{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#documents', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
{foreach $documents as $document}
	<dl class="result">
      <dt>
      {$file_info= explode('.', $document.Document.file_name)}
      	<span class="spanFileFormat {$this->Unit->getFileIcon($file_info[1])}">&nbsp;</span>
        <a class="textEllipsis" href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a>
        <span class="clr666">{$document.Document.created|date_format:"%Y-%m-%d"}</span>
      </dt>
      <dd></dd>
      <dd>
          <span class="clr666">贡献者：
          <a target="_blank" href="/resources/listview?mid={$document.Member.id}" >{$document.Member.nickname}</a>
          </span>
          <span class="clr666">|</span>
          <span class="clr666">下载次数：{$document.Document.download_cnt}次</span>
          <span class="clr666">|</span>
          <span class="clr666">共：{$document.Document.pages}页</span>
          <span class="clr666">|</span>
          <span class="clr666">积分：{if $document.Document.point == 0}免费{else}{$document.Document.point}{/if}分</span>
      </dd>
    </dl>
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
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#documents', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}