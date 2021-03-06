<script type="text/javascript">
{literal}
$(document).ready(function(){	
     datepIniChange("#birthday","birth");
	 $("#pay_password,#pay_account").val("");
	//提示信息
	$(".sjle input").focus(function(){
		var id=$(this).attr("id");
		var pro=$(".prompt");
		if (id=="name") {$(this).after(pro);pro.text("真实姓名用于后续充值提现出现问题时的身份认证，请准确填写。");pro.show();}
		else if (id=="mobile") {$(this).after(pro);pro.text("该号码用于后续信息交易联系，请务必准确填写。");pro.show();}
		else if (id=="pay_account") {$(this).after(pro);pro.text("该支付宝账户用于网站业务币提现时，只能转到该支付宝账号，请准确填写。");pro.show();}
		else if (id=="pay_password") {$(this).after(pro);pro.html("站内支付密码是聚业务平台中进行付款、交易确认、提现等重要操作时身份确认。<br/>为了安全，请勿设置跟登录密码及支付宝密码一样。");pro.show();}
		else if (id=="face") {$(this).after(pro);pro.text("仅支持JPG、JPEG、PNG格式，文件大小不大于200k。");pro.show();}
		else pro.hide();
	});
	
	$('#provincial').change(function(){
		$('#city').find('option:gt(0)').remove();
		if ($(this).val() != "") {
			$.ajax({
				'type' : 'Get',
				'url'  : '/informations/getCityList/' + $(this).val(),
				'success':function(data){
					var dataobj=eval("("+data+")");
					var optionStr = "";
					$.each(dataobj, function(idx, item){
						optionStr += '<option value="'+item.City.id+'">' + item.City.name + '</option>'
					});
					$('#city').append(optionStr);
				}
			})
		}
	});
	
	$('#category').change(function(){	
		$('ul.products').html('');
		if ($(this).val() != "") {
			$.ajax({
				'type'	: 'Get',
				'url'	: '/informations/getCategoryList/' + $(this).val(),
				'success':function(data) {
					var dataobj=eval("("+data+")");
					var liStr = "";
					$.each(dataobj, function(idx, item){
						liStr += '<li><input type="checkbox" class="sub_category" name="service[]" value="' + item.Category.id + '" id="products' + item.Category.id + '"><label for="products' + item.Category.id + '">' + item.Category.name + '</label></li>'
					});
					$('ul.products').html(liStr);
				}
			});
		}
		$('ul.products').parents('li').find('.errorMsg').remove();
	});
	
	$('#captcha').click(function(){
		var src = '/members/image/' + Math.random();
		$('#code').attr('src', src);
	});
	
	$('a.zclan').click(function(){
	    $(this).parents(".sjle").find(".errorMsg").remove();	
		if(!checkData()) {
			$('#member_upgread').submit();
		}
	});
   var checkTarget = ['name', 'mobile', 
                    'business_scope',
                    'pay_account', 'pay_password', 'pay_password_check'
                    ];
    var errorMsg = '<span class="errorMsg">请输入此项目</span>'	
    function checkData() {
		$(".prompt").hide();
        var error=0;
        $.each(checkTarget, function(target){
            if($('#' + this).val() == "") {
                $('#' + this).parent('li').append(errorMsg);
                error=1;
            } 
        });
        if ($('#provincial').val() == "请选择"||$('#city').val() == "")
        {
        	$('#provincial').parent().append(errorMsg);
        	error = 1;
        } 
        if ($('#category').val() == "")
        {
        	$('#category').parent().append('<span class="errorMsg">请选择项目</span>');
        	error = 1;
        } 
        if ($("input.sub_category:checked").length == 0) {
        	$('.products').parent().append('<span class="errorMsg" style="right:0">请选择项目</span>');
        	error = 1;
        } 
		if ($("#pay_password_check").val()!=""&&($("#pay_password_check").val()!==$("#pay_password").val())) {
			$('#pay_password_check').after('<span class="errorMsg">两次密码输入不一致</span>');
			error = 1
		}
        if($('#vehicle').attr('checked') != "checked") {
			$('.protocol').append('<span class="errorMsg">请接受协议内容</span>');
			error = 1
		} 
		if ($('#checkNum').val() == "") {
        	$('#checkNum').parent().append(errorMsg);
        	error = 1;
        } 
        return error;
    }
});
//{/literal}
</script>

<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html">账号管理</a>&gt;&gt;<a href="#">个人会员升级</a></p>      
    </div>    
      <ul class="ulFormStep">
        <li>1.填写个人资料</li>
        <li>2.信息确认</li>
        <li>3.升级成功</li>
      </ul>
      <div class="sjle">
       <form id="member_upgread" method="post" action="/members/upgradecheck" enctype="multipart/form-data">
        <ul>
          <li>
            <label><font class="facexh">*</font>真实姓名：</label>
            <input type="text" id="name" name="name">
          </li>
          <li>
            <label><font class="facexh">*</font>性别：</label>
            <div class="divSex">              
              <label><input type="radio" checked="checked" class="inpRadio" id="sex1" name="sex" value="1">男</label>              
              <label><input type="radio" class="inpRadio" id="sex2" name="sex" value="0">女</label>
            </div>
          </li>
          <li>
             <label>生日：</label>
             <input type="text" readonly="readonly" id="birthday" name="birthday" class="inpTextBox">
          </li>
          <li>
            <label><font class="facexh">*</font>手机号码：</label>
            <input type="text" name="mobile" id="mobile" onpaste="onlyNum(this)" onkeyup="onlyNum(this)">
          </li>
          <li>
            <label>联系电话：</label>
            <input type="text" name="telephone" id="telephone" onpaste="phoneNum(this)" onkeyup="phoneNum(this)">
          </li>
          <li>
            <label><font class="facexh">*</font>所在城市：</label>
            <select name="provincial" id="provincial">
                <option>请选择</option>
                {foreach $cities as $city}
                	<option value="{$city.City.id}">{$city.City.name}</option>
                {/foreach}
              </select>
            <select name="city" id="city">
                <option value="">请选择</option>
              </select>
          </li>
          <li>
            <label>公司名称：</label>
            <input type="text" name="company" id="company">
          </li>
          <li>
            <label><font class="facexh">*</font>从事行业：</label>
            <select id="category" name="category">
                  <option value="">请选择</option>
                  {foreach $category as $cate}
                  	<option value="{$cate.Category.id}">{$cate.Category.name}</option>
                  {/foreach}
                </select>
          </li>
          <li>
            <label>其他行业：</label>
            <input type="text" id="other_category" name="other_category">
          </li>
          <li>
            <label><font class="facexh">*</font>提供产品或服务：</label>
            <ul class="products">
            </ul>
          </li>
          <li>
            <label><font class="facexh">*</font>业务范围：</label>
            <input type="text" name="business_scope" id="business_scope">
          </li>          
          <li>
            <label><font class="facexh">*</font>支付宝绑定：</label>
            <input type="text" name="pay_account" id="pay_account" onpaste="Emailstr(this)" onkeyup="Emailstr(this)">
          </li>
          <li>
            <label><font class="facexh">*</font>站内支付密码：</label>
            <input type="password" name="pay_password" id="pay_password">
          </li>
          <li>
            <label><font class="facexh">*</font>确认站内支付密码：</label>
            <input type="password" name="pay_password_check" id ="pay_password_check">
          </li>
          <li>
            <label>上传头像：</label>
            <input type="file" style="height:22px;" size="20" id="face" name="face">
          </li>
          <li style="text-align:left;">
            <label><font class="facexh">*</font>验证码：</label>
            <input type="text" name="checkNum" style="width:60px;" id="checkNum">
			<a id="captcha" href="javascript:;"><img id="code" src="/members/image">看不清楚？换一个</a>
          </li>
          <li>
            <label class="protocol" for="vehicle">
              <input type="checkbox" id="vehicle" name="vehicle" class="inpCheckbox">
              我接受 <a href="/static?tpl=mianze" target="_blank">《聚业务服务协议（试行）》</a>
            </label>
          </li>
          <li><a href="javascript:void(0)" class="zclan zclan4">提交</a></li>
        </ul>
        </form>        
      </div>
    </div> 
    <div class='prompt' style="display:none">真实姓名用于后续充值提现出现问题时的身份认证，请准确填写。</div>