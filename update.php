<?php
    session_start();
    require("view/header.html");
    require("control/mydb.php"); 

    $postId = $_GET['id'];
    $commentId = $_GET['cid'];
    $model = $_GET['m'];

    if(isset($_POST['comment_update'])) {
        $rating = $_POST['rating_update'];
        $content = $_POST['content_update'];
     
        $sql = "UPDATE Comments SET content= '$content', rating = $rating WHERE postId = $postId AND commentId = $commentId";
        updateCommentRequest($sql);

        header("location:".$model."_detail.php?id=".$postId);
    }

    $sql = "SELECT rating, content FROM Comments WHERE postId = $postId AND commentId = $commentId";
    $result = handleRowRequest($sql);

    if (($row = oci_fetch_row($result))) {
?>
<body>
    <h1>Update Comment</h1>
    <form action="" method="post">
        <p>
            <label for="rating_update">Rating:</label>
            <input type="text" id="rating_update" name ="rating_update" value="<?= $row[0] ?>" placeholder = "Type the rating (1~10)">
        </p>
        <p>
            <label for="content_update">Comment:</label>
            <textarea id="content_update" name ="content_update" cols="30" rows="10" placeholder = "Type the commnet"><?= $row[1] ?></textarea>
        </p>
        <input type="submit" name="comment_update" value="Update">
    </form>
<?php
    }
    require("view/footer.html");
?>
