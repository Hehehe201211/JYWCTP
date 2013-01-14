<div class="zy_z">
	<ul class="ulFormStep ulFormStep3">
		<li>1.填写邮箱地址和密码</li>
		<li>2.输入身份信息</li>
		<li>3.注册成功</li>
	</ul>
	<div class="sjle">
	{if $result}
		会员升级申请需要审核，可能需要2-3个工作日。<br>
		请您耐心等待，我们会在第一时间把审核结果以邮件的方式<br>
		通知你。谢谢您的合作！<br>
	{else}
		{$errorMsg}
	{/if}
	</div>
</div>