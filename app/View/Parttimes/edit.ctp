<script>
{literal}
$(document).ready(function(){
    datepIniChange("#open","indate");
    datepIniChange("#close","indate");
    
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
    //开始
    $('#check').click(function(){
        if (!checkData()) {
          $.ajax({
              url : '/members/getImageNumber',
              type : 'post',
              success : function(data)
              {
                  if (data == $("#checkNum").val().toUpperCase()) {
                      $("#parttimeForm").submit();
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
    
    var checkTarget = ['title','sub_title','contact','verificationCode','checkNum'];
    var errorMsg = '<span class="errorMsg">请完善此项目</span>';
    function checkData() {
        var error=0;
        $(".sjle").find('.errorMsg').remove();
        $.each(checkTarget, function(target){            
            if($('#' + this).val() == "") {
                $('#' + this).parents(".sjle dl dt").append(errorMsg);
                error=1;
            } 
        });
        
        if($('#sub_category').val() == "") {
           $('#sub_category').parents(".sjle dl dt").append(errorMsg);
            error = 1;            
        } 
        
        if($("#open").val()==""||$("#close").val()=="") {
            $("#open").parents(".sjle dl dt").append(errorMsg);
        } else {
            if($("#open").val()>$("#close").val()) {
                $("#open").parents(".sjle dl dt").append(errorMsg);
                error = 1;
            } 
        }
        
        if ($(".city .selectedOpts li").length == 0){
            $('.city').parents(".dtSwitchBox").append('<span class="errorMsg" style="left: 240px;">请完善此项目</span>');            
            error = 1;
        } 
        
        $(".divSex input:radio:checked").each(function(index,element) {
            if($(this).next().length !=0) {
                if($(this).next().val()=="") {
                    $(this).parents(".sjle dl dt").append(errorMsg);
                    error = 1;
                } 
            } 
        });            

        $('.contact_content').each(function(){
            if ($(this).val() == "") {
                $(this).parent().append(errorMsg);
                error=1;
            } 
        });
         if ($("#vehicle").attr("checked")!="checked") {
              error = 1;
              $("#vehicle").parent().append('<span class="errorMsg">请接受协议</span>');
          }        
         if ($("#checkNum").val().trim() == "") {
              error = 1;
              $("#checkNum").parent().append(errorMsg);
          }    
        return error;
    }
    //结束
    
    $("button.addContact").live("click",function(e){
        e.preventDefault();
        $(this).parent().after($(this).parent().clone());
        $(this).parent().next().children(".inpTextBox").val("");
    });
    $("button.deleContact").live("click",function(e){
        e.preventDefault();
        if ($("button.deleContact").length>1) $(this).parent().remove(); 
    });
    
    //check number
    $('#getCheckNum').prepend('<img id="code" src="/members/image">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">平台兼职</a>&gt;&gt;
      <a href="javascript:void(0)">发布兼职</a>
      </p>
    </div>
      <ul class="ulFormStep">
      <li>1.填写兼职信息</li>
      <li>2.确认兼职信息</li>
      <li>3.兼职发布成功</li>
    </ul>
      <div class="sjle" style="min-height:896px;">
        <form method="post" action="/parttimes/check" id="parttimeForm">
          <dl>
            <dt>
              <label><font class="facexh">*</font>信息标题：</label>
              <input type="text" name="title" id="title" value="{$parttime.PartTime.title}" />
            </dt>
            <dt class="productKinds">
              <label><font class="facexh">*</font>产品所属分类：</label>
                <select name="category" id="category">
                    <option value="">请选择</option>
                    {foreach $this->Category->parentCategoryList() as $value}
                        <option value="{$value.Category.id}" {if $value.Category.id == $parttime.PartTime.category}selected="selected"{/if}>{$value.Category.name}</option>
                    {/foreach}
                </select>
                <select name="sub_category" id="sub_category">
                <option value="">请选择</option>
                {foreach $this->Category->childrenCategoryList($parttime.PartTime.category) as $value}
                    <option value="{$value.Category.id}" {if $value.Category.id == $parttime.PartTime.sub_category}selected="selected"{/if}>{$value.Category.name}</option>
                {/foreach}
                </select>
            </dt>
            <dt>
              <label><font class="facexh">*</font>产品具体名称：</label>
              <input type="text" name="sub_title" id="sub_title" value="{$parttime.PartTime.sub_title}">
            </dt>
            <dt>
              <label><font class="facexh">*</font>兼职时间：</label>
              <ul class="validity" style="width:230px;">
                <li>
                  <input type="text" name="open" id="open"  readonly="readonly" value="{$parttime.PartTime.open|date_format:"%Y-%m-%d"}"/>
                </li>
                <li style="width:36px;text-align:center">至</li>
                <li>
                  <input type="text" name="close" id="close"  readonly="readonly" value="{$parttime.PartTime.close|date_format:"%Y-%m-%d"}"/>
                </li>
              </ul>
            </dt>
            <dt style="overflow:visible">
              <label><font class="facexh">*</font>客户区域范围：</label>
              <div class="switchBox dtSwitchBox">
    <ul>
    {$areas = explode(',', $parttime.PartTime.area)}
    {$parentAreas = $this->City->getParentByChilds($areas)}
      <li class="lists city"><span class="title">
        <input type="button" value="选择城市" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>城市选择器</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">返回省份</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->City->parentCityList() as $city}
                <dd>
                  <label>
                    <input type="checkbox" value="{$city.City.id}" {if in_array($city.City.id, $parentAreas)}checked="checked"{/if}class="inpCheckbox">
                    {$city.City.name}</label>
                </dd>
                {/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
            </dd>
            <dt>您已经选择的城市是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected" style="display: block;">
                {foreach $areas as $area}
                <dd><label><input type="checkbox" value="{$area}" class="inpCheckbox" checked="checked">{$this->City->cityName($area)}</label></dd>
                {/foreach}
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts" style="display: block;">
        {foreach $areas as $area}
        <li><input type="hidden" name="citys[]" value="{$area}" />{$this->City->cityName($area)}</li>
        {/foreach}
        </ul>
      </li>
      </ul>
  </div>
            </dt>
            <dt>
              <label><font class="facexh">*</font>兼职配合方式：</label>
              <div class="divSex cooperationWay">
                <label><input type="radio" name="method" checked="checked" value="1"/>提供客户信息</label>                
                <label><input type="radio" name="method" value="2"/>协助跟单</label>
                <label><input type="radio" name="method" value="3"/>独立签单</label>
              </div>
            </dt>
            <dt>
              <label><font class="facexh">*</font>报酬：</label>
              <div class="divSex cooperationWay">
                <label>
                {if $parttime.PartTime.pay == 1}
                    <input type="radio" name="pay" value="1" onclick="$(this).next().focus();" checked="checked"/>按合同金额
                    <input type="text" name="pay_rate" value="{$parttime.PartTime.pay_rate}" onpaste="coinNum(this)" onkeyup="coinNum(this)"/>%
                {else}
                    <input type="radio" name="pay" value="1" onclick="$(this).next().focus();"/>按合同金额
                    <input type="text" name="pay_rate" onpaste="coinNum(this)" onkeyup="coinNum(this)"/>%
                {/if}
                </label>
                <label>
                {if $parttime.PartTime.pay == 2}
                    <input type="radio" name="pay" value="2" onclick="$(this).next().focus();" checked="checked"/>按单数，每单
                    <input type="text" name="pay_money" value="{$parttime.PartTime.pay_rate}" onpaste="coinNum(this)" onkeyup="coinNum(this)"/>元
                {else}
                    <input type="radio" name="pay" value="2" onclick="$(this).next().focus();" />按单数，每单
                    <input type="text" name="pay_money" onpaste="coinNum(this)" onkeyup="coinNum(this)"/>元
                {/if}
                </label>
                <label>
                {if $parttime.PartTime.pay == 3}
                    <input type="radio" name="pay" value="3" checked="checked"/>协商确定
                {/if}
                </label>
              </div>
            </dt>
            <dt>
              <label><font class="facexh">*</font>报酬支付时间：</label>
              <div class="divSex cooperationWay">
                <label>
                <input type="radio" name="pay_method" {if $parttime.PartTime.pay_method == 1}checked="checked"{/if} value="1" onclick="$(this).next().focus();"/>收款后
                <input type="text" name="pay_time" id="pay_time" value="{$parttime.PartTime.pay_time}" onpaste="onlyNum(this)" onkeyup="onlyNum(this)"/>个工作日内转账
                </label>
                <label><input type="radio" name="pay_method" value="0" {if $parttime.PartTime.pay_method == 0}checked="checked"{/if}/>其它</label>
              </div>
            </dt>
            <dt>
              <label>报酬支付说明：</label>
              <textarea cols="45" rows="5" name="pay_explanation">{$parttime.PartTime.pay_explanation}</textarea>
            </dt>
            <dt style="overflow:visible">
              <label>兼职者推荐参与行业：</label>
              <div class="switchBox dtSwitchBox">
    <ul>
      <li class="lists trade"><span class="title">
      {$industries = explode(',', $parttime.PartTime.industry)}
        <input type="button" value="行业（可选）" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>行业选择器</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">行业</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->Category->parentCategoryList() as $value}
                <dd>
                  <label>
                    <input type="checkbox" value="{$value.Category.id}" {if in_array($value.Category.id, $industries)}selected="selected"{/if} class="inpCheckbox">
                    {$value.Category.name}</label>
                </dd>
                {/foreach}
              </dl>
            </dd>
            <dt>您已经选择的行业是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected" style="display: block;">
                {foreach $industries as $industry}
                <dd><label><input type="checkbox" class="inpCheckbox" value="{$industry}" checked="checked">{$this->Category->getCategoryName($industry)}</label></dd>
                {/foreach}
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts" style="display: block;">
        {foreach $industries as $industry}
        <li><input type="hidden" name="categorys[]" value="{$industry}" />{$this->Category->getCategoryName($industry)}</li>
        {/foreach}
        </ul>
      </li>
      </ul>
  </div>
            </dt>
            <dt>
            <label><font class="facexh">*</font>联系人：</label>
            <input type="text" class="contact" name="contact" id="contact" value="{$parttime.PartTime.contact}" />
          </dt>
          {$contacts = json_decode($parttime.PartTime.contact_method, true)}
          {foreach $contacts as $contact}
            <dt>
            <label><font class="facexh">*</font>联系方式：</label>
            <div class="area1">
              <select name="contact_method[]">
                <option value="座机" {if $contact.method == "座机"}selected="selected"{/if}>座机</option>
                <option value="手机" {if $contact.method == "手机"}selected="selected"{/if}>手机</option>
                <option value="E-mail" {if $contact.method == "E-mail"}selected="selected"{/if}>E-mail</option>
                <option value="QQ" {if $contact.method == "QQ"}selected="selected"{/if}>Q Q</option>
                <option value="MSN" {if $contact.method == "MSN"}selected="selected"{/if}>MSN</option>
                <option value="Skype" {if $contact.method == "Skype"}selected="selected"{/if}>Skype</option>
                <option value="其他" {if $contact.method == "其他"}selected="selected"{/if}>其他</option>
              </select>
            </div>
            <input type="text" name="contact_content[]" value="{$contact.number}" style="width:108px;" class="contact_content" onpaste="Emailstr(this)" onkeyup="Emailstr(this)"/>
            <button class="addContact">添加</button><button class="deleContact">删除</button>
          </dt>
          {/foreach}
            <!--<dt>
              <label>联系邮箱：</label>
              <input type="text" class="post" name="email" value="{if isset($this->data['email'])}{$this->data['email']}{/if}" />
              （如果有多个邮箱，请以“,”隔开） </dt>-->
            <dt>
              <label>联系地址：</label>
              <input type="text" name="address" class="contact_method" value="{$parttime.PartTime.address}" />
            </dt>
            <dt>
              <label>兼职补充说明：</label>
              <textarea cols="45" rows="5" name="additional">{$parttime.PartTime.additional}</textarea>
            </dt>
            <dt>
              <label><font class="facexh">*</font>验证码：</label>
              <input type="text" name="verificationCode" id="checkNum" style="width:60px;" class="inpTextBox">
              <a href="javascript:void(0)" id="getCheckNum" class="getCheckNum" >看不清？</a>
          </dt>
          </dl>
          <div class="clearfix"></div>
          <div class="divProtocol">
            <label for="vehicle" class="protocol">
                <input type="checkbox" class="inpCheckbox" name="vehicle" id="vehicle">我接受 <a target="_blank" href="/static?tpl=mianze">《聚业务服务协议（试行）》</a>
            </label>
        </div>
        <div class="clearfix"></div>
            <input type="hidden" name="id" value="{$this->request->query['id']}" />
            <a class="zclan zclan4" href="javascript:void(0)" id="check">提交</a>
        </form>
      </div>
    </div>