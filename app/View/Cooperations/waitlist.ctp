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