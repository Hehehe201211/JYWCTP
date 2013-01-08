<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("button.addContact").live("click",function(e){
        e.preventDefault();
        $(this).parent().after($(this).parent().clone());
        $(this).parent().next().children(".inpTextBox").val("");
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
});
//{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;
            <a href="qy-slijzky.html">平台兼职</a>&gt;&gt;
            <a href="#">兼职发布详情</a>
        </p>
    </div>    
<ul class="ulFormStep">
      <li>1.完善资料</li>
      <li>2.信息确认</li>
      <li>3.修改成功</li>
    </ul>
    <div class="sjle">
       <form method="post" action="#">
        <ul>   
          <li>
            <label><font class="facexh">*</font>公司全名：</label>
            <input type="text" class="inpTextBox" name="full_name" id="full_name" value="{$memberAttribute.CompanyAttribute.full_name}">
          </li> 
          <li>
             <label>成立时间：</label>
             <input type="text" readonly="readonly" id="established" name="established" value="{$memberAttribute.CompanyAttribute.established}">
          </li>
          <li>
             <label><font class="facexh">*</font>联系人：</label>
             <input type="text" class="inpTextBox" id="contact" name="contact" value="{$memberAttribute.CompanyAttribute.contact}">
          </li>      
          <li>
            <label><font class="facexh">*</font>联系方式：</label>
            <div class="area1">
              <select name="contact_method[]">
                <option value="座机">座机</option>
                <option value="手机">手机</option>
                <option value="QQ">QQ</option>
                <option value="MSN">MSN</option>
              </select>
            </div>
            <input type="text" style="width:128px;" class="contact_method">
            <button class="addContact fl">添加</button><button class="deleContact fl">删除</button>
          </li>  
          <li>
            <label><font class="facexh">*</font>传真：</label>
            <input type="text" name="fax" class="inpTextBox" id="fax" value="{$memberAttribute.CompanyAttribute.fax}">
          </li>        
          <li>
            <label><font class="facexh">*</font>所在城市：</label>
            <div class="area1">
              <select name="provincial_id" id="provincial">
                <option value="">请选择</option>
                {foreach $this->City->parentCityList() as $city}
                    <option value="{$city.City.id}">{$city.City.name}</option>
                {/foreach}
              </select>
            </div>
            <div class="area1">
              <select name="city_id" id="city">
                <option value="">请选择</option>
              </select>
            </div>
          </li>
          <li>
            <label><font class="facexh">*</font>公司详细地址：</label>
            <input type="text" name="address" id="address" value="{$memberAttribute.CompanyAttribute.address}">
          </li>
          <li>
            <label><font class="facexh">*</font>公司性质：</label>
            <div class="select150">
              <select id="company_type" name="company_type">
                <option value="民营/私营公司">民营/私营公司</option>
                <option value="外企代表处">外企代表处</option>
                <option value="外企代表处">事业单位</option>
                <option value="外资（欧美）">外资（欧美）</option>
                <option value="外资（非欧美如日资）">外资（非欧美如日资）</option>
                <option value="台资、港资">台资、港资</option>
                <option value="合资（欧美）">合资（欧美）</option>
                <option value="合资（非欧美）">合资（非欧美）</option>
                <option value="国营企业">国营企业</option>
                <option value="上市公司">上市公司</option>
                <option value="私营股份制">私营股份制</option>
                <option value="其他">其他</option>
              </select>
            </div>
          </li>
          <li>
            <label><font class="facexh">*</font>从事行业：</label>
            <div class="area1">
            <select name="category_id" id="category">
            <option value="">请选择</option>
            {foreach $this->Category->parentCategoryList() as $value}
                <option value="{$value.Category.id}">{$value.Category.name}</option>
            {/foreach}
            </select>
            </div>
          </li>
          <li>
            <label>其他行业：</label>
            <input type="text" class="inpTextBox" id="acpro_inp7">
          </li>
          <li>
            <label><font class="facexh">*</font>提供产品或服务：</label>
            <ul class="products">
                {$services = explode(',', $memberAttribute.CompanyAttribute.service)}
                {$sub_categories = $this->Category->childrenCategoryList($memberAttribute.CompanyAttribute.category_id)}
                {foreach $sub_categories as $category}
                    <li>                      
                        <label><input type="checkbox" class="inpCheckbox" value="{$category.Category.id}" {if in_array($category.Category.id, $services)}checked="checked"{/if}>{$category.Category.name}</label>
                    </li>
                {/foreach}
            </ul>
          </li>
          <li>
            <label><font class="facexh">*</font>业务范围：</label>
            <textarea name="business_scope" id="business_scope" cols="45" rows="5">{$memberAttribute.CompanyAttribute.business_scope}</textarea>
          </li>          
          <li style="text-align: left;">
            <label><font class="facexh">*</font>验证码：</label>
            <input type="text" name="" style="width:60px;" class="inpTextBox" id="id="checkNum" />
            <a class="getCheckNum" id="getCheckNum" href="javascript:void(0)">看不清楚？换一个</a>
          </li> 
          <li><a href="javascript:void(0)" class="zclan zclan4">提交</a></li>
        </ul>
       </form>
      </div>
</div>   