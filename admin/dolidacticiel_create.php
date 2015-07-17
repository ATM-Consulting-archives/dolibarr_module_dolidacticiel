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
	/*
	if(isset($_REQUEST['action']) && $_REQUEST['action']=='save') {
		
		if(!empty($_REQUEST['TDolidacticiel'])) {
			foreach($_REQUEST['TDolidacticiel'] as $id=>$TValues) {
				
				$d=new TDolidacticiel;
				$d->load($PDOdb, $id);
				$d->set_values($TValues);
				
				if(isset($TValues['delete'])) {
					$d->delete($PDOdb);
				}
				else {
					$d->save($PDOdb);	
				}
			}
            
            setEventMessage($langs->trans('Saved'));
		}
		
		$newTA = & $_REQUEST['TDolidacticielNew']; 
		
		//print_r($_REQUEST['TDolidacticielNew']);
		
		if(!empty($newTA['typeAbsence']) && !empty($newTA['libelleAbsence'])) {
			
			$ta=new TRH_TypeAbsence;
			$ta->set_values($newTA);
			$ta->save($PDOdb);
		}
		
	}
	*/

// Parameters
$action = GETPOST('action', 'alpha');

/*
 * Actions
 */
if (preg_match('/set_(.*)/',$action,$reg))
{
	$code=$reg[1];
	if (dolibarr_set_const($db, $code, GETPOST($code), 'chaine', 0, '', $conf->entity) > 0)
	{
		header("Location: ".$_SERVER["PHP_SELF"]);
		exit;
	}
	else
	{
		dol_print_error($db);
	}
}
	
if (preg_match('/del_(.*)/',$action,$reg))
{
	$code=$reg[1];
	if (dolibarr_del_const($db, $code, 0) > 0)
	{
		Header("Location: ".$_SERVER["PHP_SELF"]);
		exit;
	}
	else
	{
		dol_print_error($db);
	}
}

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
dol_fiche_head(
    $head,
    'create',
    $langs->trans("Module104640Name"),
    0,
    "dolidacticiel@dolidacticiel"
);

if (GETPOST('create_test'))
{
	$test = new TDolidacticiel;
	
	$test->action = trim(GETPOST('action'));
	$test->code = trim(GETPOST('code'));
	$test->cond = trim(GETPOST('cond'));
	$test->level = trim(GETPOST('level'));
	$test->title = trim(GETPOST('title'));
	$test->description = trim(GETPOST('description'));
	$test->rights = trim(GETPOST('rights'));
	$test->tips = trim(GETPOST('tips'));
	
	if ($test->save($PDOdb))
	{
		setEventMessage("Insert ok");
	}
	else 
	{
		setEventMessage("Erreur lors du save", "errors");
	}
}

// Setup page goes here
?>

<style type="text/css">
	#create_test label {
		width:10%;
		text-align:right;
		display:inline-block;
	}
	
	#create_test input[type=text] {
		width:80%;;
	}
</style>
<form id="create_test" action="" method="POST">
	<p>
		<label>Action</label>
		<input type="text" name="action" value="" />
	</p>
	
	<p>
		<label>Code</label>
		<input type="text" name="code" value="" />
	</p>
	
	<p>
		<label>Condition</label>
		<input type="text" name="cond" value="" />
	</p>
	
	<p>
		<label>Level</label>
		<input type="text" name="level" value="" />
	</p>
	
	<p>
		<label>Titre</label>
		<input type="text" name="title" value="" />
	</p>
	
	<p>
		<label>Description</label>
		<input type="text" name="description" value="" />
	</p>
	
	<p>
		<label>Droit</label>
		<input type="text" name="rights" value="" />
	</p>
	
	<p>
		<label>Tips</label>
		<input type="text" name="tips" value="" />
	</p>
	
	<input class="button" type="submit" name="create_test" value="Créer" />
	
</form>

<?php

llxFooter();

$db->close();