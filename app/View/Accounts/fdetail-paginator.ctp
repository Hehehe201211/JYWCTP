<div class="infoComments">
{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
{foreach $messages as $message}
   <div class="comment">
              {if $message.StationMessage.sender == $memberInfo.Member.id}
                    <div class="name sender">我</div>                    
              {else}
                    <div class="name">{$message.Member.nickname}</div>
              {/if}        
              <div class="time">{$message.StationMessage.created|date_format:"%Y-%m-%d"}</div>
              <div class="content">{$message.StationMessage.content}</div>
      </div>  
{/foreach}
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
        <font>共{$paginatorParams['count']}条</font>
        <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
        <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
        <div class="dd_span1"><a href="javascript:void(0)" id="jumpButton">跳转</a></div>
    </div>
    {if $paginatorParams['nextPage']}
        <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
    {/if}
  </div>
  </form>
{$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
</div>