<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/20
 * Time: 16:00
 */
session_start();
include 'conn.php';
$sql ="INSERT  INTO carts(artworkID,userID) values ({$_GET['artworkID']},{$_SESSION['userID']})";
$conn->query($sql);
//file_put_contents('log.txt',$sql);
?>