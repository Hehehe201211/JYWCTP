{assign var=options value=['update' => '#informationList', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
{if $paginatorParams['count'] > 0}
<div class="znxConSys">
  <ul>
	{foreach $informations as $info}
		<li>
		<p>
			<a class="trader" href="hyzl.html">{$info.Member.nickname}</a>
			<a target="_blank" href="/complaints/detail?{$complaint_type}={$info.InformationComplaint.id}" class="title titleNo">{$info.Information.title}</a>
			<span class="time">{$info.InformationComplaint.created}</span>
			<span class="result">
			{if $complaint_type == Configure::read('Complaint.ActiveText')}
				{$status = Configure::read('Complaint.status_active')}
			{else}
				{$status = Configure::read('Complaint.status')}
			{/if}
			{$status[$info.InformationComplaint.status - 1]}
			</span>
		</p>
		<div class="znxMesCon">（投诉理由）{$info.InformationComplaint.reason}</div>
		</li>
	{/foreach}
  </ul>
  <div class="fanyea">
		{if $paginatorParams['prevPage']}
			<div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
		{/if}
      <div class="dd_ym">
        <label>每页显示：</label>
        <select>
          <option>100</option>
          <option>50</option>
          <option>20</option>
          <option>10</option>
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
{else}
	<div>&nbsp;{$msg}</div>
{/if}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$this->request->params['pass'][0], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$this->request->params['pass'][0]]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
