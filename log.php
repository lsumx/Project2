<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/18
 * Time: 13:50
 */
include 'conn.php';
include 'MessageShow.php';
//?>

<link rel="stylesheet" href="css/login.css" >
<link rel="stylesheet" href="css/form.css">

<div style="display: none" id="log"class="white_content">
    <div class="close"><a href="javascript:void(0)" onclick="displayHideUI('log')" class="fa fa-close"></a></div>
    <fieldset>
        <legend>用户登录</legend>
        <form name="LoginForm" method="post" action="session.php">
            <p>
                <label for="username" class="label">用户名:</label>
                <input  name="username" type="text" class="input" required="required"/>
            </p>
            <p>
                <label for="password" class="label">密 码:</label>
                <input  name="password" type="password" class="input" required="required"/>
            </p>
            </p>
            <p onload="createCode2()">
                验证码：<input type="text" id="input2" required="required"><input type="button" id="code2" onclick="createCode2()" style="width: 60px; margin-left: 5px;" title="点击更换验证码"/>
                <input type="button" value="验证" style="width: 60px; margin-left: 5px;padding: 0" onclick="validate2()">
            </p>
            <p>
                <input id="send" type="submit" name="submit" value="  确 定  " class="left" onclick="showMessage('success!')"/>
            </p>
        </form>
    </fieldset>
</div>
<div class="black_overlay"></div>
<!--<script src="js/displayAndHide.js"></script>-->
<script src="js/displayAndHide.js"></script>
<script src="js/judge.js"></script>
<script src="js/verification.js"></script>
<script src="js/jquery-3.3.1.js"></script>