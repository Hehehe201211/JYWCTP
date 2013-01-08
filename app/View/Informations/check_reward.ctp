<script>
$(document).ready(function(){
	$('#complete').click(function(){
		if($('#accept').attr('checked') == "checked") {
			$('#form').submit();
		} else {
			$('.protocol').append('<span style="color:red">请接受协议内容</span>')
		}
		
	});
	$('#back').click(function(){
		var type = $('#type').val();
		var action;
		if (type == 0) {
			action = '/informations/create/has';
		} else {
			action = '/informations/create/need';
		}
		$('#form').attr('action', action).submit();
	});
});

</script>
<div class="zy_z">
<ul class="ulFormStep ulFormStep2">
      <li>1.填写发布信息</li>
      <li>2.确认信息</li>
      <li>3.发布成功</li>
    </ul>
      <div class="sjle">
        <div class="xq_zl">
          <div class="xq_zl_xbxq">
          <form action="/informations/complete" method="post" id="form">
          <input type="hidden" name="type" value="{$this->data['type']}">
            <div class="biaotit">{$this->data['title']}<input type="hidden" value="{$this->data['title']}" name="title" /></div>
            <table width="570">
              <tbody><tr>
                <td width="132" class="tdRight">省份：</td>
                <td width="57" class="tdLeft">{$provincial}<input type="hidden" value="{$this->data['provincial']}" name="provincial" /></td>
                <td width="42" class="tdRight">城市：</td>
                <td width="319" class="tdLeft">{$city}<input type="hidden" value="{$this->data['city']}" name="city" /></td>
              </tr>
              <tr>
                <td class="tdRight">产品名称：</td>
                <td class="tdLeft" colspan="3">
                    {$category}
                    <input type="hidden" value="{$this->data['category']}" name="category" />
                    <input type="hidden" value="{$this->data['sub_category']}" name="sub_category" />
                    <input type="hidden" value="{if isset($this->data['other_category'])}{$this->data['other_category']}{/if}" name="other_category" />
                </td>
              </tr>
              <tr>
                <td class="tdRight">产品提供单位：</td>
                <td class="tdLeft" colspan="3">{$this->data['company']}<input type="hidden" value="{$this->data['company']}" name="company" /></td>
              </tr>
              <tr>
                <td class="tdRight">信息悬赏价格：</td>
                <td class="tdLeft" colspan="3">
                    {if isset($this->data['pay_coin']) && $this->data['pay_coin'] == 1} 
                                                                聚客币：{$this->data['price']}元 
                        <input type="hidden" value="{$this->data['pay_coin']}" name="pay_coin" />
                        <input type="hidden" value="{$this->data['price']}" name="price" />
                    {/if} 
                    {if isset($this->data['pay_point']) && $this->data['pay_point'] == 1} 
                                                            积分：{$this->data['point']}分 
                        <input type="hidden" value="{$this->data['pay_point']}" name="pay_point" /> 
                        <input type="hidden" value="{$this->data['point']}" name="point" /> 
                    {/if}
                </td>
              </tr>       
              <tr>
                <td class="tdRight">悬赏有效期：</td>
                <td class="tdLeft" colspan="3">{$this->data['open']} - {$this->data['close']}
                    <input type="hidden" value="{$this->data['open']}" name="open" /> 
                    <input type="hidden" value="{$this->data['close']}" name="close" />
            </td>
              </tr>
              <tr>
                <td class="tdRight">客户选择服务商因素：</td>
                <td class="tdLeft" colspan="3">{$this->data['reason']}
                    <input type="hidden" value="{$this->data['reason']}" name="reason" />
                </td>
              </tr>
              <tr>
                <td class="tdRight">产品信息描述：</td>
                <td class="tdLeft" colspan="3">
                    {$this->data['introduction']}
                        <input type="hidden" value="{$this->data['introduction']}" name="introduction" />
                </td>
              </tr>
              <tr>
                <td class="tdRight">补充说明：</td>
                <td class="tdLeft" colspan="3">
                     {$this->data['additional']}
                     <input type="hidden" value="{$this->data['additional']}" name="additional" />
                </td>
              </tr>
              
            </tbody></table>         
            </form>
             </div>
            <div class="divProtocol">
              <label for="vehicle" class="protocol">
                <input type="checkbox" class="inpCheckbox" name="accept" id="accept" style="background: none repeat scroll 0% 0% transparent;">
                我接受 <a href="#">《聚业务服务协议（试行）》</a> </label>
            </div>
            <div class="clear"></div>
          </div>
            <a class="zclan zclan2" href="javascript:void(0)" id="complete">发布</a> 
            <a class="zclan zclan2" href="javascript:void(0)" id="back">修改</a>
          </div>
      </div>