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
	,'tips'=>'table a[href*="/societe/soc.php?socid="]:contains("Test"):first,a.butAction[href*="/htdocs/societe/soc.php?socid="],form[name="formsoc"] input[name=zipcode]'
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
	,'tips'=>'table a[href*="/societe/soc.php?socid="]:contains("Test"):first,span#action-delete'
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
	,'tips'=>'a.vsmenu[href*="/societe/soc.php?leftmenu=customers&action=create&type=c"]'
	,'module_name'=>'societe'
));
$d->save($PDOdb);


$code = 'T5';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'mainmenu'=>'companies'
	,'code'=>$code
	,'prev_code'=>'T4'
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'COMPANY_CREATE,COMPANY_MODIFY'
	,'cond'=>'$object->fournisseur == 1'
	,'level'=>0
	,'rights'=>'$user->rights->societe->creer'
	,'mainmenutips'=>'a#mainmenua_companies'
	,'tips'=>'select#fournisseur'
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
	,'cond'=>'$object->lastname === "Dupond" && $object->firstname === "Pierre" && self::checkStaticId($PDOdb, $object, "societe", "Ciel & Terre")'
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
    ,'cond'=>'$object->ref === "P01" && $object->description === "Lorem ipsum"'
    ,'level'=>0
    ,'rights'=>'$user->rights->produit->creer'
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
    ,'cond'=>'$object->ref === "P01"'
    ,'level'=>0
    ,'rights'=>'$user->rights->produit->supprimer'
	,'mainmenutips'=>'a#mainmenua_products'
    ,'tips'=>'a:contains("P01"), span#action-delete'
	,'module_name'=>'product'
));
$d->save($PDOdb);


$code = 'P4';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
    'mainmenu'=>'products'
	,'code'=>$code
	,'prev_code'=>'P3'
    ,'title'=>$langs->trans('title'.$code)
    ,'description'=>$langs->trans('description'.$code)
    ,'action'=>'PRODUCT_CREATE,PRODUCT_MODIFY'
    ,'cond'=>'$object->label === "Vaporisateur d\'ambiance"'
    ,'level'=>0
    ,'rights'=>'$user->rights->produit->creer'
	,'mainmenutips'=>'a#mainmenua_products'
    ,'tips'=>'a.vsmenu[href*="/product/card.php?leftmenu=product&action=create&type=0"]'
	,'module_name'=>'product'
));
$d->save($PDOdb);


$code = 'P5';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
    'mainmenu'=>'products'
	,'code'=>$code
	,'prev_code'=>'P4'
    ,'title'=>$langs->trans('title'.$code)
    ,'description'=>$langs->trans('description'.$code)
    ,'action'=>'SUPPLIER_PRODUCT_BUYPRICE_UPDATE'
    ,'cond'=>'self::checkStaticId($PDOdb, $object, "product", "Vaporisateur d\'ambiance") && GETPOST("id_fourn", "int") == self::getStaticId($PDOdb, "societe", "nom", "Ciel & Terre")'
    ,'level'=>0
    ,'rights'=>'$user->rights->produit->creer'
	,'mainmenutips'=>'a#mainmenua_products'
    ,'tips'=>'a#suppliers[href*="/product/fournisseurs.php?id="]'
	,'module_name'=>'product'
));
$d->save($PDOdb);


$code = 'U1';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
    'mainmenu'=>'home'
	,'code'=>$code
	,'prev_code'=>'P2'
    ,'title'=>$langs->trans('title'.$code)
    ,'description'=>$langs->trans('description'.$code)
    ,'action'=>'USER_CREATE'
    ,'cond'=>'$object->lastname === "Dupont"'
    ,'level'=>0
    ,'rights'=>'$user->rights->user->user->creer'
	,'mainmenutips'=>'a#mainmenua_home'
    ,'tips'=>'a.vmenu[href*="/user/home.php?leftmenu=users"]'
	,'module_name'=>'user'
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
	,'prev_code'=>'P1'
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'TINVENTORY_CREATE'
	,'cond'=>'$object->title === "'.$langs->trans('DolidacticielTitleInventoryForTest').'" && $conf->stock->enabled'
	,'level'=>0
	,'rights'=>'$user->rights->inventory->create'
	,'mainmenutips'=>'a#mainmenua_products'
	,'tips'=>'a.vsmenu[href*="/inventory/inventory.php?action=create"]'
	,'from_atm'=>1
	,'module_name'=>'inventory'
));
$d->save($PDOdb);

$code = 'INV2';
$d=new TDolidacticiel;
$d->loadBy($PDOdb, $code, 'code');
$d->set_values(array(
	'mainmenu'=>'products'
	,'code'=>$code
	,'prev_code'=>'INV1'
	,'title'=>$langs->trans('title'.$code)
	,'description'=>$langs->trans('description'.$code)
	,'action'=>'TINVENTORY_UPDATE'
	,'cond'=>'$object->title === "'.$langs->trans('DolidacticielTitleInventoryForTest').'" && count($object->TInventorydet) > 0'
	,'level'=>0
	,'rights'=>'$user->rights->inventory->write && $conf->stock->enabled'
	,'mainmenutips'=>'a#mainmenua_products'
	,'tips'=>'a.vsmenu[href*="/inventory/inventory.php?action=list"]'
	,'from_atm'=>1
	,'module_name'=>'inventory'
));
$d->save($PDOdb);
