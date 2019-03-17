<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/11
 * Time: 12:09
 */

session_start();
$numFootprint =++$_SESSION['numFootprint'];
for ($i =0;$i<$numFootprint;$i++){
    if ($_SESSION["$i"."A"]=="<a href='search.php'>搜索></a>") {
        $_SESSION['numFootprint'] =$i;
        $numFootprint=$_SESSION['numFootprint'];
    }
}
$_SESSION["$numFootprint"."A"]="<a href='search.php'></a>";
include 'header.php';
$_mysqli = mysqli_connect('localhost', 'root', '123456', 'art_store');
mysqli_select_db($_mysqli, 'art_store');
$_mysqli->query('SET NAMES utf8');
$viewNumber =$artwork['view'];
$newViewNumber =intval($viewNumber)+1;//更新访问数据
mysqli_query($_mysqli,"update artworks set artworks.view= {$newViewNumber} WHERE  artworkID = '{$artworkID}'");//更新数据库中的访问量
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search</title>
    <link rel="stylesheet" href="css/search.css">
    <link rel="stylesheet" href="css/header.css">
<!--    <link rel="stylesheet" href="home.css">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<header><?php include_once 'header.php';?><nav id="nav">
        <a href="home.php">主页</a>
        <a href="search.php">搜索</a>
        <a href="detail.php?artworkID=408">详情</a>
        <a href="upload.php">发布艺术品</a>
    </nav>
    <div>
        <p>footprint</p>
        <?php
        for ($i =1;$i<= $numFootprint;$i++){
            $temp =$_SESSION["$i"."A"];
            echo "$temp";
        }
        ?>
    </div>
</header>
<?php include 'register.php';?>
<?php include 'log.php';?>
<form action="search.php" method="get">
    <p>搜索方式：
        <input type="text" name="artist" title="" placeholder="艺术家">
        <input type="text" name="title" placeholder="作品名称">
        <input type="text" name="description" placeholder="作品描述">
    </p>
    <p>排序方式：热度
        <input type="radio" name="radio" value="1" title="" checked>价格
        <input type="radio" name="radio" value="2" title="">
        <button id="button" type="submit">search</button>
    </p>
</form>
<?php
if (isset($_GET['radio']) && $_GET['radio'] !== "") {
    $artist = $_GET['artist'];
    $title = $_GET['title'];
    $description = $_GET['description'];
    $sort =$_GET['radio'];
    $sql = 'SELECT * FROM artworks WHERE artworks.orderID IS NULL ';
    if ($artist!='')
        $sql.="and artist like '%$artist%' ";
    if ($title!='')
        $sql.="and title like '%$title%' ";
    if ($description!='')
        $sql.="and description like '%$description%' ";
    if ($sort == 1) {
        $sql.= ' order by view DESC';
    }
    if ($sort == 2) {
        $sql.= ' order by price';
    }
    $_SESSION["searchsql"] = $sql;
    //$sql.=' limit 9';
   // echo $sql;
    $result = mysqli_query($_mysqli, $sql);//搜索出来的表

    $goodsNum = mysqli_num_rows($result);
    if($goodsNum % 9 != 0){
        $pagesNum = intval($goodsNum /9)+1;
    }else{
        $pagesNum = intval($goodsNum/9);
    }
   //echo"<script>alert($pagesNum)</script>";
    if (mysqli_num_rows($result) == 0) {
        echo '<p>搜索为空</p>';//返回结果集中的行数
    }
    else {
        echo '<div id="content"><table >';
        for ($i = 0; $i < 3; $i++) {
            echo '<tr>';
            for ($j = 0; $j < 3; $j++) {
                $row = $result->fetch_assoc();
                if ($row) {
                    ?>
                    <td>
                            <img src="resources/img/<?php echo $row['imageFileName'];?>">
                        <p><?php echo $row['title'];?></p><p> By <?php echo $row['artist'];?></p>
                        <span> <?php
                            $cut = mb_strimwidth($row['description'],0,250,'...');
                            echo $cut;
                            ?>
                        </span><br>
                        <button class="btn1"><a href="detail.php?artworkID=<?php echo $row['artworkID'];?>">查看</a></button>
                        <button class="btn2"><a>热度 <?php echo $row['view'];?></a></button>
                    </td>


<?php } }echo '</tr>'; ?>

        <?php }

        echo "</table><ul class=\"pagination\">
    <li class=\"page-item\"><a class=\"page-link\" onclick=\"changePage(1)\">Previous</a></li>";

    for($n = 1; $n <= $pagesNum; $n++){
        echo "<li class=\"page-item\"><a class=\"page-link\" onclick=\"changePage(this.innerText)\">".$n."</a></li>";
    };

   echo "<li class=\"page-item\"><a class=\"page-link\" onclick=\"changePage(2)\">Next</a></li>
</ul>";
                echo '</div>';}}?>

<script src="js/changePage.js" type="text/javascript"></script>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<!--<ul class="pagination">-->
<!--    <li class="page-item"><a class="page-link" href="#5">Previous</a></li>-->
<!--    <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--    <li class="page-item active"><a class="page-link" href="#">2</a></li>-->
<!--    <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--    <li class="page-item"><a class="page-link" href="#">Next</a></li>-->
<!--</ul>-->
