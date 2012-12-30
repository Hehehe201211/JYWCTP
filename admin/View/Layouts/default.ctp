<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    {$this->Html->charset()}
    <title>
    {$title_for_layout}
    </title>
    {$this->Html->meta('icon')}
    {$this->Html->meta($meta)}
    {$this->Html->css($css)}
    {$this->Html->script($js)}
</head>
<body class="reset">
    <div id="wrap" class="container">
    {assign var = admin value = $this->Session->read('admin')}
    {$this->element('header')}
    {if !empty($admin)}
        <div id="topmenu" class="clear span-24 last">
            <ul>
            {foreach $menus as $menu}
                <li><a menuid="" href="/admin/{$menu['Menu']['controller']}" >{$menu['Menu']['name']}</a></li>
            {/foreach}
                <li class="rightitem"><a href="/admin/index/logout">退出系统</a></li>
            </ul>
        </div>
        <div id="sidebar-left" class="span-5">
        {if !empty($sub_menus)}
            <div class="submenu">
                <ul>
                {foreach $sub_menus as $sub_menu}
                    <li><a submenuid="" href="/admin/{$sub_menu.SubMenu.link}">{$sub_menu.SubMenu.name}</a></li>
                {/foreach}
                </ul>
            </div>
        {/if}
        </div>
    {/if}
        <div id="content" class="span-18 last">
            {$this->fetch('content')}
        </div>
        {if isset($showIFrame) && $showIFrame}
            <iframe id="checkView" style="width:1000px;height:800px">
            </iframe>
            <input type="button" value="发布" id="complete">
        {/if}
    {$this->element('footer')}
    </div>
</body>
</html>