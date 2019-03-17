<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/13
 * Time: 18:37
 */
session_start();
include 'MessageShow.php';
$con = new mysqli('localhost', 'root', '123456', 'art_store');
//mysqli_select_db($con, 'art_store');
$con->query('SET NAMES utf8');
$numFootprint = ++$_SESSION['numFootprint'];
for ($i = 0; $i < $numFootprint; $i++) {
    if ($_SESSION["$i" . "A"] == "<a href='shoppingCart.php'>购物车></a>") {
        $_SESSION['numFootprint'] = $i;
        $numFootprint = $_SESSION['numFootprint'];
    }
}
$_SESSION["$numFootprint" . "A"] = "<a href='shoppingCart.php'>购物车></a>";


if (isset($_SESSION['userID'])) {


    if (isset($_GET['checkOut'])) {
        $name = $_SESSION['name'];
        $userID = $_SESSION['userID'];
        $sql = "SELECT * FROM artworks,carts WHERE carts.userID = $userID and carts.artworkID =artworks.artworkID";
//    $result = mysqli_query($con,$sql);
//    $row = mysqli_fetch_assoc($result);
        $result = $con->query($sql);
        $sum = 0;
        while ($rows = $result->fetch_assoc()) {
            $sum += $rows["price"];
        }
        $sql3 = "select * from users where userID={$_SESSION['userID']}";
        $result3 = $con->query($sql3);
        $row3 = $result3->fetch_assoc();
        $status = "";
        if ($row3['balance'] < $sum) {
            $status = 'fail';
        } else {
            $sql = "SELECT * FROM carts WHERE userID = $userID";
            $result = mysqli_query($con, $sql);
            $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($items as $item) {


//          item information;
                $artworkID = $item['artworkID'];
                $price = $item['price'];
                $title = $item['title'];
                $releaseID = $item['ownerID'];


//          remove balance from user account
                $sql = "UPDATE artworks SET ownerID = '$userID' WHERE artworkID =$artworkID ";
                mysqli_query($con, $sql);
                $sql = "SELECT balance FROM users WHERE userID = '$userID'";
                $result = mysqli_query($con, $sql);
                $balance = $result->fetch_assoc();
                $balance = $balance['balance'];
                $balance = $balance - $price;
                $sql = "UPDATE users SET balance = $balance WHERE userID='$userID'";
                mysqli_query($con, $sql);


//          add balance to the owner user account
                $sql = "SELECT balance FROM users WHERE userID = '$releaseID'";
                $result = mysqli_query($con, $sql);
                $balance = $result->fetch_assoc();
                $balance = $balance['balance'];
                $balance += $price;
                $sql = "UPDATE users SET balance = $balance WHERE userID='$releaseID'";
                mysqli_query($con, $sql);


//        remove the shopping cart item.
                $sql = "DELETE FROM carts WHERE artworkID=$artworkID AND userID = '$userID'";
                mysqli_query($con, $sql);


//          write order information
                $sql = "INSERT INTO orders (ownerID) VALUES ($userID)";
                mysqli_query($con, $sql);
                $sql = "SELECT orderID FROM orders WHERE ownerID = $userID ORDER BY timeCreated DESC LIMIT 1";
                $result4 = mysqli_query($con, $sql);
                $row4 = $result4->fetch_assoc();
                $orderID = $row4['orderID'];
                $sql = "UPDATE artworks SET orderID = $orderID where artworkID={$artworkID}";
                mysqli_query($con, $sql);
            }
            $checkOutResult = 'success';
        }
    }
    elseif (isset($_GET['delete'])){
        $sql="delete from carts where cartID ={$_GET['delete']}";
        mysqli_query($con,$sql);
    }


    $name = $_SESSION['name'];
    $userID = $_SESSION['userID'];
    $sql = "SELECT * FROM artworks,carts WHERE carts.userID = $userID and carts.artworkID =artworks.artworkID";
//    $result = mysqli_query($con,$sql);
//    $row = mysqli_fetch_assoc($result);
    $result = $con->query($sql);
    $sum = 0;
} else {
    header("refresh:3;url=home.php");
    echo "<h1>请您先登录或注册，3秒后跳转到首页。</h1>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/shoppingCart.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="js/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<header>
    <?php
    include_once 'header.php';
    ?>
    <nav id="nav"><a href="home.php">主页</a><a href="search.php">搜索</a><a href="detail.php?artworkID=408">详情</a><a href="upload.php">发布艺术品</a>
    </nav>
    <div>
        <p>footprint</p>
        <?php
        for ($i = 1; $i <= $numFootprint; $i++) {
            $temp = $_SESSION["$i" . "A"];
            echo "$temp";
        }
        ?>
    </div>
    <p id="p1">购物车</p>
    <?php
    if ($status === 'fail') {
        echo <<<div
        <p>余额不足，支付失败。</p>
div;

    }

    ?>
    <div id="#div_big">
        <table class="div_small">
            <?php
            $sum = 0;
            while ($rows = $result->fetch_assoc()) {
                $sum += $rows["price"];
                echo <<<art
 <tr>
                <td>
                    <a href="detail.php?artworkID={$rows['artworkID']}">
                        <img class="img" src="resources/img/{$rows['imageFileName']}">
                    </a>
                    <span class="p1">{$rows['title']}</span><br>
                    <span class="p2">By {$rows['artist']}</span><br>
                    <span class="p3">{$rows['description']}</span><br>
                    <button class="fa fa-star btn1">￥{$rows['price']}</button>
                    <button class="btn2"><a href="shoppingCart.php?delete={$rows['cartID']}"  class="fa fa-sign-out" onclick="showMessage("delete successfully!")" >delete</a></button>
                    </td>
            </tr>
art;
            }
            ?>
        </table>
        <a class="fa fa-mail-forward btn3" id="totalMoney" href="shoppingCart.php?checkOut" onclick="showMessage("pay successfully!")">结款：<?php echo $sum; ?></a>
    </div>
    <script src="js/shopping_cart.js"></script>

    <script src="js/sAlert.js"></script>

    <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
</body>
</html>


