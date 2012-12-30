<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".navMiddle li a:eq(2)").addClass("active");       
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
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="hyxzyemian22">
      <thead>
        <tr>
          <th width="178">文档名称</th>
          <th width="344">内容概要</th>
          <th width="120">上传时间</th>
          <th width="65">下载次数</th>          
          <th width="65">下载文档</th>
        </tr>
      </thead>
      {foreach $documents as $document}
      <tr>
        <td>{$document.Service.title}</td>
        <td class="content">{$document.Service.introduction}</td>        
        <td>{$document.Service.created|date_format:"%Y-%m-%d"}</td>        
        <td>{$document.Service.download_cnt}次</td>
        <td class="btnInfoDl"><a href="files/file.doc">下载</a></td>
      </tr>
      {/foreach}
    </table>   
    </div>
  </div>
  <div class="left right">
    <div class="divnavLeft">
      <div class="navLeft navRight"></div>
    </div>
    <div class="divconLeft">
    </div>
  </div>
</div>