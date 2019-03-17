<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/6
 * Time: 12:22
 */
session_start();
include 'header.php';
include 'MessageShow.php';
$_mysqli = mysqli_connect('localhost','root','123456','art_store');
mysqli_select_db($_mysqli,'pj2');
$_mysqli->query('SET NAMES utf8');
$artworkID =$_GET['artworkID'];
$sql = "SELECT * FROM artworks WHERE artworkID = '{$artworkID}'";
$choose =$_mysqli ->query($sql);
$artwork= $choose-> fetch_assoc();
$numFootprint =++$_SESSION['numFootprint'];
for ($i =0;$i<$numFootprint;$i++) {
    if ($_SESSION["$i" . "A"] == "<a href='detail.php'>详情></a>") {
        $_SESSION['numFootprint'] = $i;
        $numFootprint = $_SESSION['numFootprint'];
    }
}
$_SESSION["$numFootprint"."A"]="<a href='detail.php'>详情></a>";
 $viewNumber =$artwork['view'];
 $newViewNumber =intval($viewNumber)+1;//更新访问数据
mysqli_query($_mysqli,"update artworks set artworks.view= {$newViewNumber} WHERE  artworkID = '{$artworkID}'");//更新数据库中的访问量
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/details.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<header><?php include_once 'header.php';?><nav id="nav"><a href="home.php">主页</a><a href="search.php">搜索</a><a href="detail.php?artworkID=408">详情</a><a href="upload.php">发布艺术品</a></nav>
    <div>
        <p>footprint</p>
        <?php
        for ($i =1;$i<= $numFootprint;$i++){
            $temp =$_SESSION["$i"."A"];
            echo "$temp";
        }
        ?>
    </div></header>
<?php include 'register.php';?>
<?php include 'log.php';?>

        <p class="title"><?php echo $artwork['title'];?></p>
        <p>By <a href="search.php?artist=<?php echo $artwork['artist'];?>&title=&description=&radio=1"><?php echo $artwork['artist'];?></a></p>
        <div class="body_left">
                <div id="img" style="width:386px; height:500px; position:relative; margin-top:30px;margin-right: 30px; float:left;">
                    <img alt="图片" src="resources/img/<?php echo $artwork['imageFileName'];?>" id="img_zoom" width="386" height="500"/></div>  
            <div>
                <?php
                $cut = mb_strimwidth($artwork['description'],0,300,'...');
                echo $cut;?>
                <p id="price">price:$<span><?Php echo $artwork['price'];?></span></p>
                <?php
                   if ($artwork['orderID']==NULL){
                       echo "<button class=\"fa fa-cart-plus\" onclick='addCart( {$artwork['artworkID']})'>Add to Shopping Cart</button>";
                   }else{
                       echo '抱歉，该艺术品已被别的买家抢走了！';
                   }
                ?>
                <table id="details">
                    <tr>
                        <th colspan="2">Product Details</th>
                    </tr>
                    <tr>
                        <td>YearOfWork:</td>
                        <td><?php echo $artwork['yearOfWork'];?></td>
                    </tr>
                    <tr>
                        <td>Genres:</td>
                        <td><?php echo $artwork['genre'];?></td>
                    </tr>
                    <tr>
                        <td>Dimensions:</td>
                        <td><?php echo $artwork['width'];?>cm&times<?php echo $artwork['height'];?>cm</td>
                    </tr>
                    <tr>
                        <td>Heat:</td>
                        <td><?php echo $artwork['view'];?></td>
                    </tr>
                    <tr>
                        <td>State:</td>
                        <td><?php
                            if ($artwork['orderID'] ==null)
                                echo 'unsold';
                            else echo 'sold';
                            ?></td>
                    </tr>
                </table>
            </div> 
        </div>
        <aside>
            <table>
                <tr>
                    <th>流行艺术家</th>
                </tr>
                <tr>
                    <td>Da Vinci</td>
                </tr>
                <tr>
                    <td>Miller</td>
                </tr>
                <tr>
                    <td>Tintoretto</td>
                </tr>
                <tr>
                    <td>Raphael</td>
                </tr>
                <tr>
                    <td>Titian</td>
                </tr>
                <tr>
                    <td>Picasso</td>
                </tr>
            </table>
            <table>
                <th>流行流派</th>
                <tr>
                    <td>Classic</td>
                </tr>
                <tr>
                    <td>Byzantine</td>
                </tr>
                <tr>
                    <td>Impression</td>
                </tr>
                <tr>
                    <td>Eskimo</td>
                </tr>
                <tr>
                    <td>Florence</td>
                </tr>
            </table>
        </aside>
<script src="js/button.js"></script>
<script src="header.js"></script>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
