{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div id="result">
      {assign var=options value=['update' => '#result', 'evalScripts' => true]}
        {$this->Paginator->options($options)}
      {$paginatorParams = $this->Paginator->params()}
      <table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
      <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="179" class="tr_td1">兼职标题</th>          
          <th width="100" class="tr_td3">产品或服务</th>          
          <th width="92" class="tr_td5">兼职配合方式</th>
          <th width="69" class="tr_td4">发布日期</th>
          <th width="60" class="tr_td2">参与人次</th>
          <th width="117" class="tr_td6">选择操作</th>
        </tr>
      </thead>      
      <tbody>
      {$method = Configure::read('Parttime.method')}
      {foreach $parttimes as $parttime}
      <tr class="con_2_tr">
        <td class="tr_td1">
            <a target="_blank" href="/parttimes/detail?id=">{$parttime.PartTime.title}</a>
        </td>
        <td class="tr_td3">
            <a target="_blank" href="/parttimes/detail?id=">
            {$this->Category->getCategoryName($parttime.PartTime.category)} 
            {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
            </a>
        </td>
        <td class="tr_td5">
            <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">{$method[$parttime.PartTime.method - 1]}</a>
        </td>
        <td class="tr_td4">
            <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">{$parttime.PartTime.created|date_format:"%Y-%m-%d"}</a>
        </td>
        <td class="tr_td2">
            <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">{$parttime.PartTime.number}次</a>
        </td>
        <td class="con_2_xq_tofu xiushan_anniu xiushan_anniu1">
            <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">详情</a>
            <!--<a href="javascript:void(0)">删除</a>-->
        </td>
      </tr>
      {/foreach}       
    </tbody>
    </table>
    <div class="fanyea">
        <form id="searchOpt" >
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
                <font>共{$paginatorParams['count']}条</font>
                  <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
            </div>
            {if $paginatorParams['nextPage']}
                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array(1,2))}</div>
            {/if}
          </div>
      </form>
        {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
        {$form = ['isForm' => true, 'inline' => true]}
        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
        {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
        {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
        {$this->Js->writeBuffer()}
</div>