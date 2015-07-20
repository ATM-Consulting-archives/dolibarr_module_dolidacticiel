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
    'otherstests',
    $langs->trans("Module104640Name"),
    0,
    "dolidacticiel@dolidacticiel"
);


// Setup page goes here
$form=new Form($db);
$var=false;

$TDolidacticielByATM = TDolidacticiel::getAllByATM($PDOdb, $conf);

print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("DolidacticielListOfModuleByATMTitle").'</td>';
print '<td>'.$langs->trans("DolidacticielListOfModuleByATMDescription").'</td>';
print '<td>'.$langs->trans("DolidacticielListOfModuleByATMDolistore").'</td>';
print '</tr>';

foreach ($TDolidacticielByATM as $test)
{
	if (!empty($test->module_name) && $conf->{$test->module_name}->enabled)
	{
		$alt = $langs->transnoentitiesnoconv('DolidacticielTestAvailable');
		$picto = 'statut4';
		$showLink = false;
	}
	else
	{
		$alt = $langs->transnoentitiesnoconv('DolidacticielTestUnavailable');
		$picto = 'statut5';
		$showLink = true;
	}
	
	$var=!$var;
	print '<tr class="'.($var ? 'pair' : 'impair').'">';
	print '<td>'.img_picto($alt, $picto).'&nbsp;'.$test->title.'</td>';
	print '<td>'.$test->description.'</td>';
	print '<td>'.($showLink && !empty($test->module_name) ? $langs->trans('Dolidacticiel_module_'.$test->module_name) : '-').'</td>';
	print '</tr>';
	
}


llxFooter();

$db->close();