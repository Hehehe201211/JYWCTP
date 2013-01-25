{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#informationList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div class="divconMiddle" id="informationList">
  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="hyxzyemian22">
    <thead>
      <tr>
        <th width="129">职位</th>
        <th width="67">工作性质</th>
        <th width="130">工作城市</th>
        <th width="71">招聘人数</th>
        <th width="76">底薪</th>
        <th width="109">发布时间</th>
        <th width="89">投递简历</th>
      </tr>
    </thead>
    {foreach $fulltimes as $fulltime}
    <tr>
      <td>{$fulltime.Fulltime.post}</td>
      <td>{$fulltime.Fulltime.type}</td>
      <td>
        {$provincial = $this->City->cityName($fulltime.Fulltime.provincial)}
        {$city = $this->City->cityName($fulltime.Fulltime.city)}
        {if $provincial != $city}
        {$provincial} {$city}
        {else}
        {$provincial}
        {/if}
      </td>
      <td>{$fulltime.Fulltime.number}人</td>
      <td>{$fulltime.Fulltime.salary}元/月</td>
      <td>{$fulltime.Fulltime.modified|date_format:"%Y-%m-%d"}</td>
      <td class="btnInfoDl"><a href="#" class="btnDeliverR">投递</a></td>
    </tr>
    {/foreach}
  </table>
    <div class="fanyea">
        <div class="dd_ym">
            <form id="searchOpt">
            {if $paginatorParams['prevPage']}
                <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
            {/if}
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
    {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
    {$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
    {$form = ['isForm' => true, 'inline' => true]}
    {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
    {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
    {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
    {$this->Js->writeBuffer()}
</div>