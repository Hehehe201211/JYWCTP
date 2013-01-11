<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("body").append("<div class='jsxxxq jsxxxqB' id='jsxxxq1' style='width:450px;'></div>");
    //登录密码
    $(".btnSaftMod").click(function(){
       $('#jsxxxq1').load('/accounts/load', {'name':'company-password'}, function(){})
        bgKuang("#jsxxxq1","#jsxxxq1 .closeDiv");
    });
    
    $('#epasswordBtb').live('click', function(){
        if ($('#new_password').val().trim() != "" && $('#new_re_password').val().trim() != "") {
            if ($('#new_password').val() != $('#new_re_password').val()) {
                if ($('#jsxxxq1 span').length == 0) {
                    var msg = '<span class="errorMsg">确认密码不一致！</span>';
                    $('.biaotit').after(msg);
                } else {
                    $('#jsxxxq1 span').html('确认密码不一致！');
                }
            } else {
                $.ajax({
                    url : '/accounts/editSecurity',
                    type : 'post',
                    data : $('#epassword').serialize(),
                    success : function(data)
                    {
                        var result = eval("("+data+")");
                        if (result.result == "OK") {
                            $('.closeDiv').click();
                            alert(result.msg);
                        } else {
                            $('.closeDiv').click();
                            alert(result.msg);
                        }
                    }
                });
            }
        } else {
            if ($('#jsxxxq1 span').length == 0) {
                var msg = '<span class="errorMsg">请输入密码和确认密码！</span>';
                $('.biaotit').after(msg);
            } else {
                $('#jsxxxq1 span').html('请输入密码和确认密码！');
            }
        }
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;
            <a href="qy-zhaq.html">账号安全</a>&gt;&gt;
            <a href="#">账号安全</a>
        </p>
    </div>
    <div class="safe_item safe_password clearfix">
        <div class="safe_item_title">账号密码 </div>
        <div class="safe_item_des">
            <p><strong>******</strong></p>用于您的账号登陆，及某些重要操作确认。 </div>
        <div class="safe_item_but">
            <a class="btnSaftMod" id="safe_password" href="javascript:void(0)">修改</a><br>
            <a href="javascript:void(0)" style="text-decoration:underline;">忘记密码</a>
        </div>
    </div>
</div>