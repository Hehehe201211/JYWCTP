<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".zy_zs .zy_zszl").show();
    $(".linkRemoveItem").live("click",function(){
        if ($(this).parents(".conEmail table").find(".contacts").length>1) $(this).parent().parent().remove();
        else alert("至少保留一组");
    });
    $(".linkAddItem").click(function(){
        $(this).parent().parent().before('<tr class="contacts"><td><input type="text" class="name inpTextBox" name="names[]"/></td><td><input type="text" class="email inpTextBox" name="emails[]" ></td><td><a class="linkRemoveItem" href="javascript:void(0);"><b style="color:#f30;margin-right:2px;">x</b>删除</a></td></tr>');
    });
    $(".linkInvite").click(function(){
        var s=$(".conEmail table").find(".contacts");
        for (i=0;i<s.length;i++) {
            if (s.eq(i).find(".name").val()!=""&&s.eq(i).find(".email").val()!="") {                
            } else {
                alert("被邀请人部分信息未填写完整。");
                return;
            }            
        }
        $.ajax({
            url : '/friends/sendRecommendMail',
            type : 'post',
            data : $('#email').serializeArray(),
            success : function(data) {
                var result = eval("("+data+")");
                if (result.result == "OK") {
                    alert(result.msg);
                } else {
                    alert(result.msg);
                }
            }
        });
        //alert("邀请邮件已发送。");
    });
    $(".addFriend").live("click",function(){
        var a=prompt("请输入身份验证信息。")
        if (a!=""&&a!=null) {
            alert("信息已发送，等待对方确认。");
        } else if (a=="") {
            alert("信息为空。");
        }
    });
	//Zero Clipboard
	ZeroClipboard.setMoviePath($("#webroot").val()); 
	var clip = new ZeroClipboard.Client();
	clip.setHandCursor(true); 
	clip.setCSSEffects(true);
	clip.setText($(".tbMyDistUrl").val());
	clip.glue("btnCopyUrl");
	clip.addEventListener( "complete", function(){
		alert("复制成功！");
	});
});
//{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p><a href="javascript:void(0)">我的聚业务</a>&gt;&gt;<a href="javascript:void(0)">账号管理</a>&gt;&gt;<a href="javascript:void(0)">好友邀请</a></p>        
        <!--<div class="zy_zszl"></div>-->
    </div>    
    <div class="biaotit"><a class="blue" href="/accounts/friend">查看已邀请的好友</a>邀请好友</div>
    <div class="friInvite">
        <h3>方式一：便捷的方式，复制链接邀请QQ/MSN好友，第一时间得到响应</h3>
        <div class="con">
            <input type="text" readonly value="{$sns_link}" class="inpTextBox tbMyDistUrl"/>
            <a class="inp btnCopyUrl" id="btnCopyUrl" href="javascript:void(0)">复制链接</a>
            <input type="hidden" id="webroot" value="{$this->webroot|cat:'js/ZeroClipboard.swf'} "/>
        </div>
        <div class="clearfix"></div>
        <h3>方式二：直接发送邮件邀请好友</h3>
        <div class="conEmail">
            <form id="email">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <th width="26%" scope="col">被邀请人的名称</th>
                    <th width="51%" scope="col">被邀请人的E-mail </th>
                    <th width="23%" scope="col">&nbsp;</th>
                </tr>
                <tr class="contacts">
                    <td><input type="text" class="name inpTextBox" name="names[]"/></td>
                    <td><input type="text" class="email inpTextBox" name="emails[]" ></td>
                    <td><a class="linkRemoveItem" href="javascript:void(0);"><b style="color:#f30;margin-right:2px;">x</b>删除</a></td>
                </tr>
                <tr>
                    <td colspan="2"><a class="fr linkAddItem" href="javascript:;"><b style="color:#555;margin-right:2px;">+</b>增加发送地址</a></td>
                    <td width="23%" scope="col">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3"><font color="#000000">邀请信：</font></td>
                </tr>
                <tr>
                    <td colspan="3">
                    <textarea class="textarea" name="content">
HI，我最近在聚业务（www.juyewu.com）这个网站上找到了不少客户，也参与了一些兼职工作，信息有效性高，兼职企业有认证，很不错的业务平台哦，现在注册还可以赠送50个积分。
免费会员注册链接:
{$sns_link}
免费升级成功后，您也可以推荐好友参加，也有积分赠送哦。                    
                    </textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><a class="fl inp linkInvite" href="javascript:void(0);">邀请好友</a></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
    <div class="clear">&nbsp;</div>    
</div>