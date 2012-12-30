<script type="text/javascript">
{literal}
$(document).ready(function(){
    //check number
    $('#checkNum').after('<img id="code" src="/members/image">');
    $('#captcha').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
    
    $('#provincial').change(function(){
        if ($(this).val() != "") {
            $.ajax({
                'type' : 'Get',
                'url'  : '/informations/getCityList/' + $(this).val(),
                'success':function(data){
                    var dataobj=eval("("+data+")");
                    $('#city').find('option').remove();
                    var optionStr = "";
                    $.each(dataobj, function(idx, item){
                        optionStr += '<option value="'+item.City.id+'">' + item.City.name + '</option>'
                    });
                    $('#city').append(optionStr);
                }
            })
        }
    });
    
    
    datepIniChange("#open","indate");
	datepIniChange("#close","indate");
	
	$("button.addContact").live("click",function(e){
		e.preventDefault();
		$(this).parent().after($(this).parent().clone());
		$(this).parent().next().children(".inpTextBox").val("");
	});
	$("button.deleContact").live("click",function(e){
		e.preventDefault();
		if ($("button.deleContact").length>1) $(this).parent().remove(); 
	});
  
    $('#check').click(function(){
		if (!checkData()) {
		  $.ajax({
              url : '/members/getImageNumber',
              type : 'post',
              success : function(data)
              {
                  if (data == $("#checkNum").val().toUpperCase()) {
                      $("#fulltime").submit();
                  } else {
                      if ($("#checkNum").parent().find('.errorMsg').length == 0) {
                          $("#checkNum").parent().append('<span class="errorMsg">验证码不一致</span>');
                      } else {
                          $("#checkNum").parent().find('.errorMsg').html('验证码不一致');
                      }
                  }
              }
          });
		}
	});
	var checkTarget = ['title','post','company','number','contact','salary','require','checkNum', 'provincial', 'city', 'category', 'educated', 'continued'];
	var errorMsg = '<span style="color:red" class="errorMsg">请输入此项目</span>';	
	var dateEMsg = '<span style="color:red" class="errorMsg">请正确输入时间</span>';
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
			$('#open').parent().parent().append(errorMsg);
			error=1;
		} else if($('#open').val() != "" && $('#close').val() != "") {			
			if ($('#close').val() < $('#open').val()) {
			     $('#open').parent().parent().append(dateEMsg);
                 error=1;
			} else {
				$('#open').parent().parent().find('.errorMsg').remove();
			}
		}
		
		if($('#vehicle:checked').length == 0) {
			if($('#vehicle').parent().find('.errorMsg').length == 0) {
			    $('#vehicle').parent().append("<span class='errorMsg'>请接受协议</span>");
			}
			error=1;
		} else {
			$('#vehicle').parent().find('.errorMsg').remove();
		}		
		return error;
	}
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;
            <a href="qy-jzfbmx.html">常规招聘</a>&gt;&gt;
            <a href="#">发布招聘需求</a>
        </p>
    </div>
    <div class="biaotit">发布招聘需求</div>
    <div class="sjle">
    <form id="fulltime" method="post" action="/fulltimes/check">
        <dl>
            <dt>
                <label><font class="facexh">*</font>信息标题：</label>
                <input type="text" id="title" name="title" value="{if isset($this->data['title'])}{$this->data['title']}{/if}"/>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘职位：</label>
                <input type="text" id="post" name="post" value="{if isset($this->data['post'])}{$this->data['post']}{/if}">
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘单位：</label>
                <input type="text" id="company" readonly="readonly" name="company" value="{if isset($this->data['company'])}{$this->data['company']}{else}{$memberInfo.Member.company_name}{/if}"/>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘性质：</label>
                <div class="divSex jobNature">
                {if isset($this->data['type'])}                    
                    <label><input type="radio" name="type" id="jobNatureF" class="inpRadio" {if $this->data['type'] == "全职"} checked="checked" {/if} value="全职"/>全职</label>                    
                    <label><input type="radio" name="type" id="jobNatureP" class="inpRadio" {if $this->data['type'] == "兼职"} checked="checked" {/if} value="兼职"/>兼职</label>                    
                    <label><input type="radio" name="type" id="jobNatureN" class="inpRadio" {if $this->data['type'] == "不限"} checked="checked" {/if} value="不限"/>不限</label>
                {else}                    
                    <label><input type="radio" name="type" id="jobNatureF" class="inpRadio" checked="checked" value="全职"/>全职</label>                    
                    <label><input type="radio" name="type" id="jobNatureP" class="inpRadio" value="兼职"/>兼职</label>                    
                    <label><input type="radio" name="type" id="jobNatureN" class="inpRadio" value="不限"/>不限</label>
                {/if}
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>性别要求：</label>
                <div class="divSex jobNature">
                {if isset($this->data['sex'])}                   
                    <label> <input type="radio" name="sex" id="jobSexM" class="inpRadio" {if $this->data['type'] == "1"} checked="checked" {/if} value="1"/>男</label>                    
                    <label><input type="radio" name="sex" id="jobSexF" class="inpRadio" {if $this->data['type'] == "2"} checked="checked" {/if} value="2"/>女</label>                    
                    <label><input type="radio" name="sex" id="jobSexN" class="inpRadio" {if $this->data['type'] == "0"} checked="checked" {/if} value="0"/>不限</label>
                {else}                    
                    <label><input type="radio" name="sex" id="jobSexM" class="inpRadio" value="1"/>男</label>                    
                    <label><input type="radio" name="sex" id="jobSexF" class="inpRadio" value="2"/>女</label>                    
                    <label><input type="radio" name="sex" id="jobSexN" class="inpRadio" checked="checked" value="0"/>不限</label>
                {/if}
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>学历要求：</label>
                <div class="area1">
                {if isset($this->data['educated'])}
                <select id="educated" name="educated">
                    <option {if $this->data['educated'] == "0"}selected="selected"{/if} value="0">不限</option>
                    <option {if $this->data['educated'] == "1"}selected="selected"{/if} value="1">小学以上</option>
                    <option {if $this->data['educated'] == "2"}selected="selected"{/if} value="2">初中以上</option>
                    <option {if $this->data['educated'] == "3"}selected="selected"{/if} value="3">高中以上</option>
                    <option {if $this->data['educated'] == "4"}selected="selected"{/if} value="4">中专以上</option>
                    <option {if $this->data['educated'] == "5"}selected="selected"{/if} value="5">大专以上</option>
                    <option {if $this->data['educated'] == "6"}selected="selected"{/if} value="6">本科以上</option>
                    <option {if $this->data['educated'] == "7"}selected="selected"{/if} value="7">硕士研究生以上</option>
                    <option {if $this->data['educated'] == "8"}selected="selected"{/if} value="8">博士研究生以上</option>
                </select>
                {else}
                <select id="educated" name="educated">
                    <option value="0">不限</option>
                    <option value="1">小学以上</option>
                    <option value="2">初中以上</option>
                    <option value="3">高中以上</option>
                    <option value="4">中专以上</option>
                    <option value="5">大专以上</option>
                    <option value="6">本科以上</option>
                    <option value="7">硕士研究生以上</option>
                    <option value="8">博士研究生以上</option>
                </select>
                {/if}
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>工作经验：</label>
                <div class="area1">
                {if isset($this->data['continued'])}
                    <select name="continued" id="continued">
                        <option value="0" {if $this->data['continued'] == "0"}selected="selected"{/if}>不限</option>
                        <option value="1" {if $this->data['continued'] == "1"}selected="selected"{/if}>1年以内</option>
                        <option value="2" {if $this->data['continued'] == "2"}selected="selected"{/if}>1-2年</option>
                        <option value="3" {if $this->data['continued'] == "3"}selected="selected"{/if}>2-3年</option>
                        <option value="4" {if $this->data['continued'] == "4"}selected="selected"{/if}>3年以上</option>
                    </select>
                {else}
                    <select name="continued" id="continued">
                        <option value="0" selected="selected">不限</option>
                        <option value="1">1年以内</option>
                        <option value="2">1-2年</option>
                        <option value="3">2-3年</option>
                        <option value="4">3年以上</option>
                    </select>
                {/if}
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘有效期：</label>
                <ul class="validity">
                    <li>
                    <input type="text" name="begin" id="open" value="{if isset($this->data['begin'])}{$this->data['begin']}{/if}" readonly="readonly"/>
                    </li>
                    <li style="width:36px;text-align:center">至</li>
                    <li>
                    <input type="text" name="end" id="close" value="{if isset($this->data['end'])}{$this->data['end']}{/if}" readonly="readonly"/>
                    </li>
                </ul>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘人数：</label>
                <input style="width:85px;" type="text" id="number" name="number" value="{if isset($this->data['number'])}{$this->data['number']}{/if}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)"/>
                &nbsp;人
            </dt>
            <dt>
                <label><font class="facexh">*</font>职位行业：</label>
                <select name="category" id="category">
                <option selected="selected" value="">请选择职位行业</option>
                {if isset($this->data['category'])}
                {foreach $this->Category->parentCategoryList() as $value}
                    <option {if $this->data['category'] == $value.Category.id}selected="selected"{/if} value="{$value.Category.id}">{$value.Category.name}</option>
                {/foreach}
                {else}
                {foreach $this->Category->parentCategoryList() as $value}
                    <option value="{$value.Category.id}">{$value.Category.name}</option>
                {/foreach}
                {/if}
            </select>
            </dt>
            <dt>
                <label><font class="facexh">*</font>工作城市：</label>
                {if isset($this->data['provincial'])}
                    <select id="provincial" name="provincial" class="sel2211">
                        <option value="">请选择</option>
                        {foreach $this->City->parentCityList() as $city}
                            <option value="{$city.City.id}" {if $this->data['provincial'] == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
                        {/foreach}
                    </select>&nbsp;
                    <select id="city" name="city" class="sel2211" style="float:none">
                        <option value="">请选择</option>
                        {foreach $this->City->childrenCityList($this->data['provincial']) as $city}
                            <option value="{$city.City.id}" {if $this->data['city'] == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
                        {/foreach}
                    </select>
                {else}
                    <select id="provincial" name="provincial" class="sel2211">
                        <option selected="selected" value="">请选择</option>
                        {foreach $this->City->parentCityList() as $city}
                            <option value="{$city.City.id}">{$city.City.name}</option>
                        {/foreach}
                    </select>&nbsp;
                    <select id="city" name="city" class="sel2211" style="float:none">
                        <option selected="selected" value="">请选择</option>
                    </select>
                {/if}
            </dt>
            <dt>
                <label><font class="facexh">*</font>联系人：</label>
                <input type="text" id="contact" name="contact" class="contact" value="{if isset($this->data['contact'])}{$this->data['contact']}{/if}" />
            </dt>
            {if isset($this->data['method'])}
            {foreach $this->data['method'] as $key => $method}
            <dt>
                <label>联系方式：</label>
                <div class="area1">
                    <select name="method[]">
                        <option value="座机" {if $method == "座机"}selected="selected"{/if}>座机</option>
                        <option value="手机" {if $method == "手机"}selected="selected"{/if}>手机</option>
                        <option value="QQ" {if $method == "QQ"}selected="selected"{/if}>QQ</option>
                        <option value="MSN" {if $method == "MSN"}selected="selected"{/if}>MSN</option>
                        <option value="E-mail" {if $method == "E-mail"}selected="selected"{/if}>E-mail</option>
                    </select>
                </div>
                <input type="text" name="method_number[]" value="{$this->data['method_number'][$key]}" style="width:108px;" onpaste="Emailstr(this)" onkeyup="Emailstr(this)" />
                <button class="addContact" type="button">添加</button><button class="deleContact" type="button">删除</button>
            </dt>
            {/foreach}
            {else}
            <dt>
                <label>联系方式：</label>
                <div class="area1">
                    <select name="method[]">
                        <option value="座机">座机</option>
                        <option value="手机">手机</option>
                        <option value="QQ">QQ</option>
                        <option value="MSN">MSN</option>
                        <option value="E-mail">E-mail</option>
                    </select>
                </div>
                <input type="text" name="method_number[]" style="width:108px;" onpaste="Emailstr(this)" onkeyup="Emailstr(this)" />
                <button class="addContact">添加</button><button class="deleContact">删除</button>
            </dt>
            {/if}                      
            <!--<dt>
                <label>联系邮箱：</label>
                <input type="text" name="email" class="post" value="{if isset($this->data['email'])}{$this->data['email']}{/if}" />（如果有多个邮箱，请以","隔开）
            </dt>-->
			<dt>
                <label><font class="facexh">*</font>底薪：</label>
                <input type="text" id="salary" name="salary" value="{if isset($this->data['salary'])}{$this->data['salary']}{/if}">
            </dt>
            <dt>
                <label>待遇：</label>
                <input type="text" name="treatment" value="{if isset($this->data['treatment'])}{$this->data['treatment']}{/if}" />
            </dt>
            <dt>
                <label><font class="facexh">*</font>职位要求：</label>
                <textarea cols="45" rows="5" name="require">{if isset($this->data['require'])}{$this->data['require']}{/if}</textarea>
            </dt>
            <dt>
                <label>补充说明：</label>
                <textarea cols="45" rows="5" name="additional">{if isset($this->data['additional'])}{$this->data['additional']}{/if}</textarea>
            </dt>
            <dt>
                <label><font class="facexh">*</font>验证码：</label>
                <input type="text" name="checkNum" style="width:60px;" id="checkNum" onpaste="letterNum(this)" onkeyup="letterNum(this)"/>
                <a id="captcha" href="javascript:void(0);">看不清楚？换一个</a>   
            </dt>            
        </dl>
        <div class="clearfix"></div>
        <div class="divProtocol">
            <label class="protocol" for="vehicle">
                <input type="checkbox" id="vehicle" name="vehicle" class="inpCheckbox"/>我接受 <a href="#" target="_blank">《聚业务服务协议（试行）》</a>
            </label>
        </div>
		<div class="clearfix"></div>
        <a class="zclan zclan4" href="javascript:void(0)" id="check">提交</a>
    </form>
    </div>
</div>