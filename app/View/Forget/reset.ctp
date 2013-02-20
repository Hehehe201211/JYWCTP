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
        if ($('#password').val() == "") {
            error = true;
        }
        if ($('#password').val() != $('#rep_password').val()) {
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
        }
    });
});
{/literal}
</script>
<div class="porleft">
{if !$error}
    <form action="/forget/complete" method="post" id="send">
    <input type="hidden" name="tmp_id" value="{$this->request->query['id']}">
        <p>请填写以下内容</p>
        <p>
            <label class="zhmm">新密码：</label>
            <input type="password" name="password" id="password" class="forgetInp inpTextbox inpTextBox" value="">
        </p>
        <p>
            <label class="zhmm">重复新密码：</label>
            <input type="password" name="rep_password" id="rep_password" class="forgetInp inpTextbox inpTextBox" value="">
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
{else}
<p>没有此认证信息！</p>
{/if}
</div>