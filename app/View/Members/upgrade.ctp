<script type="text/javascript">
{literal}
$(document).ready(function(){	
	//提示信息
	$(".sjle>form>ul>li>input:eq(0)").focus(function(){
		$(this).after("<div class='prompt'>真实姓名用于后续充值提现出现问题时的身份认证，请准确填写。</div>");
	});
	$(".sjle>form>ul>li>input:eq(0)").blur(function(){
		$(this).next().remove();
	});
	$(".sjle>form>ul>li>input:eq(2)").focus(function(){
		$(this).after("<div class='prompt'>该号码用于后续信息交易联系，请务必准确填写。</div>");
	});
	$(".sjle>form>ul>li>input:eq(2)").blur(function(){
		$(this).next().remove();
	});
	$(".sjle>form>ul>li>input:eq(7)").focus(function(){
		$(this).after("<div class='prompt'>该支付宝账户用于网站业务币提现时，只能转到该支付宝账号，请准确填写。</div>");
	});
	$(".sjle>form>ul>li>input:eq(7)").blur(function(){
		$(this).next().remove();
	});
	$(".sjle>form>ul>li>input:eq(8)").focus(function(){
		$(this).after("<div class='prompt'>站内支付密码是聚业务平台中进行付款、交易确认、提现等重要操作时身份确认。<br/>为了安全，请勿设置跟登录密码及支付宝密码一样。</div>");
	});
	$(".sjle>form>ul>li>input:eq(8)").blur(function(){
		$(this).next().remove();
	});
	$(".sjle>form>ul>li>input:file").focus(function(){
		$(this).after("<div class='prompt'>仅支持JPG、JPEG、PNG格式，文件大小不大于200k。</div>");
	});
	$(".sjle>form>ul>li>input:file").blur(function(){
		$(this).next().remove();
	});
	
	datepIniChange("#birthday","birth");
	
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
	});
	
	$('#captcha').click(function(){
		var src = '/members/image/' + Math.random();
		$('#code').attr('src', src);
	});
	
	$('a.zclan').click(function(){
		if(!checkData()) {
			$('#member_upgread').submit();
		}
	});
   var checkTarget = ['name', 'mobile', 
                    'telephone', 'business_scope',
                    'pay_account', 'pay_password', 'pay_password_check'
                    ];
    var errorMsg = '<span style="color:red" class="errorMsg">请输入此项目</span>'
    function checkData() 
    {
        var error=0;
        $.each(checkTarget, function(target){
            if($('#' + this).val() == "") {
                if($('#' + this).parent('li').find('.errorMsg').length == 0) {
                    $('#' + this).parent('li').append(errorMsg);
                }
                error=1;
            } else {
                $('#' + this).parent('li').find('.errorMsg').remove();
            }
        });
        if ($('#provincial').val() == "请选择"||$('#city').val() == "")
        {
        	if ($('#provincial').parent().parent().find('.errorMsg').length == 0) {
        		$('#provincial').parent().parent().append(errorMsg);
        	}
        	error = 1;
        } else {
        	$('#provincial').parent().parent().find('.errorMsg').remove();
        }
        if ($('#category').val() == "")
        {
        	if ($('#category').parent().parent().find('.errorMsg').length == 0) {
        		$('#category').parent().parent().append(errorMsg);
        	}
        	error = 1;
        } else {
        	$('#category').parent().parent().find('.errorMsg').remove();
        }
        if ($("input.sub_category:checked").length == 0){
        	if ($('.products').parent().find('.errorMsg').length == 0) {
        		$('.products').parent().append(errorMsg);
        	}
        	error = 1;
        } else {
        	$('.products').parent().find('.errorMsg').remove();
        }
        if($('#vehicle').attr('checked') != "checked") {
			if ($('.protocol').children('span').length==0) $('.protocol').append('<span style="color:red">请接受协议内容</span>');
			error = 1
		} else {
			$('.protocol span').remove();
		}
		if ($('#checkNum').val() == "")
        {
        	if ($('#checkNum').parent().find('.errorMsg').length == 0) {
        		$('#checkNum').parent().append(errorMsg);
        	}
        	error = 1;
        } else {
        	$('#checkNum').parent().parent().find('.errorMsg').remove();
        }
        return error;
    }
});
{/literal}
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
              <input type="radio" checked="checked" class="inpRadio" id="sex1" name="sex" value="1">
              <label for="sex1">男</label>
              <input type="radio" class="inpRadio" id="sex2" name="sex" value="0">
              <label for="sex2">女</label>
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
            <div class="area1">
              <select name="provincial" id="provincial">
                <option>请选择</option>
                {foreach $cities as $city}
                	<option value="{$city.City.id}">{$city.City.name}</option>
                {/foreach}
              </select>
            </div>
            <div class="area1">
              <select name="city" id="city">
                <option value="">请选择</option>
              </select>
            </div>
          </li>
          <li>
            <label>公司名称：</label>
            <input type="text" name="company" id="company">
          </li>
          <li>
            <label><font class="facexh">*</font>从事行业：</label>
            <div class="area1">
            <select id="category" name="category">
                  <option value="">请选择</option>
                  {foreach $category as $cate}
                  	<option value="{$cate.Category.id}">{$cate.Category.name}</option>
                  {/foreach}
                </select>
              </div>
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
        </ul>  
        <ul>        
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
            <input type="file" style="height:auto;height:22px;" size="20" id="face" name="face">
          </li>
          <li style="text-align:left;">
            <label><font class="facexh">*</font>验证码：</label>
            <input type="text" name="checkNum" style="width:60px;" id="checkNum">
			<a id="captcha" href="javascript:;"><img id="code" src="/members/image">看不清楚？换一个</a>
          </li>
          <li>
            <label class="protocol" for="vehicle">
              <input type="checkbox" id="vehicle" name="vehicle" class="inpCheckbox">
              我接受 <a href="/static?tpl=mianze">《聚业务服务协议（试行）》</a>
            </label>
          </li>
          <li><a href="javascript:void(0)" class="zclan zclan4">提交</a></li>
        </ul>
        </form>        
      </div>
    </div> 