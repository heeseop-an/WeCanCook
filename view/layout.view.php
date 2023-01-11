<!DOCTYPE html>
<html lang="en">
<?php
    require("header.html");
    if ($type == 1) {
        require("$model.list.php");
    } else {
        require("$model.detail.php");
    }
    require("footer.html");
?>

