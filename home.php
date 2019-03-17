<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/7
 * Time: 19:14
 */
session_start();
include 'MessageShow.php';
$numFootprint = $_SESSION['numFootprint'] = 1;
$_SESSION["position"] = "home.php";
$_SESSION["$numFootprint" . "A"] = "<a href='home.php'>首页></a>";
$mysqli = new mysqli('localhost', 'root', '123456', 'art_store');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Art Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="js/jquery-3.3.1.js"></script>
</head>
<body>
<header><?php include 'header.php'; ?></header>
<?php include 'register.php'; ?>
<?php include 'log.php'; ?>


<!--轮播-->
<div id="demo" class="carousel slide" data-ride="carousel">

    <!-- 指示符 -->
    <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li>
    </ul>

    <!-- 轮播图片 -->
    <div class="carousel-inner">
        <?php
        $sql = 'SELECT * FROM artworks where orderID is null order by view DESC LIMIT 1';
        mysqli_select_db($mysqli, 'art_store');
        $retval = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
            $cut = mb_strimwidth($row['description'], 0, 350, '...');
            $content = '<div class="carousel-item active"><a href="detail.php?artworkID=' . $row['artworkID'] . '"><img src="resources/img/' . $row['imageFileName'] . '"></a><div class="carousel-caption"><h3>' . $row['title'] . '</h3><p>' . $cut . '         
          </p></div></div>';
            echo $content;
        }
        $sql = 'SELECT * FROM artworks where orderID is null order by view DESC LIMIT 2,2';
        mysqli_select_db($mysqli, 'art_store');
        $retval = mysqli_query($mysqli, $sql);
        while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
            $cut = mb_strimwidth($row['description'], 0, 350, '...');
            $content = '<div class="carousel-item"><a href="detail.php?artworkID=' . $row['artworkID'] . '"><img src="resources/img/' . $row['imageFileName'] . '"></a><div class="carousel-caption"><h3>' . $row['title'] . '</h3><p>' . $cut . '</p></div></div>';
            echo $content;
        }
        ?>
    </div>

    <!--        <div class="carousel-item">-->
    <!--            <img src="resources/img/37.jpg">-->
    <!--            <div class="carousel-caption">-->
    <!--                <h3>第二张图片描述标题</h3>-->
    <!--                <p>描述文字!</p>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--        <div class="carousel-item">-->
    <!--            <img src="resources/img/37.jpg">-->
    <!--            <div class="carousel-caption">-->
    <!--                <h3>第三张图片描述标题</h3>-->
    <!--                <p>描述文字!</p>-->
    <!--            </div>-->
    <!--        </div>-->

    <!-- 左右切换按钮 -->
    <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>
<br>
<div class="row">

    <?php
    $sql = 'SELECT * FROM artworks where orderID is null order by timeReleased DESC LIMIT 3';
    mysqli_select_db($mysqli, 'pj2');
    $mysqli->query('SET NAMES utf8');
    $retval = mysqli_query($mysqli, $sql);
    while ($row = mysqli_fetch_assoc($retval)) {
        $cut = mb_strimwidth($row['description'], 0, 350, '...');
        $content = ' <div class="col col-md-4 text-center"><a href="detail.php?artworkID=' . $row['artworkID'] . '"><img class="img-circle" id="img"  src="resources/img/' . $row['imageFileName'] . '"></a><h3>' . $row['title'] . '</h3><p>' . $cut . '</p><P><a href="detail.php?artworkID=' . $row['artworkID'] . '"><button type="button" class="btn btn-primary">view more</button></a></P></div>';
        echo $content;
    }
    ?>

</div>
<footer class="text-center">Produced and maintained by Sun at 2018.3.27</footer>

<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>
