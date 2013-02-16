<script type="text/javascript">
{literal}
$(document).ready(function(){
$("#checkNum").keydown(function(e){
		  if ($(this).val()!=""&&e.keyCode==13) $("#btnLogin").click();
	  });
	//登陆验证码
	$('#getCheckNum').prepend('<img id="code" src="/members/image">');
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
                        window.location.href = location.href;
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
});
function searchRe(event){
	if (event.keyCode==13) {
		var params = "";
    	if ($('#typeSel').val() != "") {
    		params = '?type=' + $('#typeSel').val();
    	}
    	if ($('#key_word').val() != "") {
    		if (params == "") {
    			params = '?key_word=' + $('#key_word').val();
    		} else {
    			params = parmas + '&key_word=' + $('#key_word').val();
    		}
    	}
    	window.location.href = '/resources/search' + params
	}
}
{/literal}
</script>
<div class="sbResource">
    <div class="login">
        <div class="frmTitle">个人会员登录</div>
        <form action="#" method="post" id="loginBox">
          <ul>
            <li>
              <label>用户名：</label>
              <input type="text" name="nickname" value="请输入用户名" id="nickname" class="username" txt="请输入用户名" />
            </li>
            <li>
              <label>密码：</label>
              <input type="password" name="password" value="" id="password" class="password"/>
              <label id="passwordL" for="password">请输入密码</label>
            </li>
            <li>
              <label>验证码：</label>
              <input type="text" name="checkNum" value="验证码" id="checkNum" class="yanzhengma" txt="验证码"/>
              <a id="getCheckNum" href="javascript:void(0)">看不清？</a></li>
            <li style="display:none;">              
              <input type="radio" name="type" value="0" checked="checked"/>
            </li>
            <li class="zinp">
	            <a id="btnLogin" class="inp" href="javascript:void(0)">登录</a>
	            <a id="btnRegister" class="inp" href="/members/register" target="_blank">免费注册</a>
	            <a class="forget" href="wangjimima.html">忘记密码</a>
            </li>
          </ul>
        </form>
      </div>
    <div class="shortcut">
      <h3>快速通道</h3>      
      <div>
      	<select id="typeSel" name="type">
      		  <option value="">选择分类</option>
		      <option value="1">入门成长</option>
		      <option value="2">培训课件</option>
		      <option value="3">客户管理</option>
		      <option value="4">方案模板</option>
		      <option value="5">总结计划</option>
		      <option value="6">案例分析</option>
	      </select>
	      <input type="text" id="key_word" class="inpTextBox" name="key_word" value="敲击回车键进行搜索" placeholder="敲击回车键进行搜索" onclick="this.select()" onkeydown="searchRe(event)"/>	      
      </div>
      <ul>
        <li><a href="/resources/search?type=1" target="_blank">入门成长</a></li>
        <li><a href="/resources/search?type=2" target="_blank">培训课件</a></li>
        <li><a href="/resources/search?type=3" target="_blank">客户管理</a></li>
        <li><a href="/resources/search?type=4" target="_blank">方案模板</a></li>
        <li><a href="/resources/search?type=5" target="_blank">总结计划</a></li>
        <li><a href="/resources/search?type=6" target="_blank">案例分析</a></li>
      </ul>
      <div class="clearfix"></div>
    </div>  
    <div class="hot">
      <h3>热门文档</h3>
      <ul>
      {foreach $hots as $document}
      	<li><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></li>
      {/foreach}
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="adResource"><img src="{$this->webroot}img/ads/201211201512.png" width="216" height="65" /></div>    
  </div>
<div class="clear">&nbsp;</div>