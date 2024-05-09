<?php /*a:1:{s:53:"/www/wwwroot/aeon.333309.xyz/view/simlogin/index.html";i:1666205072;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>管理登录</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">
  <link rel="stylesheet" href="/layuiadmin/style/login.css" media="all">
</head>
<body>

  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h2>管理登录</h2>
        <p>—— ADMIN ——</p>
      </div>
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
          <input type="text" name="username" id="LAY-user-login-username" lay-verify="required" placeholder="用户名" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
          <input type="password" name="password" id="LAY-user-login-password" lay-verify="required" placeholder="密码" class="layui-input">
        </div>
        <div class="layui-form-item">
          <button class="layui-btn layui-btn-fluid" lay-submit lay-filter="login-submit">登 入</button>
        </div>
      </div>
    </div>
    
    
  </div>

  <script src="/layuiadmin/layui/layui.js"></script>  
  <script>
    layui.use(['form','jquery','element', 'table','util'], function(){
      var $ = layui.$,
      form = layui.form
      form.on('submit(login-submit)', function(data){
        $.ajax('/simlogin/login', {
            type: 'post',
            data: data.field,
            success: function(d){
            if(d.code==200){
              location.href = "/simadmin";
            }else{
              layer.alert(d.msg);
            }
          }
        });
        return false;
      });
    });
  </script>
</body>
</html>