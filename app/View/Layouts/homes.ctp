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
    <div class="width1000 zhucrig">
        <a href="http://dev.jukeyuan.com/members/register">免费注册</a>&nbsp;|&nbsp;
        <a href="http://dev.jukeyuan.com/members/register">登录</a>&nbsp;|&nbsp;
        <a href="http://dev.jukeyuan.com/">聚业务首页</a>
    </div>
    <div class="width1000 header"> 
        <div class="divH left">&nbsp;</div>
        <div class="divH middle">
            <div>
            {if isset($company_thumbnail) && !empty($company_thumbnail)}
            <img src="{$this->webroot}{$company_thumbnail}" />
            {else}
            <img src="{$this->webroot}img/logo.png" />
            {/if}
            </div>
        </div>
        <div class="divH right">
            <table width="100%" height="100%" border="0">
                <tr>
                    <td><p class="webName webNameB">{$title_for_layout}</p><p class="webName">{$homepage.Homepage.company_name}</p></td>
                </tr>
            </table>    
        </div>
    </div>
{$this->fetch('content')}
{$this->element('homes-footer')}
</body>
</html>