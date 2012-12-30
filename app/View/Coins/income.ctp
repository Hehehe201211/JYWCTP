<script type="text/javascript">
{literal}
$(document).ready(function(){
    datepIniChange("#date_begin","coins");
	datepIniChange("#date_end","coins");
	$("body").append($("#bgKuang"));	
	$("body").append($("#goumaikuang"));	
	$(".detail").live("click",function(e){
		var information_id = $(this).parent().find('.information_id').val();
		$('#goumaikuang').load('/coins/detail #djbuz', {'information_id' : information_id, 'type' : 'income'}, function(){
			e.preventDefault();	
			var bgW=$(document).width();
			if ($(document).width()<screen.availWidth) bgW=screen.availWidth; 
			$("#goumaikuang").show();			
			$("#bgKuang").css({width:bgW,height:($(document).height()+$("#djbuz").height())});
			$("#goumaikuang").css({"width":$("#djbuz").width(),"height":$("#djbuz").height()});	
		    $("#goumaikuang").css({"top":$(window).scrollTop()+100+"px","left":($(document).width()-$("#goumaikuang").width())/2+"px"});
			$("#bgKuang").fadeTo("fast",0.5);
			var clicked = $('#goumaikuang').find('#clicked').val();
			if (clicked == 1) {
				num.find('a').text(parseInt(num.find('a').text())+1);
			}
		});
	});
	$(".close").live("click",function(e){				
		$("#bgKuang").fadeOut("fast");
		$("#goumaikuang").hide();
		if ($(this).attr("href")=="#"||$(this).attr("href")=="") e.preventDefault();
	});
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="new-qbmx.html">资金管理</a>&gt;&gt;<a href="#">收入明细</a></p>    
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
      <div class="biaotit">收入明细</div>
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
<div id="bgKuang"></div>
<div style="display: none;" id="goumaikuang">
</div>