<div class="main">
    <div class="wmxxjs_left">
        <div class="biaotit">{$fulltime.Fulltime.title}</div>
        <div class="gongsichakan_jobs jsxxxq">
            <div class="gongsichakan_post">
                <p class="jinggao">发布时间：{$fulltime.Fulltime.created|date_format:"%Y-%m-%d"} 信息编号：{$fulltime.Fulltime.id} 投递简历  {$fulltime.Fulltime.audition_cnt} 次 </p>
                <table class="posInfo" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <th width="25%" scope="row">公司名称：</th>
                        <td width="75%">
                        {if !empty($homepage.Homepage.domain)}
                        <a href="/homes/index/{$homepage.Homepage.domain}" target="_blank" class="red">{$fulltime.Fulltime.company}</a>
                        {else}
                        {$fulltime.Fulltime.company}
                        {/if}
                        </td>
                    </tr>
                    <tr>
                        <th width="148" scope="row">营业执照：</th>
                        <td width="593"><font color="#FF0000">已验证</font></td>
                    </tr>
                    <tr>
                        <th width="148" scope="row">招聘职位：</th>
                        <td width="593">{$fulltime.Fulltime.post}</td>
                    </tr>
                    <tr>
                        <th width="148" scope="row">招聘单位：</th>
                        <td width="593">{$fulltime.Fulltime.company}</td>
                    </tr>
                    <tr>
                        <th scope="row">招聘有效期：</th>
                        <td>{$fulltime.Fulltime.begin|date_format:"%Y-%m-%d"}&nbsp;至&nbsp;{$fulltime.Fulltime.end|date_format:"%Y-%m-%d"}</td>
                    </tr>
                    <tr>
                        <th scope="row">工作性质：</th>
                        <td>{$fulltime.Fulltime.type}</td>
                    </tr>
                    <tr>
                        <th scope="row">底薪：</th>
                        <td>{$fulltime.Fulltime.salary}元</td>
                    </tr>
                    <tr>
                        <th scope="row">待遇：</th>
                        <td>{$fulltime.Fulltime.treatment}</td>
                    </tr>
                    <tr>
                        <th scope="row">学历要求：</th>
                        <td>
                        {$educateds = Configure::read('Fulltime.educated')}
                        {$educateds[$fulltime.Fulltime.educated]}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" style="vertical-align:top">经验要求：</th>
                        <td>{$continued = Configure::read('Fulltime.continued')}{$continued[$fulltime.Fulltime.continued]}</td>
                    </tr>
                    <tr>
                        <th scope="row">性别要求：</th>
                        <td>
                        {if $fulltime.Fulltime.sex == 1} 男
                        {elseif $fulltime.Fulltime.sex ==2}女
                        {else}不限
                        {/if}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">招聘人数：</th>
                        <td>{$fulltime.Fulltime.number}人</td>
                    </tr>
                        <tr>
                            <th scope="row">职位行业：</th>
                            <td>{$this->Category->getCategoryName($fulltime.Fulltime.category)}</td>
                        </tr>
                    <tr>
                        <th scope="row">工作区域：</th>
                        <td>
                        {$provincial = $this->City->cityName($fulltime.Fulltime.provincial)}
                        {$city = $this->City->cityName($fulltime.Fulltime.city)}
                        {if $provincial != $city}
                        {$provincial} {$city}
                        {else}
                        {$provincial}
                        {/if}
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">联系人：</th>
                        <td>{$fulltime.Fulltime.contact}</td>
                    </tr>
                    {$contacts = json_decode($fulltime.Fulltime.contact_method, true)}
                      {foreach $contacts as $contact}
                      <tr>
                        <th scope="row">联系方式：</th>
                        <td>{$contact.method} {$contact.number}</td>
                      </tr>
                      {/foreach}
                </table>
                <div style="width:200px;" class="divBtnContainer">
                <a class="zclan zclan7" href="/fulltimes/detail?id={$fulltime.Fulltime.id}">投递简历</a>
                </div>
            </div>
        </div>
    </div>
    <div class="sider">
    {$recommendType = 'fulltime'}
        {$this->element('common/parttime-right')}
    </div>
    <div class="clear">&nbsp;</div>
</div>
