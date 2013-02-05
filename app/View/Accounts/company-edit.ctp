<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#category_id').change(function(){
        $('ul.products').html('').parent().find(".errorMsg").remove();
        if ($(this).val() != "") {
            $.ajax({
                'type'  : 'Get',
                'url'   : '/informations/getCategoryList/' + $(this).val(),
                'success':function(data) {
                    var dataobj=eval("("+data+")");
                    var liStr = "";
                    $.each(dataobj, function(idx, item){
                        liStr += '<li><input type="checkbox" class="sub_category" name="service[]" value="' + item.Category.id + '" id="service[]' + item.Category.id + '"><label for="service[]' + item.Category.id + '">' + item.Category.name + '</label></li>'
                    });
                    $('ul.products').html(liStr);
                }
            });
        }
    });
    $('#provincial_id').change(function(){
        if ($(this).val() != "") {
            $.ajax({
                'type' : 'Get',
                'url'  : '/informations/getCityList/' + $(this).val(),
                'success':function(data){
                    var dataobj=eval("("+data+")");
                    if (dataobj.length > 1) {
                        $('#city_id').find('option:gt(0)').remove();
                    } else {
                        $('#city_id').find('option').remove();
                    }
                    var optionStr = "";
                    $.each(dataobj, function(idx, item){
                        optionStr += '<option value="'+item.City.id+'">' + item.City.name + '</option>'
                    });
                    $('#city_id').append(optionStr);
                }
            })
        }
    });
    $("button.addContact").live("click",function(e){
        e.preventDefault();
        $(this).parent().after($(this).parent().clone());
        $(this).parent().next().find(".inpTextBox").val("");
    });
    $("button.deleContact").live("click",function(e){
        e.preventDefault();
        if ($("button.deleContact").length>1) $(this).parent().remove(); 
    });
    $('#getCheckNum').prepend('<img id="code" src="/members/image/' + Math.random() +'">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
    
    $('#check').click(function(){
        if (!checkData()) {
            $("#editForm").submit();
        }
    });    
    function checkData() {
        var checkTarget = ['full_name','contact','fax','address','category_id','company_type','business_scope','checkNum'];
        var errorMsg = '<span class="errorMsg">请输入此项目</span>'
       $(".sjle").find(".errorMsg").remove();
        var error=0;
        $.each(checkTarget, function(target){
            if($('#' + this).val() == "") {
                $('#' + this).parent().append(errorMsg);
                error=1;
            } 
        });
        if ($('#provincial_id').val() == ""||$('#city_id').val() == "") {
            $('#city_id').parent().append(errorMsg);
            error=1;
        } 
        $('.contact_method').each(function(){
            if ($(this).val() == "") {
                $(this).parent().append(errorMsg);
                error=1;
            } 
        });    
        if ($(".products input:checked:checked").length==0) {
            $('ul.products').parent().append('<span class="errorMsg" style="left:516px;">请输入此项目</span>');
            error=1;
        }
        if (!error) {
            $.ajax({
              url : '/members/getImageNumber',
              type : 'post',
              async  : false,
              success : function(data)
              {
                if (data == $("#checkNum").val().toUpperCase()) {
                    $("#checkNum").parent().find('.errorMsg').remove();
                } else {
                    error = true;
                    if ($("#checkNum").parent().find('.errorMsg').length == 0) {
                        $("#getCheckNum").after('<span class="errorMsg">验证码不一致</span>');
                    } else {
                        $("#checkNum").parent().find('.errorMsg').html('验证码不一致');
                    }
                  }
              }
          });
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
            <a href="javascript:void(0)">账号管理</a>&gt;&gt;
            <a href="javascript:void(0)">完善资料</a>
        </p>
    </div> 
    <div class="mebBaseinfo epmebBaseinfo">
        <div class="mebBaseinfoL">
          <table width="100%" height="100%" border="0">
          {if $memberInfo.Member.grade == 2}
            <tr>
              <td width="34%" rowspan="6">
              {if !empty($memberInfo.Attribute.thumbnail)}
                {$thumbnail = Configure::read('Data.path')|cat:$memberInfo.Attribute.thumbnail}
                {if file_exists($thumbnail)}
                    <img src="{$this->webroot}{$memberInfo.Attribute.thumbnail}">
                {else}
                    <img src="{$this->webroot}img/tx.jpg">
                {/if}
              {else}
              <img src="{$this->webroot}img/tx.jpg">
              {/if}
              </td>
              <td width="66%">会员昵称：{$memberInfo.Member.nickname}</td>
            </tr>
            <tr>
              <td>公司名称：{$memberInfo.Member.company_name}</td>
            </tr>
            <tr>
              <td>绑定邮箱：{$memberInfo.Member.email}</td>
            </tr>
            <tr>
              <td>行业：{$this->Category->getCategoryName($memberInfo.Attribute.category_id)}</td>
            </tr>
            <tr>
              <td>地址：{$memberInfo.Attribute.address}</td>
            </tr>
            <tr>
              <td>账户有效期：2012-09-20&nbsp;至&nbsp;2013-09-20</td>
            </tr>
            <tr>
              <td colspan="2" class="mebInfo">
              <span>资料完整度：</span>
              <span class="progressBar">
              <span style="width:100%">&nbsp;100%&nbsp;</span>
              </span>
              <a class="icon iconZ iconH" href="/accounts/edit" title="营业执照已认证"></a>
              <a class="icon iconM iconH" href="/accounts/edit" title="已绑定邮箱"></a>
              </td>
            </tr>
            {else}
            <tr>
              <td width="34%" rowspan="6"><img src="img/tx.jpg" /></td>
              <td width="66%">会员昵称：{$memberInfo.Member.nickname}</td>
            </tr>
            <tr>
              <td>公司名称：{$memberInfo.Member.company_name}<a  href="/members/upgrade">完善资料</a></td>
            </tr>
            <tr>
              <td>绑定邮箱：{$memberInfo.Member.email}</td>
            </tr>
            <tr>
              <td>行业：<a  href="/members/upgrade">完善资料</a></td>
            </tr>
            <tr>
              <td>地址：<a  href="/members/upgrade">完善资料</a></td>
            </tr>
            <tr>
              <td>账户有效期：2012-09-20&nbsp;至&nbsp;2013-09-20</td>
            </tr>
            <tr>
              <td colspan="2" class="mebInfo">
              <span>资料完整度：</span>
              <span class="progressBar">
              <span style="width:30%">&nbsp;100%&nbsp;</span>
              </span>
              <a href="/accounts/edit">完善资料</a>
              <a class="icon iconZ iconH" href="/accounts/edit" title="营业执照已认证"></a>
              <a class="icon iconM iconH" href="/members/upgrade" title="已绑定邮箱"></a>
              </td>
            </tr>
            {/if}
          </table>
        </div>
        <div class="mebBaseinfoR">
          <dl>
            <dd>已发布岗位：<a href="/fulltimes/listview">0</a>个全职&nbsp;&nbsp;<a href="/parttimes/listview?type=send">0</a>个兼职</dd>
            <dd>已收到简历到：<a href="/auditions/listview?type=receive">0</a>封</dd>
            <dd>已收到合作信息：<a href="/cooperations/listview/?type=receiver">0</a>条</dd>
            <dd>合作中的信息：<a href="/cooperations/waitlist/?type=receiver">0</a>条</dd>            
            <dd>待付款的信息：<a href="/cooperations/waitlist/?type=receiver">0</a>条</dd>
            <dd>留言：<a href="/accounts/sms">0</a>条</dd>
          </dl>
        </div>
      </div>  
<ul class="ulFormStep">
      <li>1.完善资料</li>
      <li>2.信息确认</li>
      <li>3.修改成功</li>
    </ul>
    <div class="sjle">
       <form id="editForm" action="/accounts/editCheck" method="post" enctype="multipart/form-data">
        <ul>   
          <li>
            <label><font class="facexh">*</font>公司全名：</label>
            <input type="text" class="inpTextBox" name="full_name" id="full_name" value="{if isset($this->data['full_name'])}{$this->data['full_name']}{else}{$memberAttribute.CompanyAttribute.full_name}{/if}">
          </li> 
          <li>
             <label>成立时间：</label>
             <input type="text" readonly="readonly" id="established" name="established" value="{if isset($this->data['established'])}{$this->data['established']}{else}{$memberAttribute.CompanyAttribute.established|date_format:"%Y-%m-%d"}{/if}">
          </li>
          <li>
            <label>营业执照：</label>
          </li>
          <li class="avatar">
            <label>&nbsp;</label>
            {if isset($this->data['license'])}
                {$thumbnail = Configure::read('Data.path')|cat:$this->data['license']}
                {if !empty($this->data['license']) && file_exists($thumbnail)}
                    <img src="{$this->webroot}{$this->data['license']}">
                {/if}
            {else if !empty($memberAttribute.CompanyAttribute.license)}
                {$thumbnail = Configure::read('Data.path')|cat:$memberAttribute.CompanyAttribute.license}
                {if file_exists($thumbnail)}
                    <img src="{$this->webroot}{$memberAttribute.CompanyAttribute.license}">
                {/if}
            {/if}
            <input type="hidden" name="license" value="{if isset($this->data['license'])}{$this->data['license']}{else}{$memberAttribute.CompanyAttribute.license}{/if}" />
          </li>
          <li>
            <label>公司LOGO：</label>
            <input type="file" size="20" id="logo" name="logo" class="inpFile">
          </li>
          <li class="avatar">
            <label>&nbsp;</label>
            {if isset($this->data['thumbnail'])}
                {$thumbnail = Configure::read('Data.path')|cat:$this->data['thumbnail']}
                {if !empty($this->data['thumbnail']) && file_exists($thumbnail)}
                    <img src="{$this->webroot}{$this->data['thumbnail']}">
                {/if}
            {else if !empty($memberAttribute.CompanyAttribute.thumbnail)}
                {$thumbnail = Configure::read('Data.path')|cat:$memberAttribute.CompanyAttribute.thumbnail}
                {if file_exists($thumbnail)}
                    <img src="{$this->webroot}{$memberAttribute.CompanyAttribute.thumbnail}">
                {/if}
            {/if}
            <input type="hidden" name="thumbnail" value="{if isset($this->data['thumbnail'])}{$this->data['thumbnail']}{else}{$memberAttribute.CompanyAttribute.thumbnail}{/if}" />
          </li>
          <li>
             <label><font class="facexh">*</font>联系人：</label>
             <input type="text" class="inpTextBox" id="contact" name="contact" value="{if isset($this->data['contact'])}{$this->data['contact']}{else}{$memberAttribute.CompanyAttribute.contact}{/if}">
          </li>
          {if isset($this->data['contact_method'])}
            {foreach $this->data['contact_method'] as $key => $method}
                  <li>
                    <label><font class="facexh">*</font>联系方式：</label>
                    <div class="area1">
                      <select name="contact_method[]">
                        <option value="座机" {if $method == "座机"}selected="selected"{/if}>座机</option>
                        <option value="手机" {if $method == "手机"}selected="selected"{/if}>手机</option>
                        <option value="E-mail" {if $method == "E-mail"}selected="selected"{/if}>E-mail</option>
                        <option value="QQ" {if $method == "QQ"}selected="selected"{/if}>QQ</option>
                        <option value="MSN" {if $method == "MSN"}selected="selected"{/if}>MSN</option>
                        <option value="Skype" {if $method == "Skype"}selected="selected"{/if}>Skype</option>
                        <option value="其他" {if $method == "其他"}selected="selected"{/if}>其他</option>
                      </select>
                    </div>
                    <input type="text" style="width:128px;" value="{$this->data['contact_content'][$key]}" name="contact_content[]" onkeyup="Emailstr(this)" onpaste="Emailstr(this)">
                    <button class="addContact fl">添加</button><button class="deleContact fl">删除</button>
                  </li>
              {/foreach}
          {else}
              {$contacts = json_decode($memberAttribute.CompanyAttribute.contact_method, true)}
              {foreach $contacts as $contact}
                  <li>
                    <label><font class="facexh">*</font>联系方式：</label>
                    <div class="area1">
                      <select name="contact_method[]">
                        <option value="座机" {if $contact.method == "座机"}selected="selected"{/if}>座机</option>
                        <option value="手机" {if $contact.method == "手机"}selected="selected"{/if}>手机</option>
                        <option value="E-mail" {if $contact.method == "E-mail"}selected="selected"{/if}>E-mail</option>
                        <option value="QQ" {if $contact.method == "QQ"}selected="selected"{/if}>QQ</option>
                        <option value="MSN" {if $contact.method == "MSN"}selected="selected"{/if}>MSN</option>
                        <option value="Skype" {if $contact.method == "Skype"}selected="selected"{/if}>Skype</option>
                        <option value="其他" {if $contact.method == "其他"}selected="selected"{/if}>其他</option>
                      </select>
                    </div>
                    <input type="text" style="width:128px;" value="{$contact.content}" name="contact_content[]" onkeyup="Emailstr(this)" onpaste="Emailstr(this)" class="contact_method">
                    <button class="addContact fl">添加</button><button class="deleContact fl">删除</button>
                  </li>
              {/foreach}
          {/if}
          <li>
            <label><font class="facexh">*</font>传真：</label>
            <input type="text" name="fax" class="inpTextBox" id="fax" value="{if isset($this->data['fax'])}{$this->data['fax']}{else}{$memberAttribute.CompanyAttribute.fax}{/if}" onkeyup="phoneNum(this)" onpaste="phoneNum(this)">
          </li>        
          <li>
            <label><font class="facexh">*</font>所在城市：</label>
            <select name="provincial_id" id="provincial_id">
                <option value="">请选择省份</option>
                {foreach $this->City->parentCityList() as $city}
                <option value="{$city.City.id}" 
                {if isset($this->data['provincial_id']) && $this->data['provincial_id'] == $city.City.id}
                selected="selected"
                {elseif isset($memberAttribute.CompanyAttribute.provincial_id) && $memberAttribute.CompanyAttribute.provincial_id == $city.City.id}
                selected="selected"
                {/if}>{$city.City.name}
                </option>
                {/foreach}
              </select>
            <select name="city_id" id="city_id">
                <option value="">请选择城市</option>
                {if isset($this->data['provincial_id'])}
                    {$parent_id = $this->data['provincial_id']}
                {else}
                    {$parent_id = $memberAttribute.CompanyAttribute.provincial_id}
                {/if}
                {foreach $this->City->childrenCityList($parent_id) as $child}
                    <option value="{$child.City.id}" 
                    {if isset($this->data['city_id']) && $this->data['city_id'] == $child.City.id}
                        selected="selected"
                    {elseif isset($memberAttribute.CompanyAttribute.city_id) && $memberAttribute.CompanyAttribute.city_id == $child.City.id}
                        selected="selected"
                    {/if}>{$child.City.name}
                    </option>
                {/foreach}
              </select>
          </li>
          <li>
            <label><font class="facexh">*</font>公司详细地址：</label>
            <input type="text" name="address" id="address" value="{if isset($this->data['address'])}{$this->data['address']}{else}{$memberAttribute.CompanyAttribute.address}{/if}">
          </li>
          <li>
            <label><font class="facexh">*</font>公司性质：</label>
<select id="company_type" name="company_type">
<option value="">请选择</option>
                {if isset($this->data['company_type'])}
                    <option value="民营/私营公司" {if $this->data['company_type'] == "民营/私营公司"}selected="selected"{/if}>民营/私营公司</option>
                    <option value="外企代表处" {if $this->data['company_type'] == "外企代表处"}selected="selected"{/if}>外企代表处</option>
                    <option value="事业单位" {if $this->data['company_type'] == "事业单位"}selected="selected"{/if}>事业单位</option>
                    <option value="外资（欧美）" {if $this->data['company_type'] == "外资（欧美）"}selected="selected"{/if}>外资（欧美）</option>
                    <option value="外资（非欧美如日资）" {if $this->data['company_type'] == "外资（非欧美如日资）"}selected="selected"{/if}>外资（非欧美如日资）</option>
                    <option value="台资、港资" {if $this->data['company_type'] == "台资、港资"}selected="selected"{/if}>台资、港资</option>
                    <option value="合资（欧美）" {if $this->data['company_type'] == "合资（欧美）"}selected="selected"{/if}>合资（欧美）</option>
                    <option value="合资（非欧美）" {if $this->data['company_type'] == "合资（非欧美）"}selected="selected"{/if}>合资（非欧美）</option>
                    <option value="国营企业" {if $this->data['company_type'] == "国营企业"}selected="selected"{/if}>国营企业</option>
                    <option value="上市公司" {if $this->data['company_type'] == "上市公司"}selected="selected"{/if}>上市公司</option>
                    <option value="私营股份制" {if $this->data['company_type'] == "私营股份制"}selected="selected"{/if}>私营股份制</option>
                    <option value="其他" {if $this->data['company_type'] == "其他"}selected="selected"{/if}>其他</option>
                {else}
                    <option value="民营/私营公司" {if $memberAttribute.CompanyAttribute.company_type == "民营/私营公司"}selected="selected"{/if}>民营/私营公司</option>
                    <option value="外企代表处" {if $memberAttribute.CompanyAttribute.company_type == "外企代表处"}selected="selected"{/if}>外企代表处</option>
                    <option value="外企代表处" {if $memberAttribute.CompanyAttribute.company_type == "外企代表处"}selected="selected"{/if}>事业单位</option>
                    <option value="外资（欧美）" {if $memberAttribute.CompanyAttribute.company_type == "外资（欧美）"}selected="selected"{/if}>外资（欧美）</option>
                    <option value="外资（非欧美如日资）" {if $memberAttribute.CompanyAttribute.company_type == "外资（非欧美如日资）"}selected="selected"{/if}>外资（非欧美如日资）</option>
                    <option value="台资、港资" {if $memberAttribute.CompanyAttribute.company_type == "台资、港资"}selected="selected"{/if}>台资、港资</option>
                    <option value="合资（欧美）" {if $memberAttribute.CompanyAttribute.company_type == "合资（欧美）"}selected="selected"{/if}>合资（欧美）</option>
                    <option value="合资（非欧美）" {if $memberAttribute.CompanyAttribute.company_type == "合资（非欧美）"}selected="selected"{/if}>合资（非欧美）</option>
                    <option value="国营企业" {if $memberAttribute.CompanyAttribute.company_type == "国营企业"}selected="selected"{/if}>国营企业</option>
                    <option value="上市公司" {if $memberAttribute.CompanyAttribute.company_type == "上市公司"}selected="selected"{/if}>上市公司</option>
                    <option value="私营股份制" {if $memberAttribute.CompanyAttribute.company_type == "私营股份制"}selected="selected"{/if}>私营股份制</option>
                    <option value="其他" {if $memberAttribute.CompanyAttribute.company_type == "其他"}selected="selected"{/if}>其他</option>
                {/if}
              </select>          </li>
          <li>
            <label><font class="facexh">*</font>从事行业：</label>
            <select name="category_id" id="category_id">
            <option value="">请选择</option>
                {foreach $this->Category->parentCategoryList() as $value}
                    <option value="{$value.Category.id}"
                    {if isset($this->data['category_id']) && $this->data['category_id'] == $value.Category.id}
                        selected="selected"
                    {elseif isset($memberAttribute.CompanyAttribute.category_id) && $memberAttribute.CompanyAttribute.category_id == $value.Category.id}
                        selected="selected"
                    {/if}>
                    {$value.Category.name}
                    </option>
                {/foreach}
            </select>
          </li>
          <li>
            <label>其他行业：</label>
            <input type="text" class="inpTextBox" id="acpro_inp7">
          </li>
          <li>
            <label><font class="facexh">*</font>提供产品或服务：</label>
            <ul class="products">
            {if isset($this->data['service'])}
                {$services = $this->data['service']}
                {$sub_categories = $this->Category->childrenCategoryList($this->data['category_id'])}
                {foreach $sub_categories as $category}
                    <li>
                        <label><input type="checkbox" name="service[]" class="inpCheckbox" value="{$category.Category.id}" {if in_array($category.Category.id, $services)}checked="checked"{/if}>{$category.Category.name}</label>
                    </li>
                {/foreach}
            {else}
                {$services = explode(',', $memberAttribute.CompanyAttribute.service)}
                {$sub_categories = $this->Category->childrenCategoryList($memberAttribute.CompanyAttribute.category_id)}
                {foreach $sub_categories as $category}
                    <li>
                        <label><input type="checkbox" name="service[]" class="inpCheckbox" value="{$category.Category.id}" {if in_array($category.Category.id, $services)}checked="checked"{/if}>{$category.Category.name}</label>
                    </li>
                {/foreach}
            {/if}
            </ul>
          </li>
          <li>
            <label><font class="facexh">*</font>业务范围：</label>
            <textarea name="business_scope" id="business_scope" cols="45" rows="5">{if isset($this->data['business_scope'])}{$this->data['business_scope']}{else}{$memberAttribute.CompanyAttribute.business_scope}{/if}</textarea>
          </li>          
          <li>
            <label><font class="facexh">*</font>验证码：</label>
            <input type="text" name="" style="width:40px;" class="inpTextBox" id="checkNum" />
            <a class="getCheckNum" id="getCheckNum" href="javascript:void(0)">看不清楚？</a>
          </li> 
          <li><a href="javascript:void(0)" class="zclan zclan4" id="check">确定</a></li>
        </ul>
       </form>
      </div>
</div>   