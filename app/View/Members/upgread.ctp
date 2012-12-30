<script>
$(document).ready(function(){

	$('#checkNum').after('<img style="margin-left:10px" id="code" src="/members/image">');
	$('#getCheckNum').click(function(){
		console.log("img");
		var src = '/members/image/' + Math.random();
		$('#code').attr('src', src);
	});
	
	$('#upgread').click(function(){
		var error = false;
		if ($('#name').val() == "") {
			error = true;
			if ($('#name + span').length == 0) {
				$('#name').after('<span style="color:red; margin-left:10px">请输入真实姓名</span>');
			}
		} else {
			$('#name + span').remove()
		}
		
		if ($('#UID').val() == "") {
			error = true;
			if ($('#UID + span').length == 0) {
				$('#UID').after('<span style="color:red; margin-left:10px">请输入身份证号</span>');
			}
		} else {
			$('#UID + span').remove()
		}
		if ($('#birthday').val() == "") {
			error = true;
			if ($('#birthday + span').length == 0) {
				$('#birthday').after('<span style="color:red; margin-left:10px">请输入出身日期</span>');
			}
		} else {
			$('#birthday + span').remove()
		}
		if ($('#telephone').val() == "") {
			error = true;
			if ($('#telephone + span').length == 0) {
				$('#telephone').after('<span style="color:red; margin-left:10px">请输入电话号码</span>');
			}
		} else {
			$('#telephone + span').remove()
		}
		if ($('#checkNum').val() == "") {
			error = true;
			if ($('#checkNum').parent().find('span').length == 0) {
				$('#checkNum').parent().append('<span style="color:red; margin-left:10px">请输入验证码</span>');
			}
		} else {
			$('#checkNum').parent().find('span').remove()
		}
		if ($('#accept').attr("checked") != "checked") {
			error = true;
			if ($('#accept + p + span').length == 0) {
				$('#accept + p').after('<span style="color:red; margin-left:10px">请接受协议</span>');
			}
		} else {
			$('#accept + p + span').remove();
		}
		if(!error) {
			$('#member_upgread').submit();
		}
	});
	
});

</script>

<div class="zy_z">
<div class="hysj">
	<ul>
		<li>1.填写邮箱地址和密码</li>
		<li>2.输入身份信息</li>
		<li>3.注册成功</li>
	</ul>
	<div class="sjle">
		<form method="post" id="member_upgread" action="/members/upgreadfinish" enctype="multipart/form-data">
		<div class="le">
			<dl>
				<dt>
					<label><font class="facexh">*</font>真实姓名：</label>
					<input type="text" id="name" name="name">
				</dt>
				<dt>
					<label><font class="facexh">*</font>身份证号：</label>
					<input type="text" id="UID" name="UID">
				</dt>
				<dt>
					<label><font class="facexh">*</font>出身日期：</label>
					<input type="text" id="birthday" name="birthday">
				</dt>
				<dt>
					<label><font class="facexh">*</font>手机号：</label>
					<input type="text" id="telephone" name="telephone">
				</dt>
			</dl> 
			<div class="le_sczp">
				<label><font class="facexh">*</font>上传头像：</label>
				<input type="file" size="20" id="profile" name="profile">
			</div> 
			<div style="width:500px;" class="sj_yzm">
				<label><font class="facexh">*</font>验证码：</label>
				<input width="110" type="text" id="checkNum" name="checkNum">
				<em><a href="javascript:void(0)" id="getCheckNum">换一个</a></em>
			</div> 
			<div style="margin-top:8px;" class="zcl">
				<input type="checkbox" name="accept" id="accept">
				<p>我接受 <span>《聚客源服务协议（试行）》</span></p>
			</div>
			<div class="zclan"><a href="javascript:void(0)" id="upgread">升级</a></div>
		</div>
		</form>
	</div>
</div>
</div>