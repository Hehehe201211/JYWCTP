<script>
//{literal}
$(document).ready(function(){
    $("body").append($("#jsxxxq"));    
    $("body").append($("#jsxxxqE"));    
    $("body").append($("#jsxxxqW"));    
    $("body").append($("#jsxxxqJ"));
    
    datepIniChange("#birthday","birth");
    datepIniChange("#eduBegin","EPbirth");
    datepIniChange("#eduEnd","EPbirth");    
    datepIniChange("#workBegin","EPbirth");
    datepIniChange("#workEnd","EPbirth");    
    datepIniChange("#workTime","EPbirth");
    
    $(".resumeEdit").click(function(){
        bgKuang("#jsxxxq",".jsxxxqB .closeDiv");            
    });
    $(".eduEdit").click(function(){
        bgKuang("#jsxxxqE",".jsxxxqB .closeDiv");            
    });
    $(".workEdit").click(function(){
        bgKuang("#jsxxxqW",".jsxxxqB .closeDiv");            
    });
    $(".jobEdit").click(function(){
        bgKuang("#jsxxxqJ",".jsxxxqB .closeDiv");            
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
    
    $(".divExpect .addOpts").click(function(){
      var selOpts=$(this).parent().parent().find(".selOpts option:selected");
      var seledOpts=$(this).parent().parent().find(".seledOpts");      
      for (i=0;i<selOpts.length;i++) {
          if (seledOpts.find("option").length==0)  seledOpts.append(selOpts.eq(i).clone());
          else {
              for (j=0;j<seledOpts.find("option").length;j++) {
                  if (selOpts.eq(i).val()==seledOpts.find("option").eq(j).val()) break;
                  else if (j==(seledOpts.find("option").length-1)) seledOpts.append(selOpts.eq(i).clone());
              }
          }
      }
  });
  
  $(".divExpect .removeOpts").click(function(){
      $(this).parent().parent().find(".seledOpts option:selected").remove();
  });
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
      <div class="znxContent conResume" style="border-top-width:1px;">
        <div class="znxConSys">
          <div class="biaotit">基础信息<a href="javascript:;" class="left resumeEdit">编辑</a></div>
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
            <thead>
              <tr class="con_2_tr con_2_xq_too">
                <th width="25%"> 就学起讫时间  
                  </th>
                <th width="15%"> 学历      
                  </th>
                <th width="20%"> 专业  
                  </th>
                <th width="40%"> 毕业院校  
                  </th>
              </tr>
            </thead>
            <tbody>
              <tr class="con_2_tr">
                <td align="center">{$resumeEducation.ResumeEducation.begin|date_format:"%Y-%m-%d"} - {$resumeEducation.ResumeEducation.end|date_format:"%Y-%m-%d"}</td>
                <td align="center">
                {$educate = Configure::read('Fulltime.educated')}
                {$educate[$resumeEducation.ResumeEducation.educated]}
                </td>
                <td align="center">{$resumeEducation.ResumeEducation.discipline}</td>
                <td align="center">{$resumeEducation.ResumeEducation.school} </td>
              </tr>
            </tbody>
          </table>
          <div class="biaotit">工作经历<a href="javascript:;" class="workEdit">编辑</a></div>
          <table class="con_2_table preview" border="1" cellspacing="0" cellpadding="0" width="593">
            <thead>
              <tr class="con_2_tr con_2_xq_too">
                <th width="25%"> 就职起讫时间
                  </th>
                <th width="15%"> 部门
                  </th>
                <th width="20%"> 职位
                  </th>
                <th width="40%"> 就职单位
                  </th>
              </tr>
            </thead>
            <tbody>
              <tr class="con_2_tr">
                <td align="center">{$resumeWork.ResumeWork.begin|date_format:"%Y-%m-%d"} - {$resumeWork.ResumeWork.end|date_format:"%Y-%m-%d"}</td>
                <td align="center">{$resumeWork.ResumeWork.department}</td>
                <td align="center">{$resumeWork.ResumeWork.post} </td>
                <td align="center">{$resumeWork.ResumeWork.company} </td>
              </tr>
            </tbody>
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
        </div>
      </div>
    </div>
    <div class="jsxxxq jsxxxqB" id="jsxxxq"> <a class="closeDiv" href="#">&nbsp;</a>
    <div class="biaotit">基础信息（<font class="facexh">*</font>表示必填项）</div>
      <div class="sjle">
        <form id="information" method="post" action="">          
          <dl>
            <dt>
              <label><font class="facexh">*</font>简历标题：</label>
              <input type="text"/>
            </dt>
            <dt>
              <label><font class="facexh">*</font>姓名：</label>
              <input type="text"/>
            </dt>
            <dt>
              <label>个人头像：</label>
              <input type="file" style="height:auto;height:22px\9;" />
            </dt>
            <dt>
              <label><font class="facexh">*</font>性别：</label>
              <div class="divSex">
                <label>
                  <input type="radio" class="inpRadio" checked="checked"/>
                  男</label>
                <label>
                  <input type="radio" class="inpRadio"/>
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
              <label>国籍：</label>
              <select name="">
                <option value="">请选择</option>
                <option value="1">中国</option>
                <option value="2">美国</option>
              </select>
              <label>民族：</label>
              <select name="">
                <option value="1">汉族</option>
                <option value="2">苗族</option>
                <option value="3">高山族</option>
              </select>
            </dt>
            <dt class="select100">
              <label>户口所在地：</label>
              <select name="">
                <option value="">请选择</option>
                <option value="1">福建省</option>
                <option value="2">广东省</option>
              </select>
              <select name="">
                <option value="1">厦门市</option>
                <option value="2">福州市</option>
                <option value="3">泉州市</option>
              </select>
            </dt>
            <dt class="select100">
              <label><font class="facexh">*</font>现居住地：</label>
              <select name="">
                <option value="">请选择</option>
                <option value="1">福建省</option>
                <option value="2">广东省</option>
              </select>
              <select name="">
                <option value="1">厦门市</option>
                <option value="2">福州市</option>
                <option value="3">泉州市</option>
              </select>
            </dt>
            <dt>
              <label>联系方式：</label>
              <div class="area1">
                <select>
                  <option>座机</option>
                  <option selected="selected">手机</option>
                  <option>QQ</option>
                  <option>MSN</option>
                  <option>E-mail</option>
                  <option>其他</option>
                </select>
              </div>
              <input type="text" style="width:155px;">
              <button class="addContact">添加</button>
              <button class="deleContact">删除</button>
            </dt>
            <dt>
              <label><font class="facexh">*</font>联系地址：</label>
              <input type="text"/>
            </dt>
          </dl>
          <a class="zclan zclan4" href="javascript:var a=$('.jsxxxqB .closeDiv').click();" >修改</a>
        </form>
      </div>
    </div>
    <div class="jsxxxq jsxxxqB" id="jsxxxqE"> <a class="closeDiv" href="#">&nbsp;</a>
      <div class="biaotit">教育经历（<font class="facexh">*</font>表示必填项）</div>
      <div class="sjle">
        <form id="information" method="post" action="">
          <dl>
            <dt>
              <label><font class="facexh">*</font>就学起讫时间：</label>
              <ul class="validity">
                <li>
                  <input type="text" id="eduBegin"  readonly="readonly"/>
                </li>
                <li style="width:36px;text-align:center;">至</li>
                <li>
                  <input type="text" id="eduEnd"  readonly="readonly"/>
                </li>
              </ul>
            </dt>
            <dt>
              <label><font class="facexh">*</font>就读院校名称：</label>
              <input type="text" name="" id="">
            </dt>
            <dt class="productKinds">
              <label><font class="facexh">*</font>专业类别：</label>
              <select name="category" id="category">
                <option value="">请选择</option>
                <option value="1">网络</option>
                <option value="2">广告</option>
                <option value="3">教育培训</option>
                <option value="4">人才招聘</option>
                <option value="5">原料设备</option>
                <option value="6">房产</option>
                <option value="7">装修装饰</option>
                <option value="8">设计</option>
                <option value="9">礼仪庆典</option>
                <option value="10">服务咨询</option>
                <option value="11">展会</option>
                <option value="12">投资理财</option>
                <option value="13">保险</option>
                <option value="14">旅游</option>
                <option value="15">汽车</option>
              </select>
              <select name="sub_category" >
                <option value="">请选择</option>
                <option value="">其他</option>
              </select>
            </dt>
            <dt class="productKinds">
              <label><font class="facexh">*</font>专业学历：</label>
              <select>
                <option selected="selected" value="">请选择专业学历</option>
                <option value="1">无</option>
                <option value="2">小学</option>
                <option value="3">初中</option>
                <option value="4">高中</option>
                <option value="5">中专</option>
                <option value="6">大专</option>
                <option value="7">本科</option>
                <option value="8">硕士研究生</option>
                <option value="9">博士研究生</option>
              </select>
            </dt>
            <dt class="productKinds">
              <label>就学形式：</label>
              <select>
                <option selected="selected" value="">请选择就学形式</option>
                <option value="1">全日制重点大学</option>
                <option value="2">全日制普通高校</option>
                <option value="3">自学考试</option>
                <option value="4">成人大学</option>
                <option value="5">电视大学</option>
                <option value="6">网络大学</option>
                <option value="7">函授大学</option>
                <option value="8">夜大</option>
                <option value="9">职业大学</option>
                <option value="10">其他</option>
              </select>
            </dt>
          </dl>
          <a class="zclan zclan4" href="javascript:;" onclick="alert('修改成功！');$('.jsxxxqB .closeDiv').click();">修改</a>
        </form>
      </div>
    </div>
    <div class="jsxxxq jsxxxqB" id="jsxxxqW"> <a class="closeDiv" href="#">&nbsp;</a>
      <div class="biaotit">工作经历（<font class="facexh">*</font>表示必填项）</div>
      <div class="sjle">
      <form id="information" method="post">         
        <dl>
          <dt>
            <label><font class="facexh">*</font>就职起讫时间：</label>
            <ul class="validity">
              <li>
                <input type="text" id="workBegin"  readonly="readonly"/>
              </li>
              <li style="width:36px;text-align:center;">至</li>
              <li>
                <input type="text" id="workEnd"  readonly="readonly"/>
              </li>
            </ul>
          </dt>
          <dt>
            <label><font class="facexh">*</font>就职单位名称：</label>
            <input type="text" name="contact[]" class="contact" />
          </dt>
          <dt class="productKinds">
            <label>就职单位行业：</label>
            <select>
              <option selected="selected" value="">请选择就职公司所属行业</option>
              <option value="1">计算机/互联网/通信/电子 </option>
              <option value="1001">计算机软件</option>
              <option value="1002">计算机硬件</option>
              <option value="1003">计算机服务（系统、数据服务）</option>
              <option value="1004">通信/电信/网络设备</option>
              <option value="1005">通信/电信运营、增值服务</option>
              <option value="1006">互联网/电子商务</option>
              <option value="1007">网络游戏</option>
              <option value="1008">电子技术/半导体/集成电路</option>
              <option value="1009">仪器仪表/工业自动化</option>
              <option value="2">会计/金融/银行/保险</option>
              <option value="2001">会计/审计</option>
              <option value="2002">金融/投资/证券</option>
              <option value="2003">银行</option>
              <option value="2004">保险</option>
              <option value="3">贸易/消费/制造/营运</option>
              <option value="3001">贸易/进出口</option>
              <option value="3002">批发/零售</option>
              <option value="3003">快速消费品(食品，饮料，化妆品)</option>
              <option value="3004">服装/纺织/皮革</option>
              <option value="3005">家具/家电/工艺品/玩具</option>
              <option value="3006">办公用品及设备</option>
              <option value="3007">机械/设备/重工</option>
              <option value="3008">汽车及零配件</option>
              <option value="4">制药/医疗</option>
              <option value="4001">制药/生物工程</option>
              <option value="4002">医疗/护理/保健/卫生</option>
              <option value="4003">医疗设备/器械</option>
              <option value="5">广告/媒体</option>
              <option value="5001">广告</option>
              <option value="5002">公关/市场推广/会展</option>
              <option value="5003">影视/媒体/艺术</option>
              <option value="5004">文字媒体/出版</option>
              <option value="5005">印刷/包装</option>
              <option value="6">房地产/建筑/装饰</option>
              <option value="6001">房地产开发</option>
              <option value="6002">建筑与工程</option>
              <option value="6003">家居/室内设计/装潢</option>
              <option value="6004">物业管理/商业中心</option>
              <option value="7">专业服务/教育/培训</option>
              <option value="7001">中介服务</option>
              <option value="7002">专业服务（咨询，人力资源）</option>
              <option value="7003">检测，认证</option>
              <option value="7004">法律</option>
              <option value="7005">教育/培训 </option>
              <option value="7006">学术/科研</option>
              <option value="8">服务业</option>
              <option value="8001">餐饮业</option>
              <option value="8002">酒店/旅游</option>
              <option value="8003">娱乐/休闲/体育</option>
              <option value="8004">美容/保健</option>
              <option value="8005">生活服务</option>
              <option value="9">物流/运输</option>
              <option value="9001">交通/运输/物流 航天/航空</option>
              <option value="10">能源/原材料</option>
              <option value="10001">石油/化工/矿产</option>
              <option value="10002">采掘业/冶炼</option>
              <option value="10003">电力/水利</option>
              <option value="10004">原材料和加工</option>
              <option value="11">政府/非赢利机构/其他</option>
              <option value="11001">政府</option>
              <option value="11002">非盈利机构</option>
              <option value="11003">环保</option>
              <option value="11004">农业/渔业/林业</option>
              <option value="11005">多元化业务集团公司</option>
              <option value="11006">其他行业</option>
            </select>
          </dt>
          <dt>
            <label><font class="facexh">*</font>就职部门名称：</label>
            <input type="text" name="" class="contact" />
          </dt>
          <dt>
            <label><font class="facexh">*</font>就职职位名称：</label>
            <input type="text" name="contact[]" class="contact" />
          </dt>
          <dt>
            <label><font class="facexh">*</font>从事产品及服务：</label>
            <input type="text" name="" class="contact" />
          </dt>
          <dt>
            <label><font class="facexh">*</font>工作职责：</label>
            <textarea cols="45" rows="5"></textarea>
          </dt>
          <dt>
            <label>职位待遇：</label>
            <input type="text" name="" class="contact" />
          </dt>
          <dt>
            <label>离职原因：</label>
            <input type="text" name="" class="contact" />
          </dt>
        </dl>   
         <a class="zclan zclan4" href="javascript:;" onclick="alert('修改成功！');$('.jsxxxqB .closeDiv').click();">修改</a>
      </form>
    </div>
    </div>
    <div class="jsxxxq jsxxxqB" id="jsxxxqJ"> <a class="closeDiv" href="#">&nbsp;</a>
      <div class="biaotit">求职方向（<font class="facexh">*</font>表示必填项）</div>
      <div class="sjle">
      <form id="information" method="post">        
        <dl>
          <dt>
            <label><font class="facexh">*</font>自我评价：</label>
            <textarea cols="45" rows="5"></textarea>
          </dt>
          <dt>
            <label><font class="facexh">*</font>期望工作性质：</label>
            <div class="divSex">
              <input type="radio" name="nature" id="full" class="inpRadio" checked="checked"/>
              <label for="full">全职</label>
              <input type="radio" name="nature" id="part" class="inpRadio"/>
              <label for="part">兼职</label>
            </div>
          </dt>
          <dt>
            <label><font class="facexh">*</font>意向职位：</label>
            <input type="text" name="" class="contact" />
            &nbsp;（限20个字） </dt>
          <dt>
            <label><font class="facexh">*</font>期望从事行业：</label>
            <div class="divExpect">
              <select class="selOpts sel121" size="10" multiple="multiple">
                <option value="1">计算机/互联网/通信/电子 </option>
                <option value="1001">计算机软件</option>
                <option value="1002">计算机硬件</option>
                <option value="1003">计算机服务（系统、数据服务）</option>
                <option value="1004">通信/电信/网络设备</option>
                <option value="1005">通信/电信运营、增值服务</option>
                <option value="1006">互联网/电子商务</option>
                <option value="1007">网络游戏</option>
                <option value="1008">电子技术/半导体/集成电路</option>
                <option value="1009">仪器仪表/工业自动化</option>
                <option value="2">会计/金融/银行/保险</option>
                <option value="2001">会计/审计</option>
                <option value="2002">金融/投资/证券</option>
                <option value="2003">银行</option>
                <option value="2004">保险</option>
                <option value="3">贸易/消费/制造/营运</option>
                <option value="3001">贸易/进出口</option>
                <option value="3002">批发/零售</option>
                <option value="3003">快速消费品(食品，饮料，化妆品)</option>
                <option value="3004">服装/纺织/皮革</option>
                <option value="3005">家具/家电/工艺品/玩具</option>
                <option value="3006">办公用品及设备</option>
                <option value="3007">机械/设备/重工</option>
                <option value="3008">汽车及零配件</option>
                <option value="4">制药/医疗</option>
                <option value="4001">制药/生物工程</option>
                <option value="4002">医疗/护理/保健/卫生</option>
                <option value="4003">医疗设备/器械</option>
                <option value="5">广告/媒体</option>
                <option value="5001">广告</option>
                <option value="5002">公关/市场推广/会展</option>
                <option value="5003">影视/媒体/艺术</option>
                <option value="5004">文字媒体/出版</option>
                <option value="5005">印刷/包装</option>
                <option value="6">房地产/建筑/装饰</option>
                <option value="6001">房地产开发</option>
                <option value="6002">建筑与工程</option>
                <option value="6003">家居/室内设计/装潢</option>
                <option value="6004">物业管理/商业中心</option>
                <option value="7">专业服务/教育/培训</option>
                <option value="7001">中介服务</option>
                <option value="7002">专业服务（咨询，人力资源）</option>
                <option value="7003">检测，认证</option>
                <option value="7004">法律</option>
                <option value="7005">教育/培训 </option>
                <option value="7006">学术/科研</option>
                <option value="8">服务业</option>
                <option value="8001">餐饮业</option>
                <option value="8002">酒店/旅游</option>
                <option value="8003">娱乐/休闲/体育</option>
                <option value="8004">美容/保健</option>
                <option value="8005">生活服务</option>
                <option value="9">物流/运输</option>
                <option value="9001">交通/运输/物流 航天/航空</option>
                <option value="10">能源/原材料</option>
                <option value="10001">石油/化工/矿产</option>
                <option value="10002">采掘业/冶炼</option>
                <option value="10003">电力/水利</option>
                <option value="10004">原材料和加工</option>
                <option value="11">政府/非赢利机构/其他</option>
                <option value="11001">政府</option>
                <option value="11002">非盈利机构</option>
                <option value="11003">环保</option>
                <option value="11004">农业/渔业/林业</option>
                <option value="11005">多元化业务集团公司</option>
                <option value="11006">其他行业</option>
              </select>
              <div class="div2">
                <input type="button" class="inpButton addOpts" value="添加 >>"/>
                <input type="button" class="inpButton removeOpts" value="<< 移除"/>
              </div>
              <select class="seledOpts sel121" size="10" multiple="multiple">
              </select>
            </div>
          </dt>         
          <dt>
            <label><font class="facexh">*</font>期望工作地点：</label>
            <div class="divExpect">
              <div class="div1">
                <select name="provincial" id="provincial" class="sel2211">
                  <option value="1">厦门</option>
                  <option value="2">北京</option>
                  <option value="3">上海</option>
                  <option value="4">深圳</option>
                  <option value="5">天津</option>
                  <option value="6">福建</option>
                  <option value="7">广东</option>
                  <option value="8">江苏</option>
                  <option value="9">浙江</option>
                  <option value="10">重庆</option>
                  <option value="11">山东</option>
                  <option value="12">河北</option>
                  <option value="13">四川</option>
                  <option value="14">湖北</option>
                  <option value="15">湖南</option>
                  <option value="16">安徽</option>
                  <option value="17">海南</option>
                  <option value="18">云南</option>
                  <option value="19">黑龙江</option>
                  <option value="20">辽宁</option>
                  <option value="21">吉林</option>
                  <option value="22">广西</option>
                  <option value="23">山西</option>
                  <option value="24">江西</option>
                  <option value="25">陕西</option>
                  <option value="26">贵州</option>
                  <option value="27">甘肃</option>
                  <option value="28">宁夏</option>
                  <option value="29">内蒙古</option>
                  <option value="30">新疆</option>
                  <option value="31">青海</option>
                  <option value="32">西藏</option>
                </select>
                <select class="selOpts sel2212" size="8" multiple="multiple">
                  <option value="1">厦门市</option>
                  <option value="2">福州市</option>
                  <option value="3">泉州市</option>
                  <option value="4">莆田市</option>
                  <option value="5">三明市</option>
                  <option value="6">漳州市</option>
                  <option value="7">南平市</option>
                  <option value="8">龙岩市</option>
                  <option value="9">宁德市</option>
                </select>
              </div>
              <div class="div2">
                <input type="button" class="inpButton addOpts" value="添加 >>"/>
                <input type="button" class="inpButton removeOpts" value="<< 移除"/>
              </div>
              <select class="seledOpts sel221" size="10" multiple="multiple">
              </select>
            </div>
          </dt>
          <dt>
            <label><font class="facexh">*</font>期望待遇：</label>
            <input type="text" name="" class="contact" />
          </dt>
          <dt>
            <label>上岗时间：</label>
            <ul class="validity">
              <li>
                <input type="text" name="birthday" id="workTime"  readonly="readonly"/>
              </li>
            </ul>
          </dt>
        </dl>
         <a class="zclan zclan4" href="javascript:;" onclick="alert('修改成功！');$('.jsxxxqB .closeDiv').click();">修改</a>
      </form>
    </div>
    </div>
</div>