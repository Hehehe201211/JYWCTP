<script type="text/javascript">
{literal}
$(document).ready(function(){
    datepIniChange("#established",1960,2012);
    
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
            $.ajax({
                'type'  : 'Get',
                'url'   : '/informations/getCategoryList/' + $(this).val(),
                'success':function(data) {
                    var dataobj=eval("("+data+")");
                    var liStr = "";
                    $.each(dataobj, function(idx, item){
                        liStr += '<li><input type="checkbox" class="sub_category" name="service[]" value="' + item.Category.id + '" id="products' + item.Category.id + '"><label for="products"' + item.Category.id + '>' + item.Category.name + '</label></li>'
                    });
                    $('ul.products').html(liStr);
                }
            });
        }
    });
    //地图    
    /*var strPosition;
    $("#tglMap").toggle(function(e){
        e.preventDefault();
        $(".divMapContainer").slideDown("fast",function(){
           strPosition=new googlemapjsv3({lat:"",lng:"",strCompany:""});
        });
        $(this).text("停用地图标记");
    },function(e){      
        e.preventDefault();
        $(".divMapContainer").slideUp("fast");
        $(this).text("启用地图标记");
        strPosition=null;
    });*/	
	
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
		$.each(checkTarget, function(target){
			if($('#' + this).val() == "") {
				if($('#' + this).parents(".sjle ul li").find('.errorMsg').length == 0) {
					$('#' + this).parents(".sjle ul li").append(errorMsg);
				}
				error=1;
			} else {
				$('#' + this).parents(".sjle ul li").find('.errorMsg').remove();
			}
		});
		
		$('.contact_method').each(function(){
			if ($(this).val() == "") {
				if($(this).parent().find('.errorMsg').length == 0) {
					$(this).parent().append(errorMsg);
				}
				error=1;
			} else {
				$(this).parent().find('.errorMsg').remove();
			}
		});
		
		if($('#category').val() == "") {
		   if ($('#category').parent().next('.errorMsg').length == 0) {
				  $('#category').parents(".sjle ul li").append(errorMsg);
		      }
			error = 1;			
		} else {
			$('#category').parents(".sjle ul li").find('.errorMsg').remove();
		}		
		if ($("input.sub_category:checked").length == 0){
        	if ($('.products').parent().find('.errorMsg').length == 0) {
        		$('.products').parent().append(errorMsg);
        	}
        	error = 1;
        } else {
        	$('.products').parent().find('.errorMsg').remove();
        }		
		if($('#vehicle').attr('checked') != "checked") {
		  if ($('.protocol').find('.errorMsg').length == 0) {
			$('.protocol').append('<span class="errorMsg">请接受协议内容</span>');
		  }
			error = 1
		} else {
			$('.protocol span').remove();
		}
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
    <div class="zy_zs"><!-- InstanceBeginEditable name="EditRegion7" -->
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="apep-zhaq.html">账号管理</a>&gt;&gt;<a href="#">企业会员升级</a></p>
      <!-- InstanceEndEditable -->
      <div class="zy_zszl enterpriseInfo">
        <div class="zy_zszl_z">
          <dl>
            <dt>
              <dl>
                <dt><img src="{$this->webroot}img/tx.jpg" /></dt>
                <dd class="mebInfo"><span>会员昵称：聚业务</span><span>公司名称：厦门有限公司厦门有限公司</span><span>绑定邮箱：ya*****@qq.com</span><span>行业：互联网</span><span>地址：福建省厦门市</span></dd>
              </dl>
            </dt>
            <dd><span>账户有效期：2012-09-20&nbsp;至&nbsp;2013-09-20</span></dd>
            <!--<dd><span>资料完整度：</span><span class="progressBar"><span>&nbsp;20%&nbsp;</span></span><a href="#">完善资料</a><a class="icon iconZ" href="#" title="营业执照已认证"></a><a class="icon iconM" href="#" title="未绑定邮箱"></a></dd>-->
          </dl>
        </div>
        <div class="zy_zszl_r">
          <dl>            
            <dd><span>简历总量：<strong>0</strong>份</span><span>常规招聘总职位：<strong>0</strong>个</span><span>平台兼职总职位：<strong>0</strong>个</span><span>高级个人会员：<strong>0</strong>位</span><span>高级企业会员：<strong>0</strong>家</span><span><a class="upgrade" href="apep-hysj1.html">升级到高级会员</a></span></dd>
          </dl>
        </div>
      </div>
    </div>
    <!-- InstanceBeginEditable name="EditRegion5" -->
    <div class="hysj">  
    <ul>
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
                <option>座机</option>
                <option>手机</option>
                <option>QQ</option>
                <option>MSN</option>
              </select>
            </div>
            <input type="text" style="width:128px;" name="contact_content[]" class="contact_method">
            <button class="addContact fl">添加</button><button class="deleContact fl">删除</button>
          </li>  
          <li>
            <label><font class="facexh">*</font>传真：</label>
            <input type="text" name="fax" id="fax"/>
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
            <input type="text" name="address" id="address">
          </li>
          <li>
            <label><font class="facexh">*</font>公司性质：</label>
            <div class="select150">
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
            <input name="license" type="file" id="license"/><p style="width:150px;" class="imgfilesize">（文件大小不超过500K）</p>
          </li>
          <li>
             <div class="divMapContainer">
               <div class="divInput"><input type="text" id="geostrPosition" value="输入地址查询"/><input type="button" value="搜索" id="codeAddress"/><input type="hidden" id="comlatlng" /></div>
               <div id="mapLayout"></div>
             </div>  
             <a href="#" id="tglMap">启用地图标记</a>
          </li>
          <li style="text-align: left;">
            <label><font class="facexh">*</font>验证码：</label>
            <input type="text" name="verificationCode" id="verificationCode" style="width:60px;" class="inpTextBox">
            <a href="#"><img class="imgYanzhengma" src="{$this->webroot}img/num_03.jpg">看不清楚？换一个</a> 
          </li>
          <li>
            <label for="vehicle" class="protocol">
              <input type="checkbox" name="vehicle" id="vehicle"/>
              我接受 <a href="#">《聚业务服务协议（试行）》</a>
            </label>
          </li>
          <li><a class="zclan" href="javascript:void(0)">提交</a></li>
        </ul>
       </form>
      </div>
    </div>
    <!-- InstanceEndEditable --> </div>