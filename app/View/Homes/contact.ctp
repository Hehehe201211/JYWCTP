<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".navMiddle li a:eq(5)").addClass("active");	
	var urlc=$("#urlCompany").attr("href").toUpperCase();	;
	if (urlc.indexOf("HTTP://"))  $("#urlCompany").attr("href","http://"+urlc)
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
    <div class="content">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="contactTable">
        <tr>
          <th width="20%" scope="row">公司名称：</th>
          <td>{$title_for_layout}</td>
        </tr>
        
        <tr>
          <th scope="row">联系人：</th>
          <td>{$homepage.Homepage.contact}</td>
        </tr>
        <tr>
          <th scope="row">联系人职位：</th>
          <td>{$homepage.Homepage.post}</td>
        </tr>
        {$contact_methods = json_decode($homepage.Homepage.contact_method, true)}
        {foreach $contact_methods as $method}
        <tr>
          <th scope="row">{$method.method}：</th>
          <td>{$method.number}</td>
        </tr>
        {/foreach}
        <tr>
          <th scope="row">传真：</th>
          <td>{$homepage.Homepage.fax}</td>
        </tr>
        <tr>
          <th scope="row">E-mail：</th>
          <td>{$homepage.Homepage.email}</td>
        </tr>
        <tr>
          <th scope="row">公司地址：</th>
          <td>{$homepage.Homepage.address}</td>
        </tr>   
        {if !empty($homepage.Homepage.url)}
        <tr>
          <th scope="row">公司网站：</th>
          <td><a href="{$homepage.Homepage.url}" target="_blank" id="urlCompany">{$homepage.Homepage.url}</a></td>
        </tr>
        {/if}
      </table>
      </div>
	  </div>
      <div class="divMap">
        <div id="mapLayout"></div>
      </div>
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