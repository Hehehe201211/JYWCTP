<script type="text/javascript">
{literal}
$(document).ready(function(){
	$('.cancel').click(function(){
		if (confirm("你确定要撤销此信息吗？")) {
			$.ajax({
				url : '/informations/ajax_cancel',
				type : 'post',
				data : 'information_id=' + $('#information_id').val(),
				success : function(data){
					var result = eval("("+data+")");
					if (result.result == 'OK') {
						//$('.buttons').hide();
						location.href = "/cancel/listview";
					} else {
						alert(result.msg);
					}
				}
			});
		}
	});
});
{/literal}
</script>
<div class="zy_z">	
		<div class="sjle">
			<div class="xq_zl">
				<div class="xq_zl_xbxq">
					<div class="biaotit">{$information.Information.title}</div>
					<table width="570">
						<tbody>
							<tr>
								<td width="132" class="tdRight">省份：</td>
								<td width="57" class="tdLeft">{$this->City->cityName({$information.Information.provincial})}</td>
								<td width="42" class="tdRight">城市：</td>
								<td width="319" class="tdLeft">{$this->City->cityName({$information.Information.city})}</td>
							</tr>
							{if $information.Information.type == 0}
    							<tr>
    								<td width="132" class="tdRight">行业：</td>
    								<td class="tdLeft" colspan="3">{$this->Category->getCategoryName({$information.Information.industries_id})}</td>
    							</tr>
							{/if}
							<tr>
								<td class="tdRight">采购产品：</td>
								<td class="tdLeft" colspan="3">
									{$this->Category->getCategoryName({$information.Information.category})}
									{$this->Category->getCategoryName({$information.Information.sub_category})}
								</td>
							</tr>
							<tr>
								<td class="tdRight">采购单位：</td>
								<td class="tdLeft" colspan="3">{$information.Information.company}</td>
							</tr>
							<tr>
								<td class="tdRight">信息交易价格：</td>
								<td class="tdLeft" colspan="3">
    								{if $information.Information.payment_type != 2}聚客币：{$information.Information.price}元{/if}
    								{if $information.Information.payment_type != 1}积分：{$information.Information.point}分{/if}
								</td>
							</tr>
							{if $information.Information.type == 0}
							<tr>
								<td class="tdRight">联系人：</td>
								<td class="tdLeft" colspan="3">
									{$information.Information.contact}
								</td>
							</tr>
							<tr>
								<td class="tdRight">联系人职位：</td>
								<td class="tdLeft" colspan="3">
									{$information.Information.post}
								</td>
							</tr>
							{foreach $attributes as $att}
								<tr>
								<td class="tdRight">联系方式：</td>
								<td class="tdLeft" colspan="3">{$att.InformationAttribute.mode} {$att.InformationAttribute.contact_method}</td>		
							</tr>
							{/foreach}
							<tr>
								<td class="tdRight">单位详细地址：</td>
								<td class="tdLeft" colspan="3">
								{$information.Information.address}
								</td>
							</tr>
							{/if}
							<tr>
								<td class="tdRight">有效期：</td>
								<td class="tdLeft" colspan="3">
								{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}
								</td>
							</tr>
							{if $information.Information.type == 0}
							<tr>
								<td class="tdRight">预计合作金额：</td>
								<td class="tdLeft" colspan="3">{if empty($information.Information.profit)}0{else}{$information.Information.profit}{/if}元人民币</td>
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
                            <tr>
								<td class="tdRight">采购需求描述：</td>
								<td class="tdLeft" colspan="3"><p>{$information.Information.introduction}</p></td>
							</tr>
                            <tr>
								<td class="tdRight">采购补充：</td>
								<td class="tdLeft" colspan="3"><p>{$information.Information.additional}</p></td>
							</tr>
						</tbody>
					</table>
				</div>
				{if !$paid}
							<a class="zclan zclan5" href="/informations/edit?id={$information.Information.id}">修改</a>
        <a class="zclan zclan5 cancel" href="javascript:void(0)">撤销</a>
        <a class="zclan zclan5" href="javascript:void(0)">删除</a>
							<input type="hidden" id="information_id" value="{$information.Information.id}" />							
					        {/if}
			</div>
		</div>
</div>