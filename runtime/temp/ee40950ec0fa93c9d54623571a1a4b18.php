<?php /*a:1:{s:52:"/www/wwwroot/aeon.333309.xyz/view/simadmin/test.html";i:1674144754;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>测试入口</title>
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
          <div class="layui-card-body">
            <a target="_blank" href="/simadmin/test_open" class="layui-btn" lay-submit="" lay-filter="updatePass">开 启 测 试</a>
            <a target="_blank" href="/simadmin/test_close" class="layui-btn layui-btn-danger" lay-submit="" lay-filter="updatePass">关 闭 测 试</a>
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
    });
  </script>
</body>
</html>
