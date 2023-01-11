<hr>
<h2>Ingredient</h2>
<hr>
<p>
<?php
$currPostId = $_GET['id'];
$sql = "SELECT * FROM List l WHERE l.postId = $currPostId";
$result = executePlainSQL($sql);
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    echo "$row[1]"; //ingName
}
?>
</p>

<p>
<a href="groceryStore.php?id=<?= $currPostId ?>">Are you looking for grocery stores to buy these ingredients?</a>
</p>

<!-- <?php
"<button class=\"btn btn-secondary\" type=\"button\">Nearby Grocery Stores</button>".
"</a>";
?> -->
