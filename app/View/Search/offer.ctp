<script type="text/javascript">
{literal}
$(document).ready(function(){
    var ulCHeight=$(".ulCompany1").height();
    $(".switchBox").click(function(){
        if (NaV=="msie6"||NaV=="msie7") {
            $(".ulCompany1").height(ulCHeight);
            if ($(".switchBox .divTable:visible").length==0) {
                $(".ulCompany1 li").show();
            } else {
                $(".ulCompany1 li").hide();
            }
        }
    });
    //检索按钮
    $('#search').click(function(){
        $('#searchOpt').submit();
    });
    //验证码
    $('#getCheckNum').prepend('<img id="code" src="/members/image">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
    //login
    $('#btnLogin').click(function(e){
        var msg = '';
        var error = false;
        var nickname = $('#loginBox input[name="nickname"]').val();
        var password = $('#loginBox input[name="password"]').val();
        var checkNum = $('#loginBox input[name="checkNum"]').val();
        var type = $('#loginBox input[name="type"]:checked').val();
        if (nickname == '' || nickname == '请输入用户名') {
            msg = '<li>请输入用户名</li>'
            error = true;
        }
        if (password == '') {
            msg += '<li>请输入密码</li>';
            error = true;
        }
        if (checkNum == '' || checkNum == '验证码') {
            msg += '<li>请输入验证码</li>';
            error = true;
        }
        if (type == null) {
            msg += '<li>请选择类型</li>';
            error = true;
        }
        if (error) {
            e.preventDefault();
            $('#loginWarning .question').html(msg);
            $("#loginWarning").fadeIn("fast");
            var t=setTimeout("hideWarning()",10000);            
        }
        
        if(!error) {
             params = "nickname=" + nickname + "&password=" + password + "&checkNum=" + checkNum + "&type=" + type;
             $.ajax({
                type : 'post',
                url  : '/members/ajaxlogin',
                data : params,
                success : function(data) {
                    if (data == '') {
                        window.location.href = location.href;
                    }                    
                    if (data != '') {
                        msg = '<li>' + data + '</li>';
                        $('#loginWarning ul').html(msg);
                        $("#loginWarning").fadeIn("fast");
                        var t=setTimeout("hideWarning()",10000);
                    } else {
                        $('#loginWarning').hide();
                    }                    
                }
             });
         }
    });    
});
{/literal}
</script>
<div class="main">
  <div id="loginWarning">
    <div class="area">
      <div class="notice">您输入的密码和账户名不匹配，请重新输入。</div>
      <ul class="question">
        <li>您是否锁定了键盘的大写功能？
          <p>请检查您键盘上的"Caps Lock"或"A"灯是否亮着，<br/>
            如果是，请先按一下"Caps Lock"键然后重新输入。</p>
        </li>
        <li>您是否忘记或不小心输入了错误的密码？
          <p>您可以通过<a href="#">忘记会员名</a>或<a href="#">忘记密码</a>重新设置信息。</p>
        </li>
      </ul>
    </div>
    <div class="arrow"></div>
  </div>
  <div class="wmxxjs_left inviteJobL" style="overflow:visible;">
    <form id="searchOpt" action="/search/offerSearch" method="post">
      {$this->element('common/parttime-search-bar')}
    </form>
  </div>
  <div class="sider inviteJobR">
    <div class="login">
        {if empty($memberInfo)}            
        <form action="#" method="post" id="loginBox">
        <ul>
          <li>
            <label>用户名：</label>
            <input type="text" name="nickname" value="请输入用户名" id="username" class="username" txt="请输入用户名" />
          </li>
          <li>
            <label>密码：</label>
            <input type="password" name="password" value="" id="password" class="password"/>
            <label id="passwordL" for="password">请输入密码</label>
          </li>
          <li>
            <label>验证码：</label>
            <input type="text" name="checkNum" value="验证码" class="yanzhengma" txt="验证码"/>
            <a id="getCheckNum" href="javascript:void(0)">看不清？</a></li>
          <li>
            <label>类型：</label>
            <label class="fl"><input type="radio" name="type" value="0" checked="checked"/>个人</label>
            <label class="fl"><input type="radio" name="type" value="1" />企业</label>
          </li>
          <li class="zinp">
          <a id="btnLogin" class="inp" href="javascript:void(0)">登录</a>
          <a id="btnRegister" class="inp" href="/members/register">免费注册</a>
          <a class="forget" href="/account/forget">忘记密码</a>
          </li>
        </ul>
      </form>
        {else}
            {if $memberInfo.Member.grade != 2}
                  <h3>{$memberInfo.Member.nickname}</h3>
                  <dl class="mebLinks">
                    <dt>你还不是高级会员，点击<a class="upgrade" href="/members/upgrade">立即升级</a></dt>
                    <dd><a target="_blank" href="/informations/search/has">检索客源</a></dd>
                    <dd><a target="_blank" href="/informations/search/need">检索悬赏</a></dd>
                    <dd><a target="_blank" href="/fulltimes/search">检索职位</a></dd>
                    <dd><a target="_blank" href="/parttimes/listview?type=need">检索兼职</a></dd>
                    <dd>&nbsp;</dd>
                    <dd><a class="logout" target="_blank" href="/members/logout">退出</a></dd>
                  </dl>
            {else}
                  <!--<h3>{$memberInfo.Member.nickname}</h3>-->
                  <dl class="mebLinks">        
                    <dd><a href="/informations/search/has" target="_blank">检索客源</a></dd>
                    <dd><a href="/informations/create/has" target="_blank">发布客源</a></dd>
                    <dd><a href="/informations/search/need" target="_blank">检索悬赏</a></dd>
                    <dd><a href="/informations/create/need" target="_blank">发布悬赏</a></dd>
                    <dd><a href="/fulltimes/search" target="_blank">检索职位</a></dd>
                    <dd><a href="/resumes/listview" target="_blank">简历管理</a></dd>   
                    <dd><a href="/parttimes/listview?type=need" target="_blank">检索兼职</a></dd>     
                    <dd><a href="/invitations/listview" target="_blank">兼职管理</a></dd> 
                    <dd><a href="/resources/listview?mid={$memberInfo.Member.id}" target="_blank">文档管理</a></dd>       
                    <dd><a href="/members/logout" target="_blank" class="logout">退出</a></dd>
                  </dl>
            {/if}
        {/if}
    </div>
  </div>
  <div class="clearfix"></div>  
  <div class="inviteJobB">
    <h2 class="tilInviteJobB">热门招聘</h2>
    <div class="clearfix"></div>
    <ul class="ulCompany1 ulCompany2">
    {foreach $graphics as $homepage}
      <li>
          <a href="/homes/fulltime/{$homepage.Homepage.domain}" target="_blank" title="{$homepage.Homepage.company_name}">
          {$path = Configure::read('Data.path')|cat:$homepage.Homepage.thumbnail_job}
              {if !empty($homepage.Homepage.thumbnail_job) && file_exists($path)}
              <img src="{$this->webroot}{$homepage.Homepage.thumbnail_job}" />
              {else}<span class="middle"><span>{$homepage.Homepage.company_name}</span></span>
              {/if}
          </a>
      </li>
      {/foreach}
    </ul>
    <div class="ad"><img src="{$this->webroot}img/ad_03.jpg" width="998" height="98" alt="" /></div>

    <h2 class="tilInviteJobB"><a href="/search/offerSearch" class="fr">更多...</a>最新招聘</h2>
    <table class="tableJobInfo" width="100%" border="0" cellspacing="0" cellpadding="0">
    {foreach $links as $key => $fulltime}
        {if $key % 3 == 0}
        <tr>
            <td>
                <div class="textEllipsis">
                    <a href="/search/odetail?id={$fulltime.Fulltime.id}" class="name" target="_blank">{$fulltime.Fulltime.company}</a>
                    <a href="/search/odetail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.post}</a>
                </div>
            </td>
        
        {else if $key % 3 == 2}
            <td>
                <div class="textEllipsis">
                <a href="/search/odetail?id={$fulltime.Fulltime.id}" class="name" target="_blank">{$fulltime.Fulltime.company}</a>
                <a href="/search/odetail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.post}</a>
                </div>
            </td>
          </tr>
        {else}
        <td>
            <div class="textEllipsis">
                <a href="/search/odetail?id={$fulltime.Fulltime.id}" class="name" target="_blank">{$fulltime.Fulltime.company}</a>
                <a href="/search/odetail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.post}</a>
            </div>
        </td>
        {/if}
    {/foreach}
    </table>
  </div>
</div>
