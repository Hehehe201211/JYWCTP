<div class="advance_seach">
  <div class="switchBox">
    <ul>
      <li class="lists city"><span class="title">
        <input type="button" value="城市（可选）" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>城市选择器</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">返回省份</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->City->parentCityList() as $city}
                <dd>
                  <label>
                    <input type="checkbox" value="{$city.City.id}" class="inpCheckbox">
                    {$city.City.name}</label>
                </dd>
                {/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
            </dd>
            <dt>您已经选择的城市是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected">
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts">
        </ul>
      </li>
      <li class="lists trade"><span class="title">
        <input type="button" value="行业（可选）" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>行业选择器</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">行业</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->Category->parentCategoryList() as $value}
                <dd>
                  <label>
                    <input type="checkbox" value="{$value.Category.id}" class="inpCheckbox">
                    {$value.Category.name}</label>
                </dd>
                {/foreach}
              </dl>
            </dd>
            <dt>您已经选择的行业是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected">
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts">
        </ul>
      </li>
      <li class="lists product"><span class="title">
        <input type="button" value="产品或服务（可选）" class="inpButton">
        </span>
        <div class="divTable">
          <div class="divtt">
            <div class="right">[确定]</div>
            <strong>产品或服务</strong>（最多可选5项） </div>
          <dl>
            <dt class="goback"><a href="#">返回产品或服务</a></dt>
            <dd>
              <dl class="options">
                {foreach $this->Category->parentCategoryList() as $cate}
                <dd>
                  <label>
                    <input type="checkbox" value="{$cate.Category.id}" class="inpCheckbox">
                    {$cate.Category.name}</label>
                </dd>
                {/foreach}
              </dl>
              <dl class="subOptions">
              </dl>
            </dd>
            <dt>您已经选择的产品和服务是:(点击可以取消选择)</dt>
            <dd>
              <dl class="selected">
              </dl>
            </dd>
          </dl>
          <div class="divtt">
            <div class="right">[确定]</div>
          </div>
        </div>
        <ul class="selectedOpts">
        </ul>
      </li>
      <li class="lists keyword">
        <input type="text" name="keyword" class="inpKeyword" value="{if isset($this->data['keyword'])}{$this->data['keyword']}{else}请输入关键字{/if}" placeholder="请输入关键字" onFocus="this.select()"/>
      </li>
      </ul>
      <div class="clearfix"></div>
      <ul>
      <li class="lists" style="width:255px;height:40px;">
        <label>信息价格：</label>
        <input type="text" id="amount-jiage" name="price" />
        <div id="slider-price" style="margin-left:66px"></div>
      </li>
      <li class="lists" style="width:190px;">是否支持积分交易：
        <select name="payment_method">
          <option value="">不限</option>
          <option value="1">是</option>
          <option value="0">否</option>
        </select>
      </li>
      <li class="lists" style="width:140px;">发布日期：
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
  <a class="zclan zclan4" href="javascript:void(0)" id="search">检索</a> </div>
