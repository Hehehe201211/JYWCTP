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
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">账号管理</a>&gt;&gt;
      <a href="javascript:void(0)">企业会员升级</a>
      </p>      
    </div>
    <ul class="ulFormStep ulFormStep2">
        <li>1.填写企业资料</li>
        <li>2.信息确认</li>
        <li>3.升级成功</li>
      </ul>
      <div class="sjle">
      <div class="tableDetail">
      <form id="upgrade" action="" method="post" >
      <input type="hidden" name="type" value="1">
        <table width="100%">
        <tbody><tr>
            <th width="25%">公司全名：</th>
            <td width="75%" class="red">
            {$this->data['full_name']}
            <input type="hidden" name="full_name" id="full_name" value="{$this->data['full_name']}"/>
            </td>
          </tr>
          <tr>
            <th>成立时间：</th>
            <td>
            {$this->data['established']}
            <input type="hidden" name="established" id="established" value="{$this->data['established']}"/>
            </td>
          </tr>
          <tr>
            <th>联系人：</th>
            <td>
            {$this->data['contact']}
            <input type="hidden" name="contact" id="contact" value="{$this->data['contact']}"/>
            </td>
          </tr>
          <tr>
            <th>营业执照：</th>
            <td>
                {if !empty($thumbnail)}
                <img src="{$this->webroot}{$thumbnail}">
                {else}
                <img src="{$this->webroot}img/tx.jpg">
                {/if}
            </td>
            <input type="hidden" name="thumbnail" value="{$thumbnail}" />
          </tr>
          <tr>
            <th>公司LOGO：</th>
            <td>
                {if !empty($logo)}
                <img src="{$this->webroot}{$logo}">
                {else}
                <img src="{$this->webroot}img/tx.jpg">
                {/if}
            </td>
            <input type="hidden" name="logo" value="{$logo}" />
          </tr>
          {foreach $this->data['contact_method'] as $key => $value}
          <tr>
            <th>联系方式：</th>
            <td>
            
            {$value} {$this->data['contact_content'][$key]}
            <input type="hidden" name="contact_method[]" id="contact_method" value="{$value}"/>
            <input type="hidden" name="contact_content[]" id="contact_content" value="{$this->data['contact_content'][$key]}"/>
            </td>
          </tr>
          {/foreach}
          <tr>
            <th>传真：</th>
            <td>
            {$this->data['fax']}
            <input type="hidden" name="fax" id="fax" value="{$this->data['fax']}"/>
            </td>
          </tr>
          <tr>
            <th>所在城市：</th>
            <td>
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
            <th>公司详细地址：</th>
            <td>
            {$this->data['address']}
            <input type="hidden" name="address" id="address" value="{$this->data['address']}">
            </td>
          </tr>
          <tr>
            <th>公司性质：</th>
            <td>
            {$this->data['company_type']}
            <input type="hidden" name="company_type" id="company_type" value="{$this->data['company_type']}">
            </td>
          </tr>
          <tr>
            <th>从事行业：</th>
            <td>
            {$this->Category->getCategoryName($this->data['category_id'])}
            <input type="hidden" name="category_id" id="category" value="{$this->data['category_id']}">
            </td>
          </tr>
          <tr>
            <th>提供产品或服务：</th>
            <td>
            {foreach $this->data['service'] as $value}
            {$this->Category->getCategoryName($value)}&nbsp;
            <input type="hidden" name="service[]" id="service" value="{$value}">
            {/foreach}
            </td>
          </tr>
          <tr>
            <th>业务范围：</th>
            <td>
            {$this->data['business_scope']}
            <input type="hidden" name="business_scope" id="business_scope" value="{$this->data['business_scope']}">
            </td>
          </tr>
        </tbody>
        </table>
        </form>
        </div>
        <div class="divBtnContainer" style="width: 200px;">
        <a class="zclan zclan7" id="upgradeBtn" href="javascript:void(0)">升级</a>
        <a class="zclan zclan7" id="backBtn" href="javascript:void(0)">上一步</a>
        </div>
      </div>
</div>