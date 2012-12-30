{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}

{$educated = Configure::read('Fulltime.educated')}
{foreach $fulltimes as $fulltime}
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="serTable">
    <tr class="con_2_tr">
        <td width="13%" class="tr_td1"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.post}</a></td>
        <td width="27%" class="tr_td2"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.company}</a></td>
        <td width="13%" class="tr_td3"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.modified|date_format:"%Y-%m-%d"}</a></td>
        <td width="21%" class="tr_td4"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">
        {$provincial = $this->City->cityName($fulltime.Fulltime.provincial)}
        {$city = $this->City->cityName($fulltime.Fulltime.city)}
        {if $provincial != $city}
        {$provincial} {$city}
        {else}
        {$provincial}
        {/if}
        </a></td>
        <td width="13%" class="tr_td6"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$this->Category->getCategoryName($fulltime.Fulltime.category)}</a></td>
        <td width="13%" class="tr_td5"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.salary}元/月</a></td>
        
    </tr>
    <tr class="con_2_tr">
        <th class="right">学历要求：</th>
        <td class="tr_td2 left">
        {if $fulltime.Fulltime.educated == 0}不限
        {else}
        {$educated[$fulltime.Fulltime.educated]}以上
        {/if}
        </td>
        <th class="right">工作经验：</th>
        <td class="tr_td4 left">
        {if $fulltime.Fulltime.continued == "0"} 不限
        {elseif $fulltime.Fulltime.continued == "1"}1年以内
        {elseif $fulltime.Fulltime.continued == "2"}1-2年
        {elseif $fulltime.Fulltime.continued == "3"}2-3年
        {elseif $fulltime.Fulltime.continued == "4"}3年以上
        {/if}
        </td>
        <td class="tr_td4">&nbsp;</td>
        <td class="tr_td6"><a class="detail btnDeliverR" href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">职位详情</a></td>
    </tr>
    <tr class="con_2_tr">
        <th class="right top">职位要求：</th>
        <td colspan="5" class="left">{$fulltime.Fulltime.require}</td>
    </tr>
</table>
{/foreach}
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
                <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
            </div>
            {if $paginatorParams['nextPage']}
                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
            {/if}
        </div>
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}