<?php

//Micah Netz
/*
Note: cruds.php is the file in which I do my PDO prepared statement querying,
	  and connectDB.php is used for creating a PDO connection
*/

header('Content-type: application/json');
require 'cruds.php';

//Clean data function
function scrub($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

if(($_SERVER["REQUEST_METHOD"] == "GET")) {
	//Do get stuff
	$command = new CrudCommands();
	$rows = $command->ReadCommand();
	$json = json_encode($rows);
	echo $json;
}
if(($_SERVER["REQUEST_METHOD"] == "OPTIONS")) {
	//Do options stuff (Display options)
	$arr = array(
        "GET" => "Search data based on specified input parameters",
		"OPTIONS" =>"Display the available options"
    );
	echo json_encode($arr);
}
else{
	echo "Incorrect request method received.";
	http_response_code(500);
}
?>