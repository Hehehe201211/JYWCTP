<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("body").append($('.jsxxxqB'));
    $('#delete').click(function(){
        var data = 'id=' + $('#cooperations_id').val() + '&status=12&type=send';
        var action = '/complete/listview/?type=send'
        sendAjax(data, action);
    });
    function sendAjax(data, action)
    {
        $.ajax({
            url : '/cooperations/setStatus',
            type : 'post',
            data : data,
            success : function(data) {
                var result = eval("("+data+")");
                if (result.result == 'OK') {
                    location.href = action;
                } else {
                    alter(result.msg);
                }
            }
        })
    }
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
      <a href="new-hyzy.html">我的聚业务</a>&gt;&gt;
      <a href="jltdjl.html">兼职管理</a>&gt;&gt;
      <a href="#">我投诉的合作</a>
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
    <div class="mebleft">
      <div class="biaotit"><strong>{$parttime.PartTime.title}</strong></div>
      <table class="posInfo" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="96" scope="row">公司名称：</th>
          <td width="207">
            <a href="gsqt-index.html" target="_blank" class="red blue">{$parttime.Member.company_name}</a>
          </td>
        </tr>
        <tr>
          <th width="96" scope="row">营业执照：</th>
          <td width="207"><font color="#06E">已验证</font></td>
        </tr>
        <tr>
          <th width="96" scope="row">产品所属分类：</th>
          <td width="207">
            {$this->Category->getCategoryName($parttime.PartTime.category)} 
            {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
          </td>
        </tr>
        <tr>
          <th width="96" scope="row">产品具体名称：</th>
          <td width="207">{$parttime.PartTime.sub_title}</td>
        </tr>
        <tr>
          <th scope="row">客户区域范围：</th>
          <td>
            {$cities = explode(',', $parttime.PartTime.area)}
            {foreach $cities as $city}
                {$this->City->cityName($city)} 
            {/foreach}
          </td>
        </tr>
        <tr>
          <th scope="row">兼职配合方式：</th>
          <td>
              {if $parttime.PartTime.method == 1}
            提供客户信息
            {elseif $parttime.PartTime.method == 2}
            协助跟单
            {else}
            独立签单
            {/if}
          </td>
        </tr>
        <tr>
          <th scope="row">联系人：</th>
          <td>{$parttime.PartTime.contact}</td>
        </tr>
        {$contact_methods = json_decode($parttime.PartTime.contact_method, true)}
        {foreach $contact_methods as $key => $contact}
        <tr>
          <th scope="row">联系方式：</th>
          <td>{$contact.method} {$contact.number}</td>
        </tr>
        {/foreach}
        <tr>
          <th scope="row">联系邮箱：</th>
          <td>{$parttime.PartTime.email}</td>
        </tr>
      </table>   
        <a target="_blank" href="javascript:void(0)" class="btnMoreInfo btnDeliverL">查看详情</a>    
    </div>
    <div class="mebleft mebright">
      <div class="biaotit"><strong class="red">{$information.Information.title}</strong></div>
      <table width="100%">
      <tr>
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
        <td>{$this->Category->getCategoryName($information.Information.industries_id)} </td>
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
        <td>
        {$information.Information.open|date_format:"%Y-%m-%d"} 至  {$information.Information.close|date_format:"%Y-%m-%d"}
        </td>
      </tr>
      <tr>
        <th>联系人：</th>
        <td>{$information.Information.contact}</td>
      </tr>
      <tr>
        <th>联系人职位：</th>
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
    </table>
      <a target="_blank" href="javascript:void(0)" class="btnMoreInfo btnDeliverR">查看详情</a>  
    </div>
    <div class="clear">&nbsp;</div> 
    <a href="javascript:void(0)" class="zclan zclan4 btnPwTrade" id="delete">取消投诉</a>
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

{$this->element('parttime_detail')}
{$this->element('information_detail')}