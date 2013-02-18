<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("body").append($(".jsxxxqB"));
	$(".batch a").click(function(){
		bgKuang("#jsxxxq1",".jsxxxqB .closeDiv");			
	});	
    $('#provincial').change(function(){
        $('#city').find('option:gt(0)').remove();
        if ($(this).val() != "") {
            $.ajax({
                'type' : 'Get',
                'url'  : '/informations/getCityList/' + $(this).val(),
                'success':function(data){
                    var dataobj=eval("("+data+")");
                    var optionStr = "";
                    if (dataobj.length == 1) {
						optionStr += '<option value="'+dataobj[0].City.id+'" selected="selected">' + dataobj[0].City.name + '</option>'
					} else {
						$.each(dataobj, function(idx, item){
							optionStr += '<option value="'+item.City.id+'">' + item.City.name + '</option>'
						});
					}
                    $('#city').append(optionStr);
                }
            })
        }
    });
    $('#category').change(function(){
        $('#sub_category').find('option:gt(0)').remove();
        if ($(this).val() != "") {
            $.ajax({
                'type'  : 'Get',
                'url'   : '/informations/getCategoryList/' + $(this).val(),
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
    datepIniChange("#open","indate");
	datepIniChange("#close","indate");
	datepIniChange("#acpro_inp12","indate");	
    $('#check').click(function(){
        if (!checkData()) {
            $("#information").submit();
        }
    });
    var checkTarget = ['title', 'provincial', 'city',
                        'industries_id', 'company', 'category', 
                        'sub_category',
                        'payment_type', 'introduction'
                        ];                        
    var errorMsg = '<span class="errorMsg">请输入此项目</span>';
    var re = /^[0-9]*$/;
	var intEMsg = '<span class="errorMsg">请输入数字</span>';
	var dateEMsg = '<span class="errorMsg">请正确输入时间</span>';
    function checkData() {
        var error=0;
		$(".sjle").find(".errorMsg").remove();
        $.each(checkTarget, function(target){
            if($('#' + this).val() == "") {
                $('#' + this).parent('dt').append(errorMsg);
                error=1;
            } 
        });      
        if($('#open').val() == "" || $('#close').val() == "") {
            $('#open,#close').parent().parent().append(errorMsg);
            error=1;
        } else if($('#open').val() != "" && $('#close').val() != "") {            
            if ($('#close').val() < $('#open').val() ) {
                 $('#open,#close').parent().parent().append(dateEMsg);
                 error=1;
            }
        }
        $('.contact, .post, .address, .contact_method').each(function(){
            if ($(this).val() == "") {
                $(this).parent().append(errorMsg);
                error=1;
            } 
        });
        var priceErr = false;
		if($('#pay_coin').attr('checked') == "checked") {
			if ($('#price').val() == "") {
				$('#price').parent().parent().append(errorMsg);
				error = 1;
				priceErr = true;
			} else if (!re.test($('#price').val())){
				$('#price').parent().parent().append(intEMsg);
				error = 1;
				priceErr = true;
			} 
		}
		if(!priceErr && $('#pay_point').attr('checked') == "checked") {
			if ($('#point').val() == "") {
				$('#point').parent().parent().append(errorMsg);
				error = 1;
			} else if (!re.test($('#point').val())){
				$('#point').parent().parent().append(intEMsg);
				error = 1;
			} 
		}
		if ($('#pay_coin').attr('checked') != "checked" && $('#pay_point').attr('checked') != "checked") {
			$('#point').parent().parent().append(errorMsg);
			error = 1;
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
});
{/literal}
</script>

<div class="zy_z">
	  <ul class="ulFormStep">
      <li>1.填写发布信息</li>
      <li>2.确认信息</li>
      <li>3.发布成功</li>
    </ul>
      <div class="sjle">
	  <div class="batch"><a href="javascript:;">批量发布</a></div>
        <form id="information" method="post" action="/informations/check">
            <input type="hidden" name="id" value="{if isset($this->data['id'])}{$this->data['id']}{/if}" />
            <input type="hidden" name="type" value="{$type}">
            <input type="hidden" name="target" value="{if !empty($target)}{$target}{elseif isset($this->data['target'])}{$this->data['target']}{/if}">
          <dl>
          <dt>
              <label><font class="facexh">*</font>信息标题：</label>
              <input type="text" name="title" id="title" value="{if isset($this->data['title'])}{$this->data['title']}{else}{/if}">
            </dt>
          <dt class="productKinds">
              <label><font class="facexh">*</font>产品名称：</label>
              <select name="category" id="category">
                  <option value="">请选择</option>
                  {if !empty($target) && isset($targetInfo)}
	                   {foreach $this->Category->parentCategoryList() as $value}
		               	<option value="{$value.Category.id}" {if $value.Category.id == $targetInfo.Information.category}selected="selected"{/if}>{$value.Category.name}</option>
		               {/foreach}
	               {else}
		               {foreach $this->Category->parentCategoryList() as $value}
		               	<option value="{$value.Category.id}" {if isset($this->data['category']) && $value.Category.id == $this->data['category']}selected="selected"{/if}>{$value.Category.name}</option>
		               {/foreach}
	               {/if}
                </select>
                {if isset($this->data['category'])}
	                <select name="sub_category" id="sub_category">
	                  <option value="">请选择</option>
	                  {foreach $this->Category->childrenCategoryList($this->data['category']) as $value}
	                  	<option value="{$value.Category.id}" {if isset($this->data['sub_category']) && $value.Category.id == $this->data['sub_category']}selected="selected"{/if}>{$value.Category.name}</option>
	                  {/foreach}
	                </select>
                {else}
                	<select name="sub_category" id="sub_category">
	                  <option value="">请选择</option>
	                </select>
                {/if}
              <input type="text" name="other_category" value="请输入产品名称" id="acpro_inp3">
            </dt>            
            <dt>
              <label><font class="facexh">*</font>产品提供单位：</label>
              <input type="text" name="company" id="company" value="{if isset($this->data['company'])}{$this->data['company']}{/if}">
            </dt>
            <dt>
              <label><font class="facexh">*</font>单位所在区域：</label>
              <select name="provincial" id="provincial">
                  <option value="">请选择省份</option>                  
                  {if !empty($target) && isset($targetInfo)}
	                  {foreach $this->City->parentCityList() as $city}
	                  	<option value="{$city.City.id}" {if $targetInfo.Information.provincial == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
	                  {/foreach}
                  {else}
	                  {foreach $this->City->parentCityList() as $city}
						<option value="{$city.City.id}" {if isset($this->data['provincial']) && $this->data['provincial'] == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
					  {/foreach}
				  {/if}
                </select>
                {if isset($this->data['provincial'])}
                	<select name="city" id="city">
	                  <option value="">请选择城市</option>
	                  {foreach $this->City->childrenCityList($this->data['provincial']) as $child}
						<option value="{$child.City.id}" {if isset($this->data['city']) && {$child.City.id} == $this->data['city']}selected="selected"{/if}>{$child.City.name}</option>
	                  {/foreach}
	                </select>
                {else}
	                <select name="city" id="city">
	                  <option value="">请选择城市</option>
	                </select>
                {/if}
            </dt>            
            <dt>
              <label><font class="facexh">*</font>悬赏有效期：</label>
              <ul class="validity">
                <li>
                    <input type="text" name="open" id="open" value="{if isset($this->data['open'])}{$this->data['open']}{/if}" readonly="readonly"/>
                  </li>
                  <li style="width:36px;text-align:center">至</li>
                  <li>
                    <input type="text" name="close" id="close" value="{if isset($this->data['close'])}{$this->data['close']}{/if}" readonly="readonly"/>
               </li>
              </ul>
            </dt>
            <dt>
                <label><font class="facexh">*</font>客源悬赏价格：</label>
                <ul class="payType">
                  <li>                    
                    <label><input type="checkbox" name="pay_coin" value="1" class="chkWidth15" id="pay_coin" checked="checked" />现金支付：</label>
                    <input type="text" name="price" id="price" class="text" value="{if isset($this->data['price'])}{$this->data['price']}{/if}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)"/>
                    <span>元</span></li>
                  <li>                    
                    <label><input type="checkbox" name="pay_point" value="1" class="chkWidth15" id="pay_point" {if isset($this->data['pay_point'])}checked="checked"{/if} />积分支付：</label>
                    <input type="text" name="point" id="point" class="text" value="{if isset($this->data['point'])}{$this->data['point']}{/if}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)"/>
                    <span>分</span></li>
                </ul>
              </dt>
            <dt>
              <label><font class="facexh">*</font>产品信息描述：</label>
              <textarea rows="5" cols="45" name="introduction" id ="introduction">{if isset($this->data['introduction'])}{$this->data['introduction']}{/if}</textarea>
            </dt>
            <dt>
              <label>客源选择因素：</label>
              <input type="text" name="reason" value="{if isset($this->data['reason'])}{$this->data['reason']}{/if}" />
            </dt>
            <dt>
              <label>产品的补充说明：</label>
              <textarea rows="5" cols="45" id="caigouyunayin" name="additional">{if isset($this->data['additional'])}{$this->data['additional']}{/if}</textarea>
            </dt>
          </dl>
          <a class="zclan zclan4" href="javascript:void(0)" id="check">预览</a>
        </form>
      </div>
    </div>
	<div class="jsxxxq jsxxxqB" id="jsxxxq1" style="width:480px;"><a href="#" class="closeDiv">&nbsp;</a>      
      <div class="sjle" style="overflow:hidden;">
        <dl>
          <dt><label><font class="facexh">*</font>客源模板文件下载：</label><a href="#" class="inp" style="margin-left:0;">点击下载</a></dt>
          <dt><label><font class="facexh">*</font>上传客源模板文件：</label><input type="file" /></dt>
        </dl>
      </div>
      <div class="divBtnContainer" style="width:200px;">
      <a href="javascript:alert('模板文件上传成功。');var a=$('.jsxxxqB .closeDiv').click();" class="zclan zclan7">上传</a><a href="javascript:;" onclick="$('.jsxxxqB .closeDiv').click()" class="zclan zclan7">取消</a>
      </div>
    </div>