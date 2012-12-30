<script type="text/javascript">
{literal}
$(document).ready(function(){
    //检索按钮
    $('#search').click(function(){
       var searchOpt = $('#searchOpt').serializeArray();
        $('#result').load('/fulltimes/search', searchOpt, function(){});
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="new-hyzy.html">我的聚业务</a>&gt;&gt;
            <a href="new-wwtj.html">兼职管理</a>&gt;&gt;
            <a href="#">我要工作</a>
        </p>
    </div>
    <div class="xxjs partTime" style="overflow-y:visible;min-height:460px;">
        <div class="biaotit">我要工作</div>
        <form id="searchOpt">
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
                        <dt>您已经选择的城市是:(点击可以取消选择)</dt>
                        <dl class="selected">
                        </dl>
                    </dl>
                    <div class="divtt">
                        <div class="right fr">[确定]</div>
                    </div>
                </div>
                <ul>
                    <li class="city">
                        <span class="title"><input type="button" class="inpButton" value="工作区域（可选）"/></span>
                    </li>
                    <li class="trade">
                        <span class="title"><input type="button" class="inpButton" value="意向行业（可选）"/></span>
                    </li>
                </ul>
                <table width="0" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><ul class="ulTable ulTableCity"></ul></td>
                        <td><ul class="ulTable ulTableTrade"></ul></td>
                    </tr>
                </table>
                <ul class="ulParttime">
                    <li>经验要求：
                        <select name="continued">
                            <option value="">不限</option>
                            <option value="0-1">1年以下</option>
                            <option value="1-2">1-2年</option>
                            <option value="2-3">2-3年</option>
                            <option value="4-">3年以上</option>
                        </select>
                    </li>
                    <li>学历要求：
                        <select name="educated">
                            <option value="">不限</option>
                            <option value="1">小学及以上</option>
                            <option value="3">高中/中专及以上</option>
                            <option value="5">本科/大专及以上</option>
                            <option value="7">研究生及以上</option>
                        </select>
                    </li>
                    <li>薪资：
                        <select name="salary">
                            <option value="">不限</option>
                            <option value="0-1000">1000元/月以下</option>
                            <option value="1000-2000">1000-2000元/月</option>
                            <option value="2000-3000">2000-3000元/月</option>
                            <option value="3000-4000">3000-4000元/月</option>
                            <option value="4000-">4000元/月以上</option>
                        </select>
                    </li>
                    <li>工作性质：
                        <select name="type">
                        <option value="">不限</option>
                        <option value="全职">全职</option>
                        <option value="兼职">兼职</option>
                        </select>
                    </li>
                    <li>更新日期：
                        <select name="created">
                            <option value="">不限</option>
                            <option value="0">当日</option>
                            <option value="3">3天</option>
                            <option value="7">一周</option>
                            <option value="14">两周</option>
                            <option value="30">一个月及以上</option>
                        </select>
                    </li>
                </ul>
            </div>
            <a class="zclan zclan4" href="javascript:void(0)" id="search">查询</a>
        </div>
        
        <div class="biaotit">检索结果</div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="con_2_table">
            <thead>
            <tr class="con_2_tr con_2_xq_too">
                <th width="74" class="tr_td1">职位</th>
                <th width="161" class="tr_td2">公司名称</th>
                <th width="77" class="tr_td3">更新日期</th>
                <th width="121" class="tr_td4">工作地点</th>
                <th width="73" class="tr_td5">工作行业</th>
                <th width="91" class="tr_td6">底薪</th>
            </tr>
            </thead>
        </table>
        <div id="result">
            {$form = ['isForm' => true, 'inline' => true]}
            {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
            {$this->Paginator->options($options)}
            {$paginatorParams = $this->Paginator->params()}
            {$educated = Configure::read('Fulltime.educated')}
            {foreach $fulltimes as $fulltime}
            <table width="100%" border="1" cellspacing="0" cellpadding="0" class="serTable">
                <tr class="con_2_tr">
                    <td width="13%" class="tr_td1"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.post}</a></td>
                    <td width="27%" class="tr_td2"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.company}</a></td>
                    <td width="13%" class="tr_td3"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.modified|date_format:"%Y-%m-%d"}</a></td>
                    <td width="21%" class="tr_td4"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">
                    {$provincial = $this->City->cityName($fulltime.Fulltime.provincial)}
                    {$city = $this->City->cityName($fulltime.Fulltime.city)}
                    {if $provincial != $city}
                    {$provincial} {$city}
                    {else}
                    {$provincial}
                    {/if}
                    </a></td>
                    <td width="13%" class="tr_td6"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$this->Category->getCategoryName($fulltime.Fulltime.category)}</a></td>
                    <td width="13%" class="tr_td5"><a href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">{$fulltime.Fulltime.salary}元/月</a></td>
                    
                </tr>
                <tr class="con_2_tr">
                    <th class="right">学历要求：</th>
                    <td class="tr_td2 left">
                    {if $fulltime.Fulltime.educated == 0}不限
                    {else}
                    {$educated[$fulltime.Fulltime.educated]}以上
                    {/if}
                    </td>
                    <th class="right">工作经验：</th>
                    <td class="tr_td4 left">
                    {if $fulltime.Fulltime.continued == "0"} 不限
                    {elseif $fulltime.Fulltime.continued == "1"}1年以内
                    {elseif $fulltime.Fulltime.continued == "2"}1-2年
                    {elseif $fulltime.Fulltime.continued == "3"}2-3年
                    {elseif $fulltime.Fulltime.continued == "4"}3年以上
                    {/if}
                    </td>
                    <td class="tr_td4">&nbsp;</td>
                    <td class="tr_td6"><a class="detail btnDeliverR" href="/fulltimes/detail?id={$fulltime.Fulltime.id}" target="_blank">职位详情</a></td>
                </tr>
                <tr class="con_2_tr">
                    <th class="right top">职位要求：</th>
                    <td colspan="5" class="left">{$fulltime.Fulltime.require}</td>
                </tr>
            </table>
            {/foreach}
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
