<div class="jsxxxq jsxxxqB" id="jsxxxq2"> <a href="#" class="closeDiv">&nbsp;</a>
  <div class="gongsichakan_jobs jsxxxq">
  <div class="biaotit">{$information.Information.title}(客源)</div>
      <table width="100%" class="posInfo">
        <tr>
          <th class="tdRight">采购单位：</th>
          <td>{if isset($hiddenContact) && $hiddenContact}******{else}{$information.Information.company}{/if}</td>
        </tr>
        <tr>
          <th class="tdRight" width="20%">客户区域范围：</th>
          <td width="80%">
          {$provincial = $this->City->cityName($information.Information.provincial)} 
          {$city = $this->City->cityName($information.Information.city)}
          {if $provincial != $city}
          {$provincial} {$city}
          {else}
          {$provincial}
          {/if}
          </td>
        </tr>
        <tr>
          <th class="tdRight">行业：</th>
          <td>
          {$this->Category->getCategoryName($information.Information.industries_id)}
          </td>
        </tr>
        <tr>
          <th class="tdRight">提供产品或服务：</th>
          <td>互联网</td>
        </tr>
        <tr>
          <th class="tdRight">产品名称：</th>
          <td>
          {$this->Category->getCategoryName($information.Information.category)} 
          {$this->Category->getCategoryName($information.Information.sub_category)}
          </td>
        </tr>
        <tr>
          <th class="tdRight">客源有效期：</th>
          <td>
          {$information.Information.open|date_format:"%Y-%m-%d"} 至  {$information.Information.close|date_format:"%Y-%m-%d"}
          </td>
        </tr>
        <tr>
          <th class="tdRight">联系人：</th>
          <td>{if isset($hiddenContact) && $hiddenContact}******{else}{$information.Information.contact}{/if}</td>
        </tr>
        <tr>
          <th class="tdRight">联系人职位：</th>
          <td>{if isset($hiddenContact) && $hiddenContact}******{else}{$information.Information.post}{/if}</td>
        </tr>
        {foreach $inforAttr as $attr}
      <tr>
        <th class="tdRight">联系方式：</th>
        <td>
            {$attr.InformationAttribute.mode} 
            {if isset($hiddenContact) && $hiddenContact}******{else}{$attr.InformationAttribute.contact_method}{/if}
        </td>
      </tr>
      {/foreach}
        <tr>
          <th class="tdRight">单位详细地址：</th>
          <td>{if isset($hiddenContact) && $hiddenContact}******{else}{$information.Information.address}{/if}</td>
        </tr>
        <tr>
          <th class="tdRight">预计合作金额：</th>
          <td>{if !empty($information.Information.profit)}{$information.Information.profit}{else}0{/if}元人民币</td>
        </tr>
        <tr>
          <th class="tdRight">预计合作时间：</th>
          <td>{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
        </tr>
        <tr>
          <th class="tdRight">客户选择因素：</th>
          <td>{$information.Information.reason}</td>
        </tr>
         <tr>
          <th class="tdRight">采购需求描述：</th>
          <td>{$information.Information.introduction}</td>
        </tr>
         <tr>
          <th class="tdRight">采购补充：</th>
          <td>{$information.Information.additional}</td>
        </tr>
      </table>     
       <a class="zclan zclan4" href="javascript:void(0)" onclick="$('.jsxxxqB .closeDiv').click();">关闭</a>
      </div>     
</div>