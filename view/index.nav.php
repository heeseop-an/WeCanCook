<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand">WeCanCook</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link" href="history.php">My Order History</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Filter
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php">Normal</a></li>
                        <li><a class="dropdown-item" href="index.php?md=T">Top Rated</a></li>
                        <li><a class="dropdown-item" href="index.php?md=C">Commented Only</a></li>
                        <li><a class="dropdown-item" href="index.php?md=M">Most Commented</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                <form action="" method="POST">
                    <input type="text" name="ingredient" id="ingredient">
                    <input type="submit" name="search" value="Search">
                </form>
                </li>
                <li class="nav-item">
                <?php
                $url = "login.php";
                $value = "Go To Login";
                if (isset($_SESSION['id'])) {
                    $url = "index.php";
                    $value = "Logout";

                }
                if (isset($_POST['goLogin_1'])) {

                    if (isset($_SESSION['id'])) {
                        session_unset();
                        header('location:index.php');
                    } else {
                        header('location:login.php');
                    }
                }
                ?>
                </li>
                <li class="nav-item">
                <form class="d-flex" method="POST">
                    <?php
                    echo "<button class='btn btn-outline-success' name=\"goLogin_1\" href='$url'>$value</button>";
                    ?>
                </form>
                </li>
                <li class="nav-item">
                <div class="link-icons">
                    <a href="#">
                        <i class="fas fa-shopping-cart">Cart
                        <?php
                        if (isset($_SESSION['cart'])) {
                            $count = count($_SESSION['cart']);
                            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$count</span>";
                        } else {
                            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
                        }
                        ?>
                        </i>
                    </a>
                </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
