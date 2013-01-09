{*assign var=options value=['update' => '#informationList', 'evalScripts' => true]*}
{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#informationList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<table width="100%" cellspacing="0" cellpadding="0" border="0"
    class="con_2_table">
      <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="207" class="tr_td1">产品</th>
          <th width="110" class="tr_td2">信息价格</th>
          <th width="76" class="tr_td7">城市</th>
          <th width="56" class="tr_td4">状态</th>
          <th width="61" class="tr_td5">点击次数</th>
          <th width="107" class="tr_td8">选择服务</th>
        </tr>
		</thead>
		<tbody>
        {foreach $informations as $info}
            <tr class="con_2_tr" id="{$info.Information.id}">
                <td class="tr_td1">
	                <a href="javascript:void(0)" >
	                {$this->Category->getCategoryName($info.Information.category)}<br/>
	                {$this->Category->getCategoryName($info.Information.sub_category)}
	                </a>
                </td>
                <td class="tr_td2">
	                <a href="javascript:void(0)" >
	                {if $info.Information.payment_type == 1}
						聚客币：{$info.Information.price}元
					{else if $info.Information.payment_type == 2}
						积分：{$info.Information.point}分
					{else}
						聚客币：{$info.Information.price}元<br/>积分：{$info.Information.point}分
					{/if}
	                </a>
                </td>
                <td class="tr_td7">
	                <a href="javascript:void(0)" >
	                {if $this->City->cityName($info.Information.provincial) == $this->City->cityName($info.Information.city)}
	                {$this->City->cityName($info.Information.provincial)}
	                {else}
	                {$this->City->cityName($info.Information.provincial)}<br/>
	                {$this->City->cityName($info.Information.city)}
	                {/if}
	                </a>
                </td>
                <td class="tr_td4">
	                <a href="javascript:void(0)" >有效</a>
                </td>
                <td class="tr_td5">
	                <a href="javascript:void(0)" >
	                {$info.Information.clicked}
	                </a>
                </td>
                {if $type == "myself"}
                    <td class="con_2_xq_tofu xiushan_anniu"><a href="/informations/detail/{$info.Information.id}">查看</a><a onclick="confirm('确定删除这条信息吗？')" href="#">删除</a></td>
                {else if $type == "has"}
                    <td class="con_2_xq_tofu tofu_anniu"><a href="/informations/payment/{$info.Information.id}">我需要类似服务</a></td>
                {else}
                    <td class="con_2_xq_tofu tofu_anniu"><a href="/informations/create/has/?target={$info.Information.id}&target_member={$info.Information.members_id}">我有该客源 </a></td>
                {/if}               
            </tr>
        {/foreach}        
    </tbody>
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
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$this->request->params['pass'][0], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$this->request->params['pass'][0]]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
{*$this->element('sql_dump')*}