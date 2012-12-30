<script type="text/javascript">
{literal}
$(document).ready(function(){
    //check number
    $('#checkNum').after('<img id="code" src="/members/image">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
    
    $('#postResume').click(function(){
        var checkNumError = false;
        var checkNum = $("#checkNum").val().toUpperCase();
        if (checkNum != "")
        {
            $.ajax({
                  url : '/members/getImageNumber',
                  type : 'post',
                  async : false,
                  success : function(data)
                  {
                      if (data == checkNum) {
                          checkNumError = true;
                      } else {
                          if ($("#checkNum").parent().find('.errorMsg').length == 0) {
                              $("#checkNum").parent().append('<span class="errorMsg">验证码不一致</span>');
                          } else {
                              $("#checkNum").parent().find('.errorMsg').html('验证码不一致');
                          }
                      }
                  }
              });
          } else {
              if ($("#checkNum").parent().find('.errorMsg').length == 0) {
                  $("#checkNum").parent().append('<span class="errorMsg">请输入验证码</span>');
              } else {
                  $("#checkNum").parent().find('.errorMsg').html('请输入验证码');
              }
          }
          if(checkNumError) {
            var params = $('#audition').serializeArray();
            $.ajax({
                    url : '/auditions/addAudition',
                    type : 'post',
                    data : params,
                    async : false,
                    success : function(data)
                    {
                        var result = eval("("+data+")");
                        if (result.result == 'OK') {
                            alert(result.msg);
                            $('.jsxxxqB .closeDiv').click();
                        } else {
                            alert(result.msg);
                        }
                    }
                });
          }
    });
});
{/literal}
</script>

<a href="#" class="closeDiv">&nbsp;</a>
<div class="sjle">
    <ul>
        <li>
            <label><font color="#006ee6">申请职位：</font></label>
            <input type="text" value="{$this->data['title']}" readonly="readonly"/>
        </li>
        <li>
            <label><font class="facexh">*</font>选择简历：</label>
            <form id="audition" >
            <ul class="products">
                {if !empty($resumes)}
                <select id="resumes_id" name="resumes_id">
                {foreach $resumes as $resume}
                <option value="{$resume.Resume.id}">{$resume.Resume.title}</option>
                {/foreach}
                </select>
                {else}
                <span style="color:red">没有相匹配行业的简历，请你点击【发布新简历】</span>
                {/if}
            </ul>
            <input type="hidden" name="fulltimes_id" value="{$this->data['fulltime_id']}" />
            <input type="hidden" name="receiver" value="{$this->data['receiver']}" />
            </form>
        </li>
        <li>
            <label><font class="facexh">*</font>验证码：</label>
            <input style="width:60px;" type="text" name="checkNum" id="checkNum" />
            <a href="javascript:void(0)" id="getCheckNum">看不清楚？换一个</a>
        </li>
    </ul>
	<div style="width:200px;" class="divBtnContainer">
    {if !empty($resumes)}
    <a href="javascript:void(0)" class="zclan zclan7" id="postResume">马上投递</a>
	<a href="/resumes/create?fid={$this->data['fulltime_id']}&cid={$this->data['category']}" class="zclan zclan7">发布新简历</a> 
	{else}
	<a href="/resumes/create?fid={$this->data['fulltime_id']}&cid={$this->data['category']}" class="zclan zclan4">发布新简历</a> 
    {/if}
	</div>
    
</div>