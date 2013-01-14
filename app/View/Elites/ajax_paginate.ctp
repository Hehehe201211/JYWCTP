<div id="result" >
    {assign var=options value=['update' => '#result', 'evalScripts' => true]}
    {$this->Paginator->options($options)}
    {$paginatorParams = $this->Paginator->params()}
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
      <thead>
        <tr class="con_2_tr con_2_xq_too">          
          <th width="137">客源标题</th>
          <th width="138">兼职标题</th>
          <th width="87">兼职配合方式</th>
          <th width="79">合作时间</th>  
          <th width="63">状态</th>        
          <th width="113">选择操作</th>
        </tr>
      </thead>
      {$status = Configure::read('Cooperation.receive_status')}
      {foreach $cooperations as $cooperation}
          <tr class="con_2_tr">        
            <td><a target="_blank" href="/cooperations/detail">{$cooperation.Information.title}</a></td>
            <td><a target="_blank" href="/cooperations/detail">{$cooperation.PartTime.title}</a></td>
            <td>
            <a target="_blank" href="/cooperations/detail">
            {if $cooperation.PartTime.method == 1}
            提供客户信息
            {elseif $cooperation.PartTime.method == 2}
            协助跟单
            {else}
            独立签单
            {/if}
            </a>
            </td>
            <td><a target="_blank" href="/cooperations/detail">{$cooperation.Cooperation.created}</a></td>
            <td><a target="_blank" href="/cooperations/detail">{$status[$cooperation.Cooperation.status]}</a></td>
            <td class="con_2_xq_tofu xiushan_anniu">
            <a href="/cooperations/detail" target="_blank">详情</a>
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
              <select name="pageSize">
                <option value="2" {if $pageSize == "10"} selected {/if}>10</option>
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
        {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
        {$form = ['isForm' => true, 'inline' => true]}
        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#search_conditions')->serializeForm($form)]}
        {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
        {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
        {$this->Js->writeBuffer()}
  </div>