<script type="text/javascript">
{literal}
$(document).ready(function(){
	datepIniChange("#eduBegin","Eindate");
	datepIniChange("#eduEnd","Eindate");
	datepIniChange("#workBegin","Eindate");
	datepIniChange("#workEnd","Eindate");
	datepIniChange("#workTime","Eindate");
    
    $(".divExpect .addOpts").click(function(){
	    $(this).parent().find('.errorMsg').remove();
        var selOpts=$(this).parent().parent().find(".selOpts option:selected");
        var seledOpts=$(this).parent().parent().find(".seledOpts");
        for (i=0;i<selOpts.length;i++) {
            if (seledOpts.find("option").length==0) {
                seledOpts.append(selOpts.eq(i).clone());
            } else if (seledOpts.find("option").length>2) {
				alert("你选择已超过3项。");
				break;
			} else {
                for (j=0;j<seledOpts.find("option").length;j++) {
                    if (selOpts.eq(i).val()==seledOpts.find("option").eq(j).val()){
                        break;
                    } else if (j==(seledOpts.find("option").length-1)) {
                        seledOpts.append(selOpts.eq(i).clone());
                    }
                }
            }
        }
    });
    $(".divExpect .removeOpts").click(function(){
        $(this).parent().parent().find(".seledOpts option:selected").remove();
    });
    
    $('#provincial').change(function(){
        if ($(this).val() != "") {
            $.ajax({
                'type' : 'Get',
                'url'  : '/informations/getCityList/' + $(this).val(),
                'success':function(data){
                    var dataobj=eval("("+data+")");
                    $('#city_id').find('option').remove();
                    var optionStr = "";
                    $.each(dataobj, function(idx, item){
                        optionStr += '<option value="'+item.City.id+'">' + item.City.name + '</option>'
                    });
                    $('#city_id').append(optionStr);
                }
            })
        }
    });
	
	if ($(".ckbWork").attr("checked")=="checked") $(this).parent().next().slideDown();
	else $(".ckbWork").parent().next().slideUp();
	$(".ckbWork").click(function(){
		if ($(this).attr("checked")=="checked") $(this).parent().next().slideDown();
		else $(this).parent().next().slideUp();
	});
    
	var checkTarget = ['title', 'school','discipline','educated','evaluation','intention','salary','workTime'];
	var errorMsg = '<span class="errorMsg">请输入此项目</span>';
	var dateEMsg = '<span class="errorMsg">请正确输入时间</span>';
	var optEMsg = '<span class="errorMsg">请选择期望选项</span>';
    $('#check').click(function(){
		$(".sjle").find(".errorMsg").remove();
        var error=0;		
		$.each(checkTarget, function(target){
			if($('#' + this).val() == "") {
				$('#' + this).parent().append(errorMsg);
				error=1;
			} 
		});
		if($('#eduBegin').val() == "" || $('#eduEnd').val() == "") {
			$('#eduBegin').parent().parent().append(dateEMsg);
			error=1;
		} else if($('#eduBegin').val() != "" && $('#eduEnd').val() != "") {			
			if ($('#eduBegin').val() > $('#eduEnd').val()) {
			     $('#eduBegin').parent().parent().append(dateEMsg);
                 error=1;
			}
		} 		
		if($('#workBegin').val() != "" || $('#workEnd').val() != "") {			
			if (($('#workBegin').val() == "" && $('#workEnd').val() !="") || ($('#workBegin').val() > $('#workEnd').val())) {
			     $('#workBegin').parent().parent().append(dateEMsg);
                 error=1;
			} 
		} 
			
		if($("#category_contain option").length==0) {
			$('#category_contain').prev().append(optEMsg);
			error=1;
		} 	
		if($("#city_contain option").length==0) {
			$('#city_contain').prev().append(optEMsg);
			error=1;
		} 		
		if ($(".ckbWork").attr("checked")=="checked") {
			var checkTargetW = ['company','work_category','post','service','department','responsiblly','wrok_salary','reason'];
			$.each(checkTargetW, function(target){
				if($('#' + this).val() == "") {
					$('#' + this).parent().append(errorMsg);
					error=1;
				} 
		    });
			if($('#workBegin').val() == "" || $('#workEnd').val() == "") {
			$('#workBegin').parent().parent().append(dateEMsg);
			error=1;
			} else if($('#workBegin').val() != "" && $('#workEnd').val() != "") {			
				if ($('#workBegin').val() > $('#workEnd').val()) {
					 $('#workBegin').parent().parent().append(dateEMsg);
					 error=1;
				}
			} 
		}
		
		if (!error) {
		  var category = [];
		  var city = [];
		  $('#category_contain option').each(function(){
		      category.push($(this).val());
		  });
		  $('#city_contain option').each(function(){
              city.push($(this).val());
          });
          $('#category').val(category.join(','));
          $('#city').val(city.join(','));
            $('#resume').submit();
        }	
    });
});
{/literal}
</script>

<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="new-hyzy.html">我的聚业务</a>&gt;&gt;
            <a href="new-sddsx.html">简历管理</a>&gt;&gt;
            <a href="#">填写简历</a>
        </p>
    </div>
		<ul class="ulFormStep">
      <li>1.填写简历信息</li>
      <li>2.确认信息</li>
      <li>3.新增成功</li>
    </ul> 
    <div class="sjle" style="margin:8px 0 0 18px;">
        <form method="post" action="/resumes/check" id="resume">
        <dl>
            <dt>
                <label><font class="facexh">*</font>简历标题：</label>
                <input type="text" id="title" name="title" value="{if isset($this->data['title'])}{$this->data['title']}{/if}">
            </dt>
        </dl>
        <div class="biaotit">教育经历（请填写您最主要一次经历）</div>
        <dl>
            <dt>
                <label><font class="facexh">*</font>就学起讫时间：</label>
                <ul class="validity">
                    <li>
                    <input type="text" id="eduBegin" name="edu_begin" readonly="readonly" value="{if isset($this->data['edu_begin'])}{$this->data['edu_begin']}{/if}"/>
                    </li>
                    <li style="width:36px;text-align:center;">至</li>
                    <li>
                    <input type="text" id="eduEnd" name="edu_end" readonly="readonly" value="{if isset($this->data['edu_end'])}{$this->data['edu_end']}{/if}"/>
                    </li>
                </ul>
            </dt>
            <dt>
                <label><font class="facexh">*</font>就读院校名称：</label>
                <input type="text" name="school" id="school" value="{if isset($this->data['school'])}{$this->data['school']}{/if}">
            </dt>
            <dt>
                <label><font class="facexh">*</font>专业类：</label>
                <input type="text" name="discipline" id="discipline" value="{if isset($this->data['discipline'])}{$this->data['discipline']}{/if}">
            </dt>
            <dt class="productKinds">
                <label><font class="facexh">*</font>专业学历：</label>
                {if isset($this->data['educated'])}
                <select id="educated" name="educated">
                    <option selected="selected" value="">请选择专业学历</option>
                    <option {if $this->data['educated'] == "0"}selected="selected"{/if} value="0">无</option>
                    <option {if $this->data['educated'] == "1"}selected="selected"{/if} value="1">小学</option>
                    <option {if $this->data['educated'] == "2"}selected="selected"{/if} value="2">初中</option>
                    <option {if $this->data['educated'] == "3"}selected="selected"{/if} value="3">高中</option>
                    <option {if $this->data['educated'] == "4"}selected="selected"{/if} value="4">中专</option>
                    <option {if $this->data['educated'] == "5"}selected="selected"{/if} value="5">大专</option>
                    <option {if $this->data['educated'] == "6"}selected="selected"{/if} value="6">本科</option>
                    <option {if $this->data['educated'] == "7"}selected="selected"{/if} value="7">硕士研究生</option>
                    <option {if $this->data['educated'] == "8"}selected="selected"{/if} value="8">博士研究生</option>
                </select>
                {else}
                <select id="educated" name="educated">
                    <option selected="selected" value="">请选择专业学历</option>
                    <option value="0">无</option>
                    <option value="1">小学</option>
                    <option value="2">初中</option>
                    <option value="3">高中</option>
                    <option value="4">中专</option>
                    <option value="5">大专</option>
                    <option value="6">本科</option>
                    <option value="7">硕士研究生</option>
                    <option value="8">博士研究生</option>
                </select>
                {/if}
            </dt>
            <dt class="productKinds">
                <label>就学形式：</label>
                {if isset($this->data['school_type'])}
                <select name="school_type" id="school_type">
                    <option value="">请选择就学形式</option>
                    <option {if $this->data['school_type'] == "全日制重点大学"}selected="selected"{/if} value="全日制重点大学">全日制重点大学</option>
                    <option {if $this->data['school_type'] == "全日制普通高校"}selected="selected"{/if} value="全日制普通高校">全日制普通高校</option>
                    <option {if $this->data['school_type'] == "自学考试"}selected="selected"{/if} value="自学考试">自学考试</option>
                    <option {if $this->data['school_type'] == "成人大学"}selected="selected"{/if} value="成人大学">成人大学</option>
                    <option {if $this->data['school_type'] == "电视大学"}selected="selected"{/if} value="电视大学">电视大学</option>
                    <option {if $this->data['school_type'] == "网络大学"}selected="selected"{/if} value="网络大学">网络大学</option>
                    <option {if $this->data['school_type'] == "函授大学"}selected="selected"{/if} value="函授大学">函授大学</option>
                    <option {if $this->data['school_type'] == "夜大"}selected="selected"{/if} value="夜大">夜大</option>
                    <option {if $this->data['school_type'] == "职业大学"}selected="selected"{/if} value="职业大学">职业大学</option>
                    <option {if $this->data['school_type'] == "其他"}selected="selected"{/if} value="其他">其他</option>
                </select>
                {else}
                <select name="school_type" id="school_type">
                    <option selected="selected" value="">请选择就学形式</option>
                    <option value="全日制重点大学">全日制重点大学</option>
                    <option value="全日制普通高校">全日制普通高校</option>
                    <option value="自学考试">自学考试</option>
                    <option value="成人大学">成人大学</option>
                    <option value="电视大学">电视大学</option>
                    <option value="网络大学">网络大学</option>
                    <option value="函授大学">函授大学</option>
                    <option value="夜大">夜大</option>
                    <option value="职业大学">职业大学</option>
                    <option value="其他">其他</option>
                </select>
                {/if}
            </dt>
        </dl>
        <div class="biaotit">
            <input type="checkbox" class="ckbWork" name="has_worked" value="1" {if isset($this->request->data['has_worked']) && $this->request->data['has_worked'] == 1}checked="checked" {/if}/>工作经历（请填写您最主要一次经历）
        </div>  
          <dl>
          <dt>
            <label><font class="facexh">*</font>就职起讫时间：</label>
            <ul class="validity">
              <li>
                <input type="text" id="workBegin" name="work_begin" readonly="readonly" value="{if isset($this->data['work_begin'])}{$this->data['work_begin']}{/if}"/>
              </li>
              <li style="width:36px;text-align:center;">至</li>
              <li>
                <input type="text" id="workEnd" name="work_end" readonly="readonly" value="{if isset($this->data['work_end'])}{$this->data['work_end']}{/if}"/>
              </li>
            </ul>
          </dt>
          <dt>
            <label><font class="facexh">*</font>就职单位：</label>
            <input type="text" id="company" name="company" class="contact" value="{if isset($this->data['company'])}{$this->data['company']}{/if}" />
          </dt>
          <dt class="productKinds">
            <label><font class="facexh">*</font>就职单位行业：</label>
            <select id="work_category" name="work_category">
                <option selected="selected" value="">请选择就职公司所属行业</option>
                {if isset($this->data['work_category'])}
                {foreach $this->Category->parentCategoryList() as $value}
                    <option {if $this->data['work_category'] == $value.Category.id}selected="selected"{/if} value="{$value.Category.id}">{$value.Category.name}</option>
                {/foreach}
                {else}
                {foreach $this->Category->parentCategoryList() as $value}
                    <option value="{$value.Category.id}">{$value.Category.name}</option>
                {/foreach}
                {/if}
            </select>
          </dt>
          <dt>
            <label><font class="facexh">*</font>就职部门：</label>
            <input type="text" name="department" id="department" class="contact" value="{if isset($this->data['department'])}{$this->data['department']}{/if}" />
          </dt>
          <dt>
            <label><font class="facexh">*</font>就职职位：</label>
            <input type="text" id="post" name="post" class="contact" value="{if isset($this->data['post'])}{$this->data['post']}{/if}" />
          </dt>
          <dt>
            <label><font class="facexh">*</font>从事产品或服务：</label>
            <input type="text" id="service" name="service" class="contact" value="{if isset($this->data['service'])}{$this->data['service']}{/if}" />
          </dt>
          <dt>
            <label><font class="facexh">*</font>工作职责：</label>
            <textarea cols="45" rows="5" name="responsiblly" id="responsiblly">{if isset($this->data['responsiblly'])}{$this->data['responsiblly']}{/if}</textarea>
          </dt>
          <dt>
            <label><font class="facexh">*</font>职位待遇：</label>
            <input type="text" name="wrok_salary" id="wrok_salary" class="contact" value="{if isset($this->data['wrok_salary'])}{$this->data['wrok_salary']}{/if}" />
          </dt>
          <dt>
            <label><font class="facexh">*</font>离职原因：</label>
            <textarea cols="45" rows="5" name="reason" id="reason">{if isset($this->data['reason'])}{$this->data['reason']}{/if}</textarea>
          </dt>
        </dl>      
        <div class="biaotit">求职方向</div>
        <dl>
          <dt>
            <label><font class="facexh">*</font>自我评价：</label>
            <textarea cols="45" rows="5" id="evaluation" name="evaluation">{if isset($this->data['evaluation'])}{$this->data['evaluation']}{/if}</textarea>
          </dt>
          <dt>
            <label><font class="facexh">*</font>期望工作性质：</label>
            <div class="divSex">              
              <label><input type="radio" name="nature" value="全职" class="inpRadio" {if isset($this->data['nature']) && $this->data['nature'] == "全职"} checked="checked"{elseif !isset($this->data['nature'])}checked="checked"{/if}/>全职</label>              
              <label><input type="radio" name="nature" value="兼职" {if isset($this->data['nature']) && $this->data['nature'] == "兼职"} checked="checked"{/if} class="inpRadio"/>兼职</label>             
              <label> <input type="radio" name="nature" value="不限" {if isset($this->data['nature']) && $this->data['nature'] == "不限"} checked="checked"{/if} class="inpRadio"/>不限</label>
            </div>
          </dt>
          <dt>
            <label><font class="facexh">*</font>意向职位：</label>
            <input type="text" id="intention" name="intention" class="contact" value="{if isset($this->data['intention'])}{$this->data['intention']}{/if}" />
            &nbsp;（限20个字） </dt>
          <dt>
            <label><font class="facexh">*</font>期望从事行业：</label>
            <div class="divExpect">
                <select class="selOpts sel121" size="10" multiple="multiple" style="float:left">
                    {foreach $this->Category->parentCategoryList() as $value}
                        <option value="{$value.Category.id}">{$value.Category.name}</option>
                    {/foreach}
                </select>
              <div class="div2">
                <input type="button" class="inpButton addOpts" value="添加 >>"/>
                <input type="button" class="inpButton removeOpts" value="<< 移除"/>
              </div>
              <select class="seledOpts sel121" id="category_contain" size="10" multiple="multiple">
              {if isset($this->data['category'])}
                    {$categories = explode(',', $this->data['category'])}
                    {foreach $categories as $id}
                        <option value="{$id}">{$this->Category->getCategoryName($id)}</option>
                    {/foreach}
              {elseif isset($this->request->query['cid'])}
                <option value="{$this->request->query['cid']}">{$this->Category->getCategoryName($this->request->query['cid'])}</option>
              {/if}
              </select>
              <input type="hidden" name="category" id="category">
            </div>
          </dt>
          <dt>
            <label><font class="facexh">*</font>期望工作地点：</label>
            <div class="divExpect">
              <div class="div1">
                    <select id="provincial" name="provincial" class="sel2211">
                        {foreach $this->City->parentCityList() as $city}
                            <option value="{$city.City.id}" {if $city.City.name=="福建"}selected="selected"{$default_city_id = $city.City.id}{/if}>{$city.City.name}</option>
                        {/foreach}
                    </select>
                <select id="city_id" class="selOpts sel2212" size="8" multiple="multiple">
                    {foreach $this->City->childrenCityList($default_city_id) as $child}
                    <option value="{$child.City.id}">{$child.City.name}</option>
                {/foreach}
                </select>
              </div>
              <div class="div2">
                <input type="button" class="inpButton addOpts" value="添加 >>"/>
                <input type="button" class="inpButton removeOpts" value="<< 移除"/>
              </div>
              <select class="seledOpts sel221" id="city_contain" size="10" multiple="multiple">
              {if isset($this->data['city'])}
                    {$cities = explode(',', $this->data['city'])}
                    {foreach $cities as $id}
                        <option value="{$id}">{$this->City->cityName($id)}</option>
                    {/foreach}
              {/if}
              </select>
              <input type="hidden" name="city" id="city">
            </div>
          </dt>
          <dt>
            <label><font class="facexh">*</font>期望待遇：</label>
            <input type="text" id="salary" name="salary" class="contact" value="{if isset($this->data['salary'])}{$this->data['salary']}{/if}" />
          </dt>
          <dt>
            <label><font class="facexh">*</font>上岗时间：</label>
            <input type="text" name="start" id="workTime" style="width:85px;" value="{if isset($this->data['start'])}{$this->data['start']}{/if}" readonly="readonly"/>
          </dt>
        </dl>
        {if isset($this->request->query['fid'])}
            <input type="hidden" name="fid" value="{$this->request->query['fid']}"/>
        {elseif isset($this->request->data['fid'])}
            <input type="hidden" name="fid" value="{$this->request->data['fid']}"/>
        {/if}
        <a class="zclan zclan4" href="javascript:void(0)" id="check">确认</a>
      </form>
    </div>
    </div>