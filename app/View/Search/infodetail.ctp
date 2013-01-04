<div class="main">
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="wmxxjs_left">
     <div class="biaotit">{$information.Information.title}</div>
     <div class="gongsichakan_post">        
        <div class="fl">
        <div class="biaotit">基本信息</div>
        <table width="100%" class="posInfo">          
          <tbody><tr>
            <th width="132" class="tdRight">需求地区：</th>
            <td class="tdLeft" colspan="3">
            {$provincial = $this->City->cityName($information.Information.provincial)}
        	{$city = $this->City->cityName($information.Information.city)}
        	{if $provincial == $city}
        	{$provincial}
        	{else}
        	{$provincial} {$city}
        	{/if}
            </td>
          </tr>
          <tr class="even">
            <th width="132" class="tdRight">行业：</th>
            <td class="tdLeft" colspan="3">{$this->Category->getCategoryName($information.Information.industries_id)}</td>
          </tr>
          <tr>
            <th class="tdRight connection">采购单位：</th>
            <td class="tdLeft" colspan="3">******</td>
          </tr>
          <tr class="even">
            <th class="tdRight">产品名称：</th>
            <td class="tdLeft" colspan="3">
            {$this->Category->getCategoryName($information.Information.category)} 
			{$this->Category->getCategoryName($information.Information.sub_category)}
			</td>
          </tr>
          <tr>
            <th class="tdRight">客源有效期：</th>
            <td class="tdLeft" colspan="3">{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}</td>
          </tr>
          <tr class="even">
            <th class="tdRight">信息交易价格：</th>
            <td class="tdLeft" colspan="3">
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
            <th class="tdRight connection">联系人：</th>
            <td class="tdLeft" colspan="3">******</td>
          </tr>
          <tr class="even">
            <th class="tdRight connection">联系人职位：</th>
            <td class="tdLeft" colspan="3">******</td>
          </tr>
          <tr>
            <th class="tdRight connection">联系方式：</th>
            <td class="tdLeft" colspan="3">******</td>
          </tr>
          <tr class="even">
            <th class="tdRight connection">单位详细地址：</th>
            <td class="tdLeft" colspan="3">******</td>
          </tr>
          <tr>
            <th class="tdRight">预计合作金额：</th>
            <td class="tdLeft" colspan="3">{$information.Information.profit}元人民币</td>
          </tr>
          <tr class="even">
            <th class="tdRight">预计合作时间：</th>
            <td class="tdLeft" colspan="3">{$information.Information.finished}</td>
          </tr>
          <tr>
            <th class="tdRight">客户选择服务商因素：</th>
            <td class="tdLeft" colspan="3">{$information.Information.reason}</td>
          </tr>           
        </tbody></table>      
        </div>
        <div class="fl flB">
         	<div class="biaotit">采购需求描述</div>
         	<p>{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</p>
            <div class="biaotit">采购补充</div>
            <p>{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p>
        </div>  
        <div class="clear"></div>
      </div>
    <a style="margin-top:12px;" href="javascript:;" class="zclan zclan4 linkLogin">我需要</a>
   </div>
  <div class="sider">
    <div class="fuwu">         
      <h1 class="h1Zy_rzj_tt"><a href="plf-wyky2.html"><span class="fr">更多...</span>最新需求发布</a></h1>   
      <ul class="zy_rzj_tt">
          <li style="text-overflow: ellipsis;"><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html" style="margin-left: 0px;">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li style="text-overflow: ellipsis;"><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html" style="margin-left: 0px;">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li style="text-overflow: ellipsis;"><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html" style="margin-left: 0px;">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li style="text-overflow: ellipsis;"><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html" style="margin-left: 0px;">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li style="text-overflow: ellipsis;"><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html" style="margin-left: 0px;">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li style="text-overflow: ellipsis;"><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html" style="margin-left: 0px;">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a title="2012-11-16 09:28" target="_blank" href="jzxxxq2.html">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
        </ul>
    </div>
  </div>
  <div class="clear">&nbsp;</div>
<!-- InstanceEndEditable -->
</div>