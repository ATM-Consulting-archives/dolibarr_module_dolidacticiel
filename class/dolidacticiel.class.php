<?php

class TDolidacticiel extends TObjetStd {
/*
 * Gestion des équipements 
 * */
    
    static $level=array(
		0=>'Normal'
		,1=>'Supérieur'
		,2=>'Expert'
	);
    
    function __construct() {
        $this->set_table(MAIN_DB_PREFIX.'dolidacticiel');

        $this->add_champs('action,code', array('type'=>'string', 'index'=>true, 'length'=>100)  );
        $this->add_champs('cond', array('type'=>'text'));
        $this->add_champs('level',array('type'=>'int', 'index'=>true, 'rules'=>array('min'=>0, 'max'=>2)));
        
        $this->_init_vars('title,description,rights');
        
	    $this->start();
	
		$this->setChild('TDolidacticielUser', 'fk_dolidacticiel');
		
    }

	static function getLevelFromUser(&$user) {
		return 2;
	}	
	
	static function getAll(&$PDOdb,&$user, $withAchievement=true) {
		$level = self::getLevelFromUser($user);
		
		$TRes = $PDOdb->ExecuteAsArray("SELECT d.rowid 
					FROM ".MAIN_DB_PREFIX."dolidacticiel d 
					LEFT JOIN ".MAIN_DB_PREFIX."dolidacticiel_user du ON (du.fk_dolidacticiel = d.rowid)
					WHERE d.level<=".$level." ");
		$Tab=array();					
		foreach($TRes as $row) {
			
			$d = new TDolidacticiel;
			$d->load($PDOdb, $row->rowid);
			
			$rights = !empty($d->rights) ? eval('return ('.$d->rights.' == 1);') : true;
			
			if($rights === true) {
				
				if($withAchievement) $d->currentUserAchievement = $d->getUserAchievement($user->id);
				
				$Tab[] = $d;	
			}
			
		}	
		
		return $Tab;
		
		
	}
	
	static function testConditions(&$PDOdb,&$user,&$object, $action) {
		
		$level = self::getLevelFromUser($user);
		
		$TRes = $PDOdb->ExecuteAsArray("SELECT d.rowid 
					FROM ".MAIN_DB_PREFIX."dolidacticiel d 
					LEFT JOIN ".MAIN_DB_PREFIX."dolidacticiel_user du ON (du.fk_dolidacticiel = d.rowid AND du.fk_user=".$user->id.")
					WHERE d.action  = '".$action."' AND d.level<=".$level." AND du.achievement IS NULL");
					
		foreach($TRes as $row) {
			
			$d = new TDolidacticiel;
			$d->load($PDOdb, $row->rowid);
			
			$rights = !empty($d->rights) ? eval('return ('.$d->rights.' == 1);') : true;
			$eval = !empty($d->cond) ? eval('return ('.$d->cond.');') : true;
			
			if($eval === true && $rights === true) {
				$k = $d->addChild($PDOdb, 'TDolidacticielUser');
				//var_dump($d->TDolidacticielUser);
				$d->TDolidacticielUser[$k]->fk_user = $user->id;
				$d->TDolidacticielUser[$k]->achievement=1;
				$d->save($PDOdb);
				
				setEventMessage('GG WP'.$d->code.' : '.$d->title."\n".$d->description);
				
			}
			
		}	
		
	}
	function getUserAchievement($fk_user) {
		
		foreach($this->TDolidacticielUser as &$ddu) {
			
			if($ddu->fk_user == $fk_user) {
				return true;
			}
			
		}
		
		return false;
	}
}

Class TDolidacticielUser extends TObjetStd {
    function __construct() {
        $this->set_table(MAIN_DB_PREFIX.'dolidacticiel_user');
        $this->add_champs('fk_dolidacticiel,fk_user',array('type'=>'int', 'index'=>true));
        $this->add_champs('achievement',array('type'=>'int', 'rules'=>array('in'=>array(0,1))));
        
        $this->_init_vars();
        
        $this->start();
    }
	
}
