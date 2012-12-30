{assign var=options value=['update' => '#informationList', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div class="tableSort">      
      <label><input type="checkbox" id="" name="type" value="1" class="inpCheckbox">企业合作成功未反馈</label>      
      <label><input type="checkbox" id="" name="type" value="2" class="inpCheckbox">合作成功未及时付款</label>      
      <label><input type="checkbox" checked="checked" name="type" id="" value="3" class="inpCheckbox">合作成功未足额付款</label>
      <input type="button" value="查看" class="inpButton">
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
        <thead>
            <tr class="con_2_tr con_2_xq_too">
                <th width="150" class="tr_td1">{if $type == "send"}兼职公司名称{else}会员名{/if}</th>
                <th width="110" class="tr_td2">产品或服务</th>
                <th width="85" class="tr_td2">客户区域范围</th>
                <th width="90" class="tr_td5">投诉原因</th>
                <th width="72" class="tr_td5">投诉时间</th>
                <th width="110" class="tr_td6">选择操作</th>
            </tr>
        </thead>
        {foreach $cooperations as $coop}
            <tr class="con_2_tr">
                <td class="tr_td1">
                    <a target="_blank" href="/cooperations/complaintdetail/?{$type}={$coop.Complaint.id}">
                    {if $type == "send"}
                        {$coop.Member.company_name}
                    {else}
                        {$coop.Member.nickname}
                    {/if}
                    </a>
                </td>
                <td class="tr_td2">
                    <a target="_blank" href="/cooperations/complaintdetail/?{$type}={$coop.Complaint.id}">
                        {$this->Category->getCategoryName($coop.PartTime.category)}
                        {$this->Category->getCategoryName($coop.PartTime.sub_category)}
                    </a>
                </td>
                <td class="tr_td2">
                    <a target="_blank" href="/cooperations/complaintdetail/?{$type}={$coop.Complaint.id}">
                        {$provincial = $this->City->cityName($coop.Information.provincial)}
                        {$city = $this->City->cityName($coop.Information.city)}
                        {if $provincial == $city}
                            {$provincial}
                        {else}
                            {$provincial} {$city}
                        {/if}
                    </a>
                </td>
                <td class="tr_td5"><a target="_blank" href="/cooperations/complaintdetail/?{$type}={$coop.Complaint.id}">
                {if $coop.Complaint.type == 1}
                企业合作成功未反馈
                {elseif $coop.Complaint.type == 2}
                合作成功未及时付款
                {else}
                合作成功未足额付款
                {/if}
                </a>
                </td>
                <td class="tr_td5"><a target="_blank" href="/cooperations/complaintdetail/?{$type}={$coop.Complaint.id}">{$coop.Complaint.created|date_format:"%Y-%m-%d"}</a></td>
                <td class="con_2_xq_tofu xiushan_anniu">
                    <a href="/cooperations/complaintdetail/?{$type}={$coop.Complaint.id}" target="_blank" style="font-weight: normal;">详情</a>
                </td>
            </tr>
        {/foreach}
</table>
<div class="fanyea">
                    {if $paginatorParams['prevPage']}
                        <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
                    {/if}
                    <div class="dd_ym">
                        <label>每页显示：</label>
                        <select name="pageSize" id="pageSize">
                            <option value="2" {if $pageSize == "10"} selected {/if}>10</option>
                            <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                            <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                            <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
                        </select>
                    </div>
                    <div class="dd_ym11">
                          <font>共{$paginatorParams['count']}条</font>
                          <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                          <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                          <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
                    </div>
                    {if $paginatorParams['nextPage']}
                        <div style="float:left; margin-left:6px;" class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                    {/if}
                </div>
{$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}