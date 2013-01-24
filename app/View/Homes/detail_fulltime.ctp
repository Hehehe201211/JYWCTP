<a href="#" class="closeDiv">&nbsp;</a>
<div class="pcontent" >
    <h2>{$fulltime.Fulltime.title}</h2>
    <div class="pleft">
      <div class="biaotit">基本信息</div>
      <p class="jinggao">发布时间：{$fulltime.Fulltime.created|date_format:"%Y-%m-%d"} 信息编号：{$fulltime.Fulltime.id} <br />该信息被浏览 7 次 </p>
      <table width="492" cellspacing="0" cellpadding="0" border="0" class="posInfo">
        <tr>
          <th width="119" scope="row">公司名称：</th>
          <td width="373">
          {$fulltime.Fulltime.company}
          </td>
        </tr>
        <tr>
          <th width="119" scope="row">营业执照：</th>
          <td width="373"><font color="#F00">已验证</font></td>
        </tr>
        <tr>
          <th width="119" scope="row">工作性质：</th>
          <td width="373">{$fulltime.Fulltime.type}</td>
        </tr>
        <tr>
          <th scope="row">薪资待遇：</th>
          <td>{$fulltime.Fulltime.salary}元</td>
        </tr>
        <tr>
          <th scope="row">学历要求：</th>
          <td>
            {$educateds = Configure::read('Fulltime.educated')}
            {$educateds[$fulltime.Fulltime.educated]}
           </td>
        </tr>
        <tr>
          <th scope="row">经验要求：</th>
          <td>1-3年</td>
        </tr>
        <tr>
          <th scope="row">性别要求：</th>
          <td>
            {if $fulltime.Fulltime.sex == 1} 男
            {elseif $fulltime.Fulltime.sex ==2}女
            {else}不限
            {/if}
          </td>
        </tr>
        <tr>
          <th scope="row">招聘人数：</th>
          <td>{$fulltime.Fulltime.number}人</td>
        </tr>
        <tr>
            <th scope="row">职位行业：</th>
            <td>
                {$this->Category->getCategoryName($fulltime.Fulltime.category)}
                <input type="hidden" name="category" id="category" value="{$fulltime.Fulltime.category}" />
            </td>
        </tr>
        <tr>
          <th scope="row">工作区域：</th>
          <td>
            {$provincial = $this->City->cityName($fulltime.Fulltime.provincial)}
            {$city = $this->City->cityName($fulltime.Fulltime.city)}
            {if $provincial != $city}
            {$provincial} {$city}
            {else}
            {$provincial}
            {/if}
          </td>
        </tr>
        <tr>
          <th scope="row">联系人：</th>
          <td>{$fulltime.Fulltime.contact}</td>
        </tr>
        {$contacts = json_decode($fulltime.Fulltime.contact_method, true)}
          {foreach $contacts as $contact}
          <tr>
            <th scope="row">联系方式：</th>
            <td>{$contact.method} {$contact.number}</td>
          </tr>
          {/foreach}
      </table>
    </div>
    <div class="pleft">
      <div class="biaotit">职位要求</div>
      <div class="xxContent">
        {$fulltime.Fulltime.require}
      </div>
      <div class="biaotit">补充说明</div>
      <div class="xxContent">{$fulltime.Fulltime.additional}</div>
  </div>
  <div class="divBtnContainer" style="width:200px">
    <a class="btnDeliverR zclan zclan7" href="javascript:;">投递简历</a>
  </div> 
  <div class="clearfix"></div>
</div>