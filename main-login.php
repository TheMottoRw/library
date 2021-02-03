<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('api_access.php');
if ($_SESSION['login'] != '') {
    $_SESSION['login'] = '';
} ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>SMB|UserLogin </title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet"/>
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet"/>
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet"/>
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>

</head>
<body style="background-image: url(admin/assets/img/3.jpg);">
<!------MENU SECTION START-->
<?php include('includes/header.php'); ?>
<!-- MENU SECTION END-->
<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <!--LOGIN PANEL START-->
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                USER LOGIN FORM
                            </div>
                            <div class="panel-body">

                                <?php
                                if (isset($_POST['login'])) {
                                    $_POST['cate'] = 'login';
                                    $resp = json_decode(curlPostRequest("helper.php", $_POST));
                                    if ($resp->status == 'ok') {
                                        $userInfo = $resp->user_info;
                                        $_SESSION['login'] = true;
                                        $_SESSION['category'] = $userInfo->category;
                                        $_SESSION['id'] = $userInfo->id;
                                        if ($userInfo->category == 'admin'){
                                            $_SESSION['alogin']=$userInfo->UserName;
                                            $_SESSION['emailid'] = $userInfo->AdminEmail;
                                        header('location:admin/dashboard.php');
                                        }else {
                                            $_SESSION['login'] = $userInfo->EmailId;
                                            if($userInfo->Status==1)
                                            {
                                                header('location:dashboard.php');
                                            } else {
                                                echo "<div class='alert alert-danger'>Your Account Has been blocked, Please contact admin!</div>";

                                            }
                                        }
                                    } else echo $resp->message;
                                }

                                ?>
                                <form role="form" method="post">

                                    <div class="form-group">
                                        <label>Username,Email or Phone number</label>
                                        <input class="form-control" type="text" Placeholder="Enter your username email or phone number"
                                               name="username" required autocomplete="off"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input class="form-control" type="password" name="password" required
                                               autocomplete="off"/>
                                        <p class="help-block"><a href="user-forgot-password.php">Forgot Password</a></p>
                                    </div>
                                    <button type="submit" name="login" class="btn btn-info">LOGIN</button>
                                    &nbsp&nbsp&nbsp&nbsp
                                    &nbsp&nbsp&nbsp&nbsp
                                    <button type="reset" name="Clear" value="Clear" class="btn btn-info">CLEAR</button>
                                    | <a href="signup.php">New student?</a><br>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!---LOGIN PABNEL END-->


            </div>
        </div>
        <!-- CONTENT-WRAPPER SECTION END-->
        <!-- FOOTER SECTION END-->
        <script src="assets/js/jquery-1.10.2.js"></script>
        <!-- BOOTSTRAP SCRIPTS  -->
        <script src="assets/js/bootstrap.js"></script>
        <!-- CUSTOM SCRIPTS  -->
        <script src="assets/js/custom.js"></script>

</body>
</html>
