<?php
    session_start();
    require("view/header.html");
    require("control/mydb.php");

    if(!isset($_SESSION['id'])) { ?>
<h1>Please log in to view orders</h1>
<?php } else { ?>
<h1>Orders</h1>
<form action="" method="GET">
    <p>
        <label for="ordermonth">Filter by month & year:</label>
        <input type="month" id="ordermonth" name="ordermonth">
    </p>
    <p>
        <input type="submit" name="filter" value="Filter by time period">
    </p>
</form>
<a href="orders.php?view=group"><button type="button">See orders per month</button></a>
<a href="orders.php"><button type="button">Reset</button></a>
<a href="index.php"><button>Go To Main Page</button></a>
<?php 

    $sql = "SELECT mk.name, o.orderId, o.trackingId, o.userId, o.year, o.month, mk.price
            FROM Orders o, Contain c, MealKit mk
            WHERE mk.SKU = c.SKU AND
                o.orderId = c.orderId AND
                o.userID = '{$_SESSION['id']}'
            ORDER BY o.year desc, o.month desc";

    if(isset($_GET['view'])) {
    $sql = "SELECT o.year, o.month, Count(*)
        FROM  Orders o
        WHERE o.userID = '{$_SESSION['id']}'
        GROUP BY o.year, o.month
        ORDER BY o.year desc, o.month desc";
    } else if (isset($_GET['ordermonth']) && !empty($_GET['ordermonth'])) {
    $ordertime = explode("-", $_GET['ordermonth']);
    $orderyear = $ordertime[0];
    $ordermonth = $ordertime[1];
    $sql = "SELECT mk.name, o.orderId, o.trackingId, o.userId, o.year, o.month, mk.price
            FROM Orders o, Contain c, MealKit mk
            WHERE mk.SKU = c.SKU AND
                o.orderId = c.orderId AND
                o.userID = '{$_SESSION['id']}' AND
                o.year = '$orderyear' AND o.month = '$ordermonth'
            ORDER BY o.year desc, o.month desc";
    }

    $result = executePlainSQL($sql);

    if(isset($_GET['view'])) {
    ?>
    <table class="fl-table">
    <thead>
            <tr>
                <td>Year</td>
                <td>Month</td>
                <td>Number of orders</td>
            </tr>
        </thead>
        <tbody>
        <?php
            while($row = oci_fetch_row($result)) {
            ?>
                <tr>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1]?></td>
                    <td><?php echo $row[2]?></td>
                </tr>

            <?php
            }
            ?>
            </tbody>
    </table>
    <?php
    } else {
        ?>
    <table class="fl-table">
    <thead>
            <tr>
                <td>MealKit</td>
                <td>Order ID</td>
                <td>Tracking ID</td>
                <td>User ID</td>
                <td>Year</td>
                <td>Month</td>
                <td>Price</td>
            </tr>
        </thead>
        <tbody>
        <?php
            while($row = oci_fetch_row($result)) {
            ?>
                <tr>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1]?></td>
                    <td><?php echo $row[2]?></td>
                    <td><?php echo $row[3]?></td>
                    <td><?php echo $row[4]?></td>
                    <td><?php echo $row[5]?></td>
                    <td><?php echo $row[6]?></td>
                </tr>

            <?php
            }
            ?>
            </tbody>
    </table>
    <?php
    }

    }

    require("view/footer.html");
?>
<style>
    /* From https://codepen.io/florantara/pen/dROvdb */
.fl-table {
    border-radius: 5px;
    font-size: 12px;
    font-weight: normal;
    border: none;
    border-collapse: collapse;
    width: 100%;
    max-width: 100%;
    white-space: nowrap;
    background-color: white;
}

.fl-table td, .fl-table th {
    text-align: center;
    padding: 8px;
}

.fl-table td {
    border-right: 1px solid #f8f8f8;
    font-size: 12px;
}

.fl-table thead th {
    color: #ffffff;
    background: #4FC3A1;
}


.fl-table thead th:nth-child(odd) {
    color: #ffffff;
    background: #324960;
}

.fl-table tr:nth-child(even) {
    background: #F8F8F8;
}

/* Responsive */

@media (max-width: 767px) {
    .fl-table {
        display: block;
        width: 100%;
    }
    .fl-table thead, .fl-table tbody, .fl-table thead th {
        display: block;
    }
    .fl-table thead th:last-child{
        border-bottom: none;
    }
    .fl-table thead {
        float: left;
    }
    .fl-table tbody {
        width: auto;
        position: relative;
        overflow-x: auto;
    }
    .fl-table td, .fl-table th {
        padding: 20px .625em .625em .625em;
        height: 60px;
        vertical-align: middle;
        box-sizing: border-box;
        overflow-x: hidden;
        overflow-y: auto;
        width: 120px;
        font-size: 13px;
        text-overflow: ellipsis;
    }
    .fl-table thead th {
        text-align: left;
        border-bottom: 1px solid #f7f7f9;
    }
    .fl-table tbody tr {
        display: table-cell;
    }
    .fl-table tbody tr:nth-child(odd) {
        background: none;
    }
    .fl-table tr:nth-child(even) {
        background: transparent;
    }
    .fl-table tr td:nth-child(odd) {
        background: #F8F8F8;
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tr td:nth-child(even) {
        border-right: 1px solid #E6E4E4;
    }
    .fl-table tbody td {
        display: block;
        text-align: center;
    }
}
</style>
