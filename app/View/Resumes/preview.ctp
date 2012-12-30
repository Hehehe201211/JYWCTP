<div class="zhifu" style="width:823px;">
    <div class="payProblem resume">
        <h3>{$resume.Resume.title} - {$resumeBase.ResumeBase.name}</h3>
		<table class="preview" border="1" cellspacing="0" cellpadding="0" id="baseInfo" width="100%">
          <tr>
              <td class="tlt tltH" colspan="11">基&nbsp;础&nbsp;信&nbsp;息</td>
            </tr>
            <tr>
              <td width="7%" class="tlt tltL">姓名：</td>
              <td width="15%">{$resumeBase.ResumeBase.name}</td>
              <td width="7%" class="tlt tltL">性别：</td>
              <td width="24%">{if $resumeBase.ResumeBase.sex == 1}男{else}女{/if}</td>
              <td width="7%" class="tlt tltL">户籍：</td>
              <td width="24%">{$provincial_local = $this->City->cityName($resumeBase.ResumeBase.provincial_local)}
            {$city_local =  $this->City->cityName($resumeBase.ResumeBase.city_local)}
            {if $provincial_local == $city_local}
                {$provincial_local}
            {else}
                {$provincial_local} {$city_local}
            {/if}</td>
              <td width="16%" rowspan="3"><div align="center"><img width="112" height="124" alt="portrait" src="{$this->webroot}img/tx.jpg"></div></td>
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
              <td>{$resumeBase.ResumeBase.address}</td>
            </tr>            
          </table>  
		  <table cellspacing="0" cellpadding="0" border="1" class="preview" width="100%">
        <tr>
          <td colspan="5" class="tlt tltH"> 教&nbsp;育&nbsp;经&nbsp;历</td>
        </tr>
        <tr>
          <td width="19%">{$resumeEducation.ResumeEducation.begin|date_format:"%Y-%m-%d"} - {$resumeEducation.ResumeEducation.end|date_format:"%Y-%m-%d"}</td>
          <td width="23%">{$resumeEducation.ResumeEducation.school}</td>
          <td width="16%">{$resumeEducation.ResumeEducation.discipline}</td>
          <td width="17%">
          {$educate = Configure::read('Fulltime.educated')}
          {$educate[$resumeEducation.ResumeEducation.educated]}
          </td>
          <td width="25%">{$resumeEducation.ResumeEducation.school_type}</td>
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
</div>
<div class="divBtnContainer" style="width:100px;margin:12px auto;"><a href="javascript:printme()" class="zclan zclan7">打印</a></div>
  <script>
  function printme()
  {
	  $('.wrap,.xian1,.footer,#goToTop,.divBtnContainer').hide();
	  $('.payProblem').css("border-color","#FFF");
	  window.print();
	  $('.wrap,.xian1,.footer,#goToTop,.divBtnContainer').show();
	  $('.payProblem').css("border-color","#A5B9CE");
  } 
</script>