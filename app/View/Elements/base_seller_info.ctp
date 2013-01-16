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
 <div class="mebBaseinfo">
 <div class="biaotit">{if $type == "need"}卖家{else}买家{/if}</div>
        <div class="mebBaseinfoL">
          <table width="100%" height="100%" border="0">
            <tr>
              <td width="34%" rowspan="6"><img src="{$this->webroot}img/tx.jpg"></td>
              <td width="66%">
              {if !$isFriend}
                <a href="javascript:void(0)" class="btnAddFri fr">加为好友</a>{$author.Member.nickname}
              {/if}
              </td>
            </tr>
            <tr>
              <td>会员等级：{if $author.Member.grade == 1}新手{elseif $author.Member.grade == 2}高级{/if}</td>
            </tr>
            <tr>
              <td>上次登陆时间：{date('d', time() - strtotime($author.Member.lastlogin))}天内</td>
            </tr>
            <tr>
              <td>客源数量：{$transaction_has_num}次</td>
            </tr>
            <tr>
              <td>交易次数：{$transaction_need_num}次</td>
            </tr>
            <tr>
              <td>好评率：100%</td>
            </tr>
          </table>
        </div>
        <div class="mebBaseinfoR">
          <dl>   
           <dd class="ddAddFri"><form id="msg">			
            <p>请输入身份验证信息</p>
            <input type="hidden" name="receiver" value="{$author.Member.id}" />
            <input type="hidden" name="type" value="2" />
            <textarea class="txtAddFri" name="content" id="content"></textarea>
            <input type="button" value="发送" id="send"/>
        </form></dd>
          </dl>
        </div>
      </div>