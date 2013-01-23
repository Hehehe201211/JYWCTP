<script type="text/javascript">
{literal}
$(document).ready(function(){
    //检索按钮
    $('#search').click(function(){
       var searchOpt = $('#searchOpt').serializeArray();
        $('#result').load('/resumes/search', searchOpt, function(){});
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;
            <a href="qy-jzfbmx.html">常规招聘</a>&gt;&gt;
            <a href="#">简历检索</a>
        </p>
    </div>
    <div class="xxjs partTime" style="overflow-y:visible;min-height:470px;">
        <div class="biaotit">简历检索</div>
        <form id="searchOpt">
        <div class="advance_seach">
            <div class="switchBox">
    <ul>
      <li class="lists city"><span class="title">
        <input type="button" value="工作区域（可选）" class="inpButton">
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
        <input type="button" value="意向行业（可选）" class="inpButton">
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
      </ul>
      <div class="clearfix"></div>
      <ul class="ulParttime">
              <li>性别：
               <select name="sex">
                <option value="">不限</option>
                <option value="1">男</option>
                <option value="0">女</option>
               </select>
              </li>
              <!--
              <li>工作年限：
             <select name="year">
                  <option value="0">不限</option>
                  <option value="1">1年以下</option>
                  <option value="2">1-2年</option>
                  <option value="3">2-3年</option>
                  <option value="4">3年以上</option>
             </select>
              </li>
              -->
              <li>学历要求：
              <select name="educated">
               <option value="0">不限</option>
               <option value="1">小学及以上</option>
               <option value="3">高中/中专及以上</option>
               <option value="5">本科/大专及以上</option>
               <option value="7">研究生及以上</option>
              </select>
              </li>            
              <li>岗位：
               <select name="nature">
                <option value="">不限</option>
                <option value="全职">仅全职</option>
                <option value="兼职">仅兼职</option>
               </select>
              </li> 
              <li style="width:230px;">简历更新时间：
              <select name="modified">
                   <option value="">不限</option>
                   <option value="3">3天</option>
                   <option value="7">一周</option>
                   <option value="14">两周</option>
                   <option value="21">三周</option>
                   <option value="30">一个月及以上</option>                
              </select>
              </li>
          </ul>
  </div>
            <a class="zclan zclan4" href="javascript:void(0)" id="search">查询</a>
        </div>
        <div class="biaotit">检索结果</div>
        <div id="result">
            {$form = ['isForm' => true, 'inline' => true]}
            {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
            {$this->Paginator->options($options)}
            {$paginatorParams = $this->Paginator->params()}
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="con_2_table resumeT">
                <thead>
                    <tr class="con_2_tr con_2_xq_too">
                        <th width="77">姓名</th>
            <th width="30">性别</th>
            <th width="96">学历</th>
            <th width="113">期望行业</th>
            <th width="98">期望城市</th>
            <th width="48">岗位</th>
            <th width="79">简历更新时间</th>
            <th width="55">操作</th>
                    </tr>
                </thead>
                {$educate = Configure::read('Fulltime.educated')}
                {foreach $resumes as $resume}
                <tr class="con_2_tr">
                    <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{$resume.Base.name}</a></td>
                    <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{if $resume.Base.sex == 1}男{else}女{/if}</a></td>
                    <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{$educate[$resume.Education.educated]}</a></td>
                    <td>
                    <a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">
                      {$categories = explode(',', $resume.Resume.category)}
                      {foreach $categories as $id}{$this->Category->getCategoryName($id)},{/foreach}
                    </a>
                    </td>
                    <td>
                    <a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">
                      {$cities = explode(',', $resume.Resume.city)}
					  {foreach $cities as $id}{$this->City->cityName($id)},{/foreach}
                    </a>
                    </td>
                    <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{$resume.Resume.nature}</a></td>
                    <td><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">{$resume.Resume.modified|date_format:"%Y-%m-%d"}</a></td>
                    <td class="btnSingle"><a href="/resumes/detail?id={$resume.Resume.id}" target="_blank">查看</a></td>
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