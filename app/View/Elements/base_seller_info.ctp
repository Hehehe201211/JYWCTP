<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#send').click(function(){
        if ($('#content').val().trim() == "") {
            alert("请输入身份验证信息！");
            return 0;
        }
        $.ajax({
            url : '/sms/addMsg',
            type : 'post',
            data : $('#msg').serializeArray(),
            success : function(data) {
                var result = eval("("+data+")");
                if (result.result == "OK") {
                    $(".ddAddFri").hide();
                    $(".btnAddFri").hide();
                    alert("好友申请发生成功！");
                } else {
                    alert(result.msg);
                }
            }
        });
    });
});
{/literal}
</script>
<div class="zy_zszl">
	<div class="biaotit">{if $type == "need"}卖家{else}买家{/if}</div>
	<div class="zy_zszl_z">
		<dl>
			<dt>
				<dl>
					<dt class="borBlue"><img src="/img/tx.jpg"></dt>
					<dd class="member">
						<span><a href="javascript:void(0)" class="btnAddFri">加为好友</a>{$author.Member.nickname}</span>
						<span>会员等级：{if $author.Member.grade == 1}新手{elseif $author.Member.grade == 2}高级{/if}</span>
						<span>上次登陆时间：{date('d', time() - strtotime($author.Member.lastlogin))}天内</span>
						<span>客源数量：{$transaction_has_num}次</span>
						<span>交易次数：{$transaction_need_num}次</span>
						<span>好评率：100%</span>
					</dd>
				</dl>
			</dt>
		</dl>
	</div>
	<div class="zy_zszl_r">
		<dl>
		<form id="msg">
			<dd class="ddAddFri">
            <p>请输入身份验证信息</p>
            <input type="hidden" name="receiver" value="{$author.Member.id}" />
            <input type="hidden" name="type" value="2" />
            <textarea class="txtAddFri" name="content" id="content"></textarea>
            <input type="button" value="发送" id="send"/>
          </dd>
        </form>
		</dl>
	</div>
</div>