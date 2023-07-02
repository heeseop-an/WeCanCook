<hr>
<h2>Comment</h2>
<hr>
<form action="">
    <input type="text" name="txt_comment" placeholder = "type comment"/>
    <input type="submit" value="enter"/>
</form>
<?php
    require('control/mydb.php');
    $sql = "SELECT * FROM Comments WHERE postId = $view_num";
    $result = executePlainSQL($sql);
 
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    }
?>
    <a href="">Update</a>
