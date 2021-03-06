<script type="text/javascript">
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
            $('#open').parent().parent().append(errorMsg);
            error=1;
        } else if($('#open').val() != "" && $('#close').val() != "") {            
            if ($('#close').val() < $('#open').val()) {
                 $('#open').parent().parent().append(dateEMsg);
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
        <form id="information" method="post" action="/informations/check">
            <input type="hidden" name="id" value="{$this->request->query['id']}">
            <input type="hidden" name="type" value="1">
            <input type="hidden" name="target" value="{if !empty($target)}{$target}{elseif isset($this->data['target'])}{$this->data['target']}{/if}">
          <dl>
            <dt>
              <label><font class="facexh">*</font>信息标题：</label>
              <input type="text" name="title" id="title" value="{$info.Information.title}">
            </dt>
            <dt class="productKinds">
              <label><font class="facexh">*</font>产品名称：</label>
              <select name="category" id="category">
                    <option value="">请选择</option>
                    {foreach $this->Category->parentCategoryList() as $value}
                        <option value="{$value.Category.id}" {if $value.Category.id == $info.Information.category}selected="selected"{/if}>{$value.Category.name}</option>
                    {/foreach}
                </select>
                <select name="sub_category" id="sub_category">
                  <option value="">请选择</option>
                  {foreach $this->Category->childrenCategoryList($info.Information.category) as $value}
                    <option value="{$value.Category.id}" {if $value.Category.id == $info.Information.sub_category}selected="selected"{/if}>{$value.Category.name}</option>
                  {/foreach}
                </select>
              <input type="text" name="other_category" value="请输入产品名称" id="acpro_inp3">
            </dt>
            <dt>
              <label><font class="facexh">*</font>产品提供单位：</label>
              <input type="text" name="company" id="company" value="{$info.Information.company}">
            </dt>
            <dt>
              <label><font class="facexh">*</font>单位所在区域：</label>
              <select name="provincial" id="provincial">
                  <option value="">请选择省份</option>
                    {foreach $this->City->parentCityList() as $city}
                        <option value="{$city.City.id}" {if $info.Information.provincial == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
                    {/foreach}
                </select>
                <select name="city" id="city">
	                  <option value="">请选择城市</option>
	                  {foreach $this->City->childrenCityList($info.Information.provincial) as $child}
                        <option value="{$child.City.id}" {if {$child.City.id} == $info.Information.city}selected="selected"{/if}>{$child.City.name}</option>
                      {/foreach}
	                </select>
            </dt>
            <dt>
              <label><font class="facexh">*</font>悬赏有效期：</label>
              <ul class="validity">
                <li>
                    <input type="text" name="open" id="open" value="{$info.Information.open|date_format:"%Y-%m-%d"}" readonly="readonly"/>
                  </li>
                  <li style="width:36px;text-align:center">至</li>
                  <li>
                    <input type="text" name="close" id="close" value="{$info.Information.close|date_format:"%Y-%m-%d"}" readonly="readonly"/>
               </li>
              </ul>
            </dt>
            <dt>
                <label><font class="facexh">*</font>客源悬赏价格：</label>
                <ul class="payType">
                  <li>                    
                    <label><input type="checkbox" name="pay_coin" value="1" class="chkWidth15" id="pay_coin" {if $info.Information.payment_type != 2} checked="checked"{/if} />现金支付：</label>
                    <input type="text" name="price" id="price" class="text" value="{$info.Information.price}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)"/>
                    <span>元</span></li>
                  <li>                   
                    <label><input type="checkbox" name="pay_point" value="1" class="chkWidth15" id="pay_point" {if $info.Information.payment_type != 1} checked="checked"{/if} />积分支付：</label>
                    <input type="text" name="point" id="point" class="text" value="{$info.Information.point}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)"/>
                    <span>分</span></li>
                </ul>
              </dt>
            <dt>
              <label><font class="facexh">*</font>产品信息描述：</label>
              <textarea rows="5" cols="45" name="introduction" id ="introduction">{$info.Information.introduction}</textarea>
            </dt>
            <dt>
              <label>客源选择因素：</label>
              <input type="text" name="reason" value="{$info.Information.reason}" />
            </dt>
            <dt>
              <label>产品的补充说明：</label>
              <textarea rows="5" cols="45" id="caigouyunayin" name="additional">{$info.Information.additional}</textarea>
            </dt>
          </dl>
          <a class="zclan zclan4" href="javascript:void(0)" id="check">预览</a>
        </form>
      </div>
    </div>