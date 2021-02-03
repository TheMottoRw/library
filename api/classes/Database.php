<?php
class Database{
	public $conn="";
	public function connection(){
try{
	$this->conn=new PDO("mysql:host=localhost;dbname=library","super","");
//		echo "Database connected";
}catch(PDOException $ex){
	echo json_encode(['error'=>" Could not connect to Database",'trace'=>$ex->getMessage()]);
}

        return $this->conn;
	}
	public function  getInstance(){
	    return $this->connection();
    }
}
$conn = new Database();
$conn->getInstance();
?>