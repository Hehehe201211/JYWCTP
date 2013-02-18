<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="#">企业会员主页</a></p>      
    </div>   
    <div class="mebBaseinfo epmebBaseinfo">
        <div class="mebBaseinfoL">
          <table width="100%" height="100%" border="0">
          {if $memberInfo.Member.grade == 2}
            <tr>
              <td width="34%" rowspan="6">
              {if !empty($memberInfo.Attribute.thumbnail)}
                {$thumbnail = Configure::read('Data.path')|cat:$memberInfo.Attribute.thumbnail}
                {if file_exists($thumbnail)}
                    <img src="{$this->webroot}{$memberInfo.Attribute.thumbnail}">
                {else}
                    <img src="{$this->webroot}img/tx.jpg">
                {/if}
              {else}
              <img src="{$this->webroot}img/tx.jpg">
              {/if}
              </td>
              <td width="66%">会员昵称：{$memberInfo.Member.nickname}</td>
            </tr>
            <tr>
              <td>公司名称：{$memberInfo.Member.company_name}</td>
            </tr>
            <tr>
              <td>绑定邮箱：{$memberInfo.Member.email}</td>
            </tr>
            <tr>
              <td>行业：{$this->Category->getCategoryName($memberInfo.Attribute.category_id)}</td>
            </tr>
            <tr>
              <td>地址：{$memberInfo.Attribute.address}</td>
            </tr>
            <tr>
              <td>账户有效期：2012-09-20&nbsp;至&nbsp;2013-09-20</td>
            </tr>
            <tr>
              <td colspan="2" class="mebInfo">
              <span>资料完整度：</span>
              <span class="progressBar">
              <span style="width:100%">&nbsp;100%&nbsp;</span>
              </span>
              <a class="icon iconZ iconH" href="/accounts/edit" title="营业执照已认证"></a>
              <a class="icon iconM iconH" href="/accounts/edit" title="已绑定邮箱"></a>
              </td>
            </tr>
            {else}
            <tr>
              <td width="34%" rowspan="6"><img src="img/tx.jpg" /></td>
              <td width="66%">会员昵称：{$memberInfo.Member.nickname}</td>
            </tr>
            <tr>
              <td>公司名称：{$memberInfo.Member.company_name}<a  href="/members/upgrade">完善资料</a></td>
            </tr>
            <tr>
              <td>绑定邮箱：{$memberInfo.Member.email}</td>
            </tr>
            <tr>
              <td>行业：<a  href="/members/upgrade">完善资料</a></td>
            </tr>
            <tr>
              <td>地址：<a  href="/members/upgrade">完善资料</a></td>
            </tr>
            <tr>
              <td>账户有效期：2012-09-20&nbsp;至&nbsp;2013-09-20</td>
            </tr>
            <tr>
              <td colspan="2" class="mebInfo">
              <span>资料完整度：</span>
              <span class="progressBar">
              <span style="width:30%">&nbsp;100%&nbsp;</span>
              </span>
              <a href="/accounts/edit">完善资料</a>
              <a class="icon iconZ iconH" href="/accounts/edit" title="营业执照已认证"></a>
              <a class="icon iconM iconH" href="/members/upgrade" title="已绑定邮箱"></a>
              </td>
            </tr>
            {/if}
          </table>
        </div>
        <div class="mebBaseinfoR">
          <dl>
            <dd>已发布岗位：
            <a href="/fulltimes/listview">{$fulltimeCount}</a>个全职&nbsp;&nbsp;
            <a href="/parttimes/listview?type=send">{$parttimeCount}</a>个兼职
            </dd>
            <dd>已收到简历到：<a href="/auditions/listview?type=receive">{$receiveResumeCount}</a>封</dd>
            <dd>已收到合作信息：<a href="/cooperations/listview/?type=receiver">{$receiveCooperationsCount}</a>条</dd>
            <!--<dd>留言：<a href="/accounts/sms">0</a>条</dd>-->
          </dl>
        </div>
      </div>
    <div class="biaotit">
        <a class="atitle" href="/parttimes/listview?type=send">最近发布的平台兼职</a>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="180" class="tr_td1">兼职标题 </th>
          <th width="149" class="tr_td2">产品所属分类 </th>
          <th width="88" class="tr_td7">兼职配合方式  </th>
          <th width="79" class="tr_td4">发布时间</th>
          <th width="57" class="tr_td5">参与人次</th>
          <th width="64" class="tr_td8">选择操作</th>
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
        <a class="atitle" href="/cooperations/listview/?type=receiver">最近收到的合作</a>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="120" class="tr_td1">会员名 </th>
          <th width="166" class="tr_td2">产品或服务 </th>
          <th width="130" class="tr_td7">客户区域</th>
          <th width="61" class="tr_td4">合作状态</th>
          <th width="76" class="tr_td5">投递时间</th>
          <th width="64" class="tr_td8">选择操作</th>
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
          <td class="con_2_xq_tofu xiushan_anniu xiushan_anniu1">
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
          <th width="180" class="tr_td1">职位 </th>
          <th width="60" class="tr_td2">工作性质 </th>
          <th width="60" class="tr_td7">招聘人数</th>
          <th width="70" class="tr_td4">底薪</th>
          <th width="183" class="tr_td5">工作区域</th>
          <th width="64" class="tr_td8">选择操作</th>
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
          <td class="con_2_xq_tofu xiushan_anniu xiushan_anniu1">
          <a target="_blank" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">详情</a>
          </td>
        </tr>
        {/foreach}
      </tbody>
    </table>
    
    <div class="biaotit">
        <a class="atitle" href="/auditions/listview?type=receive">最近收到的简历</a>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
        <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="120" class="tr_td1">会员名 </th>
          <th width="126" class="tr_td2">应聘岗位 </th>
          <th width="82" class="tr_td7">工作经验</th>
          <th width="67" class="tr_td4">学历</th>
          <th width="84" class="tr_td5">现居住地</th>
          <th width="74" class="tr_td5">接收时间</th>
          <th width="64" class="tr_td8">选择操作</th>
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
                <td class="con_2_xq_tofu xiushan_anniu xiushan_anniu1">
                <a target="_blank" href="/auditions/detail?type=receive&id={$audition.Audition.id}" >详情</a>                
                </td>
            </tr>
        {/foreach}
      </tbody>
    </table> 
</div>