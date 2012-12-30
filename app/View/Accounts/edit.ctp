<script type="text/javascript">
{literal}
$(document).ready(function(){
    datepIniChange("#birthday",1960,2010);
    $('#category_id').change(function(){
        $('ul.products').html('');
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
    $('#nickname').blur(function(){
        if ($('#nickname').val() != "") {
            $.ajax({
                type:    'post',
                url :    '/members/existMember',
                data:     'nickname=' + $('#nickname').val() + "&type=0",
                success    : function(data) {
                    $('#nickname + span').remove();
                    if(data == '1') {
                        if ($('#nickname + span').length == 0) {
                            $('#nickname').after('<span style="color:red; margin-left:10px">该昵称已经被使用！</span>');
                        }
                        existNickname = true;
                    } else {
                        existNickname = false;
                    }
                    
                }
            })
        }
    });
    $('#check').click(function(){
		if (!checkData()) {
			$("#editForm").submit();
		}
	});
	var checkTarget = ['name','nickname','mobile','business_scope','birthday'];
	var errorMsg = '<span class="errorMsg">请输入此项目</span>';
	var errorCKB = '<span class="errorMsg">请选择合适项目</span>';
	function checkData() 
	{
		var error=0;
		$.each(checkTarget, function(target){
			if($('#' + this).val() == "") {
				if($('#' + this).parent().find('.errorMsg').length == 0) {
					$('#' + this).parent().append(errorMsg);
				}
				error=1;
			} else {
				$('#' + this).parent().find('.errorMsg').remove();
			}
		});			
		if ($('#provincial_id').val() == "请选择"||$('#city').val() == "undefined") {
			if($('#provincial_id').parent().parent().find('.errorMsg').length == 0) {
				$('#provincial_id').parent().parent().append(errorMsg);
			}
			error=1;
		} else {
			$('#city').parent().parent().find('.errorMsg').remove();
		}		
		if ($('.products input:checkbox:checked').length==0) {
			if($('ul .products').parent().find('.errorCKB').length == 0) {
				$('ul .products').parent().append(errorCKB);
			}
			error=1;
		} else {
			$('ul .products').parent().find('.errorCKB').remove();
		}		
		return error;
	}
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html">账号管理</a>&gt;&gt;<a href="#">个人信息修改</a></p>
    </div> 
    <div class="hysj">
        <ul>
            <li>1.信息修改</li>
            <li>2.信息确认</li>
            <li>3.修改成功</li>
        </ul> 
      <div class="sjle">
      <form id="editForm" action="/accounts/editCheck" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label><font class="facexh">*</font>真实姓名：</label>
                <input type="text" id="name" name="name" value="{if isset($this->data['name'])}{$this->data['name']}{else}{$memberAttribute.MemberAttribute.name}{/if}"/>
            </li>
          <li>
            <label><font class="facexh">*</font>昵称：</label>
            <input type="text" id="nickname" name="nickname" value="{if isset($this->data['nickname'])}{$this->data['nickname']}{else}{$memberBase.Member.nickname}{/if}"/>
          </li>
          <li>
            <label><font class="facexh">*</font>性别：</label>
            <div class="divSex">
              <input type="radio" {if isset($this->data['sex']) && $this->data['sex'] == 1}checked="checked"{elseif isset($memberAttribute.MemberAttribute.sex) && $memberAttribute.MemberAttribute.sex == 1}checked="checked"{/if} class="inpRadio" id="sex1" name="sex" value="1">
              <label for="sex1">男</label>
              <input type="radio" class="inpRadio" {if isset($this->data['sex']) && $this->data['sex'] == 0}checked="checked"{elseif isset($memberAttribute.MemberAttribute.sex) && $memberAttribute.MemberAttribute.sex == 0}checked="checked"{/if} id="sex2" name="sex" value="0">
              <label for="sex2">女</label>
            </div>
          </li>
          <li>
             <label>生日：</label>
             <input type="text" name="birthday" id="birthday" readonly="readonly" value="{if isset($this->data['birthday'])}{$this->data['birthday']}{elseif isset($memberAttribute.MemberAttribute.birthday)}{$memberAttribute.MemberAttribute.birthday|date_format:"%Y-%m-%d"}{/if}"/>
          </li>
          <li>
            <label><font class="facexh">*</font>所在城市：</label>
            <div class="area1">
              <select name="provincial_id" id="provincial_id">
                <option>请选择</option>
                {foreach $this->City->parentCityList() as $city}
                <option value="{$city.City.id}" 
                {if isset($this->data['provincial_id']) && $this->data['provincial_id'] == $city.City.id}
                selected="selected"
                {elseif isset($memberAttribute.MemberAttribute.provincial_id) && $memberAttribute.MemberAttribute.provincial_id == $city.City.id}
                selected="selected"
                {/if}>{$city.City.name}
                </option>
                {/foreach}
              </select>
            </div>
            <div class="area1">
              <select name="city_id" id="city_id">
                <option>请选择</option>
                {if isset($this->data['provincial_id'])}
                    {$parent_id = $this->data['provincial_id']}
                {else}
                    {$parent_id = $memberAttribute.MemberAttribute.provincial_id}
                {/if}
                {foreach $this->City->childrenCityList($parent_id) as $child}
                    <option value="{$child.City.id}" 
                    {if isset($this->data['city_id']) && $this->data['city_id'] == $child.City.id}
                        selected="selected"
                    {elseif isset($memberAttribute.MemberAttribute.city_id) && $memberAttribute.MemberAttribute.city_id == $child.City.id}
                        selected="selected"
                    {/if}>{$child.City.name}
                    </option>
                {/foreach}
              </select>
            </div>
          </li>
          <li>
            <label><font class="facexh">*</font>手机号码：</label>
            <input type="text" id="mobile" name="mobile" value="{if isset($this->data['mobile'])}{$this->data['mobile']}{else}{$memberAttribute.MemberAttribute.mobile}{/if}" onkeyup="onlyNum(this)" onpaste="onlyNum(this)">
          </li>
          <li>
            <label>联系电话：</label>
            <input type="text" name="telephone" value="{if isset($this->data['telephone'])}{$this->data['telephone']}{else}{$memberAttribute.MemberAttribute.telephone}{/if}" onkeyup="phoneNum(this)" onpaste="phoneNum(this)">
          </li>
          <li>
            <label>公司名称：</label>
            <input type="text" name="company" value="{if isset($this->data['company'])}{$this->data['company']}{else}{$memberAttribute.MemberAttribute.company}{/if}">
          </li>
          <li>
            <label><font class="facexh">*</font>从事行业：</label>
            <div class="area1">
                <select name="category_id" id="category_id">
                    {foreach $this->Category->parentCategoryList() as $value}
                        <option value="{$value.Category.id}"
                        {if isset($this->data['category_id']) && $this->data['category_id'] == $value.Category.id}
                            selected="selected"
                        {elseif isset($memberAttribute.MemberAttribute.category_id) && $memberAttribute.MemberAttribute.category_id == $value.Category.id}
                            selected="selected"
                        {/if}>
                        {$value.Category.name}
                        </option>
                    {/foreach}
                </select>
              </div>
          </li>
          <li>
            <label><font class="facexh">*</font>提供产品或服务：</label>
            <ul class="products">
                {if isset($this->data['service'])}
                    {$service = $this->data['service']}
                {else}
                    {$service = explode(',', $memberAttribute.MemberAttribute.service)}
                {/if}
                {if isset($this->data['category_id'])}
                    {$parent_id = $this->data['category_id']}
                {else}
                    {$parent_id = $memberAttribute.MemberAttribute.category_id}
                {/if}
                {$subCategory = $this->Category->childrenCategoryList($parent_id)}
                {foreach $subCategory as $category}
                     <li>
                        <input type="checkbox" name="service[]" value="{$category.Category.id}" {if in_array($category.Category.id, $service)}checked="checked"{/if} id="service[]{$category.Category.id}"/>
                        <label for="service[]{$category.Category.id}">{$category.Category.name}</label>
                    </li>
                {/foreach}
            </ul>
          </li>
          <li>
            <label><font class="facexh">*</font>业务范围：</label>
            <input type="text" id="business_scope" name="business_scope" value="{if isset($this->data['business_scope'])}{$this->data['business_scope']}{else}{$memberAttribute.MemberAttribute.business_scope}{/if}">
          </li>
          <li>
            <label>上传头像：</label>
            <input type="file" style="height:auto;height:22px;" size="20" id="face" name="face" class="inpFile">
          </li>
          <li><a class="zclan zclan4" href="javascript:void(0)" id="check">确定</a></li>
        </ul>      
      </form>
	  </div>
    </div>
    <!--<div class="bottomRcd">
      <div class="fl">
        <h3>热门悬赏<a class="more" href="#">更多...</a></h3>
        <ul>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元&nbsp;厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        </ul>
      </div>
      <div class="fl fr">
        <h3>最新客源<a class="more" href="#">更多...</a></h3>
        <ul>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元&nbsp;厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a href="#" class="li">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        </ul>
      </div>
    </div>  
    <div class="bottomRcdPos"></div>
    -->
</div>