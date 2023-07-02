<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand">WeCanCook</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="blog.php">Blog</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="topRated.php">Top Rated</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Filter
                </a>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="index.php">Normal</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">At least 3 stars</a></li>
                    <li><a class="dropdown-item" href="#">Only Most Commented</a></li>    
                </ul>
                </li>
            </ul>
            <?php
                $url = "login.php";
                $value = "Go To Login";
                if(isset($_SESSION['name'])) {
                    $url = "index.php";
                    $value = "Logout";
                    
                } 
                if(isset($_POST['goLogin_1'])) {
                    
                    if(isset($_SESSION['name'])) {
                        session_unset();
                        header('location:index.php');
                    } else {
                        header('location:login.php');
                    }
                }   
            ?>
            <form class="d-flex" method="POST">
                <?php
                    echo "<button class='btn btn-outline-success' name=\"goLogin_1\" href='$url'>$value</button>";
                ?>
            </form>
        </div>
    </div>
</nav>
