<?php
require('index.nav.php');
require('control/mydb.php');

$view_num = $_GET['id'];

$sql = "SELECT * FROM Post p INNER JOIN MealPosts mp ON p.postId = mp.postId WHERE p.postId = $view_num";

$sql2 = "SELECT mk.SKU, mk.price, mk.instruction
            FROM MealKit mk, Explains s, Post p, MealPosts mp 
            WHERE p.postId = mp.postId AND mp.postId = s.postId AND s.postId = $view_num AND s.SKU = mk.SKU";


$result = handleRowRequest($sql);
$result2 = handleRowRequest($sql2);


if ($row = oci_fetch_row($result)) {
    if ($row2 = oci_fetch_row($result2)) {

        ?>
        <div class="row justify-content-center">
            <div class="col-16 col-md-8 p-3">
                <div class="my-6">
                    <h2><?= $row[1] ?></h2>
                </div>
            </div>
            <div class="col-14 col-md-8 p-3">
                <?php
                $name = preg_replace("! !", "_", rtrim($row[1]));
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
            <div style="col-12 col-md-8 p-3">
                <div class="alert alert-primary">
                    <figure class="text-center">
                        <blockquote class="blockquote">
                            <p>Price = $<?= $row2[1] ?></p>
                            <p>SKU# = <?= $row2[0] ?></p>
                            <p>Instruction) <?= $row2[2] ?></p>
                        </blockquote>
                    </figure>
                </div>
            </div>
            <div class="col-10 col-md-5">
                <div class="d-grid gap-2 col-11 p-5">
                    <form action="" method="POST">
                        <button type="submit" class="btn btn-primary" name='add'>Add to Cart</button>
                        <input type="hidden" name="product_id" value="<?= $view_num ?>">
                    </form>
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


        if (isset($_POST['add'])) {

            if (isset($_SESSION['cart'])) {

                $itemArrayId = array_column($_SESSION['cart'], "product_id");
                
                if(in_array($_POST['product_id'], $itemArrayId)) {
                     
                    echo "<script>alert('Product already added!!!!')</script>";
                    echo "<script>window.location = 'index.php'</script>";
                    
                } else {
                    $count = count($_SESSION['cart']);
                    $itemArray = array('product_id' => $_POST['product_id']);
                    $_SESSION['cart'][$count] = $itemArray;
                    echo "<script>alert('Product successfully added!!!!')</script>";
                    echo "<script>window.location = 'index.php'</script>";
                    print_r($_SESSION['cart']);
            }
            } else {
                $itemArray = array('product_id' => $_POST['product_id']);

                $_SESSION['cart'][0] = $itemArray;
                echo "<script>alert('Product successfully added!!!!')</script>";
                echo "<script>window.location = 'index.php'</script>";
            }

            
            
        }


    }
}

require('ingredient.php');
require('comment.php');
?>

