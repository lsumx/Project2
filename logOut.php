<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/18
 * Time: 13:39
 */
session_start();
//unset($_SESSION['footprint']);
unset($_SESSION['name']);
unset($_SESSION['userID']);
//setcookie("trace","",-1);
//$_SESSION = array();
//if(isset($_COOKIE[session_name()])){
//    setcookie(session_name(),'',time()-42000,'/');
//}
$num = $_SESSION['numFootprint'];
$s = $_SESSION[$num."B"];
header("Location:{$_SERVER['HTTP_REFERER']}");
?>