{assign var=options value=['update' => '#commentList', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
{if $paginatorParams['count'] > 0}
	<h3>站内交流</h3>
	{foreach $comments as $comment}
    <div class="comment">
        {if $comment.InformationComment.members_id == $memberInfo.Member.id}
        <div class="name sender">我</div>
        {else}
        <div class="name">{$comment.Member.nickname}</div>	        		
        {/if}
        <div class="time">{$comment.InformationComment.created}</div>
        <div class="content">{$comment.InformationComment.content}</div>
      </div>		
	{/foreach}
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
      <div class="dd_ym11">
	      <font>共{$paginatorParams['count']}条
	      </font>
	      <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页
	      </font>
        <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
        <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
      </div>
      {if $paginatorParams['nextPage']}
            <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
      {/if}
    </div>
{/if}
{if $this->request->params['controller'] == "appeals"}
{$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{else}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$type|cat:':'|cat:$this->request->params['named'][$type]|cat:'/mid:'|cat:$this->request->params['named']['mid'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$type|cat:':'|cat:$this->request->params['named'][$type]|cat:'/mid:'|cat:$this->request->params['named']['mid']]}
{/if}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#commentList', 'method' => 'post', 'data' => $this->Js->get('#commentList')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
