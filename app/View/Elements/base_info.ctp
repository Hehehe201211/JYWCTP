       {if $memberInfo.Member.grade == 2}
      <div class="mebBaseinfo">
        <div class="mebBaseinfoL">
          <table width="100%" height="100%" border="0">
            <tr>
              <td width="34%" rowspan="6">
              {if !empty($memberInfo.Attribute.thumbnail)}
                {$thumbnail = Configure::read('Data.path')|cat:$memberInfo.Attribute.thumbnail}
                {if file_exists($thumbnail)}
                    <img src="{$this->webroot}{$memberInfo.Attribute.thumbnail}">
                {else}
                    <img src="{$this->webroot}img/tx.jpg">
                {/if}
              {else}
              <img src="{$this->webroot}img/tx.jpg">
              {/if}
              </td>
              <td width="66%">会员昵称：{$memberInfo.Member.nickname}</td>
            </tr>
            <tr>
              <td>会员等级：高级</td>
            </tr>
            <tr>
              <td>绑定手机：{$memberInfo.Attribute.mobile}</td>
            </tr>
            <tr>
              <td>绑定邮箱：{$memberInfo.Member.email}</td>
            </tr>
            <tr>
              <td>行业：{$this->Category->getCategoryName($memberInfo.Attribute.category_id)}</td>
            </tr>
            <tr>
              <td>地址：
	                {$provicial = $this->City->cityName($memberInfo.Attribute.provincial_id)}
	                {$city = $this->City->cityName($memberInfo.Attribute.city_id)}
	                {if $provicial == $city}
	                {$provicial}
	                {else}
	                {$provicial} {$city}
	                {/if}</td>
            </tr>
            <tr>
              <td colspan="2" class="mebInfo">
                <span>资料完整度：</span>
                <span class="progressBar">
                    <span style="width:100%">&nbsp;100%&nbsp;</span>
                    </span><a href="/accounts/edit">完善资料</a>
		             <a class="icon iconS iconH" href="/accounts/security" title="身份已认证"></a>
		             <a class="icon iconM iconH" href="/accounts/security" title="已绑定邮箱"></a>
		             <a class="icon iconT iconH" href="/accounts/security" title="已绑定手机"></a>
		             <a class="icon iconB iconH" title="已绑定支付宝" href="/accounts/security"></a>
            </td>
            </tr>
          </table>
        </div>
        <div class="mebBaseinfoR">
          <dl>
            <dd>已发布：
		            <a href="javascript:void(0)">{$historyInfo.created_has}</a>条客源&nbsp;&nbsp;
		            <a href="javascript:void(0)">{$historyInfo.created_need}</a>条悬赏</dd>
            <dd>已收到：
		            <a href="javascript:void(0)">{$historyInfo.received_has}</a>条客源&nbsp;&nbsp;
		            <a href="javascript:void(0)">{$historyInfo.received_need}</a>条悬赏</dd>
            <dd>待确认客源：<a href="javascript:void(0)">0</a>条</dd>
            <dd>待处理投诉：<a href="javascript:void(0)">0</a>条</dd>
            <dd>留言：<a href="javascript:void(0)">0</a>条</dd>
            <dd>业务币余额：<a href="javascript:void(0)">{$memberInfo.Attribute.virtual_coin}</a>元；积分：<a href="javascript:void(0)">{$memberInfo.Attribute.point}</a>分
	         </dd>
            <dd>业务币：
                <a href="/coins/balance">余额</a>
                <a href="/coins/charge">充值</a>
                <a href="/coins/expend">提现</a>
                <a href="/coins/income">明细</a>
            </dd>
          </dl>
        </div>
      </div>
      {else}
      <div class="mebBaseinfo">
  <div class="mebBaseinfoL">
    <table width="100%" height="100%" border="0">
      <tr>
        <td width="34%" rowspan="6"><img src="{$this->webroot}img/tx.jpg"></td>
        <td width="66%">会员昵称：{$memberInfo.Member.nickname}</td>
      </tr>
      <tr>
        <td>会员等级：初级</td>
      </tr>
      <tr>
        <td>绑定邮箱：{$memberInfo.Member.email}</td>
      </tr>
      <tr>
        <td>绑定手机：<a style="float:none" href="/members/upgrade">完善资料</a></td>
      </tr>
      <tr>
        <td>行业：<a style="float:none" href="/members/upgrade">完善资料</a></td>
      </tr>
      <tr>
        <td>地址：<a style="float:none" href="/members/upgrade">完善资料</a></td>
      </tr>
      <tr>
        <td colspan="2" class="mebInfo"><span>资料完整度：</span><span class="progressBar"><span>&nbsp;25%&nbsp;</span></span><a href="/members/upgrade">完善资料</a>
                <a title="未认证身份" href="/members/upgrade" class="icon iconS"></a>
                <a title="已绑定邮箱" href="/members/upgrade" class="icon iconM iconH"></a>
                <a title="未绑定手机" href="/members/upgrade" class="icon iconT"></a>
                <a title="未绑定支付宝" href="/members/upgrade" class="icon iconB"></a></td>
      </tr>
    </table>
  </div>
  <div class="mebBaseinfoR">
    <dl>
      <dd>客源总发布量：<strong>0</strong>条</dd>
      <dd>悬赏总发布量：<strong>0</strong>条</dd>
      <dd>常规招聘总职位：<strong>0</strong>个</dd>
      <dd>平台兼职总职位：<strong>0</strong>个</dd>
      <dd>高级个人会员：<strong>0</strong>位</dd>
      <dd>高级企业会员：<strong>0</strong>家</dd>
      <dd class="upgrade"><a href="/members/upgrade">·升级到高级会员</a></dd>
    </dl>
  </div>
</div>
      {/if}
      