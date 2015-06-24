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
	
    $head = user_prepare_head($u);

    $title = $langs->trans("Achievements");
    dol_fiche_head($head, 'achievements', $title);
    
	$PDOdb = new TPDOdb;
	
	$Tab= TDolidacticiel::getAll($PDOdb, $u);
	
	print '<table class="border" width="100%">';
	foreach($Tab as &$d) {
		
		print '<tr><td width="50%"><strong>'.$d->title.'</strong><br />'.$d->description.'</td><td>'.($d->currentUserAchievement ? img_picto('Ok', 'star') : '' ).'</td></tr>';
		
	}
	
	print '</table>';
    
    dol_fiche_end();
    
	llxFooter();