{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
    <thead>
        <tr class="con_2_tr con_2_xq_too"> 
            <th class="tr_td5">ID </th>
            <th class="tr_td2">金额 </th>
            <th class="tr_td7">时间 </th>
            <th class="tr_td4">状态 </th>
            <th class="tr_td8">选择操作 </th>
        </tr>
    </thead>
    <tbody>
        {foreach $expends as $expend}
            <tr class="con_2_tr">
                <td class="tr_td5 id">{$expend.AlipayExpend.id}</td>
                <td class="tr_td2">{$expend.AlipayExpend.price}元</td>
                <td class="tr_td7">{$expend.AlipayExpend.created|date_format:"%Y-%m-%d"}</td>
                <td class="tr_td4">{$expend.AlipayExpend.status}</td>
                <td class="con_2_xq_tofu tofu_anniu">
                    <a href="javascript:void(0)" class="delete">删除记录</a>
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>
{if $paginatorParams['pageCount'] > 1}
<div class="fanyea">
    <form id="searchOpt">
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
    </form>
</div>
{/if}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}