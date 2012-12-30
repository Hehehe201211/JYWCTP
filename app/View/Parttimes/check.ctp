<script>
{literal}
$(document).ready(function(){
    $('#complete').click(function(){
		if($("#vehiclePT").attr("checked")!="checked") {
			$(".divProtocol .protocol").append('<font color="#FF0000">请接受协议</font>');
		} else {
			$('#completeForm').attr('action', '/parttimes/complete');
			$('#completeForm').submit();
		}
    });
    $('#back').click(function(){
        $('#completeForm').attr('action', '/parttimes/create');
        $('#completeForm').submit();
    });

});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="qy-jzfbmx.html">兼职管理</a>&gt;&gt;<a href="#">发布兼职</a></p>      
    </div>    
    <div class="hysj hysj_fb">
      <ul>
        <li>1.填写兼职信息</li>
        <li>2.确认兼职信息</li>
        <li>3.兼职发布成功</li>
      </ul>
      <div class="sjle">
        <div class="xq_zl">
          <div class="xq_zl_xbxq">
          <form method="post" action="" id="completeForm">
            <div class="biaotit">
            {$this->data['title']}
            <input type="hidden" name="title" value="{$this->data['title']}">
            </div>
            <table width="570">
              <tbody>
              <tr>
                <td class="tdRight connection">产品所属分类：</td>
                <td class="tdLeft" colspan="3">
                {$this->Category->getCategoryName($this->data['category'])} {$this->Category->getCategoryName($this->data['sub_category'])}
                <input type="hidden" name="category" value="{$this->data['category']}">
                <input type="hidden" name="sub_category" value="{$this->data['sub_category']}">
                </td>
              </tr>
              <tr>
                <td class="tdRight connection">产品具体名称：</td>
                <td class="tdLeft" colspan="3">
                {$this->data['sub_title']}
                <input type="hidden" name="sub_title" value="{$this->data['sub_title']}">
                </td>
              </tr>
              <tr>
                <td class="tdRight">兼职时间：</td>
                <td class="tdLeft" colspan="3">
                {$this->data['open']} - {$this->data['close']}
                <input type="hidden" name="open" value="{$this->data['open']}">
                <input type="hidden" name="close" value="{$this->data['close']}">
                </td>
              </tr>
              <tr>
                <td width="132" class="tdRight connection">客户区域范围：</td>
                <td class="tdLeft" colspan="3">
                {foreach $this->data['citys'] as $id}
                {$this->City->cityName($id)}
                <input type="hidden" name="citys[]" value="{$id}">
                {/foreach}
                </td>
              </tr>
              <tr>
                <td class="tdRight connection">兼职配合方式：</td>
                <td class="tdLeft" colspan="3">
                {if $this->data['method'] == 1}
                提供客户信息
                {elseif $this->data['method'] == 2}
                协助跟单
                {else}
                独立签单
                {/if}
                <input type="hidden" name="method" value="{$this->data['method']}">
                </td>
              </tr>
              <tr>
                <td class="tdRight connection">报酬：</td>
                <td class="tdLeft" colspan="3">
                {if $this->data['pay'] == 1}
                按合同金额百分比：{$this->data['pay_rate']}%
                <input type="hidden" name="pay_rate" value="{$this->data['pay_rate']}">
                {elseif $this->data['pay'] == 2}
                按单数，每单：{$this->data['pay_money']}元
                <input type="hidden" name="pay_rate" value="{$this->data['pay_money']}">
                {else}
                协商确定
                {/if}
                <input type="hidden" name="pay" value="{$this->data['pay']}">
                
                </td>
              </tr>
              <tr>
                <td class="tdRight connection">报酬支付时间：</td>
                <td class="tdLeft" colspan="3">
                {if $this->data['pay_method'] == 1}
                收款后{$this->data['pay_time']}个工作日内转账
                {else}
                其它
                {/if}
                <input type="hidden" name="pay_method" value="{$this->data['pay_method']}">
                <input type="hidden" name="pay_time" value="{$this->data['pay_time']}">
                </td>
              </tr>
              <tr>
                <td class="tdRight connection">兼职者推荐参与行业：</td>
                <td class="tdLeft" colspan="3">
                {if isset($this->data['categorys'])}
                    {foreach $this->data['categorys'] as $id}
                    {$this->Category->getCategoryName($id)} 
                    <input type="hidden" name="categorys[]" value="{$id}">
                    {/foreach}
                {/if}
                </td>
              </tr>
              <tr>
                <td class="tdRight">联系人：</td>
                <td class="tdLeft" colspan="3">
                {$this->data['contact']}
                <input type="hidden" name="contact" value="{$this->data['contact']}">
                </td>
              </tr>
              {foreach $this->data['contact_method'] as $key => $value}
              <tr>
                <td class="tdRight">联系方式：</td>
                <td class="tdLeft" colspan="3">
                {$value} {$this->data['contact_content'][$key]}
                <input type="hidden" name="contact_method[]" value="{$value}">
                <input type="hidden" name="contact_content[]" value="{$this->data['contact_content'][$key]}">
                </td>
              </tr>
              {/foreach}
              <tr>
                <td class="tdRight">联系邮箱：</td>
                <td class="tdLeft" colspan="3">
                {$this->data['email']}
                <input type="hidden" name="email" value="{$this->data['email']}">
                </td>
              </tr>
              <tr>
                <td class="tdRight">联系地址：</td>
                <td class="tdLeft" colspan="3">
                {$this->data['address']}
                <input type="hidden" name="address" value="{$this->data['address']}">
                </td>
              </tr>
              <tr>
                <td class="tdRight">报酬支付说明：</td>
                <td class="tdLeft" colspan="3">
                <p>
              {$this->data['pay_explanation']}
              <input type="hidden" name="pay_explanation" value="{$this->data['pay_explanation']}">
              </p>
                </td>
              </tr>
              <tr>
                <td class="tdRight">兼职补充说明：</td>
                <td class="tdLeft" colspan="3">
                <p>
              {$this->data['additional']}
              <input type="hidden" name="additional" value="{$this->data['additional']}">
              </p>
                </td>
              </tr>
            </tbody>
            </table>
          <div class="divProtocol">            
              <label for="vehiclePT" class="protocol">
              <input type="checkbox" class="inpCheckbox" name="vehicle" id="vehiclePT">
              我接受 <a href="#">《聚业务兼职政策（试行）》</a> </label>
          </div>
          <a href="javascript:void(0)" class="zclan zclan2" id="complete">提交</a>
          <a href="javascript:void(0)" class="zclan zclan2" id="back">修改</a>
          </form>
          </div>
        </div>
      </div>      
    </div>    
</div>