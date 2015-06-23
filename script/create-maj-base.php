<?php
/*
 * Script créant et vérifiant que les champs requis s'ajoutent bien
 */

if(!defined('INC_FROM_DOLIBARR')) {
	define('INC_FROM_CRON_SCRIPT', true);

	require('../config.php');

}



dol_include_once('/dolidacticiel/class/dolidacticiel.class.php');

$PDOdb=new TPDOdb;

$d=new TDolidacticiel;
$d->init_db_by_vars($PDOdb);

$o=new TDolidacticielUser;
$o->init_db_by_vars($PDOdb);


/*
 * Init du didacticiel
 */
$langs->load("dolidacticiel@dolidacticiel");
  
 
$code = 'T1';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'code'=>$code
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'COMPANY_CREATE'
	,'cond'=>'$object->name === "Test"'
	,'level'=>0
	,'rights'=>'$user->rights->societe->creer'
	
));
$d->save($PDOdb);

$code = 'T2';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'code'=>$code
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'COMPANY_MODIFY'
	,'cond'=>'$object->zip != $object->oldcopy->zip'
	,'level'=>0
	,'rights'=>'$user->rights->societe->creer'
));
$d->save($PDOdb);


$code = 'T3';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'code'=>$code
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'COMPANY_DELETE'
	,'cond'=>'$object->name === "Test"'
	,'level'=>0
	,'rights'=>'$user->rights->societe->creer'
));
$d->save($PDOdb);



