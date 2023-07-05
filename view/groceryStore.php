<p>
<?php
$currPostId = $_GET['id'];
$sql = "SELECT gs.storeId, gs.name, gs.address 
FROM GroceryStore gs
WHERE gs.storeId IN 
(SELECT i.storeId 
FROM Inform i 
WHERE i.postId = $currPostId)";
$result = executePlainSQL($sql);
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "$row[1]"; //ingName
}
?>
</p>