<div class="zy_z">
    <div class="zy_zs">
        <p>
        <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
        <a href="javascript:void(0)">常规招聘</a>&gt;&gt;
        <a href="javascript:void(0)">{$title}</a></p>
    </div>
    <div class="biaotit">{$title}</div>
    <div id="result">
    {$form = ['isForm' => true, 'inline' => true]}
    {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
    {$this->Paginator->options($options)}
    {$paginatorParams = $this->Paginator->params()}
    <form id="searchOpt">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
            <tr class="con_2_tr con_2_xq_too">
                <th width="99">会员名</th>
                <th width="70">应聘岗位</th>
                <th width="62">工作经验</th>
                <th width="104">学历</th>
                <th width="76">现居住地</th>
                <th width="73">接收时间</th>
                <th width="114">选择操作</th>
            </tr>
        </thead>
        {$educated = Configure::read('Fulltime.educated')}
        {foreach $auditions as $audition}
            <tr class="con_2_tr">
                <td><a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">{$audition.ResumeBase.name}</a></td>
                <td><a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">{$audition.Fulltime.post}</a></td>
                <td><a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">{$audition.Resume.continued}年以上</a></td>
                <td>
                <a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">
                {if $audition.Resume.educated !== NULL}
                    {$educated[$audition.Resume.educated]}
                {/if}
                </a>
                </td>
                <td>
                <a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">
                    {$provincial = $this->City->cityName($audition.ResumeBase.provincial_now)}
                    {$city = $this->City->cityName($audition.ResumeBase.city_now)}
                    {if $provincial != $city}
                    {$provincial} {$city}
                    {else}
                    {$provincial}
                    {/if}
                </a>
                </td>        
                <td><a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">{$audition.Audition.created|date_format:"%Y-%m-%d"}</a></td>
                <td class="con_2_xq_tofu xiushan_anniu">
                <a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}" >详情</a>
                <a href="javascript:var a=confirm('删除此信息对方不会收到提示，是否删除？')" >删除</a>
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
    {$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'?type=receive']}
    {$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'?type=receive']}
    {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
    {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
    {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
    {$this->Js->writeBuffer()}
    </div>
</div>
