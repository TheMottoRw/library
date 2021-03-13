<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

// code for block student    
    if (isset($_GET['inid'])) {
        $id = $_GET['inid'];
        $status = 0;
        $sql = "update tblstudents set Status=:status  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:reg-students.php');
    }


//code for active students
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $status = 1;
        $sql = "update tblstudents set Status=:status  WHERE id=:id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:reg-students.php');
    }


    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>SLS| List of Students</title>
        <!-- BOOTSTRAP CORE STYLE  -->
        <link href="assets/css/bootstrap.css" rel="stylesheet"/>
        <!-- FONT AWESOME STYLE  -->
        <link href="assets/css/font-awesome.css" rel="stylesheet"/>
        <!-- DATATABLE STYLE  -->
        <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet"/>
        <!-- CUSTOM STYLE  -->
        <link href="assets/css/style.css" rel="stylesheet"/>
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>

    </head>
    <body>
    <!------MENU SECTION START-->
    <?php include('includes/header.php'); ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">List of Students</h4>
                </div>


            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Reg Students
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <?php
                                    if(isset($_POST['update'])){
                                        $qy = $dbh->prepare("UPDATE tblstudents SET card=:card WHERE id=:id");
                                        $qy->execute(['id'=>$_POST['studentid'],'card'=>$_POST['card']]);
                                        if($qy->rowCount()>0){
                                            echo "<div class='alert alert-success'>Library card updated successful</div>";
                                        }else{
                                            echo "<div class='alert alert-danger' data-error=".json_encode($qy->errorInfo()).">Failed to update library card</div>";
                                        }
                                    }
                                ?>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Library card</th>
                                        <th>Email id</th>
                                        <th>Mobile Number</th>
                                        <th>Department</th>
                                        <th>Reg Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $sql = "SELECT * from tblstudents";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) { ?>
                                            <tr class="odd gradeX">
                                                <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                <td class="center"><?php echo htmlentities($result->StudentId); ?></td>
                                                <td class="center"><?php echo htmlentities($result->FullName); ?></td>
                                                <td class="center"><?php echo htmlentities($result->card); ?></td>
                                                <td class="center"><?php echo htmlentities($result->EmailId); ?></td>
                                                <td class="center"><?php echo htmlentities($result->MobileNumber); ?></td>
                                                <td class="center"><?php echo htmlentities($result->Department); ?></td>
                                                <td class="center"><?php echo htmlentities($result->RegDate); ?></td>
                                                <td class="center"><?php if ($result->Status == 1) {
                                                        echo htmlentities("Active");
                                                    } else {


                                                        echo htmlentities("Blocked");
                                                    }
                                                    ?></td>
                                                <td class="center">
                                                    <button class="btn btn-warning" onclick="setCardData(this)"
                                                            data-id="<?= $result->id; ?>"
                                                            data-card="<?= $result->card; ?>"
                                                            data-name="<?= $result->FullName;?>">Card
                                                    </button>

                                                    <?php if ($result->Status == 1) {
                                                        ?>
                                                        <a href="reg-students.php?inid=<?php echo htmlentities($result->id); ?>"
                                                           onclick="return confirm('Are you sure you want to block this student?');"" >
                                                        <button class="btn btn-danger"> Inactive</button>
                                                    <?php } else { ?>

                                                        <a href="reg-students.php?id=<?php echo htmlentities($result->id); ?>"
                                                           onclick="return confirm('Are you sure you want to active this student?');"">
                                                        <button class="btn btn-primary"> Active</button>
                                                    <?php } ?>

                                                </td>
                                            </tr>
                                            <?php $cnt = $cnt + 1;
                                        }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>


        </div>
        <button type="button" id="openmodal" data-toggle="modal" data-target="#cardModal"></button>

        <div class="modal fade" id="cardModal" tabindex="-1" role="dialog" aria-labelledby="cardModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="<?= $_SERVER['PHP_SELF']; ?>" METHOD="Post" role="form" id="cardForm">

                        <div class="modal-header">
                            <h5 class="modal-title">Add or Edit student library card of <span id="studentname" style="font-weight: bold"></span></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="studentid" id="studentid">
                                <label>Card</label>
                                <input type="text" name="card" class="form-control" id="card">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- CONTENT-WRAPPER SECTION END-->
    <?php include('includes/footer.php'); ?>
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
        function setCardData(obj) {
            document.getElementById('studentname').innerHTML=obj.getAttribute('data-name');
            document.getElementById('studentid').value=obj.getAttribute('data-id');
            document.getElementById('card').value=obj.getAttribute('data-card');
            document.getElementById("openmodal").click();
        }
    </script>
    </body>
    </html>
<?php } ?>
