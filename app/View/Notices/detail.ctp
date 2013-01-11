<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.inpButton').click(function(){
        $('#noticeForm').submit();
    });
});
{/literal}
</script>
<div class="main">
  <div class="ntcLeft">
    <div class="suckerdiv">
      <h3>通知中心</h3>
      {foreach $noticeParents as $parent}
      <div class="category">
        <a href="javascript:void(0);" class="catHx"></a>
        <p><a href="/notices/listview?pid={$parent.Notice.id}">{$parent.Notice.title}</a></p>
      </div>
      {/foreach}
    </div>
    <div class="otherLinks">
      <ul>
        <li><a href="/static?tpl=xinshou">新手入门</a></li>
        <li><a href="/static?tpl=jiaoyijizhi">交易机制</a></li>
        <li><a href="/static?tpl=zhifufangshi">支付方式</a></li>
        <li><a href="/static?tpl=kehufuwu">客户服务</a></li>
        <li><a href="/static?tpl=bangzhu">帮助信息</a></li>
      </ul>
      <div class="clearfix"></div>
    </div>
  </div>
  <div class="ntcRight">    
    <div class="searchBox">
      <p class="tip">请简单完整的输入您的问题，如“如何找回密码”</p>
      <form method="post" action="/notices/listview" id="noticeForm">
      <input type="text" placeholder="请输入您的问题" class="inpTextBox" id="keywrod" name="keyword">
      <input type="button" class="inpButton" value="搜 索">
    </form>         
    </div>
    <div class="corContent">
      <div class="crumbs"> {$notice.Notice.title}
      </div>
      <div class="serviceCon">
        {if !empty($notice)}
            <!--<h1></h1>-->
            {$notice.Notice.content}
        {else}
        <h1>此系统信息不存在！</h1>
        {/if}
      </div>
      <div class="artListLink">
      {if !empty($next)}
      <a class="fr " href="/notices/detail?id={$next.id}">下一篇：{$next.title}</a>
      {/if}
      {if !empty($prev)}
      <a href="/notices/detail?id={$prev.id}">上一篇：{$prev.title}</a>
      {/if}
      </div>
    </div>
  </div>
  <div class="clear">&nbsp;</div>
  
</div>