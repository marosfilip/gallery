<?php include("includes/header.php"); ?>
<?php

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 4;
$items_total_count = Photo::count_all();

// $photos = Photo::find_all();
$paginate = new Paginate($page, $items_per_page, $items_total_count);
$sqlstring = "SELECT * FROM photos ";
$sqlstring .= "LIMIT {$items_per_page} ";
$sqlstring .= "OFFSET {$paginate->offset()}";
$photos = Photo::find_by_query($sqlstring);

?>


        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <div class="thumbnails row">
            <?php foreach ($photos as $photo): ?>
                
                    
                    <div class="col-xs-6 col-md-3">
                        <a class="thumbnail" href="photo.php?id=<?php echo $photo->id ?>">
                        <img class="home_page_photo" src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                            
                        </a>
                    </div>

            <?php endforeach; ?>
             </div>

             <div class="row" align="center">
                 <ul class="pagination">

                    <?php

                        if ($paginate->has_previous()) {
                                echo "<li><a href='index.php?page={$paginate->previous()}'>Previous</a></li>";
                            }

                        for ($i=1; $i <= $paginate->page_total(); $i++) { 
                            if ($i == $paginate->current_page) {
                                echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                            } else {
                                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                            }
                        }


                        if ($paginate->page_total() > 1) {
                            if ($paginate->has_next()) {
                                echo "<li><a href='index.php?page={$paginate->next()}'>Next</a></li>";
                            }
                        }

                        


                            
                        

                    ?>                     
                     
                 </ul>
             </div>

    
            
          
         

            </div>
        </div>

        <?php include("includes/footer.php"); ?>
