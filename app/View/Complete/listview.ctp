<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.status').live('change', function(){
        $('#informationList').load('/complete/listview?type=' + $('#info_type').val(), $('#informationList').serializeArray(), function(){});
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">
      {if $type=="need"}我要客源
      <input type="hidden" value="need" id="info_type">
      {else}我有客源
      <input type="hidden" value="has" id="info_type">
      {/if}</a>&gt;&gt;
      <a href="#">已交易记录</a>
      </p>
    </div>
    <div class="biaotit">已完成交易</div>
	<form id="informationList">
    	{$this->element('transaction_paginator')}
	</form>
</div>