<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.invite').click(function(){
        if(confirm('是否真的要邀请此会员？')) {
            $.ajax({
                url : '/invitations/add',
                type : 'post',
                data : 'receiver=' + $('#members_id').val(),
                success : function(data) {
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        $('.invite').hide();
                        alter('邀请成功，请关注对方的回复！');
                    } else {
                        alter(result.msg);
                    }
                }
            });
        }
    })    
});

{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="qy-ypqq.html">平台兼职</a>&gt;&gt;<a href="#">业务精英检索详情</a></p>      
    </div>   
     <div class="biaotit">{$member.Member.nickname}的会员信息</div>
    <div class="tableDetail tableDetail1">
      <table width="100%">
        <tr>
          <th width="20%">真实姓名：</th>
          <td width="50%">{$member.MemberAttribute.name}</td>
          <td width="30%" rowspan="7" class="top">
            <img class="portrait" src="{$this->webroot}img/tx.jpg" />
            <div class="clear">&nbsp;</div>
            {if $showInviteBtn}
            <input class="invite" type="button" value="邀请兼职" />
            {/if}
          </td>           
        </tr>
        <tr>
          <th>性别：</th>
          <td>{if $member.MemberAttribute.sex == 1}男{else}女{/if}</td>
        </tr>
        <tr>
          <th>行业：</th>
          <td>{$this->Category->getCategoryName($member.MemberAttribute.category_id)}</td>
        </tr>  
        <tr>
          <th>联系方式：</th>
          <td>{$member.MemberAttribute.mobile}</td>
        </tr>
        <tr>
          <th>所在城市：</th>
          <td>福建省厦门市</td>
        </tr>
        <tr>
          <th>联系地址：</th>
          <td>
          {$this->City->cityName($member.MemberAttribute.provincial_id)} 
          {$this->City->cityName($member.MemberAttribute.city_id)}
          </td>
        </tr>  
        <tr>
          <th>业务范围：</th>
          <td>{$member.MemberAttribute.business_scope}</td>
        </tr> 
        <tr>
          <th>与公司合作：</th>
          <td>12次</td>
        </tr> 
        <tr>
          <th>成功合作：</th>
          <td>3次</td>
        </tr>       
      </table>
    </div>
    <div class="biaotit">合作的客源</div>
    <div id="result" >
    {assign var=options value=['update' => '#result', 'evalScripts' => true]}
    {$this->Paginator->options($options)}
    {$paginatorParams = $this->Paginator->params()}
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
      <thead>
        <tr class="con_2_tr con_2_xq_too">          
          <th width="137">客源标题</th>
          <th width="138">兼职标题</th>
          <th width="87">兼职配合方式</th>
          <th width="79">合作时间</th>  
          <th width="63">状态</th>        
          <th width="113">选择操作</th>
        </tr>
      </thead>
      {$status = Configure::read('Cooperation.receive_status')}
      {foreach $cooperations as $cooperation}
          <tr class="con_2_tr">        
            <td><a target="_blank" href="/cooperations/detail">{$cooperation.Information.title}</a></td>
            <td><a target="_blank" href="/cooperations/detail">{$cooperation.PartTime.title}</a></td>
            <td>
            <a target="_blank" href="/cooperations/detail">
            {if $cooperation.PartTime.method == 1}
            提供客户信息
            {elseif $cooperation.PartTime.method == 2}
            协助跟单
            {else}
            独立签单
            {/if}
            </a>
            </td>
            <td><a target="_blank" href="/cooperations/detail">{$cooperation.Cooperation.created}</a></td>
            <td><a target="_blank" href="/cooperations/detail">{$status[$cooperation.Cooperation.status]}</a></td>
            <td class="con_2_xq_tofu xiushan_anniu xiushan_anniu1">
            <a href="/cooperations/detail" target="_blank">详情</a>
            </td>
          </tr>
      {/foreach}        
      </table>
      <div class="fanyea">
            {if $paginatorParams['prevPage']}
                <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
            {/if}
            <div class="dd_ym">
              <label>每页显示：</label>
              <select name="pageSize">
                <option value="2" {if $pageSize == "10"} selected {/if}>10</option>
                <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
              </select>
            </div>
            <div class="dd_ym11">
                <font>共{$paginatorParams['count']}条</font>
                  <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
            </div>
            {if $paginatorParams['nextPage']}
                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array(1,2))}</div>
            {/if}
          </div>
        {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
        {$form = ['isForm' => true, 'inline' => true]}
        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#result')->serializeForm($form)]}
        {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
        {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
        {$this->Js->writeBuffer()}
      </div>
    <div class="clear">&nbsp;</div>
    {if $showInviteBtn}
     <a class="zclan zclan4 invite" href="javascript:void(0)">邀请参与</a>
    {/if}   
</div>

<input type="hidden" id="members_id" value="{$this->request->query['id']}" />