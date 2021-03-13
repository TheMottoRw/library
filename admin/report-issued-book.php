<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('../api_access.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
}


    ?>
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <title>SLS| Manage Issued Books</title>
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
                    <h4 class="header-line">List of Issued Books</h4>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Issued Books
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="response"></div>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Book Name</th>
                                        <th>ISBN</th>
                                        <th>Identifier</th>
                                        <th>Issued Date</th>
                                        <th>Expected Return on</th>
                                        <th>Returned on</th>
                                        <th>Fine</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $results = json_decode(curlGetRequest("issuedbooks.php?cate=get"));
                                    $sql = "SELECT tblstudents.FullName,tblbooks.BookName,tblbooks.ISBNNumber,tblbooks.identifier,tblissuedbookdetails.IssuesDate,tblissuedbookdetails.ReturnDate,tblissuedbookdetails.id as rid from  tblissuedbookdetails join tblstudents on tblstudents.StudentId=tblissuedbookdetails.StudentId join tblbooks on tblbooks.id=tblissuedbookdetails.BookId order by tblissuedbookdetails.id desc";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    //$results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    //if($query->rowCount() > 0)
                                    if (count($results) > 0) {
                                        foreach ($results as $result) { ?>
                                            <tr class="odd gradeX" >
                                                <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                <td class="center"><?php echo htmlentities($result->FullName); ?></td>
                                                <td class="center"><?php echo htmlentities($result->BookName); ?></td>
                                                <td class="center"><?php echo htmlentities($result->ISBNNumber); ?></td>
                                                <td class="center"><?php echo htmlentities($result->identifier); ?></td>
                                                <td class="center"><?php echo htmlentities($result->IssuesDate); ?></td>
                                                <td class="center"><?php echo htmlentities(substr($result->submission_date,0,10)); ?></td>
                                                <td class="center  <?= $result->RetrunStatus==2?'alert alert-danger':''; ?>"><?php if ($result->RetrunStatus == 0) {
                                                        ?>
                                                        <span style="color:red">
                                             <?php echo "<button class='btn  btn-warning btn-xs'>".htmlentities("Not Returned Yet")."</button>"; ?>
                                                </span>
                                                    <?php } else if($result->RetrunStatus==2){


                                                        echo "<button class='btn btn-xs btn-danger'>Missing</button>";
                                                    }else echo htmlentities($result->ReturnDate);
                                                    ?>
                                                </td>
                                                <td class="center"><?php echo $result->RetrunStatus == 0 ? $result->estimated_fine." RWF" : $result->fine." RWF"; ?></td>
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
        <!-- Stolen confirmation modal -->
        <button type="button" style="display: none" class="btn btn-info btn-xs" data-toggle="modal" data-target="#stolenBookModal" id="btnOpenStolenModal">Open Modal</button>

        <!-- Modal -->
        <div id="stolenBookModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Mark <b><span id="bookTitle"></span></b> as missing</h4>
                    </div>
                    <div class="modal-body">
                        <div id="stolenResponse"></div>
                        <form role="form" >
                            <div class="form-group">
                                <input type="hidden" id="issued-id">
                                <input type="hidden" id="book-id">
                                <label>Book price + Current fine</label>
                                <input type="text" class="form-control" name="stolenFine" id="stolenFine">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="btnSaveStolenBook" data-dismiss="modal">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
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


    </script>
    </body>
    </html>
