      <div class="mebBaseinfo">
        <div class="mebBaseinfoL">
          <table width="100%" height="100%" border="0">
            <tr>
              <td width="34%" rowspan="6"><img src="{$this->webroot}img/tx.jpg"></td>
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
              <td colspan="2" class="mebInfo"><span>资料完整度：</span><span class="progressBar">{if $memberInfo.Member.grade == 2}
		            <span style="width:100%">&nbsp;100%&nbsp;</span>										
		            {else}
		            <span>&nbsp;20%&nbsp;</span>
		            {/if}</span><a href="#">完善资料</a>{if $memberInfo.Member.grade == 2}
		             <a class="icon iconS iconH" href="new-grhysj.html" title="身份已认证"></a><a class="icon iconM iconH" href="new-zhaq.html" title="已绑定邮箱"></a><a class="icon iconT iconH" href="new-zhaq.html" title="已绑定手机"></a><a class="icon iconB iconH" title="已绑定支付宝" href="#"></a>										
		            {else}
		             <a class="icon iconS" href="new-grhysj.html" title="身份未认证"></a><a class="icon iconM iconH" href="new-zhaq.html" title="已绑定邮箱"></a><a class="icon iconT iconH" href="new-zhaq.html" title="已绑定手机"></a><a class="icon iconB" title="未绑定支付宝" href="#"></a>
		            {/if}</td>
            </tr>
          </table>
        </div>
        <div class="mebBaseinfoR">
          <dl>
            <dd>已发布：
		            <a href="new-ywfbmx.html">{$historyInfo.created_has}</a>条客源&nbsp;&nbsp;
		            <a href="xslb.html">{$historyInfo.created_need}</a>条悬赏</dd>
            <dd>已收到：
		            <a href="new-sddxq.html">{$historyInfo.received_has}</a>条客源&nbsp;&nbsp;
		            <a href="new-sddsx.html">{$historyInfo.received_need}</a>条悬赏</dd>
            <dd>待确认客源：<a href="dqrjy.html">0</a>条</dd>
            <dd>待处理投诉：<a href="new-wbts.html">0</a>条</dd>
            <dd>留言：<a href="new-znx.html">0</a>条</dd>
            <dd>虚拟币余额：<a href="new-zhye.html">{$memberInfo.Attribute.virtual_coin}</a>元&nbsp;&nbsp;积分：<a href="jfmx.html">{$memberInfo.Attribute.point}</a>分
	         </dd>
            <dd>聚客币：<a href="new-zhye.html">余额</a><a href="new-czjl.html">充值</a><a href="txsq.html" target="_blank">提现</a><a href="new-qbmx.html">明细</a></dd>
          </dl>
        </div>
      </div>