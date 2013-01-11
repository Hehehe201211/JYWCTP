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
<ul class="ulFormStep ulFormStep2">
      <li>1.填写发布信息</li>
      <li>2.确认信息</li>
      <li>3.发布成功</li>
    </ul>
<div class="sjle">
<div class="tableDetail">
<form action="/informations/complete" method="post" id="form">
<input type="hidden" name="type" id="type" value="{$this->data['type']}">
<input type="hidden" name="target" value="{$this->data['target']}">
<input type="hidden" name="parttime" value="{$this->data['parttime']}">
<input type="hidden" name="target_member" value="{$this->data['target_member']}">
<div class="biaotit">{$this->data['title']}<input type="hidden" value="{$this->data['title']}" name="title" /></div>
      <table width="100%">
        <tr>       
          <th width="25%">所在区域：</th>
          <td width="75%">{$provincial}<input type="hidden" value="{$this->data['provincial']}" name="provincial" />&nbsp;{$city}<input type="hidden" value="{$this->data['city']}" name="city" /></td>
        </tr>
         <tr>
          <th>行业：</th>
          <td>{$industry}
			<input type="hidden" value="{$this->data['industries_id']}" name="industries_id" /></td>
        </tr>
        <tr>
          <th>采购产品：</th>
          <td>{$this->Category->getCategoryName($this->data['category'])}
			{$this->Category->getCategoryName($this->data['sub_category'])}
			{if isset($this->data['other_category']) && $this->data['other_category'] != '请输入产品名称 '}{$this->data['other_category']}{/if}
			<input type="hidden" value="{$this->data['category']}" name="category" />
			<input type="hidden" value="{$this->data['sub_category']}" name="sub_category" />
			<!--
			<input type="hidden" value="{if isset($this->data['other_category'])}{$this->data['other_category']}{/if}" name="other_category" />
			--></td>
        </tr>
        <tr>
          <th>采购单位：</th>
          <td class="red">{$this->data['company']}<input type="hidden" value="{$this->data['company']}" name="company" /></td>
        </tr>
        {if empty($this->data['parttime'])}
	<tr>
		<th>信息交易价格：</th>
		<td>
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
          <th>有效期：</th>
          <td>{$this->data['open']} - {$this->data['close']}
			<input type="hidden" value="{$this->data['open']}" name="open" /> 
			<input type="hidden" value="{$this->data['close']}" name="close" /></td>
        </tr>
        <tr>
          <th>预计合作金额：</th>
          <td>{$this->data['profit']}元人民币
			<input type="hidden" value="{$this->data['profit']}" name="profit" /></td>
        </tr>
        <tr>
          <th>预计合作时间：</th>
          <td>{$this->data['finished']}
			<input type="hidden" value="{$this->data['finished']}" name="finished" /></td>
        </tr>
        <tr>
          <th>联系人：</th>
          <td class="red">{$this->data['contact']}
			<input type="hidden" value="{$this->data['contact']}" name="contact" /></td>
        </tr>
        <tr>
          <th>联系人职位：</th>
          <td class="red">{$this->data['post']}
			<input type="hidden" value="{$this->data['post']}" name="post" /></td>
        </tr>
        {foreach $this->data['mode'] as $key => $value}
        <tr>
          <th>联系方式：</th>
          <td class="red">{$value} {$this->data['contact_method'][$key]}
			<input type="hidden" value="{$value}" name="mode[]" /> 
			<input type="hidden" value="{$this->data['contact_method'][$key]}" name="contact_method[]" /> </td>
        </tr>
	{/foreach}
        <tr>
          <th>单位详细地址：</th>
          <td class="red">{$this->data['address']}
			<input type="hidden" value="{$this->data['address']}" name="address" /></td>
        </tr>        
        <tr>
          <th>信息详情：</th>
          <td>{$this->data['introduction']} <input type="hidden"
				value="{$this->data['introduction']}" name="introduction" /></td>
        </tr>
        <tr>
          <th>客户选择服务商因素：</th>
          <td>{$this->data['reason']}
			<input type="hidden" value="{$this->data['reason']}" name="reason" /></td>
        </tr>        
        <tr>
          <th>采购补充：</th>
          <td><p>{$this->data['additional']}<input type="hidden"
				value="{$this->data['additional']}" name="additional" /></p></td>
        </tr>
      </table>
      </form>
      <div class="divProtocol"><label class="protocol" for="vehicle">
<input type="checkbox" id="accept" name="accept" class="inpCheckbox"/>
我接受 <a href="#">《聚业务服务协议（试行）》</a> </label></div>
      <div class="divBtnContainer" style="width:200px;">
	<a class="zclan zclan7" href="javascript:void(0)" id="complete">发布</a> <a
	class="zclan zclan7" href="javascript:void(0)" id="back">修改</a>
    </div>
    </div>
</div>
</div>