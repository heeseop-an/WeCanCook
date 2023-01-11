<?php
    function view($model, $type) {
        require("view/layout.view.php");
    }
    
    function is_user_authenticated() {
        return isset($_SESSION['name']);
    }
?>