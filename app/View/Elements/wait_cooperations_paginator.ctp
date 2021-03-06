{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#informationList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div class="tableSort">
      <label><input type="checkbox" name="status[]" value="{Configure::read('Cooperation.status.cooperating')}" {if in_array(Configure::read('Cooperation.status.cooperating'), $status)}checked="checked"{/if} class="inpCheckbox">合作中</label>
      <label><input type="checkbox" name="status[]" value="{Configure::read('Cooperation.status.failure')}" {if in_array(Configure::read('Cooperation.status.failure'), $status)}checked="checked"{/if} class="inpCheckbox">失败待个人确认</label>
      <label><input type="checkbox" name="status[]" value="{Configure::read('Cooperation.status.waitpay')}" {if in_array(Configure::read('Cooperation.status.waitpay'), $status)}checked="checked"{/if} class="inpCheckbox">成功待付款</label>
      <label><input type="checkbox" name="status[]" value="{Configure::read('Cooperation.status.paid')}" {if in_array(Configure::read('Cooperation.status.paid'), $status)}checked="checked"{/if} class="inpCheckbox">已付款待确认</label>
      <select class="sort" name="sort">
        <option value="DESC" {if $sort == "DESC"}selected="selected"{/if}>时间降序</option>
        <option value="ASC" {if $sort == "ASC"}selected="selected"{/if}>时间升序</option>
      </select>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
        <thead>
            <tr class="con_2_tr con_2_xq_too">
                <th width="150" class="tr_td1">{if $type == "send"}兼职公司名称{else}会员名{/if}</th>
                <th width="110" class="tr_td2">产品或服务</th>
                <th width="85" class="tr_td2">客户区域范围</th>
                <th width="90" class="tr_td5">合作状态</th>
                <th width="72" class="tr_td5">投递时间</th>
                <th width="110" class="tr_td6">选择操作</th>
            </tr>
        </thead>
        <tbody>
        {if $type == "send"}
            {$status = Configure::read('Cooperation.send_status')}
        {else}
            {$status = Configure::read('Cooperation.receive_status')}
        {/if}
        {foreach $cooperations as $coop}
            <tr class="con_2_tr">
                <td class="tr_td1{if $type == "send" && $coop.Cooperation.send_readed == 0} new{elseif $type == "receive" && $coop.Cooperation.receive_readed == 0} new{/if}">
                    <a target="_blank" href="/cooperations/waitdetail/?{$type}={$coop.Cooperation.id}">
                    {if $type == "send"}
                        {$coop.Member.company_name}
                    {else}
                        {$coop.Member.nickname}
                    {/if}
                    </a>
                </td>
                <td class="tr_td2">
                    <a target="_blank" href="/cooperations/waitdetail/?{$type}={$coop.Cooperation.id}">
                        {$this->Category->getCategoryName($coop.PartTime.category)}
                        {$this->Category->getCategoryName($coop.PartTime.sub_category)}
                    </a>
                </td>
                <td class="tr_td2">
                    <a target="_blank" href="/cooperations/waitdetail/?{$type}={$coop.Cooperation.id}">
                        {$provincial = $this->City->cityName($coop.Information.provincial)}
                        {$city = $this->City->cityName($coop.Information.city)}
                        {if $provincial == $city}
                            {$provincial}
                        {else}
                            {$provincial} {$city}
                        {/if}
                    </a>
                </td>
                <td class="tr_td5"><a target="_blank" href="/cooperations/waitdetail/?{$type}={$coop.Cooperation.id}">{$status[$coop.Cooperation.status - 1]}</a></td>
                <td class="tr_td5"><a target="_blank" href="/cooperations/waitdetail/?{$type}={$coop.Cooperation.id}">{$coop.Cooperation.created|date_format:"%Y-%m-%d"}</a></td>
                <td class="con_2_xq_tofu xiushan_anniu xiushan_anniu1">
                    <a href="/cooperations/waitdetail/?{$type}={$coop.Cooperation.id}" target="_blank">详情</a>
                    <!--<a href="javascript:void(0)">完成</a>-->
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
                            <option value="10" {if $pageSize == "10"} selected {/if}>10</option>
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
                        <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                    {/if}
                </div>
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'/?type='|cat:$this->request->query['type']]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'/?type='|cat:$this->request->query['type']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}