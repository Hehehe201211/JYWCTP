<script type="text/javascript">
{literal}
$(document).ready(function(){
    //检索按钮
    $('.btnBar').click(function(){
       var searchOpt = $('#searchOpt').serializeArray();
        $('#informationList').load('/search/company', searchOpt, function(){});
    });
});
{/literal}
</script>
<div class="main">
    <div class="conResource">
        <div class="crumbsNav">搜索结果</div>
        <form id="searchOpt">
            <div class="searchBar">
                <input type="text" name="keyword" value="{if isset($this->data['keyword'])}{$this->data['keyword']}{/if}" class="inpTextBox inpTextbox" id="acpro_inp2">
                <a href="javascript:void(0)" class="btnBar">搜&nbsp;索</a>
            </div>
            <div class="clear">&nbsp;</div>
            <div class="serResult" id="informationList">
                {$this->element('common/company-result')}
            </div>
        </form>
    </div>
    <div class="sider">
        {$this->element('common/parttime-right')}
    </div>
    <div class="clear">&nbsp;</div>
</div>