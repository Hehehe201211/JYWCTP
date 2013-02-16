<div class="zy_l">
    <div class="zy_lq">
      <div class="zy_lt">
          <span>平台兼职</span>
          <img alt="" src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.parttimeManager')}jian.png{else}jia.png{/if}">
      </div>
      <div class="zy_lx" {if $currentMenu != Configure::read('Menu.parttimeManager')}style="display: none;"{/if}>
        <ul>          
          <li><a href="/parttimes/create">发布兼职合作</a></li>
          <li><a href="/parttimes/listview?type=send">兼职发布列表</a></li>
          <li><a href="/elites/listview">业务精英检索</a></li>
          <!--<li><a href="/invitations/listview">邀请的合作</a></li> -->
          <li>
          <a href="/cooperations/listview/?type=receiver">收到的合作</a>
            {if isset($receiveCooperationCount) && !empty($receiveCooperationCount)}
                <span class="infoNum">{$receiveCooperationCount}</span>
            {/if}
          </li>
          <li><a href="/cooperations/waitlist/?type=receiver">待确认的合作</a></li> 
          <li>
          <a href="/cooperations/complaintlist/?type=receiver">被投诉的合作</a>
            {if isset($complaintCooperationCount) && !empty($complaintCooperationCount)}
                <span class="infoNum">{$complaintCooperationCount}</span>
            {/if}
          </li>
          <li><a href="/cooperations/completelist/?type=receiver">已结束的合作</a></li>
        </ul>
      </div>
    </div>
    <div class="zy_lq">
      <div class="zy_lt">
          <span>常规招聘</span>
          <img alt="" src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.fulltimeManager')}jian.png{else}jia.png{/if}">
      </div>
      <div class="zy_lx" {if $currentMenu != Configure::read('Menu.fulltimeManager')}style="display: none;"{/if}>
        <ul>
          <li><a href="/resumes/search">简历检索</a></li>
          <li><a href="/fulltimes/create">发布招聘需求</a></li>
          <li><a href="/fulltimes/listview">职位管理</a></li>
          <li>
          <a href="/auditions/listview?type=receive">收到的简历</a>
            {if isset($resumeReceive) && !empty($resumeReceive)}
                <span class="infoNum">{$resumeReceive}</span>
            {/if}
          </li>
          <li>
          <a href="/auditions/inviteList?type=receive">面试邀请</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="zy_lq">
      <div class="zy_lt">
          <span>企业服务</span>
          <img alt="" src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.serviceManager')}jian.png{else}jia.png{/if}">
      </div>
      <div class="zy_lx" {if $currentMenu != Configure::read('Menu.serviceManager')}style="display: none;"{/if}>
        <ul>
          <li><a href="/services/home">公司主页</a></li>
          <li><a href="/services/material">产品及服务资料</a></li>
          <li><a href="/services/advertising">广告位申请</a></li>
        </ul>
      </div>
    </div>
    <div class="zy_lq">
      <div class="zy_lt">
          <span>帐号管理</span>
          <img alt="" src="{$this->webroot}img/{if $currentMenu == Configure::read('Menu.accountManager')}jian.png{else}jia.png{/if}">
      </div>
      <div class="zy_lx" {if $currentMenu != Configure::read('Menu.accountManager')}style="display: none;"{/if}>
        <ul>
          <li><a href="/accounts/edit">完善资料</a></li>
          <li><a href="/accounts/security">账号安全</a></li>
          <li><a href="/members/logout">安全退出</a></li>
        </ul>
      </div>
    </div>
    <div class="zy_bz"><a href="/static?tpl=service" target="_blank"></a></div>
    <div class="zy_fx"><a href="/static?tpl=faq" target="_blank"></a></div>
</div>