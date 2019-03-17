<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/19
 * Time: 10:57
 */
//echo '<script>alert(1)</script>';
session_start();
$conn = @mysqli_connect("localhost","root","123456",'art_store');
if (!$conn){
    die("连接数据库失败：" . mysqli_error());
}
mysqli_select_db($conn,"art_store" );
//字符转换，读库
mysqli_query($conn,"set names utf-8");
//写库
$sql = "select * from users where userID ={$_SESSION['userID']}";
$result = $conn->query($sql);
$row =$result->fetch_assoc();
$premon =$row['balance'];
$addMon =$_GET['money'];
$newMon =intval($premon)+intval($addMon);
$add ="update users set balance ={$newMon} where userID ='{$_SESSION['userID']}'";
$result2 =$conn->query($add);
echo $newMon;
?>