<script type="text/javascript">
$(document).ready(function(){
    $(".znxTitle li").click(function(e){
        e.preventDefault();
        var tabIndex=$(".znxTitle li").index(this);
        tabSwitching(tabIndex,".znxTitle li",".znxContent>div","active");
    });
    $(".znxConSys .title,.znxConFri .title").live('click', function(e){
        if($(this).hasClass("titleH")) {
            e.preventDefault();
            $(this).removeClass("titleH");
            $(this).parent("p").next(".znxMesCon").hide();
        } else {
            e.preventDefault();
            $(this).addClass("titleH");
            $(this).parent("p").next(".znxMesCon").show();
        }
    });
    
    $(".close").live('click', function(e){
        if (confirm("是否删除该信息？")) {
            var id = $(this).parent().find('.msg_id').val();
            $this = $(this);
            $.ajax({
                url : '/sms/deleteMsg',
                type : 'post',
                data : 'id=' + id,
                success : function(data) {
                    var result = eval("("+data+")");
                    if (result.result == "OK") {
                        $this.parents(".znxContent ul li").hide("fast",function(){
                            $this.parents(".znxContent ul li").remove();
                        });
                        alert(result.msg);
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
    
    //agree
    $('.agree').live('click', function(e){
        if (confirm("确定同意添加对方为好友？")) {
            var id = $(this).parent().parent().find('.msg_id').val();
            $this = $(this);
            $.ajax({
                url : '/sms/agree',
                type : 'post',
                data : 'id=' + id,
                success : function(data) {
                    var result = eval("("+data+")");
                    if (result.result == "OK") {
                        $this.remove();
                        alert(result.msg);
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
    
    
    $("#znxConSysAll,#znxConFriAll,#znxConTradeAll").live('click', function(){
        var a=$(this).parent("div").parent("div").find(".inpChk")
        a.attr("checked",this.checked);
    });
    /*
    $(".deleMess").click(function(){
        var chkBox=$(this).parent("div").parent("div").find(".inpChk");
        var n=chkBox.length-1;
        var j=0;
        for (i=0;i<n;i++) {
            if (chkBox.eq(i).attr("checked")) j+=1;
        }
        if (j==0) alert("你未选择任何信息。");
        else var b=confirm("确定删除这"+j+"条信息吗？");
        if (b) {
            for (i=0;i<n;i++) {
                if (chkBox.eq(i).attr("checked")) chkBox.eq(i).parent("p").parent("li").remove();
                } 
        }
    });
    */
    $(".deleteSelectSmg").live('click', function(){
        var chkBox = $(this).parent("div").parent("div").find(".checkboxVal");
        var ids = [];
        chkBox.each(function(e){
            if($(this).attr("checked")) {
                ids.push($(this).val());
            }
        });
        if (ids.length == 0) {
            alert("你未选择任何信息。");
        } else {
            if (confirm('你真的要删除所选信息吗？')) {
                $.ajax({
                    url : '/sms/deleteMsg',
                    type : 'post',
                    data : 'id=' + ids,
                    success : function(data) {
                        var result = eval("("+data+")");
                        if (result.result == "OK") {
                            alert(result.msg);
                            $('#msgList').load('/accounts/sms', $('#msgOpt').serializeArray(), function(){});
                        } else {
                            alert(result.msg);
                        }
                    }
                });
            }
        }
    });


    
});
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
          <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
          <a href="javascript:void(0)">信息管理</a>&gt;&gt;
          <a href="javascript:void(0)">站内信</a>
      </p>
      <div class="zy_zszl">
      </div>
    </div>
    <div class="znx">
        <ul class="znxTitle">
            <li class="active"><a href="#">系统信息</a></li>
            <li><a href="#">好友信息</a></li>
        </ul>
        <div class="znxContent">
            <div class="znxConSys" id="systemList">
            {$form = ['isForm' => true, 'inline' => true]}
            {$options = ['update' => '#systemList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#systemOpt')->serializeForm($form)]}
            {$this->Paginator->options($options)}
            {$paginatorParams = $this->Paginator->params('SystemMessage')}
                <ul>
                {foreach $system_messages as $message}
                    <li>
                        <p>
                            <a href="javascript:void(0)" title="删除" class="close">&nbsp;</a>
                            <input type="checkbox" name="" class="inpChk"/>
                            <a class="title" href="javascript:void(0)">{$message.SystemMessage.title}</a>
                            <span class="time">{$message.SystemMessage.created|date_format:"%Y-%m-%d"}</span>
                        </p>
                        <div class="znxMesCon">{$message.SystemMessage.content}</div>
                    </li>
                {/foreach}
                </ul>
                <div class="pagesMag">
                    <form id="systemOpt" >
                    <div class="fanyea fanyeaFr">
                            {if $paginatorParams['prevPage']}
                                <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
                            {/if}
                            <div class="dd_ym">
                                <label>每页显示：</label>
                                <select name="pageSize" id="syspageSize">
                                    <option value="10" {if $pageSize == "10"} selected {/if}>10</option>
                                    <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                                    <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                                    <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
                                </select>
                            </div>
                            <div class="dd_ym11">
                                <font>共{$paginatorParams['count']}条</font>
                                <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                                <input type="text" id="sysjump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                                <div class="dd_span1"><a href="javascript:void(0)" id="sysjumpButton">跳转</a></div>
                            </div>
                            {if $paginatorParams['nextPage']}
                                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                            {/if}
                        </div>
                    <input type="checkbox" class="inpChk" name="" id="znxConTradeAll"/>
                    <label for="znxConTradeAll">全选</label>
                    <input type="button" class="inpButton deleMess" name="" value="删除"/>
                        <input type="hidden" name="msg_type" value="system" />
                        {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
                        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
                        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#systemList', 'method' => 'post', 'data' => $this->Js->get('#systemOpt')->serializeForm($form)]}
                        {$this->Js->get('#syspageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
                        {$this->Js->get('#sysjumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
                        {$this->Js->writeBuffer()}
                    </form>
                </div>
            </div>
            <div class="znxConFri" style="display:none;" id="msgList">
            {$form = ['isForm' => true, 'inline' => true]}
            {$options = ['update' => '#msgList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#msgOpt')->serializeForm($form)]}
            {$this->Paginator->options($options)}
            {$paginatorParams = $this->Paginator->params('StationMessage')}
            {if $paginatorParams['count'] > 0}
                <ul>
                    {foreach $messages as $message}
                        {if $message.StationMessage.type == Configure::read('Sms.normal')}
                        <li>
                            <p>
                                <a class="close delete" title="删除" href="javascript:void(0)">&nbsp;</a>
                                <input type="checkbox" class="inpChk inpCheckbox checkboxVal" name="" value="{$message.StationMessage.id}">
                                <a class="trader" href="/accounts/fdetail?fid={$message.Member.id}">{$message.Member.nickname}</a>
                                <a target="_blank" href="#" class="title">发来信息。</a>
                                <span class="time">{$message.StationMessage.title}</span>
                                <span class="time">[{$message.StationMessage.created|date_format:"%Y-%m-%d %H:%M:%S"}]</span>
                                <input class="msg_id" type="hidden" value="{$message.StationMessage.id}" />                                
                            </p>
                            <div class="znxMesCon">
                                {$message.StationMessage.content}
                                <input type="button" onclick="window.open('/accounts/fdetail?fid={$message.Member.id}','_blank');" value="回复" name="" class="inpButton">
                            </div>
                        </li>
                        {elseif $message.StationMessage.type == Configure::read('Sms.friendRequest')}
                            <li>
                                <p>
                                    <a href="javascript:void(0)" title="删除" class="close delete">&nbsp;</a>
                                    <input type="checkbox" name="" class="inpChk checkboxVal" value="{$message.StationMessage.id}"/>
                                    <a href="hyzl.html" class="trader">{$message.Member.nickname}</a>
                                    <a class="title" href="#" target="_blank">请求添加你为好友。</a>
                                    <span class="time">[{$message.StationMessage.created|date_format:"%Y-%m-%d %H:%M:%S"}]</span>
                                    <input class="msg_id" type="hidden" value="{$message.StationMessage.id}" />                                    
                                </p>
                                <div class="znxMesCon"><input class="inpButton agree" type="button" value="同意" />
                                    注册时间：[{$message.Member.created|date_format:"%Y-%m-%d %H:%M:%S"}]
                                    <br/>所在城市：
                                    {$provincial = $this->City->cityName($message.Attribute.provincial_id)}
                                    {$city = $this->City->cityName($message.Attribute.city_id)}
                                    {if $provincial == $city}
                                        {$provincial}
                                    {else}
                                        {$provincial} {$city}
                                    {/if}
                                    <br/>行业：
                                    {$this->Category->getCategoryName($message.Attribute.category_id)}
                                    <br/>公司名称：{$message.Attribute.company}
                                </div>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
                <div class="pagesMag">
                    <form id="msgOpt" >
                    <div class="fanyea fanyeaFr">
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
                                <div class="dd_span1"><a href="javascript:void(0)" id="jumpButton">跳转</a></div>
                            </div>
                            {if $paginatorParams['nextPage']}
                                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                            {/if}
                        </div>
                    <input type="checkbox" class="inpChk" name="" id="znxConFriAll" value=""/>
                    <label for="znxConFriAll">全选</label>
                    <input type="button" class="inpButton deleMess deleteSelectSmg" name="" value="删除"/>
                        <input type="hidden" name="msg_type" value="station" />
                        {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
                        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
                        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#msgList', 'method' => 'post', 'data' => $this->Js->get('#msgOpt')->serializeForm($form)]}
                        {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
                        {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
                        {$this->Js->writeBuffer()}
                    </form>
                </div>
                {else}
                没有好友信息
                {/if}
            </div>
        </div>
    </div>
</div>