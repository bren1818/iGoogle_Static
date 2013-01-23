<?php
	$dbHost ="localhost";
	$dbUser = "root";
	$dbPass = "usbw"; 
	$dbDatabase = "ig"; 
	$db = mysql_connect("$dbHost", "$dbUser", "$dbPass") or die ("Error connecting to database."); 
	
	mysql_select_db("$dbDatabase", $db) or die ("Couldn't select the database.");
	$mysqli = new mysqli("$dbHost", "$dbUser", "$dbPass", "$dbDatabase");
	
	if ($mysqli->connect_errno) {
   		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	if( isset($_POST["json"]) ){
		
		$json = $_POST["json"];
		
		$note = json_decode($json);
		$note = $note->{'note'};
		
		$notes  = mysql_query('UPDATE  `ig`.`note` SET  `note` =  "'.mysql_real_escape_string ( $note ).'" WHERE  `note`.`id` =1;');	
       		
        if($notes ){
			echo "Saved";
		}

	}
?>