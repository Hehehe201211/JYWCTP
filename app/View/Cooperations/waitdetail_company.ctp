<script type="text/javascript">
{literal}
$(document).ready(function(){
	$("body").append($(".jsxxxqB,.divDjbuz"));
    $('#complete').click(function(){
        var data = 'id=' + $('#cooperations_id').val() + '&status=5&type=receiver';
        //var action = '/cooperations/waitlist/?type=receiver'
        var action = location.href;
        sendAjax(data, action);
    });
    
    $('#paid').click(function(){
        var data = 'id=' + $('#cooperations_id').val() + '&status=8&type=receiver';
        var action = '/cooperations/waitlist/?type=receiver'
        sendAjax(data, action);
    });
    
    $('#submit').click(function(){
        if ($('#reason').val().trim() != "") {
            var data = $('#failure').serialize();
            var action = '/cooperations/waitlist/?type=receiver'
            $.ajax({
                url : '/cooperations/failure',
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
        } else {
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
    $(".btnKYWX").click(function(e){
        e.preventDefault();
        bgKuang("#djbuz",".closeKuang");
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
						var str = '<div class="comment"><div class="name sender">我</div><div class="time">' +result.time +'</div><div class="content">'+ $('#comment_content').val() + '</div></div>';           
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
      <a href="javascript:void(0)">待确认的合作详情</a>
      </p>
    </div>  
    <div class="biaotit">合作状态</div>
    {if $cooperation.Cooperation.status == Configure::read('Cooperation.status.cooperating')}
    <div class="zy_zszlB">
      <div class="txtTousu"><strong>合作中。</strong></div>
      <span class="time">[{$cooperation.Cooperation.modified|date_format:"%Y-%m-%d"}]</span>
    </div>
    {elseif $cooperation.Cooperation.status == Configure::read('Cooperation.status.failure')}
    <div class="zy_zszlB">
      <div class="txtTousu"><strong>失败待个人确认。</strong></div>
      <span class="time">[{$cooperation.Cooperation.modified|date_format:"%Y-%m-%d"}]</span>
    </div>
    {elseif $cooperation.Cooperation.status == Configure::read('Cooperation.status.waitpay')}
    <div class="zy_zszlB">
      <div class="txtTousu"><strong>成功待付款。</strong></div>
      <span class="time">[{$cooperation.Cooperation.modified|date_format:"%Y-%m-%d"}]</span>
    </div>
        {if $parttime.PartTime.pay_method == 1}
            <div class="zy_zszlB zy_zszlBF">
            <div class="txtTousu">请在<strong>{date("Y-m-d", strtotime("+{$parttime.PartTime.pay_time} day", strtotime($cooperation.Cooperation.allow_dt)))}</strong>之前完成报酬支付。</div>
            </div>
        {/if}
    {/if}
    <div class="mebleft">
        <div class="biaotit">{$sender.MemberAttribute.name}的会员信息</strong></div>
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
          <th class="tdRight">联系地址：</th>
          <td>福建省厦门市思明区会战南路</td>
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
      </tbody>
      </table>
      <a target="_blank" href="javascript:void(0)" class="btnMoreInfo btnDeliverL">查看详情</a>  
    </div>
    <div class="mebleft mebright">
      <div class="biaotit"><strong class="red">{$information.Information.title}(客源)</strong></div>
      <table width="100%">
      <tr>
        <th>采购单位：</th>
        <td>{if $cooperation.Cooperation.status == 1}******{else}{$information.Information.company}{/if}</td>
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
        <td>{if $cooperation.Cooperation.status == 1}******{else}{$information.Information.contact}{/if}</td>
      </tr>
      <tr>
        <th>联系人职位：</th>
        <td>{if $cooperation.Cooperation.status == 1}******{else}{$information.Information.post}{/if}</td>
      </tr>
      {foreach $inforAttr as $attr}
      <tr>
        <th>联系方式：</th>
        <td>
        {if $cooperation.Cooperation.status == 1}******
        {else}
            {$attr.InformationAttribute.mode} 
            {$attr.InformationAttribute.contact_method}
        {/if}
        </td>
      </tr>
      {/foreach}
      <tr>
        <th>单位详细地址：</th>
        <td>{if $cooperation.Cooperation.status == 1}******{else}{$information.Information.address}{/if}</td>
      </tr>
      <tr>
    </table>
      <a target="_blank" href="javascript:void(0)" class="btnMoreInfo btnDeliverR">查看详情</a>  
    </div> 
     <input type="hidden" id="cooperations_id" value="{$this->request->query['receiver']}">
	 <div class="clearfix"></div>
     <div class="divBtnContainer" style="width:200px;">
     {if $cooperation.Cooperation.status == Configure::read('Cooperation.status.cooperating')}
         <a href="javascript:void(0)" id="complete" class="zclan zclan7">合作完成</a>
         <a href="javascript:void(0)" class="zclan zclan7 btnKYWX">合作失败</a>
     {*elseif $cooperation.Cooperation.status == Configure::read('Cooperation.status.failure')*}
        <!--<a href="javascript:void(0)" class="zclan zclan3">合作完成</a>-->
    {elseif $cooperation.Cooperation.status == Configure::read('Cooperation.status.waitpay')}
        <a href="javascript:void(0)" id="paid" class="zclan zclan4">已付款</a>
     {/if}
     </div>
     <div class="infoComments">
        <form id="commentList">
        {$this->element('cooperation_comments_paginator')}
        </form>
        <form method="post" id="comment">
            <div class="reply">
                <input type="text" class="txtReply inpTextBox" id="comment_content" name="content" />
                <input type="hidden" name="cooperations_id" value="{$cooperation.Cooperation.id}" />
                <input type="hidden" name="sender" value="{$cooperation.Cooperation.sender}" />
                <input type="hidden" name="receiver" value="{$cooperation.Cooperation.receiver}" />
                <input type="hidden" name="type" value="1" />
                <input type="button" class="btnReply inpButton" value="回复">
            </div>
        </form>
    </div>    
</div>
<div id="djbuz" class="divDjbuz" style="width:430px;">
  <div class="djbuzTit">
      <span style="width:397px;" class="biaot">取消合作</span>
      <a class="closeKuang" title="关闭" href="javascript:void(0)"></a>
  </div>
  <p class="biaot_wz biaot_wzL">客源标题<strong>：{$information.Information.title}</strong></p>
  <p class="biaot_wz biaot_wzL">兼职标题：<strong>{$parttime.PartTime.title}</strong></p>
  <p class="biaot_wz biaot_wzL">请输入合作失败的原因：<span id="msg" style="color:red"></span></p>
  <form id="failure">
  <p class="biaot_wz biaot_wzTA">
    <input type="hidden" name="cooperations_id" value="{$this->request->query['receiver']}">
    <textarea class="txtJytsly" name="reason" id="reason"></textarea>
  </p>
  </form>
  <div class="biaot_an">
      <a class="btnJytsly btn btn2" id="submit" href="javascript:void(0)">确定</a>
      <a class="payShortage btn btn2" href="javascript:void(0)">取消</a>
  </div>
</div>
{$this->element('member_detail')}
{$this->element('information_detail')}