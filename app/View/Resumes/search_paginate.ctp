{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="con_2_table">
    <thead>
        <tr class="con_2_tr con_2_xq_too">
            <th width="100">姓名</th>
            <th width="50">性别</th>
            <th width="105">学历</th>
            <th width="85">期望行业</th>
            <th width="73">期望城市</th>
            <th width="75">岗位</th>
            <th width="80">简历更新时间</th>
            <th width="30">操作</th>
        </tr>
    </thead>
    {$educate = Configure::read('Fulltime.educated')}
    {foreach $resumes as $resume}
    <tr class="con_2_tr">
        <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{$resume.Base.name}</a></td>
        <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{if $resume.Base.sex == 1}男{else}女{/if}</a></td>
        <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{$educate[$resume.Education.educated]}</a></td>
        <td>
        <a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">
          {$categories = explode(',', $resume.Resume.category)}
          {foreach $categories as $id}
            {$this->Category->getCategoryName($id)}
          {/foreach}
        </a>
        </td>
        <td>
        <a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">
          {$cities = explode(',', $resume.Resume.city)}
          {foreach $cities as $id}
            {$this->City->cityName($id)}
          {/foreach}
        </a>
        </td>
        <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{$resume.Resume.nature}</a></td>
        <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{$resume.Resume.modified|date_format:"%Y-%m-%d"}</a></td>
        <td class="btnSingle"><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">查看</a></td>
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
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}