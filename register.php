<?php
/**
 * Created by PhpStorm.
 * User: sunmeng
 * Date: 2018/6/18
 * Time: 13:52
 */
include 'conn.php';
include 'MessageShow.php';

?>
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="css/form.css">
<div id="reg" style="display: none" class="white_content">
    <div class="close"><a href="javascript:void(0)"onclick="displayHideUI('reg')" class="fa fa-close"></a></div>
<fieldset >
    <legend>用户注册</legend>
    <form name="form" method="post" action="reg.php">
        <p>
            <label for="username" class="label">用户名:</label>
            <input id="username" name="username" type="text" class="input" required="required" />
            <span>(必填，支持字母、数字)</span>
        </p>
        <p>
            <label for="password" class="label">密 码:</label>
            <input id="password" name="password" type="password" class="input" required="required"/>
            <span>(必填，不得少于6位)</span>
        </p>
        <p>
            <label for="repass" class="label">重复密码:</label>
            <input id="repass" name="repass" type="password" class="input" required="required"/>
        </p>
        <p>
            <label for="email" class="label">电子邮箱:</label>
            <input id="email" name="email" type="email" class="input" required="required"/>
            <span>(必填)</span>
        </p>
        <p>
            <label for="tel" class="label">电话:</label>
            <input id="tel" name="tel" type="tel" class="input" required="required"/>
            <span>(必填)</span>
        </p>
        <p>
            <label for="address" class="label">地址：</label>
            <input id="address" name="address" type="text" class="input" required="required"/>
            <span>(必填)</span>
        </p>
        <p onload="createCode()">
            验证码：<input type="text" id="input" required="required"><input type="button" id="code" onclick="createCode()" style="width: 60px; margin-left: 5px;" title="点击更换验证码"/>
            <input type="button" value="验证"style="width: 60px; margin-left: 5px;padding: 0" onclick="validate()">
        </p>
        <p>
            <input  id="bt" type="submit" name="submit" value="  提交注册  " class="left" onclick="showMessage("success!")" />
        </p>
    </form>
</fieldset>
</div>
<div class="black_overlay"></div>
<script src="js/verification.js"></script>
<script src="js/displayAndHide.js"></script>
<script src="js/jquery-3.3.1.js"></script>
<script src="js/judge.js"></script>