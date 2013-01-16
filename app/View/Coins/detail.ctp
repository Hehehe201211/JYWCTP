<div style="width:550px;" id="djbuz">
    <div class="djbuzTit">
        <span class="fk_tit">{if isset($information)}{$information.Information.title}{else}发生错误了{/if}</span>
        <a href="#" title="关闭" class="closeKuang close">
        </a>
    </div>
    {if !$error}
     <div style="padding:3px 8px;width:534px;" class="xq_zl_xbxq">
        <table width="100%">
            <tbody>
                <tr>
                    {$provincial = $this->City->cityName($information.Information.provincial)}
                    {$city = $this->City->cityName($information.Information.city)}
                    {if $provincial == $city}
                        <td width="145" class="tdRight">城市：</td>
                        <td width="57" class="tdLeft">{$provincial}</td>
						<td width="42" class="tdRight">&nbsp;</td>
                        <td width="290" class="tdLeft">&nbsp;</td>
                    {else}
                        <td width="145" class="tdRight">省份：</td>
                        <td width="57" class="tdLeft">{$provincial}</td>
                        <td width="42" class="tdRight">城市：</td>
                        <td width="290" class="tdLeft">{$city}</td>
                    {/if}
                </tr>
                {if $information.Information.type == "0"}
                <tr>
                    <td width="132" class="tdRight">行业</td>
                    <td class="tdLeft" colspan="3">{$this->Category->getCategoryName($information.Information.industries_id)}</td>
                </tr>
                {/if}
                <tr>
                    <td class="tdRight">产品名称：</td>
                    <td class="tdLeft" colspan="3">
                        {$this->Category->getCategoryName($information.Information.category)} 
                        {$this->Category->getCategoryName($information.Information.sub_category)}
                    </td>
                </tr>
                <tr>
                    <td class="tdRight connection">{if $information.Information.type == "0"}采购单位：{else}产品提供单位：{/if}</td>
                    <td class="tdLeft" colspan="3">{$information.Information.company}</td>
                </tr>
                <tr>
                    <td class="tdRight">客源有效期：</td>
                    <td class="tdLeft" colspan="3">{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}</td>
                </tr>
                <tr>
                    <td class="tdRight">信息交易价格：</td>
                    <td class="tdLeft" colspan="3">
                        {if $history.PaymentHistory.payment_type == 1}
                            业务币：{$history.PaymentHistory.number}元
                        {else if $history.PaymentHistory.payment_type == 2}
                            积分：{$history.PaymentHistory.number}分
                        {/if}
                    </td>
                </tr>
                {if $information.Information.type == "0"}
                    <tr>
                        <td class="tdRight">预计合作金额：</td>
                        <td class="tdLeft" colspan="3">{$information.Information.profit}元人民币</td>
                    </tr>
                    
                    <tr>
                        <td class="tdRight">预计合作时间：</td>
                        <td class="tdLeft" colspan="3">{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
                    </tr>
                {/if}
                <tr>
                    <td class="tdRight">客户选择服务商因素：</td>
                    <td class="tdLeft" colspan="3">{$information.Information.reason}</td>
                </tr>                               
                <tr>
                    <td class="tdRight connection">联系人：</td>
                    <td class="tdLeft" colspan="3">{$information.Information.contact}</td>
                </tr>
                <tr>
                    <td class="tdRight connection">联系人职位：</td>
                    <td class="tdLeft" colspan="3">{$information.Information.post}</td>
                </tr>
                {foreach $attributes as $attribute}
                    <tr>
                        <td class="tdRight connection">联系方式：</td>
                        <td class="tdLeft" colspan="3">{$attribute.InformationAttribute.mode} {$attribute.InformationAttribute.contact_method}</td>
                    </tr>
                {/foreach}
                <tr>
                    <td class="tdRight connection">单位详细地址：</td>
                    <td class="tdLeft" colspan="3">{$information.Information.address}</td>
                </tr>
                <tr>
                    <td class="tdRight connection">采购需求描述：</td>
                    <td class="tdLeft" colspan="3"><p style="width:390px;">{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</p></td>
                </tr>
                <tr>
                    <td class="tdRight connection">采购补充：</td>
                    <td class="tdLeft" colspan="3"><p style="width:390px;">{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p></td>
                </tr>
            </tbody>
        </table>       
        <div class="biaotit">资金情况</div>
        <div class="xxContent">
              <p>
              {if $history.PaymentHistory.payment_type == 0}
              来自{$member.Member.nickname}的退款
              {else}
                  {$member.Member.nickname}支付给你
              {/if}
                    {if $history.PaymentHistory.payment_type == 1}
                    业务币：{$history.PaymentHistory.number}元
                {else if $history.PaymentHistory.payment_type == 2}
                    积分：{$history.PaymentHistory.number}分
                {/if}
              </p>
        </div>
    </div>
    {else}
    没有你要查看的信息
    {/if}
</div>