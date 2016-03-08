<?php include("includes/header.php"); ?>
<?php include("includes/photo_library_modal.php"); ?>
<?php if(!$session->is_signed_in()) { redirect("login.php"); } ?>
<?php


if (empty($_GET['id'])) {
    redirect("users.php");
} else {
        $user = User::find_by_id($_GET['id']);
        if (isset($_POST['delete'])) {
          $user->delete();
          redirect("users.php");
        }
        if (isset($_POST['update'])){
            if($user){
                $user->username = $_POST['username'];
                $user->first_name = $_POST['first_name'];
                $user->last_name = $_POST['last_name'];
                $user->password = $_POST['password'];

                if (empty($_FILES['user_image'])) {
                  $user->save();
                } else {
                  $user->set_file($_FILES['user_image']);
                  $user->upload_image();
                  $user->save();
                  redirect("edit_user.php?id={$user->id}");
                }
            }
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
                            User Edit
                            <small>Edit User information here</small>
                        </h1>

                        <div class="col-md-3">
                          <a href="" data-toggle="modal" data-target="#photo-library"><img class="img-responsive" src="<?php echo $user->image_path_placeholder(); ?>" alt=""></a>
                        </div>
                        
                        <form action="" method="POST" enctype="multipart/form-data">

                        <div class="col-md-9">
                            <div class="form-group">
                            <label for="title">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $user->username; ?>">
                            </div>
                            <div class="well well-sm">
                                <input type="file" name="user_image">
                            </div>
                            <div class="form-group">
                                    <label for="first_name">First Name</label>
                                <input type="text" class="form-control" name="first_name" value="<?php echo $user->first_name; ?>">
                            </div>
                            <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" value="<?php echo $user->last_name; ?>">
                            </div>
                            <div class="form-group">
                                    <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" value="<?php echo $user->password; ?>">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="update" value="Update" class="btn btn-success btn-sm pull-right">
                            </div>
                            <div class="form-group">
                                <a id="user-id" href="delete_user.php?id=<?php echo $user->id; ?>"><input type="submit" name="delete" value="Delete" class="btn btn-danger btn-sm pull-left"></a>
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