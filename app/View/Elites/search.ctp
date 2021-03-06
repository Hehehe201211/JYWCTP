{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#search_conditions')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div id="result">
        <div class="biaotit">检索结果</div>
         <ul class="eliteR">
            {$dataPath = Configure::read('Data.path')}
            {foreach $elites as $elite}
                <li>
                    <a href="/elites/detail?id={$elite.Member.id}" target="_blank">
                        <div class="avatar">
                        {if !empty($elite.MemberAttribute.thumbnail)}
                            {$thumbnail = $dataPath|cat:$elite.MemberAttribute.thumbnail}
                            {if file_exists($thumbnail)}
                                <img src="{$this->webroot}{$elite.MemberAttribute.thumbnail}" alt="{$elite.Member.nickname}">
                            {else}
                                <img src="{$this->webroot}img/tx.jpg" alt="{$elite.Member.nickname}"/>
                            {/if}
                        {else}
                            <img src="{$this->webroot}img/tx.jpg" alt="{$elite.Member.nickname}"/>
                        {/if}
                        </div>
                        <div class="name">{$elite.Member.nickname}</div>
                        <div>{$this->Category->getCategoryName($elite.MemberAttribute.category_id)}</div>
                    </a>
                </li>
            {/foreach}
          </ul>
        </div>
        <div  class="fanyea">
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
                        <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                  {/if}
              </div>
</div>
{$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#search_conditions')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}