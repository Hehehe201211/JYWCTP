      <div class="zy_zszl">
        <div class="zy_zszl_z">
          <dl>
            <dt>
              <dl>
                <dt><img src="{$this->webroot}img/tx.jpg"></dt>
                <dd class="mebInfo">
	                <span>会员昵称：{$memberInfo.Member.nickname}</span>
	                <span>会员等级：高级</span>
	                <span>绑定手机：{$memberInfo.Attribute.mobile}</span>
	                <span>绑定邮箱：{$memberInfo.Member.email}</span>
	                <span>行业：{$this->Category->getCategoryName($memberInfo.Attribute.category_id)}</span>
	                <span>地址：
	                {$provicial = $this->City->cityName($memberInfo.Attribute.provincial_id)}
	                {$city = $this->City->cityName($memberInfo.Attribute.city_id)}
	                {if $provicial == $city}
	                {$provicial}
	                {else}
	                {$provicial} {$city}
	                {/if}
	                </span>
                </dd>
              </dl>
            </dt>
            <dd>
	            <span>资料完整度:</span>
		            <span class="progressBar">
		            {if $memberInfo.Member.grade == 2}
		            <span style="width:100%">&nbsp;100%&nbsp;</span>										
		            {else}
		            <span>&nbsp;20%&nbsp;</span>
		            {/if}
	            </span>
	            <a href="#">完善资料</a>
				{if $memberInfo.Member.grade == 2}
		             <a class="icon iconS iconH" href="new-grhysj.html" title="身份已认证"></a><a class="icon iconM iconH" href="new-zhaq.html" title="已绑定邮箱"></a><a class="icon iconT iconH" href="new-zhaq.html" title="已绑定手机"></a><a class="icon iconB iconH" title="已绑定支付宝" href="#"></a>										
		            {else}
		             <a class="icon iconS" href="new-grhysj.html" title="身份未认证"></a><a class="icon iconM iconH" href="new-zhaq.html" title="已绑定邮箱"></a><a class="icon iconT iconH" href="new-zhaq.html" title="已绑定手机"></a><a class="icon iconB" title="未绑定支付宝" href="#"></a>
		            {/if}
	           
            </dd>
          </dl>
        </div>
        <div class="zy_zszl_r">
          <dl>
            <dd>
	            <span>已发布：
		            <a href="new-ywfbmx.html">{$historyInfo.created_has}</a>条客源&nbsp;&nbsp;
		            <a href="xslb.html">{$historyInfo.created_need}</a>条悬赏
	            </span>
	            <span>已收到：
		            <a href="new-sddxq.html">{$historyInfo.received_has}</a>条客源&nbsp;&nbsp;
		            <a href="new-sddsx.html">{$historyInfo.received_need}</a>条悬赏
	            </span>
	            <span>待确认客源：
	            	<a href="dqrjy.html">0</a>条
	            </span>
	            <span>待处理投诉：
	            	<a href="new-wbts.html">0</a>条
	            </span>
	            <span>留言：
	            	<a href="new-znx.html">0</a>条
	            </span>
	            <span>虚拟币余额：<a href="new-zhye.html">{$memberInfo.Attribute.virtual_coin}</a>元&nbsp;&nbsp;积分：<a href="jfmx.html">{$memberInfo.Attribute.point}</a>分
	            </span>
	            <span>聚客币：
		            <a href="new-zhye.html">余额</a>
		            <a href="new-czjl.html">充值</a>
		            <a target="_blank" href="https://memberprod.alipay.com/fund/withdraw/apply.htm">提现</a>
		            <a href="new-qbmx.html">明细</a>
	            </span>
            </dd>
          </dl>
        </div>
      </div>