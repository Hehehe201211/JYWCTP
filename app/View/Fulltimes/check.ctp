<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#complete').click(function(){
        $('#fulltime').attr('action', '/fulltimes/complete').submit();        
    });
    $('#back').click(function(){
        $('#fulltime').attr('action', '/fulltimes/create').submit();
    });
});
//{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;
            <a href="qy-jzfbmx.html">常规招聘</a>&gt;&gt;
            <a href="#">发布招聘需求</a>
        </p>
    </div>
    <div class="biaotit">发布招聘需求</div>
    <div class="sjle">
    <form id="fulltime" method="post" action="/fulltimes/check">
    <div class="tableDetail">
    <table width="100%" border="0">
  <tr>
    <th width="25%">信息标题：</th>
    <td width="75%">{$this->data['title']}<input type="hidden" name="title" value="{$this->data['title']}"></td>
  </tr>
  <tr>
    <th>招聘职位：</th>
    <td>{$this->data['post']}<input type="hidden" name="post" value="{$this->data['post']}"></td>
  </tr>
  <tr>
    <th>招聘单位：</th>
    <td>{$this->data['company']}<input type="hidden" name="company" value="{$this->data['company']}"/></td>
  </tr>
  <tr>
    <th>招聘性质：</th>
    <td>{$this->data['type']}
                <input type="hidden" name="type" value="{$this->data['type']}"/></td>
  </tr>
  <tr>
    <th>性别要求：</th>
    <td>{if $this->data['sex'] == 1} 男
                {elseif $this->data['sex'] ==2}女
                {else}不限
                {/if}
                <input type="hidden" name="sex" value="{$this->data['sex']}"/></td>
  </tr>
  <tr>
    <th>学历要求：</th>
    <td>{$educated}
                <input type="hidden" name="educated" value="{$this->data['educated']}"/></td>
  </tr>
  <tr>
    <th>工作经验：</th>
    <td>{$continued}
                <input type="hidden" name="continued" value="{$this->data['continued']}"/></td>
  </tr>
  <tr>
    <th>招聘有效期：</th>
    <td>{$this->data['begin']}
                    <input type="hidden" name="begin"  value="{$this->data['begin']}"/>&nbsp;至&nbsp;
                    {$this->data['end']}
                    <input type="hidden" name="end" value="{$this->data['end']}"/></td>
  </tr>
  <tr>
    <th>招聘人数：</th>
    <td>{$this->data['number']}
                <input type="hidden" name="number" value="{$this->data['number']}"/>&nbsp;人</td>
  </tr>
  <tr>
    <th>职位行业：</th>
    <td>{$this->Category->getCategoryName($this->data['category'])}
                <input type="hidden" name="category" class="contact_method" value="{$this->data['category']}" /></td>
  </tr>
  <tr>
    <th>工作城市：</th>
    <td>{$provincial = $this->City->cityName($this->data['provincial'])}
                {$city = $this->City->cityName($this->data['city'])}
                {if $provincial != $city}
                {$provincial} {$city}
                {else}
                {$provincial}
                {/if}
                <input type="hidden" name="provincial" class="contact_method" value="{$this->data['provincial']}" />
                <input type="hidden" name="city" class="contact_method" value="{$this->data['city']}" /></td>
  </tr>
  <tr>
    <th>联系人：</th>
    <td>{$this->data['contact']}
                <input type="hidden" name="contact" class="contact" value="{$this->data['contact']}" /></td>
  </tr>
  {foreach $this->data['method'] as $key => $method}
  <tr>
    <th>联系方式：</th>
    <td>{$method}<input type="hidden" name="method[]" value="{$method}" />&nbsp;{$this->data['method_number'][$key]}
                <input type="hidden" name="method_number[]" value="{$this->data['method_number'][$key]}"></td>
  </tr>
  {/foreach}
  <tr>
    <th>底薪：</th>
    <td>{$this->data['salary']}
                <input type="hidden" name="salary" value="{$this->data['salary']}" /></td>
  </tr>
  <tr>
    <th>待遇：</th>
    <td>{$this->data['treatment']}
                <input type="hidden" name="treatment" value="{$this->data['treatment']}"/></td>
  </tr>
  <tr>
    <th>职位要求：</th>
    <td> <p>{$this->data['require']}
                <input type="hidden" name="require" value="{$this->data['require']}"/></p></td>
  </tr>
  <tr>
    <th>补充说明：</th>
    <td><p>{$this->data['additional']}
                <input type="hidden" name="additional" value="{$this->data['additional']}"/></p></td>
  </tr>
</table>
    </div>
        
        <div class="clearfix"></div>
        {if isset($this->data['id'])}
        <input type="hidden" value="{$this->data['id']}" name="id" />
        {/if}
        <a href="javascript:void(0)" id="complete" class="zclan zclan3">提交</a>
        <a href="javascript:void(0)" id="back" class="zclan zclan3">修改</a>
    </form>
    </div>
</div>