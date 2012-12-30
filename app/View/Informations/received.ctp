<div class="zy_z">
    <div class="zy_zs">
            <p><a href="#">我的聚业务</a>&gt;&gt;
            {if $type == "has"}
            <a href="#">我要客源</a>&gt;&gt;<a href="#">收到的客源</a></p>
            {else}
            <a href="#">我有客源</a>&gt;&gt;<a href="#">收到的悬赏</a></p>
            {/if}
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