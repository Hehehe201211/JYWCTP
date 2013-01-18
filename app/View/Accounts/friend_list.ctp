{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
{if $paginatorParams['count'] > 0}
<ul class="contacts-list clear" id="user_list_ul">
{foreach $friendships as $friend}
    <li class="contacts-item">
        <div class="img">
            <a href="/accounts/fdetail?fid={$friend.Friendship.friend_members_id}" title="好友资料">
                {if !empty($friend.Attribute.thumbnail)}
                    {$thumbnail = Configure::read('Data.path')|cat:$friend.Attribute.thumbnail}
                    {if file_exists($thumbnail)}
                        <img src="{$this->webroot}{$friend.Attribute.thumbnail}">
                    {else}
                        <img alt="好友" src="{$this->webroot}img/tx.jpg">
                    {/if}
                {else}
                    <img alt="好友" src="{$this->webroot}img/tx.jpg">
                {/if}
            </a>
        </div>
        <div class="name">
            <a href="hylx.html" title="好友资料" class="friendName">{$friend.Attribute.name}（{$friend.Member.nickname}）</a>
            <br />{$friend.Attribute.company}<br />业务员<br />进行过&nbsp;
            <a href="hyzl.html" titlt="交易记录">8</a>&nbsp;笔交易
        </div>
        <div class="btn btns">
            <a href="javascript:void(0)" class="btnCon">联系</a>
            <a href="javascript:void(0);" class="deleteFriend">删除</a>
            <a href="javascript:void(0);" class="inp" >更改分组</a>
        </div>
        <div class="btn groupNC">
            <select class="friSortSet friSortGroup">
                <option value="0" id="none">未分组</option>
              {foreach $groups as $group}
                <option value="{$group.FriendGroup.id}">{$group.FriendGroup.name}</option>
              {/foreach}
            </select>
            <input type="hidden" class="friend_members_id" value="{$friend.Friendship.friend_members_id}" />
            <a href="javascript:;" class="btnSave changeGroup">保存</a>
            <a href="javascript:;" class="btnCancle">取消</a>
        </div>
    </li>
{/foreach}
</ul>
<div class="fanyea">
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
        <div class="dd_span1"><a href="javascript:void(0)" id="jumpButton">跳转</a></div>
    </div>
    {if $paginatorParams['nextPage']}
        <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
    {/if}
</div>
{$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$form = ['isForm' => true, 'inline' => true]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
{else}
没有符合条件的信息。
{/if}