<?php 
require_once("includes/config.php");
if(!empty($_POST["bookid"])) {
  $bookid=$_POST["bookid"];
 
    $sql ="SELECT BookName,id FROM tblbooks WHERE (identifier=:bookid) AND status='available' AND id NOT IN (SELECT BookId FROM tblissuedbookdetails WHERE RetrunStatus IN (0,2) AND BookId IS NOT NULL)";
$query= $dbh -> prepare($sql);
$query-> bindParam(':bookid', $bookid, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
  foreach ($results as $result) {?>
<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->BookName);?></option>
<b>Book Name :</b> 
<?php  
echo htmlentities($result->BookName);
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
 else{?>
  
<option class="others"> Book not available</option>
<?php
 echo "<script>$('#submit').prop('disabled',true);</script>";
}
}



?>
