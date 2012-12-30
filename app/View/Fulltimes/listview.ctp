<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="qy-cgzwgl.html">常规招聘</a>&gt;&gt;<a href="#">职位管理</a></p>
    </div>
    <div class="biaotit">职位管理</div>
    <div id="result">
    <form id="searchOpt">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
      <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="120">职位</th>
          <th width="56">工作性质</th>
          <th width="80">招聘人数</th>
          <th width="76">底薪</th>
          <th width="67">工作区域</th>
          <th width="85">更新日期</th>
          <th width="114">选择操作</th>
        </tr>
      </thead>
      <tbody>
        {$form = ['isForm' => true, 'inline' => true]}
        {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
        {$this->Paginator->options($options)}
        {$paginatorParams = $this->Paginator->params()}
      {foreach $fulltimes as $fulltime}
      <tr class="con_2_tr">
        <td><a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">{$fulltime.Fulltime.post}</a></td>
        <td><a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">{$fulltime.Fulltime.type}</a></td>
        <td><a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">{$fulltime.Fulltime.number}人</a></td>
        <td><a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">{$fulltime.Fulltime.salary}元/月</a></td>
        <td>
        <a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">
            {$provincial = $this->City->cityName($fulltime.Fulltime.provincial)}
            {$city = $this->City->cityName($fulltime.Fulltime.city)}
            {if $provincial != $city}
            {$provincial} {$city}
            {else}
            {$provincial}
            {/if}
        </a>
        </td>
        <td>
        <a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">
        {$fulltime.Fulltime.modified|date_format:"%Y-%m-%d"}
        </a>
        </td>
        <td class="con_2_xq_tofu xiushan_anniu">
        <a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}" style="font-weight: normal;">详情</a>
        <a href="javascript:void(0)" style="font-weight: normal;">删除</a>
        </td>
      </tr>
      {/foreach}        
    </tbody>
    </table>
    <div class="fanyea">
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
    </form>
    {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
    {$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
    {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
    {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
    {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
    {$this->Js->writeBuffer()}
    </div>
</div>