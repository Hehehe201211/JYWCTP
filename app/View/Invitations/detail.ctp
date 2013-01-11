<script type="text/javascript">
{literal}
$(document).ready(function(){
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="qy-ypqq.html">平台兼职</a>&gt;&gt;<a href="#">邀请详情</a></p>
    </div>
     <div class="biaotit">的会员信息</div>
    <div class="xq_zl_xbxq">
      <table width="100%">
        <tr>
          <th width="114" class="tdRight">真实姓名：</th>
          <td width="221"></td>
          <td width="221" rowspan="7" class="top">
            <img class="portrait" src="{$this->webroot}img/tx.jpg" />
            <p>&nbsp;</p>
          </td>
        </tr>
        <tr>
          <th class="tdRight">性别：</th>
          <td></td>
        </tr>
        <tr>
          <th class="tdRight">行业：</th>
          <td></td>
        </tr>  
        <tr>
          <th class="tdRight">联系方式：</th>
          <td></td>
        </tr>
        <tr>
          <th class="tdRight">所在城市：</th>
          <td>福建省厦门市</td>
        </tr>
        <tr>
          <th class="tdRight">联系地址：</th>
          <td>
          </td>
        </tr>  
        <tr>
          <th class="tdRight">业务范围：</th>
          <td></td>
        </tr> 
        <tr>
          <th class="tdRight">与公司合作：</th>
          <td>12次</td>
        </tr> 
        <tr>
          <th class="tdRight">成功合作：</th>
          <td>3次</td>
        </tr>       
      </table>
    </div>
    <div class="biaotit">发布的兼职</div>
    <div id="parttimes" >
{assign var=options value=['update' => '#parttimes', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
      <thead>
        <tr class="con_2_tr con_2_xq_too">          
          <th width="137">兼职标题</th>
          <th width="138">产品或服务</th>
          <th width="87">兼职配合方式</th>
          <th width="79">提成比例</th>  
          <th width="63">发布日期</th>
          <th width="113">选择操作</th>
        </tr>
      </thead>
      {$status = Configure::read('Cooperation.receive_status')}
      {foreach $parttimes as $parttime}
          <tr class="con_2_tr">        
            <td><a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">{$parttime.PartTime.title}</a></td>
            <td>
                <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">
                {$this->Category->getCategoryName($parttime.PartTime.category)} 
                {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
                </a>
            </td>
            <td>
            <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">
            {if $parttime.PartTime.method == 1}
            提供客户信息
            {elseif $parttime.PartTime.method == 2}
            协助跟单
            {else}
            独立签单
            {/if}
            </a>
            </td>
            <td>
            <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">
                {if $parttime.PartTime.pay == 1}
                {$parttime.PartTime.pay_rate}%
                {else}
                协商确定
                {/if}
            </a>
            </td>
            <td><a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">{$parttime.PartTime.created|date_format:"%Y-%m-%d"}</a></td>
            <td class="con_2_xq_tofu xiushan_anniu">
            <a href="/parttimes/detail?id={$parttime.PartTime.id}" target="_blank">详情</a>
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
              <select name="pageSize" id="pageSize">
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
                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
          {/if}
          </div>
      </div>
    <div class="clear">&nbsp;</div>
</div>
{$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#parttimes', 'method' => 'post', 'data' => $this->Js->get('#parttimes')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
