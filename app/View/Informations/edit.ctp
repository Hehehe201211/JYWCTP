<script>
{literal}
$(document).ready(function(){
	datepIniChange("#open","indate");
    datepIniChange("#close","indate");
    datepIniChange("#finished","indate");   
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
    var errorMsg = '<span class="errorMsg">请输入此项目</span>'
    var re = /^[0-9]*$/;
    var intEMsg = '<span class="errorMsg">请输入数字</span>';
    var dateEMsg = '<span class="errorMsg">请正确输入时间</span>';
    function checkData() {
        var error=0;
		$(".sjle").find(".errorMsg").remove();
        $.each(checkTarget, function(target){
            if($('#' + this).val() == "") {
               $('#' + this).parent().append(errorMsg);
                error=1;
            } 
        });
        if ($('#city').val() == "") {
            $('#city').parent('dt').append(errorMsg);
            error=1;
        } 
        if($('#open').val() == "" || $('#close').val() == "") {
            $('#open').parent().parent().append(errorMsg);
            error=1;
        } else if($('#open').val() != "" && $('#close').val() != "") {
            var open_str = $('#open').val();
            var close_str = $('#close').val();
            if (close_str < open_str) {
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
        if ($('#type').val() == 0)
        {
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
        }
        if (!re.test($('#profit').val())) {
            $('#profit').parent().append(intEMsg);
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
    
    $(".productKinds input:text").focus(function(){     
        $(this).val("");
        $(this).unbind("focus");
    });
    
    $("button.addContact").live("click",function(e){
        e.preventDefault();
        $(this).parent().after($(this).parent().clone());
        $(this).parent().next().children(".inpTextBox").val("");
    });
    $("button.deleContact").live("click",function(e){
        e.preventDefault();
        if ($("button.deleContact").length>1) $(this).parent().remove(); 
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
      <form id="information" method="post" action="/informations/check{if !empty($target)}?target={$target}{/if}">
            <input type="hidden" id="parttime" name="parttime" value="">
            <input type="hidden" name="target" value="">
            <input type="hidden" name="target_member" value="">
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
                <!--
                <input type="text" name="other_category" value="请输入产品名称" id="acpro_inp3">
                -->
              </dt>
              <dt>
                <label><font class="facexh">*</font>采购单位：</label>
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
                <label><font class="facexh">*</font>行业：</label>
                <select name="industries_id" id="industries_id">
                    <option value="">请选择</option>
                        {foreach $this->Category->parentCategoryList() as $value}
                            <option value="{$value.Category.id}" {if $info.Information.industries_id == $value.Category.id}selected="selected"{/if}>{$value.Category.name}</option>
                        {/foreach}
                </select>
              </dt>                            
              <dt>
              <label><font class="facexh">*</font>有效期：</label>
              <ul class="validity">
                  <li>
                    <input type="text" name="open" id="open" value="{$info.Information.open|date_format:"%Y-%m-%d"}" readonly="readonly"/>
                  </li>
                  <li style="width:36px;text-align:center;">至</li>
                  <li>
                    <input type="text" name="close" id="close" value="{$info.Information.close|date_format:"%Y-%m-%d"}" readonly="readonly"/>
                  </li>
                </ul>
              </dt>
              {*if !isset($parttime) && !isset($this->data['parttime'])*}
              {if $info.Information.type == 0}
              <dt>
                <label><font class="facexh">*</font>买家付款方式：</label>
                <ul class="payType">
                    <li>
                    <label><input type="checkbox" name="pay_coin" value="1" class="chkWidth15" id="pay_coin" {if $info.Information.payment_type != 2} checked="checked"{/if} />现金支付：</label>
                    <input type="text" name="price" id="price" class="text" value="{$info.Information.price}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)">
                    <span>元</span>
                    </li>
                    <li>
                    <label><input type="checkbox" name="pay_point" value="1" class="chkWidth15" id="pay_point" {if $info.Information.payment_type != 1} checked="checked"{/if} />积分支付：</label>
                    <input type="text" name="point" id="point" class="text" value="{$info.Information.point}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)">
                    <span>分</span>
                    </li>
                </ul>
              </dt>
              {/if}
              <dt>
                <label><font class="facexh">*</font>联系人：</label>
                <input type="text" name="contact" class="contact" id="acpro_inp9" value="{$info.Information.contact}">
              </dt>
              <dt>
                <label><font class="facexh">*</font>联系人职位：</label>
                <input type="text" name="post" class="post" id="acpro_inp10" value="{$info.Information.post}">
              </dt>
              {if $info.Information.type != 1}
                {foreach $attributes as $key => $contact}
                    <dt>
                    <label><font class="facexh">*</font>联系方式：</label>
                    <div class="area1">
                      <select name="mode[]">
                        <option value="座机" {if $contact.InformationAttribute.mode == "座机"}selected="selected"{/if}>座机</option>
                        <option value="手机" {if $contact.InformationAttribute.mode == "手机"}selected="selected"{/if}>手机</option>
                        <option value="QQ" {if $contact.InformationAttribute.mode == "QQ"}selected="selected"{/if}>QQ</option>
                        <option value="MSN" {if $contact.InformationAttribute.mode == "MSN"}selected="selected"{/if}>MSN</option>
                      </select>
                    </div>
                    <input type="text" style="width:108px;" name="contact_method[]" class="contact_method" value="{$contact.InformationAttribute.contact_method}" onpaste="Emailstr(this)" onkeyup="Emailstr(this)">
                    <button class="addContact">添加</button><button class="deleContact">删除</button>
                  </dt>
                {/foreach}
              {/if}
              <dt>
                    <label><font class="facexh">*</font>单位详细地址：</label>
                    <input type="text" id="address" class="address" name="address" value="{$info.Information.address}">
                  </dt>
              
              <dt>
                <label><font class="facexh">*</font>采购需求描述：</label>
                <textarea name="introduction" id="introduction" cols="45" rows="5">{$info.Information.introduction}</textarea>
              </dt>
              <dt>
                <label>预计合作金额:</label>
                <input type="text" name="profit" id="profit" value="{$info.Information.profit}" onpaste="coinNum(this)" onkeyup="coinNum(this)">
              </dt>
              <dt>
                <label>预计合作时间：</label>
                <input type="text" name="finished" id="finished" value="{$info.Information.finished}" readonly="readonly">
              </dt>
              <dt>
                <label>客户选择服务商因素：</label>
                <input type="text" name="reason" id="acpro_inp13" value="{$info.Information.reason}">
              </dt>
              <dt>
                <label>采购补充：</label>
                <textarea name="additional" id="caigouyunayin" cols="45" rows="5">{$info.Information.additional}</textarea>
              </dt>
            </dl>
            <input type="hidden" id="type" name="type" value="{$info.Information.type}">
            <input type="hidden" name="id" value="{$this->request->query.id}">
            <a class="zclan zclan4" href="javascript:void(0)" id="check">预览</a>
          </form>
      </div>
    </div>