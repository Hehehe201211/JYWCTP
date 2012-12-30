<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#delete').click(function(){
        if (confirm('你真的要删除此信息？')){
            $.ajax({
                url : '/auditions/delete',
                type : 'post',
                data : 'type=send&id=' + $('#id').val(),
                success : function(data)
                {
                    var data=eval("("+data+")");
                    if (data.result == 'OK')
                    {
                        alert('信息删除成功！');
                        if ($('#status').val() == 1) {
                            location.href = '/auditions/listview?type=send';
                        } else {
                            location.href = '/auditions/inviteList?type=send';
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
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="new-zwscj.html">常规招聘</a>&gt;&gt;<a href="#">{$title_for_layout}</a></p>
    </div>
    {if $audition.Audition.status == Configure::read('Audition.status_accept')}
        <div class="zy_zszlB zy_zszlBT">
        <div class="txtTousu"><strong>留言：</strong>{$audition.Audition.message}&nbsp;&nbsp;[{$audition.Audition.modified|date_format:"%Y-%m-%d"}]</div>
        </div>
    {/if}
    {if $audition.Audition.fulltimes_id !== NULL}
    <div class="biaotit">{$audition.Fulltime.post}</div>
    <div class="gongsichakan_jobs jsxxxq">
      <div class="gongsichakan_post">
        <p class="jinggao">发布时间：{$audition.Fulltime.created|date_format:"%Y-%m-%d"} 信息编号：{$audition.Fulltime.id} 该信息被浏览 7 次 </p>
        <table width="492" cellspacing="0" cellpadding="0" border="0" class="posInfo">
          <tbody>
          <tr>
            <th width="119" scope="row">公司名称：</th>
            <td width="373"><a class="red" target="_blank" href="gsqt-index.html">{$audition.Member.company_name}</a></td>
          </tr>
          <tr>
            <th width="119" scope="row">营业执照：</th>
            <td width="373"><font color="#FF0000">已验证</font></td>
          </tr>
          <tr>
            <th width="119" scope="row">工作性质：</th>
            <td width="373">{$audition.Fulltime.type}</td>
          </tr>
          <tr>
            <th scope="row">薪资待遇：</th>
            <td>{$audition.Fulltime.salary}</td>
          </tr>
          <tr>
            <th scope="row">学历要求：</th>
            <td>
            {$educateds = Configure::read('Fulltime.educated')}
            {$educateds[$audition.Fulltime.educated]}
            </td>
          </tr>
          <tr>
            <th scope="row">经验要求：</th>
            <td>1-3年</td>
          </tr>
          <tr>
            <th scope="row">性别要求：</th>
            <td>
            {if $audition.Fulltime.sex == 1} 男
            {elseif $audition.Fulltime.sex ==2}女
            {else}不限
            {/if}
            </td>
          </tr>
          <tr>
            <th scope="row">招聘人数：</th>
            <td>{$audition.Fulltime.number}人</td>
          </tr>
          <tr>
            <th scope="row">职位行业：</th>
            <td>
                {$this->Category->getCategoryName($audition.Fulltime.category)}
                <input type="hidden" name="category" id="category" value="{$audition.Fulltime.category}" />
            </td>
          </tr>
          <tr>
            <th scope="row">工作区域：</th>
            <td>
            {$provincial = $this->City->cityName($audition.Fulltime.provincial)}
            {$city = $this->City->cityName($audition.Fulltime.city)}
            {if $provincial != $city}
            {$provincial} {$city}
            {else}
            {$provincial}
            {/if}
            </td>
          </tr>
          <tr>
            <th scope="row">联系人：</th>
            <td>{$audition.Fulltime.contact}</td>
          </tr>
          {$contacts = json_decode($audition.Fulltime.contact_method, true)}
          {foreach $contacts as $contact}
          <tr>
            <th scope="even">联系方式：</th>
            <td>{$contact.method} {$contact.number}</td>
          </tr>
          {/foreach}
          <tr>
            <th scope="row">联系邮箱：</th>
            <td>{$audition.Fulltime.require}</td>
          </tr>
        </tbody>
        </table>
      </div>
      <div class="biaotit">职位要求</div>
      <div class="xxContent">
        {$audition.Fulltime.require}
      </div>
      <div class="biaotit">补充说明</div>
      <div class="xxContent">{$audition.Fulltime.additional} </div>
      <div class="gongsichakan_info">
      <input type="hidden" id="status" value="{$audition.Audition.status}" />
      <input type="hidden" name="id" id="id" value="{$audition.Audition.id}" />
      <a href="javascript:void(0)" id="delete" class="zclan zclan3">删除</a>
      </div>
    </div>
    {else}
        <div class="gongsichakan_jobs jsxxxq">
            <div class="gongsichakan_post">
                <table width="492" cellspacing="0" cellpadding="0" border="0" class="posInfo">
                      <tbody>
                      <tr>
                        <th width="119" scope="row">公司名称：</th>
                        <td width="373"><a class="red" target="_blank" href="gsqt-index.html">{$audition.Member.company_name}</a></td>
                      </tr>
                      <tr>
                        <th width="119" scope="row">营业执照：</th>
                        <td width="373"><font color="#FF0000">已验证</font></td>
                      </tr>
                      </tbody>
                  </table>
            </div>
            <div class="gongsichakan_info">
                <input type="hidden" id="status" value="{$audition.Audition.status}" />
                <input type="hidden" name="id" id="id" value="{$audition.Audition.id}" />
                <a href="javascript:void(0)" id="delete" class="zclan zclan3">删除</a>
            </div>
        </div>
    {/if}
  </div>