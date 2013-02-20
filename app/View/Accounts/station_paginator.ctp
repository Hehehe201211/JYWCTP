{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#msgList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#msgOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params('StationMessage')}
{if $paginatorParams['count'] > 0}
<ul>
    {foreach $messages as $message}
        {if $message.StationMessage.type == Configure::read('Sms.normal')}
        <li>
            <p>
                <input type="checkbox" class="inpChk inpCheckbox checkboxVal" name="" value="{$message.StationMessage.id}">
                <a class="trader" href="/accounts/fdetail?fid={$message.Member.id}">{$message.Member.nickname}</a>
                <a target="_blank" href="#" class="title">发来信息。</a>
                <span class="time">{$message.StationMessage.title}</span>
                <span class="time">[{$message.StationMessage.created|date_format:"%Y-%m-%d %H:%M:%S"}]</span>
                <input class="msg_id" type="hidden" value="{$message.StationMessage.id}" />
                <a class="close delete" title="删除" href="javascript:void(0)">&nbsp;</a>
            </p>
            <div class="znxMesCon">
                {$message.StationMessage.content}
                <input type="button" onclick="window.open('hylx.html','_blank');" value="回复" name="" class="inpButton">
            </div>
        </li>
        {elseif $message.StationMessage.type == Configure::read('Sms.friendRequest')}
            <li>
                <p>
                    <input type="checkbox" name="" class="inpChk checkboxVal" value="{$message.StationMessage.id}"/>
                    <a href="hyzl.html" class="trader">{$message.Member.nickname}</a>
                    <a class="title" href="#" target="_blank">请求添加你为好友。</a>
                    <span class="time">[{$message.StationMessage.created|date_format:"%Y-%m-%d %H:%M:%S"}]</span>
                    <input class="msg_id" type="hidden" value="{$message.StationMessage.id}" />
                    <a href="javascript:void(0)" title="删除" class="close delete">&nbsp;</a>
                </p>
                <div class="znxMesCon">注册时间：[{$message.Member.created|date_format:"%Y-%m-%d %H:%M:%S"}]
                    <br/>所在城市：
                    {$provincial = $this->City->cityName($message.Attribute.provincial_id)}
                    {$city = $this->City->cityName($message.Attribute.city_id)}
                    {if $provincial == $city}
                        {$provincial}
                    {else}
                        {$provincial} {$city}
                    {/if}
                    <br/>行业：
                    {$this->Category->getCategoryName($message.Attribute.category_id)}
                    <br/>公司名称：{$message.Attribute.company}
                    <input class="inpButton" type="button" name="" value="同意" />
                </div>
            </li>
        {/if}
    {/foreach}
</ul>
<div class="pagesMag">
    <div class="fanyea fanyeaFr">
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
    <input type="checkbox" class="inpChk" name="" id="znxConFriAll"/>
    <label for="znxConFriAll">全选</label>
    <input type="button" class="inpButton deleMess deleteSelectSmg" name="" value="删除"/>
    <form id="msgOpt" >
        <input type="hidden" name="msg_type" value="station" />        
        {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
        {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
        {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#msgList', 'method' => 'post', 'data' => $this->Js->get('#msgOpt')->serializeForm($form)]}
        {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
        {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
        {$this->Js->writeBuffer()}
    </form>
</div>
{else}
没有好友信息
{/if}