<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("body").append($('.jsxxxqB'));
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
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">平台兼职</a>&gt;&gt;
      <a href="javascript:void(0)">未合作的客源</a>
      </p>
    </div>
    {if $cooperation.Cooperation.status == 10}
        <div class="biaotit">投诉原因</div>
        <div class="zy_zszlB">
          <div class="txtTousu">
          {if $complaint.CooperationComplaint.type == 1}
          企业合作成功未反馈：{$complaint.CooperationComplaint.reason}
          {elseif $complaint.CooperationComplaint.type == 2}
          合作成功未及时付款：{$complaint.CooperationComplaint.reason}
          {else}
          合作成功未足额付款：{$complaint.CooperationComplaint.reason}
          {/if}
          [{$complaint.CooperationComplaint.created|date_format:"%Y-%m-%d"}]
          </div>
        </div>
        <div class="biaotit">平台处理结果</div>
        <div class="zy_zszlB zy_zszlBF">
        <div class="txtTousu">
            {if $complaint.CooperationComplaint.result == 1}
              {if $complaint.CooperationComplaint.type == 1}
                          合作企业未反馈,{if $complaint.CooperationComplaint.result_code == 1}暂时关闭权限{else}关闭账号并加入黑名单 {/if}
              {elseif $complaint.CooperationComplaint.type == 2}
                          合作企业未及时付款,{if $complaint.CooperationComplaint.result_code == 1}暂时关闭权限{else}关闭账号并加入黑名单 {/if}
              {else}
                          合作企业未足额付款,{if $complaint.CooperationComplaint.result_code == 1}暂时关闭权限{else}关闭账号并加入黑名单 {/if}
              {/if}
            {else}
                平台判断你投诉无效,{if $complaint.CooperationComplaint.result_code == 1}违规，已违规2次 {else}违规超过3次，关闭此账号  {/if}
            {/if}
            <span class="time">[{$complaint.CooperationComplaint.modified|date_format:"%Y-%m-%d"}]</span>
            <div>{$complaint.CooperationComplaint.remark}</div>
        </div>
    </div>
    {else}
        <div class="biaotit">合作状态</div>
        <div class="zy_zszlB">
          <div class="txtTousu">合作完成</div>
          <span class="time">[{$cooperation.Cooperation.modified|date_format:"%Y-%m-%d"}]</span>
        </div>
    {/if}
    <div class="mebleft">
        <div class="biaotit"><strong>{$parttime.PartTime.title}(兼职)</strong></div>
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
      <div class="biaotit"><strong class="red">{$information.Information.title}(客源)</strong></div>
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
     <a href="javascript:void(0)" id="delete" class="zclan zclan3">删除</a>
     <div id="xq_huif">
        <form id="commentList">
        {$this->element('cooperation_comments_paginator')}
        </form>
    </div>
</div>
{$this->element('parttime_detail')}
{$this->element('information_detail')}