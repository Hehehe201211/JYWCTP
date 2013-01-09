<script type="text/javascript">
{literal}
$(document).ready(function(){
$("body").append("<div id='bgKuang'></div><div style='display: none;' id='goumaikuang'></div>");
	//价格范围
	$( "#slider-price" ).slider({
		range: true,
		min: 0,
		max: 5000,
		values: [ 0, 3000 ],
		slide: function( event, ui ) {
			$( "#amount-jiage" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
		}
	});
	$( "#amount-jiage" ).val($( "#slider-price" ).slider( "values", 0 ) +" - " + $( "#slider-price" ).slider( "values", 1 ) );
	
	/*$(".toggleMap").toggle(function(){
		$(".divMapCon").show("fast");
		$(this).text("隐藏地图检索");
	},function(){
		$(".divMapCon").hide("fast");
		$(this).text("打开地图检索");
	});*/
	
	//信息详情
	$(".con_2_table a:not(.tofu_anniu a)").live("click",function(e){
		var id = $(this).parent().parent().attr('id');
		var type = $('#detail_type').val();
		var num = $(this).parent().parent().find('.tr_td5');
		$('#goumaikuang').load('/informations/ajax_payment #djbuz', {'id' : id, 'type' : type}, function(){
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
	$(".close").live("click",function(){		
		$("#bgKuang").fadeOut("fast");
		$("#goumaikuang").hide();		
	});
	$(".tofu_anniu a").undelegate();
	
	//检索按钮
	$('#search').click(function(){
	   var searchOpt = $('#searchOpt').serializeArray();
        $('#informationList').load('/informations/search/' + $('#detail_type').val(), searchOpt, function(){});
	});
});
//{/literal}
</script>

<div class="zy_z" style="overflow: visible;">
<form id="searchOpt">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;{if $type == "need"}<a href="new-sddsx.html">我有客源</a>&gt;&gt;<a href="#">所有悬赏</a>{else}<a href="new-sddsx.html">我要客源</a>&gt;&gt;<a href="#">所有客源</a>{/if}</p>      
    </div>
    <div style="overflow:visible;" class="xxjs">
      <div class="biaotit">{if $type=="has"}所有客源{else}所有悬赏{/if}</div>
      <div class="advance_seach">
        <div class="switch_box">
          <div class="divTable divTableCity">
            <div class="divtt">
              <div class="left fl"><strong>城市选择器</strong>(最多可选5项)</div>
              <div class="right fr">[确定]</div>
            </div>
            <dl>
              <dt class="goback"><a href="#">返回省份</a></dt>
              <dl class="options">
              	{foreach $this->City->parentCityList() as $city}
              		<dd>
	                  <input type="checkbox" value="{$city.City.id}" class="inpCheckbox">
	                  <a href="#">{$city.City.name}</a>
                   </dd>
              	{/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
              <dt>您已经选择的城市是:(点击可以取消选择)</dt>
              <dl class="selected">
              </dl>
            </dl>
            <div class="divtt">
              <div class="right fr">[确定]</div>
            </div>
          </div>
          <div class="divTable divTableTrade">
            <div class="divtt">
              <div class="left fl"><strong>行业选择器</strong>(最多可选5项)</div>
              <div class="right fr">[确定]</div>
            </div>
            <dl>
              <dt class="goback"><a href="#">行业</a></dt>
              <dl class="options">
              	{foreach $this->Category->parentCategoryList() as $cate}
              		<dd>
	                  <input type="checkbox" value="{$cate.Category.id}" class="inpCheckbox">
	                  <a href="#">{$cate.Category.name}</a>
	               </dd>
              	{/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
              <dt>您已经选择的城市是:(点击可以取消选择)</dt>
              <dl class="selected">
              </dl>
            </dl>
            <div class="divtt">
              <div class="right fr">[确定]</div>
            </div>
          </div>
          <div class="divTable divTableProduct">
            <div class="divtt">
              <div class="left fl"><strong>产品或服务</strong>(最多可选5项)</div>
              <div class="right fr">[确定]</div>
            </div>
            <dl>
              <dt class="goback"><a href="#">返回产品或服务</a></dt>
              <dl class="options">
              	{foreach $this->Category->parentCategoryList() as $cate}
                    <dd>
                      <input type="checkbox" value="{$cate.Category.id}" class="inpCheckbox">
                      <a href="#">{$cate.Category.name}</a>
                   </dd>
                {/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
              <dt>您已经选择的城市是:(点击可以取消选择)</dt>
              <dl class="selected">
              </dl>
            </dl>
            <div class="divtt">
              <div class="right fr">[确定]</div>
            </div>
          </div>
          <ul>
            <li class="city"><span class="title">
              <input type="button" value="城市（可选）" class="inpButton">
              </span>
            </li>
            <li class="trade"><span class="title">
              <input type="button" value="行业（可选）" class="inpButton">
              </span>
            </li>
            <li class="product"><span class="title">
              <input type="button" value="产品或服务（可选）" class="inpButton">
              </span>
            </li>
            <li class="keyword">
              <input type="text" value="请输入关键字" placeholder="请输入关键字" class="inpKeyword inpTextBox" name="inpKeyword" id="acpro_inp65" widdit="on" autocomplete="off" onfocus="this.select()">
            </li>
          </ul>
          
			<table width="0" cellspacing="0" cellpadding="0" border="0">
				<tbody>
				  <tr>
				    <td><ul class="ulTable ulTableCity"></ul></td>
				    <td><ul class="ulTable ulTableTrade"></ul></td>
				    <td><ul class="ulTable ulTableProduct"></ul></td>
				  </tr>
				</tbody>
			</table>
          <ul>
            <li style="width:255px;">
              <label>信息价格：</label>
              <input type="text" id="amount-jiage" name="price" onkeyup="phoneNum(this)" onpaste="phoneNum(this)"/>
              <div id="slider-price" style="margin-left:80px"></div>
            </li>
            <li style="width:190px;">是否支持积分交易：
              <select name="payment_method">
                <option value="">不限</option>
                <option value="1">是</option>
                <option value="0">否</option>
              </select>
            </li>
            <li style="width:140px;">发布日期：
              <select name="limitTime">
                <option value="0">当日</option>
                <option value="3">3天</option>
                <option value="7">一周</option>
                <option value="30">一个月</option>
                <option value="">全部</option>
              </select>
            </li>
          </ul>
          
        </div>
        <!--<div class="divMap">
          <div class="divMapCon"><img src="{$this->webroot}img/dt.jpg"></div>
        </div>
        <div class="toggleMap">打开地图检索</div>-->
        <a href="javascript:void(0)" id="search" class="zclan zclan4">查询</a>
		</div>
    </div>
    <div class="biaotit">检索结果</div>
    <div id="informationList">
    {$this->element('search_paginator')}
    </div>
</form>
    </div>
    <input type="hidden" id="detail_type" value="{$type}" />
