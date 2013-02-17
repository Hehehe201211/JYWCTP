<table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
        <thead>
            <tr class="con_2_tr con_2_xq_too">
                <th class="tr_td1">公司名称</th>
                <th class="tr_td2">职位</th>
                <th class="tr_td2">工作性质</th>
                <th class="tr_td3">薪资</th>
                <th class="tr_td4">工作地点</th>
                <th class="tr_td5">投递时间</th>
                <th class="tr_td6">选择操作</th>
            </tr>
        </thead>
        {$form = ['isForm' => true, 'inline' => true]}
        {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
        {$this->Paginator->options($options)}
        {$paginatorParams = $this->Paginator->params()}
    
        {foreach $auditions as $audition}
            <tr class="con_2_tr">
                <td class="tr_td1{if $audition.Audition.send_readed == 0} new{/if}"><a target="_blank" href="/auditions/detail?type=send&id={$audition.Audition.id}">{$audition.Member.company_name}</a></td>
                <td class="tr_td2"><a target="_blank" href="/auditions/detail?type=send&id={$audition.Audition.id}">{$audition.Fulltime.post}</a></td>
                <td class="tr_td2"><a target="_blank" href="/auditions/detail?type=send&id={$audition.Audition.id}">{$audition.Fulltime.type}</a></td>
                <td class="tr_td3"><a target="_blank" href="/auditions/detail?type=send&id={$audition.Audition.id}">{$audition.Fulltime.salary}元/月</a></td>
                <td class="tr_td4">
                <a target="_blank" href="/auditions/detail?type=send&id={$audition.Audition.id}">
                    {$provincial = $this->City->cityName($audition.Fulltime.provincial)}
                    {$city = $this->City->cityName($audition.Fulltime.city)}
                    {if $provincial != $city}
                    {$provincial} {$city}
                    {else}
                    {$provincial}
                    {/if}
                </a>
                </td>
                <td class="tr_td5"><a target="_blank" href="/auditions/detail?type=send&id={$audition.Audition.id}">{$audition.Audition.created|date_format:"%Y-%m-%d"}</a></td>
                <td class="con_2_xq_tofu xiushan_anniu">
                <a href="/auditions/detail?type=send&id={$audition.Audition.id}" target="_blank">详情</a>
                <a href="javascript:void(0)" >删除</a>
                </td>
            </tr>
        {/foreach}        
</table>
<form id="searchOpt">
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
            </form>
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'?type=send']}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'?type=send']}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}