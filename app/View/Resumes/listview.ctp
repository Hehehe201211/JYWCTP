<script type="text/javascript">
{literal}
$(document).ready(function(){
    //sidebarSF(2);  
	$(".newResume").click(function(){
		if ($("#baseInfo tbody tr").length==0) alert("请先填写基础信息");
		else window.open("/resumes/create");
	});	  
            
    $("body").append($("#jsxxxq"));    
    $("#resumeBase").click(function(){
        bgKuang("#jsxxxq",".jsxxxqB .closeDiv");
    });
    datepIniChange("#birthday","birth");    
    $("button.addContact").live("click",function(e){
        e.preventDefault();
        $(this).parent().after($(this).parent().clone());
        $(this).parent().next().children(".inpTextBox").val("");        
    });
    $("button.deleContact").live("click",function(e){
        e.preventDefault();
        if ($("button.deleContact").length>1) $(this).parent().remove(); 
    });    
    $('#provincial_local').change(function(){
        $('#city').find('option').remove();
        if ($(this).val() != "") {
            $.ajax({
                'type' : 'get',
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
                    $('#city_local').append(optionStr);
                }
            })
        }
    });
    
    $('#provincial_now').change(function(){
        $('#city').find('option').remove();
        if ($(this).val() != "") {
            $.ajax({
                'type' : 'get',
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
                    $('#city_now').append(optionStr);
                }
            })
        }
    });
    
    $('#editBtn').click(function(){       
       var checkTarget = ['name','provincial_now','city_now','address', 'telephone', 'email', 'nationality', 'ethnic'];
       var errorMsg = '<span class="errorMsg">请输入此项目</span>';    
       var error=0;
        $.each(checkTarget, function(target){
            if($('#' + this).val() == "") {
                if($('#' + this).parent().find('.errorMsg').length == 0) {
                    $('#' + this).parent().append(errorMsg);
                }
                error=1;
            } else {
                $('#' + this).parent('dt').find('.errorMsg').remove();
            }
        });
        if($('#birthday').val()=="") {
            if($('#birthday').parent().parent().find('.errorMsg').length == 0) {
                $('#birthday').parent().parent().append(errorMsg);
            }
            error=1;
        } else {
            $('#birthday').parent().parent().find('.errorMsg').remove();
        }
       if(!error) {
            var information = $("#information").serializeArray();
            $.ajax({
                url : '/resumes/editBase',
                type : 'post',
                data : information,
                async: false,
                success : function(data)
                {
                    var result=eval("("+data+")");
                    if(result.result == 'OK') {
                        alert(result.msg);
                        $('.jsxxxqB .closeDiv').click();
                        location.href=location.href;
                    } else {
                        alert(result.msg);
                    }
                }
            });
       }
    });
});
{/literal}
</script>
<div class="zy_z">
  <div class="zy_zs">
    <p> <a href="javascript:void(0)">我的聚业务</a>&gt;&gt; <a href="javascript:void(0)">常规招聘</a>&gt;&gt; <a href="javascript:void(0)">我的简历</a> </p>
  </div>
  <form id="searchOpt">
  <div style="margin:0 0 8px 3px;"> <span>我目前想要的工作性质：</span>
    <select style="width:80px;" name="nature">
      <option value="">不限</option>
      <option value="全职">仅全职</option>
      <option value="兼职">仅兼职</option>
    </select>
  </div>
  <div class="znx resume">
    <div class="resumeTlt">
      <ul class="znxTitle">
        <li class="active"> <a href="#">基础信息</a></li>
      </ul>
      <span><a class="newResume" href="javascript:;">新增简历</a></span> </div>
    <div class="znxContent conResume">
      <div class="znxConSys">
        {if !empty($resumeBase)}
        <div class="biaotit">
            <a class="left" href="javascript:void(0)" id="resumeBase">编辑基础信息</a>
        </div>
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
              <td width="16%" rowspan="2"><div align="center"><img width="112" height="124" alt="portrait" src="{$this->webroot}img/tx.jpg"></div></td>
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
        {else}
        <div class="biaotit">
        <a class="left" href="javascript:void(0)" id="resumeBase">追加基础信息</a>
        <table cellspacing="0" cellpadding="0" border="1" class="preview" id="baseInfo">
        </table>
        </div>
        {/if}
        <div class="biaotit">简历一览</div>
        <div id="result">
            {$form = ['isForm' => true, 'inline' => true]}
            {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
            {$this->Paginator->options($options)}
            {$paginatorParams = $this->Paginator->params()}
            <table width="593" cellspacing="0" cellpadding="0" border="0" class="con_2_table" style="margin:0 5px 6px;">
              <thead>
                <tr class="con_2_tr con_2_xq_too">
                  <th style="width:75px;" class="tr_td8">简历标题</th>
                  <th class="tr_td1">期望从事行业</th>
                  <th style="width:90px;" class="tr_td2">期望工作地点 </th>
                  <th class="tr_td1">工作性质</th>
                  <th style="width:90px;" class="tr_td2">发布时间 </th>
                  <th class="tr_td8">选择操作</th>
                </tr>
              </thead>
              {foreach $resumes as $resume}
              <tr class="con_2_tr">
                <th><a target="_blank" href="/resumes/preview?id={$resume.Resume.id}">{$resume.Resume.title}</a></th>
                <td>
                    <a target="_blank" href="/resumes/preview?id={$resume.Resume.id}">
                    {$categories = explode(',', $resume.Resume.category)}
                    {foreach $categories as $id}
                        {$this->Category->getCategoryName($id)}
                    {/foreach}
                    </a>
                </td>
                <td>
                <a target="_blank" href="/resumes/preview?id={$resume.Resume.id}">
                {$cities = explode(',', $resume.Resume.city)}
                {foreach $cities as $id}
                    {$this->City->cityName($id)}
                {/foreach}
                </a>
                </td>
                <td>{$resume.Resume.nature}</td>
                <td>{$resume.Resume.created|date_format:"%Y-%m-%d"}</td>
                <td class="con_2_xq_tofu xiushan_anniu">
				    <a target="_blank" href="/resumes/detail?id={$resume.Resume.id}">详情</a>
                    <a target="_blank" href="/resumes/preview?id={$resume.Resume.id}">预览</a>                    
                </td>
              </tr>
              {/foreach}
            </table>
            <div class="fanyea">
                {if $paginatorParams['prevPage']}
                    <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
                {/if}
                <div class="dd_ym">
                    <label>每页显示：</label>
                    <select name="pageSize" id="pageSize">
                        <option value="10" {if $pageSize == "10"} selected {/if}>10</option>
                        <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                        <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                        <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
                    </select>
                </div>
                <div class="dd_ym11">
                    <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                    <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                    <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
                </div>
                {if $paginatorParams['nextPage']}
                    <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                {/if}
            </div>
            {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
            {$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
            {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
            {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}

            {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
            {$this->Js->writeBuffer()}
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
  </form>
</div>

<div class="jsxxxq jsxxxqB" id="jsxxxq"> <a class="closeDiv" href="#">&nbsp;</a>
  <div class="biaotit">基础信息（<font class="facexh">*</font>表示必填项）</div>
  <div class="sjle">
    <form id="information" method="post" action="/resumes/editBase">
    {if !empty($resumeBase)}
          <dl>
            <dt>
              <label><font class="facexh">*</font>姓名：</label>
              <input type="text" id="name" name="name" value="{$resumeBase.ResumeBase.name}"/>
            </dt>
            <dt>
              <label>个人头像：</label>
              <input type="file" style="height:auto;height:22px\9;" />
            </dt>
            <dt>
              <label><font class="facexh">*</font>性别：</label>
              <div class="divSex">
                <label>
                  <input type="radio" class="inpRadio" name="sex" value="1" {if $resumeBase.ResumeBase.sex == 1} checked="checked"{/if}/>
                  男</label>
                <label>
                  <input type="radio" name="sex" value="0" class="inpRadio" {if $resumeBase.ResumeBase.sex == 0} checked="checked"{/if}/>
                  女</label>
              </div>
            </dt>
            <dt>
              <label><font class="facexh">*</font>出生日期：</label>
              <ul class="validity">
                <li>
                  <input type="text" name="birthday" id="birthday" value="{$resumeBase.ResumeBase.birthday|date_format:"%Y-%m-%d"}" readonly="readonly"/>
                </li>
              </ul>
            </dt>
            <dt>
              <label><font class="facexh">*</font>国籍：</label>
              <input type="text" name="nationality" value="{$resumeBase.ResumeBase.nationality}" id="nationality" style="width:100px;" />
              <label><font class="facexh">*</font>民族：</label>
              <input type="text" name="ethnic" value="{$resumeBase.ResumeBase.ethnic}" id="ethnic" style="width:100px;" />
            </dt>
            <dt class="select100">
              <label>户口所在地：</label>
              <select name="provincial_local" id="provincial_local">
                <option value="">请选择</option>
                {foreach $this->City->parentCityList() as $city}
                    <option value="{$city.City.id}" {if $resumeBase.ResumeBase.provincial_local == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
                {/foreach}
              </select>
              <select name="city_local" id="city_local">
              <option value="">请选择</option>
              {foreach $this->City->childrenCityList($resumeBase.ResumeBase.provincial_local) as $city}
              <option value="{$city.City.id}" {if $resumeBase.ResumeBase.city_local == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
              {/foreach}
              </select>
            </dt>
            <dt class="select100">
              <label><font class="facexh">*</font>现居住地：</label>
              <select name="provincial_now" id="provincial_now">
                <option value="">请选择</option>
                {foreach $this->City->parentCityList() as $city}
                    <option value="{$city.City.id}" {if $resumeBase.ResumeBase.provincial_now == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
                {/foreach}
              </select>
              <select name="city_now" id="city_now">
                <option value="">请选择</option>
                {foreach $this->City->childrenCityList($resumeBase.ResumeBase.provincial_now) as $city}
                <option value="{$city.City.id}" {if $resumeBase.ResumeBase.city_now == $city.City.id}selected="selected"{/if}>{$city.City.name}</option>
                {/foreach}
              </select>
            </dt>
            <dt>
              <label><font class="facexh">*</font>联系电话：</label>
              <input type="text" name="telephone" id="telephone" value="{$resumeBase.ResumeBase.telephone}" onkeyup="phoneNum(this)" onpaste="phoneNum(this)"/>
            </dt>
            <dt>
              <label><font class="facexh">*</font>E-mail：</label>
              <input type="text" name="email" id="email" value="{$resumeBase.ResumeBase.email}" onkeyup="Emailstr(this)" onpaste="Emailstr(this)"/>
            </dt>
            <dt>
              <label><font class="facexh">*</font>联系地址：</label>
              <input type="text" name="address" value="{$resumeBase.ResumeBase.address}" id="address"/>
            </dt>
          </dl>
          <input type="hidden" name="id" value="{$resumeBase.ResumeBase.id}" />
          <a class="zclan zclan4" href="javascript:void(0)" id="editBtn" >修改</a>
      {else}
            <dl>
            <dt>
              <label><font class="facexh">*</font>姓名：</label>
              <input type="text" id="name" name="name"/>
            </dt>
            <dt>
              <label>个人头像：</label>
              <input type="file" style="height:auto;height:22px\9;" />
            </dt>
            <dt>
              <label><font class="facexh">*</font>性别：</label>
              <div class="divSex">
                <label>
                  <input type="radio" class="inpRadio" name="sex" value="1" checked="checked"/>
                  男</label>
                <label>
                  <input type="radio" name="sex" value="0" class="inpRadio"/>
                  女</label>
              </div>
            </dt>
            <dt>
              <label><font class="facexh">*</font>出生日期：</label>
              <ul class="validity">
                <li>
                  <input type="text" name="birthday" id="birthday"  readonly="readonly"/>
                </li>
              </ul>
            </dt>
            <dt>
              <label><font class="facexh">*</font>国籍：</label>
              <input type="text" name="nationality" id="nationality" style="width:100px;" />
              <label><font class="facexh">*</font>民族：</label>
              <input type="text" name="ethnic" id="ethnic" style="width:100px;" />

            </dt>
            <dt class="select100">
              <label>户口所在地：</label>
              <select name="provincial_local" id="provincial_local">
                <option value="">请选择</option>
                {foreach $this->City->parentCityList() as $city}
                    <option value="{$city.City.id}">{$city.City.name}</option>
                {/foreach}
              </select>
              <select name="city_local" id="city_local">
              <option value="">请选择</option>
              </select>
            </dt>
            <dt class="select100">
              <label><font class="facexh">*</font>现居住地：</label>
              <select name="provincial_now" id="provincial_now">
                <option value="">请选择</option>
                {foreach $this->City->parentCityList() as $city}
                    <option value="{$city.City.id}">{$city.City.name}</option>
                {/foreach}
              </select>
              <select name="city_now" id="city_now">
                <option value="">请选择</option>
              </select>
            </dt>            
            <dt>
              <label><font class="facexh">*</font>联系电话：</label>
              <input type="text" name="telephone" id="telephone"/>
            </dt>
            <dt>
              <label><font class="facexh">*</font>E-mail：</label>
              <input type="text" name="email" id="email"/>
            </dt>
            <dt>
              <label><font class="facexh">*</font>联系地址：</label>
              <input type="text" name="address" id="address"/>
            </dt>
          </dl>
          <a class="zclan zclan4" href="javascript:void(0)" id="editBtn" >提交</a>
      {/if}
    </form>
  </div>
</div>

