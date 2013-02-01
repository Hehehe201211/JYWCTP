<script type="text/javascript">
{literal}
$(document).ready(function(){
    datepIniChange("#open","indate");
    datepIniChange("#close","indate");
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
                      $("#checkNum").parent().append('<span class="errorMsg">验证码不一致</span>');
                  }
              }
          });
        }
    });
    var checkTarget = ['title','post','company','number','contact','salary','require','checkNum', 'provincial', 'city', 'category', 'educated', 'continued'];
    var errorMsg = '<span style="color:red" class="errorMsg">请输入此项目</span>';    
    var dateEMsg = '<span style="color:red" class="errorMsg">请正确输入时间</span>';
    function checkData()    {
        var error=0;
        $(".sjle").find(".errorMsg").remove();
        $.each(checkTarget, function(target){
            if($('#' + this).val() == "") {
                $('#' + this).parent('dt').append(errorMsg);
                error=1;
            } 
        }); 
        $(".method_number").each(function(index) {
            if ($(this).val()=="") $(this).parent().append(errorMsg);
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
        if($('#vehicle:checked').length == 0) {
            $('#vehicle').parent().append("<span class='errorMsg'>请接受协议</span>");
            error=1;
        } 
        return error;
    }
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
            <a href="javascript:void(0)">常规招聘</a>&gt;&gt;
            <a href="javascript:void(0)">发布招聘需求</a>
        </p>
    </div>
    <div class="biaotit">发布招聘需求</div>
    <div class="sjle">
    <form id="fulltime" method="post" action="/fulltimes/check">
        <dl>
            <dt>
                <label><font class="facexh">*</font>信息标题：</label>
                <input type="text" id="title" name="title" value="{$fulltime.Fulltime.title}"/>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘职位：</label>
                <input type="text" id="post" name="post" value="{$fulltime.Fulltime.post}">
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘单位：</label>
                <input type="text" id="company" readonly="readonly" name="company" value="{$fulltime.Fulltime.company}"/>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘性质：</label>
                <div class="divSex jobNature">
                    <label><input type="radio" name="type" id="jobNatureF" class="inpRadio" {if $fulltime.Fulltime.type == "全职"} checked="checked" {/if} value="全职"/>全职</label>                    
                    <label><input type="radio" name="type" id="jobNatureP" class="inpRadio" {if $fulltime.Fulltime.type == "兼职"} checked="checked" {/if} value="兼职"/>兼职</label>                    
                    <label><input type="radio" name="type" id="jobNatureN" class="inpRadio" {if $fulltime.Fulltime.type == "不限"} checked="checked" {/if} value="不限"/>不限</label>
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>性别要求：</label>
                <div class="divSex jobNature">
                    <label> <input type="radio" name="sex" id="jobSexM" class="inpRadio" {if $fulltime.Fulltime.sex == 1} checked="checked" {/if} value="1"/>男</label>                    
                    <label><input type="radio" name="sex" id="jobSexF" class="inpRadio" {if $fulltime.Fulltime.sex == 2} checked="checked" {/if} value="2"/>女</label>                    
                    <label><input type="radio" name="sex" id="jobSexN" class="inpRadio" {if $fulltime.Fulltime.sex == 0} checked="checked" {/if} value="0"/>不限</label>
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>学历要求：</label>
                <select id="educated" name="educated">
                    <option {if $fulltime.Fulltime.educated == "0"}selected="selected"{/if} value="0">不限</option>
                    <option {if $fulltime.Fulltime.educated == "1"}selected="selected"{/if} value="1">小学以上</option>
                    <option {if $fulltime.Fulltime.educated == "2"}selected="selected"{/if} value="2">初中以上</option>
                    <option {if $fulltime.Fulltime.educated == "3"}selected="selected"{/if} value="3">高中以上</option>
                    <option {if $fulltime.Fulltime.educated == "4"}selected="selected"{/if} value="4">中专以上</option>
                    <option {if $fulltime.Fulltime.educated == "5"}selected="selected"{/if} value="5">大专以上</option>
                    <option {if $fulltime.Fulltime.educated == "6"}selected="selected"{/if} value="6">本科以上</option>
                    <option {if $fulltime.Fulltime.educated == "7"}selected="selected"{/if} value="7">硕士研究生以上</option>
                    <option {if $fulltime.Fulltime.educated == "8"}selected="selected"{/if} value="8">博士研究生以上</option>
                </select>
            </dt>
            <dt>
                <label><font class="facexh">*</font>工作经验：</label>
                    <select name="continued" id="continued">
                        <option value="0" {if $fulltime.Fulltime.continued == "0"}selected="selected"{/if}>不限</option>
                        <option value="1" {if $fulltime.Fulltime.continued == "1"}selected="selected"{/if}>1年以内</option>
                        <option value="2" {if $fulltime.Fulltime.continued == "2"}selected="selected"{/if}>1-2年</option>
                        <option value="3" {if $fulltime.Fulltime.continued == "3"}selected="selected"{/if}>2-3年</option>
                        <option value="4" {if $fulltime.Fulltime.continued == "4"}selected="selected"{/if}>3年以上</option>
                    </select>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘有效期：</label>
                <ul class="validity">
                    <li>
                    <input type="text" name="begin" id="open" value="{$fulltime.Fulltime.begin|date_format:"%Y-%m-%d"}" readonly="readonly"/>
                    </li>
                    <li style="width:36px;text-align:center">至</li>
                    <li>
                    <input type="text" name="end" id="close" value="{$fulltime.Fulltime.end|date_format:"%Y-%m-%d"}" readonly="readonly"/>
                    </li>
                </ul>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘人数：</label>
                <input style="width:85px;" type="text" id="number" name="number" value="{$fulltime.Fulltime.number}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)"/>
                &nbsp;人
            </dt>
            <dt>
                <label><font class="facexh">*</font>职位行业：</label>
                <select name="category" id="category">
                <option selected="selected" value="">请选择职位行业</option>
                {foreach $this->Category->parentCategoryList() as $value}
                    <option {if $fulltime.Fulltime.category == $value.Category.id}selected="selected"{/if} value="{$value.Category.id}">{$value.Category.name}</option>
                {/foreach}
            </select>
            </dt>
            <dt>
                <label><font class="facexh">*</font>工作城市：</label>
                    <select id="provincial" name="provincial">
                        <option value="">请选择省份</option>
                        {foreach $this->City->parentCityList() as $city}
                            <option value="{$city.City.id}" {if $fulltime.Fulltime.provincial == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
                        {/foreach}
                    </select>
                    <select id="city" name="city">
                        <option value="">请选择城市</option>
                        {foreach $this->City->childrenCityList($fulltime.Fulltime.provincial) as $city}
                            <option value="{$city.City.id}" {if $fulltime.Fulltime.city == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
                        {/foreach}
                    </select>
            </dt>
            <dt>
                <label><font class="facexh">*</font>联系人：</label>
                <input type="text" id="contact" name="contact" class="contact" value="{$fulltime.Fulltime.contact}" />
            </dt>
            {$contact_methods = json_decode($fulltime.Fulltime.contact_method, true)}
            {foreach $contact_methods as $key => $method}
            <dt>
                <label><font class="facexh">*</font>联系方式：</label>
                <div class="area1">
                    <select name="method[]">
                        <option value="座机" {if $method.method == "座机"}selected="selected"{/if}>座机</option>
                        <option value="手机" {if $method.method == "手机"}selected="selected"{/if}>手机</option>
                        <option value="E-mail" {if $method.method == "E-mail"}selected="selected"{/if}>E-mail</option>
                        <option value="QQ" {if $method.method == "QQ"}selected="selected"{/if}>QQ</option>
                        <option value="MSN" {if $method.method == "MSN"}selected="selected"{/if}>MSN</option>                       
                        <option value="Skype" {if $method.method == "Skype"}selected="selected"{/if}>Skype</option>
                        <option value="其他" {if $method.method == "其他"}selected="selected"{/if}>其他</option>
                    </select>
                </div>
                <input type="text" name="method_number[]" value="{$method.number}" style="width:108px;" onpaste="Emailstr(this)" onkeyup="Emailstr(this)" class="method_number"/>
                <button class="addContact" type="button">添加</button><button class="deleContact" type="button">删除</button>
            </dt>
            {/foreach}
            <dt>
                <label><font class="facexh">*</font>底薪：</label>
                <input type="text" id="salary" name="salary" value="{$fulltime.Fulltime.salary}">
            </dt>
            <dt>
                <label>待遇：</label>
                <input type="text" name="treatment" value="{$fulltime.Fulltime.treatment}" />
            </dt>
            <dt>
                <label><font class="facexh">*</font>职位要求：</label>
                <textarea cols="45" rows="5" name="require" id="require">{$fulltime.Fulltime.require}</textarea>
            </dt>
            <dt>
                <label>补充说明：</label>
                <textarea cols="45" rows="5" name="additional">{$fulltime.Fulltime.additional}</textarea>
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
                <input type="checkbox" id="vehicle" name="vehicle" class="inpCheckbox"/>我接受 <a href="/static?tpl=mianze" target="_blank">《聚业务服务协议（试行）》</a>
            </label>
        </div>
        <div class="clearfix"></div>
        <input type="hidden" value="{$this->request->query['id']}" name="id" />
        <a class="zclan zclan4" href="javascript:void(0)" id="check">提交</a>
    </form>
    </div>
</div>