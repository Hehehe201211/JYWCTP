<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("button.addContact").live("click",function(e){
        e.preventDefault();
        $(this).parents(".sjle dl dt").after($(this).parents(".sjle dl dt").clone());
        $(this).parents(".sjle dl dt").next().children(".inpTextBox").val("");
    });
    $("button.deleContact").live("click",function(e){
        e.preventDefault();
        if ($("button.deleContact").length>1) $(this).parents(".sjle dl dt").remove(); 
    });
    $('#getCheckNum').prepend('<img id="code" src="/members/image/' + Math.random() +'">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
    
    var span=$("dt .spanValue");
    var inp=span.prev();
    inp.hide();
    var checkTarget = ['domain','contact','post','address','introduction','checkNum','company_type','scale'];
    var errorMsg = '<span class="errorMsg">请完善此项目</span>';
    $("#check").click(function(){
        var error = false;
        if ($(this).text()=="修改") {
            $(this).text("保存");
            inp.show();
            span.hide();
            $("#dtCheckNum").show();
            $("html,body").animate({scrollTop:0},"normal");
        } else {    
		$(".sjle").find(".errorMsg").remove();        
        $.each(checkTarget, function(target){            
            if($('#' + this).val() == "") {
                $('#' + this).parents(".sjle dl dt").append(errorMsg);
                error=1;
            } 
        });        
        $('.contact_content').each(function(){
            if ($(this).val() == "") {
                $(this).parent().append(errorMsg);
                error=1;
            } 
        });
            
        if (!error) {
            $('#servicesForm').submit();
        /*
            alert("资料修改成功。");
            $(this).text("修改");
            span.show();
            inp.hide();
            $("#dtCheckNum").hide();
            $("html,body").animate({scrollTop:0},"normal");
            var error=0;
            */            
          }
        }
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">企业服务</a>&gt;&gt;
      <a href="javascript:void(0)">公司简介</a>
      </p>
    </div>    
    <div class="biaotit"><a href="/homes/index/{$homepage.Homepage.domain}" target="_blank" class="mebgszyT">查看公司首页</a>公司主页设置</div>
    <div class="sjle"> 
    <form id="servicesForm" method="post" action="/services/saveHome" enctype="multipart/form-data">
    {*var_dump($homepage.Homepage)*}
    {if !empty($homepage)}
        <dl>
          <dt>
            <label><font class="facexh">*</font>主页英文名：</label>
            <input type="text" name="domain" id="domain" readonly value="{$homepage.Homepage.domain}" onfocus="this.select();" placeholder="一旦设置，不可更改。">
            <span class="spanValue">{$homepage.Homepage.domain}</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>系统检索：</label>
            <div class="divSex">              
              <label><input type="radio" value="1" name="display" class="inpRadio" checked="checked" />开启</label>
              <label><input type="radio" value="0" name="display" class="inpRadio"/>关闭</label>
            </div>
            <span class="spanValue">开启</span>
          </dt>
          <dt>
            <label>公司名称：</label>
            <input type="text" name="company_name" value="{$homepage.Homepage.company_name}" />
            <span class="spanValue">{$homepage.Homepage.company_name}</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>联系人：</label>
            <input type="text" name="contact" id="contact" value="{$homepage.Homepage.contact}" class="contact" />
            <span class="spanValue">{$homepage.Homepage.contact}</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>联系人职位：</label>
            <input type="text" name="post" id="post" value="{$homepage.Homepage.post}" class="post" />
            <span class="spanValue">{$homepage.Homepage.post}</span>
          </dt>
          {$contact_methods = json_decode($homepage.Homepage.contact_method, true)}
          {foreach $contact_methods as $method}
          <dt>
            <label><font class="facexh">*</font>联系方式：</label>
            <div style="float:left;">
            <div class="area1">
              <select name="contact_methods[]">
                <option value="座机" {if $method.method == "座机"}selected="selected"{/if}>座机</option>
                <option value="手机" {if $method.method == "手机"}selected="selected"{/if}>手机</option>
                <option value="QQ" {if $method.method == "QQ"}selected="selected"{/if}>QQ</option>
                <option value="MSN" {if $method.method == "MSN"}selected="selected"{/if}>MSN</option>
              </select>
            </div>
            <input type="text" style="width:108px;" value="{$method.number}" name="contact_numbers[]" class="contact_content" onkeyup="Emailstr(this)" onpaste="Emailstr(this)">
            <button class="addContact">添加</button><button class="deleContact">删除</button>
            </div>
            <span class="spanValue">{$method.method} {$method.number}</span>
          </dt>
          {/foreach}
          <dt>
            <label>传真：</label>
            <input type="text" name="fax" value="{$homepage.Homepage.fax}" />
            <span class="spanValue">{$homepage.Homepage.fax}</span>
          </dt>
          <dt>
            <label>E-mail：</label>
            <input type="text" name="email" value="{$homepage.Homepage.email}" onkeyup="Emailstr(this)" onpaste="Emailstr(this)"/>
            <span class="spanValue">{$homepage.Homepage.email}</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>公司地址：</label>
            <input type="text" name="address" id="address" value="{$homepage.Homepage.address}" />
            <span class="spanValue">{$homepage.Homepage.address}</span>
          </dt>          
          <dt>
            <label><font class="facexh">*</font>公司类型：</label>
            <div>
              <select name="company_type" id="company_type">
                <option value="">请选择</option>
                <option value="民营/私营公司" {if $homepage.Homepage.company_type == "民营/私营公司"}selected="selected" {/if}>民营/私营公司</option>
                <option value="外企代表处" {if $homepage.Homepage.company_type == "外企代表处"}selected="selected" {/if}>外企代表处</option>
                <option value="事业单位" {if $homepage.Homepage.company_type == "事业单位"}selected="selected" {/if}>事业单位</option>
                <option value="外资（欧美）" {if $homepage.Homepage.company_type == "外资（欧美）"}selected="selected" {/if}>外资（欧美）</option>
                <option value="外资（非欧美如日资）" {if $homepage.Homepage.company_type == "外资（非欧美如日资）"}selected="selected" {/if}>外资（非欧美如日资）</option>
                <option value="台资、港资" {if $homepage.Homepage.company_type == "台资、港资"}selected="selected" {/if}>台资、港资</option>
                <option value="合资（欧美）" {if $homepage.Homepage.company_type == "合资（欧美）"}selected="selected" {/if}>合资（欧美）</option>
                <option value="合资（非欧美）" {if $homepage.Homepage.company_type == "合资（非欧美）"}selected="selected" {/if}>合资（非欧美）</option>
                <option value="国营企业" {if $homepage.Homepage.company_type == "国营企业"}selected="selected" {/if}>国营企业</option>
                <option value="上市公司" {if $homepage.Homepage.company_type == "上市公司"}selected="selected" {/if}>上市公司</option>
                <option value="私营股份制" {if $homepage.Homepage.company_type == "私营股份制"} {/if}>私营股份制</option>
                <option value="其他" {if $homepage.Homepage.company_type == "其他"}selected="selected" {/if}>其他</option>
              </select>
            </div>
            <span class="spanValue">{$homepage.Homepage.company_type}</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>公司规模：</label>
            <div>
              <select name="scale" id="scale">
                <option value="">请选择</option>
                <option value="1" {if $homepage.Homepage.scale == 1}selected="selected"{$scale="10人以下"}{/if}>10人以下</option>
                <option value="2" {if $homepage.Homepage.scale == 2}selected="selected"{$scale="10-50人"}{/if}>10-50人</option>
                <option value="3" {if $homepage.Homepage.scale == 3}selected="selected"{$scale="50-100人"}{/if}>50-100人</option>
                <option value="4" {if $homepage.Homepage.scale == 4}selected="selected"{$scale="100-200人"}{/if}>100-200人</option>
                <option value="5" {if $homepage.Homepage.scale == 5}selected="selected"{$scale="200人以上"}{/if}>200人以上</option>
              </select>
            </div>
            <span class="spanValue">{$scale}</span>
          </dt>
          <dt>
            <label>公司网站：</label>
            <input type="text" name="url" value="{$homepage.Homepage.url}" />
            <span class="spanValue">{$homepage.Homepage.url}</span>
          </dt>
          <dt>
            <label>公司简介图片：</label>
            <div style="float:left;">
            <input type="file" name="thumbnail"><p class="advise">（图片文件大小不超过300K。）</p>
            </div>
            <span class="spanValue spanValueI">{if !empty($homepage.Homepage.thumbnail)}<img src="{$this->webroot}{$homepage.Homepage.thumbnail}" />{/if}</span>
          </dt>
		  <dt>
            <label>企业招聘图片：</label>
            <div style="float:left;">
            <input type="file" name="thumbnail_job"><p class="advise">（图片分辨率为159x60px，大小不超过300K。）</p>
            </div>
            <span class="spanValue spanValueI">{if !empty($homepage.Homepage.thumbnail_job)}<img src="{$this->webroot}{$homepage.Homepage.thumbnail_job}" />{/if}</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>公司简介：</label>
            <textarea rows="5" cols="45" id="introduction" name="introduction" >{$homepage.Homepage.introduction|replace:"<br/>":"\n"}</textarea>
            <span class="spanValue spanValueP">{$homepage.Homepage.introduction}</span>
          </dt>
          <dt id="dtCheckNum" style="display:none;">            
            <label><font class="facexh">*</font>验证码：</label>
            <input type="text" name="checkNum" style="width:60px;" class="inpTextBox" id="checkNum" onkeyup="letterNum(this)" onpaste="letterNum(this)"/>
            <a class="getCheckNum" id="getCheckNum" href="javascript:void(0)">看不清楚？换一个</a>      
          </dt>
        </dl>
    {else}
        <dl>
          <dt>
            <label><font class="facexh">*</font>主页英文名：</label>
            <input type="text" name="domain" id="domain" onfocus="this.select();" />
            <span class="spanValue">一旦设置，不可更改。</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>系统检索：</label>
            <div class="divSex">              
              <label><input type="radio" name="display" class="inpRadio" checked="checked" />开启</label>
              <label><input type="radio" name="display" class="inpRadio"/>关闭</label>
            </div>
            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label>公司名称：</label>
            <input type="text" name="company_name" />

            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>联系人：</label>
            <input type="text" name="contact" id="contact" class="contact" />
            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>联系人职位：</label>
            <input type="text" name="post" id="post" class="post" />
            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>联系方式：</label>
            <div style="float:left;">
            <div class="area1">
              <select name="contact_methods[]">
                <option value="座机">座机</option>
                <option value="手机">手机</option>
                <option value="QQ">QQ</option>
                <option value="MSN">MSN</option>
              </select>
            </div>
            <input type="text" style="width:108px;" name="contact_numbers[]" class="contact_content" onkeyup="Emailstr(this)" onpaste="Emailstr(this)">
            <button class="addContact">添加</button><button class="deleContact">删除</button>
            </div>
            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label>传真：</label>
            <input type="text" name="fax" />
            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label>E-mail：</label>
            <input type="text" name="email" onkeyup="Emailstr(this)" onpaste="Emailstr(this)"/>
            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>公司地址：</label>
            <input type="text" name="address" id="address"  />
            <span class="spanValue">无</span>
          </dt>          
          <dt>
            <label><font class="facexh">*</font>公司类型：</label>
            <div>
              <select name="company_type" id="company_type">
                <option value="">请选择</option>
                <option value="民营/私营公司">民营/私营公司</option>
                <option value="外企代表处">外企代表处</option>
                <option value="事业单位">事业单位</option>
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
            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>公司规模：</label>
            <div>
              <select name="scale" id="scale">
                <option value="">请选择</option>
                <option value="1">10人以下</option>
                <option value="2">10-50人</option>
                <option value="3">50-100人</option>
                <option value="4">100-200人</option>
                <option value="5">200人以上</option>
              </select>
            </div>
            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label>公司网站：</label>
            <input type="text" name="url" />
            <span class="spanValue">无</span>
          </dt>
          <dt>
            <label>公司简介图片：</label>
            <div style="float:left;">
            <input type="file" name="thumbnail"><p class="advise">（图片文件大小不超过300K。）</p>
            </div>
            <span class="spanValue spanValueI">无</span>
          </dt>		 
		  <dt>
            <label>企业招聘图片：</label>
            <div style="float:left;">
            <input type="file" name="thumbnail_job"><p class="advise">（图片分辨率为159x60px，大小不超过300K。）</p>
            </div>
            <span class="spanValue spanValueI">{if !empty($homepage.Homepage.thumbnail_job)}<img src="{$this->webroot}{$homepage.Homepage.thumbnail_job}" />{/if}</span>
          </dt>
          <dt>
            <label><font class="facexh">*</font>公司简介：</label>
            <textarea rows="5" cols="45" id="introduction" name="introduction" ></textarea>
            <span class="spanValue spanValueP">无</span>
          </dt>
          <dt id="dtCheckNum" style="display:none;">            
            <label><font class="facexh">*</font>验证码：</label>
            <input type="text" name="checkNum" style="width:60px;" class="inpTextBox" id="checkNum" onkeyup="letterNum(this)" onpaste="letterNum(this)"/>
            <a class="getCheckNum" id="getCheckNum" href="javascript:void(0)">看不清楚？换一个</a>      
          </dt>
        </dl>
    {/if}
          <div class="clearfix"></div>
        <a id="check" href="javascript:void(0)" class="zclan zclan4">修改</a>
        </form>
    </div>
</div>