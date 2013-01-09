<div class="advance_seach pltParttimes">    
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
      <!--<li class="lists trade"><span class="title">
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
      </li>-->
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
        <input type="text" name="inpKeyword" class="inpKeyword" value="请输入关键字" placeholder="请输入关键字" onFocus="this.select()"/>
      </li>
      </ul>
    <div class="clearfix"></div>       
        <ul class="ulParttime">
            <li class="lists">经验要求：
                <select>
                    <option>不限</option>
                    <option>1年以下</option>
                    <option>1-2年</option>
                    <option>2-3年</option>
                    <option>3年以上</option>
                </select>
            </li>
            <li class="lists">学历要求：
                <select>
                    <option>不限</option>
                    <option>小学及以上</option>
                    <option>高中/中专及以上</option>
                    <option>本科/大专及以上</option>
                    <option>研究生及以上</option>
                </select>
            </li>
            <li class="lists">薪资：
                <select>
                    <option>不限</option>
                    <option>1000元/月以下</option>
                    <option>1000-2000元/月</option>
                    <option>2000-3000元/月</option>
                    <option>3000-4000元/月</option>
                    <option>4000元/月以上</option>
                </select>
            </li>
            <li class="lists">工作性质：
                <select>
                    <option>不限</option>
                    <option>全职</option>
                    <option>兼职</option>
                </select>
            </li>
            <li class="lists">发布日期：
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
