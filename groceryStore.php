<?php
    require("view/header.html");
    require("control/mydb.php"); 
    $postId = $_GET['id'];
    if(isset($_POST['return'])) {
        header("location:index_detail.php?id=".$postId);
    }
?>
<p>
<?php
    $sql = "SELECT * 
            FROM GroceryStore
            WHERE storeId IN    (   SELECT storeId 
                                    FROM Inform 
                                    WHERE postId = $postId
                                )";
    $result = executePlainSQL($sql);
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "$row[1] "; //ingName
        echo "<br>"; //ingName
    }

?>
</p>
<form action="" method="post">
    <p>
        <input type="submit" name="return" value="Return">
    </p>
</form>
<?php
    require("view/footer.html");
?>


