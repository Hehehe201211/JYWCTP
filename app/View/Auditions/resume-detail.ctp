<script type="text/javascript">
{literal}
$(document).ready(function(){
    //check number
	$('body').append($('.jsxxxqB'));
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
        var errorMsg = '<span style="color:red" class="errorMsg">请输入此项目</span>';
        if($('#message').val().trim() == "") {
            error = true;
            if($('#message').parent().find('.errorMsg').length == 0) {
                $('#message').after(errorMsg);
            }
        } else {
            $('#message').parent().find('.errorMsg').remove();
        }
        
        if($('#checkNum').val().trim() == "") {
            error = true;
            if($('#message').parent().find('.errorMsg').length == 0) {
                $('#getCheckNum').after(errorMsg);
            }
        } else {
            $('#message').parent().find('.errorMsg').remove();
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
        if (!error) {
            $.ajax({
                url : '/auditions/accept',
                type : 'post',
                data : $('#inviteForm').serializeArray(),
                success : function(data)
                {
                    var data=eval("("+data+")");
                    if (data.result == 'OK')
                    {
                        alert('成功发送面试邀请！');
                        $('.btnDemand').hide();
                        //$('.jsxxxqB .closeDiv').click();
                        location.href="/auditions/inviteList?type=receive";
                    } else {
                        alert(data.msg);
                    }
                }
            });
        }
    });
    $('.delete').click(function(){
        if (confirm('你真的要删除此信息？')){
            $.ajax({
                url : '/auditions/delete',
                type : 'post',
                data : 'type=receive&id=' + $('#id').val(),
                success : function(data)
                {
                    var data=eval("("+data+")");
                    if (data.result == 'OK')
                    {
                        alert('信息删除成功！');
                        if ($('#status').val() == 1) {
                            location.href = '/auditions/listview?type=receive';
                        } else {
                            location.href = '/auditions/inviteList?type=receive';
                        }
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
      <a href="javascript:void(0)">{$title_for_layout}</a>
      </p>
    </div>
    {if !$error}
    <div class="biaotit">职位：<a class="linkfn" target="_blank" href="qy-cgzwglxq.html">{$audition.Fulltime.post}</a></div>
    {if $audition.Audition.status == Configure::read('Audition.status_accept')}
        <div class="zy_zszlB zy_zszlBT">
        <div class="txtTousu"><strong>留言：</strong>{$audition.Audition.message}&nbsp;&nbsp;[{$audition.Audition.modified|date_format:"%Y-%m-%d"}]</div>
        </div>
    {/if}
    <div class="resume">
      <h3>{$audition.ResumeBase.name}的简历</h3>
<table class="preview" border="1" cellspacing="0" cellpadding="0" id="baseInfo" width="100%">
          <tr>
              <td class="tlt tltH" colspan="11">基&nbsp;础&nbsp;信&nbsp;息</td>
            </tr>
            <tr>
              <td width="8%" class="tlt tltL">姓名：</td>
              <td width="15%">{$audition.ResumeBase.name}</td>
              <td width="8%" class="tlt tltL">性别：</td>
              <td width="22%">{if $audition.ResumeBase.sex == 1}男{else}女{/if}</td>
              <td width="8%" class="tlt tltL">户籍：</td>
              <td width="23%">{$provincial_local = $this->City->cityName($audition.ResumeBase.provincial_local)}
            {$city_local =  $this->City->cityName($audition.ResumeBase.city_local)}
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
              <td >{$audition.ResumeBase.nationality}</td>
              <td class="tlt tltL">民族：</td>
              <td>{$audition.ResumeBase.ethnic}</td>
              <td class="tlt tltL">生日：</td>
              <td>{$audition.ResumeBase.birthday|date_format:"%Y-%m-%d"}</td>
            </tr>
            <tr>
              <td class="tlt tltL">联系<br />
电话：</td>
              <td>{$audition.ResumeBase.telephone}</td>
              <td class="tlt tltL">电子<br />
邮箱：</td>
              <td>{$audition.ResumeBase.email}</td>
              <td class="tlt tltL">联系<br />
地址：</td>
              <td colspan="2" >{$audition.ResumeBase.address}</td>
            </tr>            
          </table>
{if $audition.Audition.resumes_id !== NULL}   
     <table cellspacing="0" cellpadding="0" border="1" class="preview" width="100%">
        <tr>
          <td colspan="5" class="tlt tltH"> 教&nbsp;育&nbsp;经&nbsp;历</td>
        </tr>
        <tr>
          <td width="25%">{$audition.ResumeEducation.begin|date_format:"%Y-%m-%d"} - {$audition.ResumeEducation.end|date_format:"%Y-%m-%d"}</td>
          <td width="27%">{$audition.ResumeEducation.school}</td>
          <td width="17%">{$audition.ResumeEducation.discipline}</td>
          <td width="15%">
          {$educate = Configure::read('Fulltime.educated')}
          {$educate[$audition.ResumeEducation.educated]}
          </td>
          <td width="25%">{$audition.ResumeEducation.school_type}</td>
        </tr>
        <tr>
          <td colspan="5" class="tlt tltH">工&nbsp;作&nbsp;经&nbsp;历</td>
        </tr>
        <tr>
          <td>{$audition.ResumeWork.begin|date_format:"%Y-%m-%d"} - {$audition.ResumeWork.end|date_format:"%Y-%m-%d"}</td>
          <td>{$audition.ResumeWork.company}</td>
          <td>{$this->Category->getCategoryName($audition.ResumeWork.category)}</td>
          <td>{$audition.ResumeWork.department}</td>
          <td>{$audition.ResumeWork.post}</td>
        </tr>
        <tr>
            <td class="tlt">从事产品或服务：</td>
            <td colspan="4">{$audition.ResumeWork.service}</td>
        </tr>
		<tr>
            <td class="tlt">职位待遇：</td>
            <td colspan="4">{$audition.ResumeWork.salary}</td>
        </tr>
		<tr>
            <td class="tlt">工作职责：</td>
            <td colspan="4">{$audition.ResumeWork.responsiblly}</td>
        </tr>
        <tr>
            <td class="tlt">离职原因：</td>
            <td colspan="4">{$audition.ResumeWork.reason}</td>
        </tr>
        <tr>
          <td colspan="5" class="tlt tltH">求&nbsp;职&nbsp;方&nbsp;向</td>
        </tr>
        <tr>
          <td class="tlt">自我评价：</td>
          <td colspan="4">{$audition.Resume.evaluation}</td>
        </tr>
        <tr>
          <td class="tlt">期望工作性质：</td>
          <td colspan="4">{$audition.Resume.nature}</td>
        </tr>
        <tr>
          <td class="tlt">意向职位：</td>
          <td colspan="4">{$audition.Resume.intention}</td>
        </tr>
        <tr>
          <td class="tlt">期望从事行业：</td>
          <td colspan="4">
          {$categories = explode(',', $audition.Resume.category)}
                  {foreach $categories as $id}
                    {$this->Category->getCategoryName($id)}
                  {/foreach}
          </td>
        </tr>
        <tr>
          <td class="tlt">期望工作地点：</td>
          <td colspan="4">
          {$cities = explode(',', $audition.Resume.city)}
                  {foreach $cities as $id}
                    {$this->City->cityName($id)}
                  {/foreach}
          </td>
        </tr>
        <tr>
          <td class="tlt">期望待遇：</td>
          <td colspan="4">{$audition.Resume.salary}</td>
        </tr>
        <tr>
          <td class="tlt">上岗时间：</td>
          <td colspan="4">{$audition.Resume.start|date_format:"%Y-%m-%d"}</td>
        </tr>
        </table> 
     {/if}
    </div>
        {if $audition.Audition.status == Configure::read('Audition.status_accept')}
		<div style="width:200px;" class="divBtnContainer">
		<a target="_blank" href="/resumes/preview?id={$audition.Resume.id}" class="zclan zclan7">打印</a>
        <a class="zclan zclan7 delete" href="javascript:void(0)">删除</a>
		</div>
        {else}
		<div style="width:300px;" class="divBtnContainer">
        <a class="zclan zclan7 btnDemand" href="javascript:void(0)">我需要他</a>
		<a target="_blank" href="/resumes/preview?id={$audition.Resume.id}" class="zclan zclan7">打印</a>
        <a class="zclan zclan7 delete" href="javascript:void(0)">删除</a>
		</div>
        {/if}        
    {else}
        没有你需要的信息！
    {/if}
</div>
<input type="hidden" id="status" value="{$audition.Audition.status}" />
<div class="jsxxxq jsxxxqB">
<a class="closeDiv" href="#">&nbsp;</a>
  <div class="sjle">
  <form id="inviteForm">
    <ul>
      <li>
        <label><font class="facexh">*</font>求职者：</label>
        <input type="text" readonly="readonly" value="{$audition.ResumeBase.name}" class="inpTextBox" id="acpro_inp1">
        <input type="hidden" name="id" id="id" value="{$audition.Audition.id}" />
      </li>      
      <li>
        <label><font class="facexh">*</font>留言：</label>
        <textarea name="message" id="message" cols="45" rows="5"></textarea>
      </li>
      <li>
        <label><font class="facexh">*</font>验证码：</label>
        <input type="text" name="" style="width:60px;" class="inpTextBox" id="checkNum">
        <a id="getCheckNum" href="javascript:void(0)">看不清楚？换一个</a> </li>
    </ul>    
    </form>
  </div>
  <div style="width:200px;" class="divBtnContainer">
  <a class="zclan zclan4" id="invite" href="javascript:void(0)">面试邀请</a> 
  </div>
</div>