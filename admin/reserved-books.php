<?php
session_start();
error_reporting(1);

include_once "../api_access.php";
if(!isset($_SESSION['alogin'])){
    header("location:index.php");
}
$reqReservations = curlGetRequest("reservation.php?cate=get");
$reservations = json_decode($reqReservations);
?>


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SLS| Reserved Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
<!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
<div class="content-wrapper">
    <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">List of Books</h4>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Books Listing
                        </div>
                        <div class="panel-body">
                            <div id="removeReserveResponse"></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student</th>
                                        <th>Department</th>
                                        <th>Book Name</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>ISBN</th>
                                        <th>Identifier</th>
                                        <th>Reserved on</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    foreach($reservations as $K=> $result)
                                    {               ?>
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo $K+1;?></td>
                                            <td class="center"><?php echo htmlentities($result->FullName);?></td>
                                            <td class="center"><?php echo htmlentities($result->Department);?></td>
                                            <td class="center"><?php echo htmlentities($result->BookName);?></td>
                                            <td class="center"><?php echo htmlentities($result->CategoryName);?></td>
                                            <td class="center"><?php echo htmlentities($result->AuthorName);?></td>
                                            <td class="center"><?php echo htmlentities($result->ISBNNumber);?></td>
                                            <td class="center"><?php echo htmlentities($result->identifier);?></td>
                                            <td class="center"><?php echo htmlentities($result->RegDate);?></td>
                                            <td class="center">
                                                <button class="btn btn-success btn-sm" onclick="confirmReservationTaken(<?= "'".$result->id."'"; ?>,<?= "'".$result->StudentId."'"; ?>)"><i class="fa fa-check "></i> Taken</button>
                                                <button class="btn btn-danger btn-sm" onclick="removeReservation(<?= "'".$result->id."'"; ?>,<?= "'".$result->StudentId."'"; ?>)"><i class="fa fa-trash-o "></i> Remove</button>
                                            </td>
                                        </tr>
                                        <?php $cnt=$cnt+1;} ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>



        </div>
    </div>

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php');?>
    <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
    <script>
        function removeReservation(reservationId,studentId) {
            var removeRes = confirm("Are you sure you want to cancel your reservation?");
            if (removeRes) {
                var params = {'cate': 'delete', 'id': reservationId, 'studentid': studentId};
                jQuery.ajax({
                    url: "../api/requests/reservation.php",
                    data: params,
                    dataType: 'json',
                    type: "POST",
                    success: function (data) {
                        $("#removeReserveResponse").html(data.message);
                        setTimeout(function () {
                            window.location = 'reserved-books.php';
                        }, 1500);
                    },
                    error: function () {
                    }
                });
            }
        }
            function confirmReservationTaken(reservationId,studentId){
                var removeRes = confirm("Confirm reserved book given to one who reserved it");
                if(removeRes){
                    var params = {'cate':'taken','id':reservationId,'studentid':studentId};
                    jQuery.ajax({
                        url: "../api/requests/reservation.php",
                        data:params,
                        dataType:'json',
                        type: "POST",
                        success:function(data){
                            $("#removeReserveResponse").html(data.message);
                            setTimeout(function(){
                                window.location='reserved-books.php';
                            },1500);
                        },
                        error:function (){}
                    });
                }
        }
    </script>
</body>
</html>

