<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#complete').click(function(){
        $('#edit').attr('action', '/accounts/editComplete');
        $('#edit').submit();
    });
    
    $('#backBtn').click(function(){
        $('#edit').attr('action', '/accounts/edit');
        $('#edit').submit();
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
        <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
        <a href="javascript:void(0)">账号管理</a>&gt;&gt;
        <a href="javascript:void(0)">完善资料</a>
        </p>
    </div>
<ul class="ulFormStep ulFormStep2">
      <li>1.信息修改</li>
      <li>2.信息确认</li>
      <li>3.修改成功</li>
    </ul> 
        <div class="sjle">
        <div class="xq_zl_xbxq">
            <form id="edit" action="" method="post" >
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
                {if !empty($this->data['license'])}
                <img src="{$this->webroot}{$this->data['license']}">
                {else}
                <img src="{$this->webroot}img/tx.jpg">
                {/if}
                <input type="hidden" id="license" name="license" value="{$this->data['license']}">
            </td>
          </tr>
          <tr>
            <td class="tdRight">公司LOGO：</td>
            <td class="tdLeft" colspan="3">
                {if !empty($thumbnail) && file_exists($thumbnail)}
                    <img src="{$this->webroot}{$thumbnail}">
                    <input type="hidden" id="thumbnail" name="thumbnail" value="{$thumbnail}">
                {elseif !empty($this->data['thumbnail'])}
                    {$thumbnail = Configure::read('Data.path')|cat:$this->data['thumbnail']}
                    {if file_exists($thumbnail)}
                        <img src="{$this->webroot}{$this->data['thumbnail']}">
                        <input type="hidden" id="thumbnail" name="thumbnail" value="{$this->data['thumbnail']}">
                    {else}
                        <img src="{$this->webroot}img/tx.jpg">
                        <input type="hidden" id="thumbnail" name="thumbnail" value="">
                    {/if}
                {else}
                    <img src="{$this->webroot}img/tx.jpg">
                    <input type="hidden" id="thumbnail" name="thumbnail" value="">
                {/if}
            </td>
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
        <a href="javascript:void(0)" id="complete" class="zclan zclan2">提交</a>
        <a href="javascript:void(0)" id="backBtn" class="zclan zclan2">上一步</a>
        </div>
</div>