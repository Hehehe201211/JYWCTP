<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".navMiddle li a:eq(4)").addClass("active");
    $("body").append($(".jsxxxqB"));        
    $(".hyxzyemian22 tbody td").live("click",function(){
    
       var parttime_id = $(this).parent().find('.parttime_id').val();
       $('.jsxxxq').load('/homes/detailParttime', {'id':parttime_id}, function(){
            bgKuang(".jsxxxq",".jsxxxq .closeDiv");
       });        
       /*
        var n=$(".hyxzyemian22 tbody tr").index($(this).parent());
        if ($(this).find(".btnDeliverR").length==1)    bgKuang(".jsxxxqBR:eq("+n+")",".jsxxxqB .closeDiv");
        else bgKuang(".jsxxxqBI:eq("+n+")",".jsxxxqB .closeDiv");
        */
    });
    $(".jsxxxqB .btnDeliverR").live("click",function(){
        var n=$(".jsxxxqB .btnDeliverR").index(this);
        bgKuang(".jsxxxqBR:eq("+n+")",".jsxxxqB .closeDiv",".main .hyxzyemian22");
    });
});
//{/literal}
</script>
<div class="main">
  <div class="left">
    <div class="divnavLeft">
      <div class="navLeft"></div>
    </div>
    <div class="divconLeft"></div>
  </div>
  <div class="middle">
    <div class="navMiddle">
      <ul>
        <li><a class="aleft" href="/homes/index/{$domain}">公司简介</a></li>
        <li><a href="/homes/service/{$domain}">产品或服务</a></li>
        <li><a href="/homes/download/{$domain}">资料下载</a></li>
        <li><a href="/homes/fulltime/{$domain}">招聘岗位</a></li>
        <li><a href="/homes/parttime/{$domain}">兼职需求及政策</a></li>
        <li><a class="aright" href="/homes/contact/{$domain}">联系方式</a></li>
      </ul>
    </div>
    {$form = ['isForm' => true, 'inline' => true]}
    {$options = ['update' => '#informationList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
    {$this->Paginator->options($options)}
    {$paginatorParams = $this->Paginator->params()}
    <div class="divconMiddle" id="informationList">
      <table width="100%" cellspacing="0" cellpadding="0" border="0" class="hyxzyemian22">
        <thead>
          <tr>
            <th width="129">兼职标题</th>
            <th width="177">公司名称</th>
            <th width="78">产品名称</th>
            <th width="116">客户区域范围</th>
            <th width="87">兼职配合方式</th>
            <th width="106">发布时间</th>
            <th width="40">参与</th>
          </tr>
        </thead>
        {foreach $parttimes as $parttime}
        <tr>
          <td>{$parttime.PartTime.title}</td>
          <td>{$title_for_layout}</td>
          <td>{$parttime.PartTime.sub_title}</td>
          <td> {$areas = explode(',', $parttime.PartTime.area)}
            {foreach $areas as $id}
            {$this->City->cityName($id)}
            {/foreach} </td>
          <td> {if $parttime.PartTime.method == 1}提供客户信息
            {elseif $parttime.PartTime.method == 2} 协助跟单
            {else}独立签单
            {/if} </td>
          <td>{$parttime.PartTime.created|date_format:"%Y-%m-%d"}</td>
          <td class="btnInfoDl"><a href="#" class="btnDeliverR">参与</a></td>
          <input type="hidden" class="parttime_id" value="{$parttime.PartTime.id}" />
        </tr>
        {/foreach}
      </table>
      <div class="fanyea">
            <form id="searchOpt">
            <div class="dd_ym">
                {if $paginatorParams['prevPage']}
                    <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
                {/if}
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
            </form>
        </div>
        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'/'|cat:$domain]}
        {$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
        {$form = ['isForm' => true, 'inline' => true]}
        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
        {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
        {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
        {$this->Js->writeBuffer()}
    </div>
  </div>
  <div class="left right">
    <div class="divnavLeft">
      <div class="navLeft navRight"></div>
    </div>
    <div class="divconLeft"> </div>
  </div>
</div>
<div class="jsxxxq jsxxxqB jsxxxqBI">

</div>
