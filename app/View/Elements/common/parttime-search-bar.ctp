<div class="advance_seach pltParttimes">    
    <div class="switch_box">
        <div class="divTable divTableCity">
            <div class="divtt">
                <div class="left fl"><strong>城市选择器</strong>(最多可选5项)</div>
                <div class="right fr">[确定]</div>
            </div>
            <dl>
                <dt class="goback"><a href="#">返回省份</a></dt>
                    <dl class="options">
                        {foreach $this->City->parentCityList() as $city}
                            <dd>
                                <input type="checkbox" class="inpCheckbox" value="{$city.City.id}"/>
                                <a href="#">{$city.City.name}</a>
                            </dd>
                        {/foreach}
                    </dl>
                <dl class="subOptions"></dl>
                <dt>您已经选择的城市是:(点击可以取消选择)</dt>
                <dl class="selected"></dl>
            </dl>
            <div class="divtt">
                <div class="right fr">[确定]</div>
            </div>
        </div>
        <!--
        <div class="divTable divTableTrade">
            <div class="divtt">
                <div class="left fl"><strong>行业选择器</strong>(最多可选5项)</div>
                <div class="right fr">[确定]</div>
            </div>
            <dl>
                <dt class="goback"><a href="#">行业</a></dt>
                <dl class="options">
                    {foreach $this->Category->parentCategoryList() as $value}
                        <dd>
                            <input type="checkbox" class="inpCheckbox" value="{$value.Category.id}"/>
                            <a href="#">{$value.Category.name}</a>
                        </dd>
                    {/foreach}
                </dl>
                <dl class="subOptions"></dl>
                <dt>您已经选择的城市是:(点击可以取消选择)</dt>
                <dl class="selected"></dl>
            </dl>
            <div class="divtt">
                <div class="right fr">[确定]</div>
            </div>
        </div>
        -->
        <div class="divTable divTableProduct" style="left:118px;">
            <div class="divtt">
                <div class="left fl"><strong>产品或服务</strong>(最多可选5项)</div>
                <div class="right fr">[确定]</div>
            </div>
            <dl>
                <dt class="goback"><a href="#">返回产品或服务</a></dt>
                <dl class="options">
                    {foreach $this->Category->parentCategoryList() as $cate}
                        <dd>
                          <input type="checkbox" value="{$cate.Category.id}" class="inpCheckbox">
                          <a href="#">{$cate.Category.name}</a>
                       </dd>
                    {/foreach}
                </dl>
                <dl class="subOptions"></dl>
                <dt>您已经选择的城市是:(点击可以取消选择)</dt>
                <dl class="selected"></dl>
            </dl>
            <div class="divtt">
                <div class="right fr">[确定]</div>
            </div>
        </div>
        <ul>
            <li class="city">
                <span class="title">
                    <input type="button" class="inpButton" value="城市（可选）"/>
                </span>
            </li>
            <!--
            <li class="trade">
                <span class="title">
                    <input type="button" class="inpButton" value="行业（可选）"/>
                </span>
            </li>
            -->
            <li class="product">
                <span class="title">
                    <input type="button" class="inpButton" value="产品或服务（可选）"/>
                </span>
            </li>
            <li class="keyword">
                <input type="text" name="inpKeyword" class="inpKeyword" value="请输入关键字" placeholder="请输入关键字" onfocus="this.select();"/>
            </li>
        </ul>
        <table width="0" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><ul class="ulTable ulTableCity"></ul></td>
                <!--
                <td><ul class="ulTable ulTableTrade"></ul></td>
                -->
                <td>
                    <ul class="ulTable ulTableProduct">
                    </ul>
                </td>
            </tr>
        </table>
        <ul class="ulParttime">
            <li>经验要求：
                <select>
                    <option>不限</option>
                    <option>1年以下</option>
                    <option>1-2年</option>
                    <option>2-3年</option>
                    <option>3年以上</option>
                </select>
            </li>
            <li>学历要求：
                <select>
                    <option>不限</option>
                    <option>小学及以上</option>
                    <option>高中/中专及以上</option>
                    <option>本科/大专及以上</option>
                    <option>研究生及以上</option>
                </select>
            </li>
            <li>薪资：
                <select>
                    <option>不限</option>
                    <option>1000元/月以下</option>
                    <option>1000-2000元/月</option>
                    <option>2000-3000元/月</option>
                    <option>3000-4000元/月</option>
                    <option>4000元/月以上</option>
                </select>
            </li>
            <li>工作性质：
                <select>
                    <option>不限</option>
                    <option>全职</option>
                    <option>兼职</option>
                </select>
            </li>
            <li>发布日期：
                <select>
                    <option>不限</option>
                    <option>当日</option>
                    <option>3天</option>
                    <option>一周</option>
                    <option>两周</option>
                    <option>一个月及以上</option>
                </select>
            </li>
        </ul>
    </div>
    <a class="zclan zclan4" href="javascript:void(0)" id="search">检索</a>
</div>
