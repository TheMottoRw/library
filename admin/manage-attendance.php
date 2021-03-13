<?php
session_start();
error_reporting(0);
include('includes/config.php');
include_once'../api_access.php';

if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
    $reqAttendaces = curlGetRequest("attendance.php?cate=load");
    $attendances = json_decode($reqAttendaces);

    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SLS| Attendance</title>
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
                <h4 class="header-line">Attendance</h4>
    </div>
         </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Attendance of students who attended Library
                        </div>
                        <div class="panel-body">
                            <div id="response"></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Reg_No</th>
                                            <th>Full_Name</th>
                                            <th>Department</th>
                                            <th>EntryDate(In)</th>
                                            <th>LeavingDate(Out)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
foreach($attendances as $k=>$result)
{               ?>                                      
                                        <tr class="odd gradeX">
                                            <td class="center"><?php echo $k+1;?></td>
                                            <td class="center"><?php echo htmlentities($result->StudentId);?></td>
                                            <td class="center"><?php echo htmlentities($result->Full_Name);?></td>  
                                            <td class="center"><?php echo htmlentities($result->Department);?></td>         
                                            <td class="center"><?php echo htmlentities($result->EntryDate);?></td>
                                            <td class="center"><?php if($result->LeavingDate==null)
                                            {?>
                                            <span class="btn btn-danger btn-xs">
                                             <?php   echo htmlentities("Not Yet Out"); ?>
                                                </span>
                                            <?php }else {


                                            echo htmlentities($result->LeavingDate);
}
                                            ?></td>
                                            <td class="center">
                                                <?php if($result->LeavingDate==null){?>
                                            <button class="btn btn-xs btn-primary " onclick="leave(<?= $result->id ?>)"><i class="fa fa-share "></i>Leave</button>
                                                <?php } ?>
                                            </td>
                                        </tr>
 <?php } ?>
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
    function leave(id){
        var isLeaving = confirm("Confirm attendee is leaving or has left");
        if(isLeaving){
            jQuery.ajax({
                url: "../api/requests/attendance.php",
                data: {cate: 'leave', id: id},
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $("#response").html(data.message);
                    setTimeout(function (){window.location='manage-attendance.php';},1500)
                },
                error: function () {
                }
            });
        }
    }
</script>
</body>
</html>