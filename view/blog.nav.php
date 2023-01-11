<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand">WeCanCook</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" href="blog.php">Blog</a>
                </li>
            </ul>
            <?php
                $url = "login.php";
                $value = "Go To Login";
                if(isset($_SESSION['name'])) {
                    $url = "index.php";
                    $value = "Logout";
                } 
                if(isset($_POST['goLogin_2'])) {
                    if(isset($_SESSION['name'])) {
                        session_unset();
                        header('location:blog.php');
                    } else {
                        header('location:login.php');
                    }
                }   
            ?>
            <form class="d-flex" method="POST">
                <?php
                    echo "<button class='btn btn-outline-success' name=\"goLogin_2\" href='$url'>$value</button>";
                ?>
            </form>
        </div>
    </div>
</nav>
