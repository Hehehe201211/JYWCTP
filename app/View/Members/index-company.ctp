<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="#">企业会员主页</a></p>      
    </div>   
    <div class="biaotit">
        <a class="atitle" href="qy-jzfblb.html">最近发布的平台兼职</a>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="158" class="tr_td1">兼职标题 </th>
          <th width="109" class="tr_td2">产品所属分类 </th>
          <th width="91" class="tr_td7">兼职配合方式  </th>
          <th width="67" class="tr_td4">发布时间</th>
          <th width="61" class="tr_td5">参与人次</th>
          <th width="110" class="tr_td8">选择操作</th>
        </tr>
        </thead>
        <tbody>
        {$method = Configure::read('Parttime.method')}
        {foreach $newParttimes as $parttime}
        <tr class="con_2_tr">
          <td class="tr_td1">
              <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">
                {$parttime.PartTime.title}
              </a>
          </td>
          <td class="tr_td2">
              <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">
                  {$this->Category->getCategoryName($parttime.PartTime.category)}
                  {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
              </a>
          </td>
          <td class="tr_td7">
          <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">
            {$method[$parttime.PartTime.method - 1]}
          </a>
          </td>
          <td class="tr_td4">
              <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">
                {$parttime.PartTime.created|date_format:"%Y-%m-%d"}
              </a>
          </td>
          <td class="tr_td5"><a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">{$parttime.PartTime.clicked}</a></td>
          <td class="con_2_xq_tofu xiushan_anniu">
          <a target="_blank" href="/parttimes/detail?id={$parttime.PartTime.id}">详情</a>
          </td>
        </tr>
        {/foreach}
      </tbody>
    </table>    
    <div class="biaotit">
        <a class="atitle" href="qy-jzfblb.html">最近收到的合作</a>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="158" class="tr_td1">会员名 </th>
          <th width="109" class="tr_td2">产品或服务 </th>
          <th width="91" class="tr_td7">客户区域</th>
          <th width="67" class="tr_td4">合作状态</th>
          <th width="61" class="tr_td5">投递时间</th>
          <th width="110" class="tr_td8">选择操作</th>
        </tr>
        </thead>
        <tbody>
        {$status = Configure::read('Cooperation.receive_status')}
        {foreach $newReceived as $cooperation}
        <tr class="con_2_tr">
          <td class="tr_td1">
              <a target="_blank" href="/cooperations/detail/?receiver={$cooperation.Cooperation.id}">
              {$cooperation.Member.nickname}
              </a>
          </td>
          <td class="tr_td2">
          <a target="_blank" href="/cooperations/detail/?receiver={$cooperation.Cooperation.id}">
            {$this->Category->getCategoryName($cooperation.Information.category)}
            {$this->Category->getCategoryName($cooperation.Information.sub_category)}
          </a>
          </td>
            <td class="tr_td7">
                <a target="_blank" href="/cooperations/detail/?receiver={$cooperation.Cooperation.id}">
                    {$provincial = $this->City->cityName($cooperation.Information.provincial)}
                    {$city = $this->City->cityName($cooperation.Information.city)}
                    {if $provincial == $city}
                        {$provincial}
                    {else}
                        {$provincial} {$city}
                    {/if}
                </a>
            </td>
          <td class="tr_td4">
              <a target="_blank" href="/cooperations/detail/?receiver={$cooperation.Cooperation.id}">
              {$status[$cooperation.Cooperation.status - 1]}
              </a>
          </td>
          <td class="tr_td5"><a target="_blank" href="/cooperations/detail/?receiver={$cooperation.Cooperation.id}">
          {$cooperation.Cooperation.created|date_format:"%Y-%m-%d"}
          </a>
          </td>
          <td class="con_2_xq_tofu xiushan_anniu">
          <a target="_blank" href="/cooperations/detail/?receiver={$cooperation.Cooperation.id}">详情</a>
          </td>
        </tr>
        {/foreach}
      </tbody>
    </table>    
    <div class="biaotit">
        <a class="atitle" href="qy-jzfblb.html">最近收到的简历</a>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="158" class="tr_td1">信息标题 </th>
          <th width="109" class="tr_td2">提供的产品或服务 </th>
          <th width="91" class="tr_td7">客户区域范围</th>
          <th width="74" class="tr_td4">发布时间</th>
          <th width="58" class="tr_td5">点击次数</th>
          <th width="110" class="tr_td8">选择操作</th>
        </tr>
        </thead>
        <tbody>
        <tr class="con_2_tr">
          <td class="tr_td1"><a target="_blank" href="new-xxxq.html">公司标志制作</a></td>
          <td class="tr_td2"><a target="_blank" href="new-xxxq.html">路由器</a></td>
          <td class="tr_td7"><a target="_blank" href="new-xxxq.html">黑龙江省<br>齐齐哈尔市</a></td>
          <td class="tr_td4"><a target="_blank" href="new-xxxq.html">2012-09-25<br>15:15</a></td>
          <td class="tr_td5"><a target="_blank" href="new-xxxq.html">220</a></td>
          <td class="con_2_xq_tofu xiushan_anniu"><a target="_blank" href="new-xxxq.html">详情</a><a onclick="confirm('确定删除这条信息吗？')" href="#">删除</a></td>
        </tr>
      </tbody>
    </table> 
</div>