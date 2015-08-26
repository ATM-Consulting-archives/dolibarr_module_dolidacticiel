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
	'mainmenu'=>'companies'
	,'code'=>$code
	,'prev_code'=>''
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'COMPANY_CREATE'
	,'cond'=>'$object->name === "Test"'
	,'level'=>0
	,'rights'=>'$user->rights->societe->creer'
	,'mainmenutips'=>'a#mainmenua_companies'
	,'tips'=>'a.vsmenu[href*="/societe/soc.php?action=create"]'
	,'module_name'=>'societe'
));
$d->save($PDOdb);

$code = 'T2';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'mainmenu'=>'companies'
	,'code'=>$code
	,'prev_code'=>'T1'
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'COMPANY_MODIFY'
	,'cond'=>'$object->zip != $object->oldcopy->zip'
	,'level'=>0
	,'rights'=>'$user->rights->societe->creer'
	,'mainmenutips'=>'a#mainmenua_companies'
	,'tips'=>'table a[href*="/htdocs/societe/soc.php?socid="]:contains("Test"):first,a.butAction[href*="/htdocs/societe/soc.php?socid="],form[name="formsoc"] input[name=zipcode]'
	,'module_name'=>'societe'
));
$d->save($PDOdb);


$code = 'T3';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'mainmenu'=>'companies'
	,'code'=>$code
	,'prev_code'=>'T2'
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'COMPANY_DELETE'
	,'cond'=>'$object->name === "Test"'
	,'level'=>0
	,'rights'=>'$user->rights->societe->supprimer'
	,'mainmenutips'=>'a#mainmenua_companies'
	,'tips'=>'table a[href*="/htdocs/societe/soc.php?socid="]:contains("Test"):first,span#action-delete'
	,'module_name'=>'societe'
	
));
$d->save($PDOdb);

$code = 'T4';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'mainmenu'=>'companies'
	,'code'=>$code
	,'prev_code'=>'T3'
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'COMPANY_CREATE'
	,'cond'=>'$object->name === "Ciel & Terre"'
	,'level'=>0
	,'rights'=>'$user->rights->societe->creer'
	,'mainmenutips'=>'a#mainmenua_companies'
	,'tips'=>'a.vsmenu[href*="/societe/soc.php?action=create"]'
	,'module_name'=>'societe'
));
$d->save($PDOdb);

$code = 'C1';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'mainmenu'=>'companies'
	,'code'=>$code
	,'prev_code'=>'T4'
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'CONTACT_CREATE,CONTACT_MODIFY'
	,'cond'=>'$object->lastname === "Dupond" && $object->firstname === "Pierre" && self::checkSocId($PDOdb, $object, "Ciel & Terre")'
	,'level'=>0
	,'rights'=>'$user->rights->societe->creer'
	,'mainmenutips'=>'a#mainmenua_companies'
	,'tips'=>'a.vsmenu[href*="/contact/card.php?leftmenu=contacts&action=create"]'
	,'module_name'=>'societe'
));
$d->save($PDOdb);

$code = 'P1';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
    'mainmenu'=>'products'
	,'code'=>$code
	,'prev_code'=>''
    ,'title'=>$langs->trans('title'.$code)
    ,'description'=>$langs->trans('description'.$code)
    ,'action'=>'PRODUCT_CREATE'
    ,'cond'=>'$object->ref === "P01"'
    ,'level'=>0
    ,'rights'=>'$user->rights->produit->creer'
	,'mainmenutips'=>'a#mainmenua_products'
    ,'tips'=>'a.vsmenu[href*="/product/card.php?leftmenu=product&action=create&type=0"]'
	,'module_name'=>'product'
));
$d->save($PDOdb);


$code = 'P2';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
    'mainmenu'=>'products'
	,'code'=>$code
	,'prev_code'=>'P1'
    ,'title'=>$langs->trans('title'.$code)
    ,'description'=>$langs->trans('description'.$code)
    ,'action'=>'PRODUCT_MODIFY'
    ,'cond'=>'$object->ref === "P01"'
    ,'level'=>0
    ,'rights'=>'$user->rights->produit->supprimer'
	,'mainmenutips'=>'a#mainmenua_products'
    ,'tips'=>'a:contains("P01"), a:contains("'.$langs->trans('Modify').'")'
	,'module_name'=>'product'
));
$d->save($PDOdb);


$code = 'P3';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
    'mainmenu'=>'products'
	,'code'=>$code
	,'prev_code'=>'P2'
    ,'title'=>$langs->trans('title'.$code)
    ,'description'=>$langs->trans('description'.$code)
    ,'action'=>'PRODUCT_DELETE'
    ,'cond'=>'$object->description === "Lorem ipsum"'
    ,'level'=>0
    ,'rights'=>'$user->rights->produit->creer'
	,'mainmenutips'=>'a#mainmenua_products'
    ,'tips'=>'a:contains("P01"), span#action-delete)'
	,'module_name'=>'product'
));
$d->save($PDOdb);


$code = 'PJ1';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
    'mainmenu'=>'project'
	,'code'=>$code
	,'prev_code'=>''
    ,'title'=>$langs->trans('title'.$code)
    ,'description'=>$langs->trans('description'.$code)
    ,'action'=>'PROJECT_CREATE'
    ,'cond'=>''
    ,'level'=>0
    ,'rights'=>'$user->rights->projet->creer'
	,'mainmenutips'=>'a#mainmenua_project'
    ,'tips'=>'a.vsmenu[href*="/projet/card.php?leftmenu=projects&action=create"]'
	,'module_name'=>'projet'
));
$d->save($PDOdb);


$code = 'INV1';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'mainmenu'=>'products'
	,'code'=>$code
	,'prev_code'=>''
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'ABRICOT_SAVE'
	,'cond'=>'$this->title === "'.$langs->trans('DolidacticielTitleInventoryForTest').'"'
	,'level'=>0
	,'rights'=>'$user->rights->inventory->create && $conf->stock->enabled'
	,'mainmenutips'=>'a#mainmenua_products'
	,'tips'=>'table a[href*="/htdocs/custom/inventory/inventory.php?action=create"],#confirmCreate input[name="title"]'
	,'from_atm'=>1
	,'module_name'=>'inventory'
	
));
$d->save($PDOdb);
