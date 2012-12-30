<div id="header" class="span-24 last">
    <div class="span-8" >
        <a href=""><img src="{$this->webroot}img/logo.png" alt="Logo" /></a>
    </div>
    <div class="span-11">
        <br />
        <h2>后台管理系统</h2>
    </div>
    <div id="userinfo" class="span-4">
        <br />
        <br />
        <br />
{if !empty($admin)}
        <label>用户:&nbsp;&nbsp;{$admin['Admin']['name']}</label>
    </div>
{/if}
</div>
