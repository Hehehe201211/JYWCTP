<script type="text/javascript">
{literal}

$(document).ready(function(){
    $(".SSmore").toggle(function(){
        $(this).addClass("open");
        $(".tablePTSSXQ").show("fast");     
    },function(){       
        $(this).removeClass("open");
        $(".tablePTSSXQ").hide("fast");
    });
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
    {if $transaction.PaymentTransaction.status > Configure::read('Transaction.status_code.complete')}
        <div class="biaotit">投诉原因</div>
        <div class="zy_zszlB">
          <div class="txtTousu">{$complaint.InformationComplaint.reason}</div>
        </div>
        {if !empty($answer)}
            <div class="biaotit">投诉回答</div>
            <div class="zy_zszlB">
              <div class="txtTousu">{$answer.ComplaintAnswer.answer}</div>
            </div>
        {/if}
        {if !empty($answers)}
            <div class="biaotit">申诉结果</div>
            <div class="zy_zszlB zy_zszlBT">
              <div class="txtTousu">
              {if $appeal.Appeal.status == 2}
                                            平台判定信息有效，交易完成。
              {else}
                                            平台判定信息无效，交易完成。
              {/if}
                <a class="SSmore" href="#">点击查看申诉详情。</a>
              </div>
                <table cellspacing="0" cellpadding="0" border="1" class="tablePTSSXQ" style="display: none;">
                <tbody><tr>
                  <th colspan="2">平台申诉结果</th>
                </tr>
                {foreach $templates as $key => $template}
                    <tr>
                      <td>{$key + 1}、{$template.AppealAnswerTemplate.title}</td>
                      {$labels = explode(";", {$template.AppealAnswerTemplate.label})}
                      <td class="tableR">
                      <p class="result">
                      {if $answers[$key]['AppealAnswer']['answer'] == 1}
                      {$labels[0]}
                      {else}
                      {$labels[1]}
                      {/if}
                      </p>
                        <p class="content">
                        {$answers[$key]['AppealAnswer']['content']}
                        </p>
                    </td>
                    </tr>
                {/foreach}
                <tr>
                  <td align="right" colspan="2">平台判定结果：<strong>{if $appeal.Appeal.status == 2}信息有效{else}信息无效{/if}</strong>{$appeal.Appeal.modified}</td>
                </tr>
              </tbody>
              </table>
           </div>
       {/if}
    {/if}
    <div class="xq_zl">
      <div class="xq_zl_xbxq">
        <div class="biaotit">{$information.Information.title}
        <span>
        {$status = Configure::read('Transaction.status')}
        {$status[$transaction.PaymentTransaction.status - 2]}
        </span>
        </div>
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
                {if $transaction.PaymentTransaction.payment_type == 1}
                    聚客币：{$transaction.PaymentTransaction.number}元
                {else if $transaction.PaymentTransaction.payment_type == 2}
                    积分：{$transaction.PaymentTransaction.number}分
                {/if}
            </td>
          </tr>
          <tr>
                <td class="tdRight connection">联系人：</td>
                <td class="tdLeft" colspan="3">{$information.Information.contact}</td>
          </tr>
          <tr>
                <td class="tdRight connection">联系人职位：</td>
                <td class="tdLeft" colspan="3">{$information.Information.post}</td>
          </tr>
          {foreach $attributes as $attribute}
            <tr>
                <td class="tdRight connection">联系方式：</td>
                <td class="tdLeft" colspan="3">{$attribute.InformationAttribute.mode} {$attribute.InformationAttribute.contact_method}</td>
            </tr>
        {/foreach}
        <tr>
            <td class="tdRight connection">单位详细地址：</td>
            <td class="tdLeft" colspan="3">{$information.Information.address}</td>
        </tr>
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
          <tr>
            <td class="tdRight">采购需求描述：</td>
            <td class="tdLeft" colspan="3"> <p>{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</p></td>
          </tr> 
          <tr>
            <td class="tdRight">采购补充：</td>
            <td class="tdLeft" colspan="3"><p>{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p></td>
          </tr>          
        </tbody></table>
      </div> 
            </div>     
    <div class="txtEstimate">
    <div class="biaotit">评论</div>
    {if $showAppraisal}
      <div class="appraisal_radio">
        <span>对本次交易的评价：</span>
        <input type="hidden" checked="input" id="information_id" name="information_id" value="{$information.Information.id}">
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
    <form id="commentList">
    {$this->element('comments_paginator')}
    </form>
    </div>
</div>