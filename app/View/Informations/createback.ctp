<script>
{literal}
$(document).ready(function(){
	$('#provincial').change(function(){
		$('#city').find('option:gt(0)').remove();
		if ($(this).val() != "") {
			$.ajax({
				'type' : 'Get',
				'url'  : '/informations/getCityList/' + $(this).val(),
				'success':function(data){
					var dataobj=eval("("+data+")");
					var optionStr = "";
					$.each(dataobj, function(idx, item){
						optionStr += '<option value="'+item.City.id+'">' + item.City.name + '</option>'
					});
					$('#city').append(optionStr);
				}
			})
		}
	});
	
	$('#category').change(function(){
		$('#sub_category').find('option:gt(0)').remove();
		if ($(this).val() != "") {
			$.ajax({
				'type'	: 'Get',
				'url'	: '/informations/getCategoryList/' + $(this).val(),
				'success':function(data) {
					var dataobj=eval("("+data+")");
					var optionStr = "";
					$.each(dataobj, function(idx, item){
						optionStr += '<option value="'+item.Category.id+'">' + item.Category.name + '</option>'
					});
					$('#sub_category').append(optionStr);
				}
			});
		}
	});
	
	$("#open,#close,#acpro_inp12").datepicker({monthNames: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayNamesMin: ["日","一","二","三","四","五","六"],dateFormat:"yy-mm-dd"});
	//
	$('#check').click(function(){
		if (!checkData()) {
			$("#information").submit();
		}
	});
	var checkTarget = ['title', 'provincial', 
						'industries_id', 'company', 'category', 
						'sub_category',
						'payment_type', 'introduction'
						];
	var errorMsg = '<span style="color:red" class="errorMsg">请输入此项目</span>'
	function checkData() 
	{
		var error=0;
		$.each(checkTarget, function(target){
			if($('#' + this).val() == "") {
				if($('#' + this).parent('dt').find('.errorMsg').length == 0) {
					$('#' + this).parent('dt').append(errorMsg);
				}
				error=1;
			} else {
				$('#' + this).parent('dt').find('.errorMsg').remove();
			}
		});
		if($('#open').val() == "" || $('#close').val() == "") {
			if($('#open,#close').parent().parent().find('.errorMsg').length == 0) {
				$('#open,#close').parent().parent().append(errorMsg)
			}
		} else if($('#open').val() != "" && $('#close').val() != "") {
			$('#open,#close').parent().parent().find('.errorMsg').remove();
		}
		
		$('.contact, .post, .address, .contact_method').each(function(){
			if ($(this).val() == "") {
				if($(this).parent().find('.errorMsg').length == 0) {
					$(this).parent().append(errorMsg);
				}
				error=1;
			} else {
				$(this).parent().find('.errorMsg').remove();
			}
		});
		if($('#pay_coin').attr('checked') == "checked") {
			if ($('#price').val() == "") {
				if ($('#price').parent().parent().find('.errorMsg').length == 0) {
					$('#price').parent().parent().append(errorMsg);
				}
				error = 1;
			} else {
				$('#price').parent().parent().find('.errorMsg').remove();
			}
		}
		if($('#pay_point').attr('checked') == "checked") {
			if ($('#point').val() == "") {
				if ($('#point').parent('dt .errorMsg').length == 0) {
					$('#point').parent('dt').append(errorMsg);
				}
				error = 1;
			} else {
				$('#point').parent('dt').find('.errorMsg').remove();
			}
		}
		return error;
	}
	
	$('#sub_category').live('change', function(){
		if ($(this).find("option:selected").text()=="其它") {
			$(".productKinds input:text").show();
		} else  {
			$(".productKinds input:text").hide();
		}
	});
	$('#category').change(function(){
		$(".productKinds input:text").val('');
		$(".productKinds input:text").hide();
	});
	
	
	$(".productKinds input:text").focus(function(){		
		$(this).val("");
		$(this).unbind("focus");
	});
	var i=1;
	$("button.addCon").live("click",function(e){
		e.preventDefault();
		var str = "<dt class='dtConnection"+i+"'>"+
                    "<label>"+
                    "<font class='facexh'>*</font>联系人："+
                    "</label>"+
                    "<input type='text' name='contact[]' class='contact' />"+
                 "</dt>"+
                 "<dt class='dtConnection"+i+"'>"+
                    "<label>"+
                    "<font class='facexh'>*</font>联系人职位："+
                    "</label>"+
                    "<input type='text' name='post[]' class='post' />"+
                "</dt>"+
                "<dt class='dtConnection"+i+"'>"+
                    "<label>"+
                    "<font class='facexh'>*</font>单位详细地址："+
                    "</label>"+
                    "<input type='text' name='address[]' class='address' />"+
                "</dt>"+
                "<dt class='dtConnection"+i+"'>"+
                    "<label>"+
                    "<font class='facexh'>*</font>联系方式："+
                    "</label>"+
                    "<input type='text' name='contact_method[]' class='contact_method' />"+
                    "<button class='addCon' value=''>添加</button>"+
                    "<button class='deleCon' value='' btnnum='"+i+"'>删除</button>"+
                    "</dt>";
        $(this).parent("dt").after(str);
//		$(this).parent("dt").after("<dt class='dtConnection"+i+"'><label><font class='facexh'>*</font>联系人：</label><input type='text' name='contact[]' class='contact' /></dt><dt  class='dtConnection"+i+"'><label><font class='facexh'>*</font>联系人职位：</label><input type='text' name='post[]' class='post' /></dt><dt class='dtConnection"+i+"'><label><font class='facexh'>*</font>联系方式：</label><input type='text' name='contact_method[]' class='contact_method' /><button class='addCon' value=''>添加</button><button class='deleCon' value='' btnnum='"+i+"'>删除</button></dt>");
		i++;
	});
	$("button.deleCon").live("click",function(){
		var n=$(this).attr("btnnum");
		$(".dtConnection"+n).remove();
	});
	
	
});
{/literal}
</script>


<div class="zy_z">
    <div class="hysj">
      <ul>
        <li>1.填写发布信息</li>
        <li>2.确认信息</li>
        <li>3.发布成功</li>
      </ul>
      <div class="sjle">
      <form id="information" method="post" action="/informations/check{if !empty($target)}?target={$target}{/if}">
      		<input type="hidden" name="target" value="{$target}">
            <dl>
              <dt>
                <label><font class="facexh">*</font>信息标题：</label>
                <input type="text" name="title" id="title" value="{if isset($this->data['title'])}{$this->data['title']}{else}{/if}">
              </dt>
              <dt>
                <label><font class="facexh">*</font>省份：</label>
                <select name="provincial" id="provincial">
                  <option value="">请选择</option>
                  {foreach $cityList as $city}
					<option value="{$city.City.id}" {if isset($this->data['provincial']) && $this->data['provincial'] == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
				{/foreach}
                </select>

                <label><font class="facexh">*</font>城市：</label>
                {if isset($this->data['provincial'])}
                	<select name="city" id="city">
	                  <option value="">请选择</option>
	                  {foreach $this->City->childrenCityList($this->data['provincial']) as $child}
						<option value="{$child.City.id}" {if isset($this->data['city']) && {$child.City.id} == $this->data['city']}selected="selected"{/if}>{$child.City.name}</option>
	                  {/foreach}
	                </select>
                {else}
	                <select name="city" id="city">
	                  <option value="">请选择</option>
	                </select>
                {/if}
              </dt>
              <dt>
                <label><font class="facexh">*</font>行业：</label>
                <select name="industries_id" id="industries_id">
                  <option value="">请选择</option>
                  {foreach $category as $value}
	               	<option value="{$value.Category.id}">{$value.Category.name}</option>
	               {/foreach}
                </select>
              </dt>
              <dt>
                <label><font class="facexh">*</font>采购单位：</label>
                <input type="text" name="company" id="company">
              </dt>
              <dt class="productKinds">
                <label><font class="facexh">*</font>产品名称：</label>
                <select name="category" id="category">
                  <option value="">请选择</option>
                   {foreach $category as $value}
	               	<option value="{$value.Category.id}">{$value.Category.name}</option>
	               {/foreach}
                </select>
                <select name="sub_category" id="sub_category">
                  <option value="">请选择</option>
                </select>
                <input type="text" name="other_category" value="请输入产品名称" id="acpro_inp3">
              </dt>
              <dt>
              <label><font class="facexh">*</font>有效期：</label>
              <ul class="validity">
                  <li>
                    <input type="text" name="open" id="open"/>
                  </li>
                  <li style="width:36px">至</li>
                  <li>
                    <input type="text" name="close" id="close">
                  </li>
                </ul>
              </dt>
              <dt>
                <label><font class="facexh">*</font>买家付款方式：</label>
                <ul class="payType">
                  <li>
                    <input type="checkbox" name="pay_coin" value="1" class="chkWidth15" id="pay_coin" checked="checked" style="background-image: none; background-position: initial initial; background-repeat: initial initial; ">
                    <label for="xianjinzhifu">现金支付：</label>
                    <input type="text" name="price" id="price" class="text">
                    <span>元</span></li>
                  <li>
                    <input type="checkbox" name="pay_point" value="1" class="chkWidth15" id="pay_point" style="background-image: none; background-position: initial initial; background-repeat: initial initial; ">
                    <label for="jifenzhifu">积分支付：</label>
                    <input type="text" name="point" id="point" class="text">
                    <span>分</span></li>
                </ul>
              </dt>
              <dt>
                <label><font class="facexh">*</font>联系人：</label>
                <input type="text" name="contact[]" class="contact" id="acpro_inp9">
              </dt>
              <dt>
                <label><font class="facexh">*</font>联系人职位：</label>
                <input type="text" name="post[]" class="post" id="acpro_inp10">
              </dt>
              <dt>
                <label><font class="facexh">*</font>单位详细地址：</label>
                <input type="text" id="address" name="address[]">
              </dt>
              <dt>
                <label><font class="facexh">*</font>联系方式：</label>
                <input type="text" name="contact_method[]" class="contact_method" id="acpro_inp11">
                <button class="addCon" value="">添加</button>
              </dt>
              <dt>
                <label><font class="facexh">*</font>采购需求描述：</label>
                <textarea name="introduction" id="introduction" cols="45" rows="5"></textarea>
              </dt>
              <dt>
                <label>预计合作金额:</label>
                <input type="text" name="profit" id="acpro_inp11">
              </dt>
              <dt>
                <label>预计合作时间：</label>
                <input type="text" name="finished" id="acpro_inp12">
              </dt>
              <dt>
                <label>客户选择服务商因素：</label>
                <input type="text" name="reason" id="acpro_inp13">
              </dt>
              <dt>
                <label>采购补充：</label>
                <textarea name="additional" id="caigouyunayin" cols="45" rows="5"></textarea>
              </dt>
            </dl>
            <input type="hidden" name="type" value="{$type}">
            <a class="zclan" href="javascript:void(0)" id="check">预览</a>
          </form>
      
      
      
      
      
      
      <!--
        <form id="information" method="post" action="/informations/check">
          <dl>
            <dt>
              <label><font class="facexh">*</font>信息标题：</label>
              <input type="text" name="title" id="title">
            </dt>
            <dt class="area">
              <label><font class="facexh">*</font>省份：</label>
              <select name="provincial" id="provincial">
				<option value="">请选择</option>
				{foreach $cityList as $city}
					<option value="{$city.City.id}">{$city.City.name}</option>
				{/foreach}
			</select>
            </dt>
            <dt class="area">
              <label><font class="facexh">*</font>城市：</label>
              <select name="city" id="city">
				<option value="">请选择</option>
			</select>
            </dt>
            <dt class="area">
              <label><font class="facexh">*</font>行业：</label>
              <select name="industries_id" id="industries_id">
                <option value="">请选择</option>
	               {foreach $category as $value}
	               	<option value="{$value.Category.id}">{$value.Category.name}</option>
	               {/foreach}
              </select>
            </dt>
            <dt>
              <label><font class="facexh">*</font>采购单位：</label>
              <input type="text" name="company" id="company">
            </dt>
                   
            <dt class="productKinds">
               <label><font class="facexh">*</font>产品名称：</label>
               <select name="category" id="category">
               		<option value="">请选择</option>
	               {foreach $category as $value}
	               	<option value="{$value.Category.id}">{$value.Category.name}</option>
	               {/foreach}
               </select>
              <select name="sub_category" id="sub_category">
              	<option value="">请选择</option>
              </select>
               <input type="text" name="other_category" value="请输入产品名称" id="acpro_inp3">
            </dt>
            <dt>
              <label><font class="facexh">*</font>有效期：</label>
              <ul>
              <li><input type="text" name="open" id="open"/>&nbsp;至&nbsp;</li>
              
              <li><input type="text" name="close" id="close"></li>
              </ul>
            </dt>
            <dt>
              <label><font class="facexh">*</font>买家付款方式：</label>
              <ul>
                <li>
                  <input type="checkbox" name="pay_coin" value="1" class="chkWidth15" id="pay_coin" checked="checked" style="background-image: none; background-position: initial initial; background-repeat: initial initial; ">
                  <label for="xianjinzhifu">现金支付：</label>
                  <input type="text" name="price" id="price" />
                  &nbsp;元
                  </li>
                <li>
                  <input type="checkbox" name="pay_point" value="1" class="chkWidth15" id="pay_point" style="background-image: none; background-position: initial initial; background-repeat: initial initial; ">
                  <label for="jifenzhifu">积分支付：</label>
                  <input type="text" name="point" id="point" />
                  &nbsp;分</li>
              </ul>
            </dt>
              <dt>
                <label><font class="facexh">*</font>联系人：</label>
                <input type="text" name="contact[]" class="contact" />
              </dt>
              <dt>
                <label><font class="facexh">*</font>联系人职位：</label>
                <input type="text" name="post[]" class="post" />
              </dt>
              <dt>
                <label><font class="facexh">*</font>单位详细地址：</label>
                <input type="text" id="address" name="address[]" class="address">
              </dt>
              <dt>
                <label><font class="facexh">*</font>联系方式：</label>
                <input type="text" name="contact_method[]" class="contact_method" />
                <button class="addCon" value="">添加</button>
              </dt>
            <dt>
              <label><font class="facexh">*</font>采购需求描述：</label>
              <textarea name="introduction" id="introduction" cols="45" rows="5"></textarea>
            </dt>
            <dt>
              <label>预计合作金额:</label>
              <input type="text" name="profit" id="acpro_inp11">
            </dt>
            <dt>
              <label>预计合作时间：</label>
              <input type="text" name="finished" id="acpro_inp12">
            </dt>
            <dt>
              <label>客户选择服务商因素：</label>
              <input type="text" name="reason" id="acpro_inp13">
            </dt>
            <dt>
              <label>采购补充：</label>
              <textarea name="additional" id="caigouyunayin" cols="45" rows="5"></textarea>
            </dt>
          </dl>
          <input type="hidden" name="type" value="{$type}">
          <a class="zclan" href="javascript:void(0)" id="check">预览</a>
        </form>
        -->
      </div>
    </div>
    <!-- InstanceEndEditable --> 
    </div>