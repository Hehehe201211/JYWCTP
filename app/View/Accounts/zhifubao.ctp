<a href="#" class="closeDiv">&nbsp;</a>
<div class="biaotit">支付宝修改</div>
<div class="sjle sjleBold" style="margin-top:0;">
<div class="info">&nbsp;<span class="errorMsg"></span></div>
<form id="ezhifubao">
    <ul>
	<li>
        <label><font class="facexh">*</font>请输入支付密码：</label>
        <input type="password" name="old_password" id="old_password" />
      </li>
      <li>
        <label><font class="facexh">*</font>请输入旧支付宝 ：</label>
        <input type="text" name="old_zhifubao" id="old_zhifubao" onkeyup="Emailstr(this)" onpaste="Emailstr(this)"/>
      </li>
      <li>
        <label><font class="facexh">*</font>请输入新支付宝：</label>
        <input type="text" name="new_zhifubao" id="new_zhifubao" onkeyup="Emailstr(this)" onpaste="Emailstr(this)"/>
      </li>
      <input type="hidden" name="type" value="zhifubao" />
    </ul>
</form>
</div>
<div class="divBtnContainer clear" style="width:200px;">
    <a class="zclan zclan7" href="javascript:void(0)" id="ezhifubaoBtb">确定</a>
    <a class="zclan zclan7" href="javascript:void(0)" onclick="var a=$('.jsxxxqB .closeDiv').click();">关闭</a>
</div>