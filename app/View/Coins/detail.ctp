    <div class="djbuzTit">
        <span class="fk_tit">{if isset($information)}{$information.Information.title}{else}发生错误了{/if}</span>
        <a href="#" title="关闭" class="closeKuang">
        </a>
    </div>
    {if !$error}
     <div class="tableDetail">
        <table width="100%">
            <tbody>
            <tr>
        {$provincial = $this->City->cityName($information.Information.provincial)}
        {$city = $this->City->cityName($information.Information.city)}
          <th width="30%">所在区域：</th>
          <td width="70%">{if $provincial == $city}{$provincial}{else}{$provincial}&nbsp;{$city}{/if}</td>
        </tr>                
                {if $information.Information.type == "0"}
                <tr>
                    <th>行业</td>
                    <td>{$this->Category->getCategoryName($information.Information.industries_id)}</td>
                </tr>
                {/if}
                <tr>
                    <th>产品名称：</th>
                    <td>
                        {$this->Category->getCategoryName($information.Information.category)} 
                        {$this->Category->getCategoryName($information.Information.sub_category)}
                    </td>
                </tr>
                <tr>
                    <th>{if $information.Information.type == "0"}采购单位：{else}产品提供单位：{/if}</th>
                    <td class="red">{$information.Information.company}</td>
                </tr>
                <tr>
                    <th>客源有效期：</th>
                    <td>{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}</td>
                </tr>
                <tr>
                    <th>信息交易价格：</th>
                    <td>
                        {if $history.PaymentHistory.payment_type == 1}
                            业务币：{$history.PaymentHistory.number}元
                        {else if $history.PaymentHistory.payment_type == 2}
                            积分：{$history.PaymentHistory.number}分
                        {/if}
                    </td>
                </tr>
                {if $information.Information.type == "0"}
                    <tr>
                        <th>预计合作金额：</th>
                        <td>{$information.Information.profit}元人民币</td>
                    </tr>
                    
                    <tr>
                        <th>预计合作时间：</th>
                        <td>{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
                    </tr>
                {/if}
                <tr>
                    <th>客户选择服务商因素：</th>
                    <td>{$information.Information.reason}</td>
                </tr>                               
                <tr>
                    <th>联系人：</th>
                    <td class="red">{$information.Information.contact}</td>
                </tr>
                <tr>
                    <th>联系人职位：</th>
                    <td class="red">{$information.Information.post}</td>
                </tr>
                {foreach $attributes as $attribute}
                    <tr>
                        <th>联系方式：</th>
                        <td class="red">{$attribute.InformationAttribute.mode} {$attribute.InformationAttribute.contact_method}</td>
                    </tr>
                {/foreach}
                <tr>
                    <th>单位详细地址：</th>
                    <td class="red">{$information.Information.address}</td>
                </tr>
                <tr>
                    <th>采购需求描述：</th>
                    <td><p>{if empty($information.Information.introduction)}无{else}{$information.Information.introduction}{/if}</p></td>
                </tr>
                <tr>
                    <th>采购补充：</th>
                    <td><p>{if empty($information.Information.additional)}无{else}{$information.Information.additional}{/if}</p></td>
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
    <a href="javascript:void(0)" class="zclan zclan4 close">关闭详情</a>
