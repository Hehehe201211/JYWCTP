<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.prev').live('click', function(){
    	var param = $(this).attr('href');
    	var page = param.substr(param.indexOf('?page=') + 6);
    	$('#favouritePage').load('/resources/getFavourites', {'page':page}, function(){});
    	return false;
    });
    $('.next').live('click', function(){
    	var param = $(this).attr('href');
    	var page = param.substr(param.indexOf('?page=') + 6);
    	$('#favouritePage').load('/resources/getFavourites', {'page':page}, function(){});
    	return false;
    });
});
function searchRe(event){
  if (event.keyCode==13) {
	  var params = "";
	  if ($('#typeSel').val() != "") {
		  params = '?type=' + $('#typeSel').val();
	  }
	  if ($('#key_word').val() != "") {
		  if (params == "") {
			  params = '?key_word=' + $('#key_word').val();
		  } else {
			  params = parmas + '&key_word=' + $('#key_word').val();
		  }
	  }
	  window.location.href = '/resources/search' + params;
  }
}
{/literal}
</script>
<div class="sbResource">
	{if $memberInfo.Member.type != Configure::read('UserType.company')}
    <a href="/resources/upload" class="fileUpload" target="_blank">上传文档</a>
    {/if}
    <div class="userInfo">
      <h3>{$memberInfo.Member.nickname}</h3>
      <div class="userData">下载文档：
	      <a href="javascript:void(0)" target="_blank">{if isset($download_cnt)}{$download_cnt}{else}0{/if}</a>次&nbsp;&nbsp;上传文档：
	      <a href="javascript:void(0)" target="_blank">{if isset($upload_cnt)}{$upload_cnt}{else}0{/if}</a>篇
      </div>      
      <div class="recUpload">最近上传</div>
      <ul>
      {foreach $newUploads as $new}
      	<li><a href="/resources/detail?id={$new.Document.id}" target="_blank">{$new.Document.title}</a></li>
      {/foreach}
      </ul>
    </div>
    <div class="clearfix"></div>
    <div class="shortcut">
      <h3>快速通道</h3>
      <div>
	      <select id="typeSel" name="type">
	      	  <option value="">选择分类</option>
		      <option value="1">入门成长</option>
		      <option value="2">培训课件</option>
		      <option value="3">客户管理</option>
		      <option value="4">方案模板</option>
		      <option value="5">总结计划</option>
		      <option value="6">案例分析</option>
	      </select>	      
          <input type="text" id="key_word" class="inpTextBox" name="key_word" value="敲击回车键进行搜索" placeholder="敲击回车键进行搜索" onclick="this.select()" onkeydown="searchRe(event)"/>	      
      </div>
      <ul>
        <li><a href="/resources/search?type=1" target="_blank">入门成长</a></li>
        <li><a href="/resources/search?type=2" target="_blank">培训课件</a></li>
        <li><a href="/resources/search?type=3" target="_blank">客户管理</a></li>
        <li><a href="/resources/search?type=4" target="_blank">方案模板</a></li>
        <li><a href="/resources/search?type=5" target="_blank">总结计划</a></li>
        <li><a href="/resources/search?type=6" target="_blank">案例分析</a></li>
      </ul>
      <div class="clearfix"></div>
    </div>  
	<div class="hot" id="favouritePage">
      <h3 style="width:216px;">
      <div class="fr btnPage">
      {if $hasPrev}
      	<a href="/{$this->request->params['controller']}/{$this->request->params['action']}?page={$page-1}" class="prev"></a>
      {/if}
      {if $hasNext}
      	<a href="/{$this->request->params['controller']}/{$this->request->params['action']}?page={$page + 1}" class="next"></a>
      {/if}
      </div>我的收藏(<span id="favourite_cnt">{$favouriteCnt}</span>)
      </h3>
      <ul>
      {foreach $favourites as $document}
      	<li><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></li>
      {/foreach}
      </ul>
      <div class="clearfix"></div>
    </div>  
    <div class="hot">
      <h3>热门文档</h3>
      <ul>
      {foreach $hots as $document}
      	<li><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></li>
      {/foreach}
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="adResource"><img src="{$this->webroot}img/ads/201211201512.png" width="216" height="65" /></div>    
  </div>
<div class="clear">&nbsp;</div>