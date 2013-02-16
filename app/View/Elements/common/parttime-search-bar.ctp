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
        <input type="text" name="keyword" class="inpKeyword" value="{if isset($this->data['keyword'])}{$this->data['keyword']}{else}请输入关键字{/if}" placeholder="请输入关键字" onFocus="this.select()"/>
      </li>
      </ul>
      {if $this->request->params['action'] != 'parttime'}
    <div class="clearfix"></div>
        <ul class="ulParttime">
            <li class="lists">经验要求：
                <select name="continued">
                    <option value="">不限</option>
                    <option value="1">1年以下</option>
                    <option value="2">1-2年</option>
                    <option value="3">2-3年</option>
                    <option value="4">3年以上</option>
                </select>
            </li>
            <li class="lists">学历要求：
                <select name="educated">
                    <option value="">不限</option>
                    <option value="1">小学及以上</option>
                    <option value="3">高中/中专及以上</option>
                    <option value="5">大专/本科及以上</option>
                    <option value="7">研究生及以上</option>
                </select>
            </li>
            <li class="lists">薪资：
                <select name="salary">
                    <option value="">不限</option>
                    <option value="0-1000">1000元/月以下</option>
                    <option value="1000-2000">1000-2000元/月</option>
                    <option value="2000-3000">2000-3000元/月</option>
                    <option value="3000-4000">3000-4000元/月</option>
                    <option value="4000-">4000元/月以上</option>
                </select>
            </li>
            <li class="lists">工作性质：
                <select name="type">
                    <option value="">不限</option>
                    <option value="全职">全职</option>
                    <option value="兼职">兼职</option>
                </select>
            </li>
            <li class="lists">发布日期：
                <select name="limitTime">
                  <option value="">全部</option>
                  <option value="0">当日</option>
                  <option value="3">3天</option>
                  <option value="7">一周</option>
                  <option value="30">一个月</option>
                </select>
            </li>
        </ul>
        {/if}
    </div>
    <a class="zclan zclan4" href="javascript:void(0)" id="search">检索</a>
</div>
