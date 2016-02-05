<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * 	\file		admin/dolidacticiel.php
 * 	\ingroup	dolidacticiel
 * 	\brief		This file is an example module setup page
 * 				Put some comments here
 */
// Dolibarr environment
require('../config.php');

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
require_once '../lib/dolidacticiel.lib.php';
dol_include_once('/dolidacticiel/class/dolidacticiel.class.php');

// Translations
$langs->load("dolidacticiel@dolidacticiel");

// Access control
if (! $user->admin) {
    accessforbidden();
}

$PDOdb=new TPDOdb;

// Parameters
$action = GETPOST('action', 'alpha');
$dolidacticiel = new TDolidacticiel;
/*
 * Actions
 */
if($action){
	switch ($action) {
		case 'view':
			$dolidacticiel->load($PDOdb,GETPOST('id'));
			_fiche($PDOdb, $dolidacticiel, 'view');
			break;
		case 'edit':
			$dolidacticiel->load($PDOdb,GETPOST('id'));
			_fiche($PDOdb, $dolidacticiel, 'edit');
			break;
		case 'save':
			$dolidacticiel->load($PDOdb,GETPOST('id'));
			$dolidacticiel->set_values($_REQUEST);
			$dolidacticiel->save($PDOdb);
			_fiche($PDOdb, $dolidacticiel, 'view');
			break;
		case 'liste':
			_liste($PDOdb,$dolidacticiel, $action);
			break;
		
		default:
			_liste($PDOdb,$dolidacticiel, $action);
			break;
	}
}
else{
	_liste($PDOdb,$dolidacticiel, 'view');
}

llxFooter();

$db->close();

function _liste(&$PDOdb,&$dolidacticiel,$action){
	global $langs, $db, $user, $conf;
	/*
	 * View
	 */
	$page_name = "dolidacticielSetup";
	llxHeader('', $langs->trans($page_name));
	
	// Subheader
	$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
	    . $langs->trans("BackToModuleList") . '</a>';
	print_fiche_titre($langs->trans($page_name), $linkback);
	
	// Configuration header
	$head = dolidacticielAdminPrepareHead();
	dol_fiche_head($head,'create',$langs->trans("Module104640Name"),0,"dolidacticiel@dolidacticiel");
	
	$liste = new TSSRenderControler($dolidacticiel);
	
	$sql = "SELECT rowid, title, code, description, module_name
			FROM ".MAIN_DB_PREFIX."dolidacticiel";
	
	$THide = array('rowid');
	
	$form=new TFormCore($_SERVER['PHP_SELF'], 'formDolidacticiel', 'GET');
	
	$liste->liste($PDOdb, $sql, array(
		'limit'=>array(
			'nbLine'=>$conf->liste_limit
		)
		,'link'=>array(
			'title'=>'<a href="'.dol_buildpath('dolidacticiel/admin/dolidacticiel_admin.php?id=@rowid@&action=view', 2).'">@val@</a>'
		)
		,'translate'=>array()
		,'hide'=>$THide
		,'liste'=>array(
			'titre'=> $langs->trans('DolidacticielTests')
			,'image'=>img_picto('','title.png', '', 0)
			,'picto_precedent'=>img_picto('','back.png', '', 0)
			,'picto_suivant'=>img_picto('','next.png', '', 0)
			,'messageNothing'=>"Il n'y a aucun ".$langs->trans('Test')." à afficher"
			,'picto_search'=>img_picto('','search.png', '', 0)
		)
		,'title'=>array(
			'module_name'=>'Module'
			,'title'=>'Intitulé'
			,'code'=>'Code'
			,'description'=>'Desctription'
		)
		,'search'=>array(
			'module_name'=>true
			,'title'=>true
			,'code'=>true
		)
	));
	
	$form->end();
}

function _fiche(&$PDOdb,&$dolidacticiel,$action){
	global $langs, $db, $user;
	
	/*
	 * View
	 */
	$page_name = "dolidacticielSetup";
	llxHeader('', $langs->trans($page_name));
	
	// Subheader
	$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
	    . $langs->trans("BackToModuleList") . '</a>';
	print_fiche_titre($langs->trans($page_name), $linkback);
	
	// Configuration header
	$head = dolidacticielAdminPrepareHead();
	dol_fiche_head($head,'create',$langs->trans("Module104640Name"),0,"dolidacticiel@dolidacticiel");
	
	$form=new TFormCore($_SERVER['PHP_SELF'], 'formDolidacticiel', 'POST');
	$form->Set_typeaff($action);
	
	$TBS=new TTemplateTBS();
	$tpl_fiche= "dolidacticiel_admin.tpl.php";
	
	print $TBS->render('../tpl/'.$tpl_fiche
		,array()
		,array(
			'test'=>array(
				'id'=>$dolidacticiel->getId()
				,'rowid'=>$form->hidden('rowid', $dolidacticiel->getId())
				,'mainmenu'=>$form->texte('','mainmenu',$dolidacticiel->mainmenu,50)
				,'action'=>$form->texte('','mainmenu',$dolidacticiel->action,50)
				,'code'=>$form->texte('','mainmenu',$dolidacticiel->code,50)
				,'prev_code'=>$form->texte('','mainmenu',$dolidacticiel->prev_code,50)
				,'module_name'=>$form->texte('','mainmenu',$dolidacticiel->module_name,50)
				,'cond'=>$form->texte('','mainmenu',$dolidacticiel->cond,50)
				,'title'=>$form->texte('','mainmenu',$dolidacticiel->title,50)
				,'description'=>$form->texte('','mainmenu',$dolidacticiel->description,50)
				,'rights'=>$form->texte('','mainmenu',$dolidacticiel->rights,50)
				,'mainmenutips'=>$form->texte('','mainmenu',$dolidacticiel->mainmenutips,50)
				,'tips'=>$form->texte('','mainmenu',$dolidacticiel->tips,50)
			)
			,'view'=>array(
				'mode'=>$action
			)
		)
	);
	
	$form->end();
}