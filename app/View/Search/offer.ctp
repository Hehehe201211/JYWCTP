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
  	{$this->element('common/parttime-search-bar')}
  </div>
  <div class="sider inviteJobR">
    <div class="login">
      <form action="#" method="post" id="loginBox">
        <ul>
          <li>
            <label>用户名：</label>
            <input type="text" name="username" value="请输入用户名" id="username" class="username" txt="请输入用户名" />
          </li>
          <li>
            <label>密码：</label>
            <input type="password" name="password" value="" id="password" class="password"/>
            <label id="passwordL" for="password">请输入密码</label>
          </li>
          <li>
            <label>验证码：</label>
            <input type="text" name="yanzhengma" value="验证码" class="yanzhengma" txt="验证码"/>
            <a id="getCheckNum" href="javascript:void(0)"><img src="{$this->webroot}img/num_03.jpg"/>看不清？</a></li>
          <li>
            <label>类型：</label>            
            <label class="fl"><input type="radio" name="type" value="person" checked="checked" id="person"/>个人</label>            
            <label class="fl"><input type="radio" name="type" value="enterprise" id="enterprise"/>企业</label>
          </li>
          <li class="zinp"><a id="btnLogin" class="inp" href="new-hyzy.html">登录</a><a id="btnRegister" class="inp" href="zhuce.html" target="_blank">免费注册</a><a class="forget" href="wangjimima.html">忘记密码</a></li>
        </ul>
      </form>
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
	      	<img src="{$this->webroot}img/ads/1350529873.jpg" />
	      	{else}<span class="middle"><span>{$homepage.Homepage.company_name}</span></span>	      	
	      	{/if}
	      </a>
      </li>
      {/foreach}
    </ul>
    <div class="ad"><img src="{$this->webroot}img/ad_03.jpg" width="998" height="98" alt="" /></div>

    <h2 class="tilInviteJobB"><a href="plt-qyfw2more.html" class="fr">更多...</a>最新招聘</h2>
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
