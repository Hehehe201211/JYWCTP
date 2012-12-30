<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("body").append($('.jsxxxqB'));
	$("body").append($('#djbuz1'));
	
    $('#cancel').click(function(){
        var data = 'id=' + $('#cooperations_id').val() + '&status=4&type=send';
        var action = '/cooperations/waitlist/?type=send'
        sendAjax(data, action);
    });
    $('#receivables').click(function(){
        var data = 'id=' + $('#cooperations_id').val() + '&status=9&type=send';
        var action = '/cooperations/completelist/?type=send'
        sendAjax(data, action);
    });
    $('#submit').click(function(){
        if ($('#reason').val().trim() != "") {
            var data = $('#complaint').serialize();
            var action = '/cooperations/complaintlist/?type=send';
            $.ajax({
                url : '/cooperations/complaint',
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
            });
        }else {
            $('#msg').html('请填写原因！')
        }
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
    $(".btnWYTG").click(function(){
        bgKuang("#djbuz1",".closeKuang");
    });
    
    $(".payShortage").click(function(e){
        e.preventDefault();
        $(".divDjbuz").hide();
        $("#bgKuang").remove();
    });
    
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
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="jltdjl.html">兼职管理</a>&gt;&gt;<a href="#">合作中的兼职详情</a></p>
    </div>
    <div class="biaotit">合作状态</div>
    {if $cooperation.Cooperation.status == Configure::read('Cooperation.status.cooperating')}
    <div class="zy_zszlB">
      <div class="txtTousu">合作中</div>
      <span class="time">[{$cooperation.Cooperation.modified|date_format:"%Y-%m-%d"}]</span>
    </div>
    {elseif $cooperation.Cooperation.status == Configure::read('Cooperation.status.waitpay')}
    <div class="zy_zszlB">
      <div class="txtTousu">合作成功 等待对方付款</div>
      <span class="time">[{$cooperation.Cooperation.modified|date_format:"%Y-%m-%d"}]</span>
    </div>
    {elseif $cooperation.Cooperation.status == Configure::read('Cooperation.status.paid')}
    <div class="zy_zszlB">
      <div class="txtTousu">合作成功 对方已经付款</div>
      <span class="time">[{$cooperation.Cooperation.modified|date_format:"%Y-%m-%d"}]</span>
    </div>
    {elseif $cooperation.Cooperation.status == Configure::read('Cooperation.status.failure')}
    <div class="zy_zszlB zy_zszlBF">
      <div class="txtTousu"><strong>企业反馈失败待确认：</strong>{$failure.CooperationFailure.reason}</div>
      <span class="time">[{$cooperation.Cooperation.modified|date_format:"%Y-%m-%d"}]</span>
    </div>
    {/if}
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
    {if $cooperation.Cooperation.status == Configure::read('Cooperation.status.cooperating') ||
        $cooperation.Cooperation.status == Configure::read('Cooperation.status.waitpay')
    }
	<div class="divBtnContainer" style="width:200px;">
    <a href="javascript:void(0)" id="cancel" class="zclan zclan7 btnKYWX">取消合作</a>
    <a href="javascript:void(0)" class="zclan zclan7 btnWYTG">投诉</a>
	</div>
    {elseif $cooperation.Cooperation.status == Configure::read('Cooperation.status.failure')}
	<div class="divBtnContainer" style="width:200px;">
    <a href="javascript:void(0)" class="zclan zclan7">确认取消</a>
    <a href="javascript:void(0)" class="zclan zclan7 btnWYTG">投诉</a>
	</div>
    {elseif $cooperation.Cooperation.status == Configure::read('Cooperation.status.paid')}
	<div class="divBtnContainer" style="width:200px;">
    <a href="javascript:void(0)" id="receivables" class="zclan zclan7">已收款</a>
    <a href="javascript:void(0)" class="zclan zclan7 btnWYTG">投诉</a>
	</div>
    {/if}
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
    <div class="bottomRcd" style="position: static; display: none;">
      <div class="fl">
        <h3>热门悬赏<a href="#" class="more">更多...</a></h3>
        <ul>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元&nbsp;厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        </ul>
      </div>
      <div class="fl fr">
        <h3>最新客源<a href="#" class="more">更多...</a></h3>
        <ul>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元&nbsp;厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        </ul>
      </div>
    </div>  
    <div class="bottomRcdPos"></div>   
  </div>
  
<div id="djbuz1" class="divDjbuz" style="width:430px;">
    <div class="djbuzTit">
        <span style="width:397px;" class="biaot">投诉兼职</span>
        <a class="closeKuang" title="关闭" href="#"></a>
    </div>
    <form id="complaint">
    <p class="biaot_wz biaot_wzL">兼职标题：<strong>{$information.Information.title}</strong></p>
    <p class="biaot_wz biaot_wzL">发布公司：<strong>{$parttime.PartTime.title}</strong></p>
    <p class="biaot_wz biaot_wzL">投诉原因：
        <select class="complain" name="type">
            <option value="1">企业合作成功未反馈</option>
            <option value="2">合作成功未及时付款</option>
            <option value="3">合作成功未足额付款</option>
        </select>
    </p>
    <p class="biaot_wz biaot_wzL">请输入投诉理由：<span id="msg" style="color:red"></span></p>
    <p class="biaot_wz biaot_wzTA">
    <input type="hidden" name="cooperations_id" id="cooperations_id" value="{$this->request->query['send']}">
    <input type="hidden" name="receiver" value="{$cooperation.Cooperation.receiver}">
    <input type="hidden" name="sender" value="{$memberInfo.Member.id}">
    <input type="hidden" name="information_id" value="{$cooperation.Cooperation.information_id}">
    <input type="hidden" name="part_times_id" value="{$cooperation.Cooperation.part_times_id}">
    <textarea class="txtJytsly" name="reason" id="reason"></textarea>
    </p>
    </form>
    <div style="padding-left:80px;" class="biaot_an">
        <span><a href="javascript:void(0)" id="submit" class="btnJytsly">确定</a></span>
        <span><a href="javascript:void(0)" class="payShortage">取消</a></span>
    </div>
</div>
{$this->element('parttime_detail')}
{$this->element('information_detail')}
