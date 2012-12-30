<div class="advance_seach">
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
        <div class="divTable divTableProduct">
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
            <li class="trade">
                <span class="title">
                    <input type="button" class="inpButton" value="行业（可选）"/>
                </span>
            </li>
            <li class="product">
                <span class="title">
                    <input type="button" class="inpButton" value="产品或服务（可选）"/>
                </span>
            </li>
            <li class="keyword">
                <input type="text" name="inpKeyword" class="inpKeyword" value="请输入关键字"/>
            </li>
        </ul>
        <table width="0" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><ul class="ulTable ulTableCity"></ul></td>
                <td><ul class="ulTable ulTableTrade"></ul></td>
                <td>
                    <ul class="ulTable ulTableProduct">
                    </ul>
                </td>
            </tr>
        </table>
        <ul>
            <li style="width:255px;height:40px;">
                <label>信息价格：</label>
                <input type="text" id="amount-jiage" name="price" />
                <div id="slider-price" style="margin-left:66px"></div>
            </li>
            <li style="width:190px;">是否支持积分交易：
                <select name="payment_method">
                <option value="">不限</option>
                <option value="1">是</option>
                <option value="0">否</option>
              </select>
            </li>
            <li style="width:140px;">发布日期：
                <select name="limitTime">
                <option value="">全部</option>
                <option value="0">当日</option>
                <option value="3">3天</option>
                <option value="7">一周</option>
                <option value="30">一个月</option>
              </select>
            </li>
        </ul>
    </div>
    <!--<div class="divMap">
      <div class="divMapCon">
            <div class="divInput">
                <input type="text" id="geostrPosition" value="输入地址查询"/>
                <input type="button" value="搜索" id="codeAddress"/>
                <input type="hidden" id="comlatlng" />
            </div>
            <div id="mapLayout"></div>
        </div>
    </div>-->
    <!--<div class="toggleMap">打开地图检索</div>-->
    <a class="zclan zclan4" href="javascript:void(0)" id="search">检索</a>
</div>