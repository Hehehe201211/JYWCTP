<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.status').live('change', function(){
        $('#informationList').load('/informations/issue?type=' + $('#info_type').val(), $('#informationList').serializeArray(), function(){});
    });
    
    $('.delete').live('click', function(){
        var information_id = $(this).next('.information_id').val();
        $this = $(this);
        if (confirm("你确定要删除此信息吗？")) {
            $.ajax({
                url : '/informations/ajax_delete',
                type : 'post',
                data : 'information_id=' + information_id,
                success : function(data){
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        //location.href = location.href;
                        $this.parent().parent().remove();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
            {if $type == "has"}
                <a href="javascript:void(0)">我有客源</a>&gt;&gt;
                <a href="javascript:void(0)">我的客源</a>
            {else}
                <a href="javascript:void(0)">我要客源</a>&gt;&gt;
                <a href="javascript:void(0)">我的悬赏</a>
            {/if}
        </p>
    </div>
    {if $type=="need"}
        <div class="biaotit">悬赏列表</div>
        <input type="hidden" value="need" id="info_type">
    {else}
        <div class="biaotit">客源列表</div>
        <input type="hidden" value="has" id="info_type">
    {/if}
    <form id="informationList">
        {$form = ['isForm' => true, 'inline' => true]}
        {assign var=options value=['update' => '#informationList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
        {$this->Paginator->options($options)}
        {$paginatorParams = $this->Paginator->params()}
        {if $paginatorParams['count'] > 0}
            <div class="tableSort" style="clear: both;">
                  <label><input type="checkbox" {if in_array(Configure::read('Information.status_code.active'), $status)}checked="checked"{/if} value="{Configure::read('Information.status_code.active')}" name="status[]" class="status">未交易</label>
                  <label><input type="checkbox" {if in_array(Configure::read('Information.status_code.overtime'), $status)}checked="checked"{/if} value="{Configure::read('Information.status_code.overtime')}" name="status[]" class="status">已过期</label>
                  <label><input type="checkbox" {if in_array(Configure::read('Information.status_code.cancel'), $status)}checked="checked"{/if} value="{Configure::read('Information.status_code.cancel')}" name="status[]" class="status">已撤销</label>
            </div>
            <table width="100%" cellspacing="0" cellpadding="0" border="0"
                class="con_2_table">
                <thead>
                    <tr class="con_2_tr con_2_xq_too">
                      <th width="236" class="tr_td1">产品</th>
                      <th width="93" class="tr_td2">{if $type == "need"}悬赏金额{else}信息价格{/if}</th>
                      <th width="68" class="tr_td7">城市</th>
                      <th width="52" class="tr_td4">状态</th>
                      <th width="58" class="tr_td5">点击次数</th>
                      <th width="110" class="tr_td8">选择服务</th>
                    </tr>
                </thead>
                    {foreach $informations as $info}
                        <tr class="con_2_tr">
                            <td class="tr_td1">
                            {$this->Category->getCategoryName($info.Information.category)}
                            {$this->Category->getCategoryName($info.Information.sub_category)}
                            </td>
                            <td class="tr_td2">
                                {if $info.Information.payment_type == 1}
                                        业务币：{$info.Information.price}元
                                    {else if $info.Information.payment_type == 2}
                                        积分：{$info.Information.point}分
                                    {else}
                                        业务币：{$info.Information.price}元<br/>积分：{$info.Information.point}分
                                {/if}
                            </td>
                            <td class="tr_td7">
                            {$provincial = $this->City->cityName($info.Information.provincial)}
                            {$city = $this->City->cityName($info.Information.city)}
                            {if $provincial == $city}
                                {$provincial}
                            {else}
                                {$provincial}<br/>{$city}
                            {/if}
                            </td>
                            <td class="tr_td4">
                                {$status = Configure::read("Information.status")}
                                {$status[{$info.Information.status} - 1]}
                            </td>
                            <td class="tr_td5">{$info.Information.clicked}</td>
                            <td class="con_2_xq_tofu xiushan_anniu xiushan_anniu1">
                                <a href="/informations/detail/{$info.Information.id}" target="_blank">查看</a>
                                <!--<a class="delete" href="javascript:void(0)">删除</a>-->
                                <input type="hidden" class="information_id" name="information_id" value="{$info.Information.id}" />
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
                <div class="dd_ym11"> <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                    <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                    <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
                </div>
                {if $paginatorParams['nextPage']}
                    <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                {/if}
            </div>
        {else}
            <div class="tip">当前列表暂无信息。你可以<a href="/informations/search/need">检索悬赏</a><a href="/informations/search/has">检索客源</a><a href="/informations/create/need">发布悬赏</a><a href="/informations/create/has">发布客源</a></div>
        {/if}
        {$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'/?type='|cat:$this->request->query['type']]}
        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'/?type='|cat:$this->request->query['type']]}
        {$form = ['isForm' => true, 'inline' => true]}
        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#informationList')->serializeForm($form)]}
        {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
        {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
        {$this->Js->writeBuffer()}
    </form>
</div>