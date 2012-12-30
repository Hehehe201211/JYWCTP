{assign var=options value=['update' => '#informationList', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}

{if $paginatorParams['count'] > 0}
<table width="596" cellspacing="0" cellpadding="0" border="0"
    class="con_2_table">
    <tbody>
        <tr class="con_2_tr con_2_xq_too">
            <th style="width:75px;" class="tr_td8">{if $info_type == "need"}卖家{else}买家{/if}</th> 
            <th class="tr_td1">信息标题</th>
            <th style="width:90px;" class="tr_td2">信息价格 </th>
            <th style="width:80px;" class="tr_td7">客源地址</th>
            <th style="width:80px;" class="tr_td5">交易完成 </th>
            <th style="width:70px;" class="tr_td4">选择操作 </th>                             
        </tr>
        {foreach $informations as $info}
            <tr class="con_2_tr">
                      <th><a href="/informations/closedetail/?{$info_type}={$info.PaymentHistory.information_id}" target="_blank">{$info.Member.nickname}</a></th> 
                      <td><a style="font-weight: bold;" href="/informations/closedetail/?{$info_type}={$info.PaymentHistory.information_id}" target="_blank">{$info.Information.title}</a></td>
                      <td>
                        {if $info.PaymentHistory.payment_type == 1}
                                聚客币：{$info.PaymentHistory.number}元
                            {else if $info.PaymentHistory.payment_type == 2}
                                积分：{$info.PaymentHistory.number}分
                        {/if}
                      </td>
                      <td>
                          {$provincial = $this->City->cityName($info.Information.provincial)}
                          {$city = $this->City->cityName($info.Information.city)}
                          {if $provincial != $city}
                            {$provincial} {$city}
                          {else}
                            {$provincial}
                          {/if}
                      </td>
                      <td>{$info.PaymentHistory.created|date_format:"%Y-%m-%d"}</td> 
                      <td>
                        {$status = Configure::read("Information.status")}
                        {$status[{$info.Information.status} - 1]}
                      </td>
            </tr>
        {/foreach}
        <tr>
            <td class="fanyea_x" colspan="6">
                <div class="fanyea">
                    {if $paginatorParams['prevPage']}
                        <div style="margin-left:30px;" class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
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
                        <div style="float:left; margin-left:6px;" class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                    {/if}
                </div>
            </td>
        </tr>
    </tbody>
</table>
{else}
    {$msg}
{/if}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$this->request->params['pass'][0], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$this->request->params['pass'][0]]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
