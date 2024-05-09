<?php /*a:1:{s:53:"/www/wwwroot/aeon.333309.xyz/view/simadmin/index.html";i:1674144668;}*/ ?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>首页</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
  <link rel="stylesheet" href="../layuiadmin/style/admin.css" media="all">
  
  <script>
  /^http(s*):\/\//.test(location.href) || alert('请先部署到 localhost 下再访问');
  </script>
</head>
<body class="layui-layout-body">
  
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
        </ul>
      </div>
      
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="/simadmin/sqlb">
            <span>ADMIN</span>
          </div>
          
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
            <li data-name="sqlb" class="layui-nav-item layui-nav-itemed layui-this">
              <a lay-href="/simadmin/sqlb" lay-tips="数据列表" lay-direction="2">
                <i class="layui-icon layui-icon-table"></i>
                <cite>数据列表</cite>
              </a>
            </li>
            <li data-name="oklist" class="layui-nav-item layui-nav-itemed">
              <a lay-href="/simadmin/oklist" lay-tips="完整数据" lay-direction="2">
                <i class="layui-icon layui-icon-table"></i>
                <cite>完整数据</cite>
              </a>
            </li>
            <li data-name="loglist" class="layui-nav-item layui-nav-itemed">
              <a lay-href="/simadmin/loglist" lay-tips="数据日志" lay-direction="2">
                <i class="layui-icon layui-icon-table"></i>
                <cite>数据日志</cite>
              </a>
            </li>
            <li data-name="ip" class="layui-nav-item layui-nav-itemed">
              <a lay-href="/simadmin/ip" lay-tips="访问统计" lay-direction="2">
                <i class="layui-icon layui-icon-chart"></i>
                <cite>访问统计</cite>
              </a>
            </li>
            <li data-name="test" class="layui-nav-item layui-nav-itemed">
              <a lay-href="/simadmin/test" lay-tips="测试入口" lay-direction="2">
                <i class="layui-icon layui-icon-vercode"></i>
                <cite>测试入口</cite>
              </a>
            </li>
            <li data-name="xgmm" class="layui-nav-item layui-nav-itemed">
              <a lay-href="/simadmin/xgmm" lay-tips="修改密码" lay-direction="2">
                <i class="layui-icon layui-icon-password"></i>
                <cite>修改密码</cite>
              </a>
            </li>

            <li data-name="out" class="layui-nav-item layui-nav-itemed">
              <a href="/simlogin/out" lay-tips="退出登录" lay-direction="2">
                <i class="layui-icon layui-icon-logout"></i>
                <cite>退出登录</cite>
              </a>
            </li>
            
          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="/simadmin/sqlb" lay-attr="/simadmin/sqlb" class="layui-this"> 数据列表</li>
          </ul>
        </div>
      </div>
      
      
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="/simadmin/sqlb" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>

  <script src="../layuiadmin/layui/layui.js"></script>
  <script>
  layui.config({
    base: '../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use('index');
  </script>
  
</body>
</html>


