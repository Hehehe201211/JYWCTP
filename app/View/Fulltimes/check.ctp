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
{/literal}
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
        <dl>
            <dt>
                <label><font class="facexh">*</font>信息标题：</label>
                {$this->data['title']}
                <input type="hidden" name="title" value="{$this->data['title']}">
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘职位：</label>
                {$this->data['post']}
                <input type="hidden" name="post" value="{$this->data['post']}">
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘单位：</label>
                {$this->data['company']}
                <input type="hidden" name="company" value="{$this->data['company']}"/>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘性质：</label>
                <div class="divSex jobNature">
                {$this->data['type']}
                <input type="hidden" name="type" value="{$this->data['type']}"/>
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>性别要求：</label>
                <div class="divSex jobNature">
                {if $this->data['sex'] == 1} 男
                {elseif $this->data['sex'] ==2}女
                {else}不限
                {/if}
                <input type="hidden" name="sex" value="{$this->data['sex']}"/>
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>学历要求：</label>
                <div class="divSex jobNature">
                {$educated}
                <input type="hidden" name="educated" value="{$this->data['educated']}"/>
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>工作经验：</label>
                <div class="divSex jobNature">
                {$continued}
                <input type="hidden" name="continued" value="{$this->data['continued']}"/>
                </div>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘有效期：</label>
                <ul class="validity">
                    <li>
                    {$this->data['begin']}
                    <input type="hidden" name="begin"  value="{$this->data['begin']}"/>
                    </li>
                    <li style="width:36px;text-align:center">至</li>
                    <li>
                    {$this->data['end']}
                    <input type="hidden" name="end" value="{$this->data['end']}"/>
                    </li>
                </ul>
            </dt>
            <dt>
                <label><font class="facexh">*</font>招聘人数：</label>
                {$this->data['number']}
                <input type="hidden" name="number" value="{$this->data['number']}"/>
                &nbsp;人
            </dt>
            <dt>
                <label><font class="facexh">*</font>职位行业：</label>
                {$this->Category->getCategoryName($this->data['category'])}
                <input type="hidden" name="category" class="contact_method" value="{$this->data['category']}" />
            </dt>
            <dt>
                <label><font class="facexh">*</font>工作城市：</label>
                {$provincial = $this->City->cityName($this->data['provincial'])}
                {$city = $this->City->cityName($this->data['city'])}
                {if $provincial != $city}
                {$provincial} {$city}
                {else}
                {$provincial}
                {/if}
                <input type="hidden" name="provincial" class="contact_method" value="{$this->data['provincial']}" />
                <input type="hidden" name="city" class="contact_method" value="{$this->data['city']}" />
            </dt>
            <dt>
                <label><font class="facexh">*</font>联系人：</label>
                {$this->data['contact']}
                <input type="hidden" name="contact" class="contact" value="{$this->data['contact']}" />
            </dt>
            {foreach $this->data['method'] as $key => $method}
            <dt>
                <label>联系方式：</label>
                <div class="area1">
                    {$method}
                    <input type="hidden" name="method[]" value="{$method}" />
                </div>
                {$this->data['method_number'][$key]}
                <input type="hidden" name="method_number[]" value="{$this->data['method_number'][$key]}">
            </dt>
            {/foreach}
            <!--<dt>
                <label>联系邮箱：</label>
                {$this->data['email']}
                <input type="hidden" name="email" class="post" value="{$this->data['email']}"/>（如果有多个邮箱，请以“,”隔开）
            </dt>-->          
            <dt>
                <label><font class="facexh">*</font>底薪：</label>
                {$this->data['salary']}
                <input type="hidden" name="salary" value="{$this->data['salary']}" />
            </dt>
            <dt>
                <label>待遇：</label>
                {$this->data['treatment']}
                <input type="hidden" name="treatment" value="{$this->data['treatment']}"/>
            </dt>
            <dt>
                <label><font class="facexh">*</font>职位要求：</label>
                {$this->data['require']}
                <input type="hidden" name="require" value="{$this->data['require']}"/>
            </dt>
            <dt>
                <label>补充说明：</label>
                {$this->data['additional']}
                <input type="hidden" name="additional" value="{$this->data['additional']}"/>
            </dt>
        </dl>
        <div class="clearfix"></div>
        <a href="javascript:void(0)" id="complete" class="zclan zclan3">提交</a>
        <a href="javascript:void(0)" id="back" class="zclan zclan3">修改</a>
    </form>
    </div>
</div>