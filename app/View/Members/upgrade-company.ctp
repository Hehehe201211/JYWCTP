<script type="text/javascript">
{literal}
$(document).ready(function(){
    datepIniChange("#established","EPbirth");    
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
        $('ul.products').html('');
        if ($(this).val() != "") {
		$('ul.products').parent().find(".errorMsg").remove();
            $.ajax({
                'type'  : 'Get',
                'url'   : '/informations/getCategoryList/' + $(this).val(),
                'success':function(data) {
                    var dataobj=eval("("+data+")");
                    var liStr = "";
                    $.each(dataobj, function(idx, item){
                        liStr += '<li><input type="checkbox" class="sub_category" name="service[]" value="' + item.Category.id + '" id="products' + item.Category.id + '"><label for="products' + item.Category.id + '">' + item.Category.name + '</label></li>'
                    });
                    $('ul.products').html(liStr);
                }
            });
        }
    });
	
	$('.zclan').click(function(){
		if (!checkData()) {
			$("#member_upgread").submit();
		}
	});
   var checkTarget = ['full_name', 'established', 
                'contact', 'fax',
                'provincial', 'city', 'address',
                'company_type', 'business_scope', 'products',
                'industries_id','license','vehicle','verificationCode'
                ];
   var errorMsg = '<span class="errorMsg">请完善此项目</span>'  

	function checkData() {
		var error=0;
		$(".sjle").find(".errorMsg").remove();
		$.each(checkTarget, function(target){
			if($('#' + this).val() == "") {
				$('#' + this).parents(".sjle ul li").append(errorMsg);
				error=1;
			} 
		});
		
		$('.contact_method').each(function(){
			if ($(this).val() == "") {
				$(this).parent().append(errorMsg);
				error=1;
			} 
		});		
		if($('#category').val() == "") {
		    $('#category').parents(".sjle ul li").append(errorMsg);
			error = 1;			
		} 
		if ($("input.sub_category:checked").length == 0){
        	$('.products').parent().append(errorMsg);
        	error = 1;
        }	
		if($('#vehicle').attr('checked') != "checked") {
		     $('.protocol').append('<span class="errorMsg">请接受协议内容</span>');
			error = 1
		} 
		$("input:file").each(function(index, element) {
            if ($(this).next().length==0&&$(this).val()=="") $(this).after('<span class="errorMsg">（文件大小不超过500K）</span>');
        });
		return error;
	}
    
    $("button.addContact").live("click",function(e){
        e.preventDefault();
        $(this).parent().after($(this).parent().clone());
        $(this).parent().next().children(".inpTextBox").val("");
    });
    $("button.deleContact").live("click",function(e){
        e.preventDefault();
        if ($("button.deleContact").length>1) $(this).parent().remove(); 
    });
    $("#codeAddress").click(function(){
        var a=document.getElementById("geostrPosition").value;
        strPosition.codeAddress(a);
    });        
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">账号管理</a>&gt;&gt;
      <a href="javascript:void(0)">企业会员升级</a>
      </p>      
    </div>
    <ul class="ulFormStep">
        <li>1.填写企业资料</li>
        <li>2.信息确认</li>
        <li>3.升级成功</li>
      </ul>    
     <div class="sjle">
       <form id="member_upgread" method="post" action="/members/upgradecheck" enctype="multipart/form-data">
        <input type="hidden" name="type" value="1">
        <ul>   
          <li>
            <label><font class="facexh">*</font>公司全名：</label>
            <input type="text" name="full_name" id="full_name"/>
          </li> 
          <li>
             <label><font class="facexh">*</font>成立时间：</label>
             <input type="text" name="established" id="established" readonly="readonly"/>
          </li>
          <li>
             <label><font class="facexh">*</font>联系人：</label>
             <input type="text" name="contact" id="contact"/>
          </li>      
          <li>
            <label><font class="facexh">*</font>联系方式：</label>
            <div class="area1">
              <select name="contact_method[]">
                <option value="座机">座机</option>
                <option value="手机">手机</option>
		<option value="E-mail">E-mail</option>
                <option value="QQ">Q Q</option>                
                <option value="MSN">MSN</option>
		<option value="Skype">Skype</option>
		<option value="其他">其他</option>
              </select>
            </div>
            <input type="text" style="width:128px;" name="contact_content[]" class="contact_method" onpaste="Emailstr(this)" onkeyup="Emailstr(this)">
            <button class="addContact fl">添加</button><button class="deleContact fl">删除</button>
          </li>  
          <li>
            <label><font class="facexh">*</font>传真：</label>
            <input type="text" name="fax" id="fax" onpaste="phoneNum(this)" onkeyup="phoneNum(this)"/>
          </li>
          <li>
            <label><font class="facexh">*</font>所在城市：</label>
            <select name="provincial_id" id="provincial">
                <option value="">请选择</option>
                {foreach $this->City->parentCityList() as $city}
                    <option value="{$city.City.id}">{$city.City.name}</option>
                {/foreach}
              </select>
            <select name="city_id" id="city">
                <option value="">请选择</option>
              </select>
          </li>
          <li>
            <label><font class="facexh">*</font>公司详细地址：</label>
            <input type="text" name="address" id="address">
          </li>
          <li>
            <label><font class="facexh">*</font>公司性质：</label>
            <select name="company_type" >
                <option value="民营/私营公司">民营/私营公司</option>
                <option value="外企代表处">外企代表处</option>
                <option value="外企代表处">事业单位</option>
                <option value="其他">其他</option>
                <option value="外资（欧美）">外资（欧美）</option>
                <option value="外资（非欧美如日资）">外资（非欧美如日资）</option>
                <option value="台资、港资">台资、港资</option>
                <option value="合资（欧美）">合资（欧美）</option>
                <option value="合资（非欧美）">合资（非欧美）</option>
                <option value="国营企业">国营企业</option>
                <option value="上市公司">上市公司</option>
                <option value="私营股份制">私营股份制</option>
              </select>
          </li>
          <li>
            <label><font class="facexh">*</font>从事行业：</label>
            <select name="category_id" id="category">
            <option value="">请选择</option>
            {foreach $this->Category->parentCategoryList() as $value}
                <option value="{$value.Category.id}">{$value.Category.name}</option>
            {/foreach}
            </select>
          </li>
          <li>
            <label>其他行业：</label>
            <input type="text">
          </li>
          <li>
            <label><font class="facexh">*</font>提供产品或服务：</label>
            <ul class="products">
            </ul>
          </li>
          <li>
            <label><font class="facexh">*</font>业务范围：</label>
            <textarea rows="5" cols="45" id="business_scope" name="business_scope"></textarea>
          </li>
          <li>
            <label><font class="facexh">*</font>上传企业营业执照：</label>
            <input name="face" type="file" id="license"/><span class="errorMsg">（文件大小不超过500K）</span>
          </li>
          <li>
            <label>上传企业Logo：</label>
            <input name="logo" type="file" id="logo"/><span class="errorMsg">（文件大小不超过500K）</span>
          </li>
          <li>
            <label><font class="facexh">*</font>验证码：</label>
            <input type="text" name="verificationCode" id="verificationCode" style="width:40px;" class="inpTextBox">
            <a href="#"><img class="imgYanzhengma" src="{$this->webroot}img/num_03.jpg">看不清楚？换一个</a> 
          </li>
          <li>
            <label for="vehicle" class="protocol">
              <input type="checkbox" name="vehicle" id="vehicle"/>
              我接受 <a href="/static?tpl=mianze" target="_blank">《聚业务服务协议（试行）》</a>
            </label>
          </li>
          <li><a class="zclan zclan4" href="javascript:void(0)">提交</a></li>
        </ul>
       </form>
    </div>
 </div>