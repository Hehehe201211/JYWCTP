<script type="text/javascript">
{literal}
$(document).ready(function(){
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
						alert(result.msg);
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
		bgKuang("#divDjbuz",".divDjbuz .closeDiv");
	}
	});
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
      <h3>文档信息<a href="javascript:void(0);" class="inform linkLogin">举报</a></h3>
      <p class="docInfo">浏览：{$document.Document.clicked}次&nbsp;&nbsp;&nbsp;下载：{$document.Document.download_cnt}次</p>
      <p class="docInfo">贡献者：<a href="plt-zytd-hislist.html" target="_blank">{$document.Member.nickname}</a></p>
      <p class="docInfo">贡献时间：{$document.Document.created|date_format:"%Y-%m-%d"}</p>
      <p class="docInfo"><span class="fl">格式：</span><span class="spanFileFormat {$this->Unit->getFileIcon($file_info[1])}"></span>{$file_info[1]}</p>
      <p class="docInfo">关键词：
	      <a href="plt-zytd-search.html" target="_blank">{$document.Document.key_word}</a>
      </p>
      <h3>文档简介</h3>
      <p class="filedescribe">{$document.Document.introduction}</p>
      <div class="clearfix"></div>
    </div>
    <div class="downFile"> <a href="javascript:void(0);" class="btnCollect">收藏</a>
      <div class="download"><a href="javascript:void(0);" class="btnDownload">下载</a>
        <div class="describe">
          <p>大小：{printf("%.1f", $document.Document.size/1000)}KB</p>
          <p>所需积分：{$document.Document.point}分</p>
        </div>
      </div>
    </div>
    <div class="articleCommentN">  
       <h3>评论</h3>
       {if $downloaded}
        <div class="row">
          <label>您的评论:</label>
          <textarea onfocus="_Showvaldiv(0);" id="comment0" name="comment"></textarea>
          <div class="clearfix"></div>
        </div>
        <div class="row">
          <label>验证码:</label><input type="text" />
          <a href="javascript:;" title="刷新验证码"><img src="{$this->webroot}img/num_03.jpg" />看不清？</a> 
        </div>
        <div class="row">          
          <a href="javascript:;" title="递交" class="btnCommit" onclick="alert('评论已递交。');">递交</a> 
        </div>
        {else if empty($memberInfo)}
        <div class="nolog"> 登录后你可以发表评论，请先登录。<a class="linkNolog linkLogin" href="javascript:void(0);">登录&gt;&gt;</a></div>
        {else}
        <div class="nolog"> 下载之后你可以发表评论，请先下载查看。</div>
        {/if}
      <div class="tilComment">共&nbsp;32&nbsp;条评论，显示&nbsp;32&nbsp;条</div>
      <div class="commentContent">
        <ul>
          <li>
            <div class="photo fl"><img src="{$this->webroot}img/avatar/avatar.php.gif" /></div>
            <div class="name"><span class="fr">2楼</span><b>XXX5202012</b><span>4天前</span></div>
            <div class="body">
              <p>不用看了，美国都卖完了，瞬间被秒了</p>
              <div class="menu">
	              <a target="_self" href="javascript:;" class="btnDing">支持</a>(0)
	              <a target="_self" href="javascript:;" class="btnCai">反对</a>(0)<span>|</span>
	              <a title="举报" href="javascript:void(0);" >举报</a>
              </div>
              <div class="divReply">
                <input type="text" class="inpTextBox" />
                <button class="btnReply">回复</button>
                <button class="btnCancle">取消</button>
              </div>
            </div>
          </li>
        </ul>
      </div>
      <div class="artFangye"> <a href="#" class="dd_span">上一页</a> <a href="#" class="dd_span">1</a> <a href="#" class="dd_span">2</a> <a href="#" class="dd_span">3</a> <a href="#" class="dd_span">4</a> <a href="#" class="dd_span">5</a> <a href="#" class="dd_span">6</a> <a href="#" class="dd_span">7</a> <a href="#" class="dd_span">8</a> <a href="#" class="dd_span">9</a> <a href="#" class="dd_span">...16</a>
            <div class="dd_ym">
              <select>
                <option>100</option>
                <option>50</option>
                <option>20</option>
                <option>10</option>
              </select>
            </div>
            <div class="dd_ym11"><span>共64388条</span><span>第9999/9999页</span>
              <input class="inpTextBox" type="text"/>
            </div>
            <a href="#" class="dd_span">跳转</a> <a href="#" class="dd_span">下一页</a> </div>
    </div>
  </div>
  {$this->element('resource/left')}
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
    <form action="#" method="post" id="loginBox">
      <ul>
        <li>
          <label>个人用户名：</label>
          <input type="text" name="nickname" value="" id="username" class="username" />
        </li>
        <li>
          <label>密码：</label>
          <input type="password" name="password" value="" id="password" class="password"/>
        </li>
        <li>
          <label>验证码：</label>
          <input type="text" name="yanzhengma" value="" class="yanzhengma" >
          <a class="getCheckNum" href="javascript:void(0)"><img src="images/num_03.jpg"/>看不清？</a></li>
        <li class="zinp">
	        <a id="btnLogin" class="inp" href="javascript:void(0)">登录</a>
	        <a id="btnRegister" class="inp" href="/members/register" target="_blank">免费注册</a>
	        <a class="forget" href="wangjimima.html">忘记密码</a>
        </li>
      </ul>
    </form>
  </div>
</div>
{/if}

<iframe style="display:none" id="downloadIframe">

</iframe>