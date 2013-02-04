<div class="jsxxxq jsxxxqB" id="jsxxxq1">
<a href="#" class="closeDiv">&nbsp;</a>
  <div class="biaotit">{$parttime.PartTime.title}(兼职)</div>
    <div class="gongsichakan_jobs jsxxxq">
      <div class="gongsichakan_post">
        <p class="jinggao">发布时间： 信息编号： 该信息被浏览 7 次 </p>
        <table class="posInfo" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th scope="row">公司名称：</th>
            <td width="75%">
            <a href="gsqt-index.html" target="_blank" class="red">{$parttime.Member.company_name}</a>
            </td>
          </tr>
          <tr>
            <th scope="row">营业执照：</th>
            <td><font color="#FF0000">已验证</font></td>
          </tr>
          <tr>
            <th scope="row">产品所属分类：</th>
            <td>
            {$this->Category->getCategoryName($parttime.PartTime.category)} 
            {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
            </td>
          </tr>
          <tr>
            <th scope="row">产品具体名称：</th>
            <td>{$parttime.PartTime.sub_title}</td>
          </tr>
          <tr>
            <th scope="row">兼职时间：</th>
            <td>{$parttime.PartTime.open|date_format:"%Y-%m-%d"} 至 {$parttime.PartTime.close|date_format:"%Y-%m-%d"}</td>
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
            <th scope="row">报酬：</th>
            <td>协商确定</td>
          </tr>
          <tr>
            <th scope="row">报酬支付时间：</th>
            <td>收款后{$parttime.PartTime.pay_time}个工作日内转账方式</td>
          </tr>
          <tr>
            <th scope="row" style="vertical-align:top">报酬支付说明：</th>
            <td>{$parttime.PartTime.pay_explanation}</td>
          </tr>
          <tr>
            <th scope="row">推荐参与行业：</th>
            <td>
            {$industries = explode(',', $parttime.PartTime.industry)}
            {foreach $industries as $industry}
                {$this->Category->getCategoryName($industry)} 
            {/foreach}
            </td>
          </tr>
          <tr>
            <th scope="row">联系人：</th>
            <td>
            {$parttime.PartTime.contact}
            </td>
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
          <tr>
            <th scope="row">公司地址：</th>
            <td>{$parttime.PartTime.address}</td>
          </tr>
           <tr>
            <th scope="row">补充说明：</th>
            <td><p>{$parttime.PartTime.additional}</p></td>
          </tr>
        </table>
      </div>
      <div class="divBtnContainer" style="width:100px;">        
      <a class="zclan zclan4" id="close" href="javascript:void(0)">关闭</a>   
      </div>
    </div>
</div>