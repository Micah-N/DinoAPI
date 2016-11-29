<?php

//Micah Netz
/*
Note: cruds.php is the file in which I do my PDO prepared statement querying,
	  and connectDB.php is used for creating a PDO connection
*/

require 'connectDB.php';
 
class CrudCommands
{ 
    protected $conn;
	
    function __construct()
    {
        $this->conn = DatabaseConnection();
    }
 
    function __destruct()
    {
        $this->conn = null;
    } 
	
    public function CreateCommand($name, $order, $suborder, $when, $where, $food);
    {
        $stmt = $this->conn->prepare("INSERT INTO dinosaurs(Name, Order, Suborder, When, Where, Foood) VALUES (:name, :order, :suborder, :when, :where, :food)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":order", $order);
        $stmt->bindParam(":suborder", $suborder);
		$stmt->bindParam(":when", $when);
		$stmt->bindParam(":where", $where);
		$stmt->bindParam(":food", $food);
        $stmt->execute();
		
		/*
		name
		order
		suborder
		when
		where
		food
		
		*/
    }
 
    public function ReadCommand()
    {
        $stmt = $this->conn->prepare("SELECT * FROM dinosaurs");
        $stmt->execute();
		
        $results = array();
		
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $row;
        }
        return $results;
    }
	
	public function UpdateCommand($name, $order, $suborder, $when, $where, $food, $id)
    {
        $stmt = $this->conn->prepare("UPDATE dinosaurs SET Name = :Name, Order = :Order, Suborder = :Suborder, When = :When, Where = :where, Food = :food WHERE id = :id");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":order", $order);
        $stmt->bindParam(":suborder", $suborder);
		$stmt->bindParam(":when", $when);
		$stmt->bindParam(":where", $where);
		$stmt->bindParam(":food", $food);
		$stmt->bindParam(":id", $id);
        $stmt->execute();
    }
 
    public function DeleteCommand($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM dinosaurs WHERE id = :id");
        $stmt->bindParam("id", $id);
        $stmt->execute();
    }	
}
?>