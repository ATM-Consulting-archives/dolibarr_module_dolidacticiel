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

        $this->add_champs('trigger', array('type'=>'string', 'index'=>true, 'length'=>100)  );
        $this->add_champs('condition', array('type'=>'text'));
        $this->add_champs('level',array('type'=>'int', 'index'=>true, 'rules'=>array('min'=>0, 'max'=>2)));
        
        $this->_init_vars('title,description');
        
		$this->setChild('TDolidacticiel_user', 'fk_dolidacticiel');
		
        $this->start();
		
    }

	static function getLevelFromUser(&$user) {
		return 2;
	}	
	
	static function testConditions(&$PDOdb,&$user,&$object, $trigger) {
		
		$level = self::getLevelFromUser($user);
		
		$TRes = $PDOdb->ExecuteAsArray("SELECT rowid 
					FROM ".MAIN_DB_PREFIX."dolidacticiel d 
					LEFT JOIN ".MAIN_DB_PREFIX."dolidacticiel_user du ON (du.fk_dolidacticiel = d.rowid AND du.fk_user=".$user->id.")
					WHERE d.trigger='".$trigger."' AND d.level<=".$level." AND du.achievement IS NULL");
					
		foreach($TRes as $row) {
			
			$d = new TDolidacticiel;
			$d->load($PDOdb, $row->rowid);
			
			if(eval('return ('.$d->condition.')') === true) {
				
				$k = $d->addChild($PDOdb, 'TDolidacticiel_user');
				$d->TDolidacticiel_user[$k]->fk_user = $user->id;
				$d->TDolidacticiel_user[$k]->achievement=1;
				$d->save($PDOdb);
				
				setEventMessage('GG WP'.$d->title.$d->description);
				
			}
			
		}	
		
	}
}

Class TDolidacticiel_user extends TObjetStd {
    function __construct() {
        $this->set_table(MAIN_DB_PREFIX.'dolidacticiel_user');
        $this->add_champs('fk_dolidacticiel,fk_user',array('type'=>'int', 'index'=>true));
        $this->add_champs('achievement',array('type'=>'int', 'rules'=>array('in'=>array(0,1))));
        
        $this->_init_vars();
        
        $this->start();
    }
	
}
