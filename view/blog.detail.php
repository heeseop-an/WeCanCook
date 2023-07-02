<?php
    require('blog.nav.php');
    require('control/mydb.php');
 
    $view_num = $_GET['id'];
    $sql = "SELECT * FROM Post p INNER JOIN Blog b ON p.postId = b.postId AND p.postId = $view_num";
    
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
</div>
    <?php
    }
?>