<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">兼职管理</a>&gt;&gt;
      <a href="javascript:void(0)">客源提供记录</a>
      </p>      
    </div>    
    <div class="biaotit">{if $type == "send"}客源提供列表{else}收到的合作{/if}</div>
    <form id="informationList">
        {$this->element('cooperations_paginator')}
    </form>
</div>