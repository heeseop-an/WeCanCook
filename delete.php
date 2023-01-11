<?php    
        session_start();
        require("view/header.html");
        require('control/mydb.php');
        $prevPage = $_SERVER["HTTP_REFERER"];

        $postId = $_GET['id'];
        $commentId = $_GET['cid'];
        $sql = "DELETE FROM Comments WHERE postId = $postId AND commentId = $commentId";
        deleteCommentRequest($sql);
        header("location:".$prevPage);
        require("view/footer.html");
    ?>   