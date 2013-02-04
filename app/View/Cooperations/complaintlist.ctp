<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.inpCheckbox').live('change', function(){
        $('#pageSize').get(0).selectedIndex = 0;
        $('#jump').val('');
        $('#informationList').load(location.href, $('#informationList').serializeArray(), function(){});
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      {if $type == "send"}
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">兼职管理</a>&gt;&gt;
      <a href="javascript:void(0)">我的投诉</a>
      {else}
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">兼职管理</a>&gt;&gt;
      <a href="javascript:void(0)">我被投诉</a>
      {/if}
      </p>      
    </div>    
    <div class="biaotit">{if $type == "send"}我的投诉{else}我被投诉{/if}</div>
    <form id="informationList">
        {$this->element('complaint_cooperations_paginator')}
    </form>
</div>