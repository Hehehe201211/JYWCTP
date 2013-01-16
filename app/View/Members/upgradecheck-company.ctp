<script type="text/javascript">
$(document).ready(function(){
    $('#upgradeBtn').click(function(){
        $('#upgrade').attr('action', '/members/upgradecomplete');
        $('#upgrade').submit();
    });
    
    $('#backBtn').click(function(){
        $('#upgrade').attr('action', '/members/upgrade');
        $('#upgrade').submit();
    });    
});
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="apep-zhaq.html">账号管理</a>&gt;&gt;<a href="#">企业会员升级</a></p>
      <div class="zy_zszl enterpriseInfo">
        <div class="zy_zszl_z">
          <dl>
            <dt>
              <dl>
                <dt><img src="{$this->webroot}img/tx.jpg"></dt>
                <dd class="mebInfo"><span>会员昵称：聚业务</span><span>公司名称：厦门有限公司厦门有限公司</span><span>绑定邮箱：ya*****@qq.com</span><span>行业：互联网</span><span>地址：福建省厦门市</span></dd>
              </dl>
            </dt>
            <dd><span>账户有效期：2012-09-20&nbsp;至&nbsp;2013-09-20</span></dd>
            <!--<dd><span>资料完整度：</span><span class="progressBar"><span>&nbsp;20%&nbsp;</span></span><a href="#">完善资料</a><a class="icon iconZ" href="#" title="营业执照已认证"></a><a class="icon iconM" href="#" title="未绑定邮箱"></a></dd>-->
          </dl>
        </div>
        <div class="zy_zszl_r">
          <dl>            
            <dd><span>简历总量：<strong>0</strong>份</span><span>常规招聘总职位：<strong>0</strong>个</span><span>平台兼职总职位：<strong>0</strong>个</span><span>高级个人会员：<strong>0</strong>位</span><span>高级企业会员：<strong>0</strong>家</span><span><a class="upgrade" href="apep-hysj1.html">升级到高级会员</a></span></dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="hysj hysj_fb">
      <ul>
        <li>1.填写企业资料</li>
        <li>2.信息确认</li>
        <li>3.升级成功</li>
      </ul>
      <div class="sjle">
      <div class="xq_zl_xbxq">
      <form id="upgrade" action="" method="post" >
      <input type="hidden" name="type" value="1">
        <table width="570">
        <tbody><tr>
            <td width="176" class="tdRight connection">公司全名：</td>
            <td width="382" colspan="3" class="tdLeft">
            {$this->data['full_name']}
            <input type="hidden" name="full_name" id="full_name" value="{$this->data['full_name']}"/>
            </td>
          </tr>
          <tr>
            <td class="tdRight">成立时间：</td>
            <td colspan="3" class="tdLeft">
            {$this->data['established']}
            <input type="hidden" name="established" id="established" value="{$this->data['established']}"/>
            </td>
          </tr>
          <tr>
            <td class="tdRight">联系人：</td>
            <td colspan="3" class="tdLeft">
            {$this->data['contact']}
            <input type="hidden" name="contact" id="contact" value="{$this->data['contact']}"/>
            </td>
          </tr>
          <tr>
            <td class="tdRight">营业执照：</td>
            <td class="tdLeft" colspan="3">
                {if !empty($thumbnail)}
                <img src="{$this->webroot}{$thumbnail}">
                {else}
                <img src="{$this->webroot}img/tx.jpg">
                {/if}
            </td>
            <input type="hidden" name="license" value="{$thumbnail}" />
          </tr>
          {foreach $this->data['contact_method'] as $key => $value}
          <tr>
            <td width="176" class="tdRight">联系方式：</td>
            <td colspan="3" class="tdLeft">
            
            {$value} {$this->data['contact_content'][$key]}
            <input type="hidden" name="contact_method[]" id="contact_method" value="{$value}"/>
            <input type="hidden" name="contact_content[]" id="contact_content" value="{$this->data['contact_content'][$key]}"/>
            </td>
          </tr>
          {/foreach}
          <tr>
            <td width="176" class="tdRight">传真：</td>
            <td colspan="3" class="tdLeft">
            {$this->data['fax']}
            <input type="hidden" name="fax" id="fax" value="{$this->data['fax']}"/>
            </td>
          </tr>
          <tr>
            <td width="176" class="tdRight">所在城市：</td>
            <td colspan="3" class="tdLeft">
            {$provincial = $this->City->cityName($this->data['provincial_id'])}
            {$city = $this->City->cityName($this->data['city_id'])}
            {if $provincial == $city}
                {$provincial}
            {else}
                {$provincial} {$city}
            {/if}
            <input type="hidden" name="provincial_id" id="provincial_id" value="{$this->data['provincial_id']}"/>
            <input type="hidden" name="city_id" id="city_id" value="{$this->data['city_id']}"/>
            </td>
          </tr>
          <tr>
            <td width="176" class="tdRight">公司详细地址：</td>
            <td colspan="3" class="tdLeft">
            {$this->data['address']}
            <input type="hidden" name="address" id="address" value="{$this->data['address']}">
            </td>
          </tr>
          <tr>
            <td width="176" class="tdRight">公司性质：</td>
            <td colspan="3" class="tdLeft">
            {$this->data['company_type']}
            <input type="hidden" name="company_type" id="company_type" value="{$this->data['company_type']}">
            </td>
          </tr>
          <tr>
            <td class="tdRight">从事行业：</td>
            <td colspan="3" class="tdLeft">
            {$this->Category->getCategoryName($this->data['category_id'])}
            <input type="hidden" name="category_id" id="category" value="{$this->data['category_id']}">
            </td>
          </tr>
          <tr>
            <td class="tdRight">提供产品或服务：</td>
            <td colspan="3" class="tdLeft">
            {foreach $this->data['service'] as $value}
            {$this->Category->getCategoryName($value)}&nbsp;
            <input type="hidden" name="service[]" id="service" value="{$value}">
            {/foreach}
            </td>
          </tr>
          <tr>
            <td class="tdRight">业务范围：</td>
            <td colspan="3" class="tdLeft">
            {$this->data['business_scope']}
            <input type="hidden" name="business_scope" id="business_scope" value="{$this->data['business_scope']}">
            </td>
          </tr>
        </tbody>
        </table>
        </form>
        </div>
        <a class="zclan zclan2" id="upgradeBtn" href="javascript:void(0)">升级</a>
        <a class="zclan zclan2" id="backBtn" href="javascript:void(0)">上一步</a>
      </div>
    </div>
</div>