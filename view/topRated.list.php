<?php 
    require('index.nav.php');
    require('card.view.topRated.php');
  
    

    // "SELECT p.postId, p.title, p.content FROM Post p, MealPosts mp WHERE p.postId = mp.postId";
    $sql = "SELECT p.title, MAX(mp.rate)
    FROM Post p, MealPosts mp
    WHERE p.postId = mp.postId AND mp.rate >= 8
    GROUP BY p.title";
    getCardView($sql, $model);
?>
