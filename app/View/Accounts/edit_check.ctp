<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#complete').click(function(){
        $('#edit').attr('action', '/accounts/editComplete');
        $('#edit').submit();
    });
    
    $('#backBtn').click(function(){
        $('#edit').attr('action', '/accounts/edit');
        $('#edit').submit();
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs"><!-- InstanceBeginEditable name="EditRegion7" -->
        <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html">账号管理</a>&gt;&gt;<a href="#">个人信息修改</a></p>
    </div>
    <div class="hysj hysj_fb">
        <ul>
            <li>1.信息修改</li>
            <li>2.信息确认</li>
            <li>3.修改成功</li>
        </ul> 
        <div class="sjle">
        <div class="xq_zl_xbxq">
            <form id="edit" action="" method="post" >
                <table width="570">
                    <tbody>
                    <tr>
                        <td width="176" class="tdRight connection">真实姓名：</td>
                        <td width="382" class="tdLeft" colspan="3">{$this->data['name']}
                            <input type="hidden" id="name" name="name" value="{$this->data['name']}">
                        </td>
                    </tr>
                    <tr>
                        <td width="176" class="tdRight connection">昵称：</td>
                        <td width="382" class="tdLeft" colspan="3">{$this->data['nickname']}
                            <input type="hidden" id="nickname" name="nickname" value="{$this->data['nickname']}">
                        </td>
                    </tr>
                    <tr>
                        <td class="tdRight">我的头像：</td>
                        <td class="tdLeft" colspan="3"><img src="{$this->webroot}img/tx.jpg"></td>
                    </tr>
                    <tr>
                        <td class="tdRight">性别：</td>
                        <td class="tdLeft" colspan="3">
                        {if $this->data['sex'] == 1}男
                        {else}女
                        {/if}
                        <input type="hidden" name="sex" value="{$this->data['sex']}" />
                        </td>
                    </tr>
                    {if isset($this->data['birthday']) && !empty($this->data['birthday'])}
                    <tr>
                        <td class="tdRight">生日：</td>
                        <td class="tdLeft" colspan="3">
                            {$this->data['birthday']}
                            <input type="hidden" name="birthday" value="{$this->data['birthday']}" />
                        </td>
                    </tr>
                    {/if}
                    <tr>
                        <td width="176" class="tdRight connection">手机号码：</td>
                        <td class="tdLeft" colspan="3">{$this->data['mobile']}
                           <input type="hidden" name="mobile" id="mobile" value="{$this->data['mobile']}" />
                        </td>
                    </tr>
                    <tr>
                        <td width="176" class="tdRight">联系电话：</td>
                        <td class="tdLeft" colspan="3">{$this->data['telephone']}
                           <input type="hidden" name="telephone" id="telephone" value="{$this->data['telephone']}" />
                        </td>
                    </tr>
                    <tr>
                        <td width="176" class="tdRight">所在城市：</td>
                        <td class="tdLeft" colspan="3">
                            {$provincial = $this->City->cityName($this->data['provincial_id'])}
                            {$city = $this->City->cityName($this->data['city_id'])}
                            {if $provincial != $city}
                                {$provincial}{$city}
                            {else}
                                {$provincial}
                            {/if}
                            <input type="hidden" name="provincial_id" id="provincial" value="{$this->data['provincial_id']}" />
                            <input type="hidden" name="city_id" id="city_id" value="{$this->data['city_id']}" />
                        </td>
                    </tr>
                    <tr>
                        <td width="176" class="tdRight">公司名称：</td>
                        <td class="tdLeft" colspan="3">{$this->data['company']}
                           <input type="hidden" name="company" id="company" value="{$this->data['company']}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="tdRight">从事行业：</td>
                        <td class="tdLeft" colspan="3">{$this->Category->getCategoryName($this->data['category_id'])}
                           <input type="hidden" name="category_id" id="category_id" value="{$this->data['category_id']}">
                        </td>
                    </tr>
                    <tr>
                        <td class="tdRight">提供产品或服务：</td>
                        <td class="tdLeft" colspan="3">
                            {foreach $this->data['service'] as $service}
                            {$this->Category->getCategoryName($service)}
                            <input type="hidden" name="service[]" value="{$service}">
                            {/foreach}
                        </td>
                    </tr>
                    <tr>
                        <td class="tdRight">业务范围：</td>
                        <td class="tdLeft" colspan="3">{$this->data['business_scope']}
                            <input type="hidden" name="business_scope" id="business_scope" value="{$this->data['business_scope']}">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <a href="javascript:void(0)" id="complete" class="zclan zclan2">提交</a>
        <a href="javascript:void(0)" id="backBtn" class="zclan zclan2">上一步</a>
        </div>
    </div>
</div>