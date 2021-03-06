<script>
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
    
    $('#category').change(function() {
        $('#sub_category').find('option:gt(0)').remove();
        if ($(this).val() != "") {
            $.ajax({
                'type'    : 'Get',
                'url'    : '/informations/getCategoryList/' + $(this).val(),
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
    datepIniChange("#finished","indate");    
    if ($('#parttime').val() != "") $(".payType").parent().hide();
    $('#check').click(function(){
        if (!checkData()) {
            $("#information").submit();
        }
    });
    var checkTarget = ['title', 'provincial', 
                        'industries_id', 'company', 'category', 
                        'sub_category',
                        'payment_type', 'introduction','profit','finished'
                        ];
    var errorMsg = '<span class="errorMsg">请输入此项目</span>'
    var re = /^[0-9]*$/;
    var intEMsg = '<span class="errorMsg">请输入数字</span>';
    var dateEMsg = '<span class="errorMsg">请正确输入时间</span>';
    function checkData()     {
        $(".sjle").find(".errorMsg").remove();
        var error=0;
        $.each(checkTarget, function(target){
            if($('#' + this).val() == "") {
                $('#' + this).parent('dt').append(errorMsg);
                error=1;
            } 
        });
        if ($('#city').val() == ""||$('#provincial').val() == "") {
            $('#city').parent('dt').append(errorMsg);
            error=1;
        } 
        if($('#open').val() == "" || $('#close').val() == ""||$('#open').val()>$('#close').val()) {
            $('#open,#close').parent().parent().append(errorMsg);
            error=1;
        }         
        $('.contact, .post, .address, .contact_method').each(function(){
            if ($(this).val() == "") {
                $(this).parent().append(errorMsg);
                error=1;
            } 
        });
        var priceErr = false;
        if ($('#type').val() == 0) {
            if($('#pay_coin').attr('checked') == "checked") {
                if ($('#price').val() == "") {
                    $('#price').parent().parent().append(errorMsg);                    
                    error = 1;
                    priceErr = true;
                } 
            }
            if(!priceErr && $('#pay_point').attr('checked') == "checked") {
                if ($('#point').val() == "") {
                    $('#point').parent().parent().append(errorMsg);
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
	  <div class="batch"><a href="javascript:;">批量发布</a></div>
      <form id="information" method="post" action="/informations/check{if !empty($target)}?target={$target}{/if}">
              <input type="hidden" id="parttime" name="parttime" value="{if !empty($parttime)}{$this->request->query['parttime']}{elseif isset($this->data['parttime'])}{$this->data['parttime']}{/if}">
              <input type="hidden" name="target" value="{if !empty($target)}{$target}{elseif isset($this->data['target'])}{$this->data['target']}{/if}">
              <input type="hidden" name="target_member" value="{if !empty($target_member)}{$target_member}{elseif isset($this->data['target_member'])}{$this->data['target_member']}{/if}">
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
                   {elseif isset($parttime)}
                       {foreach $this->Category->parentCategoryList() as $value}
                        <option value="{$value.Category.id}" {if $value.Category.id == $parttime.PartTime.category}selected="selected"{/if}>{$value.Category.name}</option>
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
                {elseif !empty($target) && isset($targetInfo)}
                    <select name="sub_category" id="sub_category">
                      <option value="">请选择</option>
                      {foreach $this->Category->childrenCategoryList($targetInfo.Information.category) as $value}
                          <option value="{$value.Category.id}" {if $value.Category.id == $targetInfo.Information.sub_category}selected="selected"{/if}>{$value.Category.name}</option>
                      {/foreach}
                    </select>
                {elseif isset($parttime)}
                    <select name="sub_category" id="sub_category">
                      <option value="">请选择</option>
                      {foreach $this->Category->childrenCategoryList($parttime.PartTime.category) as $value}
                        <option value="{$value.Category.id}" {if $value.Category.id == $parttime.PartTime.sub_category}selected="selected"{/if}>{$value.Category.name}</option>
                      {/foreach}
                    </select>
                {else}
                    <select name="sub_category" id="sub_category">
                      <option value="">请选择</option>
                    </select>
                {/if}
                <!--
                <input type="text" name="other_category" value="请输入产品名称" id="acpro_inp3">
                -->
              </dt>
              <dt>
                <label><font class="facexh">*</font>采购单位：</label>
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
                {elseif !empty($target) && isset($targetInfo)}
                    <select name="city" id="city">
                      <option value="">请选择城市</option>
                      {foreach $this->City->childrenCityList($targetInfo.Information.provincial) as $child}
                        <option value="{$child.City.id}" {if $child.City.id == $targetInfo.Information.city}selected="selected"{/if}>{$child.City.name}</option>
                      {/foreach}
                    </select>
                {else}
                    <select name="city" id="city">
                      <option value="">请选择城市</option>
                    </select>
                {/if}
              </dt>
              <dt>
                <label><font class="facexh">*</font>单位所属行业：</label>
                <select name="industries_id" id="industries_id">
                    <option value="">请选择行业</option>
                      {if !empty($target) && isset($targetInfo)}
                          {foreach $this->Category->parentCategoryList() as $value}
                              <option value="{$value.Category.id}" {if $value.Category.id == $targetInfo.Information.industries_id}selected="selected"{/if}>{$value.Category.name}</option>
                          {/foreach}
                      {elseif isset($parttime)}
                          {foreach $this->Category->parentCategoryList() as $value}
                            <option value="{$value.Category.id}" {if $value.Category.id == $parttime.PartTime.category}selected="selected"{/if}>{$value.Category.name}</option>
                        {/foreach}
                      {else}
                          {foreach $this->Category->parentCategoryList() as $value}
                               <option value="{$value.Category.id}" {if isset($this->data['industries_id']) && $value.Category.id == $this->data['industries_id']}selected="selected"{/if}>{$value.Category.name}</option>
                           {/foreach}
                       {/if}
                </select>
              </dt>                       
              <dt>
              <label><font class="facexh">*</font>客源有效期：</label>
              <ul class="validity">
                  <li>
                    <input type="text" name="open" id="open" value="{if !empty($target) && isset($targetInfo)}{$targetInfo.Information.open|date_format:"%Y-%m-%d"}{elseif isset($this->data['open'])}{$this->data['open']}{/if}" readonly="readonly"/>
                  </li>
                  <li style="width:36px;text-align:center;">至</li>
                  <li style="margin-right:8px;">
                    <input type="text" name="close" id="close" value="{if !empty($target) && isset($targetInfo)}{$targetInfo.Information.close|date_format:"%Y-%m-%d"}{elseif isset($this->data['close'])}{$this->data['close']}{/if}" readonly="readonly"/>
                  </li>
                </ul>
              </dt>
              {if !isset($this->data['type']) && isset($this->data['type']) == 0 || $type == 0}
              <dt>
                <label><font class="facexh">*</font>买家付款方式：</label>
                <ul class="payType">
                {if !empty($target) && isset($targetInfo) && ($targetInfo.Information.payment_type == 1 || $targetInfo.Information.payment_type == 3)}
                    <li>                    
                    <label><input type="checkbox" name="pay_coin" value="1" class="chkWidth15" id="pay_coin" checked="checked" />现金支付：</label>
                    <input type="text" name="price" id="price" class="text" value="{$targetInfo.Information.price}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)">
                    <span>元</span>
                    </li>
                {elseif isset($this->data['pay_coin']) && $this->data['pay_coin'] == 1}
                    <li>
                    <label><input type="checkbox" name="pay_coin" value="1" class="chkWidth15" id="pay_coin" checked="checked" />现金支付：</label>
                    <input type="text" name="price" id="price" class="text" value="{$this->data['price']}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)"/>
                    <span>元</span>
                    </li>
                {else}
                    <li>
                    <label><input type="checkbox" name="pay_coin" value="1" class="chkWidth15" id="pay_coin" checked="checked" />现金支付：</label>
                    <input type="text" name="price" id="price" class="text" value="" onpaste="onlyNum(this)" onkeyup="onlyNum(this)">
                    <span>元</span>
                    </li>
                {/if}                
                {if !empty($target) && isset($targetInfo) && ($targetInfo.Information.payment_type == 2 || $targetInfo.Information.payment_type == 3)}
                    <li>                    
                    <label><input type="checkbox" name="pay_point" value="1" class="chkWidth15" id="pay_point" checked="checked" />积分支付：</label>
                    <input type="text" name="point" id="point" class="text" value="{$targetInfo.Information.point}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)">
                    <span>分</span>
                     </li>
                {elseif isset($this->data['pay_point']) && $this->data['pay_point'] == 1}
                    <li>                    
                    <label><input type="checkbox" name="pay_point" value="1" class="chkWidth15" id="pay_point" checked="checked" />积分支付：</label>
                    <input type="text" name="point" id="point" class="text" value="{if isset($this->data['point'])}{$this->data['point']}{/if}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)">
                    <span>分</span>
                     </li>
                {else}
                    <li>                    
                    <label><input type="checkbox" name="pay_point" value="1" class="chkWidth15" id="pay_point" />积分支付：</label>
                    <input type="text" name="point" id="point" class="text" value="" onpaste="onlyNum(this)" onkeyup="onlyNum(this)">
                    <span>分</span>
                     </li>
                {/if}
                </ul>
              </dt>
              {/if}
              <dt>
                <label><font class="facexh">*</font>联系人：</label>
                <input type="text" name="contact" class="contact" id="acpro_inp9" value="{if isset($this->data['contact'])}{$this->data['contact']}{/if}">
              </dt>
              <dt>
                <label><font class="facexh">*</font>联系人职位：</label>
                <input type="text" name="post" class="post" id="acpro_inp10" value="{if isset($this->data['post'])}{$this->data['post']}{/if}">
              </dt>
              {if isset($this->data['mode'])}
                  {foreach $this->data['mode'] as $key => $contact}
                      <dt>
                    <label><font class="facexh">*</font>联系方式：</label>
                    <div class="area1">
                      <select name="mode[]">
                        <option value="座机" {if $contact == "座机"}selected="selected"{/if}>座机</option>
                        <option value="手机" {if $contact == "手机"}selected="selected"{/if}>手机</option>
                        <option value="E-mail" {if $contact == "E-mail"}selected="selected"{/if}>E-mail</option>
                        <option value="QQ" {if $contact == "QQ"}selected="selected"{/if}>QQ</option>
                        <option value="MSN" {if $contact == "MSN"}selected="selected"{/if}>MSN</option>
                        <option value="Skype" {if $contact == "Skype"}selected="selected"{/if}>Skype</option>
                        <option value="其他" {if $contact == "其他"}selected="selected"{/if}>其他</option>
                      </select>
                    </div>
                    <input type="text" style="width:108px;" name="contact_method[]" class="contact_method" value="{$this->data['contact_method'][$key]}" onpaste="Emailstr(this)" onkeyup="Emailstr(this)">
                    <button class="addContact">添加</button><button class="deleContact">删除</button>
                  </dt>
                  {/foreach}
              {else}
              <dt>
                <label><font class="facexh">*</font>联系方式：</label>
                <div class="area1">
                  <select name="mode[]">
                   <option value="座机">座机</option>
                <option value="手机">手机</option>
        <option value="E-mail">E-mail</option>
                <option value="QQ">Q Q</option>                
                <option value="MSN">MSN</option>
        <option value="Skype">Skype</option>
        <option value="其他">其他</option>
                  </select>
                </div>
                <input type="text" style="width:108px;" name="contact_method[]" class="contact_method" onpaste="Emailstr(this)" onkeyup="Emailstr(this)">
                <button class="addContact" type="button">添加</button><button class="deleContact" type="button">删除</button>
              </dt>
              {/if}
              <dt>
                    <label><font class="facexh">*</font>单位详细地址：</label>
                    <input type="text" id="address" class="address" name="address" value="{if isset($this->data['address'])}{$this->data['address']}{/if}">
                  </dt>
              <dt>
                <label><font class="facexh">*</font>采购需求描述：</label>
                <textarea name="introduction" id="introduction" cols="45" rows="5">{if isset($this->data['introduction'])}{$this->data['introduction']}{/if}</textarea>
              </dt>
              <dt>
                <label><font class="facexh">*</font>预计合作金额：</label>
                <input type="text" name="profit" id="profit" value="{if isset($this->data['profit'])}{$this->data['profit']}{/if}" onpaste="coinNum(this)" onkeyup="coinNum(this)">
              </dt>
              <dt>
                <label><font class="facexh">*</font>预计合作时间：</label>
                <input type="text" name="finished" id="finished" value="{if isset($this->data['finished'])}{$this->data['finished']}{/if}" readonly="readonly">
              </dt>
              <dt>
                <label>客户选择服务商因素：</label>
                <input type="text" name="reason" id="acpro_inp13" value="{if isset($this->data['reason'])}{$this->data['reason']}{/if}">
              </dt>
              <dt>
                <label>采购补充：</label>
                <textarea name="additional" id="caigouyunayin" cols="45" rows="5">{if isset($this->data['additional'])}{$this->data['additional']}{/if}</textarea>
              </dt>
            </dl>
            {if isset($this->data['type'])}
            <input type="hidden" name="type" value="{$this->data['type']}">
            {else}
            <input type="hidden" name="type" value="{$type}">
            {/if}
            <input type="hidden" name="id" value="{if isset($this->data['id'])}{$this->data['id']}{/if}" />
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