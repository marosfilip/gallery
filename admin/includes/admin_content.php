            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>Subheading</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
          
<?php 

// $photos = Photo::find_all();
// foreach ($photos as $photo) {
//     echo $photo->title . "<br />";
// }


$photo = new Photo();
$photo->title = "test title";
$photo->description = "Some description of the photo goes here";
$photo->filename = "image2.jpg";
$photo->type = "image";
$photo->size = "128";
$photo->create();


 ?>







            </div>
            <!-- /.container-fluid -->