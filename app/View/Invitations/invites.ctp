<div id="invite" >
{assign var=options value=['update' => '#invite', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
      <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="200" class="tr_td1">公司名称</th>
          <th width="138" class="tr_td3">行业</th>
          <th width="79" class="tr_td5">所在城市</th>
          <th width="117" class="tr_td6">选择操作</th>
        </tr>
      </thead>      
      <tbody>
      {foreach $invites as $invite}
      <tr class="con_2_tr even">
        <td class="tr_td2">
            <a target="_blank" href="/invitations/detail?id={$invite.Invitation.id}" style="font-weight: bold;">
                {$invite.MemberAttribute.full_name}
            </a>
        </td>
        <td class="tr_td1">
            <a target="_blank" href="/invitations/detail?id={$invite.Invitation.id}" style="font-weight: bold;">
            {$this->Category->getCategoryName($invite.MemberAttribute.category_id)}
            </a>
        </td>        
        <td class="tr_td5">
            <a target="_blank" href="/invitations/detail?id={$invite.Invitation.id}" style="font-weight: bold;">
            {$provincial = $this->City->cityName($invite.MemberAttribute.provincial_id)} 
            {$city = $this->City->cityName($invite.MemberAttribute.city_id)}
            {if $provincial != $city}
                {$provincial} {$city}
            {else}
                {$city}
            {/if}
            </a>
        </td>
        <td class="tr_td4">
            <a target="_blank" href="/invitations/detail?id={$invite.Invitation.id}" style="font-weight: bold;">
            {$invite.MemberAttribute.company_type}
            </a>
        </td>
        <td class="con_2_xq_tofu xiushan_anniu">
            <a target="_blank" href="/invitations/detail?id={$invite.Invitation.id}" style="font-weight: normal;">详情</a>
        </td>
      </tr>
      {/foreach}
      <tr>
        <td colspan="6" class="fanyea_x"><div class="fanyea">
            {if $paginatorParams['prevPage']}
                <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
            {/if}
            <div class="dd_ym">
              <label>每页显示：</label>
              <select name="pageSize" id="pageSize">
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
                <div style="float:left; margin-left:6px;" class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
          {/if}
          </div>
          </td>
      </tr> 
    </tbody>
    </table>
</div>
{$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#invite', 'method' => 'post', 'data' => $this->Js->get('#invite')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}