<div class="zy_r">
    <ul>
      <li class="friend"><a href="/accounts/friend">好友</a></li>
      <li class="znx"><a href="/accounts/sms" class="aZNXSpan">站内信</a></li>
    </ul>
    <div class="adRcd"><a href="/accounts/invite"><img src="{$this->webroot}img/ads/20110615175842023378.jpg"/></a></div>
    <div class="change2">
        <div class="nTab3"> 
            <div class="TabTitle3">
                <ul id="myTab2">
                    {foreach $notices as $key => $notice}
                        {if $key <= 2 && $key == 0}
                            <li class="active3">{$notice.Notice.title}</li>
                        {else if $key <= 2}
                            <li>{$notice.Notice.title}</li>
                        {/if}
                    {/foreach}
                    <li class="long">兼职黑名单</li>
                </ul>
            </div>
            <div class="TabContent3">
                {foreach $notices as $key => $notice}
                    {if $key <= 2}
                        {if $key == 0}
                        <div class="myTab1_Content2" style="display:block">
                            <div class="con_3">
                                <ul>
                                    {foreach $notice.subNotice as $sub}
                                        <li><a href="/notices/detail?id={$sub.Notice.id}">{$sub.Notice.title}</a><span>[{$sub.Notice.created|date_format:"%Y-%m-%d"}]</span></li>
                                    {/foreach}
                                </ul>
                                {if count($notice.subNotice) == 5}
                                    <h5><a href="/notices/listview?pid={$notice.Notice.id}">查看更多&gt;&gt;</a></h5>
                                {/if}
                            </div>
                        </div>
                        {else}
                        <div class="myTab1_Content2">
                            <div class="con_3">
                                <ul>
                                    {foreach $notice.subNotice as $sub}
                                        <li><a href="/notices/detail?id={$sub.Notice.id}">{$sub.Notice.title}</a><span>[{$sub.Notice.created|date_format:"%Y-%m-%d"}]</span></li>
                                    {/foreach}
                                </ul>
                                {if count($notice.subNotice) == 5}
                                    <h5><a href="/notices/listview?pid={$notice.Notice.id}">查看更多&gt;&gt;</a></h5>
                                {/if}
                            </div>
                        </div>
                        {/if}
                    {/if}
                {/foreach}
                <div class="myTab1_Content2">
                    <div class="con_3">
                        <ul>
                            <li><a href="#">新新festet闻新闻新闻新新闻新闻新闻新新闻新新闻新新闻新闻新闻新新闻新闻新闻新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                            <li><a href="#">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                            <li><a href="#">新闻gsdgs新闻新闻新闻</a><span>[2011-9-19]</span></li>
                            <li><a href="#">新awff闻新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                            <li><a href="#">新zvdsfa闻新闻闻闻新闻新闻</a><span>[2011-9-19]</span></li>
                        </ul>
                    <h5><a href="#">更多&gt;&gt;</a></h5>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="zy_rzj">
        <strong>推荐兼职</strong>
        <span><a href="/parttimes/listview?type=need">更多&gt;&gt;</a></span>
    </div>
    <div class="zy_rzj_tt">
        <ul>
        {foreach $recommendParttimes as $parttime}
            <li>
            <a href="/parttimes/detail?id={$parttime.PartTime.id}">
            {$areas = explode(',', $parttime.PartTime.area)}
            {foreach $areas as $area}
            {$this->City->cityName($area)}
            {/foreach}
            /{$this->Category->getCategoryName($parttime.PartTime.category)}
            /{if $parttime.PartTime.method == 1}提供客户信息{elseif $parttime.PartTime.method == 2}协助跟单{else}独立签单{/if}
            /{if $parttime.PartTime.pay == 1}按合同金额：{$parttime.PartTime.pay_rate}%{else}协商确定{/if}
            </a>
            </li>
        {/foreach}
        </ul>
    </div>
</div>