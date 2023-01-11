<?php
    require("view/header.html");
    require("control/mydb.php");

session_start();
if(isset($_SESSION['id'])) {
    $sql = "SELECT      mk.name, count(*) AS Count, SUM(mk.price) AS Total
            FROM        MealKit mk, Contain c, Orders o
            WHERE       c.orderId = o.orderId
            AND         o.userId = '{$_SESSION['id']}'
            AND         mk.SKU = c.SKU
            GROUP BY    mk.name, mk.price";
    $result = executePlainSQL($sql);
?>
<h2>Summary</h2>
<p>
============================================================
</p>
<?php
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    ?>
    
    <p>
    <h4><?= $row[0] ?></h4>
    </p>
    <p>
    Cnt = <?= $row[1] ?>, Total Cost = $<?= $row[2] ?> 
    </p>
    <p>
    ============================================================
    </p>
    <?php
}

$sql2 = "SELECT      SUM(mk.price) AS totalSum
         FROM        MealKit mk, Contain c, Orders o
         WHERE       c.orderId = o.orderId
         AND         o.userId = '{$_SESSION['id']}'
         AND         mk.SKU = c.SKU";

$result2 = executePlainSQL($sql2);
$total = OCI_Fetch_Array($result2, OCI_BOTH)

?>
<p>
Total value of all your orders = $<?= $total[0] ?>
</p>
<p>
    <button><a class="nav-link" href="orders.php">More Detail</a></button>
    <button><a class="nav-link" href="index.php">Back</a></button>
</p>

<?php
} else {
    header('location:login.php');
}
?>






