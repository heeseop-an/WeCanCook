<?php
    session_start();
    require("view/header.html");
    require("control/mydb.php");
?>

<form action="" method="POST">
    <p>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
    </p>
    <p>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </p>
    <p>
        <input type="submit" name="login" value="Login">
    </p>
</form>
<div class="error">
    <p>
        <?php
        if(isset($status)) {
            echo $status;
            $status = "";
        }
        ?>
    </p>
</div> 
<?php
    require("view/footer.html");
?>

