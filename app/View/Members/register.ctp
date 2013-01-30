<script type="text/javascript">
{literal}
$(document).ready(function(){
    var existEmail = false;
    var existNickname = false
    $('#email').blur(function(){		
        if ($('#email').val() != "" && checkEmailFormat($('#email').val())) {
			$(this).parent().find(".errorMsg").remove();
            $.ajax({
                type:    'post',
                url :    '/members/existMember',
                data:     'email=' + $('#email').val() + "&type=0",
                success    : function(data) {
                    $('#email + span').remove();
                    if(data == '1') {
                        $('#email').after('<span class="errorMsg">这个邮箱已经被注册！</span>');
                        existEmail = true;
                    } else {
                        existEmail = false;
                    }
                }
            })
        }
    });
    
    $('#nickname').blur(function(){
        if ($('#nickname').val() != "") {
			$(this).parent().find(".errorMsg").remove();
            $.ajax({
                type:    'post',
                url :    '/members/existMember',
                data:     'nickname=' + $('#nickname').val() + "&type=0",
                success    : function(data) {
                    $('#nickname + span').remove();
                    if(data == '1') {
                       $('#nickname').after('<span class="errorMsg">这个用户名已经被注册！</span>');
                        existNickname = true;
                    } else {
                        existNickname = false;
                    }                    
                }
            })
        }
    });    
    
    $('#register').click(function(){
        if (existEmail || existNickname) {
            return false;
        }
        var error = false;
		$(this).parent().find(".errorMsg").remove();
        if($('#nickname').val() == "") {
            error = true;
            $('#nickname').after('<span class="errorMsg">请输入用户名</span>');
        } else {
            $('#nickname + span').remove()
        }
        if($('#passwordR').val() == "") {
            error = true;
            $('#passwordR').after('<span class="errorMsg">请输入密码</span>');
        } else {
            $('#passwordR + span').remove()
        }
        if($('#checkpassword').val() == "") {
            error = true;
            $('#checkpassword').after('<span class="errorMsg">请输入确认密码</span>');
        } else {
            $('#checkpassword + span').remove()
        }
        if($('#email').val() == "") {
            error = true;
            $('#email').after('<span class="errorMsg">请输入邮箱</span>');
        } else {
            $('#email + span').remove();
        }
        if ($('#personal_accept').attr("checked") != "checked") {
            error = true;
           $('#personal_accept + a').after('<span class="errorMsg">请接受协议</span>');
        } 
        if (!error) {
            if($('#passwordR').val() !== $('#checkpassword').val()) {
                error = true;
               $('#checkpassword').after('<span class="errorMsg">确认密码和密码不一致</span>');
            } else {
                $('#checkpassword + span').remove()
            }
        }        
        if (!error) {
            if (!checkEmailFormat($('#email').val())) {
                error = true;
                $('#email').after('<span class="errorMsg">请输入有效邮箱</span>');
            } else {
                $('#email + span').remove();
            }
        }        
        if(!error) {
            $('#member_register').submit();
        }
    });
    
    //企业会员注册
        $('#email_company').blur(function(){
        if ($('#email_company').val() != "" && checkEmailFormat($('#email_company').val())) {
			$(this).parent().find(".errorMsg").remove();
            $.ajax({
                type:    'post',
                url :    '/members/existMember',
                data:     'email=' + $('#email_company').val() + "&type=1",
                success    : function(data) {
                    $('#email_company + span').remove();
                    if(data == '1') {
                        $('#email_company').after('<span class="errorMsg">这个邮箱已经被注册！</span>');
                        existEmail = true;
                    } else {
                        existEmail = false;
                    }
                }
            })
        }
    });
    
    $('#nickname_company').blur(function(){
        if ($('#nickname_company').val() != "") {
			$(this).parent().find(".errorMsg").remove();
            $.ajax({
                type:    'post',
                url :    '/members/existMember',
                data:     'nickname=' + $('#nickname_company').val() + "&type=1",
                success    : function(data) {
                    $('#nickname_company + span').remove();
                    if(data == '1') {
                        $('#nickname_company').after('<span class="errorMsg">这个用户名已经被注册！</span>');
                        existNickname = true;
                    } else {
                        existNickname = false;
                    }
                    
                }
            })
        }
    });
    var companyCheckTarget = ['nickname_company', 'company_name', 'password_company', 'checkpassword_company', 'email_company'];
    var errorMsg = '<span class="errorMsg">请输入此项目</span>'
    $('#register_company').click(function(){
    	var error=false;
		$(this).parent().find(".errorMsg").remove();
        $.each(companyCheckTarget, function(target){
            if($('#' + this).val() == "") {
                $('#' + this).parent().append(errorMsg);
                error = true;
            }
        });
        if (!error) {
            if ($('#password_company').val() != $('#checkpassword_company').val()) {
                $('#checkpassword_company').parent().append('<span class="errorMsg">确认密码不一致</span>');
                error = true;
            }
            if (!checkEmailFormat($('#email_company').val())) {
                $('#email_company').parent().append('<span class="errorMsg">请输入有效邮箱</span>');
                error = true;
            }
        }
        if ($('#personal_accept_company').attr("checked") != "checked") {
            error = true;
            $('#personal_accept_company + a').after('<span class="errorMsg">请接受协议</span>');
        }
        if(!error) {
            $('#company_register').submit();
        }
    });  
    //check number
    $('#yanzhengma').after('<img id="code" src="/members/image">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
	$("#yanzhengma").keydown(function(e){
		  if ($(this).val()!=""&&e.keyCode==13) $("#btnLogin").click();
	  });
    //login
    $('#btnLogin').click(function(e){
        var msg = '';
        var error = false;
        var nickname = $('#loginBox input[name="nickname"]').val();
        var password = $('#loginBox input[name="password"]').val();
        var checkNum = $('#loginBox input[name="checkNum"]').val();
        var type = $('#loginBox input[name="type"]:checked').val();
        if (nickname == '' || nickname == '请输入用户名') {
            msg = '<li>请输入用户名</li>'
            error = true;
        }
        if (password == '') {
            msg += '<li>请输入密码</li>';
            error = true;
        }
        if (checkNum == '' || checkNum == '输入验证码') {
            msg += '<li>请输入验证码</li>';
            error = true;
        }
        if (type == null) {
            msg += '<li>请选择类型</li>';
            error = true;
        }
        if (error) {
            e.preventDefault();
            $('#loginWarning .question').html(msg);
            $("#loginWarning").fadeIn("fast");
            var t=setTimeout("hideWarning()",10000);            
        }
        
        if(!error) {
             params = "nickname=" + nickname + "&password=" + password + "&checkNum=" + checkNum + "&type=" + type;
             $.ajax({
                type : 'post',
                url  : '/members/ajaxlogin',
                data : params,
                success : function(data) {
                    if (data == '') {
                        window.location.href = '/members'
                    }                    
                    if (data != '') {
                        msg = '<li>' + data + '</li>';
                        $('#loginWarning ul').html(msg);
                        $("#loginWarning").fadeIn("fast");
                        var t=setTimeout("hideWarning()",10000);
                    } else {
                        $('#loginWarning').hide();
                    }                    
                }
             });
         }
    });
    $(".titleZC").click(function(){
		$(this).parent().find(".errorMsg").remove();
        $(".titleZC:eq(0)").next().slideToggle("normal");
        $(".titleZC:eq(1)").next().slideToggle("normal");
      });
    // email format check
    function checkEmailFormat(email)
    {
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
        return reg.test(email);
    }
});
function hideWarning(){
    $("#loginWarning").fadeOut("slow");
}
{/literal}
</script>

<div id="zccon">
  <div class="le">
    <h1 class="titleZC">个人用户注册</h1>
    <div style="height:260px;">
      <form id="member_register" action="/members/check" method="post">
        <dl>
          <dt>
            <label><font class="facexh">*</font>用户名：</label>
            <input type="text" name="nickname" id="nickname"/>
          </dt>
          <dt>
            <label><font class="facexh">*</font>密码：</label>
            <input type="password" name="password" id="passwordR"/>
          </dt>
          <dt>
            <label><font class="facexh">*</font>确认密码：</label>
            <input type="password" name="checkpassword" id="checkpassword"/>
          </dt>
          <dt>
            <label><font class="facexh">*</font>邮箱：</label>
            <input type="text" name="email" id="email"/>
          </dt>
        </dl>
        <div class="zcl">
          <input type="hidden" name="type" value="0"/>
          {if $fromMember}
          <input type="hidden" name="mid" value="{$this->request->query['mid']}"/>
          {/if}
          <label>
            <input type="checkbox" name="personal" id="personal_accept"/>
            我接受 <a href="/static?tpl=mianze" class="protocol" target="_blank">《聚业务服务协议（试行）》</a></label>
        </div>
        <a class="zclan" href="javascript:void(0)" id="register">注册</a>
      </form>
    </div>
    <h1 class="titleZC titleZCH">企业用户注册</h1>
    <div style="display:none;">
      <form id="company_register" action="/members/check" method="post">
        <dl>
          <dt>
            <label><font class="facexh">*</font>用户名：</label>
            <input type="text" name="nickname" id="nickname_company"/>
          </dt>
          <dt>
            <label><font class="facexh">*</font>公司名称：</label>
            <input type="text" name="company_name" id="company_name"/>
          </dt>
          <dt>
            <label><font class="facexh">*</font>密码：</label>
            <input type="password" name="password" id="password_company">
          </dt>
          <dt>
            <label><font class="facexh">*</font>确认密码：</label>
            <input type="password" name="checkpassword" id="checkpassword_company">
          </dt>
          <dt>
            <label><font class="facexh">*</font>邮箱：</label>
            <input type="text" name="email" id="email_company"/>
          </dt>
        </dl>
        <div class="zcl">
          <input type="hidden" name="type" value="1"/>
          <label>
            <input type="checkbox" name="personal" id="personal_accept_company"/>
            我接受 <a href="/static?tpl=mianze" class="protocol" target="_blank">《聚业务服务协议（试行）》</a></label>
        </div>
        <a class="zclan" href="javascript:void(0)" id="register_company">注册</a>
      </form>
    </div>
  </div>
  <div class="ri">
    <div class="ris">已有聚业务帐号？</div>
    <div class="login">
      <h1>会员登录</h1>
      <form id="loginBox" method="post" action="#">
        <ul>
          <li>
            <label>用户名：</label>
            <input type="text" name="nickname" value="请输入用户名" id="username" class="username" txt="请输入用户名" />
          </li>
          <li>
            <label>密码：</label>
            <input type="password" class="password" id="password" value="" name="password">
            <label for="password" id="passwordL" style="display: block;">请输入密码</label>
          </li>
          <li>
            <label>验证码：</label>
            <input type="text" name="checkNum" value="验证码" class="yanzhengma" id="yanzhengma" txt="验证码"/>
          <li style="text-align:right"><a href="javascript:void(0)" id="getCheckNum">看不清楚？换一个</a></li>
          <li>
            <label>类型：</label>
            <label class="tL">
              <input type="radio" id="person" class="inpRadio" checked="checked" value="0" name="type">
              个人</label>
            <label class="tL">
              <input type="radio" id="enterprise" class="inpRadio" value="1" name="type">
              企业</label>
          </li>
          <li><a class="inp" id="btnLogin" href="javascript:void(0)"> 登录</a><a href="wangjimima.html" style="text-decoration:underline;">忘记密码</a></li>
        </ul>
      </form>
    </div>
    <div class="zcdt"><img src="/img/zc_dt.jpg" /></div>
    <div id="loginWarning">
      <div class="area">
        <div class="notice">登录出现错误</div>
        <ul class="question">
        </ul>
      </div>
      <div class="arrow"></div>
    </div>
  </div>
</div>
