<?php

//Micah Netz
/*
Note: cruds.php is the file in which I do my PDO prepared statement querying,
	  and connectDB.php is used for creating a PDO connection
*/

header('Content-type: application/json');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Access-Control-Allow-Origin: *');
require 'cruds.php';

//Clean data function
function scrub($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}
/* This method is used to read ALL entries
if(($_SERVER["REQUEST_METHOD"] == "GET")) {
	//Do get stuff
	$command = new CrudCommands();
	$rows = $command->ReadCommand();
	$json = json_encode($rows);
	echo $json;
}
*/
/* This method is used to search SPECIFIC entries */
if(($_SERVER["REQUEST_METHOD"] == "GET")){
	try{
			$command = new CrudCommands();
			if(isset($_GET['name']) || isset($_GET['order']) || isset($_GET['suborder']) || isset($_GET['when']) || isset($_GET['where']) || isset($_GET['food'])){
				$name = scrub($_GET['name']);
				$order = scrub($_GET['order']);
				$suborder = scrub($_GET['suborder']);
				$when = scrub($_GET['when']);
				$where = scrub($_GET['where']);
				$food = scrub($_GET['food']);
				$keyword = scrub($_GET['keyword']);
				if($keyword == "Name"){
					$rows = $command->SearchCommand($name, $keyword);
				}
				elseif($keyword == "Order"){
					$rows = $command->SearchCommand($order, $keyword);
				}
				elseif($keyword == "Suborder"){
					$rows = $command->SearchCommand($suborder, $keyword);
				}
				elseif($keyword == "When"){
					$rows = $command->SearchCommand($when, $keyword);
				}
				elseif($keyword == "Where"){
					$rows = $command->SearchCommand($where, $keyword);
				}
				elseif($keyword == "Food"){
					$rows = $command->SearchCommand($food, $keyword);
				}
				else{
					$rows = $command->ReadCommand();
				}
			}
			else{
				$rows = $command->ReadCommand();
			}
			$json = json_encode($rows);
			echo $json;
		}catch(Exception $e){
				http_response_code(500);
				echo "Name not found error" . $e; //<--This will need to be removed when publishing live, but helpful for testing
				die("Data Entry Error");
		}
	
}
/**/

/**/
elseif(($_SERVER["REQUEST_METHOD"] == "POST")) {
	//Do post stuff (Add)
	//$name, $order, $suborder, $when, $where, $food
	if(isset($_GET['name']) || isset($_GET['order']) || isset($_GET['suborder']) || isset($_GET['when']) || isset($_GET['where']) || isset($_GET['food'])){
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
	if(isset($_REQUEST['id']) && isset($_REQUEST['name'])  && isset($_REQUEST['order']) && isset($_REQUEST['suborder']) && isset($_REQUEST['when']) && isset($_REQUEST['where']) && isset($_REQUEST['food'])){
		try{
			//Retrieve and scrub input
			$id = scrub($_REQUEST['id']);		
			$name = scrub($_REQUEST['name']);
			$order = scrub($_REQUEST['order']);
			$suborder = scrub($_REQUEST['suborder']);
			$when = scrub($_REQUEST['when']);
			$where = scrub($_REQUEST['where']);
			$food = scrub($_REQUEST['food']);
 
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
	$id = $_REQUEST['id'];
	$command = new CrudCommands();
	$command->DeleteCommand($id);
}
/**/

elseif(($_SERVER["REQUEST_METHOD"] == "OPTIONS")) {
	//Do options stuff (Display options)
	$arr = array(
        "GET" => "Search data based on specified input parameters",
        "POST" => "Add data",
		"PUT" => "Update data",
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