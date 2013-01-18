<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".btnDeliverL").click(function(e){
        e.preventDefault();
        bgKuang("#jsxxxq1","#jsxxxq1 .closeDiv");
    });
    $(".btnDeliverR").click(function(e){
        e.preventDefault();
        bgKuang("#jsxxxq2","#jsxxxq2 .closeDiv");
    });
    $('#close').click(function(){
        $('.jsxxxqB .jsxxxq .closeDiv').click();
    });
    
    //站内信
    $('.btnReply').click(function(){
        if($('#comment_content').val() != "") {
            var data = $('#comment').serialize();
            $.ajax({
                type : 'post',
                url  : '/cooperations/comment/',
                data : data,
                success : function(data) {
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        var str = "";
                        
                        str += '<div class="xq_huif_tet">'+
                                '<p class="xq_huif_tet11">';
                        str += '<strong class="sender">我</strong>';
                        str += $('#comment_content').val()+
                                '</p>'+
                                '<p class="xq_huif_riq">' + result.time + '</p>'+
                            '</div>';
                        if ($('#commentList h3').length == 0) {
                            str = '<h3>&nbsp; </h3>' + str;
                            $('#commentList').append(str);
                        } else {
                            $('#commentList h3').after(str);
                        }
                        
                        $('#comment_content').val('');
                    }
                }
            })
        }
    });
    
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">平台兼职</a>&gt;&gt;
      <a href="javascript:void(0)">被投诉的合作</a>
      </p>
    </div>
    <div class="biaotit">投诉原因</div>
    <div class="zy_zszlB">
      <div class="txtTousu">
      <strong>
      {if $complaint.CooperationComplaint.type == 1}
      合作成功未及时付款：
      {elseif $complaint.CooperationComplaint.type == 2}
      合作成功未及时付款：
      {else}
      合作成功未足额付款：
      {/if}
      </strong>
      {$complaint.CooperationComplaint.reason} [{$complaint.CooperationComplaint.created|date_format:"%Y-%m-%d"}]
      确认合作时间[{$cooperation.Cooperation.allow_dt|date_format:"%Y-%m-%d"}]
      </div>
    </div>
    <div class="zy_zszlB zy_zszlBF">
    <div class="txtTousu">请在<strong>
    {date("Y-m-d", strtotime("+{$parttime.PartTime.pay_time} day", strtotime($cooperation.Cooperation.allow_dt)))}
    </strong>之前完成报酬支付。</div>
    </div>
    <div class="mebleft">
      <div class="biaotit"><strong>{$sender.MemberAttribute.name}的会员信息 </strong></div>
      <table width="100%">
        <tbody><tr>
          <th width="114" class="tdRight">真实姓名：</th>
          <td width="221">{$sender.MemberAttribute.name}</td>
        </tr>
        <tr>
          <th class="tdRight">性别：</th>
          <td>{if $sender.MemberAttribute.sex}男{else}女{/if}</td>
        </tr>
        <tr>
          <th class="tdRight">行业：</th>
          <td>
          {$this->Category->getCategoryName($sender.MemberAttribute.category_id)}
          </td>
        </tr>
        <tr>
          <th class="tdRight">联系方式：</th>
          <td>{$sender.MemberAttribute.mobile}</td>
        </tr>
        <tr>
          <th class="tdRight">所在城市：</th>
          <td>
          {$this->City->cityName($sender.MemberAttribute.provincial_id)} 
          {$this->City->cityName($sender.MemberAttribute.city_id)}
          </td>
        </tr>
        <tr>
          <th class="tdRight">业务范围：</th>
          <td>{$sender.MemberAttribute.business_scope}</td>
        </tr>
        <tr>
          <th class="tdRight">与公司合作：</th>
          <td>12次</td>
        </tr>
        <tr>
          <th class="tdRight">成功合作：</th>
          <td>3次</td>
        </tr>
      </tbody></table>
      <a target="_blank" href="javascript:void(0)" class="btnMoreInfo btnDeliverL">查看详情</a> </div>
    <div class="mebleft mebright">
      <div class="biaotit"><strong class="red">{$information.Information.title}(客源) </strong></div>
      <table width="100%">
        <tbody><tr>
          <th>采购单位：</th>
          <td>{$information.Information.company}</td>
        </tr>
        <tr>
          <th width="95">客户区域范围：</th>
          <td width="195">
            {$this->City->cityName($information.Information.provincial)} 
            {$this->City->cityName($information.Information.city)}
          </td>
        </tr>
        <tr>
          <th>行业：</th>
          <td>{$this->Category->getCategoryName($information.Information.industries_id)}</td>
        </tr>
        <tr>
          <th>产品名称：</th>
          <td>
            {$this->Category->getCategoryName($information.Information.category)} 
            {$this->Category->getCategoryName($information.Information.sub_category)}
          </td>
        </tr>
        <tr>
          <th>客源有效期：</th>
          <td>{$information.Information.open|date_format:"%Y-%m-%d"} 至  {$information.Information.close|date_format:"%Y-%m-%d"}</td>
        </tr>
        <tr>
          <th>联系人：</th>
          <td>{$information.Information.post}</td>
        </tr>
        {foreach $inforAttr as $attr}
      <tr>
        <th>联系方式：</th>
        <td>
            {$attr.InformationAttribute.mode} 
            {$attr.InformationAttribute.contact_method}
        </td>
      </tr>
      {/foreach}
        <tr>
          <th>单位详细地址：</th>
          <td>{$information.Information.address}</td>
        </tr>
        <tr>
      </tr></tbody></table>
      <a target="_blank" href="javascript:void(0)" class="btnMoreInfo btnDeliverR">查看详情</a> </div>
    <div class="clear">&nbsp;</div>
    <a href="javascript:void(0)" class="zclan zclan2">支付完成</a>
     <div id="xq_huif">
      <form id="commentList">
        {$this->element('cooperation_comments_paginator')}
        </form>
      <form method="post" id="comment">
      <p class="xq_huif_centr_toprr">
        <input type="text" class="txtReply inpTextBox" id="comment_content" name="content" />
        <input type="hidden" name="cooperations_id" value="{$cooperation.Cooperation.id}" />
        <input type="hidden" name="sender" value="{$cooperation.Cooperation.sender}" />
        <input type="hidden" name="receiver" value="{$cooperation.Cooperation.receiver}" />
        <input type="hidden" name="type" value="0" />
        <input type="button" class="btnReply" value="回复">
      </p>
      </form>
    </div>
</div>
{$this->element('member_detail')}
{$this->element('information_detail')}