{assign var=options value=['update' => '#informationList', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}

{if $paginatorParams['count'] > 0}
<table width="100%" cellspacing="0" cellpadding="0" border="0"
    class="con_2_table">
    <thead>
        <tr class="con_2_tr con_2_xq_too">
			<th style="width:75px;" class="tr_td8">{if $type=="need"}卖家{else}买家{/if}</th> 
			<th class="tr_td1">信息标题</th>
			<th style="width:90px;" class="tr_td2">信息价格 </th>
			<th style="width:80px;" class="tr_td7">客源地址</th>
			<th style="width:80px;" class="tr_td5">交易时间 </th>
			<th style="width:70px;" class="tr_td4">状态 </th>                             
        </tr>
    </thead>
        {foreach $informations as $info}
	        <tr class="con_2_tr">
	                  <th><a href="/{$this->request->params['controller']}/detail/{$type}:{$info.PaymentTransaction.information_id}/mid:{$info.Member.id}" target="_blank">{$info.Member.nickname}</a></th> 
	                  <td><a href="/{$this->request->params['controller']}/detail/{$type}:{$info.PaymentTransaction.information_id}/mid:{$info.Member.id}" target="_blank">{$info.Information.title}</a></td>
	                  <td>
    	                  {if $info.PaymentTransaction.payment_type == 1}
                                聚客币：{$info.PaymentTransaction.number}元
                            {else if $info.PaymentTransaction.payment_type == 2}
                                积分：{$info.PaymentTransaction.number}分
                        {/if}
	                  </td>
	                  <td>
	                    {$provincial = $this->City->cityName($info.Information.provincial)}
                        {$city = $this->City->cityName($info.Information.city)}
                        {if $provincial == $city}
                            {$provincial}
                        {else}
                            {$provincial}<br/>{$city}
                        {/if}
	                  </td>
	                  <td>{$info.PaymentTransaction.created|date_format:"%Y-%m-%d"}</td> 
	                  <td>
                        {$status = Configure::read("Transaction.status")}
                        {$status[{$info.PaymentTransaction.status} - 2]}
	                  </td>
	        </tr>
        {/foreach}
</table>
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
                    <div class="dd_ym11"> <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                        <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                        <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
                    </div>
                    {if $paginatorParams['nextPage']}
                        <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                    {/if}
                </div>
{else}	
	<div class="tip">{$msg}。你可以<a href="/informations/search/need">检索悬赏</a><a href="/informations/search/has">检索客源</a><a href="/informations/create/need">发布悬赏</a><a href="/informations/create/has">发布客源</a></div>
{/if}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'?type='|cat:$this->request->query['type'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'?type='|cat:$this->request->query['type']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
