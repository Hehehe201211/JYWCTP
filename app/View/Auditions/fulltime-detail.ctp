<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#delete').click(function(){
        if (confirm('确定删除此信息？')){
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
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">常规招聘</a>&gt;&gt;
      <a href="javascript:void(0)">{$title_for_layout}</a>
      </p>
    </div>
    {if $audition.Audition.status == Configure::read('Audition.status_accept')}
        <div class="zy_zszlB zy_zszlBT">
        <div class="txtTousu"><strong>留言：</strong>{$audition.Audition.message}&nbsp;&nbsp;[{$audition.Audition.modified|date_format:"%Y-%m-%d"}]</div>
        </div>
    {/if}
    {if $audition.Audition.fulltimes_id !== NULL}
    <div class="biaotit">{$audition.Fulltime.post}</div>
    <div class="tableDetail">
        <p class="jinggao">发布时间：{$audition.Fulltime.created|date_format:"%Y-%m-%d"} 信息编号：{$audition.Fulltime.id} 该信息被浏览 7 次 </p>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="posInfo">
          <tbody>
          <tr>
            <th width="25%">公司名称：</th>
            <td width="75%">
            {if !empty($domain)}
            <a class="red" target="_blank" href="/homes/index/{$domain}">{$audition.Member.company_name}</a>
            {else}
            {$audition.Member.company_name}
            {/if}
            </td>
          </tr>
          <tr>
            <th>营业执照：</th>
            <td class="red">已验证</td>
          </tr>
          <tr>
            <th>工作性质：</th>
            <td>{$audition.Fulltime.type}</td>
          </tr>
          <tr>
            <th>薪资待遇：</th>
            <td>{$audition.Fulltime.salary}</td>
          </tr>
          <tr>
            <th>学历要求：</th>
            <td>
            {$educateds = Configure::read('Fulltime.educated')}
            {$educateds[$audition.Fulltime.educated]}
            </td>
          </tr>
          <tr>
            <th>经验要求：</th>
            <td>1-3年</td>
          </tr>
          <tr>
            <th>性别要求：</th>
            <td>
            {if $audition.Fulltime.sex == 1} 男
            {elseif $audition.Fulltime.sex ==2}女
            {else}不限
            {/if}
            </td>
          </tr>
          <tr>
            <th>招聘人数：</th>
            <td>{$audition.Fulltime.number}人</td>
          </tr>
          <tr>
            <th>职位行业：</th>
            <td>
                {$this->Category->getCategoryName($audition.Fulltime.category)}
                <input type="hidden" name="category" id="category" value="{$audition.Fulltime.category}" />
            </td>
          </tr>
          <tr>
            <th>工作区域：</th>
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
            <th>联系人：</th>
            <td>{$audition.Fulltime.contact}</td>
          </tr>
          {$contacts = json_decode($audition.Fulltime.contact_method, true)}
          {foreach $contacts as $contact}
          <tr>
            <th>联系方式：</th>
            <td>{$contact.method} {$contact.number}</td>
          </tr>
          {/foreach}
          <tr>
            <th>联系邮箱：</th>
            <td>{$audition.Fulltime.require}</td>
          </tr>
          <tr>
            <th>职位要求：</th>
            <td><p>{$audition.Fulltime.require}</p></td>
          </tr>
          <tr>
            <th>补充说明：</th>
            <td><p>{$audition.Fulltime.additional}</p></td>
          </tr>
        </tbody>
        </table>
      <input type="hidden" id="status" value="{$audition.Audition.status}" />
      <input type="hidden" name="id" id="id" value="{$audition.Audition.id}" />
      <a href="javascript:void(0)" id="delete" class="zclan zclan4">删除</a>
    </div>
    {else}
        <div class="tableDetail">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="posInfo">
                      <tbody>
                      <tr>
                        <th width="25%">公司名称：</th>
                        <td width="75%"><a class="red" target="_blank" href="gsqt-index.html">{$audition.Member.company_name}</a></td>
                      </tr>
                      <tr>
                        <th>营业执照：</th>
                        <td class="red">已验证</td>
                      </tr>
                      </tbody>
                  </table>
                <input type="hidden" id="status" value="{$audition.Audition.status}" />
                <input type="hidden" name="id" id="id" value="{$audition.Audition.id}" />
                <a href="javascript:void(0)" id="delete" class="zclan zclan4">删除</a>
        </div>
    {/if}
  </div>