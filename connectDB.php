<?php

//Micah Netz
/*
Note: cruds.php is the file in which I do my PDO prepared statement querying,
	  and connectDB.php is used for creating a PDO connection
*/

/* The following lines are for setting up the db connection to the local host: 
define('host', 'localhost');
define('user', 'root');
define('pass', '');
define('db', 'dinosaurs');
define('charset', 'utf8');
/**/
/*	The following lines are for setting up the db connection for the web hosting service: */
//Use the below technique
define('host', 'localhost');
define('user', 'micahnet');
define('pass', 'Mkn.1523');
define('db', 'micahnet_dinosaurs');
define('charset', 'utf8');
/**/
 
function DatabaseConnection()
{
    
	try{
		static $conn;
		$settings = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => FALSE,
		);
		$userInfo = 'mysql:host=' . host . ';dbname=' . db . ';charset=' . charset;
		$conn = new PDO($userInfo, user, pass, $settings);		
		return $conn;
	}catch(PDOException $e){
		http_response_code(500);
		die("DB Error: " . $e->getMessage());
	}
    
} 
?>