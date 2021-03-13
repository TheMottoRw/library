<?php
session_start();
error_reporting(0);
include('includes/config.php');
include('../api_access.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {


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
                <div class="row">
                    <?php if ($_SESSION['error'] != "") {
                        ?>
                        <div class="col-md-6">
                            <div class="alert alert-danger">
                                <strong>Error :</strong>
                                <?php echo htmlentities($_SESSION['error']); ?>
                                <?php echo htmlentities($_SESSION['error'] = ""); ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($_SESSION['msg'] != "") {
                        ?>
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <strong>Success :</strong>
                                <?php echo htmlentities($_SESSION['msg']); ?>
                                <?php echo htmlentities($_SESSION['msg'] = ""); ?>
                            </div>
                        </div>
                    <?php } ?>



                    <?php if ($_SESSION['delmsg'] != "") {
                        ?>
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <strong>Success :</strong>
                                <?php echo htmlentities($_SESSION['delmsg']); ?>
                                <?php echo htmlentities($_SESSION['delmsg'] = ""); ?>
                            </div>
                        </div>
                    <?php } ?>

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
                                        <th>Action</th>
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


                                                        echo "[Missing]";
                                                    }else echo htmlentities($result->ReturnDate);
                                                    ?></td>
                                                <td class="center"><?php echo $result->RetrunStatus == 0 ? $result->estimated_fine." RWF" : $result->fine." RWF"; ?></td>
                                                <td class="center">
                                                    <a href="update-issue-bookdeails.php?rid=<?php echo htmlentities($result->rid); ?>">
                                                        <button class="btn btn-primary"><i class="fa fa-edit "></i> Edit
                                                        </button>
                                                    </a>
                                                    <?php if ($result->RetrunStatus != 0) { ?>
                                                        <button class="btn btn-success" onclick="confirmSubmission(<?= $result->rid;?>,<?= $result->estimated_fine;?>)"><i class="fa fa-check-square "></i>
                                                            Submit
                                                        </button>
                                                        <button class="btn btn-danger"  onclick="setModalStolen(<?= $result->rid;?>,<?= $result->book_id;?>,<?= ($result->BookPrice + $result->estimated_fine);?>,<?= "'".$result->BookName."'"; ?>)"><i class="fa fa-try "></i>
                                                            Stolen
                                                        </button>
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
        $("#btnSaveStolenBook").click(function (){
            markAsStolenBook();
        })
        function setModalStolen(id,bookid,price,bookTitle){
            $("#issued-id").val(id);
            $("#book-id").val(bookid);
            $("#stolenFine").val(price);
            $("#bookTitle").val(bookTitle);
            $("#btnOpenStolenModal").click();
        }
        function confirmSubmission(id, fine) {
            if (fine == 0) message = "Confirm submission of the book";
            else {
                message = `Confirm submission of the book with fine payment of ${fine} RWF of the submission delay`;
            }
            var confirmation = confirm(message);
            if (confirmation) {
                submitBook(id, fine);
            }
        }

        //function for book details
        function markAsStolenBook() {
            jQuery.ajax({
                url: "../api/requests/issuedbooks.php",
                data: {cate: 'stolen', id: $("#issued-id").val(), fine: $("#stolenFine").val(),bookid:$("#book-id").val()},
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $("#response").html(data.message);
                },
                error: function () {
                }
            });
        }
        //function for book details
        function submitBook(id, fine) {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "../api/requests/issuedbooks.php",
                data: {cate: 'return', id: id, fine: fine},
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $("#response").html(data.message);
                },
                error: function () {
                }
            });
        }

    </script>
    </body>
    </html>
<?php } ?>
