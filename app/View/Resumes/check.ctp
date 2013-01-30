<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#complete').click(function(){
        $('#resume').attr('action', '/resumes/complete').submit();
        
    });
    $('#back').click(function(){
        $('#resume').attr('action', '/resumes/create').submit();
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
<ul class="ulFormStep ulFormStep2">
      <li>1.填写简历信息</li>
      <li>2.确认信息</li>
      <li>3.新增成功</li>
    </ul> 
    <div class="resume">
      <h3>{$this->data['title']} - {$memberInfo.Attribute.name}</h3>
      <table class="preview" border="1" cellspacing="0" cellpadding="0" width="100%">
          <tr>
              <td class="tlt tltH" colspan="11">基&nbsp;础&nbsp;信&nbsp;息</td>
            </tr>
            <tr>
              <td width="8%" class="tlt tltL">姓名：</td>
              <td width="13%">{$resumeBase.ResumeBase.name}</td>
              <td width="8%" class="tlt tltL">性别：</td>
              <td width="24%">{if $resumeBase.ResumeBase.sex == 1}男{else}女{/if}</td>
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
              {if !empty($memberInfo.Attribute.thumbnail)}
                {$thumbnail = Configure::read('Data.path')|cat:$memberInfo.Attribute.thumbnail}
                {if file_exists($thumbnail)}
                    <img width="112" height="124" src="{$this->webroot}{$memberInfo.Attribute.thumbnail}">
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
          <td width="19%">{$this->data['edu_begin']|date_format:"%Y.%m"} - {$this->data['edu_end']|date_format:"%Y.%m"}</td>
          <td width="23%">{$this->data['school']}</td>
          <td width="16%">{$this->data['discipline']}</td>
          <td width="17%">
          {$educate = Configure::read('Fulltime.educated')}
          {$educate[$this->data['educated']]}
          </td>
          <td width="25%">{$this->data['school_type']}</td>
        </tr>
        <tr>
          <td colspan="5" class="tlt tltH">工&nbsp;作&nbsp;经&nbsp;历</td>
        </tr>
        <tr>
          <td>{$this->data['work_begin']|date_format:"%Y.%m"} - {$this->data['work_end']|date_format:"%Y.%m"}</td>
          <td>{$this->data['company']}</td>
          <td>{$this->Category->getCategoryName($this->data['work_category'])}</td>
          <td>{$this->data['department']}</td>
          <td>{$this->data['post']}</td>
        </tr>
        <tr>
			<td colspan="3"><strong>从事产品或服务：</strong>{$this->data['service']}</td>
            <td colspan="2"><strong>职位待遇：</strong>{$this->data['wrok_salary']}</td>
        </tr>
        <tr>
            <td class="tlt">工作职责：</td>
            <td colspan="4">{$this->data['responsiblly']}</td>
        </tr>
        <tr>
            <td class="tlt">离职原因：</td>
            <td colspan="4">{$this->data['reason']}</td>
        </tr>
        <tr>
          <td colspan="5" class="tlt tltH">求&nbsp;职&nbsp;方&nbsp;向</td>
        </tr>
        <tr>
          <td class="tlt">自我评价：</td>
          <td colspan="4">{$this->data['evaluation']}</td>
        </tr>
        <tr>
          <td class="tlt">期望工作性质：</td>
          <td colspan="4">{$this->data['nature']}</td>
        </tr>
        <tr>
          <td class="tlt">意向职位：</td>
          <td colspan="4">{$this->data['intention']}</td>
        </tr>
        <tr>
          <td class="tlt">期望从事行业：</td>
          <td colspan="4">
          {$categories = explode(',', $this->data['category'])}
          {foreach $categories as $id}
            {$this->Category->getCategoryName($id)}
          {/foreach}
          </td>
        </tr>
        <tr>
          <td class="tlt">期望工作地点：</td>
          <td colspan="4">
          {$cities = explode(',', $this->data['city'])}
          {foreach $cities as $id}
            {$this->City->cityName($id)}
          {/foreach}
          </td>
        </tr>
        <tr>
          <td class="tlt">期望待遇：</td>
          <td colspan="4">{$this->data['salary']}</td>
        </tr>
        <tr>
          <td class="tlt">上岗时间：</td>
          <td colspan="4">{$this->data['start']}</td>
        </tr>
        </table>      
    </div>
        <a href="javascript:void(0)" id="complete" class="zclan zclan3">提交</a>
        <a href="javascript:void(0)" id="back" class="zclan zclan3">修改</a>
    </div>
    <form id="resume" action="" method="post">
        <input type="hidden" name="title" value="{$this->data['title']}">
        <input type="hidden" id="eduBegin" name="edu_begin"  value="{$this->data['edu_begin']}"/>
        <input type="hidden" id="eduEnd" name="edu_end"  value="{$this->data['edu_end']}"/>
        <input type="hidden" name="school" id="school"  value="{$this->data['school']}"/>
        <input type="hidden" name="discipline" id="discipline"  value="{$this->data['discipline']}"/>
        <input type="hidden" name="educated" id="educated"  value="{$this->data['educated']}"/>
        <input type="hidden" name="school_type" id="school_type"  value="{$this->data['school_type']}"/>
        
        <input type="hidden" id="workBegin" name="work_begin"  value="{$this->data['work_begin']}"/>
        <input type="hidden" id="workEnd" name="work_end"  value="{$this->data['work_end']}"/>
        <input type="hidden" name="company" class="contact"  value="{$this->data['company']}"/>
        <input type="hidden" name="work_category" class="contact"  value="{$this->data['work_category']}"/>
        <input type="hidden" name="department" class="contact"  value="{$this->data['department']}"/>
        <input type="hidden" name="post" class="contact"  value="{$this->data['post']}"/>
        <input type="hidden" name="service" class="contact"  value="{$this->data['service']}"/>
        <input type="hidden" name="responsiblly" class="contact"  value="{$this->data['responsiblly']}"/>
        <input type="hidden" name="wrok_salary" class="contact"  value="{$this->data['wrok_salary']}"/>
        <input type="hidden" name="reason" class="contact"  value="{$this->data['reason']}"/>
        
        <input type="hidden" name="evaluation" class="contact" value="{$this->data['evaluation']}"/>
        <input type="hidden" name="nature" class="inpRadio" value="{$this->data['nature']}"/>
        <input type="hidden" name="intention" class="contact" value="{$this->data['intention']}"/>
        <input type="hidden" name="category" class="contact" value="{$this->data['category']}"/>
        <input type="hidden" name="city" class="contact" value="{$this->data['city']}"/>
        <input type="hidden" name="salary" class="contact" value="{$this->data['salary']}"/>
        <input type="hidden" name="start" id="workTime" value="{$this->data['start']}"/>
        {if isset($this->data['fid'])}
        <input type="hidden" name="fid" id="fid" value="{$this->data['fid']}"/>
        {/if}
        {if isset($this->data['has_worked'])}
            <input type="hidden" name="has_worked" id="has_worked" value="1"/>
        {else}
            <input type="hidden" name="has_worked" id="has_worked" value="0"/>
        {/if}
    </form>