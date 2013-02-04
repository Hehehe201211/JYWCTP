<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("body").append($(".jsxxxqB"));
    //check number
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
        $(".btnDemand").click(function(){
        $('#getCheckNum img').remove();
        $('#getCheckNum').prepend('<img id="code" src="/members/image/' + Math.random() +'">');
        bgKuang(".jsxxxqB",".jsxxxqB .closeDiv");
    });
    $('#invite').click(function(){
        var error = false;
        var errorMsg = '<span class="errorMsg">请输入此项目</span>';
		$(".jsxxxqB .sjle").find(".errorMsg").remove();
        if($('#message').val().trim() == "") {
            error = true;
            $('#message').after(errorMsg);
        }         
        if($('#checkNum').val().trim() == "") {
            error = true;
            $('#getCheckNum').after(errorMsg);
        } 
        if (!error) {
            $.ajax({
              url : '/members/getImageNumber',
              type : 'post',
              async  : false,
              success : function(data)
              {
                  if (data != $("#checkNum").val().toUpperCase()) {
                      error = true;
                      $("#getCheckNum").after('<span class="errorMsg">验证码不一致</span>');
                  } 
              }
          });
        }
        if (!error) {
            $.ajax({
                url : '/auditions/companySendInvite',
                type : 'post',
                data : $('#inviteForm').serializeArray(),
                success : function(data)
                {
                    var data=eval("("+data+")");
                    if (data.result == 'OK')
                    {
                        alert('成功发送面试邀请！');
                        /*
                        $('.btnDemand').hide();
                        $('.jsxxxqB .closeDiv').click();
                        */
                        location.href = '/auditions/inviteList?type=receive'
                    } else {
                        alert(data.msg);
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
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">常规招聘</a>&gt;&gt;
      <a href="javascript:void(0)">简历检索信息详情</a>
      </p>
    </div>   
    <div class="resume">
      <h3>{$resumeBase.ResumeBase.name}的简历</h3>
	  <table class="preview" border="1" cellspacing="0" cellpadding="0" id="baseInfo" width="100%">
          <tr>
              <td class="tlt tltH" colspan="11">基&nbsp;础&nbsp;信&nbsp;息</td>
            </tr>
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
      <table cellspacing="0" cellpadding="0" border="1" class="preview" width="100%">
        <tr>
          <td colspan="5" class="tlt tltH"> 教&nbsp;育&nbsp;经&nbsp;历</td>
        </tr>
        <tr>
          <td width="25%">{$resumeEducation.ResumeEducation.begin|date_format:"%Y-%m-%d"} - {$resumeEducation.ResumeEducation.end|date_format:"%Y-%m-%d"}</td>
          <td width="27%">{$resumeEducation.ResumeEducation.school}</td>
          <td width="17%">{$resumeEducation.ResumeEducation.discipline}</td>
          <td width="15%">
          {$educate = Configure::read('Fulltime.educated')}
          {$educate[$resumeEducation.ResumeEducation.educated]}
          </td>
          <td width="15%">{$resumeEducation.ResumeEducation.school_type}</td>
        </tr>
        <tr>
          <td colspan="5" class="tlt tltH">工&nbsp;作&nbsp;经&nbsp;历</td>
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
        <tr>
          <td colspan="5" class="tlt tltH">求&nbsp;职&nbsp;方&nbsp;向</td>
        </tr>
        <tr>
          <td class="tlt">自我评价：</td>
          <td colspan="4">{$resume.Resume.evaluation}</td>
        </tr>
        <tr>
          <td class="tlt">期望工作性质：</td>
          <td colspan="4">{$resume.Resume.nature}</td>
        </tr>
        <tr>
          <td class="tlt">意向职位：</td>
          <td colspan="4">{$resume.Resume.intention}</td>
        </tr>
        <tr>
          <td class="tlt">期望从事行业：</td>
          <td colspan="4">
          {$categories = explode(',', $resume.Resume.category)}
                  {foreach $categories as $id}
                    {$this->Category->getCategoryName($id)}
                  {/foreach}
          </td>
        </tr>
        <tr>
          <td class="tlt">期望工作地点：</td>
          <td colspan="4">
          {$cities = explode(',', $resume.Resume.city)}
                  {foreach $cities as $id}
                    {$this->City->cityName($id)}
                  {/foreach}
          </td>
        </tr>
        <tr>
          <td class="tlt">期望待遇：</td>
          <td colspan="4">{$resume.Resume.salary}</td>
        </tr>
        <tr>
          <td class="tlt">上岗时间：</td>
          <td colspan="4">{$resume.Resume.start|date_format:"%Y-%m-%d"}</td>
        </tr>
        </table>     
    </div>
    <div>&nbsp;</div>    
	<div class="divBtnContainer" style="width:200px;"><a class="zclan zclan7 btnDemand" href="javascript:void(0)">我需要他</a><a target="_blank" href="/resumes/preview?id={$resume.Resume.id}" class="zclan zclan7">打印</a></div>
</div>
<div class="jsxxxq jsxxxqB">
<a class="closeDiv" href="#">&nbsp;</a>
  <div class="sjle">
    <ul>
      <li>
        <label><font class="facexh">*</font>求职者：</label>
        <input type="text" readonly="readonly" value="{$resumeBase.ResumeBase.name}" class="inpTextBox" id="acpro_inp1">
      </li>
      <li>
        <label><font class="facexh">*</font>选择职位：</label>
        <form id="inviteForm">
        <input type="hidden" name="sender" value="{$resumeBase.ResumeBase.members_id}" />
        <input type="hidden" name="resumes_id" value="{$this->request->query['id']}" />
        {if !empty($fulltimes)}
            <select id="fulltimes_id" name="fulltimes_id">
            <option value="">请选择职位</option>
            {foreach $fulltimes as $fulltime}
            <option value="{$fulltime.Fulltime.id}">{$fulltime.Fulltime.post}</option>
            {/foreach}
            </select>
            {else}
            <span style="color:red">没有职位信息</span>
            {/if}
      </li>
      <li>
        <label><font class="facexh">*</font>留言：</label>
        <textarea name="message" id="message" cols="45" rows="5"></textarea>
      </li>
        <li>
            <label><font class="facexh">*</font>验证码：</label>
            <input type="text" name="" style="width:60px;" class="inpTextBox" id="checkNum">
            <a id="getCheckNum" href="javascript:void(0)">看不清楚？换一个</a>
        </li>
    </ul>
    </form>
    <a class="zclan zclan4" id="invite" href="javascript:void(0)">面试邀请</a> 
  </div>
</div>