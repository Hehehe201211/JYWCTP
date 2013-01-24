<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('body').append($('.jsxxxqB'));
    $('#candidate').click(function(){
        var title = $('#title').html();
        var category = $('#category').val();
        var fulltime_id = $('#fulltime_id').val();
        var receiver = $('#receiver').val();
        $('.jsxxxqB').load('/resumes/candidate', {'title' : title, 'category' : category, 'fulltime_id' : fulltime_id, 'receiver' : receiver}, function(){
            bgKuang(".jsxxxqB",".jsxxxqB .closeDiv");
        });
    });
    $('#favorite').click(function(){
        var $this = $(this);
        if ($this.hasClass('add')) {
            if(confirm('真的要把此职位信息添加到收藏？')){
                var fulltime_id = $('#fulltime_id').val();
                $.ajax({
                    url : '/fulltimes/addFavourite',
                    type : 'post',
                    data : 'fulltimes_id=' + fulltime_id,
                    success : function(data)
                    {
                        var result = eval("("+data+")");
                        if (result.result == 'OK') {
                            //$('#favorite').hide();
                            $this.removeClass('add').addClass('del').html('删除收藏');
                            alert(result.msg);
                        } else {
                            alert(result.msg);
                        }
                    }
                });
            }
        } else if ($this.hasClass('del')){
            if(confirm('真的要把此职位信息从收藏中删除吗？')){
                var fulltime_id = $('#fulltime_id').val();
                $.ajax({
                    url : '/fulltimes/delFavourite',
                    type : 'post',
                    data : 'fulltimes_id=' + fulltime_id,
                    success : function(data)
                    {
                        var result = eval("("+data+")");
                        if (result.result == 'OK') {
                            //$('#delete').hide();
                            $this.removeClass('del').addClass('add').html('收藏');
                            alert(result.msg);
                        } else {
                            alert(result.msg);
                        }
                    }
                });
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
            <a href="javascript:void(0)">常规招聘</a>&gt;&gt;
            <a href="javascript:void(0)">常规职位详情</a>
        </p>
    </div>    
    <div class="biaotit" id="title">{$fulltime.Fulltime.title}</div>
    <div class="gongsichakan_jobs jsxxxq">
      <div class="gongsichakan_post">
        <p class="jinggao">发布时间：{$fulltime.Fulltime.created|date_format:"%Y-%m-%d"} 信息编号：{$fulltime.Fulltime.id}  该信息被浏览 7 次 </p>
        <table class="posInfo" width="100%" border="0" cellspacing="0" cellpadding="0">
          {if !$isAuthor}
          <tr>
            <th width="119" scope="row">公司名称：</th>
            <td width="373">
                {if !empty($homepage.Homepage.domain)}
                <a href="/homes/index/{$homepage.Homepage.domain}" target="_blank" class="red">{$fulltime.Fulltime.company}</a>
                {else}
                {$fulltime.Fulltime.company}
                {/if}
            </td>
          </tr>
          <tr>
            <th width="119" scope="row">营业执照：</th>
            <td width="373"><font color="#FF0000">已验证</font></td>
          </tr>
          {/if}
          <tr>
            <th width="119" scope="row">工作性质：</th>
            <td width="373">{$fulltime.Fulltime.type}</td>
          </tr>
          <tr>
            <th scope="row">薪资待遇：</th>
            <td>{$fulltime.Fulltime.salary}元</td>
          </tr>
          <tr>
            <th scope="row">学历要求：</th>
            <td>
            {$educateds = Configure::read('Fulltime.educated')}
            {$educateds[$fulltime.Fulltime.educated]}
            </td>
          </tr>
          <tr>
            <th scope="row">经验要求：</th>
            <td>1-3年</td>
          </tr>
          <tr>
            <th scope="row">性别要求：</th>
            <td>
            {if $fulltime.Fulltime.sex == 1} 男
            {elseif $fulltime.Fulltime.sex ==2}女
            {else}不限
            {/if}
            </td>
          </tr>
          <tr>
            <th scope="row">招聘人数：</th>
            <td>{$fulltime.Fulltime.number}人</td>
          </tr>
          <tr>
            <th scope="row">职位行业：</th>
            <td>
                {$this->Category->getCategoryName($fulltime.Fulltime.category)}
                <input type="hidden" name="category" id="category" value="{$fulltime.Fulltime.category}" />
            </td>
          </tr>
          <tr>
            <th scope="row">工作区域：</th>
            <td>
            {$provincial = $this->City->cityName($fulltime.Fulltime.provincial)}
            {$city = $this->City->cityName($fulltime.Fulltime.city)}
            {if $provincial != $city}
            {$provincial} {$city}
            {else}
            {$provincial}
            {/if}
            </td>
          </tr>
          <tr>
            <th scope="row">联系人：</th>
            <td>{$fulltime.Fulltime.contact}</td>
          </tr>
          {$contacts = json_decode($fulltime.Fulltime.contact_method, true)}
          {foreach $contacts as $contact}
          <tr>
            <th scope="row">联系方式：</th>
            <td>{$contact.method} {$contact.number}</td>
          </tr>
          <tr>
            <th scope="row">职位要求：</th>
            <td><p>{$fulltime.Fulltime.require}</p></td>
          </tr>
          <tr>
            <th scope="row">补充说明：</th>
            <td><p>{$fulltime.Fulltime.additional}</p></td>
          </tr>
          {/foreach}
        </table>
      </div>       
        {if !$isAuthor}
			   <div style="width:200px;" class="divBtnContainer">
                <a class="zclan zclan7 btnDeliverR" href="javascript:void(0)" id="candidate">投递简历</a>
                {if $showFavourite == 'add'}
                    <a class="zclan zclan7 add" href="javascript:void(0)" id="favorite">收藏</a>
                {elseif $showFavourite == 'delete'}
                    <a class="zclan zclan7 del" href="javascript:void(0)" id="favorite">删除收藏</a>
                {/if}
			  </div>
            {else}
                <a class="zclan zclan4 btnDeliverR" href="javascript:void(0)" id="delete">删除职位</a>
            {/if}
    </div>
</div>
<input type="hidden" name="fulltime_id" id="fulltime_id" value="{$fulltime.Fulltime.id}" />
<input type="hidden" name="receiver" id="receiver" value="{$fulltime.Fulltime.members_id}" />
<div class="jsxxxq jsxxxqB" style="height:179px;">
    
</div>
