{assign var=options value=['update' => '#informationList', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
{if $paginatorParams['count'] > 0}
<div class="znxConSys">
  <ul>
	{foreach $appeals as $info}
		<li>
		<p>
			<a class="trader" href="javascript:void(0)">{$info.Member.nickname}</a>
			<a target="_blank" href="/appeals/detail/id:{$info.Appeal.id}" class="title titleNo">{$info.Information.title}</a>
			<span class="time">{$info.Appeal.created}</span>
		</p>
		<div class="znxMesCon">{$info.Appeal.content}</div>
		</li>
	{/foreach}
  </ul>
  <div class="pagesMag">
    <div class="fanye">
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
  </div>
</div>
{else}
	<div>&nbsp;{$msg}</div>
{/if}
{$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
