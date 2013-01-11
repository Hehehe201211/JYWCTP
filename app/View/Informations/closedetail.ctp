<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#appraisal').click(function(){
        var level = $('.appraisal_radio input[name="rdoEstimate"]:checked').val();
        var information_id = $('#information_id').val();
        var members_id = $('#members_id').val();
        var comment = $('#appraisal_comment').val();
        $.ajax({
            url : '/informations/appraisal',
            type : 'post',
            data : 'information_id='+information_id + '&level=' + level + '&comment=' + comment + '&to_members_id=' + members_id,
            success: function(data) {
                var result = eval("("+data+")");
                if (result.result == 'OK') {
                var levelstr = "";
                $('.appraisal_radio').hide();
                if (level == 2) {
                	levelstr = "好";
                } else if (level == 1) {
                	levelstr = "一般";
                } else {
                	levelstr = "差";
                }
                var date = new Date();
                var time = date.getFullYear() + "-" + 
	                (date.getMonth() + 1) + "-" + 
	                date.getDate() + " " + 
	                date.getHours() + ":" + 
	                date.getMinutes() + ":" 
	                date.getSeconds();
                var str = '<div class="xq_huif_tet">' + 
		              '<p class="xq_huif_tet11">' +
		                  '<strong>我</strong>' +
		                  '<span>的评价：' + levelstr + '</span>' +
		                  comment + 
		              '</p>'+
		              '<p class="xq_huif_riq">' + time + '</p>' +
		            '</div>';
                    $('.appraisal_area').html(str);
                }
            }
        })
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html.html">{if $type == "has"}我有客源{else}我要客源{/if}</a>&gt;&gt;<a href="#">已交易记录</a></p>
    </div>
    {$this->element('base_seller_info')}
    <div class="tableDetail">
<div class="biaotit">{$information.Information.title}<span>交易完成</span></div>
      <table width="100%">
        <tr>
        {$provincial = $this->City->cityName($information.Information.provincial)}
		{$city = $this->City->cityName($information.Information.city)}					
          <th width="25%">所在区域：</th>
          <td width="75%">{if $provincial == $city}{$provincial}{else}{$provincial}&nbsp;{$city}{/if}</td>
        </tr>
         <tr>
          <th>行业：</th>
          <td>{$this->Category->getCategoryName($information.Information.industries_id)}</td>
        </tr>
        <tr>
          <th>采购单位：</th>
          <td class="red">{$information.Information.company}</td>
        </tr>
        <tr>
          <th>产品名称</th>
          <td class="red"> {$this->Category->getCategoryName($information.Information.category)} 
			{$this->Category->getCategoryName($information.Information.sub_category)}</td>
        </tr>   
        <tr>
          <th>客源有效期：</th>
          <td>{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}</td>
        </tr>    
        <tr>
          <th>信息交易价格：</th>
          <td>{if $history.PaymentHistory.payment_type == 1}
					聚客币：{$history.PaymentHistory.number/(1-Configure::read('Information.payment_platform'))}元
				{else if $history.PaymentHistory.payment_type == 2}
					积分：{$history.PaymentHistory.number/(1-Configure::read('Information.payment_platform'))}分
				{/if}</td>
        </tr> 
        <tr>
          <th>联系人：</th>
          <td class="red">{$attribute.InformationAttribute.contact}</td>
        </tr>
        <tr>
          <th>联系人职位：</th>
          <td class="red">{$attribute.InformationAttribute.post}</td>
        </tr>
        {foreach $attributes as $attribute}
        <tr>
          <th>联系方式：</th>
          <td class="red">{$attribute.InformationAttribute.contact_method}</td>
        </tr>
        {/foreach}
        <tr>
          <th>单位详细地址：</th>
          <td class="red">{$attribute.InformationAttribute.address}</td>
        </tr> 
        <tr>
          <th>预计合作金额：</th>
          <td>{if empty($information.Information.profit)}0{else}{$information.Information.profit}{/if}元人民币</td>
        </tr>
        <tr>
          <th>预计合作时间：</th>
          <td>{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
        </tr>
        {/if}
        <tr>
          <th>客户选择服务商因素：</th>
          <td>{$information.Information.reason}</td>
        </tr>
        <tr>
          <th>采购需求描述：</th>
          <td><P>{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</P></td>
        </tr>
        <tr>
          <th>采购补充：</th>
          <td><p>{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p></td>
        </tr>
      </table>      
    </div>     
    <div class="txtEstimate">
    {if $showAppraisal}
      <div class="appraisal_radio">
        <span>对本次交易的评价：</span>
        <input type="radio" checked="checked" id="rdoEstimate1" name="rdoEstimate" class="inpRadio" value="2">
        <label for="rdoEstimate1">好（2分）</label>
        <input type="radio" id="rdoEstimate2" name="rdoEstimate" class="inpRadio" value="1">
        <label for="rdoEstimate2">一般（1分）</label>
        <input type="radio" id="rdoEstimate3" name="rdoEstimate" class="inpRadio" value="0">
        <label for="rdoEstimate3">差（-1分）</label>        
      </div>
    {/if}
      <div class="appraisal_area">
        <span>评论：</span>
        {if $showAppraisal}
            <textarea class="textaEstimate" name="appraisal_comment" id="appraisal_comment"></textarea>
            <input type="button" id="appraisal" value="确定" name="btnEstimate" class="btn inpButton">
            <div style="margin-bottom:8px;">（请及时评价，从交易日起，10个工作日后系统将自动评价。）</div>
        {else if isset($appraisal) && !empty($appraisal)}
            <div class="xq_huif_tet">
              <p class="xq_huif_tet11">
                  <strong>{if $type == "need"}我{else}{$author.Member.nickname}{/if}</strong>
                  <span>{if $type == "need"}的评价{else}对你的评价{/if}：{if $appraisal.Appraisal.level == 2}好{else if $appraisal.Appraisal.level == 1}一般{else}差{/if}</span>
                  {$appraisal.Appraisal.comment}
              </p>
              <p class="xq_huif_riq">{$appraisal.Appraisal.created}</p>
            </div>
        {else}
        买家没有对你进行评价
        {/if}
      </div>
    </div>
    <div id="xq_huif">
    {if count($comments) > 0}
        <h3>&nbsp; </h3>
        {foreach $comments as $comment}
            <div class="xq_huif_tet">
                <p class="xq_huif_tet11">
                    {if $comment.InformationComment.members_id == $memberInfo.Member.id}
                        <strong class="sender">我</strong>
                    {else}
                        <strong>{$comment.Member.nickname}</strong>
                    {/if}
                    {$comment.InformationComment.content}
                </p>
                <p class="xq_huif_riq">{$comment.InformationComment.created}</p>
            </div>
        {/foreach}
    {/if}
      <p class="xq_huif_centr_toprr">
        <input type="text" class="txtReply inpTextBox" id="acpro_inp5">
        <input type="hidden" name="information_id" id="information_id" value="{$information.Information.id}">
        <input type="hidden" name="members_id" id = "members_id" value="{$information.Information.members_id}">
        <input type="button" class="btnReply inpButton" value="回复">
      </p>
    </div>
</div>