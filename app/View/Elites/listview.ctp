<script type="text/javascript">
{literal}
$(document).ready(function(){
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
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0">兼职管理</a>&gt;&gt;
      <a href="javascript:void(0">信息概览</a>
      </p>
    </div>
    <div class="xxjs partTime" style="overflow-y:visible;min-height:460px;">
      <div class="biaotit">业务精英检索</div>
      <form id="search_conditions">
      <div class="advance_seach">
        <div class="switchBox">
    <ul>
      <li class="lists city"><span class="title">
        <input type="button" value="城市（可选）" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>城市选择器</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">返回省份</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->City->parentCityList() as $city}
                <dd>
                  <label>
                    <input type="checkbox" value="{$city.City.id}" class="inpCheckbox">
                    {$city.City.name}</label>
                </dd>
                {/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
            </dd>
            <dt>您已经选择的城市是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected">
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts">
        </ul>
      </li>
      <li class="lists trade"><span class="title">
        <input type="button" value="行业（可选）" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>行业选择器</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">行业</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->Category->parentCategoryList() as $value}
                <dd>
                  <label>
                    <input type="checkbox" value="{$value.Category.id}" class="inpCheckbox">
                    {$value.Category.name}</label>
                </dd>
                {/foreach}
              </dl>
            </dd>
            <dt>您已经选择的行业是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected">
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts">
        </ul>
      </li>      
      <li class="lists keyword">
        <input type="text" name="keyword" class="inpKeyword" value="请输入关键字" placeholder="请输入关键字" onfocus="this.select()"/>
      </li>
      </ul>
      <div class="clearfix"></div>
      <ul class="ulParttime">
      <li class="lists" style="width:190px;">性别：
              <select name="sex">
                <option value="">不限</option>
                <option value="1">男</option>
                <option value="0">女</option>
              </select>
            </li> 
    </ul>
  </div>
        <a class="zclan zclan4" href="javascript:void(0)" id="searchBtn">查询</a>
    </div>
    <div id="result">
    {$form = ['isForm' => true, 'inline' => true]}
    {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#search_conditions')->serializeForm($form)]}
    {$this->Paginator->options($options)}
    {$paginatorParams = $this->Paginator->params()}
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
                        <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array(1,2))}</div>
                  {/if}
              </div>
        {$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#search_conditions')->serializeForm($form)]}
        {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
        {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
        {$this->Js->writeBuffer()}
    </div>
    </form>
    </div>
</div>