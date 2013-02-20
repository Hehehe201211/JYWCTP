{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#informationList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div id="informationList">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="15%" class="tr_td1">职位</th>
          <th width="27%" class="tr_td2">公司名称</th>
          <th width="13%" class="tr_td3">更新日期</th>
          <th width="19%" class="tr_td4">工作地点</th>
          <th width="13%" class="tr_td5">底薪</th>
          <th width="13%" class="tr_td6">联系方式</th>
        </tr>
        </thead>
    </table>
    {$educated = Configure::read('Fulltime.educated')}
    {$continued = Configure::read('Fulltime.continued')}
    {foreach $fulltimes as $fulltime}
    <table width="100%" cellspacing="0" cellpadding="0" border="1" class="serTable">
        <tbody>
        <tr class="con_2_tr">
        <td width="15%"><a target="_blank" href="/search/odetail?id={$fulltime.Fulltime.id}" style="font-weight: bold;">{$fulltime.Fulltime.post}</a></td>
        <td width="27%"><a target="_blank" href="/search/odetail?id={$fulltime.Fulltime.id}" style="font-weight: bold;">{$fulltime.Fulltime.company}</a></td>
        <td width="13%"><a target="_blank" href="/search/odetail?id={$fulltime.Fulltime.id}" style="font-weight: bold;">{$fulltime.Fulltime.modified|date_format:"%Y-%m-%d"}</a></td>
        <td width="19%">
        <a target="_blank" href="/search/odetail?id={$fulltime.Fulltime.id}" style="font-weight: bold;">
        {$provincial = $this->City->cityName($fulltime.Fulltime.provincial)}
        {$city = $this->City->cityName($fulltime.Fulltime.city)}
        {if $provincial != $city}
            {$provincial} {$city}
        {else}
            {$provincial}
        {/if}
        </a>
        </td>
        <td width="13%"><a target="_blank" href="/search/odetail?id={$fulltime.Fulltime.id}" style="font-weight: bold;">{$fulltime.Fulltime.salary}元/月</a></td>
        <td width="13%"><a target="_blank" href="/search/odetail?id={$fulltime.Fulltime.id}" style="font-weight: bold;"></a></td>
        </tr>
        <tr class="con_2_tr">
        <th class="right">学历要求：</th>
        <td class="left">{$educated[$fulltime.Fulltime.educated]}</td>
        <th class="right">工作经验：</th>
        <td class="left" colspan="2">{$continued[$fulltime.Fulltime.continued]}</td>
        <td><a target="_blank" href="/search/odetail?id={$fulltime.Fulltime.id}" class="detail linkLogin" style="font-weight: bold;">职位详细</a></td>
        </tr>
        <tr class="con_2_tr">
        <th class="right top">职位要求：</th>
        <td class="left" colspan="5">{$fulltime.Fulltime.require}</td>
        </tr>
        </tbody>
    </table>
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
</div>
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
