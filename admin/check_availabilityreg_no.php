<?php 
require_once("includes/config.php");
// code user email availablity
if(!empty($_POST["regnoid"])) 
{
	$regno= $_POST["regnoid"];
	$sql ="SELECT StudentId FROM tblstudents WHERE StudentId=:regno";
$query= $dbh -> prepare($sql);
$query-> bindParam(':regno', $regno, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Reg_No already exists .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> Reg_No available for Registration .</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
?>
