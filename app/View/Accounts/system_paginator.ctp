{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#systemList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#systemOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params('SystemMessage')}
<ul>
{foreach $system_messages as $message}
    <li>
        <p>
            <a href="javascript:void(0)" title="删除" class="close">&nbsp;</a>
            <input type="checkbox" name="" class="inpChk"/>
            <a class="title" href="javascript:void(0)">{$message.SystemMessage.title}</a>
            <span class="time">{$message.SystemMessage.created|date_format:"%Y-%m-%d"}</span>
        </p>
        <div class="znxMesCon">{$message.SystemMessage.content}</div>
    </li>
{/foreach}
</ul>
<div class="pagesMag">
<form id="systemOpt" >
    <div class="fanyea fanyeaFr">
        {if $paginatorParams['prevPage']}
            <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
        {/if}
        <div class="dd_ym">
            <label>每页显示：</label>
            <select name="pageSize" id="syspageSize">
                <option value="10" {if $pageSize == "10"} selected {/if}>10</option>
                <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
            </select>
        </div>
        <div class="dd_ym11">
            <font>共{$paginatorParams['count']}条</font>
            <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
            <input type="text" id="sysjump" name="jump" value="{if isset($jump)}{$jump}{/if}">
            <div class="dd_span1"><a href="javascript:void(0)" id="sysjumpButton">跳转</a></div>
        </div>
        {if $paginatorParams['nextPage']}
            <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
        {/if}
    </div>
    <input type="checkbox" class="inpChk" name="" id="znxConTradeAll"/>
    <label for="znxConTradeAll">全选</label>
    <input type="button" class="inpButton deleMess" name="" value="删除"/>
    <input type="hidden" name="msg_type" value="system" />
    {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
    {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
    {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#systemList', 'method' => 'post', 'data' => $this->Js->get('#systemOpt')->serializeForm($form)]}
    {$this->Js->get('#syspageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
    {$this->Js->get('#sysjumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
    {$this->Js->writeBuffer()}
</form>
</div>