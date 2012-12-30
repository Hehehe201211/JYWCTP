<div class="zy_z">
    <div class="zy_zs">
      <p>
      {if $type == "send"}
      <a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="jltdjl.html">兼职管理</a>&gt;&gt;<a href="#">我的投诉</a>
      {else}
      <a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="jltdjl.html">兼职管理</a>&gt;&gt;<a href="#">我被投诉</a>
      {/if}
      </p>      
    </div>    
    <div class="biaotit">{if $type == "send"}我的投诉{else}我被投诉{/if}</div>
    <form id="informationList">
        {$this->element('complaint_cooperations_paginator')}
    </form>
</div>