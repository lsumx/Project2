<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/20
 * Time: 14:55
 */
session_start();
include 'conn.php';
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$address = $_POST['address'];
$userID = $_SESSION['$userID'];
$sql = mysqli_query($conn, "select count(*) from art_store.users where userID = '$userID'");
$userNum = mysqli_fetch_assoc($sql);
$userNum = $userNum['count(*)'];
$userID = $userNum + 1;
if (mysqli_fetch_array($sql)) {
    echo '错误：用户名 ', $username, ' 已存在。';

}
//写入数据
if (isset($_POST['username'])) {
    echo "line23";
//$password = MD5($password);
    $sql = "INSERT INTO art_store.users(users.name,users.email,users.password,tel,address)VALUES('$username','$email','$password','$tel','$address')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['name'] = $username;
        $_SESSION['userID'] = $userID;
        $s = $_SESSION['position'];
        // file_put_contents("log.txt",$s."\n",FILE_APPEND);
        header("Location:{$_SERVER['HTTP_REFERER']}");
        //  echo "<script>window.location.href='home.php'</script>";
    }
    $num = $_SESSION['numFootprint'];
    $s = $_SESSION[$num . "B"];
    header("Location:{$_SERVER['HTTP_REFERER']}");
//   echo "<script>window.location.href='home.php'</script>";
}

?>

