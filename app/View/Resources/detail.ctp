<script type="text/javascript">
{literal}
$(document).ready(function(){
	//评论验证码
    $('#getCommentCheckNum').prepend('<img id="commentCode" src="/members/image">');
    $('#getCommentCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#commentCode').attr('src', src);
    });
	$(".btnDownload,.linkLogin").click(function(){
		var logined = $('#logined').val();
		var downloaded = $('#downloaded').val();
		if (logined == 1) {
			if ($('#grade').val() == 2){
				//高级会员
				var point = $('#point').val();
				var src = "";
				$.ajax({
					url : '/resources/checkPoint',
					type : 'post',
					data : 'point=' + point,
					async : false,
					success:function(data) {
						var result = eval("("+data+")");
						var documents_id = $('#documents_id').val();
						if (result.result == 'OK') {
							src = "/resources/download?id=" + documents_id;
						} else {
							src = '';
							if (confirm(result.msg+'\n点击确定打开充值页面；若页面被浏览器拦截，请点击允许。')) window.open("/coins/charge");
						}
					}
				});
				if (src != "") {
					$('#downloadIframe').attr('src', src);
				}
			} else {
				bgKuang("#divDjbuz",".divDjbuz .closeDiv");
			}
		} else {
		//还没有登陆，显示登陆框
			if (!$('#loginCheckNum').next().is('img')) {
				$('#loginCheckNum').after('<img id="loginCode" src="/members/image">');
			    $('#getLoginCheckNum').click(function(){
			        var src = '/members/image/' + Math.random();
			        $('#loginCode').attr('src', src);
			    });
		    }
			bgKuang("#divDjbuz",".divDjbuz .closeDiv");
		}
	});
	//确保验证码显示
	$('#loginCheckNum').focus(function(){
		if(!$(this).next().is('img')) {
			$(this).after('<img id="loginCode" src="/members/image">');
		}
	})	
	//登陆按钮
	$('#btnCommentLogin').click(function(){
		var errorMsg = '<span style="color:red">请输入此项</span>'
		$('#loginCommentBox span').remove();
		if ($('#comment_nickname').val() == "") {
			$('#comment_nickname').after(errorMsg);
			return false;
		}
		if ($('#comment_password').val() == "") {
			$('#comment_password').after(errorMsg);
			return false;
		}
		if ($('#loginCheckNum').val() == "") {
			$('#loginCheckNum').parent().append(errorMsg);
			return false;
		}
		var nickname = $('#comment_nickname').val();
		var password = $('#comment_password').val();
		var checkNum = $('#loginCheckNum').val();
		var type = 0;
		
		var params = "nickname=" + nickname + "&password=" + password + "&checkNum=" + checkNum + "&type=" + type;
		$.ajax({
                type : 'post',
                url  : '/members/ajaxlogin',
                data : params,
                success : function(data) {
                    if (data == '') {
                        window.location.href = location.href;
                    }
                    
                    if (data != '') {
                        msg = '<span style="color:red">' + data + '</span>';
                        $('#loginCommentBox ul:first-child').before(msg);
                    }
                    
                }
             });
	});
	
	//评论按钮
	$(".btnComment").click(function(){
		var error = false;
		$('#sendComment span').remove();
		var documents_id = $('#documents_id').val();
		if ($('#comment').val() == "") {
			error = true;
			$('#comment').after('<span class="errorMsg">先说几句吧...</span>');
		} else $('#comment').next().remove();
		if ($('#commentCheckNum').val() == "") {
			error = true;
			$('#commentCheckNum').parent().append('<span class="errorMsg" style="top:450px;">请输入验证码</span>');
		} else {
			$.ajax({
		      url : '/members/getImageNumber',
		      type : 'post',
		      async : false,
		      success : function(data)
		      {
		          if (data != $('#commentCheckNum').val().toUpperCase()) {
		              error = true;
		              if ($("#commentCheckNum").parent().find('.errorMsg').length == 0) {
                          $("#commentCheckNum").parent().append('<span class="errorMsg" style="top:450px;">验证码不一致</span>');
                      } else {
                          $("#commentCheckNum").parent().find('.errorMsg').html('验证码不一致');
                      }
		          }
		      }
		  });
		}
		if (!error) {
			$.ajax({
				url : '/resources/addComment',
				type : 'post',
				data : 'comment=' + $('#comment').val() + '&documents_id=' + documents_id,
				success : function(data) {
					var result = eval("("+data+")");
					if (result.result != "OK") {
						alert(result.msg);
					} else {
						alert('发表评论成功！');
						var li = 
						'<li>' +
				            '<div class="photo fl"><img src="' + result.thumbnail + '" /></div>' +
				            '<div class="name"><b>' + result.name + '</b><span>刚刚</span></div>' +
				            '<div class="body">' +
				              '<p>' + $('#comment').val() + '</p>' +
				              '<div class="menu">' +
				              	  '<input class="comments_id" type="hidden" value="' + result.id + '">' +
					              '<a target="_self" href="javascript:void(0);" class="btnDing">支持</a>(0)' +
					              '<a target="_self" href="javascript:void(0);" class="btnCai">反对</a>(0)' +
				              '</div>' +
				            '</div>' +
				          '</li>';
				         $('.commentContent ul').prepend(li);
				         $('#comment').val('');
				         $("#commentCheckNum").val('');
				         var src = '/members/image/' + Math.random();
        				$('#commentCode').attr('src', src);
					}
				}
			});
		}
	});
	//针对评论，发表意见
	$('.btnDing').live('click', function(){
		var comments_id = $(this).parent().find('.comments_id').val();
		if (sendOption(comments_id, 1)) {
			var support = parseInt($(this).parent().find('.support').html()) + 1;
			var opposition = parseInt($(this).parent().find('.opposition').html());
			var html = '<span  class="manner">我已支持过</span><span>支持(' + support +')反对(' + opposition +')</span>';
			$(this).parent().html(html);
		}
	});
	$('.btnCai').live('click', function(){
		var comments_id = $(this).parent().find('.comments_id').val();
		if (sendOption(comments_id, 0)) {
			var support = parseInt($(this).parent().find('.support').html());
			var opposition = parseInt($(this).parent().find('.opposition').html()) + 1;
			var html = '<span class="manner">我已反对过</span><span>支持(' + support +')反对(' + opposition +')</span>';
			$(this).parent().html(html);
		}
	});
	function sendOption(comments_id, option)
	{
		var success = false;
		$.ajax({
			url : '/resources/support',
			type : 'post',
			async : false,
			data : 'comments_id=' + comments_id + '&option=' + option,
			success : function(data){
				var result = eval("("+data+")");
				if (result.result != "OK") {
					alert(result.msg);
				} else {
					success = true;
				}
			}
		});
		return success;
	}
	
	//收藏和删除收藏
	$('.addFavorite').live('click', function(){
		var documents_id = $('#documents_id').val();
		if (sendFavorite(documents_id, 'add')) {
			$(this).text('删除收藏').removeClass('addFavorite').addClass('delFavorite');
		}
	});
	$('.delFavorite').live('click', function(){
		var documents_id = $('#documents_id').val();
		if (sendFavorite(documents_id, 'del')) {
			$(this).text('收藏').removeClass('delFavorite').addClass('addFavorite');
		}
	});
	function sendFavorite(documents_id, action)
	{
		var success = false;
		$.ajax({
			url : '/resources/favorite',
			type : 'post',
			async : false,
			data : 'documents_id=' + documents_id + '&action=' + action,
			success : function(data){
				var result = eval("("+data+")");
				if (result.result == 'unlogin') {
					window.location.href = location.href;
				} else if (result.result != "OK") {
					alert(result.msg);
				} else {
					success = true;
				}
			}
		});
		return success;
	}
	
});
{/literal}
</script>
<div class="main">
	<div id="loginWarning">
        <div class="area">
            <div class="notice">您输入的密码和账户名不匹配，请重新输入。</div>
            <ul class="question">
            </ul>
        </div>
        <div class="arrow"></div>
    </div>
  <div class="conResource conResourceF">
    <div class="crumbsNav"><a href="plt-zytd.html">资源天地</a>&nbsp;&gt;&nbsp;<a href="plt-zytdI-list.html">客户管理</a></div>
    <h1>
    {$file_info= explode('.', $document.Document.file_name)}
    <span class="spanFileFormat {$this->Unit->getFileIcon($file_info[1])}"></span>
	    {$file_info[0]}
    </h1>
    <div class="sbResource">
      <h3><a href="javascript:void(0);" class="inform linkLogin">举报</a>文档信息</h3>
      <p class="docInfo">浏览：{$document.Document.clicked}次&nbsp;&nbsp;&nbsp;下载：{$document.Document.download_cnt}次</p>
      <p class="docInfo">贡献者：<a href="/resources/listview?mid={$document.Document.members_id}" target="_blank">{$document.Member.nickname}</a></p>
      <p class="docInfo">贡献时间：{$document.Document.created|date_format:"%Y-%m-%d"}</p>
      <p class="docInfo"><span class="fl">格式：</span><span class="spanFileFormat {$this->Unit->getFileIcon($file_info[1])}"></span>{$file_info[1]}</p>
      <p class="docInfo">关键词：
	      <a href="plt-zytd-search.html" target="_blank">{$document.Document.key_word}</a>
      </p>
      <h3>文档简介</h3>
      <p class="filedescribe">{$document.Document.introduction}</p>
      <div class="clearfix"></div>
    </div>
    <div class="downFile">
        {if !empty($memberInfo)}
        	{if $isFavourite}
        		<a href="javascript:void(0);" class="btnCollect delFavorite">删除收藏</a>
        	{else}
        		<a href="javascript:void(0);" class="btnCollect addFavorite">收藏</a>
        	{/if}
        {/if}
      <div class="download"><a href="javascript:void(0);" class="btnDownload">下载</a>
        <div class="describe">
          <p>大小：{printf("%.1f", $document.Document.size/1000)}KB</p>
          <p>所需积分：{$document.Document.point}分</p>
        </div>
      </div>
    </div>
    <div class="articleCommentN">  
       <h3>评论</h3>
       {if !empty($memberInfo) && $memberInfo.Member.id == $document.Document.members_id || $downloaded}
       	<div id="sendComment">
	        <div class="row">
	          <label>您的评论:</label>
	          <textarea id="comment" name="comment"></textarea>
	          <div class="clearfix"></div>
	        </div>
	        <div class="row">
	          <label>验证码:</label><input type="text" id="commentCheckNum"/>
	          <a href="javascript:void(0);" id="getCommentCheckNum" title="刷新验证码">看不清？</a> 
	        </div>
	        <div class="row">          
	          <a href="javascript:void(0);" title="递交" class="btnComment btnCommit">递交</a> 
	        </div>
        </div>
       {else}
       		{if empty($memberInfo)}
       			<div class="nolog"> 登录后你可以发表评论，请先登录。<a class="linkNolog linkLogin" href="javascript:void(0);">登录&gt;&gt;</a></div>
       		{else}
       			<div class="nolog"> 下载之后你可以发表评论，请先下载查看。</div>
       		{/if}
       	<div id="sendComment" style="display:none">
	        <div class="row">
	          <label>您的评论:</label>
	          <textarea onfocus="_Showvaldiv(0);" id="comment" name="comment"></textarea>
	          <div class="clearfix"></div>
	        </div>
	        <div class="row">
	          <label>验证码:</label><input type="text" id="commentCheckNum"/>
	          <a href="javascript:void(0);" id="getCommentCheckNum" title="刷新验证码">看不清？</a> 
	        </div>
	        <div class="row">          
	          <a href="javascript:void(0);" title="递交" class="btnCommit btnComment">递交</a> 
	        </div>
        </div>
       {/if}

<div id="comments">
{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#comments', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
      <div class="tilComment">共&nbsp;{$paginatorParams['count']}&nbsp;条评论</div>
      <div class="commentContent">
        <ul>
        {foreach $comments as $key => $comment}
          <li>
            <div class="photo fl"><img src="{$this->webroot}{if !empty($comment.Attribute.thumbnail)}{$comment.Attribute.thumbnail}{else}img/tx.jpg{/if}" /></div>
            <div class="name"><b>{$comment.Member.nickname}</b><span>{$comment.DocumentComment.created|date_format:"%Y-%m-%d"}</span></div>
            <div class="body">
              <p>{$comment.DocumentComment.comment}</p>
              {if !empty($memberInfo) && $comment.DocumentComment.members_id != $memberInfo.Member.id}
              	{if $comment.Option.option !== NULL}
              		<div class="menu">
              		  {if $comment.Option.option == true}
              		  <span class="manner">我已支持过</span>
              		  {else}
              		  <span class="manner">我已反对过</span>
              		  {/if}
		              支持({$comment.DocumentComment.support})反对({$comment.DocumentComment.opposition})
	               </div>
              	{else}
	              <div class="menu">
	              	  <input type="hidden" class="comments_id" value="{$comment.DocumentComment.id}" />
		              <a target="_self" href="javascript:void(0);" class="btnDing">支持</a>(<span class="support">{$comment.DocumentComment.support}</span>)
		              <a target="_self" href="javascript:void(0);" class="btnCai">反对</a>(<span class="opposition">{$comment.DocumentComment.opposition}</span>)
	              </div>
              	{/if}
              {else if $comment.DocumentComment.members_id == $memberInfo.Member.id}
              	  <div class="menu">
		              支持(<span class="support">{$comment.DocumentComment.support}</span>)
		              反对(<span class="opposition">{$comment.DocumentComment.opposition}</span>)
	              </div>
             {else}
              	<div class="menu"></div>
             {/if}
            </div>
          </li>
          {/foreach}
        </ul>
      </div>
      {if $paginatorParams['count'] > 0}
      <div class="fanyea">
      <form id="searchOpt">
        {if $paginatorParams['prevPage']}
            <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
        {/if}
        <div class="dd_ym">
            <label>每页显示：</label>
            <select name="pageSize" id="pageSize">
                <option value="10" {if $pageSize == "10"} selected {/if}>10</option>
                <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
            </select>
        </div>
        <div class="dd_ym11">
            <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
            <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
            <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
        </div>
        {if $paginatorParams['nextPage']}
            <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
        {/if}
        </form>
    </div>
    {/if}
	</div>
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'?id='|cat:$document.Document.id]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'?id='|cat:$document.Document.id]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#comments', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
  </div>
  </div>
  {if !empty($memberInfo)}
  {$this->element('resource/left_logined')}
  {else}
  {$this->element('resource/left')}
  {/if}
</div>

<input type="hidden" id="downloaded" value="{if $downloaded}1{else}0{/if}" />
<input type="hidden" id="point" value="{$document.Document.point}" />
<input type="hidden" id="documents_id" value="{$document.Document.id}" />

{if !empty($memberInfo)}
	<input type="hidden" id="grade" value="{$memberInfo['Member']['grade']}" />
    <input type="hidden" id="logined" value="1" />
    {if $memberInfo['Member']['grade'] != 2}
    	<div class="divDjbuz" id="divDjbuz" style="width:274px;"> <a class="closeDiv" href="#">&nbsp;</a>
	  		<div class="login">
	    		<div class="frmTitle">您需要升级为高级会员才能下载文档！</div>
	    		<ul>
        			<li><a href="/members/upgrade">免费升级</a></li>
        			<li><a href="javascript:void(0)" class="closeUpgradeWin">关闭窗口</a></li>
    			</ul>
	  		</div>
		</div>
    {/if}
{else}
    <input type="hidden" id="logined" value="0" />
<div class="divDjbuz" id="divDjbuz" style="width:274px;"> <a class="closeDiv" href="#">&nbsp;</a>
  <div class="login">
    <div class="frmTitle">您需要登录后才能继续操作</div>
    <form action="#" method="post" id="loginCommentBox">
      <ul>
        <li>
          <label>个人用户名：</label>
          <input type="text" name="nickname" value="" id="comment_nickname" class="username" />
        </li>
        <li>
          <label>密码：</label>
          <input type="password" name="password" value="" id="comment_password" class="password"/>
        </li>
        <li>
          <label>验证码：</label>
          <input type="text" name="checknum" id="loginCheckNum" value="" class="yanzhengma" >
          <a id="getLoginCheckNum" href="javascript:void(0)">看不清？</a></li>
        <li class="zinp">
	        <a id="btnCommentLogin" class="inp" href="javascript:void(0)">登录</a>
	        <a id="btnCommentRegister" class="inp" href="/members/register" target="_blank">免费注册</a>
	        <a class="forget" href="wangjimima.html">忘记密码</a>
        </li>
      </ul>
    </form>
  </div>
</div>
{/if}

<iframe style="display:none" id="downloadIframe">

</iframe>