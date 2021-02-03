<?php
session_start();
error_reporting(0);
include('includes/config.php');
if($_SESSION['alogin']!='')
{
$_SESSION['alogin']='';
}?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SLS|Homepage</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body bgcolor="skyblue" style="background-image: url();">
    <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<p>
    
</p>

<center>
    <div class="panel-body">
<table width="1200px" height="450px" bgcolor="white" cellpadding="" style="border-radius: 10px;">
    
    <tr>
        <td width="600px">
            <h1>Pre-Requisite</h1>
            <hr>
            <h4>This is a sysytem for you, If you need a book
                You must sign up in the system so that you get 
                a username and password that will help you to 
                login in the system. If you are already signed 
                up in the system login the start to access the 
                library service. 
                <p>
                    
                </p>

                If you need a book First check whether the book
                is available then after reserve a book you want 
                through your account. After that you come to take 
                in library.
                <p>

                </p>
                <font color="red">
                N.B: If you have borrowed a book, Remember
                to bring it back early/at time to avoid the penalities.</font>    
        </td>
      
        <td align="center" style="background-image: url();>

             
<!--LOGIN PANEL START-->           
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
<div class="panel panel-info">
<img src="admin/assets/img/3.jpg" width="750px" height="450px">
 </div>
</div>
</div>
</div> 
        </td>
    </tr>
</table></center>
<p>
    
</p>

<p>
    
</p>
 <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</script>
</body>
</html>
 <?php
if(isset($_POST['login']))
{
$username=$_POST['username'];
$password=md5($_POST['password']);
$sql ="SELECT UserName,Password FROM admin WHERE UserName=:username and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':username', $username, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
$_SESSION['alogin']=$_POST['username'];
echo "<script type='text/javascript'> document.location ='admin/dashboard.php'; </script>";
} else{
echo "<font color='Red'>Invalid Username/Password!</font>";
}
}
?>
