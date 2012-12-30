<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".zy_zs .zy_zszl").show();
    
    $(".btnCopyUrl").click(function () {
        copyToClipboard($(".tbMyDistUrl").val());
    });
    $(".linkRemoveItem").live("click",function(){
        if ($(this).parents(".conEmail table").find(".contacts").length>1) $(this).parent().parent().remove();
        else alert("至少保留一组");
    });
    $(".linkAddItem").click(function(){
        $(this).parent().parent().before($(this).parents(".conEmail table").find(".contacts").eq(0).clone());
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
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p><a href="javascript:void(0)">我的聚业务</a>&gt;&gt;<a href="javascript:void(0)">账号管理</a>&gt;&gt;<a href="javascript:void(0)">好友邀请</a></p>        
        <!--<div class="zy_zszl"></div>-->
    </div>    
    <div class="biaotit"><a class="blue" href="hygl.html">查看已邀请的好友</a>邀请好友</div>
    <div class="friInvite">
        <h3>方式一：便捷的方式，复制链接邀请QQ/MSN好友，第一时间得到响应</h3>
        <div class="con">
            <input type="text" readonly="readonly" value="{$sns_link}" class="inpTextBox tbMyDistUrl"/>
            <a class="inp btnCopyUrl" href="javascript:void(0)">复制链接</a>
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
                    <td colspan="3"><textarea class="textarea" name="content">推荐一个不错的网站：举贤网 http://jukeyuan.com，举贤网是获得奖金概率最高的人才推荐平台！在举贤网，您可以通过为朋友推荐职位机会，在帮助他人同时，拓展自己的人脉资源，还可获得丰厚的推荐奖金。抓紧行动吧！</textarea></td>
                </tr>
                <tr>
                    <td colspan="3"><a class="fl inp linkInvite" href="javascript:void(0);">邀请好友</a></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
    <div class="clear">&nbsp;</div>       
    <!--  
    <div class="bottomRcd">
      <div class="fl">
        <h3>热门悬赏<a class="more" href="#">更多...</a></h3>
        <ul>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元&nbsp;厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        </ul>
      </div>
      <div class="fl fr">
        <h3>最新客源<a class="more" href="#">更多...</a></h3>
        <ul>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元&nbsp;厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        </ul>
      </div>
    </div>  
    <div class="bottomRcdPos"></div>
    -->
</div>