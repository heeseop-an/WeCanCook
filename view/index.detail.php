<?php
    require('index.nav.php');
    require('control/mydb.php');
 
    $view_num = $_GET['id'];
    $sql = "SELECT * FROM Post p INNER JOIN MealPosts mp ON p.postId = mp.postId WHERE p.postId = $view_num";

    $result = handleRowRequest($sql);

    if (($row = oci_fetch_row($result))) {
?>   
<div class="row justify-content-center">           
    <div class="col-16 col-md-8 p-3">
        <div class="my-6">
            <h2><?= $row[1] ?></h2>
        </div>
    </div>
    <div class="col-14 col-md-8 p-3">
        <?php
            $name = preg_replace("! !", "_",  rtrim($row[1]));
            echo "<img src=images\\$name.jpg  class=\"img-fluid\" alt=\"Responsive image\">"
        ?>
    </div>
    <div style="col-12 col-md-8 p-3">
        <div class="alert alert-primary">
            <figure class="text-center">
                <blockquote class="blockquote">
                    <p><?= $row[2] ?></p>
                </blockquote>
            </figure>
        </div>
    </div>
    <div class="col-10 col-md-5">
        <div class="d-grid gap-2 col-11 p-5">
            <button class="btn btn-primary" type="button">Add</button>
        </div>
    </div>
    <div class="col-16 col-lg-8">
        <figure class="text-center">
            <span><?= $row[4] ?></p>
                <blockquote class="blockquote">
                    <p><?= $row[5] ?></p>
                </blockquote>
        </figure>
    </div>
</div>
    <?php
    }
    require('ingredient.php');
    require('groceryStore.php');
    require('comment.php');
?>