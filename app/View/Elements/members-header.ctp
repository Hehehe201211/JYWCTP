<div class="wrapper1 wrap header">
  <div class="toplist">
    <ul>
      <li class="back"><a href="#" target="_blank">低投入高回报</a></li>
      <li class="loginInfo"> <ul class="fr">
          <li><a href="zhuce.html" target="_blank">网站说明</a></li>
          <li class="line"></li>
          {if empty($memberInfo) || $memberInfo.Member.type == Configure::read('UserType.Personal')}
          <li><a href="/accounts/invite" target="_blank">好友推荐</a></li>
		  <li class="line"></li>
          {/if}          
          <li><a href="/accounts/sms" target="_blank">站内信</a></li>
          <li class="line"></li>
          {if empty($memberInfo)}
          <li class="cor">
          <a href="/services/home" target="_blank">企业服务</a>
             <div class="moreList" style="width:60px;">
	             <a href="/services/home" target="_blank">企业服务</a>
                 <a href="/fulltimes/create" target="_blank">常规招聘</a>
                 <a href="/parttimes/create" target="_blank">平台兼职</a>
             </div>
          </li>
          <li class="line"></li>
          <li class="cor">
          <a href="/members" target="_blank">我的聚业务</a>
             <div class="moreList" style="width:72px;">
	             <a href="/informations/search/need" target="_blank">我有客源</a>
                 <a href="/informations/search/has" target="_blank">我要客源</a>
                 <a href="/auditions/inviteList?type=send" target="_blank">面试邀请</a>
                 <a href="/invitations/listview" target="_blank">平台兼职</a>
             </div>
          </li>
          {else if $memberInfo.Member.type == Configure::read('UserType.company')}
          <li class="cor">
          <a href="/services/home" target="_blank">企业服务</a>
             <div class="moreList" style="width:60px;">
	             <a href="/services/home" target="_blank">企业服务</a>
                 <a href="/fulltimes/create" target="_blank">常规招聘</a>
                 <a href="/parttimes/create" target="_blank">平台兼职</a>
             </div>
          </li>
          {else}
          <li class="cor">
          <a href="/members" target="_blank">我的聚业务</a>
             <div class="moreList" style="width:72px;">
	             <a href="/informations/search/need" target="_blank">我有客源</a>
                 <a href="/informations/search/has" target="_blank">我要客源</a>
                 <a href="/auditions/inviteList?type=send" target="_blank">面试邀请</a>
                 <a href="/invitations/listview" target="_blank">平台兼职</a>
             </div>
          </li>
          {/if}
        </ul>
        {if empty($memberInfo)}
        您好，游客，欢迎光临聚业务网&nbsp;<a href="/members/register" target="blank" class="toptoolUseN">注册/登录</a>
        {else}
        您好，<font color="#FF3300">{$memberInfo.Member.nickname}</font>，欢迎光临聚业务网&nbsp;<a href="/members/logout" target="blank" class="toptoolUseN">[安全退出]</a>
        {/if}
      </li>
      <li class="help"><a href="#" target="_blank">帮助</a></li>
      <li class="daohang"><a href="#" target="_blank">网站导航</a>&nbsp;
        <dl>
          {if empty($memberInfo)}
          <dt><a href="/members" target="_blank">个人会员</a></dt>
          <dd><a href="/informations/create/has" target="_blank">发布客源</a>
              <a href="/informations/create/need" target="_blank">发布悬赏</a>
              <a href="#" target="_blank">我要充值</a>
          </dd>
          <dt><a href="/members" target="_blank">企业会员</a></dt>
          <dd>
              <a href="/fulltimes/create" target="_blank">发布招聘</a>
              <a href="/parttimes/create" target="_blank">发布兼职</a>
          </dd>
        {else}
            {if $memberInfo.Member.type == Configure::read('UserType.company')}
            <dt><a href="/members" target="_blank">企业会员</a></dt>
            <dd>
                <a href="/fulltimes/create" target="_blank">发布招聘</a>
                <a href="/parttimes/create" target="_blank">发布兼职</a>
            </dd>
            {else}
            <dt><a href="/members" target="_blank">个人会员</a></dt>
            <dd><a href="/informations/create/has" target="_blank">发布客源</a>
                <a href="/informations/create/need" target="_blank">发布悬赏</a>
                <a href="#" target="_blank">我要充值</a>
            </dd>
            {/if}
        {/if}
          <dt><a href="#" target="_blank">聚业务社区</a></dt>
          <dd>
	          <a href="#" target="_blank">博文</a>
	          <a href="#" target="_blank">论坛</a>
	          <a href="#" target="_blank">知道</a>
	          <a href="#" target="_blank">新闻</a>
          </dd>
          <dt><a href="#" target="_blank">所有服务</a></dt>          
        </dl>
      </li>
    </ul>
  </div>
  <div id="zyt">
    <a href="/members"><div class="zylo"></div></a>
    <div class="zydh">
      <div class="zydh_b">
        <ul>
          <li><a href="/" target="_blank">首页</a></li>
          <li><a href="/members">{if $memberInfo.Member.type == Configure::read('UserType.Personal')}个人主页{else}企业主页{/if}</a></li>
          <li>{if $memberInfo.Member.type == Configure::read('UserType.Personal')}<a href="/accounts/friend">好友</a>{else}<a href="/resumes/search">招聘</a>{/if}</li>
          <li>{if $memberInfo.Member.type == Configure::read('UserType.Personal')}<a href="/parttime/listview?type=need">兼职</a>{else}<a href="/elites/listview">兼职</a>{/if}</li>
          <li><a href="/accounts/sms">站内信</a></li>
        </ul>
        <p><a href="#">搜索</a></p>
        <div class="zylb"> <span class="spanSearchWrap">
          <div class="sltSearchTil"> <a class="x_selected" href="#" hidefocus="true"><span class="mbSearchR">请选择类别</span></a> </div>
          <ul class="sltSearch">
            <li><a href="/informations/issue/has">已发布客源</a></li>
            <li><a href="/informations/received/has">已收到客源</a></li>
            <li><a href="informations/issue/need">已发布悬赏</a></li>
            <li><a href="/informations/received/need">已收到悬赏</a></li>
            <li><a href="#">站内信</a></li>
            <li><a href="#">全部</a></li>
          </ul>
          </span>
          <input type="text" class="txtSearch" />
          <a href="#" class="btnSearch"></a> </div>        
      </div>
    </div>
  </div>
</div>
<div class="wrap">
  <div class="xian2"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('.zy_lt').click(function(){
		$(this).next("div").slideToggle("slow");
		var src = $(this).find('img:first').attr('src');
		if(/jian/.test(src)){
			$(this).find('img:first').attr('src', '/img/jia.png');
		} else {
			$(this).find('img:first').attr('src', '/img/jian.png');
		}
		
	});
});
</script>