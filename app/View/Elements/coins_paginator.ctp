{assign var=options value=['update' => '#informationList', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}

{if $paginatorParams['count'] > 0}
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
            <tr class="con_2_tr con_2_xq_too">
            {if $this->params['action'] == "expenses"}
              <th width="12%" class="tr_td5">收款方</th>
            {else}
              <th width="12%" class="tr_td5">支出方</th>
            {/if}
              <th width="10%" class="tr_td2">金额 </th>
              <th width="22%" class="tr_td7">时间 </th>
              <th width="10%" class="tr_td4">状态 </th>
              <th width="36%" class="tr_td1">标题</th>
              <th width="10%" class="tr_td8">选择操作 </th>
            </tr>
          </thead>
          {if $this->request->params['action']== "income"}
          	{$payment_type = Configure::read('Payment.payment_type_in')}
          {else}
          	{$payment_type = Configure::read('Payment.payment_type_out')}
          {/if}
          {if $this->request->params['controller'] == "coin"}
          {$unit = "元"}
          {else}
          {$unit = "点"}
          {/if}
        {foreach $informations as $info}
	      <tr class="con_2_tr">
            <td class="tr_td5">{$info.Member.nickname}</td>
            <td class="tr_td2">{$info.PaymentHistory.number}{$unit}</td>
            <td class="tr_td7">{$info.PaymentHistory.created}</td>
            <td class="tr_td4">{$payment_type[$info.PaymentHistory.payment_type - 1]}</td>
            <td class="tr_td1">{$info.Information.title}</td>
            <td class="btnSingle" >
            <a href="javascript:void(0)" class="detail">详细</a>
            <input type="hidden" value="{$info.Member.id}" name="members_id" class="members_id" />
            <input type="hidden" value="{$info.PaymentHistory.information_id}" name="information_id" class="information_id">
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
                        <option value="2" {if $pageSize == "2"} selected {/if}>10</option>
                        <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                        <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                        <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
                        </select>
                    </div>
                    <div class="dd_ym11"> <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                        <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                        <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
                    </div>
                    {if $paginatorParams['nextPage']}
                        <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                    {/if}
                </div>
{else}
	{$msg}
{/if}
{$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
