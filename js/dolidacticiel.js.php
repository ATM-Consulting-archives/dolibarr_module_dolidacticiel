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
		
		var TTipsOffSet = new Array();
		var xy = 0;
		
	    <?php
	    
	        foreach ($Tab as &$test) 
	        {
	            //echo "console.log('".$test->mainmenu." ".$test->code." p".$test->prev_code." ".(int)$test->currentUserAchievement." ".(int)$test->prevCodeAchievement($PDOdb, $user)."');";
	            if (!empty($test->tips) && !$test->currentUserAchievement && $test->prevCodeAchievement($PDOdb, $user)) 
	            {
	                echo 'var obj = $(\''.($mainmenu == $test->mainmenu ? $test->tips : $test->mainmenutips).'\');
						
						for (var i = 0; i < obj.length; i++)
						{
							xy++;
							
							var offset = $(obj[i]).offset();
							var left = offset.left-20;
							var top = offset.top - 10;
							var positionFound = false;
							
							//Check si un Tips chevauffe un autre
							for (var j in TTipsOffSet)
						    {
						    	if (TTipsOffSet[j].left == left && TTipsOffSet[j].top == top)
						    	{
						    		TTipsOffSet[j].ids.push("tips_"+xy);
									positionFound = true;
									break;
						    	}
						    }
							
							if (!positionFound) TTipsOffSet.push({"left":left,"top":top,"ids":new Array("tips_"+xy)});
							
			                if(offset && top>0) {
			                    $("body").append(\'<div id="tips_\'+xy+\'" style="position:absolute; left:\'+(left)+\'px; top:\'+(top)+\'px;" class="dolidacticielTips '.($mainmenu == $test->mainmenu ? '' : 'tipTopMenu').'"><span class="code">'.$test->code.'</span><div class="content"><strong>'.$test->title.'</strong><br />'.$test->description.'</div></div>\');   
			                }
						}
		                
	                ';
	                
	            }
	        }
	    
	    ?>
	    
	    for (var i = 0; i < TTipsOffSet.length; i++)
	    {
	    	if (TTipsOffSet[i].ids.length > 1) //uniquement les tableaux de tips avec + de 1 element superposé
	    	{
	    		var masterTips = $("<div class='masterTips' style='position:absolute; left:"+TTipsOffSet[i].left+"px;top:"+TTipsOffSet[i].top+"px;'></div>");
	    		var currentTop = 0;
	    		
	    		for (var j = 0; j < TTipsOffSet[i].ids.length; j++)
	    		{
	    			var clone = $("#"+TTipsOffSet[i].ids[j]).clone();
	    			clone.css("left", 0).css("top", currentTop);
	    			
	    			$("#"+TTipsOffSet[i].ids[j]).remove();
	    			
	    			masterTips.append(clone);
	    			
	    			currentTop += 30;
	    		}
	    		
	    		$("body").append(masterTips);
	    	}
	    }
	 
	});

});
