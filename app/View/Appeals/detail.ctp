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
    //站内信
    $('.inpButton').click(function(){
        if($('#comment_content').val() != "") {
            var data = $('#comment').serialize();
            $.ajax({
                type : 'post',
                url  : '/informations/comment/',
                data : data,
                success : function(data) {
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        var str = "";
                        if ($('#xq_huif h3').length == 0) {
                            str = '<h3>&nbsp; </h3>';
                        }
                        str += '<div class="xq_huif_tet">'+
                                '<p class="xq_huif_tet11">';
                        str += '<strong class="sender">' + result.name + '</strong>';
                        str += $('#comment_content').val()+
                                '</p>'+
                                '<p class="xq_huif_riq">' + result.time + '</p>'+
                            '</div>';
                        $('#xq_huif h3').after(str);
                        $('#comment_content').val('');
                    }
                }
            })
        }
    });
    //同意投诉
    $(".btnTYTS").click(function(e) {
        $.ajax({
            url : '/complaints/agree',
            type : 'post',
            data : 'complaints_id=' + $('#complaints_id').val(),
            success : function(data) {
                var result = eval("("+data+")");
                if (result.result == "OK") {
                    alert("同意投诉成功");
                    location.href="/invalid/listview/?type=has";
                    
                }
            }
        });
    });
});
{/literal}
</script>

<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html.html">我有客源</a>&gt;&gt;<a href="#">我的申诉详情</a></p>     
    </div>
	{$this->element('base_seller_info')}
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
      {else}
     <div class="biaotit">投诉回答</div>
    <div class="zy_zszlB">
      <div class="txtTousu">平台处理申诉中···</div>
    </div>
      {/if}
   <div class="tableDetail">
<div class="biaotit">{$information.Information.title}<span>{$status = Configure::read('Appeal.status')}{$status[$appeal.Appeal.status-1]}</span></div>
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
          <td>{$this->Category->getCategoryName($information.Information.category)} 
            {$this->Category->getCategoryName($information.Information.sub_category)}</td>
        </tr>               
        <tr>
          <th>客源有效期：</th>
          <td>{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}</td>
        </tr> 
        <tr>
            <th>信息交易价格：</th>
            <td>
                {if $information.Information.payment_type == 1}
                    聚客币：{$information.Information.price}元
                {else if $information.Information.payment_type == 2}
                    积分：{$information.Information.point}分
                {else}
                    聚客币：{$information.Information.price}元；积分：{$information.Information.point}分
                {/if}
            </td>
          </tr>  
        <tr>
          <th>联系人：</th>
          <td class="red">{$information.Information.contact}</td>
        </tr>
        <tr>
          <th>联系人职位：</th>
          <td class="red">{$information.Information.post}</td>
        </tr>
       {foreach $attributes as $attribute}
        <tr>
          <th>联系方式：</th>
          <td class="red">{$attribute.InformationAttribute.mode} {$attribute.InformationAttribute.contact_method}</td>
        </tr>
       {/foreach}
        <tr>
          <th>单位详细地址：</th>
          <td class="red">{$information.Information.address}</td>
        </tr>  
        <tr>
          <th>预计合作金额：</th>
          <td>{if empty($information.Information.profit)}0{else}{$information.Information.profit}{/if}元人民币</td>
        </tr>
        <tr>
          <th>预计合作时间：</th>
          <td>{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
        </tr>
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
      {if empty($answers)}
      <input type="hidden" name="complaints_id" id="complaints_id" value="{$complaint.InformationComplaint.id}"/>
      <a href="javascript:void(0)" class="zclan zclan4 btnTYTS">同意投诉</a>
      {/if}
 </div>
    <div id="xq_huif">
    <form id="commentList">
    	{$this->element('comments_paginator')}
    </form>
    <form method="post" id="comment">
        <p class="xq_huif_centr_toprr">
            <input type="text" class="txtReply inpTextBox" id="comment_content" name="content" />
            <input type="hidden" name="information_id" value="{$information.Information.id}" />
            <input type="hidden" name="members_id" value="{$memberInfo.Member.id}" />
            <input type="hidden" name="target_members_id" value="{$author.Member.id}" />            
            <input type="button" value="回复" class="inpButton">
        </p>
    </form>
    </div>
</div>