<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    {$this->Html->charset()}
    <title>{$title_for_layout}</title>
    {$this->Html->meta('icon')}
    {$this->Html->meta($meta)}
    {$this->Html->css($css)}
    {$this->Html->script($js)}
</head>
<body>
<div class="wrap">
  <div id="wrapper">
    <div id="zhuc">
      <div class="header_top_logo" style="margin-top:4px;"><img src="{$this->webroot}img/logo.jpg" /></div>
      <div class="zhucrig">
        <div class="zhucrig_t"><a href="/members/register">免费注册</a>&nbsp;|&nbsp;<a href="/members/register">登录</a>&nbsp;|&nbsp;<a href="/">聚业务首页</a>&nbsp;|&nbsp;<a href="#">帮助</a></div>
      </div>
    </div>
  </div>
</div>
<div class="xian1 wrap"></div>
{$this->fetch('content')}
<div class="xian1 wrap"></div>
<div class="footer"> <a href="#">关于我们</a> | <a href="#">支付方式</a> | <a href="#">联系方式</a> | <a href="#">友情链接</a> | <a href="#">客服中心</a> | <a href="#">网站地图</a> | <a href="#">公司资质</a> | <a href="#">加入我们</a><br>
  服务热线：0592-8624266   传真：0592-8624766  地址：厦门市思明区会展南七路73号224室<br/>
  Copyright©2012 <a href="#">聚业务</a> 版权所有
  <ul>
    <li><img src="{$this->webroot}img/footer_03.jpg"/></li>
    <li><img src="{$this->webroot}img/footer_03.jpg"/></li>
    <li><img src="{$this->webroot}img/footer_03.jpg"/></li>
    <li><img src="{$this->webroot}img/footer_03.jpg"/></li>
    <li><img src="{$this->webroot}img/footer_03.jpg"/></li>
    <li><img src="{$this->webroot}img/footer_03.jpg"/></li>
  </ul>
</div>
</body>
</html>