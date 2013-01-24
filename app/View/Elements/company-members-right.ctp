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
                        {if $key == 0}
                            <li class="active3 long">{$notice.Notice.title}</li>
                        {else if $key <= 1}
                            <li class="long">{$notice.Notice.title}</li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
            <div class="TabContent3">
                {foreach $notices as $key => $notice}
                    {if $key <= 1}
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
            </div>
        </div>
    </div>
    <div class="zy_rzj"><strong>推荐兼职</strong> <span><a href="#">更多&gt;&gt;</a></span> </div>
    <div class="zy_rzj_tt">
        <ul>
            <li><a href="#">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
            <li><a href="#">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
            <li><a href="#">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
            <li><a href="#">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
            <li><a href="#">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
        </ul>
    </div>
</div>