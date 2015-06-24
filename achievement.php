<?php

	require('config.php');
	dol_include_once('/dolidacticiel/class/dolidacticiel.class.php');
	dol_include_once('/core/lib/usergroups.lib.php');
	$id = GETPOST('id');
	
	$u=new User($db);
	$u->fetch($id);
	$u->getrights();

	if($u->id<=0)exit('ErrorUser');
	
	llxHeader();
	
    $head = user_prepare_head($object);

    $title = $langs->trans("Achievements");
    dol_fiche_head($head, 'user', $title, 0, 'achievement');
    
	$PDOdb = new TPDOdb;
	
	$Tab= TDolidacticiel::getAll($PDOdb, $u);
	
	print '<table>';
	foreach($Tab as &$d) {
		
		print '<tr><td>'.$d->title.'</td><td>'.($d->currentUserAchievement ? img_picto('Ok', 'redstar') : 'Non Fait').'</td></tr>';
		
	}
	
	print '</table>';
    
    dol_fiche_end();
    
	llxFooter();