<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/16
 * Time: 18:21
 */
$conn = @mysqli_connect("localhost","root","123456",'art_store');
if (!$conn){
    die("连接数据库失败：" . mysqli_error());
}
mysqli_select_db($conn,"art_store" );
//字符转换，读库
mysqli_query($conn,"set names utf-8");
//写库

?>