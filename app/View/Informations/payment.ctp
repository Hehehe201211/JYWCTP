<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("body").append($("#djbuz"));
	$(".moreInfo").click(function(e){
		if ($('#bgKuang').length == 0) {
			$("body").append("<div id='bgKuang'></div>");
		}
		$("#bgKuang").css({width:$(document).width(),height:$(document).height()});
		$("#bgKuang").fadeTo("fast",0.5,function(){
			$("#djbuz").css({"top":$(window).scrollTop()+220+"px","left":($(document).width()-$("#djbuz").width())/2+"px","display":"block"});
		});
		e.preventDefault();
	});
	$("#closeKuang,#payJukebi,#payJifen").click(function(){
		$("#djbuz").css("display","none");
		$('#bgKuang').remove();
	});
	
	$('#yanzhengma').after('<img style="height:20px" id="code" src="/members/image">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
    
    $('#btnNext').click(function(){
    	var error = false;
    	if ($('#payPassword').val() == "") {
    		if ($('#payPasswordErr').length == 0) {
    			var msg = '<span style="color:red" id="payPasswordErr">请输入支付密码</span>';
    			$('#payPasswordMsg').html(msg);
    			error = true;
    		}
    	} else {
			$('#payPasswordMsg').html('');
		}
    	if ($('#yanzhengma').val() == "") {
    		if ($('#yanzhengmaErr').length == 0) {
    			var msg = '<span style="color:red" id="yanzhengmaErr">请输入验证码</span>';
    			$('#getCheckNum').after(msg);
    			error = true;
    		}
    	} else {
			$('#yanzhengmaErr').remove();
		}
		if (!error) {
	    	var data = $("#payment").serialize();
	    	$.ajax({
	    		type : 'post',
	    		url : '/payment/pay',
	    		data : data,
	    		success : function(data) {
	    			if (data != "") {
	    				var result = eval("("+data+")");
	    				if (result.result == 'error') {
		    				if (result.field == 'pay_passwrod') {
		    					if ($('#payPasswordErr').length == 0) {
					    			var msg = '<span style="color:red" id="payPasswordErr">支付密码错误</span>';
					    			$('#payPasswordMsg').html(msg);
					    		} else {
					    			$('#payPasswordErr').html('支付密码错误');
					    		}
					    		
		    				} else if(result.field == 'checkNum') {
		    					if ($('#yanzhengmaErr').length == 0) {
					    			var msg = '<span style="color:red" id="yanzhengmaErr">' + result.msg + '</span>';
					    			$('#getCheckNum').after(msg);
					    		} else {
					    			$('#yanzhengmaErr').html(result.msg);
					    		}
		    				}
	    				} else {
	    				   var info_type = $('#type').val();
	    				   var mid = $('#members_id').val();
	    				   if(info_type == 0) {
	    				       location.href = '/confirm/detail/need:' + $('#information_id').val() + '/mid:' + mid;
	    				   } else {
	    				       location.href = '/confirm/detail/has:' + $('#information_id').val() + '/mid:' + mid;
	    				   }
	    				}
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
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html.html">我要客源</a>&gt;&gt;<a href="#">客源检索</a></p>      
      <div class="hx"></div>
    </div>    
    {$this->element('base_seller_info')}
    <div class="tableDetail">
<div class="biaotit">{$information.Information.title}</div>
      <table width="100%">
        <tr>
        {$provincial = $this->City->cityName($information.Information.provincial)}
        {$city = $this->City->cityName($information.Information.city)}        
        <th width="25%">所在区域：</th>
        <td width="75%">{if $provincial == $city}{$provincial}{else}{$provincial}&nbsp;{$city}{/if}</td>
        </tr>
        <tr>
          <th>行业：</th>
          <td>{$this->Category->getCategoryName($information.Information.industries_id)}</td>
        </tr>
        <tr>
          <th>采购产品：</th>
          <td>{$this->Category->getCategoryName($information.Information.category)} 
		{$this->Category->getCategoryName($information.Information.sub_category)}
		{$this->Category->getCategoryName($information.Information.other_category)}
</td>
        </tr>
        <tr>
          <th >采购单位：</th>
          <td class="red">{if $paid}
		{$information.Information.company}
		{else}
		******
		{/if}
</td>
        </tr>       
 <tr>
          <th>联系人：</th>
          <td class="red">{if $paid}
			    {$information.Information.contact}
			{else}
			    ******
			{/if}</td>
        </tr>
        <tr>
          <th>联系人职位：</th>
          <td class="red">{if $paid}
                {$information.Information.post}
            {else}
                ******
            {/if}</td>
        </tr>
         {foreach $attributes as $attr}
        <tr>
          <th>联系方式：</th>
          <td class="red">{if $paid}
                {$attr.InformationAttribute.contact_method}
            {else}
                ******
            {/if}</td>
        </tr>
 {/foreach}
 <tr>
          <th>联系人地址：</th>
          <td class="red">{if $paid}
                {$information.Information.address}
            {else}
                ******
            {/if}</td>
        </tr>        
        <tr>
          <th>信息交易价格：</th>
          <td>{if $information.Information.payment_type == 1}
				业务币：{$information.Information.price}元
			{else if $information.Information.payment_type == 2}
				积分：{$information.Information.point}分
			{else}
				业务币：{$information.Information.price}元；积分：{$information.Information.point}分
			{/if}
</td>
        </tr>     
        <tr>
          <th>有效期：</th>
          <td>{$information.Information.open} - {$information.Information.close} </td>
        </tr>   
        <tr>
          <th>预计合作金额：</th>
          <td>{$information.Information.profit}元人民币</td>
        </tr>
        <tr>
          <th>预计合作时间：</th>
          <td>{$information.Information.finished}</td>
        </tr>
        <tr>
          <th>客户选择服务商因素：</th>
          <td>{$information.Information.reason}</td>
        </tr>
        {if $type=="has" && $memberInfo.Member.grade < 1}
				<tr>
					<th>&nbsp;</th>
					<td><em>你的会员等级不足以购买此信息，是否立即<a target="_blank" href="/members/upgrade">提升会员等级</a>？</em></td>
				</tr>
				{/if}
        <tr>
          <th>信息描述：</th>
          <td><p>
			{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</p></td>
        </tr>
        <tr>
          <th>采购补充：</th>
          <td><p>
			{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p></td>
        </tr>
      </table>
      {if !$paid && $memberInfo.Member.grade > 1}<a id="btnXuyao" class="moreInfo zclan zclan4" href="javascript:void(0)">我需要</a>{/if}
    </div>
    </div>

<div style="width:550px;display:none;position:absolute;z-index:100;" id="djbuz">
<form id="payment">
<input name="type" value="{$information.Information.type}" type="hidden" id="type" />
  <div  class="djbuzTit"><span class="fk_tit">支付确认</span><a id="closeKuang" title="关闭" href="javascript:void(0)"></a></div>
  <table class="payTable">
  <tr>
    <th colspan="3"><span>{$memberInfo.Member.nickname}</span> 业务币余额：<span>{$memberInfo.Attribute.virtual_coin}</span>元 &nbsp;&nbsp;积分：<span>{$memberInfo.Attribute.point}</span>分</th>
    </tr>
  <tr>
    <td class="payTableTil">信息标题：</td>
    <td colspan="2">{$information.Information.title}<input name="information_id" id="information_id" value="{$information.Information.id}" type="hidden" />
    <input name="members_id" id="members_id" value="{$information.Information.members_id}" type="hidden" /></td>    
    </tr>
  <tr>
    <td class="payTableTil">支付方式：</td>
    {if $information.Information.payment_type == 1}
	    <td width="147">
		    <input type="radio" name="pay_method" id="zffsJKB" checked="checked" value="coin"/>
		    <label for="zffsJKB">业务币支付：
		    	<span>{$information.Information.price}</span>元
		    </label>
		    <input name="virtual_coin" value="{$information.Information.price}" type="hidden" />
	    </td>
		<td width="212">&nbsp;</td>
    {else if $information.Information.payment_type == 2}
	    <td width="147">&nbsp;</td>
	    <td width="212">
	    	<input type="radio" name="pay_method" id="zffsJF" checked="checked" value="point" />
		    <label for="zffsJF">积分支付：
		    <span>{$information.Information.point}</span>分
		    </label>
		    <input name="point" value="{$information.Information.point}" type="hidden" />
	    </td>
    {else}
    	<td width="147">
		    <input type="radio" name="pay_method" id="zffsJKB" checked="checked" value="coin"/>
		    <label for="zffsJKB">业务币支付：
		    	<span>{$information.Information.price}</span>元
		    </label>
		    <input name="virtual_coin" value="{$information.Information.price}" type="hidden" />
	    </td>
	    <td width="212"><input type="radio" name="pay_method" id="zffsJF" value="point" />
		    <label for="zffsJF">积分支付：
		    <span>{$information.Information.point}</span>分
		    </label>
		    <input name="point" value="{$information.Information.point}" type="hidden" />
	    </td>
    {/if}
  </tr>
  <tr>
    <td class="payTableTil">支付密码：</td>
    <td><input type="password" name="pay_password" id="payPassword" style="height:18px;"/></td>
    <td id="payPasswordMsg">&nbsp;</td>
  </tr>
  <tr>
    <td height="27" class="payTableTil">验证码：</td>
    <td colspan="2">
	    <input id="yanzhengma" class="yanzhengma" type="text" name="checkNum" style="height:18px;">
	    <a id="getCheckNum" href="javascript:void(0)" style="display:inline;background:none;float:none;">&nbsp;看不清楚？换一个</a>
    </td>
  </tr>
  <tr>
    <td height="27" class="payTableTil">买家留言：</td>
    <td colspan="2">
	    <textarea name="content" cols="40"> </textarea>
    </td>
  </tr>
  
  <tr>
    <td colspan="3" style="padding-left:120px;padding-top:10px;"><input type="button"  value="确认支付" class="ui-btn-text" id="btnNext"/></th>
    </tr>
</table>
</form>
</div>