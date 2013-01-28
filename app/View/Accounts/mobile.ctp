<a href="#" class="closeDiv">&nbsp;</a>
<div class="biaotit">认证手机修改</div>
<div class="sjle sjleBold" style="margin-top:0;">
<div class="info">&nbsp;<span class="errorMsg"></span></div>
<form id="emobile">
    <ul>
      <li>
        <label><font class="facexh">*</font>请输入旧认证手机：</label>
        <input type="text" name="old_mobile" id="old_mobile" onkeyup="onlyNum(this)" onpaste="onlyNum(this)"/>
      </li>
      <li>
        <label><font class="facexh">*</font>请输入新认证手机：</label>
        <input type="text" name="new_mobile" id="new_mobile" onkeyup="onlyNum(this)" onpaste="onlyNum(this)"/>
      </li>
      <input type="hidden" name="type" value="mobile" />
    </ul>
</form>
</div>
<div class="divBtnContainer clear" style="width:200px;">
    <a class="zclan zclan7" href="javascript:void(0)" id="emobileBtb">确定</a>
    <a class="zclan zclan7" href="javascript:void(0)" onclick="var a=$('.jsxxxqB .closeDiv').click();">关闭</a>
</div>
