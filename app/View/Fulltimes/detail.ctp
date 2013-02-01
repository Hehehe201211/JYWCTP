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
            if(confirm('确定收藏此职位信息？')){
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
            if(confirm('确定从收藏中删除此职位信息？')){
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
    $("#delete").click(function(){
        if(confirm('确定删除此职位信息？')){
                var fulltime_id = $('#fulltime_id').val();
                $.ajax({
                    url : '/fulltimes/delete',
                    type : 'post',
                    data : 'id=' + fulltime_id,
                    success : function(data)
                    {
                        var result = eval("("+data+")");
                        if (result.result == 'OK') {
                            alert(result.msg);
                            location.href = '/fulltimes/listview';
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
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
            <a href="javascript:void(0)">常规招聘</a>&gt;&gt;
            <a href="javascript:void(0)">常规职位详情</a>
        </p>
    </div>    
    <div class="biaotit" id="title">{$fulltime.Fulltime.title}</div>
    <div class="tableDetail">
        <p class="jinggao">发布时间：{$fulltime.Fulltime.created|date_format:"%Y-%m-%d"} 信息编号：{$fulltime.Fulltime.id}  该信息被浏览 7 次 </p>
        <table class="posInfo" width="100%" border="0" cellspacing="0" cellpadding="0">
          {if !$isAuthor}
          <tr>
            <th width="25%">公司名称：</th>
            <td width="75%">
                {if !empty($homepage.Homepage.domain)}
                <a href="/homes/index/{$homepage.Homepage.domain}" target="_blank" class="red">{$fulltime.Fulltime.company}</a>
                {else}
                {$fulltime.Fulltime.company}
                {/if}
            </td>
          </tr>
          <tr>
            <th>营业执照：</th>
            <td class="red">已验证</td>
          </tr>
          {/if}
           <tr>
            <th width="25%">招聘职位：</th>
            <td width="75%">{$fulltime.Fulltime.post}</td>
          </tr>
          <tr>
            <th>招聘单位：</th>
            <td>{$fulltime.Fulltime.company}</td>
          </tr>
          <tr>
            <th>招聘有效期：</th>
            <td>{$fulltime.Fulltime.begin|date_format:"%Y-%m-%d"}&nbsp;至&nbsp;{$fulltime.Fulltime.end|date_format:"%Y-%m-%d"}</td>
          </tr>
          <tr>
            <th>工作性质：</th>
            <td>{$fulltime.Fulltime.type}</td>
          </tr>
          <tr>
            <th>底薪：</th>
            <td>{$fulltime.Fulltime.salary}元</td>
          </tr>
          <tr>
            <th>待遇：</th>
            <td>{$fulltime.Fulltime.treatment}</td>
          </tr>
          <tr>
            <th>学历要求：</th>
            <td>
            {$educateds = Configure::read('Fulltime.educated')}
            {$educateds[$fulltime.Fulltime.educated]}
            </td>
          </tr>
          <tr>
            <th>经验要求：</th>
            <td>{$continued = Configure::read('Fulltime.continued')}{$continued[$fulltime.Fulltime.continued]}</td>
          </tr>
          <tr>
            <th>性别要求：</th>
            <td>
            {if $fulltime.Fulltime.sex == 1} 男
            {elseif $fulltime.Fulltime.sex ==2}女
            {else}不限
            {/if}
            </td>
          </tr>
          <tr>
            <th>招聘人数：</th>
            <td>{$fulltime.Fulltime.number}人</td>
          </tr>
          <tr>
            <th>职位行业：</th>
            <td>
                {$this->Category->getCategoryName($fulltime.Fulltime.category)}
                <input type="hidden" name="category" id="category" value="{$fulltime.Fulltime.category}" />
            </td>
          </tr>
          <tr>
            <th>工作区域：</th>
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
            <th>联系人：</th>
            <td>{$fulltime.Fulltime.contact}</td>
          </tr>
          {$contacts = json_decode($fulltime.Fulltime.contact_method, true)}
          {foreach $contacts as $contact}
          <tr>
            <th>联系方式：</th>
            <td>{$contact.method} {$contact.number}</td>
          </tr>
          <tr>
            <th>职位要求：</th>
            <td><p>{$fulltime.Fulltime.require}</p></td>
          </tr>
          <tr>
            <th>补充说明：</th>
            <td><p>{$fulltime.Fulltime.additional}</p></td>
          </tr>
          {/foreach}
        </table>    
        <div style="width:200px;" class="divBtnContainer">  
        {if !$isAuthor}			   
                <a class="zclan zclan7" href="javascript:void(0)" id="candidate">投递简历</a>
                {if $showFavourite == 'add'}
                    <a class="zclan zclan7 add" href="javascript:void(0)" id="favorite">收藏</a>
                {elseif $showFavourite == 'delete'}
                    <a class="zclan zclan7 del" href="javascript:void(0)" id="favorite">删除收藏</a>
                {/if}			  
            {else}
                <a class="zclan zclan7" href="/fulltimes/edit/?id={$this->request->query['id']}" id="">修改</a>
                <a class="zclan zclan7" href="javascript:void(0)" id="delete">删除职位</a>
            {/if}
            </div>
    </div>
</div>
<input type="hidden" name="fulltime_id" id="fulltime_id" value="{$fulltime.Fulltime.id}" />
<input type="hidden" name="receiver" id="receiver" value="{$fulltime.Fulltime.members_id}" />
<div class="jsxxxq jsxxxqB" style="width:605px;">
    
</div>
