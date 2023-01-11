<hr>
<h1>Comment</h1>
<hr>
<?php
    if(isset($_POST['cmt_insert'])) {
        if(isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];
            $rating = $_POST['rating_insert'];
            $content = $_POST['content_insert'];

            $sql = "INSERT INTO Comments(postId, commentId, rating, content, userId)
                    VALUES ($view_num, comment_seq.NEXTVAL, $rating, '$content', $userId)";

            insertCommentRequest($sql);  
        } 
        else{
            echo "<script type='text/javascript'>alert('Please Login...');</script>";
        }
    }
    
    $sql = "SELECT u.name, c.rating, c.content, c.commentId, u.userId FROM Comments c JOIN Users u ON c.userId = u.userId WHERE c.postId = $view_num";

    $result = executePlainSQL($sql);

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "Name: $row[0] &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Rating: $row[1]<br>";
        echo "Content: $row[2]<br>";
      
        if ($row[4] == $_SESSION['id']) {
            echo "<a href=\"update.php?id={$view_num}&cid={$row[3]}&m={$model}\">Update</a> &nbsp&nbsp";
            echo "<a href=\"delete.php?id={$view_num}&cid={$row[3]}&m={$model}\">Delete</a>";
            echo "<hr>";
        }
    }
?>
<hr>
<form action="" method="post">
    <p>
        <label for="rating_insert">Rating:</label>
        <input type="text" id="rating_insert" name ="rating_insert" placeholder = "Type the rating (1~10)">
    </p>
    <p>
        <label for="content_insert">Comment:</label>
        <textarea id="content_insert" name ="content_insert" cols="30" rows="10" placeholder = "Type the comment"></textarea>
    </p>
    <input type="submit" id="cmt_insert" name="cmt_insert" value="Insert">
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