<?php /*a:1:{s:50:"/www/wwwroot/aeon.333309.xyz/view/simadmin/ip.html";i:1666301034;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>访问统计</title>
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
            <table class="layui-table" style="margin: 0px 0px 15px 0px !important;">
              <tr><td>今日IP：<?php echo htmlentities($today); ?></td></tr>
              <tr><td>历史IP：<?php echo htmlentities($sum); ?></td></tr>
            </table>
            <button id="qk_ip" class="layui-btn layui-btn-danger" lay-submit="" lay-filter="updatePass"><i class="layui-icon layui-icon-delete"></i>清空统计数据</button>
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
      $('#qk_ip').click(function() {
        layer.prompt({
          formType: 1,
          title: '请输入清空密码',
        }, 
        function(value, index, elem){
          layer.close(index);
          $.ajax('/simadmin/qk_ip', {
            type: 'post',
            data:{
              p:value
            },
            success: function(d){
              if(d.code==200){
                layer.msg('已清空统计数据', {icon: 1, time: 1000});
              }else if(d.code==500){
                layer.msg('密码错误', {icon: 2, time: 1000});
              }
              else{
                layer.msg('系统错误', {icon: 2, time: 1000});
              }
            }
          });
        });
      });
    });
  </script>
</body>
</html>
