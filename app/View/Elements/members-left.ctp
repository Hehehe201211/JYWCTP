<div class="zy_l">
    <div class="zy_lq">
        <div class="zy_lt">
            <span>信息管理</span>
            <img src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.informationManager')}jian.png{else}jia.png{/if}"  alt=""/>
        </div>
        <div class="zy_xxl" {if $currentMenu != Configure::read('Menu.informationManager')}style="display: none;"{else}{/if}>
            <dl>
                <dt>我有客源</dt>
                <dd><a href="/informations/search/need">所有悬赏</a></dd>
                <dd><a href="/informations/received/?type=need" {if $memberInfo.Member.grade == 0}class="elementary"{/if}>收到的悬赏</a></dd>
                <dd><a href="/informations/create/has" {if $memberInfo.Member.grade == 0}class="elementary"{/if}>发布客源</a></dd>
                <dd><a href="/informations/issue/?type=has" {if $memberInfo.Member.grade == 0}class="elementary"{/if}>我的客源</a></dd>
                <dd><a href="/confirm/listview/?type=has" {if $memberInfo.Member.grade == 0}class="elementary"{/if}>交易中</a></dd>
                <dd><a href="/complete/listview/?type=has" {if $memberInfo.Member.grade == 0}class="elementary"{/if}>已结束</a></dd>
                <dt>我要客源</dt>
                <dd><a href="/informations/search/has">所有客源</a></dd>
                <dd><a href="/informations/received/?type=has" {if $memberInfo.Member.grade == 0}class="elementary"{/if}>收到的客源</a></dd>
                <dd><a href="/informations/create/need" {if $memberInfo.Member.grade == 0}class="elementary"{/if}>我要悬赏</a></dd>
                <dd><a href="/informations/issue/?type=need" {if $memberInfo.Member.grade == 0}class="elementary"{/if}>我的悬赏</a></dd>
                <dd><a href="/confirm/listview/?type=need" {if $memberInfo.Member.grade == 0}class="elementary"{/if}>交易中</a></dd>
                <dd><a href="/complete/listview/?type=need" {if $memberInfo.Member.grade == 0}class="elementary"{/if}> 已结束</a></dd>
            </dl>
        </div>
    </div>
    <div class="zy_lq" style="margin-top:6px;">
      <div class="zy_lt"><span>帐号管理</span> <img src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.accountManager')}jian.png{else}jia.png{/if}" alt="" /></div>
        <div class="zy_lx" {if $currentMenu != Configure::read('Menu.accountManager')}style="display: none;"{else}{/if}>
            <ul>
                {if $memberInfo.Member.grade == 0}
                <li><a href="/members/upgrade">会员升级</a></li>
                {/if}
                <li><a href="/accounts/security">账号安全</a></li>
                <li><a href="/accounts/edit">信息修改</a></li>
                <li><a href="/accounts/friend">好友管理</a></li>
                <li><a href="/members/logout">安全退出</a></li>
            </ul>
        </div>
    </div>
    <div class="zy_lq" style="margin-top:6px;">
        <div class="zy_lt"><span>聚客币管理</span><img src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.coinManager')}jian.png{else}jia.png{/if}"  alt=""/></div>
        <div class="zy_lx" {if $currentMenu != Configure::read('Menu.coinManager')}style="display: none;"{else}{/if}>
            <ul>
                <li><a href="/coins/balance">账户余额</a></li>
                <li><a href="/coins/charge">充值记录</a></li>
                <li><a href="/coins/income">收入明细</a></li>
                <li><a href="/coins/expenses">支出明细</a></li>
                <li><a href="/coins/expend">提现明细</a></li>
            </ul>
        </div>
    </div>
    <div class="zy_lq">
        <div class="zy_lt"><span>积分管理</span> <img src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.pointManager')}jian.png{else}jia.png{/if}"  alt=""/></div>
        <div class="zy_lx" {if $currentMenu != Configure::read('Menu.pointManager')}style="display: none;"{else}{/if}>
            <ul>
                <li><a href="/points/balance">积分查询</a></li>
                <li><a href="/points/charge">积分充值</a></li>
                <li><a href="/points/income">收入明细</a></li>
                <li><a href="/points/expenses">支出明细</a></li>
            </ul>
        </div>
    </div>
    <div class="zy_lq">
      <div class="zy_lt"><span>常规招聘</span> <img alt="" src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.fulltimeManager')}jian.png{else}jia.png{/if}"></div>
      <div class="zy_lx" {if $currentMenu != Configure::read('Menu.fulltimeManager')}style="display: none;"{else}{/if}>
        <ul>
          <li><a href="/resumes/listview">我的简历</a></li>
          <li><a href="/fulltimes/search">我要工作</a></li>
          <li><a href="/fulltimes/favouriteList">职位收藏夹</a></li>
          <li><a href="/auditions/listview?type=send">简历投递记录</a></li>
          <li><a href="/auditions/inviteList?type=send">面试邀请</a></li>
        </ul>
      </div>
    </div>
    
    <div class="zy_lq">
        <div class="zy_lt"><span>兼职管理</span> <img src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.parttimeManager')}jian.png{else}jia.png{/if}"  alt=""/></div>
        <div class="zy_lx" {if $currentMenu != Configure::read('Menu.parttimeManager')}style="display: none;"{else}{/if}>
            <ul>
                <li><a href="/parttimes/listview?type=need">我要兼职</a></li>
                <li><a href="/favourites/listview">我收藏的兼职</a></li>
                <li><a href="/invitations/listview">收到的邀请</a></li>
                <li><a href="/cooperations/listview/?type=send">客源提供列表</a></li>
                <li><a href="/cooperations/waitlist/?type=send">合作中的兼职</a></li>
                <li><a href="/cooperations/complaintlist/?type=send">我的投诉</a></li>
                <li><a href="/cooperations/completelist/?type=send">交易结束的兼职</a></li>
            </ul>
        </div>
    </div>
    <div class="zy_bz"><a href="#"></a></div>
    <div class="zy_fx"><a href="#"></a></div>
</div>