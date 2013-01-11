{literal}
<style type="text/css">
  .znxContent .znxMesCon{display:block;}
</style>
{/literal}
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;
      {if $complaint_type == Configure::read('Complaint.ActiveText')}
      <a href="new-hyzy.html">我要客源</a>&gt;&gt;<a href="#">我的投诉</a>
      {else}
      <a href="new-hyzy.html">我有客源</a>&gt;&gt;<a href="#">我被投诉</a>
      {/if}
      </p>
    </div>
    <div class="znx">
      <ul class="znxTitle">
        <li class="active"><a href="#">{if $complaint_type == Configure::read('Complaint.ActiveText')}我的投诉{else}我被投诉{/if}</a></li>
      </ul>
      <div class="znxContent">
      <form id="informationList">
		{$this->element('complaint_paginator')}
      </form>
      </div>
    </div>
    </div>