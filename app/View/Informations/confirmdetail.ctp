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
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html.html">{if $info_type=="need"}我要客源{else}我有客源{/if}</a>&gt;&gt;<a href="#">待确认交易</a></p>
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
          <td>{$this->Category->getCategoryName($information.Information.industries_id)}</td>
        </tr>
        <tr>
          <th>采购产品：</th>
          <td class="red">{$this->Category->getCategoryName($information.Information.category)}
			{$this->Category->getCategoryName($information.Information.sub_category)}
</td>
        </tr>
        <tr>
          <th>采购单位</th>
          <td class="red"> {$information.Information.company}</td>
        </tr>               
        <tr>
          <th>信息交易价格：</th>
          <td>{if $paymentTransaction.PaymentTransaction.payment_type == 1}
			聚客币：{$paymentTransaction.PaymentTransaction.number}元 
			{else $paymentTransaction.PaymentTransaction.payment_type == 2}
			积分：{$paymentTransaction.PaymentTransaction.number}分 
			{/if}</td>
        </tr> 
        <tr>
          <th>有效期：</th>
          <td>{$information.Information.open|date_format:"%Y-%m-%d"} -
			{$information.Information.close|date_format:"%Y-%m-%d"}</td>
        </tr>
        <tr>
          <th>预计合作金额：</th>
          <td>{if empty($information.Information.profit)}0{else}{$information.Information.profit}{/if}元人民币</td>
        </tr>
        <tr>
          <th>预计合作时间：</th>
          <td>{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
        </tr>
        <tr>
          <th>联系人：</th>
          <td class="red">{$value.InformationAttribute.contact}</td>
        </tr>
        <tr>
          <th>联系人职位：</th>
          <td class="red">{$value.InformationAttribute.post}</td>
        </tr>
        {foreach $attributes as $value}
        <tr>
          <th>联系方式：</th>
          <td class="red">{$value.InformationAttribute.contact_method}</td>
        </tr>
        {/foreach}
        <tr>
          <th>单位详细地址：</th>
          <td class="red">{$value.InformationAttribute.address}</td>
        </tr>       
        <tr>
          <th>客户选择服务商因素：</th>
          <td>{$information.Information.reason}</td>
        </tr>
        <tr>
          <th>信息详情：</th>
          <td><P>{$information.Information.introduction}</P></td>
        </tr>
        <tr>
          <th>采购补充：</th>
          <td><p>{$information.Information.additional}</p></td>
        </tr>
      </table>
     {if $info_type=="need"}            
            {if !$complainted}
            	<a href="javascript:void(0)" class="zclan  zclan4 btnTrdComplete">交易完成</a>
             {else}<div class="divBtnContainer" style="width:200px;">
             <a href="javascript:void(0)" class="zclan zclan7 btnTrdComplete">交易完成</a><a href="javascript:void(0)" class="zclan zclan7 btnTousu">投诉</a>
             </div>
            {/if}
    {/if}
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
	<div class="fanye">
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
<div style="width:430px;height:200px;display: none;z-index:99;" id="djbuz">
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
    
    
    