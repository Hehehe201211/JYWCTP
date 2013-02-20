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
        var error = false;
        if ($('#email').val() == "") {
            error = true;
        }
        if ($('#checkNum').val() == "") {
            error = true;
        }
        if (!error) {
            $.ajax({
                  url : '/members/getImageNumber',
                  type : 'post',
                  async  : false,
                  success : function(data)
                  {
                      if (data == $("#checkNum").val().toUpperCase()) {
                          $("#checkNum").parent().find('.errorMsg').remove();
                          
                      } else {
                        error = true;
                        if ($("#checkNum").parent().find('.errorMsg').length == 0) {
                            $("#getCheckNum").after('<span class="errorMsg">验证码不一致</span>');
                        } else {
                            $("#checkNum").parent().find('.errorMsg').html('验证码不一致');
                        }
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
            <input type="text" class="forgetInp inpTextbox inpTextBox" name="email" id="email" value="">
        </p>
        <p>
            <label class="zhmm">类型：</label>
            <label class="tL"><input type="radio" id="person" class="inpRadio" checked="checked" value="0" name="type">个人</label>
            <label class="tL"><input type="radio" id="enterprise" class="inpRadio" value="1" name="type">企业</label>
        </p>
        <p>请输入图片中的验证码</p>
        <p>
            <input type="text" name="checkNum" class="forgetInp inw2 inpTextbox inpTextBox" maxlength="5" size="2">
            <a id="getCheckNum" href="javascript:void(0)">看不清？</a>
        </p>
        <p>
            <label class="butt" id="butt">
                <input type="submit" class="fgbtn inpButton" value="提交">
            </label>
        </p>
    </form>
</div>