<script type="text/javascript">
{literal}
$(document).ready(function(){
    var existEmail = false;
    var existNickname = false

    $('#email').blur(function(){
        if ($('#email').val() != "" && checkEmailFormat($('#email').val())) {
            $.ajax({
                type:    'post',
                url :    '/members/existMember',
                data:     'email=' + $('#email').val() + "&type=0",
                success    : function(data) {
                    $('#email + span').remove();
                    if(data == '1') {
                        if ($('#email + span').length == 0) {
                            $('#email').after('<span style="color:red; margin-left:10px">这个邮箱已经被注册！</span>');
                        }
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
            $.ajax({
                type:    'post',
                url :    '/members/existMember',
                data:     'nickname=' + $('#nickname').val() + "&type=0",
                success    : function(data) {
                    $('#nickname + span').remove();
                    if(data == '1') {
                        if ($('#nickname + span').length == 0) {
                            $('#nickname').after('<span style="color:red; margin-left:10px">这个用户名已经被注册！</span>');
                        }
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
        if($('#nickname').val() == "") {
            error = true;
            if ($('#nickname + span').length == 0) {
                $('#nickname').after('<span style="color:red; margin-left:10px">请输入用户名</span>');
            }
        } else {
            $('#nickname + span').remove()
        }
        if($('#passwordR').val() == "") {
            error = true;
            if ($('#passwordR + span').length == 0) {
                $('#passwordR').after('<span style="color:red; margin-left:10px">请输入密码</span>');
            }
        } else {
            $('#passwordR + span').remove()
        }
        if($('#checkpassword').val() == "") {
            error = true;
            if ($('#checkpassword + span').length == 0) {
                $('#checkpassword').after('<span style="color:red; margin-left:10px">请输入确认密码</span>');
            }
        } else {
            $('#checkpassword + span').remove()
        }
        if($('#email').val() == "") {
            error = true;
            if ($('#email + span').length == 0) {
                $('#email').after('<span style="color:red; margin-left:10px">请输入邮箱</span>');
            }
        } else {
            $('#email + span').remove();
        }
        if ($('#personal_accept').attr("checked") != "checked") {
            error = true;
            if ($('#personal_accept + p + span').length == 0) {
                $('#personal_accept + p').after('<span style="color:red; margin-left:10px">请接受协议</span>');
            }
        } else {
            $('#personal_accept + p + span').remove();
        }
        if (!error) {
            if($('#passwordR').val() !== $('#checkpassword').val()) {
                error = true;
                if ($('#checkpassword + span').length == 0) {
                    $('#checkpassword').after('<span style="color:red; margin-left:10px">确认密码和密码不一致</span>');
                }
            } else {
                $('#checkpassword + span').remove()
            }
        }
        
        if (!error) {
            if (!checkEmailFormat($('#email').val())) {
                error = true;
                if ($('#email + span').length == 0) {
                    $('#email').after('<span style="color:red; margin-left:10px">请输入有效邮箱</span>');
                }
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
            $.ajax({
                type:    'post',
                url :    '/members/existMember',
                data:     'email=' + $('#email_company').val() + "&type=1",
                success    : function(data) {
                    $('#email_company + span').remove();
                    if(data == '1') {
                        if ($('#email_company + span').length == 0) {
                            $('#email_company').after('<span style="color:red; margin-left:10px">这个邮箱已经被注册！</span>');
                        }
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
            $.ajax({
                type:    'post',
                url :    '/members/existMember',
                data:     'nickname=' + $('#nickname_company').val() + "&type=1",
                success    : function(data) {
                    $('#nickname_company + span').remove();
                    if(data == '1') {
                        if ($('#nickname_company + span').length == 0) {
                            $('#nickname_company').after('<span style="color:red; margin-left:10px">这个用户名已经被注册！</span>');
                        }
                        existNickname = true;
                    } else {
                        existNickname = false;
                    }
                    
                }
            })
        }
    });
    var companyCheckTarget = ['nickname_company', 'company_name', 'password_company', 'checkpassword_company', 'email_company'];
    var errorMsg = '<span style="color:red" class="errorMsg">请输入此项目</span>'
    $('#register_company').click(function(){
    	var error=false;
        $.each(companyCheckTarget, function(target){
            $('#' + this).parent().find('.errorMsg').remove();
            if($('#' + this).val() == "") {
                $('#' + this).parent().append(errorMsg);
                error = true;
            }
        });
        if (!error) {
            if ($('#password_company').val() != $('#checkpassword_company').val()) {
                $('#checkpassword_company').parent().append('<span style="color:red" class="errorMsg">确认密码不一致</span>');
                error = true;
            }
            if (!checkEmailFormat($('#email_company').val())) {
                $('#email_company').parent().append('<span style="color:red" class="errorMsg">请输入有效邮箱</span>');
                error = true;
            }
        }
        if ($('#personal_accept_company').attr("checked") != "checked") {
            error = true;
            if ($('#personal_accept_company + p + span').length == 0) {
                $('#personal_accept_company + p').after('<span style="color:red; margin-left:10px">请接受协议</span>');
            }
        } else {
            $('#personal_accept_company + p + span').remove();
        }
        if(!error) {
            $('#company_register').submit();
        }
    });
    $("#yanzhengma").keypress(function(e){
		  if ($(this).val()!=""&&e.keyCode==13) $("#btnLogin").click();
	  });
    
    //check number
    $('#yanzhengma').after('<img id="code" src="/members/image">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
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
          $(".titleZC:eq(0)").next("form").children("div").slideToggle("normal");
          $(".titleZC:eq(1)").next("form").children("div").slideToggle("normal");
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
    <form id="member_register" action="/members/check" method="post">
    <div style="height:401px;">
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
        <input type="checkbox" name="personal" id="personal_accept"/>
        <input type="hidden" name="type" value="0"/>
        <p>我接受 <a href="#" class="protocol">《聚业务服务协议（试行）》</a></p>
      </div>
      <div><a class="zclan" href="javascript:void(0)" id="register">注册</a></div>
    </div>
    </form>
    <h1 class="titleZC titleZCH">企业用户注册</h1>
    <form id="company_register" action="/members/check" method="post">
    <div style="display:none;">
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
        <input type="checkbox" name="personal" id="personal_accept_company"/>
        <input type="hidden" name="type" value="1"/>
        <p>我接受 <a href="#" class="protocol">《聚业务服务协议（试行）》</a></p>
      </div>
      <div><a class="zclan" href="javascript:void(0)" id="register_company">注册</a></div>
    </div>
      </form>
  </div>
  <div class="ri">
    <div class="ris">已有聚业务帐号？</div>
    <div class="login">
      <h1>会员登录</h1>
      <form id="loginBox" method="post" action="#">
      <ul>
        <li>
          <label>用户名：</label>
          <input type="text" onblur="txtBlur(this.id,'请输入用户名')" onfocus="txtFocus(this.id,'请输入用户名')" class="nickname" id="username" value="请输入用户名" name="nickname" style="color: rgb(153, 153, 153);">
        </li>
        <li>
          <label>密码：</label>
          <input type="password" class="password" id="password" value="" name="password"> 
          <label for="password" id="passwordL" style="display: block;">请输入密码</label>
        </li>
        <li>
          <label>验证码：</label>
          <input type="text" onblur="txtBlur(this.id,'输入验证码')" onfocus="txtFocus(this.id,'输入验证码')" class="yanzhengma" id="yanzhengma" value="输入验证码" name="checkNum" style="color: rgb(153, 153, 153);">
          <li style="text-align:right"><a href="javascript:void(0)" id="getCheckNum">看不清楚？换一个</a></li>
        <li><span>
          <label>类型：</label>
            </span> <span style="width:60px; float:left;">
            <input type="radio" id="person" class="login_input" checked="checked" value="0" name="type">
            <label for="person" style="width:30px;">个人</label>
            </span> <span style="width:60px; float:left;">
            <input type="radio" id="enterprise" class="login_input" value="1" name="type">
            <label for="enterprise" style="width:30px;">企业</label>
          </span> </li>
        <li><a class="inp" id="btnLogin" href="javascript:void(0)"> 登录</a><a href="wangjimima.html" style="text-decoration:underline;">忘记密码</a></li>    
      </ul>
      </form>
    </div>
    <!--
    <div class="login" style=" background:#f6f6f6; border:none;">
      <h1>会员登录</h1>
      <p><img src="/img/huiyx.jpg" style="width:200px; margin:0 auto 5px;"/></p>
      <ul>
      <form id="ajaxLogin">
        <li>
          <label>账号：</label>
          <input type="text" name="nickname"/>
        </li>
        <li>
          <label>密码：</label>
          <input type="password" name="password">
        </li>
        <li>
          <label>验证码：</label>
          <input type="text"  value="" name="checkNum" id="checkNum"  class="txt2" style="height:20px; width:63px; line-height:20px; margin-right:5px;" />
        </li>
        <li style="text-align:right"><a href="javascript:void(0)" id="getCheckNum">看不清楚？换一个</a></li>
        <li><span>
          <label>类型：</label>
          </span> <span style="width:60px; float:left;">
          <input type="radio" name="type" value="0" class="login_input"/>
          <label style="width:40px;">个人：</label>
          </span> <span style="width:60px; float:left;">
          <input type="radio" name="type" value="1" class="login_input" />
          <label style="width:40px;">企业：</label>
          </span> </li>
        <li class="zinp"> <span class="inp"><a id="btnLogin" href="javascript:void(0)"> 登录</a></span> <span><a href="wangjimima.html" style="text-decoration:underline;">忘记密码</a></span></li>     
      </ul>
    </div>
    -->
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