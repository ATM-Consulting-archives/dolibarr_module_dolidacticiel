<?php

    require('../config.php');
    dol_include_once('/dolidacticiel/class/dolidacticiel.class.php');
    $PDOdb=new TPDOdb;
    $Tab= TDolidacticiel::getAll($PDOdb, $user, $conf); 
	$mainmenu = $_SESSION['mainmenu'];
    //echo "console.log(JSON.parse('".json_encode($Tab)."'));";  //équivalent d'un var_dump();
?>

$(document).ready(function() {
	
	$(window).bind("load", function() {
	    <?php
	    
	        foreach ($Tab as &$test) 
	        {
	            echo "console.log('".$test->mainmenu." ".$test->code." p".$test->prev_code." ".(int)$test->currentUserAchievement." ".(int)$test->prevCodeAchievement($PDOdb, $user)."');";
	            if (!empty($test->tips) && !$test->currentUserAchievement && $test->prevCodeAchievement($PDOdb, $user)) 
	            {
	                echo 'var obj = $(\''.($mainmenu == $test->mainmenu ? $test->tips : $test->mainmenutips).'\');
					console.log(obj.length);
						for (var i = 0; i < obj.length; i++)
						{
							var offset = $(obj[i]).offset();
			                if(offset && offset.top>0) {
			                    $("body").append(\'<div style="position:absolute; left:\'+(offset.left-20)+\'px; top:\'+(offset.top - 10)+\'px;" class="dolidacticielTips"><span class="code">'.$test->code.'</span><div class="content"><strong>'.$test->title.'</strong><br />'.$test->description.'</div></div>\');   
			                }
						}
		                
	                ';
	                
	            }
	        }
	    
	    ?>
	    
	});

});
