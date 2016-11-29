<?php

//Micah Netz
/*
Note: cruds.php is the file in which I do my PDO prepared statement querying,
	  and connectDB.php is used for creating a PDO connection
*/

header('Content-type: application/json');
require 'cruds.php';
if(($_SERVER["REQUEST_METHOD"] == "GET")) {
	//Do get stuff
}
if(($_SERVER["REQUEST_METHOD"] == "POST")) {
	//Do post stuff
}
if(($_SERVER["REQUEST_METHOD"] == "PUT")) {
	//Do put stuff
}
if(($_SERVER["REQUEST_METHOD"] == "DELETE")) {
	//Do delete stuff
}
if(($_SERVER["REQUEST_METHOD"] == "OPTIONS")) {
	//Do options stuff
}
?>