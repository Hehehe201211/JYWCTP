<div style="width:550px;" id="djbuz">
	<div class="djbuzTit">
		<span class="fk_tit">{$information.Information.title}</span>
		<a href="javascript:void(0)" title="关闭" class="closeKuang close">
		</a>
	</div>
    <div class="tableDetail" style="padding-top:3px;">
      <table width="100%">
        <tr>
        {$provincial = $this->City->cityName($information.Information.provincial)}
					{$city = $this->City->cityName($information.Information.city)}
					{if $provincial == $city}
          <th width="25%">所在区域：</th>
          <td width="75%">{$provincial}</td>
          {else}
          <th width="25%">所在区域：</th>
          <td width="75%">{$provincial}&nbsp;{$city}</td>
          {/if}
        </tr>
        {if $type == "has"}				
         <tr>
          <th>行业：</th>
          <td>{$this->Category->getCategoryName($information.Information.industries_id)}</td>
        </tr>
		{/if}
        <tr>
          <th>产品名称：</th>
          <td>{$this->Category->getCategoryName($information.Information.category)} 
				  {$this->Category->getCategoryName($information.Information.sub_category)}</td>
        </tr>
        <tr>
          <th>{if $type == "has"}采购单位：{else}产品提供单位：{/if}</th>
          <td class="red">{if $type == "has" && $paid}{$information.Information.company}{else if $type == "need"}{$information.Information.company}{else}******{/if} </td>
        </tr>
        {if $type == 'has'}
        <tr>
          <th>联系人：</th>
          <td class="red">{if $paid}{$attribute.InformationAttribute.contact}{else}******{/if}</td>
        </tr>
        <tr>
          <th>联系人职位：</th>
          <td class="red">{if $paid}{$attribute.InformationAttribute.post}{else}******{/if}</td>
        </tr>
        {foreach $attributes as $attribute}
        <tr>
          <th>联系方式：</th>
          <td class="red">{if $paid}{$attribute.InformationAttribute.contact_method}{else}******{/if}</td>
        </tr>
        {/foreach}
        <tr>
          <th>单位详细地址：</th>
          <td class="red">{if $paid}{$attribute.InformationAttribute.address}{else}******{/if}</td>
        </tr>
        {/if}
        <tr>
          <th>客源有效期：</th>
          <td>{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}</td>
        </tr>
        <tr>
          <th>信息交易价格：</th>
          <td>{if $information.Information.payment_type == 1}
							聚客币：{$information.Information.price}元
						{else if $information.Information.payment_type == 2}
							积分：{$information.Information.point}分
						{else}
							聚客币：{$information.Information.price}元；积分：{$information.Information.point}分
						{/if}</td>
        </tr>
        {if $type == "has"}
        <tr>
          <th>预计合作金额：</th>
          <td>{$information.Information.profit}元人民币</td>
        </tr>
        <tr>
          <th>预计合作时间：</th>
          <td>{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
        </tr>
        {/if}
        <tr>
          <th>选择服务商因素：</th>
          <td>{$information.Information.reason}</td>
        </tr>
        {if $type=="has" && $memberInfo.Member.grade < 1}
				<tr>
					<th>&nbsp;</th>
					<td><em>你的会员等级不足以购买此信息，是否立即<a target="_blank" href="/members/upgrade">提升会员等级</a>？</em></td>
				</tr>
				{/if}
        <tr>
          <th>采购需求描述：</th>
          <td><P>{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</P></td>
        </tr>
        <tr>
          <th>采购补充：</th>
          <td><p>{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p></td>
        </tr>
      </table>
      <div class="divBtnContainer" style="width:200px;">
	{if $type=="has"}
	<a target="_blank" href="/informations/payment/{$information.Information.id}" class="zclan zclan7 close">我要客源</a>
	{else}
	<a target="_blank" href="/informations/create/has/?target={$information.Information.id}&target_member={$information.Information.members_id}" class="zclan zclan7 close">我有客源</a>
	{/if}
	<a href="javascript:void(0)" class="zclan zclan7 close">关闭详情</a>
    </div>
    </div> 	
	<input type="hidden" value="{$clicked}" id="clicked" name="clicked">    
</div>
