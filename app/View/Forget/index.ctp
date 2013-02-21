<script type="text/javascript">
{literal}
$(document).ready(function(){
    //验证码
    $('#getCheckNum').prepend('<img id="code" src="/members/image">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
    
    $('.inpButton').click(function(e){
	   $("#send").find(".errorMsg").remove();
        var error = false;
        if ($('#email').val() == "") {
            error = true;
			$('#email').after('<span class="errorMsg">请输入邮箱</span>');
        }
        if ($('#checkNum').val() == "") {
            error = true;
			$('#getCheckNum').after('<span class="errorMsg">请输入验证码</span>');
        }
        if (!error) {
            $.ajax({
                  url : '/members/getImageNumber',
                  type : 'post',
                  async  : false,
                  success : function(data)
                  {					 
                      if (data != $("#checkNum").val().toUpperCase()) {
                        //error = true;
                        $("#getCheckNum").after('<span class="errorMsg">验证码输入错误</span>');
                    }
                }
            });
        }
        if (!error) {
            $('#send').submit();
        } else {
            return false;
        }
    });
    
});
{/literal}
</script>
<div class="porleft">
    <form action="/forget/send" method="post" id="send">
        <p>请填写以下内容</p>
        <p>
            <label class="zhmm">电子邮箱：</label>
            <input type="text" class="forgetInp inpTextBox" name="email" id="email" value="" onkeyup="Emailstr(this)" onpaste="Emailstr(this)">
        </p>
        <p>
            <label class="zhmm">类型：</label>
            <label class="tL"><input type="radio" id="person" class="inpRadio" checked="checked" value="0" name="type">个人</label>
            <label class="tL"><input type="radio" id="enterprise" class="inpRadio" value="1" name="type">企业</label>
        </p>
        <p>请输入图片中的验证码</p>
        <p>
            <input type="text" name="checkNum" class="forgetInp inw2 inpTextBox" id="checkNum" onkeyup="letterNum(this)" onpaste="letterNum(this)">
            <a id="getCheckNum" href="javascript:void(0)">看不清？</a>
        </p>
        <p>
            <label class="butt" id="butt">
                <input type="button" class="fgbtn inpButton" value="提交">
            </label>
        </p>
    </form>
</div>