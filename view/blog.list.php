<?php 
    require('blog.nav.php');
    require('card.view.php');
    $sql = "SELECT p.postId, p.title, p.content FROM Post p, Blog b WHERE p.postId = b.postId";
    getCardView($sql, $model);
?>

</nav>