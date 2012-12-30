<script type="text/javascript">
{literal}
$(document).ready(function(){
	$(".btnTousu").click(function(e){
		if ($('#bgKuang').length == 0) {
			$("body").append("<div id='bgKuang'></div>");
		}
		$("#bgKuang").css({width:$(document).width(),height:$(document).height()});
		$("#bgKuang").fadeTo("fast",0.5,function(){
			$("#djbuz").css({"top":$(window).scrollTop()+220+"px","left":($(document).width()-$("#djbuz").width())/2+"px","display":"block"});
		});
		e.preventDefault();
	});
	$("#closeKuang,.payShortage").click(function(){
		$("#djbuz").css("display","none");
		$('#bgKuang').remove();
	});
	//投诉
	$('#complaintsBtn').click(function(){
		if ($('#content').val() == "") {
			
		} else {
			var data = $('#complaints').serialize();
			$.ajax({
				type : 'post',
				url  : '/informations/complaint',
				data : data,
				success : function(data) {
					var result = eval("("+data+")");
					if (result.result == 'OK') {
						$("#djbuz").css("display","none");
						$('#bgKuang').remove();
						$('.btnTousu').hide();
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
						if ($('#xq_huif h3').length == 0) {
							str = '<h3>&nbsp; </h3>';
						}
						str += '<div class="xq_huif_tet">'+
								'<p class="xq_huif_tet11">';
						str += '<strong class="sender">' + result.name + '</strong>';
						str += $('#comment_content').val()+
								'</p>'+
								'<p class="xq_huif_riq">' + result.time + '</p>'+
							'</div>';
						$('#comment').before(str);
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
						location.href = '/informations/closedetail/?need=' + information_id;
					}
				}
			})
		}
	});
});

{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs"><!-- InstanceBeginEditable name="EditRegion7" -->
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html.html">{if $info_type=="need"}我要客源{else}我有客源{/if}</a>&gt;&gt;<a href="#">待确认交易</a></p>
    <!-- InstanceEndEditable -->
    </div>
    <!-- InstanceBeginEditable name="EditRegion5" --> 
    {$this->element('base_seller_info')}
    <div class="xq_zl">
      <div class="xq_zl_xbxq">
        <div class="biaotit">{$information.Information.title}<span>（交易中）</span></div>
        <table width="570">
	<tbody>
		<tr>
			<td width="132" class="tdRight">省份：</td>
			<td width="57" class="tdLeft">{$this->City->cityName($information.Information.provincial)}</td>
			<td width="42" class="tdRight">城市：</td>
			<td width="319" class="tdLeft">{$this->City->cityName($information.Information.city)}</td>
		</tr>
		<tr>
			<td width="132" class="tdRight">行业：</td>
			<td class="tdLeft" colspan="3">{$this->Category->getCategoryName($information.Information.industries_id)}
			</td>
		</tr>
		<tr>
			<td class="tdRight">采购产品：</td>
			<td class="tdLeft" colspan="3">
			{$this->Category->getCategoryName($information.Information.category)}
			{$this->Category->getCategoryName($information.Information.sub_category)}
			</td>
		</tr>
		<tr>
			<td class="tdRight">采购单位：</td>
			<td class="tdLeft" colspan="3">{$information.Information.company}
			</td>
		</tr>
		<tr>
			<td class="tdRight">信息交易价格：</td>
			<td class="tdLeft" colspan="3">
			{if $paymentTransaction.PaymentTransaction.payment_type == 1}
			聚客币：{$paymentTransaction.PaymentTransaction.number}元 
			{else $paymentTransaction.PaymentTransaction.payment_type == 2}
			积分：{$paymentTransaction.PaymentTransaction.number}分 
			{/if}
			</td>
		</tr>
		<tr>
			<td class="tdRight">有效期：</td>
			<td class="tdLeft" colspan="3">{$information.Information.open|date_format:"%Y-%m-%d"} -
			{$information.Information.close|date_format:"%Y-%m-%d"}</td>
		</tr>
		<tr>
			<td class="tdRight">预计合作金额：</td>
			<td class="tdLeft" colspan="3">
			{$information.Information.profit}元人民币</td>
		</tr>
		<tr>
			<td class="tdRight">预计合作时间：</td>
			<td class="tdLeft" colspan="3">
			{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
		</tr>
		<tr>
			<td class="tdRight">客户选择服务商因素：</td>
			<td class="tdLeft" colspan="3">{$information.Information.reason}
			</td>
		</tr>
		{foreach $attributes as $value}
		<tr class="connection">
			<td colspan="6"><span> <label>联系人：</label>{$value.InformationAttribute.contact}
			</span> <span> <label>联系人职位：</label>{$value.InformationAttribute.post}
			</span> <span> <label>联系人地址：</label>{$value.InformationAttribute.address}
			</span> <span> <label> 联系方式：</label>{$value.InformationAttribute.contact_method}
			</span></td>
		</tr>
		{/foreach}
	</tbody>
</table>
        
      </div>
      <div class="biaotit">信息详情</div>
      <div class="xxContent">
        <div class="description" id="zhiwei">
          <table cellspacing="0" cellpadding="0">
            <tbody><tr>
              	<td>
              		{$information.Information.introduction}
				</td>
            </tr>
          </tbody>
          </table>
        </div>
        <div class="clear"></div>
      </div>
      <div class="biaotit">采购补充</div>
      <div class="xxContent">
        <div class="description" id="zhiwei">
          <table cellspacing="0" cellpadding="0">
            <tbody><tr>
              <td>{$information.Information.additional}</td>
            </tr>
          </tbody></table>
        </div>
        <div class="clear"></div>
        {if $info_type=="need"}
            <a href="javascript:void(0)" class="zclan zclan2 zclan3 btnTrdComplete">交易完成</a>
            {if !$complainted}
            	<a href="javascript:void(0)" class="zclan zclan2 btnTousu">投诉</a>
            {/if}
        {/if}
      </div>
    </div>
    <div id="xq_huif">
    {if count($comments) > 0}
    	<h3>&nbsp; </h3>
    	{foreach $comments as $comment}
    		<div class="xq_huif_tet">
		        <p class="xq_huif_tet11">
		        	{if $comment.InformationComment.members_id == $memberInfo.Member.id}
		        		<strong class="sender">我</strong>
		        	{else}
		        		<strong>{$comment.Member.nickname}</strong>
		        	{/if}
			        {$comment.InformationComment.content}
		        </p>
		        <p class="xq_huif_riq">{$comment.InformationComment.created}</p>
	        </div>
        {/foreach}
    {/if}
	<div class="pagesMag">
            <div class="fanye fanyefr">
              <div class="dd_span"><a href="#">上一页</a></div>
              <div class="dd_ym">
                <label>每页显示：</label>
                <select>
                  <option>100</option>
                  <option>50</option>
                  <option>20</option>
                  <option>10</option>
                </select>
              </div>
              <div class="dd_ym11"> <font>共64388条</font> <font>第1/644页</font>
                <input class="inpTextBox">
                <div class="dd_span1"><a href="#">跳转</a></div>
              </div>
              <div class="dd_span"><a href="#">下一页</a></div>
            </div>
          </div>		
      <form method="post" id="comment">
      <p class="xq_huif_centr_toprr">
        <input type="text" class="txtReply inpTextBox" id="comment_content" name="content" />
        <input type="hidden" name="information_id" value="{$information.Information.id}" />
        <input type="hidden" name="target_members_id" value="{$author.Member.id}" />
        <input type="button" class="btnReply" value="回复">
      </p>
      </form>
    </div>
	<!-- InstanceEndEditable --> 
    </div>
    
<div style="width: 430px; height: 200px; top: 1219px; left: 576.5px; display: none; position: absolute; z-index: 100;" id="djbuz">
<form id="complaints">
<div style="width:430px;height:200px;" id="djbuz">
  <div class="djbuzTit"><span class="biaot" style="width:397px;">投诉此信息</span><a href="#" title="关闭" id="closeKuang"></a></div>
  <p class="biaot_wz">信息标题<strong>：{$information.Information.title}</strong>&nbsp;&nbsp;&nbsp;&nbsp;发布人：<strong>{$author.Member.nickname}</strong></p>
  <p style="text-indent:20px;text-align:left;" class="biaot_wz">请输入投诉此信息理由：</p>
  <p class="biaot_wz" style="width:430px;padding-top:8px;"><textarea class="txtJytsly" name="content" id="content"></textarea></p>
  <input type="hidden" id="information_id" name="information_id" value="{$information.Information.id}" />
  <input type="hidden" name="target_members_id" value="{$author.Member.id}" />
  <input type="hidden" name="members_id" value="{$memberInfo.Member.id}" />
  <div class="biaot_an" style="padding-left:80px;">
	  <span>
	  	<a class="btnJytsly" href="javascript:void(0)" id="complaintsBtn">确定</a>
	  </span>
	  <span>
	  	<a class="payShortage" href="javascript:void(0)">取消</a>
	  </span>
  </div>
</div>
</form>
</div>
    
    
    