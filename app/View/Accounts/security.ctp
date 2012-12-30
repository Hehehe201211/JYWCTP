<script type="text/javascript">
{literal}
$(document).ready(function(){
     $("body").append("<div class='jsxxxq jsxxxqB' id='jsxxxq1' style='width:450px;'></div>");
    //登录密码
	$(".btnPWMod").click(function(){
	   $('#jsxxxq1').load('/accounts/load', {'name':'password'}, function(){})
		bgKuang("#jsxxxq1","#jsxxxq1 .closeDiv");
	});
	//支付密码
	$(".btnPPWMod").click(function(){
       $('#jsxxxq1').load('/accounts/load', {'name':'pay_password'}, function(){})
        bgKuang("#jsxxxq1","#jsxxxq1 .closeDiv");
    });
    //支付宝
    $(".btnZFBMod").click(function(){
       $('#jsxxxq1').load('/accounts/load', {'name':'zhifubao'}, function(){})
        bgKuang("#jsxxxq1","#jsxxxq1 .closeDiv");
    });
    //手机号
    $(".btnMBMod").click(function(){
       $('#jsxxxq1').load('/accounts/load', {'name':'mobile'}, function(){})
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
    
    $('#epay_passwordBtb').live('click', function(){
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
                    data : $('#epay_password').serialize(),
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
    
    $('#ezhifubaoBtb').live('click', function(){
        if ($('#old_zhifubao').val() != "") {
            if ($('#new_zhifubao').val() != "") {
                $.ajax({
                    url : '/accounts/editSecurity',
                    type : 'post',
                    data : $('#ezhifubao').serialize(),
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
            } else {
                if ($('#jsxxxq1 span').length == 0) {
                    var msg = '<span class="errorMsg">请输入新支付宝！</span>';
                    $('.biaotit').after(msg);
                } else {
                    $('#jsxxxq1 span').html('请输入新支付宝！');
                }
            }
        } else {
            if ($('#jsxxxq1 span').length == 0) {
                var msg = '<span class="errorMsg">请输入旧支付宝！</span>';
                $('.biaotit').after(msg);
            } else {
                $('#jsxxxq1 span').html('请输入旧支付宝！');
            }
        }
    });
    
    $('#emobileBtb').live('click', function(){
        if ($('#old_mobile').val() != "") {
            if ($('#new_mobile').val() != "") {
                $.ajax({
                    url : '/accounts/editSecurity',
                    type : 'post',
                    data : $('#emobile').serialize(),
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
            } else {
                if ($('#jsxxxq1 span').length == 0) {
                    var msg = '<span class="errorMsg">请输入新认证手机！</span>';
                    $('.biaotit').after(msg);
                } else {
                    $('#jsxxxq1 span').html('请输入新认证手机！');
                }
            }
        } else {
            if ($('#jsxxxq1 span').length == 0) {
                var msg = '<span class="errorMsg">请输入旧认证手机！</span>';
                $('.biaotit').after(msg);
            } else {
                $('#jsxxxq1 span').html('请输入旧认证手机！');
            }
        }
    });
});
String.prototype.trim = function () {
	return this .replace(/^\s\s*/, '' ).replace(/\s\s*$/, '' ); 
}
{/literal}
</script>

<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="new-hyzy.html">我的聚业务</a>>>
            <a href="grxxxg.html">账号管理</a>>>
            <a href="#">账号安全</a>
        </p>
    <div class="zy_zszl">
        <div class="zy_zszl_z">
            <dl>
                <dt>
                    <dl>
                        <dt><img src="{$this->webroot}img/tx.jpg" /></dt>
                        <dd class="mebInfo">
                            <span>会员昵称：聚业务</span>
                            <span>会员等级：高级会员</span>
                            <span>绑定手机：1500****500</span>
                            <span>绑定邮箱：ya*****@qq.com</span>
                            <span>行业：互联网</span>
                            <span>地址：福建省厦门市</span>
                        </dd>
                    </dl>
                </dt>
                <dd>
                    <span>资料完整度：</span>
                    <span class="progressBar">
                        <span>&nbsp;20%&nbsp;</span>
                    </span>
                    <a href="#">完善资料</a>
                    <a class="icon iconS" href="new-grhysj.html" title="身份已认证"></a>
                    <a class="icon iconM" href="new-zhaq.html" title="未绑定邮箱"></a>
                    <a class="icon iconT" href="new-zhaq.html" title="未绑定手机"></a>
                    <a class="icon iconB" title="已绑定支付宝" href="#"></a>
                </dd>
            </dl>
        </div>
        <div class="zy_zszl_r">
            <dl>
                <dd>
                    <span>已发布：<a href="new-ywfbmx.html">0</a>条客源&nbsp;&nbsp;<a href="xslb.html">0</a>条悬赏</span>
                    <span>已收到：<a href="new-sddxq.html">0</a>条客源&nbsp;&nbsp;<a href="new-sddsx.html">0</a>条悬赏</span>
                    <span>待确认客源：<a href="dqrjy.html">0</a>条</span>
                    <span>待处理投诉：<a href="new-wbts.html">0</a>条</span>
                    <span>留言：<a href="new-znx.html">0</a>条</span>
                    <span>虚拟币余额：<a href="new-zhye.html">0</a>元&nbsp;&nbsp;积分：<a href="jfmx.html">0</a>分</span>
                    <span>聚客币：<a href="new-zhye.html">余额</a><a href="new-czjl.html">充值</a><a href="txsq.html" target="_blank">提现</a><a href="new-qbmx.html">明细</a></span>
                </dd>
            </dl>
        </div>
    </div>
    </div>
    <div class="safe_item safe_password clearfix">
        <div class="safe_item_title">账号密码 </div>
        <div class="safe_item_des">
          <p><strong>******</strong></p>用于您的账号登陆，及某些重要操作确认
        </div>
        <div class="safe_item_but">
          <a href="javascript:void(0)" class="btnSaftMod btnPWMod">修改</a><br />
          <a style="text-decoration:underline;" href="wangjimima.html">忘记密码</a>
        </div>
    </div>
    <div class="safe_item safe_payPassword clearfix">
        <div class="safe_item_title">支付密码 </div>
        <div class="safe_item_des">
          <p><strong>******</strong></p>用于您的资金流通时身份验证。
        </div>
        <div class="safe_item_but">
          <a href="javascript:void(0)" id="safe_payPassword" class="btnSaftMod btnPPWMod">修改</a><br />
          <a style="text-decoration:underline;" href="#">忘记密码</a>
        </div>
    </div>
    <div class="safe_item safe_alipay clearfix">
        <div class="safe_item_title">支付宝 </div>
        <div class="safe_item_des">
          <p><strong>ya*******@qq.com</strong></p>提现。 
        </div>
        <div class="safe_item_but">
          <a href="javascript:void(0)" id="safe_alipay" class="btnSaftMod btnZFBMod">修改</a>
        </div>
    </div>

    <div class="safe_item safe_mobile clearfix">
        <div class="safe_item_title">认证手机 </div>
        <div class="safe_item_des">
          <p><strong>150****4745</strong></p>绑定手机后，您即可使用手机号码进行登录，在忘记密码时也可通过绑定手机找回。 
        </div>
        <div class="safe_item_but">
          <a href="javascript:void(0)" id="safe_mobile" class="btnSaftMod btnMBMod">修改</a>
        </div>
    </div>
</div>