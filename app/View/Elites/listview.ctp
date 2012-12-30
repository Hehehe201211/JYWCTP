<script type="text/javascript">
{literal}
$(document).ready(function(){
    //边框
    $(".xxjs .eliteR li").hover(function(){
        if($(this).children("a").length!=0) $(this).css("border-color","#F50");
    },function(){
        $(this).css("border-color","#ccc");
    });
    
    //地图检索
    /*var strPosition;
    $(".toggleMap").toggle(function(){
        $(".divMapCon").show("fast",function(){
           strPosition=new googlemapjsv3({lat:"",lng:"",strCompany:"",pChange:false});
        });
        $(this).text("隐藏地图检索");
    },function(){
        $(".divMapCon").hide("fast");
        $(this).text("打开地图检索");
        strPosition=null;
    });
    $("#codeAddress").click(function(){
        var a=document.getElementById("geostrPosition").value;
        strPosition.codeAddress(a);
    });*/
    $('#searchBtn').click(function(){
        var conditionsArray = $('#search_conditions').serializeArray();
        $('#result').load('/elites/search', conditionsArray, function(){
            
        });
        
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="qy-jzfbmx.html">兼职管理</a>&gt;&gt;<a href="#">信息概览</a></p>
    </div>
    <div class="xxjs partTime" style="overflow-y:visible;min-height:460px;">
      <div class="biaotit">业务精英检索</div>
      <form id="search_conditions">
      <div class="advance_seach">
        <div class="switch_box">
          <div class="divTable divTableCity">
            <div class="divtt">
              <div class="left fl"><strong>城市选择器</strong>(最多可选5项)</div>
              <div class="right fr">[确定]</div>
            </div>
            <dl>
              <dt class="goback"><a href="#">返回省份</a></dt>
              <dl class="options">
                {foreach $this->City->parentCityList() as $city}
                    <dd>
                        <input type="checkbox" class="inpCheckbox" value="{$city.City.id}"/>
                        <a href="#">{$city.City.name}</a>
                    </dd>
                {/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
              <dt>您已经选择的城市是:(点击可以取消选择)</dt>
              <dl class="selected">
              </dl>
            </dl>
            <div class="divtt">
              <div class="right fr">[确定]</div>
            </div>
          </div>
          <div class="divTable divTableTrade">
            <div class="divtt">
              <div class="left fl"><strong>行业选择器</strong>(最多可选5项)</div>
              <div class="right fr">[确定]</div>
            </div>
            <dl>
              <dt class="goback"><a href="#">行业</a></dt>
              <dl class="options">
                {foreach $this->Category->parentCategoryList() as $value}
                    <dd>
                        <input type="checkbox" class="inpCheckbox" value="{$value.Category.id}"/>
                        <a href="#">{$value.Category.name}</a>
                    </dd>
                {/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
              <dt>您已经选择的行业是:(点击可以取消选择)</dt>
              <dl class="selected">
              </dl>
            </dl>
            <div class="divtt">
              <div class="right fr">[确定]</div>
            </div>
          </div>
          <ul>
            <li class="city"><span class="title">
              <input type="button" class="inpButton" value="城市（可选）"/>
              </span>
            </li>
            <li class="trade"><span class="title">
              <input type="button" class="inpButton" value="行业（可选）"/>
              </span>
            </li>
            <li class="keyword">
              <input type="text" name="keyword" class="inpKeyword" value="请输入关键字" placeholder="请输入关键字" onfocus="this.select()"/>
            </li>
          </ul>
          <table width="0" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><ul class="ulTable ulTableCity"></ul></td>
                <td><ul class="ulTable ulTableTrade"></ul></td>
                <td><ul class="ulTable ulTableProduct"></ul></td>
              </tr>
         </table>
          <ul>            
            <li style="width:190px;">性别：
              <select name="sex">
                <option value="">不限</option>
                <option value="1">男</option>
                <option value="0">女</option>
              </select>
            </li>
          </ul>
        </div>
        <!--<div class="divMap">
          <div class="divMapCon">
            <div class="divInput">
              <input type="text" id="geostrPosition" value="输入地址查询"/>
              <input type="button" value="搜索" id="codeAddress"/>
              <input type="hidden" id="comlatlng" />
            </div>
            <div id="mapLayout"></div>
          </div>
        </div>
        <div class="toggleMap">打开地图检索</div>-->
        <a class="zclan zclan4" href="javascript:void(0)" id="searchBtn">查询</a>
    </div>
    </form>
    <div id="result">
    {assign var=options value=['update' => '#result', 'evalScripts' => true]}
    {$this->Paginator->options($options)}
    {$paginatorParams = $this->Paginator->params()}
        <div class="biaotit">检索结果</div>
         <ul class="eliteR">
         {foreach $elites as $elite}
            <li>
                <a href="/elites/detail?id={$elite.Member.id}" target="_blank">
                    <div class="avatar">
                    <img src="{$this->webroot}img/tx.jpg" alt="xxx5202012"/>
                    </div>
                    <div class="name">{$elite.Member.nickname}</div>
                    <div>{$this->Category->getCategoryName($elite.MemberAttribute.category_id)}</div>
                </a>
            </li>
            {/foreach}
          </ul>        
        <div  class="fanyea">
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
                        <div style="float:left; margin-left:6px;" class="dd_span">{$this->Paginator->next('下一页', array(), null, array(1,2))}</div>
                  {/if}
              </div>
        {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
        {$form = ['isForm' => true, 'inline' => true]}
        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#result')->serializeForm($form)]}
        {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
        {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
        {$this->Js->writeBuffer()}
    </div>
    </div>
</div>