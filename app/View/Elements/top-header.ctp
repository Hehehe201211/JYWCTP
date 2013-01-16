<div class="header">
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
  <div class="header_top">
    <div class="header_top_logo"><img src="{$this->webroot}img/logo.jpg" alt="" /></div>
    <div class="header_top_number">
      <div class="header_top_numberH">
        <div>新增会员</div>
        <div>新增信息</div>
        <div class="long">新增招聘兼职</div>
      </div>
      <div class="header_top_index_tj">
        <div class="index_tj_s"><span id="index_tj_sp"></span> <span id="index_tj_sp1"></span></div>
        <div class="index_tj">
          <ul>
            <li>
              <table width="125%" border="0">
                <tr>
                  <td width="16%" rowspan="2" class="title">所有</td>
                  <td width="13%">个人会员</td>
                  <td width="13%">企业会员</td>
                  <td width="12%">客源</td>
                  <td width="12%">悬赏</td>
                  <td width="11%">简历</td>
                  <td width="12%">岗位</td>
                  <td width="11%">兼职</td>
                </tr>
                <tr>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                </tr>
              </table>
            </li>
            <li>
              <table width="125%" border="0">
                <tr>
                  <td width="16%" rowspan="2" class="title">昨日</td>
                  <td width="13%">个人会员</td>
                  <td width="13%">企业会员</td>
                  <td width="12%">客源</td>
                  <td width="12%">悬赏</td>
                  <td width="11%">简历</td>
                  <td width="12%">岗位</td>
                  <td width="11%">兼职</td>
                </tr>
                <tr>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                </tr>
              </table>
            </li>
            <li>
              <table width="125%" border="0">
                <tr>
                  <td width="16%" rowspan="2" class="title">本周</td>
                  <td width="13%">个人会员</td>
                  <td width="13%">企业会员</td>
                  <td width="12%">客源</td>
                  <td width="12%">悬赏</td>
                  <td width="11%">简历</td>
                  <td width="12%">岗位</td>
                  <td width="11%">兼职</td>
                </tr>
                <tr>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                </tr>
              </table>
            </li>
            <li>
              <table width="125%" border="0">
                <tr>
                  <td width="16%" rowspan="2" class="title">本月</td>
                  <td width="13%">个人会员</td>
                  <td width="13%">企业会员</td>
                  <td width="12%">客源</td>
                  <td width="12%">悬赏</td>
                  <td width="11%">简历</td>
                  <td width="12%">岗位</td>
                  <td width="11%">兼职</td>
                </tr>
                <tr>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                  <td>999999</td>
                </tr>
              </table>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="header_top_search">
      <div class="x_search2 x_only2" >
        <div id="top_select" class="x_slist2" > <a class="x_selected select" href="#" hidefocus="true"><span id="topSearch" class="rel">任务</span></a> </div>
        <input id="inpSearch" class="test2" type="text" name="input"/>
        <input class="image2" width="22" type="image" height="26" src="{$this->webroot}img/topsearch_04.gif" name="inpSearch" />
        <ul id="topSearchUl" class="select_list" style="display:none;">
          <li><a href="#">任务标题</a></li>
          <li><a href="#">任务号</a></li>
          <li><a href="#">任务发布者</a></li>
          <li><a href="#">稿件编号</a></li>
          <li><a href="#">会员名</a></li>
          <li><a href="#">人才技能</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div id="navi">
    <ul class="nav">
        <li><a {if $currentTopBar == "index"}class="current"{/if} href="/">首&nbsp;&nbsp;页</a></li>
        <li><a {if $currentTopBar == "need"}class="current"{/if} href="/search?type=need">我要客源</a></li>
        <li><a {if $currentTopBar == "has"}class="current"{/if} href="/search?type=has">我有客源</a></li>
        <li><a {if $currentTopBar == "offer"}class="current"{/if} href="/search/offer">企业招聘</a></li>
        <li><a {if $currentTopBar == "parttime"}class="current"{/if} href="/search/parttime">兼职信息</a></li>
        <li><a {if $currentTopBar == "resource"}class="current"{/if} href="/resources">资源天地</a></li>
        <li><a {if $currentTopBar == "community"}class="current"{/if} href="#">聚业务社区</a></li>
        <li><a {if $currentTopBar == "static"}class="current"{/if} href="http://dev.jukeyuan.com/static?tpl=SIndex">服务中心</a></li>
    </ul>
</div>