<script>
$(document).ready(function(){
	$('#complete').click(function(){
		if($('#accept').attr('checked') == "checked") {
			$('#form').submit();
		} else {
			$('.protocol').append('<span style="color:red">请接受协议内容</span>')
		}
		
	});
	$('#back').click(function(){
		var type = $('#type').val();
		var action;
		if (type == 0) {
			action = '/informations/create/has';
		} else {
			action = '/informations/create/need';
		}
		$('#form').attr('action', action).submit();
	});
});

</script>
<div class="zy_z">
<div class="hysj hysj_fb">
<ul>
	<li>1.填写发布信息</li>
	<li>2.确认信息</li>
	<li>3.发布成功</li>
</ul>
<div class="sjle">
<div class="xq_zl">
<div class="xq_zl_xbxq">
<form action="/informations/complete" method="post" id="form">
<input type="hidden" name="type" id="type" value="{$this->data['type']}">
<input type="hidden" name="target" value="{$this->data['target']}">
<input type="hidden" name="parttime" value="{$this->data['parttime']}">
<input type="hidden" name="target_member" value="{$this->data['target_member']}">
<div class="biaotit">{$this->data['title']}<input type="hidden" value="{$this->data['title']}" name="title" /></div>
<table width="100%">
	<tbody>
	<tr>
		<td width="132" class="tdRight">省份：</td>
		<td width="57" class="tdLeft">{$provincial}<input type="hidden" value="{$this->data['provincial']}" name="provincial" /></td>
		<td width="42" class="tdRight">城市：</td>
		<td width="319" class="tdLeft">{$city}<input type="hidden" value="{$this->data['city']}" name="city" /></td>
	</tr>
	<tr>
		<td width="132" class="tdRight">行业：</td>
		<td class="tdLeft" colspan="3">{$industry}
			<input type="hidden" value="{$this->data['industries_id']}" name="industries_id" />
		</td>
	</tr>
	<tr>
		<td class="tdRight">采购产品：</td>
		<td class="tdLeft" colspan="3">
			{$this->Category->getCategoryName($this->data['category'])}
			{$this->Category->getCategoryName($this->data['sub_category'])}
			{if isset($this->data['other_category']) && $this->data['other_category'] != '请输入产品名称 '}{$this->data['other_category']}{/if}
			<input type="hidden" value="{$this->data['category']}" name="category" />
			<input type="hidden" value="{$this->data['sub_category']}" name="sub_category" />
			<!--
			<input type="hidden" value="{if isset($this->data['other_category'])}{$this->data['other_category']}{/if}" name="other_category" />
			-->
		</td>
	</tr>
	<tr>
		<td class="tdRight">采购单位：</td>
		<td class="tdLeft" colspan="3">{$this->data['company']}<input type="hidden" value="{$this->data['company']}" name="company" /></td>
	</tr>
	{if empty($this->data['parttime'])}
	<tr>
		<td class="tdRight">信息交易价格：</td>
		<td class="tdLeft" colspan="3">
			{if isset($this->data['pay_coin']) && $this->data['pay_coin'] == 1} 
				聚客币：{$this->data['price']}元 
				<input type="hidden" value="{$this->data['pay_coin']}" name="pay_coin" />
				<input type="hidden" value="{$this->data['price']}" name="price" />
			{/if}
			{if isset($this->data['pay_point']) && $this->data['pay_point'] == 1} 
			积分：{$this->data['point']}分 
			<input type="hidden" value="{$this->data['pay_point']}" name="pay_point" /> 
			<input type="hidden" value="{$this->data['point']}" name="point" /> 
			{/if}
		</td>
	</tr>
	{/if}
	<tr>
		<td class="tdRight">有效期：</td>
		<td class="tdLeft" colspan="3">{$this->data['open']} - {$this->data['close']}
			<input type="hidden" value="{$this->data['open']}" name="open" /> 
			<input type="hidden" value="{$this->data['close']}" name="close" />
		</td>
	</tr>
	<tr>
		<td class="tdRight">预计合作金额：</td>
		<td class="tdLeft" colspan="3">
			{$this->data['profit']}元人民币
			<input type="hidden" value="{$this->data['profit']}" name="profit" />
		</td>
	</tr>
	<tr>
		<td class="tdRight">预计合作时间：</td>
		<td class="tdLeft" colspan="3">
			{$this->data['finished']}
			<input type="hidden" value="{$this->data['finished']}" name="finished" />
		</td>
	</tr>
	<tr>
		<td class="tdRight">客户选择服务商因素：</td>
		<td class="tdLeft" colspan="3">{$this->data['reason']}
			<input type="hidden" value="{$this->data['reason']}" name="reason" />
		</td>
	</tr>
	<tr>
		<td class="tdRight">联系人：</td>
		<td class="tdLeft" colspan="3">{$this->data['contact']}
			<input type="hidden" value="{$this->data['contact']}" name="contact" />
		</td>
	</tr>
	<tr>
		<td class="tdRight">联系人职位：</td>
		<td class="tdLeft" colspan="3">{$this->data['post']}
			<input type="hidden" value="{$this->data['post']}" name="post" />
		</td>
	</tr>
	{foreach $this->data['mode'] as $key => $value}
	 <tr class="connection">
		<td class="tdRight">联系方式：</td>
		<td class="tdLeft" colspan="3">{$value} {$this->data['contact_method'][$key]}
			<input type="hidden" value="{$value}" name="mode[]" /> 
			<input type="hidden" value="{$this->data['contact_method'][$key]}" name="contact_method[]" /> 
		</td>
	</tr>
	{/foreach}
	<tr>
		<td class="tdRight">单位详细地址：</td>
		<td class="tdLeft" colspan="3">{$this->data['address']}
			<input type="hidden" value="{$this->data['address']}" name="address" />
		</td>
	</tr>
	<tr>
		<td class="tdRight">信息详情：</td>
		<td class="tdLeft" colspan="3">{$this->data['introduction']} <input type="hidden"
				value="{$this->data['introduction']}" name="introduction" />
		</td>
	</tr>
	<tr>
		<td class="tdRight">采购补充：</td>
		<td class="tdLeft" colspan="3">{$this->data['additional']}<input type="hidden"
				value="{$this->data['additional']}" name="additional" />
		</td>
	</tr>
	</tbody>
</table>

</form>
</div>
<div class="xxContent">

<div class="divProtocol"><label class="protocol" for="vehicle">
<input type="checkbox" id="accept" name="accept" class="inpCheckbox"
	style="background-image: none; background-position: initial initial; background-repeat: initial initial;">
我接受 <a href="#">《聚业务服务协议（试行）》</a> </label></div>
<div class="clear"></div>
</div>
<a class="zclan zclan2" href="javascript:void(0)" id="complete">发布</a> <a
	class="zclan zclan2" href="javascript:void(0)" id="back">修改</a></div>
</div>
</div>
</div>