<div class="main">
<div class="wmxxjs_left">
     <div class="biaotit">{$information.Information.title}</div>
     <div class="gongsichakan_post">
        <div class="fl">
        <div class="biaotit">基本信息</div>
        <table width="100%" class="posInfo">
<tr>
            <th>需求地区：</th>
            <td>
            {$provincial = $this->City->cityName($information.Information.provincial)}
        	{$city = $this->City->cityName($information.Information.city)}
        	{if $provincial == $city}
        	{$provincial}
        	{else}
        	{$provincial} {$city}
        	{/if}
            </td>
          </tr>
          {if $information.Information.type == Configure::read('Information.type.has')}
              <tr>
                <th width="40%">行业：</th>
                <td width="60%">{$this->Category->getCategoryName($information.Information.industries_id)}</td>
              </tr>
              
              <tr>
                <th>采购单位：</th>
                <td class="red">******</td>
              </tr>
          {else}
              <tr>
                <th>产品提供单位：</th>
                <td class="red">{$information.Information.company}</td>
          </tr>
          {/if}
          <tr>
            <th>产品名称：</th>
            <td>
            {$this->Category->getCategoryName($information.Information.category)} 
			{$this->Category->getCategoryName($information.Information.sub_category)}
			</td>
          </tr>
          <tr>
            <th>{if $information.Information.type == Configure::read('Information.type.has')}客源有效期{else}悬赏有效期{/if}：</th>
            <td>{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}</td>
          </tr>
          <tr>
            <th>{if $information.Information.type == Configure::read('Information.type.has')}信息交易价格{else}客源悬赏价格{/if}：</th>
            <td>
            {if $information.Information.payment_type == 1}
				业务币：{$information.Information.price}元
			{else if $information.Information.payment_type == 2}
				积分：{$information.Information.point}分
			{else}
				业务币：{$information.Information.price}元；积分：{$information.Information.point}分
			{/if}
            </td>
          </tr>
          {if $information.Information.type == Configure::read('Information.type.has')}
          <tr>
            <th>联系人：</th>
            <td class="red">******</td>
          </tr>
          <tr>
            <th>联系人职位：</th>
            <td class="red">******</td>
          </tr>
          <tr>
            <th>联系方式：</th>
            <td class="red">******</td>
          </tr>
          <tr>
            <th>单位详细地址：</th>
            <td class="red">******</td>
          </tr>
          <tr>
            <th>预计合作金额：</th>
            <td>{$information.Information.profit}元人民币</td>
          </tr>
          <tr>
            <th>预计合作时间：</th>
            <td>{$information.Information.finished}</td>
          </tr>
          {/if}
          <tr>
            <th>客户选择服务商因素：</th>
            <td>{$information.Information.reason}</td>
          </tr>           
</table>      
        </div>
        <div class="fl flB">
         	<div class="biaotit">采购需求描述</div>
         	<p>{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</p>
            <div class="biaotit">采购补充</div>
            <p>{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p>
        </div>  
        <div class="clear"></div>
      </div>
        <a style="margin-top:12px;" href="/informations/payment/{$this->request->query['id']}" class="zclan zclan4 linkLogin">{if $information.Information.type == Configure::read('Information.type.has')}我需要{else}我有客源{/if}</a>
   </div>
  <div class="sider">
    <div class="fuwu">
        {$this->element('common/parttime-right')}
    </div>
  </div>
  <div class="clear">&nbsp;</div>
</div>