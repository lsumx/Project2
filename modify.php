<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/19
 * Time: 11:06
 */
session_start();
include 'conn.php';
$conn->query("set names utf8");
$userID =$_SESSION['userID'];
if (!isset($_SESSION['name'])) {
    header("refresh:3;url=home.php");
    echo "<h1>请您先登录或注册，3秒后跳转到首页。</h1>";
    exit;
}
$numFootprint = ++$_SESSION['numFootprint'];
for ($i = 0; $i < $numFootprint; $i++) {
    if ($_SESSION["$i" . "A"] == "<a href='modify.php'>modify></a>") {
        $_SESSION['numFootprint'] = $i;
        $numFootprint = $_SESSION['numFootprint'];
    }
}
$_SESSION["$numFootprint" . "A"] = "<a href='modify.php'>modify></a>";




if (isset($_POST['title'])) {
//    $connection = mysqli_connect('localhost','root','123456','art_store');
    $conn->query("SET NAMES utf8");
    $error = mysqli_connect_error();
    if ($error != null) {
        $output = "<p>Unable to connect to database<p>" . $error;
        exit($output);
    }
    $title = $_POST['title'];
    $title = str_replace("'", "\'", $title);
    $author = $_POST['artist'];
    $author = str_replace("'", "\'", $author);
    $description = $_POST['description'];
    $description = str_replace("'", "\'", $description);
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $price = $_POST['price'];
    $fileName = time() . ".jpg";
    if (isset($_SESSION['userID'])) {
        $sql = "update artworks set title ='$title', artist='$author', description='$description', yearOfWork='$year',genre ='$genre',width='$width',height='$length',price='$price',ownerID='$userID',imageFileName='$fileName' where artworkID ={$artworkID}";
        $conn->query($sql);
        $fileToMove = $_FILES['file']['tmp_name'];
        $destination = "resources/img/" . $fileName;
        if (mysqli_query($conn, $sql))
            if (file_exists($destination)){
                echo $fileToMove;
            }
            else if(move_uploaded_file($fileToMove, $destination)) {
        $status = 'success';
    }
            else $status = 'publish failed';
    }
}elseif (isset($_GET['artworkID'])){
    $artworkID =$_GET['artworkID'];
    $sql = "SELECT * FROM artworks WHERE artworkID = {$artworkID}";
    $choose =$conn->query($sql);
    $artwork= $choose-> fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modify</title>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<header><?php
    include_once 'header.php';
    ?>
    <nav id="nav">
        <a href="home.php">主页</a>
        <a href="search.php">搜索</a>
        <a href="detail.php">详情</a>
        <a href="upload.php">发布艺术品</a>
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
</header>
<form method="post" enctype="multipart/form-data" action="modify.php">
    <fieldset class="form-group">

        <div class="container">
            <label for="picture"></label>
            <input class="form-control" type="file" id="picture" name="file" required="required" value="<?php echo $artwork['imageFileName']?>">
            <img width="400px" id="preview" src="resources/img/<?php echo $artwork['imageFileName']?>">
        </div>
    </fieldset>
    <fieldset class="form-group">
        <div class="container">
            <label for="title">Painting title</label>
            <input type="text" class="form-control" id="title" value="<?php echo $artwork['title']?>" name="title"
                   required="required">
        </div>
    </fieldset>
    <fieldset class="form-group">
        <div class="container">
            <label for="artist">Artist</label>
            <input type="text" class="form-control" id="artist" value="<?php echo $artwork['artist']?>" name="artist"
                   required="required">
        </div>
    </fieldset>
    <fieldset class="form-group">
        <div class="container">
            <label for="description">Description</label>
            <textarea class="form-control" id="title"  name="description"
                      required="required"><?php echo $artwork['description']?></textarea>
        </div>
    </fieldset>
    <fieldset class="form-group">
        <div class="container">
            <label for="year">Year Of Work</label>
            <input type="number" class="form-control" id="year" value="<?php echo $artwork['yearOfWork']?>" name="year"
                   required="required">
        </div>
    </fieldset>
    <fieldset class="form-group">
        <div class="container">
            <label for="genre">Genre</label>
            <input type="text" class="form-control" id="genre" value="<?php echo $artwork['genre']?>" name="genre"
                   required="required">
        </div>
    </fieldset>
    <fieldset class="form-group">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <label for="exampleInputLength">Length</label>
                    <input type="number" class="form-control" id="inputLength" name="length" min="1"
                           value="<?php echo $artwork['height']?>" required="required">
                </div>
                <div class="col-md-6">
                    <label for="exampleInputWidth">Width</label>
                    <input type="number" class="form-control" id="inputWidth" name="width" min="1"
                           value="<?php echo $artwork['width']?>" required="required">
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset class="form-group">
        <div class="container">
            <label for="exampleInputPrice">Price $</label>
            <input type="number" class="form-control" id="inputPrice" min="1" name="price"
                   value="<?php echo $artwork['price']?>" required="required">
        </div>
    </fieldset>

    <div class="container">
        <button type="submit" class="btn btn-primary">Submit</button>
</form>
<!--<script src="upload.js"></script>-->
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>


<script>
    function imagePreview() {
        let uploadElement = document.getElementById('picture');
        let previewImage = document.getElementById('preview');
        previewImage.src = window.URL.createObjectURL(uploadElement.files[0]);
    }
</script>


<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>