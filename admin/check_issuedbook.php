<?php 
require_once("includes/config.php");
// code   ISBN availablity
if(!empty($_POST["bookid"])) 
{
	$book= $_POST["bookid"];
	
		$sql ="SELECT BookId FROM tblissuedbookdetails  WHERE BookId=:bookid";
		$query= $dbh -> prepare($sql);
		$query-> bindParam(':book', $book, PDO::PARAM_STR);
		$query-> execute();
		$results = $query -> fetchAll(PDO::FETCH_OBJ);
		$cnt=1;
if($query -> rowCount() > 0)
{
	echo "<span style='color:red'>This Book is already borrowed, Please choose another! .</span>";
	 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> Allowed to be borrowed!!.</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}



?>
