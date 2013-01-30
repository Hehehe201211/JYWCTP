<script type="text/javascript">
{literal}
$(document).ready(function(){
	$('#btnSearch').click(function(){
		//$('#jump').val('');
		$("#key_word").val($(".searchBar .inpTextBox").val());
		var searchOpt = $('#searchOpt').serializeArray();
		$('#documents').load('/resources/search', searchOpt, function(){});
	});
});
function searchBar(event){
	if (event.keyCode==13) $('#btnSearch').click();
}
{/literal}
</script>
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
    <div class="crumbsNav"><a href="plt-zytd.html">资源天地</a>&nbsp;&gt;&nbsp;搜索结果</div>
    <form id="searchOpt">
    	<div class="searchBar">        
	        <select name="type">
	          <option value="">选择分类</option>
		      <option value="1" {if isset($type) && $type == 1}selected="selected"{/if}>入门成长</option>
		      <option value="2" {if isset($type) && $type == 2}selected="selected"{/if}>培训课件</option>
		      <option value="3" {if isset($type) && $type == 3}selected="selected"{/if}>客户管理</option>
		      <option value="4" {if isset($type) && $type == 4}selected="selected"{/if}>方案模板</option>
		      <option value="5" {if isset($type) && $type == 5}selected="selected"{/if}>总结计划</option>
		      <option value="6" {if isset($type) && $type == 6}selected="selected"{/if}>案例分析</option>
	      	</select>
	        	<input type="text" class="inpTextBox" name="key_word" value="{if isset($key_word)}{$key_word}{/if}" onKeyDown="searchBar(event)"/>        
	        	<a class="btnBar" id="btnSearch" href="javascript:void(0)">搜&nbsp;索</a>
        </div>
    <div class="clear">&nbsp;</div>    
    <div class="corResult" id="documents">
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
	</div>
	</form>
  </div>
    {if !empty($memberInfo)}
  {$this->element('resource/left_logined')}
  {else}
  {$this->element('resource/left')}
  {/if}
</div>