<script type="text/javascript">
{literal}
$(document).ready(function(){
    var m=$("#email").text().indexOf("@")+1;
	var str="mail."+$("#email").text().slice(m);
	$("#email").attr("href","http://"+str);
});
//{/literal}
</script>
<div class="renzheng">
{if !$error}
<p><strong>尊敬的 {$nickname}：</strong><br/>
&nbsp;&nbsp;欢迎您加入聚业务。<br/>
&nbsp;&nbsp;为了保证每个会员的真实性，请您于24小时之内点击登陆邮箱（<a href="#" target="_blank" id="email">{$email}</a>），查收邮件并验证其有效性；<br/>
&nbsp;&nbsp;如果提供的邮箱登陆网址有误，请在地址栏中手动输入，谢谢您的合作！<br/><br>
&nbsp;&nbsp;<strong style="color:#FF3300">聚业务将竭诚为您服务！</strong><br/></p>
{else}
<p>{$errorMsg}</p>
{/if}
</div>