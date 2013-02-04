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
      <a href="javascript:void(0)">已结束的合作</a>
      {else}
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">兼职管理</a>&gt;&gt;
      <a href="javascript:void(0)">已结束的合作</a>
      {/if}
      </p>      
    </div>    
    <div class="biaotit">完成的合作</div>
    <form id="informationList">
        {$this->element('complete_cooperations_paginator')}
    </form>
</div>