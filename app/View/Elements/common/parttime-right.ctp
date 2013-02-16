<script type="text/javascript">
{literal}
$(document).ready(function(){
var zy_zBottomRcdT;
  $(".zy_rzj_tt li a").hover(function(){
	  $(this).parent().css("text-overflow","clip");
	  var selector=".zy_rzj_tt li a:eq("+$(".zy_rzj_tt li a").index(this)+")";	 
	  zy_zBottomRcdT=window.setInterval(function(){singleLineTextS(selector);},200);
  },function(){
	   $(this).parent().css("text-overflow","ellipsis");
	   $(this).css("margin-left",0);
	   window.clearInterval(zy_zBottomRcdT);	   
  });
});
{/literal}
</script>

<div class="fuwu">
    {if $recommendType == 'parttime'}
        <h1><a href="/search/parttime"><span class="fr">更多...</span>最新兼职</a></h1>
        {foreach $recommend_parttimes as $parttime}
            <dl class="imgParttime">
                <dt>
                <a href="/search/pdetail?id={$parttime.PartTime.id}" target="_blank" title="{$parttime.PartTime.title}">
                {if !empty($fulltime.MemberAttribute.thumbnail)}
                    {$thumbnail = Configure::read('Data.path')|cat:$fulltime.MemberAttribute.thumbnail}
                    {if file_exists($thumbnail)}
                        <img src="{$this->webroot}{$fulltime.MemberAttribute.thumbnail}">
                    {else}
                        <img src="{$this->webroot}img/tx.jpg">
                    {/if}
                {else}
                    <img src="{$this->webroot}img/tx.jpg">
                {/if}
                </dt>
                <dd class="title">
                <a href="/search/pdetail?id={$parttime.PartTime.id}" target="_blank" title="{$parttime.PartTime.title}">{$parttime.PartTime.title}</a>
                </dd>
                <dd class="content">
                <a href="/search/pdetail?id={$parttime.PartTime.id}" target="_blank">
                {$parttime.PartTime.sub_title}
                {$areas = explode(',', $parttime.PartTime.area)} 
                {foreach $areas as $area}
                {$this->City->cityName($area)}
                {/foreach}
                {$this->Category->getCategoryName($parttime.PartTime.category)}
                </a>
                </dd>
            </dl>
        {/foreach}
    {elseif $recommendType == 'fulltime'}
        <h1><a href="/search/offer"><span class="fr">更多...</span>最新职位</a></h1>
        {foreach $recommend_fulltimes as $fulltime}
            <dl class="imgParttime">
                <dt>
                <a href="/search/odetail?id={$fulltime.Fulltime.id}" target="_blank" title="{$fulltime.Fulltime.title}">
                    {if !empty($fulltime.MemberAttribute.thumbnail)}
                        {$thumbnail = Configure::read('Data.path')|cat:$fulltime.MemberAttribute.thumbnail}
                        {if file_exists($thumbnail)}
                            <img src="{$this->webroot}{$fulltime.MemberAttribute.thumbnail}">
                        {else}
                            <img src="{$this->webroot}img/tx.jpg">
                        {/if}
                    {else}
                        <img src="{$this->webroot}img/tx.jpg">
                    {/if}
                </a>
                </dt>
                <dd class="title">
                <a href="/search/odetail?id={$fulltime.Fulltime.id}" target="_blank" title="">{$fulltime.Fulltime.title}</a>
                </dd>
                <dd class="content">
                <a href="/search/odetail?id={$fulltime.Fulltime.id}" target="_blank">
                {$fulltime.Fulltime.post} {$fulltime.Fulltime.type} {$fulltime.Fulltime.salary} {$fulltime.Fulltime.require}
                </a>
                </dd>
            </dl>
        {/foreach}
    {elseif $recommendType == 'has'}
        <h1 class="h1Zy_rzj_tt"><a href="/search?type=has"><span class="fr">更多...</span>最新发布客源</a></h1>   
        <ul class="zy_rzj_tt">
        {foreach $newInformations as $information}
            <li>
            <a href="/search/infodetail?id={$information.Information.id}" target="_blank" title="{$information.Information.created}">
           {$information.Information.title}/
           {$provincial = $this->City->cityName($information.Information.provincial)}
           {$city = $this->City->cityName($information.Information.city)}
           {if $provincial != $city}
           {$provincial} {$city}
           {else}
           {$provincial}
           {/if}
           /{$this->Category->getCategoryName($information.Information.category)} {$this->Category->getCategoryName($information.Information.sub_category)}
            </a>
            </li>
        {/foreach}
        </ul>
    {elseif $recommendType == 'need'}
        <h1 class="h1Zy_rzj_tt"><a href="/search?type=need"><span class="fr">更多...</span>最新发布悬赏</a></h1>   
        <ul class="zy_rzj_tt">
        {foreach $newInformations as $information}
            <li>
            <a href="/search/infodetail?id={$information.Information.id}" target="_blank" title="{$information.Information.created}">
            {$information.Information.title}/
           {$provincial = $this->City->cityName($information.Information.provincial)}
           {$city = $this->City->cityName($information.Information.city)}
           {if $provincial != $city}
           {$provincial} {$city}
           {else}
           {$provincial}
           {/if}
           /{$this->Category->getCategoryName($information.Information.category)} {$this->Category->getCategoryName($information.Information.sub_category)}
            
            </a>
            </li>
        {/foreach}
        </ul>
    {/if}
    <!--
      <div class="clear">&nbsp;</div>
      <h1 class="h1Zy_rzj_tt"><a href="plt-jzxx.html"><span class="fr">更多...</span>最新兼职发布</a></h1>   
      <ul class="zy_rzj_tt">
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
          <li><a href="jzxxxq2.html" target="_blank" title="2012-11-16 09:28">厦门/电视广告/提供信息/10%厦门/电视广告/提供信息/10%</a></li>
        </ul>
    -->
</div>