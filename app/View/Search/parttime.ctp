<script type="text/javascript">
{literal}
$(document).ready(function(){
    //检索按钮
    $('#search').click(function(){
       var searchOpt = $('#searchOpt').serializeArray();
        $('#informationList').load('/search/parttime', searchOpt, function(){});
    });
});
{/literal}
</script>
<div class="main">
    <div class="wmxxjs_left">
        <form id="searchOpt">
            {$this->element('common/parttime-search-bar')}
            <div class="biaotit">检索结果</div>
            {$this->element('common/parttime-result')}
        </form>
    </div>
    <div class="sider">
        {$this->element('common/parttime-right')}
    </div>
    <div class="clear">&nbsp;</div>
</div>