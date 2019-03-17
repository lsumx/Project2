<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/15
 * Time: 23:02
 */
session_start();
include 'header.php';
$_mysqli = mysqli_connect('localhost', 'root', '123456', 'art_store');
mysqli_select_db($_mysqli, 'art_store');
$_mysqli->query('SET NAMES utf8');
if (!isset($_SESSION['userID'])) {
    header("location:home.php");
}
$numFootprint = ++$_SESSION['numFootprint'];
for ($i = 0; $i < $numFootprint; $i++) {
    if ($_SESSION["$i" . "A"] == "<a href='userInformation.php'>用户信息></a>") {
        $_SESSION['numFootprint'] = $i;
        $numFootprint = $_SESSION['numFootprint'];
    }
}
$_SESSION["$numFootprint" . "A"] = "<a href='userInformation.php'>用户信息></a>";
$sql = "SELECT * FROM art_store.users WHERE userID ='{$_SESSION['userID']}'";
$result = $_mysqli->query($sql);
$row = $result->fetch_assoc();
set_time_limit(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Information</title>
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/userInformation.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<header>
    <nav id="nav"><a href="home.php">主页</a><a href="search.php">搜索</a><a href="detail.php?artworkID=408">详情</a><a
                href="upload.php">发布艺术品</a></nav>
    <div>
        <p>footprint</p>
        <?php
        for ($i = 1; $i <= $numFootprint; $i++) {
            $temp = $_SESSION["$i" . "A"];
            echo "$temp";
        }
        ?>
    </div>
</header>
<body>
<div class="div1">
    用户：<?php echo $row['name']; ?><br>
    电话：<?php echo $row['tel']; ?><br>
    邮箱：<?php echo $row['email']; ?><br>
    地址：<?php echo $row['address']; ?><br>
    余额： <span id="money"><?php echo $row['balance']; ?></span><br>
    <button onclick="displayShowUI('display');addMoney()">充值信仰</button>
</div>


<div class="div2">我上传的艺术品
    <table>
        <tr>
            <?php
            $result3 = mysqli_query($_mysqli, "SELECT * FROM artworks WHERE ownerID='{$_SESSION['userID']}' and orderID is null order by timeReleased DESC ");
            //            $row3 = $result3->fetch_assoc();
            while ($row3 = $result3->fetch_assoc()) {
                echo <<<upload
                <tr><td><img src="resources/img/{$row3['imageFileName']}" width="300px"></td>
                 <td><span class="p1">Title: <a href="detail.php?artworkID={$row3['artworkID']}">{$row3['title']}</a></span><br></td>
                <td><span>Time Released: {$row3['timeReleased']}</span></td>
                <td><a href="modify.php?artworkID={$row3['artworkID']}">修改发布</a></td></tr>
upload;
            }
            ?>


        </tr>
    </table>
</div>
<!--bought-->
<?php
$sql2 = "SELECT * FROM artworks WHERE ownerID ='{$_SESSION['userID']}'";
$result2 = $_mysqli->query($sql2);

?>
<div class="div3"><p>我购买的艺术品</p>
    <table>
        <?php
        while ($row2 = $result2->fetch_assoc()) {
            echo <<<buy

<tr><td>订单编号：{$row2['orderID']}</td></tr>
            <tr><td>商品名称：{$row2['title']}</td></tr>
            <tr><td>订单时间：{$row2['timeReleased']}</td></tr>
            <tr><td>订单金额：￥{$row2['price']}<hr></td></tr>
buy;

        }
        ?>
    </table>
</div>
<?php
$soldForm = mysqli_query($_mysqli, "select * from artworks where ownerID ={$_SESSION['userID']} and orderID is not null order by timeReleased desc ");
?>
<div class="div4">
    <p>我卖出的艺术品</p>
    <table>
        <?php
        while ($soldGoods = $soldForm->fetch_assoc()) {
            $mySoldOrderForm = mysqli_query($_mysqli, "select * FROM orders WHERE orderID= '{$soldGoods["orderID"]}'");//1行
            $myPayerIDrow = $mySoldOrderForm->fetch_assoc();
            $myPayerInforForm = mysqli_query($_mysqli, "select * FROM users WHERE userID = '{$myPayerIDrow["ownerID"]}'");
            $myPayerInforrow = $myPayerInforForm->fetch_assoc();
            echo <<<sold
 <tr>
 <td width="15%"><img src="resources/img/{$soldGoods['imageFileName']}" width="100%"></td>
                                <td width="35%" class="text-center"><a href="detail.php?artworkID={$soldGoods["artworkID"]}" style="text-decoration: none;font-weight: bolder" id="link">{$soldGoods["title"]}</a></td>
                                <td width="50%" >
                                    <table>
                                    <tr><td>卖出时间:  {$myPayerIDrow["timeCreated"]}</td></tr>
                                    <tr><td>成交价格： {$soldGoods["price"]}</td></tr>
                                    <tr><td>购买人用户名： {$myPayerInforrow["name"]}</td></tr>
                                    <tr><td>购买人邮箱： {$myPayerInforrow["email"]}</td></tr>
                                    <tr><td>购买人电话： {$myPayerInforrow["tel"]}</td></tr>
                                    <tr><td>购买人地址： {$myPayerInforrow["address"]}</td></tr>
                                    </table>
                                </td>
        </tr>
sold;

        }
        ?>

    </table>
</div>
<div id="display" class="white_content" style="display: none">
    <div class="close"><a href="javascript:void(0)" onclick="displayHideUI('display')" class="fa fa-close"></a></div>
    <form method="post" class="form" id="formMoney">
        <p class="title">信仰充值</p>
        <div class="box" id="box">
            <div class="amount">
                <input type="text" class="price fa fa-cny" id="price" placeholder="请输入充值金额：" min="0" max="1000000">
            </div>
            <div class="btn" id="submit">
                <p onclick="addMoney();">快速充值</p>
            </div>
        </div>
    </form>
</div>
<div class="black_overlay"></div>
<script src="js/button.js" type="text/javascript"></script>
<script src="js/displayAndHide.js"></script>
<script src="js/shopping_cart.js"></script>
<script src="js/jquery-3.3.1.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
</body>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</html>