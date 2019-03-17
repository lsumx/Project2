<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/7
 * Time: 19:12
 */
if(empty($_SESSION['name'])){
showNavLef_tourist();
}else{
showNavLef_loged();
}
function showNavLef_tourist(){
    echo '
<div class="hide">
  <div class="row">
  <span class="navbar-brand">Art Store</span><span class="navbar-text">where you find <em>GENIUS</em> and <em>EXTRAORDINARY</em></span>
        <nav class="navbar navbar-expand-sm bg-light navbar-light pull-right">
            <ul class="navbar-nav"><li class="nav-item"><a class="nav-link"  href="home.php">首页</a></li>
            <li class="nav-item"><a class="nav-link" href="search.php">搜索</a></li>
            <li class="nav-item"><a class="nav-link" onclick="displayShowUI(\'reg\')">注册</a></li>
            <li class="nav-item"><a class="nav-link" onclick="displayShowUI(\'log\')">登录</a></li></ul>
        </nav>
    </div>
    </div>
';
}
function showNavLef_loged(){
    echo '
<div class="row">
<nav class="navbar navbar-expand-sm bg-light navbar-light col-md-6">
 <span class="navbar-brand " style="float: left">Art Store</span><span class="navbar-text">where you find <em>GENIUS</em> and <em>EXTRAORDINARY</em></span>
 </nav>
<nav class="navbar navbar-expand-sm bg-light navbar-light pull-right col-md-6">        
<ul class="nav pull-right">
    <li class="nav-item">
        <a href="userInformation.php" class="nav-link right-a"><i class="fa fa-user">'.$_SESSION["name"].'</i> </a>
    </li>
    <li class="nav-item ">
        <a href="shoppingCart.php" class="nav-link right-a"><i class="fa fa-shopping-cart">购物车</i> </a>
    </li>
    <li class="nav-item ">
        <a class="nav-link right-a" href="logOut.php"><i class="fa fa-mail-reply">登出</i></a>
    </li>

    <form class="form-inline navbar-form pull-right">

        <a href="search.php" class="nav-link right-a" ><i class="fa fa-search"></i></a>
    </form>
    </ul>
    </nav>
    </div>
    ';
}
?>
<script src="js/displayAndHide.js"></script>
<script src="js/verification.js"></script>
<script src="js/judge.js"></script>
<script src="js/jquery-3.3.1.js"></script>
