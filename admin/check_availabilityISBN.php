<?php 
require_once("includes/config.php");
// code   ISBN availablity
if(!empty($_POST["isbnid"])) 
{
	$isbn= $_POST["isbnid"];
	
		$sql ="SELECT ISBNNumber FROM tblbooks WHERE ISBNNumber=:isbn";
		$query= $dbh -> prepare($sql);
		$query-> bindParam(':isbn', $isbn, PDO::PARAM_STR);
		$query-> execute();
		$results = $query -> fetchAll(PDO::FETCH_OBJ);
		$cnt=1;
if($query -> rowCount() > 0)
{
	echo "<span style='color:red'>ISBN is already exist! .</span>";
	 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> ISBN is allowed!!.</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}



?>
