<script>
{literal}
$(document).ready(function(){
    $("body").append($(".jsxxxqB"));    
    datepIniChange("#birthday","birth");
    datepIniChange("#eduBegin","EPbirth");
    datepIniChange("#eduEnd","EPbirth");    
    datepIniChange("#workBegin","EPbirth");
    datepIniChange("#workEnd","EPbirth");    
    //datepIniChange("#workTime","EPbirth");
    var errorMsg = '<span class="errorMsg">请输入此项目</span>';
	var dateEMsg = '<span class="errorMsg">请正确输入时间</span>';
	var optEMsg = '<span class="errorMsg">请选择期望选项</span>';
	
    $(".eduEdit").click(function(){
        bgKuang("#jsxxxqE",".jsxxxqB .closeDiv");
    });
    $(".workEdit").click(function(){
        bgKuang("#jsxxxqW",".jsxxxqB .closeDiv");
    });
    $(".jobEdit").click(function(){
        bgKuang("#jsxxxqJ",".jsxxxqB .closeDiv");
    });
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
  
    $('#editEducation').click(function(){
		$(this).parent().find(".errorMsg").remove();	
        if (checkEducation()) {
            $.ajax({
                url : '/resumes/editEducation',
                type : 'post',
                data : $('#educationForm').serializeArray(),
                success : function(data)
                {
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        location.href = location.href;
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
    $('#editWork').click(function(){
		$(this).parent().find(".errorMsg").remove();	
        if (checkWork()) {
            $.ajax({
                url : '/resumes/editWork',
                type : 'post',
                data : $('#workForm').serializeArray(),
                success : function(data)
                {
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        location.href = location.href;
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
    $('#editResume').click(function(){
		$(this).parent().find(".errorMsg").remove();	
        if (checkResume()) {
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
            $.ajax({
                url : '/resumes/editResume',
                type : 'post',
                data : $('#resumeForm').serializeArray(),
                success : function(data)
                {
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        location.href = location.href;
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
    //如果没有错则返回true
    function checkEducation() {		
		var error=0;
		var checkTarget = ['school', 'discipline','educated'];
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
		if (!error) return true;
    }
    //如果没有错则返回true
    function checkWork() {
        var error=0;
		var checkTarget = ['company', 'department','post','service','responsiblly','work_category','salary','reason'];
		$.each(checkTarget, function(target){
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
        if (!error) return true;
    }
    //如果没有错则返回true
    function checkResume() {
        var error=0;
		var checkTarget = ['evaluation', 'intention','rsalary','workTime'];
		$.each(checkTarget, function(target){
			if($('#' + this).val() == "") {
				$('#' + this).parent().append(errorMsg);
				error=1;
			} 
		});
		if($("#category_contain option").length==0) {
			$('#category_contain').prev().append(optEMsg);
			error=1;
		} 	
		if($("#city_contain option").length==0) {
			$('#city_contain').prev().append(optEMsg);
			error=1;
		} 	
        if (!error) return true;
    }
  
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
          <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
          <a href="javascript:void(0)">兼职管理</a>&gt;&gt;
          <a href="javascript:void(0)">我的简历</a>
      </p>
    </div>
    <div class="znx resume">
      <div class="znxContent conResume" style="border-top:1px solid #ccc;">
        <div class="znxConSys">
          <h2><a target="_blank" href="/resumes/preview?id={$resume.Resume.id}" title="预览">{$resume.Resume.title}</a></h2>
          <div class="biaotit">基础信息<!--<a href="javascript:;" class="left resumeEdit">编辑</a>--></div>
          <table class="preview" border="1" cellspacing="0" cellpadding="0" id="baseInfo" width="593">
            <tr>
              <td width="8%" class="tlt tltL">姓名：</td>
              <td width="15%">{$resumeBase.ResumeBase.name}</td>
              <td width="8%" class="tlt tltL">性别：</td>
              <td width="22%">{if $resumeBase.ResumeBase.sex == 1}男{else}女{/if}</td>
              <td width="8%" class="tlt tltL">户籍：</td>
              <td width="23%">{$provincial_local = $this->City->cityName($resumeBase.ResumeBase.provincial_local)}
            {$city_local =  $this->City->cityName($resumeBase.ResumeBase.city_local)}
            {if $provincial_local == $city_local}
                {$provincial_local}
            {else}
                {$provincial_local} {$city_local}
            {/if}</td>
              <td width="16%" rowspan="2">
              <div align="center">
              {if !empty($thumbnail)}
                {$thumbnailP = Configure::read('Data.path')|cat:$thumbnail}
                {if file_exists($thumbnailP)}
                    <img width="112" height="124" src="{$this->webroot}{$thumbnail}">
                {else}
                    <img width="112" height="124" src="{$this->webroot}img/tx.jpg">
                {/if}
              {else}
                <img width="112" height="124" src="{$this->webroot}img/tx.jpg">
              {/if}
              </div>
              </td>
            </tr>
            <tr>
              <td class="tlt tltL">国籍：</td>
              <td >{$resumeBase.ResumeBase.nationality}</td>
              <td class="tlt tltL">民族：</td>
              <td>{$resumeBase.ResumeBase.ethnic}</td>
              <td class="tlt tltL">生日：</td>
              <td>{$resumeBase.ResumeBase.birthday|date_format:"%Y-%m-%d"}</td>
            </tr>
            <tr>
              <td class="tlt tltL">联系<br />
电话：</td>
              <td>{$resumeBase.ResumeBase.telephone}</td>
              <td class="tlt tltL">电子<br />
邮箱：</td>
              <td>{$resumeBase.ResumeBase.email}</td>
              <td class="tlt tltL">联系<br />
地址：</td>
              <td colspan="2" >{$resumeBase.ResumeBase.address}</td>
            </tr>            
          </table>
          <div class="biaotit">教育经历<a href="javascript:;" class="eduEdit">编辑</a></div>
          <table class="con_2_table preview" border="1" cellspacing="0" cellpadding="0" width="593">
          <tr>
          <td class="tlt tltC">就学起讫时间</td>
          <td class="tlt tltC">就读院校名称</td>
          <td class="tlt tltC">专业类别</td>
          <td class="tlt tltC">专业学历</td>
          <td class="tlt tltC">就学形式</td>
        </tr>
        <tr>
          <td width="25%">{$resumeEducation.ResumeEducation.begin|date_format:"%Y-%m-%d"} - {$resumeEducation.ResumeEducation.end|date_format:"%Y-%m-%d"}</td>
          <td width="27%">{$resumeEducation.ResumeEducation.school}</td>
          <td width="17%">{$resumeEducation.ResumeEducation.discipline}</td>
          <td width="14%">
          {$educate = Configure::read('Fulltime.educated')}
          {$educate[$resumeEducation.ResumeEducation.educated]}
          </td>
          <td width="16%">{$resumeEducation.ResumeEducation.school_type}</td>
        </tr>
          </table>
          <div class="biaotit">工作经历<a href="javascript:;" class="workEdit">编辑</a></div>
          <table class="con_2_table preview" border="1" cellspacing="0" cellpadding="0" width="593">
<tr>
              <td width="19%" class="tlt tltC">就职起讫时间</td>
              <td width="26%" class="tlt tltC">单位名称</td>
              <td width="18%" class="tlt tltC">单位行业</td>
              <td width="18%" class="tlt tltC">部门</td>
              <td width="19%" class="tlt tltC">职位</td>
            </tr>
        <tr>
          <td>{$resumeWork.ResumeWork.begin|date_format:"%Y-%m-%d"} - {$resumeWork.ResumeWork.end|date_format:"%Y-%m-%d"}</td>
          <td>{$resumeWork.ResumeWork.company}</td>
          <td>{$this->Category->getCategoryName($resumeWork.ResumeWork.category)}</td>
          <td>{$resumeWork.ResumeWork.department}</td>
          <td>{$resumeWork.ResumeWork.post}</td>
        </tr>       
        <tr>
            <td class="tlt">从事产品或服务：</td>
            <td colspan="4">{$resumeWork.ResumeWork.service}</td>
        </tr>
		<tr>
            <td class="tlt">职位待遇：</td>
            <td colspan="4">{$resumeWork.ResumeWork.salary}</td>
        </tr>
		<tr>
            <td class="tlt">工作职责：</td>
            <td colspan="4">{$resumeWork.ResumeWork.responsiblly}</td>
        </tr>
        <tr>
            <td class="tlt">离职原因：</td>
            <td colspan="4">{$resumeWork.ResumeWork.reason}</td>
        </tr>
        </table>
          <div class="biaotit">求职方向<a href="javascript:;" class="left jobEdit">编辑</a></div>
          <table class="preview" border="1" cellspacing="0" cellpadding="0" width="593">
            <tr>
              <td class="tlt" width="20%">自我评价：</td>
              <td width="80%">{$resume.Resume.evaluation}</td>
            </tr>
            <tr>
              <td class="tlt" >期望工作性质：</td>
              <td>{$resume.Resume.nature}</td>
            </tr>
            <tr>
              <td class="tlt">意向职位：</td>
              <td>{$resume.Resume.intention}</td>
            </tr>
            <tr>
              <td class="tlt">期望从事行业：</td>
              <td>
              {$categories = explode(',', $resume.Resume.category)}
              {foreach $categories as $id}
                {$this->Category->getCategoryName($id)}
              {/foreach}
              </td>
            </tr>
            <tr>
                <td class="tlt">期望工作地点：</td>
                <td colspan="8">
                  {$cities = explode(',', $resume.Resume.city)}
                  {foreach $cities as $id}
                    {$this->City->cityName($id)}
                  {/foreach}
                </td>
            </tr>
            <tr>
              <td class="tlt">期望待遇：</td>
              <td>{$resume.Resume.salary}</td>
            </tr>
            <tr>
              <td class="tlt" >上岗时间：</td>
              <td>{$resume.Resume.start|date_format:"%Y-%m-%d"}</td>
            </tr>
          </table>
          <div style="width:100px;" class="divBtnContainer"><a class="zclan zclan4" href="/resumes/preview?id={$resume.Resume.id}" target="_blank">预览</a></div>
        </div>
      </div>
    </div>
    <div class="jsxxxq jsxxxqB" id="jsxxxqE"> <a class="closeDiv" href="#">&nbsp;</a>
      <div class="biaotit">教育经历（<font class="facexh">*</font>表示必填项）</div>
      <div class="sjle">
        <form id="educationForm">
        <input type="hidden" name="resumes_id" value="{$this->request->query['id']}" />
          <dl>
            <dt>
              <label><font class="facexh">*</font>就学起讫时间：</label>
              <ul class="validity">
                <li>
                  <input type="text" id="eduBegin" name="begin" value="{$resumeEducation.ResumeEducation.begin|date_format:"%Y-%m-%d"}" readonly="readonly"/>
                </li>
                <li style="width:36px;text-align:center;">至</li>
                <li>
                  <input type="text" id="eduEnd" name="end" value="{$resumeEducation.ResumeEducation.end|date_format:"%Y-%m-%d"}" readonly="readonly"/>
                </li>
              </ul>
            </dt>
            <dt>
              <label><font class="facexh">*</font>就读院校名称：</label>
              <input type="text" name="school" value="{$resumeEducation.ResumeEducation.school}" id="school">
            </dt>
            <dt>
              <label><font class="facexh">*</font>专业类别：</label>
              <input type="text" name="discipline" id="discipline" value="{$resumeEducation.ResumeEducation.discipline}" />
            </dt>
            <dt class="productKinds">
              <label><font class="facexh">*</font>专业学历：</label>
              <select id="educated" name="educated">
                    <option selected="selected" value="">请选择专业学历</option>
                    <option {if $resumeEducation.ResumeEducation.educated == "0"}selected="selected"{/if} value="0">无</option>
                    <option {if $resumeEducation.ResumeEducation.educated == "1"}selected="selected"{/if} value="1">小学</option>
                    <option {if $resumeEducation.ResumeEducation.educated == "2"}selected="selected"{/if} value="2">初中</option>
                    <option {if $resumeEducation.ResumeEducation.educated == "3"}selected="selected"{/if} value="3">高中</option>
                    <option {if $resumeEducation.ResumeEducation.educated == "4"}selected="selected"{/if} value="4">中专</option>
                    <option {if $resumeEducation.ResumeEducation.educated == "5"}selected="selected"{/if} value="5">大专</option>
                    <option {if $resumeEducation.ResumeEducation.educated == "6"}selected="selected"{/if} value="6">本科</option>
                    <option {if $resumeEducation.ResumeEducation.educated == "7"}selected="selected"{/if} value="7">硕士研究生</option>
                    <option {if $resumeEducation.ResumeEducation.educated == "8"}selected="selected"{/if} value="8">博士研究生</option>
            </select>
            </dt>
            <dt class="productKinds">
              <label>就学形式：</label>
              <select name="school_type" id="school_type">
                    <option value="">请选择就学形式</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "全日制重点大学"}selected="selected"{/if} value="全日制重点大学">全日制重点大学</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "全日制普通高校"}selected="selected"{/if} value="全日制普通高校">全日制普通高校</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "自学考试"}selected="selected"{/if} value="自学考试">自学考试</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "成人大学"}selected="selected"{/if} value="成人大学">成人大学</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "电视大学"}selected="selected"{/if} value="电视大学">电视大学</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "网络大学"}selected="selected"{/if} value="网络大学">网络大学</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "函授大学"}selected="selected"{/if} value="函授大学">函授大学</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "夜大"}selected="selected"{/if} value="夜大">夜大</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "职业大学"}selected="selected"{/if} value="职业大学">职业大学</option>
                    <option {if $resumeEducation.ResumeEducation.school_type == "其他"}selected="selected"{/if} value="其他">其他</option>
                </select>
            </dt>
          </dl>
          <a class="zclan zclan4" id="editEducation" href="javascript:void(0);">修改</a>
        </form>
      </div>
    </div>
    <div class="jsxxxq jsxxxqB" id="jsxxxqW"> <a class="closeDiv" href="#">&nbsp;</a>
      <div class="biaotit">工作经历（<font class="facexh">*</font>表示必填项）</div>
      <div class="sjle">
      <form id="workForm">
      <input type="hidden" name="resumes_id" value="{$this->request->query['id']}" />
        <dl>
          <dt>
            <label><font class="facexh">*</font>就职起讫时间：</label>
            <ul class="validity">
              <li>
                <input type="text" id="workBegin" name="begin" value="{$resumeWork.ResumeWork.begin|date_format:"%Y-%m-%d"}" readonly="readonly"/>
              </li>
              <li style="width:36px;text-align:center;">至</li>
              <li>
                <input type="text" id="workEnd" name="end" value="{$resumeWork.ResumeWork.end|date_format:"%Y-%m-%d"}" readonly="readonly"/>
              </li>
            </ul>
          </dt>
          <dt>
            <label><font class="facexh">*</font>单位名称：</label>
            <input type="text" name="company" id="company" value="{$resumeWork.ResumeWork.company}"/>
          </dt>
          <dt class="productKinds">
            <label>单位行业：</label>
            <select id="work_category" name="work_category">
                <option selected="selected" value="">请选择就职公司所属行业</option>
                {foreach $this->Category->parentCategoryList() as $value}
                    <option {if $resumeWork.ResumeWork.category == $value.Category.id}selected="selected"{/if} value="{$value.Category.id}">{$value.Category.name}</option>
                {/foreach}
            </select>
          </dt>
          <dt>
            <label><font class="facexh">*</font>部门：</label>
            <input type="text" name="department" id="department" value="{$resumeWork.ResumeWork.department}"/>
          </dt>
          <dt>
            <label><font class="facexh">*</font>职位：</label>
            <input type="text" name="post" id="post" value="{$resumeWork.ResumeWork.post}"/>
          </dt>
          <dt>
            <label><font class="facexh">*</font>从事产品及服务：</label>
            <input type="text" name="service" id="service" value="{$resumeWork.ResumeWork.service}"/>
          </dt>
          <dt>
            <label><font class="facexh">*</font>工作职责：</label>
            <textarea cols="45" rows="5" name="responsiblly" id="responsiblly">{$resumeWork.ResumeWork.responsiblly}</textarea>
          </dt>
          <dt>
            <label><font class="facexh">*</font>职位待遇：</label>
            <input type="text" name="salary" id="salary" value="{$resumeWork.ResumeWork.salary}"/>
          </dt>
          <dt>
            <label><font class="facexh">*</font>离职原因：</label>
            <textarea cols="45" rows="5" name="reason" id="reason">{$resumeWork.ResumeWork.reason}</textarea>
          </dt>
        </dl>   
         <a class="zclan zclan4" id="editWork" href="javascript:void(0);" >修改</a>
      </form>
    </div>
    </div>
    <div class="jsxxxq jsxxxqB" id="jsxxxqJ"> <a class="closeDiv" href="#">&nbsp;</a>
      <div class="biaotit">求职方向（<font class="facexh">*</font>表示必填项）</div>
      <div class="sjle">
      <form id="resumeForm">
      <input type="hidden" name="id" value="{$this->request->query['id']}" />
        <dl>          
          <dt>
            <label><font class="facexh">*</font>期望工作性质：</label>
            <div class="divSex">              
              <label><input type="radio" name="nature" value="全职" class="inpRadio" {if $resume.Resume.nature == "全职"} checked="checked"{/if}/>全职</label>
              <label><input type="radio" name="nature" value="兼职" {if $resume.Resume.nature == "兼职"} checked="checked"{/if} class="inpRadio"/>兼职</label>
              <label> <input type="radio" name="nature" value="不限" {if $resume.Resume.nature == "不限"} checked="checked"{/if} class="inpRadio"/>不限</label>
            </div>
          </dt>
          <dt>
            <label><font class="facexh">*</font>意向职位：</label>
            <input type="text" name="intention" id="intention" value="{$resume.Resume.intention}" />
            &nbsp;（限20个字） </dt>
          <dt>
            <label><font class="facexh">*</font>期望从事行业：</label>
            <div class="divExpect">
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
                {$categories = explode(',', $resume.Resume.category)}
                {foreach $categories as $id}
                    <option value="{$id}">{$this->Category->getCategoryName($id)}</option>
                {/foreach}
              </select>
              <input type="hidden" name="category" id="category">
            </div>
          </dt>
          <dt>
            <label><font class="facexh">*</font>期望工作地点：</label>
            <div class="divExpect">
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
                {$cities = explode(',', $resume.Resume.city)}
                {foreach $cities as $id}
                    <option value="{$id}">{$this->City->cityName($id)}</option>
                {/foreach}
              </select>
              <input type="hidden" name="city" id="city">
            </div>
          </dt>
          <dt>
            <label><font class="facexh">*</font>期望待遇：</label>
            <input type="text" name="salary" name="rsalary" value="{$resume.Resume.salary}" />
          </dt>
          <dt>
            <label><font class="facexh">*</font>上岗时间：</label>
            <ul class="validity">
              <li>
                <input type="text" name="start" id="workTime" value="{$resume.Resume.start}" style="width:218px;"/>
              </li>
            </ul>
          </dt>
		  <dt>
            <label><font class="facexh">*</font>自我评价：</label>
            <textarea cols="45" rows="5" name="evaluation" id="evaluation">{$resume.Resume.evaluation}</textarea>
          </dt>
        </dl>
         <a class="zclan zclan4" href="javascript:void(0);" id="editResume">修改</a>
      </form>
    </div>
    </div>
</div>