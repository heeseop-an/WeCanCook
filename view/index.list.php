<?php 
    require('index.nav.php');
    require('card.view.php');

    
    $sql = "SELECT p.postId, p.title, p.content FROM Post p, MealPosts mp WHERE p.postId = mp.postId";

    if(isset($_GET['md'])) {
        if ($_GET['md'] == "T") {
            $sql = "SELECT  p.postId, p.title, p.content 
                    FROM    Post p, MealPosts mp 
                    WHERE   p.postId = mp.postId
                    AND     p.postId IN (   SELECT      postId
                                            FROM        Comments
                                            GROUP BY    postId
                                            HAVING      avg(rating) >= 8
                                        )";
        } else if ($_GET['md'] == "C") {
            $sql = "SELECT  p.postId, p.title, p.content 
                    FROM    Post p, MealPosts mp 
                    WHERE   p.postId = mp.postId
                    AND     p.postId IN (   SELECT postId
                                            FROM   Comments
                                            GROUP BY postId
                                        )";
        } else if ($_GET['md'] == "M") {
            $sql = "SELECT  p.postId, p.title, p.content 
            FROM    Post p, MealPosts mp 
            WHERE   p.postId = mp.postId
            AND     p.postId IN (   SELECT      c1.postId
                                    FROM        Comments c1   
                                    GROUP BY    c1.postId
                                    HAVING      COUNT(*) = (
                                                            SELECT MAX(COUNT(*))
                                                            FROM Comments c2   
                                                            GROUP BY c2.postId
                                                            )
                                )";
        }
    }

    if (isset($_POST['search'])) {
        // Division    
        $item = $_POST['ingredient'];
        $sql = "SELECT  p.postId, p.title, p.content 
        FROM    Post p, MealPosts mp
        WHERE   p.postId = mp.postId
                AND NOT EXISTS ((   SELECT      distinct l1.postId
                                FROM        List l1
                                WHERE       l1.postId = p.postId)
                                MINUS
                            (   SELECT      distinct l2.postId
                                FROM        List l2
                                WHERE       l2.ingName = '$item'
                            ))";
    }
    getCardView($sql, $model);
?>
