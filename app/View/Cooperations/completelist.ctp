<div class="zy_z">
    <div class="zy_zs">
      <p>
      {if $type == "send"}
      <a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="jltdjl.html">兼职管理</a>&gt;&gt;<a href="#">已结束的合作</a>
      {else}
      <a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="jltdjl.html">兼职管理</a>&gt;&gt;<a href="#">已结束的合作</a>
      {/if}
      </p>      
    </div>    
    <div class="biaotit">完成的合作</div>
    <form id="informationList">
        {$this->element('complete_cooperations_paginator')}
    </form>
</div>