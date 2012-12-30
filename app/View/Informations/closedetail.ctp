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
    <div class="zy_zs"><!-- InstanceBeginEditable name="EditRegion7" -->
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html.html">{if $type == "has"}我有客源{else}我要客源{/if}</a>&gt;&gt;<a href="#">已交易记录</a></p>
      <!-- InstanceEndEditable -->
      <!--
      <div class="zy_zszl">
      
        <div class="zy_zszl_z">
          <dl>
            <dt>
              <dl>
                <dt><img src="{$this->webroot}img/tx.jpg"></dt>
                <dd class="mebInfo"><span>会员昵称：聚业务</span><span>会员等级：高级会员</span><span>绑定手机：1500****500</span><span>绑定邮箱：ya*****@qq.com</span><span>行业：互联网</span><span>地址：福建省厦门市</span></dd>
              </dl>
            </dt>
            <dd><span>资料完整度：</span><span class="progressBar"><span>&nbsp;20%&nbsp;</span></span><a href="#">完善资料</a><a title="身份已认证" href="new-grhysj.html" class="icon iconS iconH"></a><a title="未绑定邮箱" href="new-zhaq.html" class="icon iconM"></a><a title="未绑定手机" href="new-zhaq.html" class="icon iconT"></a><a href="#" title="已绑定支付宝" class="icon iconB iconH"></a></dd>
          </dl>
        </div>
        <div class="zy_zszl_r">
          <dl>
            <dd> <span>已发布：<a href="new-ywfbmx.html">0</a>条客源&nbsp;&nbsp;<a href="xslb.html">0</a>条悬赏</span><span>已收到：<a href="new-sddxq.html">0</a>条客源&nbsp;&nbsp;<a href="new-sddsx.html">0</a>条悬赏</span><span>待确认客源：<a href="dqrjy.html">0</a>条</span><span>待处理投诉：<a href="new-wbts.html">0</a>条</span><span>留言：<a href="new-znx.html">0</a>条</span><span>虚拟币余额：<a href="new-zhye.html">0</a>元&nbsp;&nbsp;积分：<a href="jfmx.html">0</a>分</span><span>聚客币：<a href="new-zhye.html">余额</a><a href="new-czjl.html">充值</a><a target="_blank" href="txsq.html">提现</a><a href="new-qbmx.html">明细</a></span></dd>
          </dl>
        </div>
        
      </div>
      -->
    </div>
    <!-- InstanceBeginEditable name="EditRegion5" -->
    <!--
    <div class="zy_zszl">
      <div class="biaotit">买家</div>
      <div class="zy_zszl_z">
        <dl>
          <dt>
            <dl>
              <dt class="borBlue"><img src="{$this->webroot}img/tx.jpg"></dt>
              <dd class="member"> <span>张伟（花心的小男人、小佳）</span> <span>会员等级：新手</span><span>上次登陆时间：7天内</span><span>业务交易：8次</span><span>需求交易：8次</span><span>好评率：100%</span></dd>
            </dl>
          </dt>
        </dl>
      </div>
      <div class="zy_zszl_r">
        <dl>
          <dd> </dd>
        </dl>
      </div>
    </div>
    -->
    {$this->element('base_seller_info')}
    
    <div class="xq_zl">
      <div class="xq_zl_xbxq">
        <div class="biaotit">{$information.Information.title}<span>交易完成</span></div>
        <table width="570">
          <tbody>
          <tr>
            {$provincial = $this->City->cityName($information.Information.provincial)}
			{$city = $this->City->cityName($information.Information.city)}
			{if $provincial == $city}
				<td width="132" class="tdRight">城市：</td>
				<td width="57" class="tdLeft">{$provincial}</td>
			{else}
				<td width="132" class="tdRight">省份：</td>
				<td width="57" class="tdLeft">{$provincial}</td>
				<td width="42" class="tdRight">城市：</td>
				<td width="319" class="tdLeft">{$city}</td>
			{/if}
          </tr>
          <tr>
            <td width="132" class="tdRight">行业：</td>
            <td class="tdLeft" colspan="3">{$this->Category->getCategoryName($information.Information.industries_id)}</td>
          </tr>
          <tr>
            <td class="tdRight connection">采购单位：</td>
            <td class="tdLeft" colspan="3">{$information.Information.company}</td>
          </tr>
          <tr>
            <td class="tdRight">产品名称：</td>
            <td class="tdLeft" colspan="3">
            {$this->Category->getCategoryName($information.Information.category)} 
			{$this->Category->getCategoryName($information.Information.sub_category)}
            </td>
          </tr>
          <tr>
            <td class="tdRight">客源有效期：</td>
            <td class="tdLeft" colspan="3">
            	{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}
            </td>
          </tr>
          <tr>
            <td class="tdRight">信息交易价格：</td>
            <td class="tdLeft" colspan="3">
            	{if $history.PaymentHistory.payment_type == 1}
					聚客币：{$history.PaymentHistory.number/(1-Configure::read('Information.payment_platform'))}元
				{else if $history.PaymentHistory.payment_type == 2}
					积分：{$history.PaymentHistory.number/(1-Configure::read('Information.payment_platform'))}分
				{/if}
            </td>
          </tr>
          {foreach $attributes as $attribute}
			<tr>
				<td class="tdRight connection">联系人：</td>
				<td class="tdLeft" colspan="3">{$attribute.InformationAttribute.contact}</td>
			</tr>
			<tr>
				<td class="tdRight connection">联系人职位：</td>
				<td class="tdLeft" colspan="3">{$attribute.InformationAttribute.post}</td>
			</tr>
			<tr>
				<td class="tdRight connection">联系方式：</td>
				<td class="tdLeft" colspan="3">{$attribute.InformationAttribute.contact_method}</td>
			</tr>
			<tr>
				<td class="tdRight connection">单位详细地址：</td>
				<td class="tdLeft" colspan="3">{$attribute.InformationAttribute.address}</td>
			</tr>
		{/foreach}
          <tr>
            <td class="tdRight">预计合作金额：</td>
            <td class="tdLeft" colspan="3">{if empty($information.Information.profit)}0{else}{$information.Information.profit}{/if}元人民币</td>
          </tr>
          <tr>
            <td class="tdRight">预计合作时间：</td>
            <td class="tdLeft" colspan="3">{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
          </tr>
          <tr>
            <td class="tdRight">客户选择服务商因素：</td>
            <td class="tdLeft" colspan="3">{$information.Information.reason}</td>
          </tr>          
        </tbody></table>
        <div class="biaotit">采购需求描述</div>
        <div class="xxContent">
          <p>{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</p>
        </div>
        <div class="biaotit">采购补充</div>
        <div class="xxContent">
          <p>{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p>
        </div>
      </div> 
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
    <!-- InstanceEndEditable -->
</div>