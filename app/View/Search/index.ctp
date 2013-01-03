<script type="text/javascript">
{literal}
$(document).ready(function(){
    //价格范围
    $( "#slider-price" ).slider({
        range: true,
        min: 0,
        max: 5000,
        values: [ 0, 3000 ],
        slide: function( event, ui ) {
            $( "#amount-jiage" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
        }
    });
    $( "#amount-jiage" ).val($( "#slider-price" ).slider( "values", 0 ) +" - " + $( "#slider-price" ).slider( "values", 1 ) );

    //检索按钮
    $('#search').click(function(){
       var searchOpt = $('#searchOpt').serializeArray();
        $('#informationList').load('/search?type=' + $('#info_type').val(), searchOpt, function(){});
    });
    
    $('.search_category').click(function(){
        var category_id = $(this).find('.category_id').val();
        $('#informationList').load('/search/index/fromMenu:true?type=' + $('#info_type').val(), {'product':[category_id]}, function(){});
    });
});
{/literal}
</script>
<div class="main">
    {$this->element('common/category-list')}
    <div class="wmxxjs_right">
        <form id="searchOpt">
            {$this->element('common/keyuan-search-bar')}
			{if $type=="need"}
            <div class="biaotit">检索到客源信息</div>
			{else}
			<div class="biaotit">检索到悬赏信息</div>
			{/if}
            {$this->element('common/keyuan-result')}
        </form>
        <input type="hidden" id="info_type" value="{$type}" />
    </div>
</div>