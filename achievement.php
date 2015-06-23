<?php

	require('config.php');
	dol_include_once('/dolidacticiel/class/dolidacticiel.class.php');
	
	$id = GETPOST('id');
	
	$u=new User($db);
	$u->fetch($id);
	$u->getrights();

	if($u->id<=0)exit('ErrorUser');
	
	llxHeader();
	
	$PDOdb = new TPDOdb;
	
	$Tab= TDolidacticiel::getAll($PDOdb, $u);
	
	print '<table>';
	foreach($Tab as &$d) {
		
		print '<tr><td>'.$d->title.'</td><td>'.($d->currentUserAchievement ? 'Fait' : 'Non Fait').'</td></tr>';
		
	}
	
	print '</table>';
	llxFooter();