{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
      <div class="crumbs">
      </div>
      <div class="serviceCon">
      <ul class="titleLists">
      {foreach $notices as $notice}
        <li>
            <span class="fr time">{$notice.Notice.modified|date_format:"%Y-%m-%d"}</span>
            <p><a target="_blank" href="/notices/detail?id={$notice.Notice.id}">{$notice.Notice.title}</a></p>
        </li>
      {/foreach}
      </ul>
      </div>
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
{if isset($this->request->query['pid']) && !empty($this->request->query['pid'])}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:"?pid="|cat:$this->request->query['pid']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:"?pid="|cat:$this->request->query['pid']]}
{else}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
{/if}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
