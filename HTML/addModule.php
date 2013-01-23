<?php
	/*Add Module Handler*/
	include("db.php");
	
	if( isset($_POST["json"]) ){
		$module = $_POST["json"];
		
		$module =   json_decode($module,true) ;
		$module = convertToProper($module);
	
		switch ($module['moduleType']) {
			case "Feed":
				//add module
				$addModule  = mysql_query("INSERT INTO `ig`.`newsfeed` (`id`, `feedName`, `feedUrl`, `numArticles`) VALUES (NULL, '".$module['feedName']."', '".$module['feedURL']."', '".$module['feedCount']."');");
				$moduleType = 1;
				
			break;
			case "setWeather":			
			case "localWeather":
				if($module['moduleType'] == "localWeather"){
					$addModule  = mysql_query("INSERT INTO  `ig`.`weather` (`moduleId` ,`GeoCode`)VALUES ('',  'local');");
					$moduleType = 2;
				}else{
					$addModule  = mysql_query("INSERT INTO  `ig`.`weather` (`moduleId` ,`GeoCode`)VALUES ('',  'local');"); //update
					$moduleType = 3;
				}

			break;
		}
		
		//get id of new module
		if( $addModule ){
			$id = mysql_insert_id();
			if( isset($id) ){
				$linkModule = mysql_query("INSERT INTO `ig`.`modules` (`id`, `moduleType`, `parent`) VALUES ('".$id."', '".$moduleType."', '".$module['moduleParent']."');");
				if($linkModule){
					echo "Ok";
				}
			}
		}
		
	}
?>