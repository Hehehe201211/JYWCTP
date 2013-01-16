<script type="text/javascript">
{literal}
$(document).ready(function(){
	$("body").append($(".divDjbuz"));
	$(".btnTousu").click(function(){
		bgKuang("#divDjbuz1",".divDjbuz .closeKuang");
	});
	$(".payShortage").click(function(){
		$(".divDjbuz .closeKuang").click();
	});
	
	//投诉
	$('#complaintsBtn').click(function(){
		if ($('#complaints_content').val() == "") {
			alert('请输入投诉原因！');
		} else {
			var data = $('#complaints').serialize();
			$.ajax({
				type : 'post',
				url  : '/complaints/add',
				data : data,
				success : function(data) {
					var result = eval("("+data+")");
					if (result.result == 'OK') {
						//location.href = '/complaints/index/active'
						location.href = '/confirm/listview/?type=' + $('#info_type').val();
					} else {
					   alert(result.msg);
					   location.reload();
					}
				}
			});
		}
	});
	//站内信
	$('.btnReply').click(function(){
		if($('#comment_content').val() != "") {
			var data = $('#comment').serialize();
			$.ajax({
				type : 'post',
				url  : '/informations/comment/',
				data : data,
				success : function(data) {
					var result = eval("("+data+")");
					if (result.result == 'OK') {
						var str = "";
						
						str += '<div class="xq_huif_tet">'+
								'<p class="xq_huif_tet11">';
						str += '<strong class="sender">' + result.name + '</strong>';
						str += $('#comment_content').val()+
								'</p>'+
								'<p class="xq_huif_riq">' + result.time + '</p>'+
							'</div>';
						if ($('#commentList h3').length == 0) {
							str = '<h3>&nbsp; </h3>' + str;
							$('#commentList').append(str);
						} else {
							$('#commentList h3').after(str);
						}
						
						$('#comment_content').val('');
					}
				}
			})
		}
	});
	//完成按钮
	$('.btnTrdComplete').click(function(){
		if (confirm("你真的要完成交易吗？")) {
			var information_id = $('#information_id').val();
			$.ajax({
				type : 'post',
				url  : '/informations/close',
				data : 'information_id=' + information_id,
				success : function(data) {
					var result = eval("("+data+")");
					if (result.result == 'OK') {
						location.href = '/complete/detail/need:' + information_id + '/mid:' + $('#target_members_id').val();
					}
				}
			})
		}
	});
});
{/literal}
</script>

  <div class="zy_z">
    <div class="zy_zs">
      <p>
          <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
          <a href="javascript:void(0)">
          {if $type=="need"}我要客源
          <input type="hidden" id="info_type" value="need" />
          {else}我有客源
          <input type="hidden" id="info_type" value="has" />
          {/if}</a>&gt;&gt;
          <a href="javascript:void(0)">待确认交易</a>
      </p>    
    </div>    
    {$this->element('base_seller_info')}
<div class="tableDetail">
        <div class="biaotit">{$information.Information.title}<span>（交易中）</span></div>
        <table width="100%">
   <tr>
          <th width="25%">所在区域：</th>
          <td width="75%">{$this->City->cityName($information.Information.provincial)}&nbsp;{$this->City->cityName($information.Information.city)}</td>
        </tr>		
		<tr>
			<th>行业：</th>
			<td>{$this->Category->getCategoryName($information.Information.industries_id)}
			</td>
		</tr>
		<tr>
			<th>采购产品：</th>
			<td>
			{$this->Category->getCategoryName($information.Information.category)}
			{$this->Category->getCategoryName($information.Information.sub_category)}
			</td>
		</tr>
		<tr>
			<th>采购单位：</th>
			<td>{$information.Information.company}
			</td>
		</tr>
        <tr>
			<th>联系人：</th>
			<td class="red">{$information.Information.contact}
			</td>
		</tr>
		<tr>
			<th>联系人职位：</th>
			<td class="red">{$information.Information.post}
			</td>
		</tr>
		{foreach $attributes as $value}
		<tr>
            <th>联系方式：</th>
			<td class="red">{$value.InformationAttribute.mode} {$value.InformationAttribute.contact_method}
			</td>
		</tr>
		{/foreach}
		<tr>
			<th>联系人地址：</th>
			<td>{$information.Information.address}
			</td>
		</tr>
		<tr>
			<th>信息交易价格：</th>
			<td>
			{if $transaction.PaymentTransaction.payment_type == 1}
			业务币：{$transaction.PaymentTransaction.number}元 
			{/if} 
			{if $transaction.PaymentTransaction.payment_type == 2}
			积分：{$transaction.PaymentTransaction.number}分 
			{/if}
			</td>
		</tr>
		<tr>
			<th>有效期：</th>
			<td>{$information.Information.open|date_format:"%Y-%m-%d"} -
			{$information.Information.close|date_format:"%Y-%m-%d"}</td>
		</tr>
		<tr>
			<th>预计合作金额：</th>
			<td>
			{$information.Information.profit}元人民币</td>
		</tr>
		<tr>
			<th>预计合作时间：</th>
			<td>
			{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
		</tr>
		<tr>
			<th>客户选择服务商因素：</th>
			<td>{$information.Information.reason}
			</td>
		</tr>		
        <tr>
			<th>信息详情：</th>
			<td>{$information.Information.introduction}
			</td>
		</tr>
        <tr>
			<th>采购补充：</th>
			<td>{$information.Information.additional}
			</td>
		</tr>
</table>        
<div class="divBtnContainer" style="width:200px;">
      {if $information.Information.members_id != $memberInfo.Member.id}
        	<a href="javascript:void(0)" class="zclan zclan7 btnTrdComplete">交易完成</a>
        {/if}
        {if !$complainted}
        	<a href="javascript:void(0)" class="zclan zclan7 btnTousu">投诉</a>
        {/if}
        </div>
</div>
    <div id="xq_huif">
    <form id="commentList">
    {$this->element('comments_paginator')}
    </form>
      <form method="post" id="comment">
      <p class="xq_huif_centr_toprr">
        <input type="text" class="txtReply inpTextBox" id="comment_content" name="content" />
        <input type="hidden" name="information_id" value="{$information.Information.id}" />
        <input type="hidden" name="target_members_id" value="{$author.Member.id}" />
        <input type="button" class="btnReply" value="回复">
      </p>
      </form>
    </div>	
    </div>
    
<div style="width:430px;" id="divDjbuz1" class="divDjbuz">
<form id="complaints">
  <div class="djbuzTit"><span class="biaot" style="width:397px;">投诉此信息</span><a href="#" title="关闭" class="closeKuang"></a></div>
  <p class="biaot_wz">信息标题：<strong>{$information.Information.title}</strong></p>
  <p class="biaot_wz">发布人：<strong>{$author.Member.nickname}</strong></p>
  <p class="biaot_wz">请输入投诉此信息理由：</p>
  <p class="biaot_wz"><textarea class="txtJytsly" name="content" id="complaints_content"></textarea></p>
  <input type="hidden" id="information_id" name="information_id" value="{$information.Information.id}" />
  <input type="hidden" name="target_members_id" value="{$author.Member.id}" id ="target_members_id"/>
  <input type="hidden" name="members_id" value="{$memberInfo.Member.id}" />
  <div class="biaot_an" style="padding-left:80px;">
	  <span>
	  	<a class="btnJytsly" href="javascript:void(0)" id="complaintsBtn">确定</a>
	  </span>
	  <span>
	  	<a class="payShortage" href="javascript:void(0)">取消</a>
	  </span>
  </div> 
</form>
</div>