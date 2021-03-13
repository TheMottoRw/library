<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <H1 style="font-family: Verdana;"><font color="Skyblue">SMART LIBRARY SYSTEM</font></H1>

            </div>

            <div class="right-div">
                <a href="logout.php" class="btn btn-danger pull-right">LOG ME OUT (<?= $_SESSION['name']; ?>)</a>
            </div>
            <div class="right-div">
                <button class="btn btn-info pull-right" data-toggle="modal" data-target="#emailModal"><i class="fa fa-send"></i> Broadcast email</button>
            </div>
            <div class="right-div">
                <a href="change-password.php" class="btn btn-danger pull-right">CHANGE PASSWORD</a>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboard.php" class="menu-top-active">DASHBOARD</a></li>
                           
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Categories <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-category.php">Add Category</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-categories.php">Manage Categories</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Authors <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-author.php">Add Author</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-authors.php">Manage Authors</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">Departments<i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-department.php">Add New Department</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-department.php">Manage Departments</a></li>
                                </ul>
                            </li>
                           <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Books <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-book.php">Add Book</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-books.php">Manage Books</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="reserved-books.php">Reserved Books</a></li>
                                </ul>
                            </li>
                           <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Issue Books <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="issue-book.php">Issue New Book</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-issued-books.php">Manage Issued Books</a></li>
                                </ul>
                            </li>
                             <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Attendance <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-attendance.php">New Entrance</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="manage-attendance.php">Manage Attendance</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">Student<i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="add-student.php">Add_Student</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="reg-students.php">Manage_Students</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown">Reports<i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="report-missing-book.php">Missing books</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="report-issued-book.php">Issued Books</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="emailModalLabel">Broadcast email to students</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text"  class="form-control" name="" id="title">
                                </div>
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea name="" class="form-control" rows="6" id="message"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnClose">Close</button>
                            <button type="button" onclick="sendEmail()" id="btnSendEmail" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    function sendEmail(){
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "../api/requests/broadcast.php",
                data: {cate: 'broadcast',title:document.getElementById("title").value, message: document.getElementById("message").value},
                type: "POST",
                dataType: 'text',
                success: function (data) {
                    document.getElementById("btnClose").click();
                    if(data=='ok') alert("Email broadcasted successful");
                },
                error: function () {
                }
            });
    }
</script>