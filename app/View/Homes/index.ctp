<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".navMiddle li a:eq(0)").addClass("active");       
});
{/literal}
</script>
<div class="main">
    <div class="left">
        <div class="divnavLeft">
            <div class="navLeft"></div>
        </div>
        <div class="divconLeft"></div>
    </div>
    <div class="middle">
        <div class="navMiddle">
            <ul>
                <li><a class="aleft" href="/homes/index/{$domain}">公司简介</a></li>
                <li><a href="/homes/service/{$domain}">产品或服务</a></li>
                <li><a href="/homes/download/{$domain}">资料下载</a></li>
                <li><a href="/homes/fulltime/{$domain}">招聘岗位</a></li>
                <li><a href="/homes/parttime/{$domain}">兼职需求及政策</a></li>
                <li><a class="aright" href="/homes/contact/{$domain}">联系方式</a></li>
            </ul>
        </div>
        <div class="divconMiddle">
            <div class="conLeft">
                <div class="content">{if !empty($homepage.Homepage.thumbnail)}<img class="conRImg" src="{$this->webroot}{$homepage.Homepage.thumbnail}" />{/if}<p>{$homepage.Homepage.introduction}</p></div>
            </div>            
        </div>
    </div>
    <div class="left right">
        <div class="divnavLeft">
            <div class="navLeft navRight"></div>
        </div>
        <div class="divconLeft"></div>
    </div>    
</div>