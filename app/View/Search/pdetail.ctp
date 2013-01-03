<div class="main">
    <div class="wmxxjs_left">
        <div class="biaotit">{$parttime.PartTime.title}</div>
        <div class="gongsichakan_jobs jsxxxq">
            <div class="gongsichakan_post">
                <p class="jinggao">发布时间：{$parttime.PartTime.created|date_format:"%Y-%m-%d"} 信息编号：{$parttime.PartTime.id} 该信息被浏览 {$parttime.PartTime.clicked + $clicked} 次 </p>
                <table class="posInfo" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th width="148" scope="row">公司名称：</th>
                        <td width="593"><a href="gsqt-index.html" target="_blank" class="red">{$parttime.Member.company_name}</a></td>
                    </tr>
                    <tr>
                        <th width="148" scope="row">营业执照：</th>
                        <td width="593"><font color="#FF0000">已验证</font></td>
                    </tr>
                    <tr>
                        <th width="148" scope="row">产品所属分类：</th>
                        <td width="593">
                        {$this->Category->getCategoryName($parttime.PartTime.category)} 
                        {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
                        </td>
                    </tr>
                    <tr>
                        <th width="148" scope="row">产品具体名称：</th>
                        <td width="593">{$parttime.PartTime.sub_title}</td>
                    </tr>
                    <tr>
                        <th scope="row">兼职时间：</th>
                        <td>{$parttime.PartTime.open|date_format:"%Y-%m-%d"} 至 {$parttime.PartTime.close|date_format:"%Y-%m-%d"}</td>
                    </tr>
                    <tr>
                        <th scope="row">客户区域范围：</th>
                        <td>
                        {$citys = explode(',', $parttime.PartTime.area)}
                        {foreach $citys as $city_id}
                        {$this->City->cityName($city_id)}<br/>
                        {/foreach}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">兼职配合方式：</th>
                        <td>
                        {if $parttime.PartTime.method == 1}提供客户信息
                        {elseif $parttime.PartTime.method == 2}协助跟单
                        {else}独立签单
                        {/if}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">报酬：</th>
                        <td>
                        {if $parttime.PartTime.pay == 1}按合同金额  {$parttime.PartTime.pay_rate}%
                        {else}协商确定
                        {/if}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">报酬支付时间：</th>
                        <td>
                        {if $parttime.PartTime.pay_method == 1}收款后{$parttime.PartTime.pay_time}个工作日内转账
                        {else}其它
                        {/if}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="vertical-align:top">报酬支付补充说明：</th>
                        <td>{$parttime.PartTime.pay_explanation}</td>
                    </tr>
                    <tr>
                        <th scope="row">推荐参与行业：</th>
                        <td>
                        {$categorys = explode(',', $parttime.PartTime.industry)}
                        {foreach $categorys as $id}
                        {$this->Category->getCategoryName($id)} 
                        {/foreach}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">联系人：</th>
                        <td>{$parttime.PartTime.contact}</td>
                    </tr>
                    {$contact_methods = json_decode($parttime.PartTime.contact_method, true)}
                    {foreach $contact_methods as $value}
                        <tr>
                            <th scope="row">联系方式：</th>
                            <td>{$value.method} {$value.number}</td>
                        </tr>
                    {/foreach}
                    <tr>
                        <th scope="row">联系邮箱：</th>
                        <td>{$parttime.PartTime.email}</td>
                    </tr>
                    <tr>
                        <th scope="row">公司地址：</th>
                        <td>{$parttime.PartTime.address}</td>
                    </tr>
                    <tr>
                        <th scope="row">补充说明：</th>
                        <td>{$parttime.PartTime.additional}</td>
                    </tr>
                </table>
            </div>
            <div class="divBtnContainer">
                <a class="zclan zclan7 linkLogin" href="#">我有客源</a>
                <a class="zclan zclan7 linkLogin" href="javascript:;">收藏</a>
            </div>
        </div>
    </div>
    <div class="sider">
        {$this->element('common/parttime-right')}
    </div>
    <div class="clear">&nbsp;</div>
</div>
