<div class="zy_z">
    <div class="zy_zs">
        <p>
	        <a href="#">我的聚客源</a>&gt;&gt;
	        <a href="#">信息记录</a>&gt;&gt;
	        <a href="#">{$naviText}</a>
        </p>
    </div>
	{if $type=="need"}<div class="biaotit">悬赏列表</div>{else}<div class="biaotit">客源列表</div>{/if}
<form id="informationList">
    {$this->element('paginator')}
</form>
</div>