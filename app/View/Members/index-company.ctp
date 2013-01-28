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
          <td class="con_2_xq_tofu xiushan_anniu xiushan_anniu1">
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
        <a class="atitle" href="/fulltimes/listview">最近发布的职位信息</a>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="158" class="tr_td1">职位 </th>
          <th width="109" class="tr_td2">工作性质 </th>
          <th width="91" class="tr_td7">招聘人数</th>
          <th width="67" class="tr_td4">底薪</th>
          <th width="61" class="tr_td5">工作区域</th>
          <th width="110" class="tr_td8">选择操作</th>
        </tr>
        </thead>
        <tbody>
        {foreach $newFulltimes as $fulltime}
        <tr class="con_2_tr">
          <td class="tr_td1">
              <a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">
              {$fulltime.Fulltime.post}
              </a>
          </td>
          <td class="tr_td2">
          <a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">
          {$fulltime.Fulltime.type}
          </a>
          </td>
            <td class="tr_td7">
                <a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">
                {$fulltime.Fulltime.number}
                </a>
            </td>
          <td class="tr_td4">
              <a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">
              {$fulltime.Fulltime.salary}元/月
              </a>
          </td>
          <td class="tr_td5"><a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">
            {$provincial = $this->City->cityName($fulltime.Fulltime.provincial)}
            {$city = $this->City->cityName($fulltime.Fulltime.city)}
            {if $provincial != $city}
            {$provincial} {$city}
            {else}
            {$provincial}
            {/if}
          </a>
          </td>
          <td class="con_2_xq_tofu xiushan_anniu">
          <a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">详情</a>
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
          <th width="158" class="tr_td1">会员名 </th>
          <th width="109" class="tr_td2">应聘岗位 </th>
          <th width="91" class="tr_td7">工作经验</th>
          <th width="74" class="tr_td4">学历</th>
          <th width="58" class="tr_td5">现居住地</th>
          <th width="73" class="tr_td5">接收时间</th>
          <th width="110" class="tr_td8">选择操作</th>
        </tr>
        </thead>
        <tbody>
        {$educated = Configure::read('Fulltime.educated')}
        {foreach $newAuditions as $audition}
            <tr class="con_2_tr">
                <td><a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">{$audition.ResumeBase.name}</a></td>
                <td><a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">{$audition.Fulltime.post}</a></td>
                <td><a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">{$audition.Resume.continued}年以上</a></td>
                <td>
                <a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">
                {if $audition.Resume.educated !== NULL}
                    {$educated[$audition.Resume.educated]}
                {/if}
                </a>
                </td>
                <td>
                <a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">
                    {$provincial = $this->City->cityName($audition.ResumeBase.provincial_now)}
                    {$city = $this->City->cityName($audition.ResumeBase.city_now)}
                    {if $provincial != $city}
                    {$provincial} {$city}
                    {else}
                    {$provincial}
                    {/if}
                </a>
                </td>        
                <td><a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}">{$audition.Audition.created|date_format:"%Y-%m-%d"}</a></td>
                <td class="con_2_xq_tofu xiushan_anniu">
                <a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}" >详情</a>
                <a href="javascript:var a=confirm('删除此信息对方不会收到提示，是否删除？')" >删除</a>
                </td>
            </tr>
        {/foreach}
      </tbody>
    </table> 
</div>