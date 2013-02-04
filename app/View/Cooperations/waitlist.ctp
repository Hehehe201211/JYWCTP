<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.inpCheckbox').live('change', function(){
        $('#pageSize').get(0).selectedIndex = 0;
        $('#jump').val('');
        $('#informationList').load(location.href, $('#informationList').serializeArray(), function(){});
    });
    $('.sort').live('change', function(){
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
      <a href="javascript:void(0)">客源提供记录</a>
      {else}
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">兼职管理</a>&gt;&gt;
      <a href="javascript:void(0)">客源提供记录</a>
      {/if}
      </p>      
    </div>    
    <div class="biaotit">合作中的兼职</div>
    <form id="informationList">
        {$this->element('wait_cooperations_paginator')}
    </form>
</div>