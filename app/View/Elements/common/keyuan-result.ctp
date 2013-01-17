{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#informationList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div id="informationList">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="con_2_table">
    <thead>
        <tr class="con_2_tr con_2_xq_too">
            <th class="tr_td1">发布人</th>
            <th class="tr_td2">产品</th>
            <th class="tr_td3">{if $type == "need"}悬赏金额{else}信息价格{/if}</th>
            <th class="tr_td4">城市</th>
            <th class="tr_td5">点击次数</th>
            <th class="tr_td6">选择服务</th>
        </tr>
    </thead>
    {foreach $informations as $information}
    <tr class="con_2_tr">
        <td class="tr_td1"><a href="/search/infodetail?id={$information.Information.id}">{$information.Member.nickname}</a></td>
        <td class="tr_td2">
            <a href="/search/infodetail?id={$information.Information.id}" >
            {$this->Category->getCategoryName($information.Information.category)} 
            {$this->Category->getCategoryName($information.Information.sub_category)}
            </a>
        </td>
        <td class="tr_td3">
            <a href="/search/infodetail?id={$information.Information.id}">
                {if $information.Information.payment_type == 1}
                    业务币：{$information.Information.price}元
                {else if $information.Information.payment_type == 2}
                    积分：{$information.Information.point}分
                {else}
                    业务币：{$information.Information.price}元<br/>积分：{$information.Information.point}分
                {/if}
            </a>
        </td>
        <td class="tr_td4">
            <a href="/search/infodetail?id={$information.Information.id}">
                {$provincial = $this->City->cityName($information.Information.provincial)} 
                {$city = $this->City->cityName($information.Information.city)}
                {if $provincial != $city}
                {$provincial} {$city}
                {else}
                {$provincial}
                {/if}
            </a>
        </td>
        <td class="tr_td5"><a href="/search/infodetail?id={$information.Information.id}">{$information.Information.clicked}</a></td>
        <td class="con_2_xq_tofu tofu_anniu"><a href="/search/infodetail?id={$information.Information.id}" target="_blank">详情</a></td>
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
                    <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                    <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                    <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
                </div>
                {if $paginatorParams['nextPage']}
                    <div  class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                {/if}
            </div>
</div>
{if isset($this->request->params['named']['fromMenu'])}
    <input type="hidden" value="{$this->request->data['product'][0]}" name="product[]">
    {$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'/fromMenu:true?type='|cat:$type]}
    {$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'/fromMenu:true?type='|cat:$type]}
{else}
    {$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'?type='|cat:$type]}
    {$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'?type='|cat:$type]}
{/if}

{*$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$type, 'setPageSize' => 1]*}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
{*$this->element('sql_dump')*}