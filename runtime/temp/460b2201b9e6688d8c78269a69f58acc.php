<?php /*a:1:{s:52:"/www/wwwroot/aeon.333309.xyz/view/simadmin/xgmm.html";i:1666293820;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>修改密码</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
</head>
<body>


  <div class="layui-fluid" id="component-tabs">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md6">
        <div class="layui-card">
          <div class="layui-card-header">
            修改登陆密码
          </div>
          <div class="layui-card-body">
            <div class="layui-form" lay-filter="">
              <div class="layui-form-item">
                <label class="layui-form-label">原始密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="oldPassword" lay-verify="required" lay-vertype="tips" class="layui-input" autocomplete="off">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="password" lay-verify="required" lay-vertype="tips" class="layui-input" autocomplete="off">
                </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">确认新密码</label>
                <div class="layui-input-inline">
                  <input type="password" name="password2" lay-verify="required" lay-vertype="tips" class="layui-input" autocomplete="off">
                </div>
              </div>
              <div class="layui-form-item">
                <div class="layui-input-block">
                  <button class="layui-btn" lay-submit="" lay-filter="updatePass">确认修改登陆密码</button>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div><div class="layui-col-md6">
      <div class="layui-card">
        <div class="layui-card-header">
          修改清空密码
        </div>
        <div class="layui-card-body">
          <div class="layui-form" lay-filter="">
            <div class="layui-form-item">
              <label class="layui-form-label">原始密码</label>
              <div class="layui-input-inline">
                <input type="password" name="oldPassword_qk" lay-verify="required" lay-vertype="tips" class="layui-input" autocomplete="off">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">新密码</label>
              <div class="layui-input-inline">
                <input type="password" name="password_qk" lay-verify="required" lay-vertype="tips" class="layui-input" autocomplete="off">
              </div>
            </div>
            <div class="layui-form-item">
              <label class="layui-form-label">确认新密码</label>
              <div class="layui-input-inline">
                <input type="password" name="password2_qk" lay-verify="required" lay-vertype="tips" class="layui-input" autocomplete="off">
              </div>
            </div>
            <div class="layui-form-item">
              <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="updatePass_qk">确认修改清空密码</button>
              </div>
            </div>
          </div>
        </div>
      </div>
   </div>
  </div>

  <script src="../layuiadmin/layui/layui.js"></script>
  <script>
    layui.use(['form','jquery','element', 'table','util'], function(){
      var $ = layui.$,
      table = layui.table,
      element = layui.element,
      form = layui.form;

     
      form.on('submit(updatePass)', function(data){
        $.ajax('/simadmin/xgmm_update', {
          type: 'post',
          data: data.field,
          success: function(d){
            layer.alert(d.msg);
          }
        });
        return false;
      });

      form.on('submit(updatePass_qk)', function(data){
        $.ajax('/simadmin/xgmm_qk_update', {
          type: 'post',
          data: data.field,
          success: function(d){
            layer.alert(d.msg);
          }
        });
        return false;
      });
    });
  </script>
</body>
</html>
