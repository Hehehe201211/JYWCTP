<div class="main">
    <div id="loginWarning">
        <div class="area">
            <div class="notice">您输入的密码和账户名不匹配，请重新输入。</div>
            <ul class="question">
            </ul>
        </div>
        <div class="arrow"></div>
    </div>
  <div class="conResource">
    <div class="crumbsNav"><a href="plt-zytd.html">资源天地</a>&nbsp;&gt;&nbsp;（上传人的昵称）</div>
    <div id="documents">
{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#documents', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}  
    <div class="divResource" style="float:none;width:auto;">
      <h2><div class="catalog"><a href="javascript:;">全部</a><a href="javascript:;">入门成长</a><a href="javascript:;">培训课件</a><a href="javascript:;">客户管理</a><a href="javascript:;">方案模板</a><a href="javascript:;">总结计划</a><a href="javascript:;">案例分析</a></div>（上传人的昵称）- 目录</h2>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
      	{foreach $documents as $key => $document}
	        {if $key%2 == 0}
	        <tr>
	        	<td class="title"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></td>
	          	<td class="pages">{$document.Document.pages}页</td>
	          	<td class="fraction"><span>{if $document.Document.point == 0}免费{else}{$document.Document.point}分{/if}</span></td>
	        {else}
	          	<td class="title"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></td>
	          	<td class="pages">{$document.Document.pages}页</td>
	          	<td class="fraction"><span>{if $document.Document.point == 0}免费{else}{$document.Document.point}分{/if}</span></td>
	        </tr>
	        {/if}
        {/foreach}
        {if $key%2 == 0}
        	</tr>
        {/if}
      </table>      
    </div>
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
{if isset($this->request->query['mid'])}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'?mid='|cat:$this->request->query['mid']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'?mid='|cat:$this->request->query['mid']]}
{else}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
{/if}

{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#documents', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
	</div>
  </div>
  {if !empty($memberInfo)}
  {$this->element('resource/left_logined')}
  {else}
  {$this->element('resource/left')}
  {/if}
</div>