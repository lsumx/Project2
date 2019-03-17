<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/18
 * Time: 13:44
 */
include 'conn.php';
//login
$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];
//file_put_contents("log.txt",$username."\n",FILE_APPEND);
if (isset($_POST['username'])){
    $sql = "select * from art_store.users where users.name='$username' and password='$password' limit 1";
    $check_query = mysqli_query($conn,$sql);
//    file_put_contents(log.txt,$sql,FILE_APPEND);
    if( $row = $check_query->fetch_assoc()) {
        //登录成功

        session_start();
        $_SESSION['name'] = $username;
        $_SESSION['userID'] =$row['userID'];
       $s = $_SESSION['position'];
       // file_put_contents("log.txt",$s."\n",FILE_APPEND);
        header("Location:{$_SERVER['HTTP_REFERER']}");
      //  echo "<script>window.location.href='home.php'</script>";
    }
    $num = $_SESSION['numFootprint'];
    $s = $_SESSION[$num."B"];
    header("Location:{$_SERVER['HTTP_REFERER']}");
 //   echo "<script>window.location.href='home.php'</script>";
}
?>
