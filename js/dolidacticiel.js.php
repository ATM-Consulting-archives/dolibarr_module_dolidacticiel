<?php

    require('../config.php');
    dol_include_once('/dolidacticiel/class/dolidacticiel.class.php');
    $PDOdb=new TPDOdb;
    $Tab= TDolidacticiel::getAll($PDOdb, $user);
    
?>

$(document).ready(function() {
	
	$(window).bind("load", function() {
	    <?php
	    
	        foreach($Tab as &$d) {
	            
	            if(!empty($d->tips) && !$d->currentUserAchievement) {
	               
	                echo 'var obj = $(\''.$d->tips.'\').first();
	                var offset = obj.offset();
	                if(offset && offset.top>0) {
	                    
	                    $("body").append(\'<div style="position:absolute; left:\'+(offset.left-20)+\'px; top:\'+(offset.top - 10)+\'px;" class="dolidacticielTips"><span class="code">'.$d->code.'</span><div class="content"><strong>'.$d->title.'</strong><br />'.$d->description.'</div></div>\');
	                    
	                }
	               
	                ';
	                
	            } 
	        }
	    
	    ?>
	    
	});

});
