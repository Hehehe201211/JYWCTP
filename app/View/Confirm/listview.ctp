<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.status').live('change', function(){
        $('#informationList').load('/confirm/listview?type=' + $('#info_type').val(), $('#informationList').serializeArray(), function(){});
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
      {/if}
      </a>&gt;&gt;
      <a href="#">交易中</a></p>
    </div>
    {if $type=="need"}<div class="biaotit">交易中的悬赏</div>
    {else}<div class="biaotit">交易中的客源</div>
    {/if}    
	<form id="informationList">
    	{$this->element('confirm_paginator')}
	</form>
</div>