<?php 
    require('index.nav.php');
    require('card.view.php');
  
    

    // "SELECT p.postId, p.title, p.content FROM Post p, MealPosts mp WHERE p.postId = mp.postId";
    $sql = "SELECT p.postId, p.title, p.content FROM Post p, MealPosts mp WHERE p.postId = mp.postId";
    getCardView($sql, $model);
?>
