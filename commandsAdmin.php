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
/*if(($_SERVER["REQUEST_METHOD"] == "GET")){
	if(isset($_GET['name']) && isset($_GET['order']) && isset($_S['suborder']) && isset($_GET['when']) && isset($_GET['where']) && isset($_GET['food']) && isset($_GET['keyword')){
	try{
			//Retrieve and scrub input
			$name = scrub($_GET['name']);
			$order = scrub($_GET['order']);
			$suborder = scrub($_GET['suborder']);
			$when = scrub($_GET['when']);
			$where = scrub($_GET['where']);
			$food = scrub($_GET['food']);
			$keyword = scrub($_GET['keyword']);
			$command = new CrudCommands();
			if($keyword == "Name"){
				$command->SearchCommand($name, $keyword);
			}
			elseif($keyword == "Order"){
				$command->SearchCommand($order, $keyword);
			}
			elseif($keyword == "Suborder"){
				$command->SearchCommand($suborder, $keyword);
			}
			elseif($keyword == "When"){
				$command->SearchCommand($when, $keyword);
			}
			elseif($keyword == "Where"){
				$command->SearchCommand($where, $keyword);
			}
			elseif($keyword == "Food"){
				$command->SearchCommand($food, $keyword);
			}
			else{
				
			}
		}catch(Exception $e){
				http_response_code(500);
				echo "error" . $e; //<--This will need to be removed when publishing live, but helpful for testing
				die("Data Entry Error");
		}
	}
}
*/
elseif(($_SERVER["REQUEST_METHOD"] == "POST")) {
	//Do post stuff (Add)
	//$name, $order, $suborder, $when, $where, $food
	if(isset($_POST['name']) && isset($_POST['order']) && isset($_POST['suborder']) && isset($_POST['when']) && isset($_POST['where']) && isset($_POST['food'])){
	try{
			//Retrieve and scrub input
			$name = scrub($_POST['name']);
			$order = scrub($_POST['order']);
			$suborder = scrub($_POST['suborder']);
			$when = scrub($_POST['when']);
			$where = scrub($_POST['where']);
			$food = scrub($_POST['food']);
 
			$command = new CrudCommands(); 
			$command->CreateCommand($name, $order, $suborder, $when, $where, $food);
		}catch(Exception $e){
				http_response_code(500);
				echo "error" . $e; //<--This will need to be removed when publishing live, but helpful for testing
				die("Data Entry Error");
		}
	}
	else{
		echo "POST variables aren't set.";
		http_response_code(500);
	}
}
elseif(($_SERVER["REQUEST_METHOD"] == "PUT")) {
	//Do put stuff (Update)
	//$name, $order, $suborder, $when, $where, $food, $id
	if(isset($_PUT['id']) && isset($_PUT['name'])  && isset($_PUT['order']) && isset($_PUT['suborder']) && isset($_PUT['when']) && isset($_PUT['where']) && isset($_PUT['food'])){
		try{
			//Retrieve and scrub input
			$id = scrub($_PUT['id']);		
			$name = scrub($_PUT['name']);
			$order = scrub($_PUT['order']);
			$suborder = scrub($_PUT['suborder']);
			$when = scrub($_PUT['when']);
			$where = scrub($_PUT['where']);
			$food = scrub($_PUT['food']);
 
			$command = new CrudCommands(); 
			$command->UpdateCommand($name, $order, $suborder, $when, $where, $food, $id);
			
		}catch(Exception $e){
			http_response_code(500);
			echo "error" . $e; //<--This will need to be removed when publishing live, but helpful for testing
			die("Data Entry Error");
		}
	}
	else{
		echo "PUT variables aren't set.";
		http_response_code(500);
	}
	
}
elseif(($_SERVER["REQUEST_METHOD"] == "DELETE")) {
	//Do delete stuff (Delete)
	if(isset($_DELETE['id']) && isset($_DELETE['id']) != ""){
		try{
			//Retrieve and scrub id
			$id = scrub($_DELETE['id']);
			$command = new CrudCommands();
			$command->DeleteCommand($id);
		}catch(Exception $e){
			http_response_code(500);
			echo "error" . $e; //<--This will need to be removed when publishing live, but helpful for testing
			die("Data Entry Error");
		}	
	}
	else{
		echo "DELETE variables aren't set.";
		http_response_code(500);
	}
}
elseif(($_SERVER["REQUEST_METHOD"] == "OPTIONS")) {
	//Do options stuff (Display options)
	$arr = array(
        "GET" => "Search data based on specified input parameters",
        "POST" => "Add data",
		"PUT" => "Updata data",
		"DELETE" => "Delete data",
		"OPTIONS" =>"Display the available options"
    );
	echo json_encode($arr);
}
else{
	echo "Incorrect request method received.";
	http_response_code(500);
}
?>