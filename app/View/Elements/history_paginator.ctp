  {assign var=options value=['update' => '#informationList', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}

{if $paginatorParams['count'] > 0}
  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
    <thead>
            <tr class="con_2_tr con_2_xq_too">
              <th style="width:75px;" class="tr_td8">买家</th> 
              <th class="tr_td1">信息标题</th>
              <th style="width:90px;" class="tr_td2">信息价格 </th>
              <th style="width:80px;" class="tr_td7">客源地址</th>
              <th style="width:80px;" class="tr_td5">交易完成</th>                            
              <th class="tr_td8">选择操作</th>            
            </tr>
           </thead>
            <tbody><tr class="con_2_tr">
              <th><a target="_blank" href="hyzl.html">张伟</a></th> 
              <td><a target="_blank" href="new-jycxxq.html">公司标志制作</a></td>
              <td>业务币：100元</td>
              <td>福建省思明区</td>
              <td>2012-08-28 10:27</td> 
              <td class="con_2_xq_tofu xiushan_anniu"><a target="_blank" href="new-jycxxq.html">详情</a><a onclick="alert('双方互评未完成，暂时无法删除。')" href="#">删除</a></td>
            </tr> 
            <tr class="con_2_tr">
              <th><a target="_blank" href="hyzl.html">张伟</a></th> 
              <td><a target="_blank" href="new-jycxxq2.html">公司标志制作</a></td>
              <td>业务币：100元</td>
              <td>福建省思明区</td>
              <td>2012-08-28 10:27</td> 
              <td class="con_2_xq_tofu xiushan_anniu"><a target="_blank" href="new-jycxxq2.html">详情</a><a onclick="confirm('确定删除这条信息吗？')" href="#">删除</a></td>
            </tr> 
            <tr class="con_2_tr">
              <th class="tr_td1"><a target="_blank" href="hyzl.html">张伟</a></th> 
              <td><a target="_blank" href="wdssxq2.html">公司标志制作</a></td>
              <td>业务币：100元</td>
              <td>福建省思明区</td>
              <td>2012-08-28 10:27</td> 
              <td class="con_2_xq_tofu xiushan_anniu"><a target="_blank" href="wdssxq2.html">详情</a><a onclick="alert('双方互评未完成，暂时无法删除。')" href="#">删除</a></td>          
            </tr>           
    </tbody>
</table>
<div class="fanyea">
            <div class="dd_span"><a href="#">上一页</a></div>
            <div class="dd_ym">
              <label>每页显示：</label>
              <select>
                <option>100</option>
                <option>50</option>
                <option>20</option>
                <option>10</option>
              </select>
            </div>
            <div class="dd_ym11"><font>共64388条</font> <font>第1/644页</font>
              <input class="inpTextBox" id="acpro_inp1">
              <div class="dd_span1"><a href="#">跳转</a></div>
            </div>
            <div class="dd_span"><a href="#">下一页</a></div>
              </div>
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