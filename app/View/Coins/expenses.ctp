<script type="text/javascript">
{literal}
$(document).ready(function(){    
	datepIniChange("#date_begin","coins");
	datepIniChange("#date_end","coins");
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="new-qbmx.html">资金管理</a>&gt;&gt;<a href="#">支出明细</a></p>  
    </div>    
    <div class="zhanghujil">        
        <div class="rightBody">
          <div class="mt10 lh24">
            <p><strong>充值/消费明细</strong>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#">刷新明细</a></p>
            <form method="get" action="#">
            <p class="margin0"> 查询日期：从&nbsp;
            <input id="date_begin" type="text" name="date_begin" value="" readonly="readonly"/>
            &nbsp;至&nbsp;
            <input id="date_end" type="text"  name="date_end" value="" readonly="readonly"/>
             <input type="submit" value="查询" id="topupQuery"/>
            </p>
          </form>
          </div>
      <div class="biaotit">支出明细</div>
       <p class="sort">排序:
      <input type="radio" name="zjSort" id="time" value="time" checked="checked" /><label for="time">时间&nbsp;</label>
      <!--
      <input type="radio" name="zjSort" id="linkman" value="linkman" /><label for="linkman">支出方&nbsp;</label>
      -->
      <input type="radio" name="zjSort" id="sum" value="sum" /><label for="sum">金额&nbsp;</label></p>
		<form id="informationList">
    		{$this->element('coins_paginator')}
		</form>
      </div>
      </div>	
</div>