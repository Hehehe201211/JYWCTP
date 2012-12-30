{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<table width="593" cellspacing="0" cellpadding="0" border="0" class="con_2_table" style="margin:0 5px 6px;">
  <thead>
    <tr class="con_2_tr con_2_xq_too">
      <th style="width:75px;" class="tr_td8">简历标题</th>
      <th class="tr_td1">期望从事行业</th>
      <th style="width:90px;" class="tr_td2">期望工作地点 </th>
      <th class="tr_td1">工作性质</th>
      <th style="width:90px;" class="tr_td2">发布时间 </th>
      <th class="tr_td8">选择操作</th>
    </tr>
  </thead>
  {foreach $resumes as $resume}
  <tr class="con_2_tr">
    <th><a target="_blank" href="/resumes/preview?id={$resume.Resume.id}">{$resume.Resume.title}</a></th>
    <td>
        <a target="_blank" href="/resumes/preview?id={$resume.Resume.id}">
        {$categories = explode(',', $resume.Resume.category)}
        {foreach $categories as $id}
            {$this->Category->getCategoryName($id)}
        {/foreach}
        </a>
    </td>
    <td>
    <a target="_blank" href="/resumes/preview?id={$resume.Resume.id}">
    {$cities = explode(',', $resume.Resume.city)}
    {foreach $cities as $id}
        {$this->City->cityName($id)}
    {/foreach}
    </a>
    </td>
    <td>{$resume.Resume.nature}</td>
    <td>{$resume.Resume.created|date_format:"%Y-%m-%d"}</td>
    <td class="con_2_xq_tofu xiushan_anniu">
        <a target="_blank" href="/resumes/preview?id={$resume.Resume.id}">预览</a>
        <a target="_blank" href="/resumes/detail?id={$resume.Resume.id}">详情</a>
    </td>
  </tr>
  {/foreach}
</table>
<div class="fanyea" style="margin:0 5px;">
    {if $paginatorParams['prevPage']}
        <div style="margin-left:30px;" class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
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
        <div style="float:left; margin-left:6px;" class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
    {/if}
</div>
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}