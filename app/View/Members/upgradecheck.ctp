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
      <div class="sjle">
      <div class="xq_zl_xbxq">
      <form id="upgrade" action="" method="post" >
        <table width="570">
        <tbody><tr>
            <td width="176" class="tdRight connection">真实姓名：</td>
            <td width="382" class="tdLeft" colspan="3">{$this->data['name']}
            <input type="hidden" id="name" name="name" value="{$this->data['name']}">
            </td>
          </tr>
           <tr>
            <td class="tdRight">我的头像：</td>
            <td class="tdLeft" colspan="3"><img src="{$this->webroot}img/tx.jpg"></td>
          </tr>
          <tr>
            <td class="tdRight">性别：</td>
            <td class="tdLeft" colspan="3">
            {if $this->data['sex'] == 1}男
            {else}女
            {/if}
            <input type="hidden" name="sex" value="{$this->data['sex']}" />
            </td>
          </tr>
          {if isset($this->data['birthday']) && !empty($this->data['birthday'])}
          <tr>
            <td class="tdRight">生日：</td>
            <td class="tdLeft" colspan="3">
            {$this->data['birthday']}
            <input type="hidden" name="birthday" value="{$this->data['birthday']}" />
            </td>
          </tr>
          {/if}
          <tr>
            <td width="176" class="tdRight connection">手机号码：</td>
            <td class="tdLeft" colspan="3">{$this->data['mobile']}
            <input type="hidden" name="mobile" id="mobile" value="{$this->data['mobile']}" />
            </td>
          </tr>
          <tr>
            <td width="176" class="tdRight">联系电话：</td>
            <td class="tdLeft" colspan="3">{$this->data['telephone']}
            <input type="hidden" name="telephone" id="telephone" value="{$this->data['telephone']}" />
            </td>
          </tr>
          <tr>
            <td width="176" class="tdRight">所在城市：</td>
            <td class="tdLeft" colspan="3">
            {$this->City->cityName($this->data['provincial'])}{$this->City->cityName($this->data['city'])}
			<input type="hidden" name="provincial" id="provincial" value="{$this->data['provincial']}" />
			<input type="hidden" name="city" id="city" value="{$this->data['city']}" />
			</td>
          </tr>
          <tr>
            <td width="176" class="tdRight">公司名称：</td>
            <td class="tdLeft" colspan="3">{$this->data['company']}
            <input type="hidden" name="company" id="company" value="{$this->data['company']}" />
            </td>
          </tr>
          <tr>
            <td class="tdRight">从事行业：</td>
            <td class="tdLeft" colspan="3">{$this->Category->getCategoryName($this->data['category'])}
            <input type="hidden" name="category" id="category" value="{$this->data['category']}">
            </td>
          </tr>
          <tr>
            <td class="tdRight">提供产品或服务：</td>
            <td class="tdLeft" colspan="3">
            {foreach $this->data['service'] as $service}
            {$this->Category->getCategoryName($service)}
            <input type="hidden" name="service[]" value="{$service}">
            {/foreach}
            </td>
          </tr>
          <tr>
            <td class="tdRight">业务范围：</td>
            <td class="tdLeft" colspan="3">{$this->data['business_scope']}
            <input type="hidden" name="business_scope" id="business_scope" value="{$this->data['business_scope']}">
            </td>
          </tr>
          <tr>
            <td class="tdRight connection">支付宝账号：</td>
            <td class="tdLeft " colspan="3">{$this->data['pay_account']}
            <input type="hidden" name="pay_account" id="pay_account" value="{$this->data['pay_account']}" />
            </td>
          </tr>
          <input type="hidden" name="pay_password" value="{$this->data['pay_password']}" />
        </tbody>
        </table>
        </form>
        </div>
		<div class="divBtnContainer" style="width: 200px;">
        <a href="javascript:void(0)" id="upgradeBtn" class="zclan zclan7">升级</a><a href="javascript:void(0)" id="backBtn" class="zclan zclan7">上一步</a>
		</div>
      </div>
    </div>