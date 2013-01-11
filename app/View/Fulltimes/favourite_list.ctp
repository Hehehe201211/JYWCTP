<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="new-wwtj.html">兼职管理</a>&gt;&gt;<a href="#">职位收藏夹</a></p>
    </div>
    <div class="biaotit">职位收藏夹</div>
    <div id="result">
        {$form = ['isForm' => true, 'inline' => true]}
        {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
        {$this->Paginator->options($options)}
        {$paginatorParams = $this->Paginator->params()}
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="conTable3">
            <thead>
                <tr class="con_2_tr con_2_xq_too">
                    <th class="tr_td1">公司名称</th>
                    <th class="tr_td2">职位</th>
                    <th class="tr_td3">工作性质</th>
                    <th class="tr_td4">工作地点</th>
                    <th class="tr_td5">发布时间</th>
                    <th class="tr_td6">选择操作</th>
                </tr>
            </thead>
            {foreach $favourites as $favo}
            <tr class="con_2_tr">
                <td class="tr_td1"><a href="/fulltimes/detail?id={$favo.Fulltime.id}" target="_blank">{$favo.Fulltime.company}</a></td>
                <td class="tr_td2"><a href="/fulltimes/detail?id={$favo.Fulltime.id}" target="_blank">{$favo.Fulltime.post}</a></td>
                <td class="tr_td3"><a href="/fulltimes/detail?id={$favo.Fulltime.id}" target="_blank">{$favo.Fulltime.type}</a></td>
                <td class="tr_td4">
                <a href="/fulltimes/detail?id={$favo.Fulltime.id}" target="_blank">
                    {$provincial = $this->City->cityName($favo.Fulltime.provincial)}
                    {$city = $this->City->cityName($favo.Fulltime.city)}
                    {if $provincial != $city}
                    {$provincial} {$city}
                    {else}
                    {$provincial}
                    {/if}
                </a>
                </td>
                <td class="tr_td5"><a href="/fulltimes/detail?id={$favo.Fulltime.id}" target="_blank">{$favo.FulltimeFavourite.created|date_format:"%Y-%m-%d"}</a></td>
                <td class="con_2_xq_tofu xiushan_anniu">
                <a target="_blank" href="/fulltimes/detail?id={$favo.Fulltime.id}">详情</a>
                </td>
            </tr>
            {/foreach}             
        </table>
        <form id="searchOpt">
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
                </form>
    </div>
</div>
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}