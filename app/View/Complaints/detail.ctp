<script type="text/javascript">
{literal}
$(document).ready(function(){
$("body").append($(".divDjbuz"));
	//站内信
	$("#comment_content").keydown(function(e){
	  if (e.keyCode==13) $(".reply .inpButton").click();
	});
	$('.inpButton').click(function(){
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
						if ($('#commentList h3').length == 0) {
							str = '<h3>&nbsp; </h3>';
						}
						str += '<div class="comment">';
						if (result.author) {
							str += '<div class="name sender">' + result.name + '</div>';
						} else {
							str += '<div class="name">' + result.name + '</div>';
						}
						str +='<div class="time">' + result.time + '</div><div class="content">'+ $('#comment_content').val()+'</div></div>';
						$('#commentList h3').after(str);
						$('#comment_content').val('');
					}
				}
			})
		}
	});
	
	//回复买家
	$(".btnWYTG").click(function(e){
		e.preventDefault();
		bgKuang("#djbuz","#closeKuang");
	});
	//申诉
	$(".btnWYSS").click(function(e){
		e.preventDefault();
		bgKuang("#djbuz1","#closeKuang1");
	});
	//同意投诉
	$(".btnTYTS").click(function(e) {
		$.ajax({
			url : '/complaints/agree',
			type : 'post',
			data : 'complaints_id=' + $('#complaints_id').val(),
			success : function(data) {
				var result = eval("("+data+")");
				if (result.result == "OK") {
					alert("同意投诉成功");
					location.href="/invalid/listview/?type=has";
				}
			}
		});
	});
	
	$(".payShortage").click(function(e){
		e.preventDefault();
		$(".divDjbuz").hide();
		$("#bgKuang").remove();
	});
	//回复投诉
	$('#answerBtn').click(function(){
		if($('#answer').val() == "") {
			$('#djbuz p.error').show();
		} else {
			$.ajax({
				url  : '/complaints/answer',
				type : 'post',
				data : 'information_complaints_id=' + $('#complaints_id').val() + '&answer=' + $('#answer').val(),
				success : function(data) {
					var result = eval("("+data+")");
					if (result.result == 'OK') {
						
						var str = '<div class="biaotit">投诉回答</div>'
    								+'<div class="zy_zszlB">'
      								+'<div class="txtTousu">'+result.text+'</div>'
    							+'</div>';
						$('.zy_zszlB').after(str);
						$('#reply').hide();
						$(".divDjbuz").hide();
						$("#bgKuang").remove();
						alert("发送成功。");
					} else if(result.result == 'EXIST'){
						alert("已经回复过此条投诉，不能重复回复！");
						window.location.reload();
					}
				}
			});
		}
	});	
	$(".btnJytsly").click(function(e){
		if ($('#reason').val() == "") {		
		} else {
			$.ajax({
				url : '/appeals/add',
				type : 'post',
				data : 'complaints_id=' + $('#complaints_id').val() + '&content=' + $('#reason').val() + '&type=0',
				success : function(data) {
					var result = eval("("+data+")");
					if (result.result == "OK") {
						alert("申诉提交成功");
						//location.href="/appeals/listview/has";
						location.href="/confirm/listview/?type=" + $('#info_type').val();
					}
				}
			});
		}
	});	
	
	$('#cancel').click(function(){
	   if(confirm('是否确定撤销对此信息的投诉，撤销投诉后交易将继续进行？')) {
	       $.ajax({
                url : '/complaints/cancel',
                type : 'post',
                data : 'complaints_id=' + $('#complaints_id').val(),
                success : function(data) {
                    var result = eval("("+data+")");
                    if (result.result == "OK") {
                        alert("投诉成功撤销!");
                        location.href="/complete/detail/need:" + $('#information_id').val() + "/mid:" + $('#target_members_id').val();
                        //$('#cancel').hide();
                    }
                }
            });
	   }
	});
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      {if $type == "has"}
      <a href="javascript:void(0)">我有客源</a>&gt;&gt;
      <a href="javascript:void(0)">我被投诉</a>
      <input type="hidden" id="info_type" value="has" />
      {else}
      <a href="javascript:void(0)">我要客源</a>&gt;&gt;
      <a href="javascript:void(0)">我的投诉</a>
      <input type="hidden" id="info_type" value="need" />
      {/if}
      </p>
    </div>
    {$this->element('base_seller_info')}
    <div class="biaotit">投诉原因</div>
    <div class="zy_zszlB">
      <div class="txtTousu">{$complaint.InformationComplaint.reason}<span style="margin-left:8px;" class="time">{$complaint.InformationComplaint.created}</span></div>
    </div>
    {if !empty($complaint.Answer.answer)}
    <div class="biaotit">投诉回答</div>
    <div class="zy_zszlB">
      <div class="txtTousu">{$complaint.Answer.answer}</div>
    </div>
    {/if}
   <div class="tableDetail">
        <div class="biaotit">{$information.Information.title}
            <span>
            {if $complaints_type == Configure::read('Complaint.ActiveText')}
                {$status = Configure::read('Complaint.status_active')}
            {else}
                {$status = Configure::read('Complaint.status')}
            {/if}
                {$status[$complaint.InformationComplaint.status - 1]}
            </span>
        </div>
        <table width="100%">
         <tr>
        {$provincial = $this->City->cityName($information.Information.provincial)}
        {$city = $this->City->cityName($information.Information.city)}
          <th width="25%">所在区域：</th>
          <td width="75%">{if $provincial == $city}{$provincial}{else}{$provincial}&nbsp;{$city}{/if}</td>
        </tr>
          <tr>
            <th>行业：</th>
            <td>
                {$this->Category->getCategoryName($information.Information.industries_id)}
            </td>
          </tr>
          <tr>
            <th>采购单位：</th>
            <td>
                {$information.Information.company}
            </td>
          </tr>
          <tr>
            <th>产品名称：</th>
            <td>
            {$this->Category->getCategoryName($information.Information.category)} 
            {$this->Category->getCategoryName($information.Information.sub_category)}
            </td>
          </tr>
          <tr>
            <th>客源有效期：</th>
            <td>
                {$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}
            </td>
          </tr>
          <tr>
            <th>信息交易价格：</th>
            <td>
                {if $transaction.PaymentTransaction.payment_type == 1}
                    业务币：{$transaction.PaymentTransaction.number}元
                {else if $transaction.PaymentTransaction.payment_type == 2}
                    积分：{$transaction.PaymentTransaction.number}分
                {/if}
            </td>
          </tr>
          <tr>
                <th>联系人：</th>
                <td class="red">{$information.Information.contact}</td>
          </tr>
          <tr>
                <th>联系人职位：</th>
                <td class="red">{$information.Information.post}</td>
          </tr>
          {foreach $attributes as $attribute}
            <tr>
                <th>联系方式：</th>
                <td class="red">{$attribute.InformationAttribute.mode} {$attribute.InformationAttribute.contact_method}</td>
            </tr>
          {/foreach}
          <tr>
                <th>单位详细地址：</th>
                <td class="red">{$information.Information.address}</td>
          </tr>
          <tr>
            <th>预计合作金额：</th>
            <td>{$information.Information.profit}元人民币</td>
          </tr>
          <tr>
            <th>预计合作时间：</th>
            <td>
                {$information.Information.finished|date_format:"%Y-%m-%d"}
            </td>
          </tr>
          <tr>
            <th>客户选择服务商因素：</th>
            <td>{$information.Information.reason}</td>
          </tr>
          <tr>
            <th>采购需求描述：</th>
            <td><p>{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</p></td>
          </tr>
          <tr>
            <th>采购补充：</th>
            <td><p>{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p></td>
          </tr>          
</table>	  
      {if $complaints_type == "been"}
	      <a href="javascript:void(0)" class="zclan zclan6 btnTYTS">同意投诉</a>
	      {if empty($complaint.Answer.answer)}
	      <a href="javascript:void(0)" class="zclan zclan6 btnWYTG" id="reply">回复投诉</a>
	      {/if}
	      {if empty($appeal)}
	      <a href="javascript:void(0)" class="zclan zclan6 btnWYSS">我要申诉</a>
	      {/if}
	  {else}
    	  {if $complaint.InformationComplaint.status == Configure::read('Complaint.status_code.discuss') 
    	      || $complaint.InformationComplaint.status == Configure::read('Complaint.status_code.platform')
    	  }
    	       <a href="javascript:void(0)" id="cancel" class="zclan  zclan4">撤销投诉</a>
    	  {/if}
      {/if}
      <div class="clear"></div>
    </div>    
    <div class="infoComments">
        <form id="commentList">
        {$this->element('comments_paginator')}
        </form>
    <form method="post" id="comment">
        <div class="reply">
          	<input type="text" class="txtReply inpTextBox" id="comment_content" name="content" />
	        <input type="hidden" id="information_id" name="information_id" value="{$information.Information.id}" />
	        <input type="hidden" id="members_id" name="members_id" value="{$memberInfo.Member.id}" />
	        <input type="hidden" id="target_members_id" name="target_members_id" value="{$author.Member.id}" />			
          	<input type="button" value="回复" class="inpButton">
        </div>
    </form>
      </div>
</div>
<div id="djbuz" class="divDjbuz" style="width:430px;height:200px;">
  <div class="djbuzTit"><span style="width:397px;" class="biaot">回复买家</span><a id="closeKuang" title="关闭" href="javascript:void(0)"></a></div>
  <p class="biaot_wz">信息标题<strong>：{$information.Information.title}</strong></p>
  <p class="biaot_wz error" style="text-indent:20px;text-align:left;display:none" >请输入回复内容</p>
  <p style="width:430px;padding-top:8px;" class="biaot_wz">
  <input name="information_complaints_id" type="hidden" id="complaints_id" value="{$complaint.InformationComplaint.id}" /><textarea class="txtJytsly" name="answer" id="answer"></textarea>
  </p>
  <div style="padding-left:80px;" class="biaot_an">
	  <span><a href="javascript:void(0)" id="answerBtn">确定</a></span>
	  <span><a href="javascript:void(0)" class="payShortage">取消</a></span>
  </div>
</div>

<div id="djbuz1" class="divDjbuz" style="width:430px;height:200px;">
  <div class="djbuzTit"><span style="width:397px;" class="biaot">我要申诉</span><a id="closeKuang1" class="closeKuang" title="关闭" href="#"></a></div>
  <p class="biaot_wz">信息标题<strong>：{$information.Information.title}</strong></p>
  <p class="biaot_wz" style="text-indent:20px;text-align:left;display:none" >请输入申诉理由：</p>
  <p style="width:430px;padding-top:8px;" class="biaot_wz"><textarea class="txtJytsly" id="reason" name="reason"></textarea></p>
  <div style="padding-left:80px;" class="biaot_an">
	  <span><a href="javascript:void(0)" class="btnJytsly">确定</a></span>
	  <span><a href="javascript:void(0)" class="payShortage">取消</a></span>
  </div>
</div>