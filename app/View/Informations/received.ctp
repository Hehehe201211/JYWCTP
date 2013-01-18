<div class="zy_z">
    <div class="zy_zs">
            <p>
                <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
            {if $type == "has"}
                <a href="javascript:void(0)">我要客源</a>&gt;&gt;
                <a href="javascript:void(0)">收到的客源</a>
            {else}
                <a href="javascript:void(0)">我有客源</a>&gt;&gt;
                <a href="javascript:void(0)">收到的悬赏</a>
            {/if}
            </p>
    </div>
	{if $type == "has"}
            <div class="biaotit">收到的客源</div>
            {else}
            <div class="biaotit">收到的悬赏</div>
            {/if}
<form id="informationList">
{$type=['btn_type'=>'received']}
    {$this->element('paginator', $type)}
</form>
</div>