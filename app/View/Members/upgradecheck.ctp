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
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html">账号管理</a>&gt;&gt;<a href="#">个人会员升级</a></p>
    </div>
      <ul class="ulFormStep ulFormStep2">
        <li>1.填写个人资料</li>
        <li>2.信息确认</li>
        <li>3.升级成功</li>
      </ul>
      <div class="tableDetail">
      <form id="upgrade" action="" method="post" >
        <table width="100%">
        <tr>
            <th width="30%">真实姓名：</th>
            <td width="70%" class="red">{$this->data['name']}
            <input type="hidden" id="name" name="name" value="{$this->data['name']}">
            </td>
          </tr>
           <tr>
            <th>我的头像：</th>
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
            <th>性别：</th>
            <td>
            {if $this->data['sex'] == 1}男
            {else}女
            {/if}
            <input type="hidden" name="sex" value="{$this->data['sex']}" />
            </td>
          </tr>
          {if isset($this->data['birthday']) && !empty($this->data['birthday'])}
          <tr>
            <th>生日：</th>
            <td>
            {$this->data['birthday']}
            <input type="hidden" name="birthday" value="{$this->data['birthday']}" />
            </td>
          </tr>
          {/if}
          <tr>
            <th>手机号码：</th>
            <td class="red">{$this->data['mobile']}
            <input type="hidden" name="mobile" id="mobile" value="{$this->data['mobile']}" />
            </td>
          </tr>
          <tr>
            <th>联系电话：</th>
            <td>{$this->data['telephone']}
            <input type="hidden" name="telephone" id="telephone" value="{$this->data['telephone']}" />
            </td>
          </tr>
          <tr>
            <th>所在城市：</th>
            <td>
            {$provincial = $this->City->cityName($this->data['provincial'])}
            {$city = $this->City->cityName($this->data['city'])}
            {if $provincial == $city}
            {$provincial}
            {else}
            {$provincial} {$city}
            {/if}
			<input type="hidden" name="provincial" id="provincial" value="{$this->data['provincial']}" />
			<input type="hidden" name="city" id="city" value="{$this->data['city']}" />
			</td>
          </tr>
          <tr>
            <th>公司名称：</th>
            <td>{$this->data['company']}
            <input type="hidden" name="company" id="company" value="{$this->data['company']}" />
            </td>
          </tr>
          <tr>
            <th>从事行业：</th>
            <td>{$this->Category->getCategoryName($this->data['category'])}
            <input type="hidden" name="category" id="category" value="{$this->data['category']}">
            </td>
          </tr>
          <tr>
            <th>提供产品或服务：</th>
            <td>
            {foreach $this->data['service'] as $service}
            {$this->Category->getCategoryName($service)}
            <input type="hidden" name="service[]" value="{$service}">
            {/foreach}
            </td>
          </tr>
          <tr>
            <th>业务范围：</th>
            <td>{$this->data['business_scope']}
            <input type="hidden" name="business_scope" id="business_scope" value="{$this->data['business_scope']}">
            </td>
          </tr>
          <tr>
            <th>支付宝账号：</th>
            <td class="red">{$this->data['pay_account']}
            <input type="hidden" name="pay_account" id="pay_account" value="{$this->data['pay_account']}" />
            </td>
          </tr>
          <input type="hidden" name="pay_password" value="{$this->data['pay_password']}" />
        </table>
        </form>
        </div>
        <div class="divBtnContainer" style="width: 200px;">
        <a href="javascript:void(0)" id="upgradeBtn" class="zclan zclan7">升级</a><a href="javascript:void(0)" id="backBtn" class="zclan zclan7">上一步</a>
		</div>
    </div>