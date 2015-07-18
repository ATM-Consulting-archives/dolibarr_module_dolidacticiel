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
    'ggwp',
    $langs->trans("Module104640Name"),
    0,
    "dolidacticiel@dolidacticiel"
);


// Setup page goes here
$form=new Form($db);
$var=false;

$TDolidacticielByUser = TDolidacticiel::getAllUser($PDOdb, $db, $conf);

print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("DolidacticielListOfUserAchievement").'</td>';

foreach ($TDolidacticielByUser as $row)
{
	$u = $row['user'];
	$TDolidacticiel = $row['dolidacticiel'];
	
	
	$var=!$var;
	print '<tr class="'.($var ? 'pair' : 'impair').'">';
	print '<td>'.$u->getNomUrl(1).'</td>';
	
	if (count($TDolidacticiel) > 0)
	{
		foreach ($TDolidacticiel as $dacticiel)
		{
			if ($dacticiel->currentUserAchievement > 0) $picto = img_picto($langs->transnoentitiesnoconv('DolidacticielCheck'), 'statut4');
			elseif ($dacticiel->currentUserAchievement == 0) $picto = img_picto($langs->transnoentitiesnoconv('DolidacticielUncheck'), 'statut8');
			else $picto = img_picto($langs->transnoentitiesnoconv('DolidacticielNotAutorized'), 'statut5');
			
			$var=!$var;
			print '<tr class="'.($var ? 'pair' : 'impair').'">';
			print '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.$picto.'&nbsp;'.$dacticiel->description.'</td>';
		}	
	}
	else
	{
		$var=!$var;
		print '<tr class="'.($var ? 'pair' : 'impair').'">';
		print '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.img_picto('', '1rightarrow').'&nbsp;<em>'.$langs->trans('DolidacticielNoTestAvailable').'</em></td>';
	}
	
}

/*print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td>'.$langs->trans("Parameters").'</td>'."\n";
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="center" width="100">'.$langs->trans("Value").'</td>'."\n";


// Example with a yes / no select
$var=!$var;
/*print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("ParamLabel").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
print '<input type="hidden" name="action" value="set_CONSTNAME">';
print $form->selectyesno("CONSTNAME",$conf->global->CONSTNAME,1);
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</form>';
print '</td></tr>';

print '</table>';
*/

/*
	$TAbsenceType = TRH_TypeAbsence::getList($PDOdb);
	$absenceTypeDummy = new TRH_TypeAbsence;
	$form=new TFormCore($_SERVER['PHP_SELF'],'form1','POST');
	$form->Set_typeaff('edit');
	echo $form->hidden('action', 'save');
	$TFormAbsenceType=array();
	foreach($TAbsenceType as $absenceType) {
		
		$TFormAbsenceType[]=array(
			'typeAbsence'=>$form->texte('', 'TDolidacticiel['.$absenceType->getId().'][typeAbsence]', $absenceType->typeAbsence, 15,50)
			,'libelleAbsence'=>$form->texte('', 'TDolidacticiel['.$absenceType->getId().'][libelleAbsence]', $absenceType->libelleAbsence, 30,255)
			,'codeAbsence'=>$form->texte('', 'TDolidacticiel['.$absenceType->getId().'][codeAbsence]', $absenceType->codeAbsence, 6,10)
			
			,'colorId'=>$form->combo('', 'TDolidacticiel['.$absenceType->getId().'][colorId]', $absenceTypeDummy->TColorId , $absenceType->colorId)
			
			,'unite'=>$form->combo('', 'TDolidacticiel['.$absenceType->getId().'][unite]', $absenceTypeDummy->TUnite , $absenceType->unite)
			,'decompteNormal'=>$form->combo('', 'TDolidacticiel['.$absenceType->getId().'][decompteNormal]', $absenceTypeDummy->TDecompteNormal , $absenceType->decompteNormal)
            ,'secable'=>$form->combo('', 'TDolidacticiel['.$absenceType->getId().'][insecable]', $absenceTypeDummy->TForAdmin , $absenceType->insecable)
            ,'isPresence'=>$form->hidden( 'TDolidacticiel['.$absenceType->getId().'][isPresence]', 0)
			,'admin'=>$form->combo('', 'TDolidacticiel['.$absenceType->getId().'][admin]', $absenceTypeDummy->TForAdmin , $absenceType->admin)
			
			,'delete'=>$form->checkbox1('', 'TDolidacticiel['.$absenceType->getId().'][delete]', 1)
		);
		
	}
	$TFormAbsenceTypeNew=array(
			'typeAbsence'=>$form->texte('', 'TDolidacticielNew[typeAbsence]', '', 15,50)
			,'libelleAbsence'=>$form->texte('', 'TDolidacticielNew[libelleAbsence]', '', 30,255)
			,'codeAbsence'=>$form->texte('', 'TDolidacticielNew[codeAbsence]', '', 6,10)
			
			,'unite'=>$form->combo('', 'TDolidacticielNew[unite]', $absenceTypeDummy->TUnite , null)
			,'decompteNormal'=>$form->combo('', 'TDolidacticielNew[decompteNormal]', $absenceTypeDummy->TDecompteNormal , null)
			,'isPresence'=>$form->hidden( 'TDolidacticielNew[isPresence]', 0)
			,'admin'=>$form->combo('', 'TDolidacticielNew[admin]', $absenceTypeDummy->TForAdmin , null)
			
			,'colorId'=>$form->combo('', 'TDolidacticielNew[colorId]', $absenceTypeDummy->TColorId , null)
		);
	$TBS=new TTemplateTBS();
	print $TBS->render('./tpl/typeAbsence.tpl.php'
		,array(
			'typeAbsence'=>$TFormAbsenceType
		)
		,array(
			'typeAbsenceNew'=>$TFormAbsenceTypeNew
			,'view'=>array(
				'head'=>dol_get_fiche_head(adminCongesPrepareHead('compteur')  , 'typeabsence', $langs->trans('AbsencesPresencesAdministration'))
			)
			,'translate' => array(
				'Code' => $langs->trans('Code'),
				'Wording' => $langs->trans('Wording'),
				'Unit' => $langs->trans('Unit'),
				'AccountingOfficerCode' => $langs->trans('AccountingOfficerCode'),
				'AbsenceSecable' => $langs->trans('AbsenceSecable'),
				'ColorCode' => $langs->trans('ColorCode'),
				'AskReservedAdmin' => $langs->trans('AskReservedAdmin'),
				'OnlyCountBusinessDay' => $langs->trans('OnlyCountBusinessDay'),
				'New' => $langs->trans('New'),
				'Register' => $langs->trans('Register'),
				'AskDelete' => $langs->trans('AskDelete')
			)
		)	
		
	);
	
	echo $form->end_form();	
	
*/
llxFooter();

$db->close();