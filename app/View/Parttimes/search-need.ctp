{assign var=options value=['update' => '#result', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div id="result">
  <div class="biaotit">检索结果</div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="con_2_table">
    <thead>
      <tr class="con_2_tr con_2_xq_too">
        <th width="181" class="tr_td1">公司名称</th>
        <th width="100" class="tr_td2">产品或服务</th>
        <th width="92" class="tr_td3">兼职配合方式</th>
        <th width="55" class="tr_td4">提成比例</th>
        <th width="78" class="tr_td5">发布日期</th>
        <th width="91" class="tr_td6">查看详情</th>
      </tr>
    </thead>
  </table>
  {foreach $parttimes as $parttime}
      <table width="100%" border="1" cellspacing="0" cellpadding="0" class="serTable">
        <tr class="con_2_tr">
        <td colspan="2" class="tr_td1">
            <a href="/parttimes/detail?id={$parttime.PartTime.id}" target="_blank">&nbsp;</a>
            <a href="/parttimes/detail?id={$parttime.PartTime.id}" target="_blank">{$parttime.Member.company_name}</a>
        </td>
        <td width="17%" class="tr_td2">
            <a href="/parttimes/detail?id={$parttime.PartTime.id}" target="_blank">{$this->Category->getCategoryName($parttime.PartTime.category)} {$this->Category->getCategoryName($parttime.PartTime.sub_category)}</a>
        </td>
        <td width="15%" class="tr_td3">
            <a href="/parttimes/detail?id={$parttime.PartTime.id}" target="_blank">
            {if $parttime.PartTime.method == 1}
            提供客户信息
            {elseif $parttime.PartTime.method == 2}
            协助跟单
            {else}
            独立签单
            {/if}
            </a>
        </td>
        <td width="10%" class="tr_td4">
            <a href="/parttimes/detail?id={$parttime.PartTime.id}" target="_blank">
            {if $parttime.PartTime.pay == 1}
            {$parttime.PartTime.pay_rate}%
            {else}
            协商确定
            {/if}
            </a>
        </td>
        <td width="13%" class="tr_td5">
            <a href="/parttimes/detail?id={$parttime.PartTime.id}" target="_blank">{$parttime.PartTime.created|date_format:"%Y-%m-%d"}</a>
        </td>
        <td width="15%" class="tr_td6">
            <a class="detail btnDeliverR" href="/parttimes/detail?id={$parttime.PartTime.id}" target="_blank">查看详情</a>
        </td>
        </tr>
        <tr class="con_2_tr">
          <th width="12%" class="right">兼职说明：</th>
          <td colspan="6" class="tr_td2 left">{$parttime.PartTime.additional}</td>
        </tr>
      </table>
  {/foreach}
    <div class="fanyea">
        {if $paginatorParams['prevPage']}
            <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
        {/if}
        <div class="dd_ym">
            <label>每页显示：</label>
            <select>
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
                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array(1,2))}</div>
          {/if}
    </div>
</div>
{$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#result')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}