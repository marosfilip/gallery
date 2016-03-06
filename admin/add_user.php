<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) { redirect("login.php"); } ?>
<?php

$user = new User();
        if (isset($_POST['create'])){


            if($user){
                $user->username = $_POST['username'];
                $user->first_name = $_POST['first_name'];
                $user->last_name = $_POST['last_name'];
                $user->password = $_POST['password'];
                $user->set_file($_FILES['user_image']);
                $user->save_user_and_image();
            }
        }


?>


        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            


        <?php include("includes/top_nav.php"); ?>
        

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include("includes/side_nav.php"); ?>
            <!-- /.navbar-collapse -->
        </nav>





        <div id="page-wrapper">

        <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add User
                            <small>Register new user</small>
                        </h1>
                        
                        <form action="" method="POST" enctype="multipart/form-data">

                        <div class="col-md-6 col-md-offset-3">
                            <div class="form-group">
                            <label for="title">Username</label>
                                <input type="text" class="form-control" name="username">
                            </div>
                            <div class="well well-sm">
                                <input type="file" name="user_image">
                            </div>
                            <div class="form-group">
                                    <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name">
                            </div>
                            <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name">
                            </div>
                            <div class="form-group">
                                    <label for="password">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="create" value="Register!" class="btn btn-success btn-sm pull-right">
                            </div>
                        </div>


                        </form>


                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>