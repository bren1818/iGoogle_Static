<?php
	/*Add Column Handler*/
	include("db.php");
	if( isset($_POST["json"]) ){
		if( $_POST["json"]["add"] == "column" && isset($_POST["json"]["order"]) ){
			$order = $_POST["json"]["order"];
			$title = $_POST["json"]["title"];
			//echo "Add Column at position: ".$order;
			$addColumn = mysql_query("INSERT INTO  `ig`.`columnblocks` (`id` ,`Name` ,`order`)VALUES (NULL ,  '".$title."',  '".$order."');");
			if( $addColumn ){
				echo "Ok";
			}
		}
	}

?>