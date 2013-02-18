<script type="text/javascript">
{literal}
$(document).ready(function(){
$("body").append($(".divDjbuz"));
	//价格范围
	$( "#slider-price" ).slider({
		range: true,
		min: 0,
		max: 500,
		values: [ 0, 100 ],
		slide: function( event, ui ) {
			$( "#amount-jiage" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
		}
	});
	$( "#amount-jiage" ).val($( "#slider-price" ).slider( "values", 0 ) +" - " + $( "#slider-price" ).slider( "values", 1 ) );
	
	//信息详情
	$(".con_2_table a:not(.tofu_anniu a)").live("click",function(e){
		var id = $(this).parent().parent().attr('id');
		var type = $('#detail_type').val();
		var num = $(this).parent().parent().find('.tr_td5');
		$('#divDjbuz1').load('/informations/ajax_payment', {'id' : id, 'type' : type}, function(){			
			bgKuang("#divDjbuz1",".divDjbuz .closeKuang");	
			var clicked = $('#divDjbuz1').find('#clicked').val();
			if (clicked == 1) {
				num.find('a').text(parseInt(num.find('a').text())+1);
			}
		});
	});	
	$(".close").live("click",function(){		
		$(".divDjbuz .closeKuang").click();
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
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      {if $type == "need"}
        <a href="javascript:void(0)">我有客源</a>&gt;&gt;
        <a href="javascript:void(0)">所有悬赏</a>
      {else}
          <a href="javascript:void(0)">我要客源</a>&gt;&gt;
          <a href="javascript:void(0)">所有客源</a>
      {/if}
      </p>      
    </div>
    <div style="overflow:visible;" class="xxjs">
      <div class="biaotit">{if $type=="has"}所有客源{else}所有悬赏{/if}</div>
      <div class="advance_seach">
        <div class="switchBox">
    <ul>
      <li class="lists city"><span class="title">
        <input type="button" value="城市（可选）" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>城市选择器</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">返回省份</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->City->parentCityList() as $city}
                <dd>
                  <label>
                    <input type="checkbox" value="{$city.City.id}" class="inpCheckbox">
                    {$city.City.name}</label>
                </dd>
                {/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
            </dd>
            <dt>您已经选择的城市是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected">
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts">
        </ul>
      </li>
      <li class="lists trade"><span class="title">
        <input type="button" value="行业（可选）" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>行业选择器</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">行业</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->Category->parentCategoryList() as $value}
                <dd>
                  <label>
                    <input type="checkbox" value="{$value.Category.id}" class="inpCheckbox">
                    {$value.Category.name}</label>
                </dd>
                {/foreach}
              </dl>
            </dd>
            <dt>您已经选择的行业是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected">
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts">
        </ul>
      </li>
      <li class="lists product"><span class="title">
        <input type="button" value="产品或服务（可选）" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>产品或服务</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">返回产品或服务</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->Category->parentCategoryList() as $cate}
                <dd>
                  <label>
                    <input type="checkbox" value="{$cate.Category.id}" class="inpCheckbox">
                    {$cate.Category.name}</label>
                </dd>
                {/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
            </dd>
            <dt>您已经选择的产品和服务是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected">
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts">
        </ul>
      </li>
      <li class="lists keyword">
        <input type="text" name="inpKeyword" class="inpKeyword" value="请输入关键字" placeholder="请输入关键字" onfocus="this.select()"/>
      </li>
      </ul>
      <div class="clearfix"></div>
      <ul>
      <li class="lists" style="width:255px;height:40px;">
        <label>{if $type == "has"}信息价格{else}悬赏金额{/if}：</label>
        <input type="text" id="amount-jiage" name="price" />
        <div id="slider-price" style="margin-left:66px"></div>
      </li>
      <li class="lists" style="width:115px;">是否支持积分交易：
        <select name="payment_method">
          <option value="">不限</option>
          <option value="1">是</option>
          <option value="0">否</option>
        </select>
      </li>
      <li class="lists">发布日期：
        <select name="limitTime">
          <option value="">全部</option>
          <option value="0">当日</option>
          <option value="3">3天</option>
          <option value="7">一周</option>
          <option value="30">一个月</option>
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
<div style="width:550px;" id="divDjbuz1" class="divDjbuz">
    <div id="djbuz">
    </div>
    </div>