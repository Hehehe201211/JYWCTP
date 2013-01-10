<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.inpButton').click(function(){
        var keyword = $('#keyword').val();
        $('#result').load('/notices/listview', {'keyword':keyword}, function(){});
    });
});
{/literal}
</script>

<div class="main">
  <div class="ntcLeft">
    <div class="suckerdiv">
      <h3>通知中心</h3>
      {foreach $noticeParents as $parent}
      <div class="category">
        <a href="javascript:void(0);" class="catHx"></a>
        <p><a href="/notices/listview?pid={$parent.Notice.id}">{$parent.Notice.title}</a></p>
      </div>
      {/foreach}
    </div>
    <div class="otherLinks">
      <ul>
        <li><a href="pltS-index.html">新手入门</a></li>
        <li><a href="pltS-index.html">交易机制</a></li>
        <li><a href="pltS-index.html">支付方式</a></li>
        <li><a href="pltS-index.html">客户服务</a></li>
        <li><a href="pltS-index.html">帮助信息</a></li>
      </ul>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="ntcRight">    
    <div class="searchBox">
      <p class="tip">请简单完整的输入您的问题，如“如何找回密码”</p>
      <form method="post" id="noticeForm">
      <input type="text" placeholder="请输入您的问题" class="inpTextBox" id="keyword" name="keyword">
      <input type="button" class="inpButton" value="搜 索">
    </form>         
    </div>
    <div class="corContent" id="result">
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
      </div>
  </div>
  <div class="clear">&nbsp;</div>
  
</div>