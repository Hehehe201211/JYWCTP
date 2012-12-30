<div style="width:550px;" id="djbuz">
	<div class="djbuzTit">
		<span class="fk_tit">{$information.Information.title}</span>
		<a href="#" title="关闭" class="closeKuang close">
		</a>
	</div>
 	<div style="padding:3px 0 3px 10px;" class="xq_zl_xbxq">
		<table width="540">
			<tbody>
				<tr>
					{$provincial = $this->City->cityName($information.Information.provincial)}
					{$city = $this->City->cityName($information.Information.city)}
					{if $provincial == $city}
						<td width="132" class="tdRight">城市：</td>
						<td width="57" class="tdLeft">{$provincial}</td>
						<td width="42" class="tdRight"> </td>
						<td width="309" class="tdLeft"> </td>
					{else}
						<td width="132" class="tdRight">省份：</td>
						<td width="57" class="tdLeft">{$provincial}</td>
						<td width="42" class="tdRight">城市：</td>
						<td width="309" class="tdLeft">{$city}</td>
					{/if}
				</tr>
				{if $type == "has"}
				<tr>
					<td width="132" class="tdRight">行业：</td>
					<td class="tdLeft" colspan="3">{$this->Category->getCategoryName($information.Information.industries_id)}</td>
				</tr>
				{/if}
				<tr>
					<td class="tdRight">产品名称：</td>
					<td class="tdLeft" colspan="3">
						{$this->Category->getCategoryName($information.Information.category)} 
						{$this->Category->getCategoryName($information.Information.sub_category)}
					</td>
				</tr>
				<tr>
					<td class="tdRight connection">{if $type == "has"}采购单位：{else}产品提供单位：{/if}</td>
					<td class="tdLeft" colspan="3">{if $type == "has" && $paid}{$information.Information.company}{else if $type == "need"}{$information.Information.company}{else}******{/if}</td>
				</tr>
				<tr>
						<td class="tdRight connection">联系人：</td>
						<td class="tdLeft" colspan="3">{if $paid}{$attribute.InformationAttribute.contact}{else}******{/if}</td>
					</tr>
					<tr>
						<td class="tdRight connection">联系人职位：</td>
						<td class="tdLeft" colspan="3">{if $paid}{$attribute.InformationAttribute.post}{else}******{/if}</td>
					</tr>
					{foreach $attributes as $attribute}
					<tr>
						<td class="tdRight connection">联系方式：</td>
						<td class="tdLeft" colspan="3">{if $paid}{$attribute.InformationAttribute.contact_method}{else}******{/if}</td>
					</tr>
					{/foreach}
					<tr>
						<td class="tdRight connection">单位详细地址：</td>
						<td class="tdLeft" colspan="3">{if $paid}{$attribute.InformationAttribute.address}{else}******{/if}</td>
					</tr>		
				<tr>
					<td class="tdRight">客源有效期：</td>
					<td class="tdLeft" colspan="3">{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}</td>
				</tr>
				<tr>
					<td class="tdRight">信息交易价格：</td>
					<td class="tdLeft" colspan="3">
						{if $information.Information.payment_type == 1}
							聚客币：{$information.Information.price}元
						{else if $information.Information.payment_type == 2}
							积分：{$information.Information.point}分
						{else}
							聚客币：{$information.Information.price}元；积分：{$information.Information.point}分
						{/if}
					</td>
				</tr>
				{if $type == "has"}
				<tr>
					<td class="tdRight">预计合作金额：</td>
					<td class="tdLeft" colspan="3">{$information.Information.profit}元人民币</td>
				</tr>
				
				<tr>
					<td class="tdRight">预计合作时间：</td>
					<td class="tdLeft" colspan="3">{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
				</tr>
				{/if}
				<tr>
					<td class="tdRight">客户选择服务商因素：</td>
					<td class="tdLeft" colspan="3">{$information.Information.reason}</td>
				</tr>
							
				{if $type=="has" && $memberInfo.Member.grade < 1}
				<tr>
					<td class="tdRight"></td>
					<td class="tdLeft" colspan="3"><em>你的会员等级不足以购买此信息，是否立即<a target="_blank" href="/members/upgrade">提升会员等级</a>？</em></td>
				</tr>
				{/if}
				<tr>
					<td class="tdRight">采购需求描述：</td>
					<td class="tdLeft" colspan="3"><p>
			{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}
			</p></td>
				</tr>
				<tr>
					<td class="tdRight">采购补充：</td>
					<td class="tdLeft" colspan="3"><p>{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p></td>
				</tr>
			</tbody>
		</table>
	</div>
	<input type="hidden" value="{$clicked}" id="clicked" name="clicked">
    <div class="divBtnContainer" style="width:200px;">
	{if $type=="has"}
	<a target="_blank" href="/informations/payment/{$information.Information.id}" class="zclan zclan7 close">我要客源</a>
	{else}
	<a target="_blank" href="/informations/create/has/?target={$information.Information.id}&target_member={$information.Information.members_id}" class="zclan zclan7 close">我有客源</a>
	{/if}
	<a href="#" class="zclan zclan7 close">关闭详情</a>
    </div>
</div>
