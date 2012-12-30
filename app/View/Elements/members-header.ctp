<div class="wrapper1 wrap header">
  <div class="toplist">
    <ul>
        <li class="back"><a href="#">低投入高回报</a></li>
        <li class="loginInfo">
            <span class="left fl">您好，<a class="toptoolUseN">{$memberInfo.Member.nickname}</a>，欢迎光临聚业务网&nbsp;
                <a href="/members/logout" class="toptoolUseN">[安全退出]</a>
            </span>
            <span class="right fr">
                <a href="/members">我的聚业务</a>
                <a href="/accounts/sms">站内信</a>
                <a href="/accounts/invite">好友推荐</a>
                <a href="zhuce.html" style="border:none;">网站说明</a>
            </span>
        </li>
        <li class="help"><a href="#">帮助</a></li>
        <li class="daohang"><a href="#">网站导航</a>&nbsp;</li>
    </ul>
  </div>
  <div id="zyt">
    <a href="/members"><div class="zylo"></div></a>
    <div class="zydh">
      <div class="zydh_b">
        <ul>
          <li><a href="/" target="_blank">首页</a></li>
          <li><a href="/members">个人主页</a></li>
          <li><a href="/accounts/friend">好友</a></li>
          <li><a href="/parttime/listview?type=need">兼职</a></li>
          <li><a href="/accounts/sms">站内信</a></li>
        </ul>
        <p><a href="#">搜索</a></p>
        <div class="zylb"> <span class="spanSearchWrap">
          <div class="sltSearchTil"> <a class="x_selected" href="#" hidefocus="true"><span class="mbSearchR">请选择类别</span></a> </div>
          <ul class="sltSearch">
            <li><a href="/informations/issue/has">已发布客源</a></li>
            <li><a href="/informations/received/has">已收到客源</a></li>
            <li><a href="informations/issue/need">已发布悬赏</a></li>
            <li><a href="/informations/received/need">已收到悬赏</a></li>
            <li><a href="#">站内信</a></li>
            <li><a href="#">全部</a></li>
          </ul>
          </span>
          <input type="text" class="txtSearch" />
          <a href="#" class="btnSearch"></a> </div>        
      </div>
    </div>
  </div>
</div>
<div class="wrap">
  <div class="xian2"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
//	$('.zy_lt:gt(0)').next('div').hide();
	$('.zy_lt').click(function(){
		$(this).next("div").slideToggle("slow");
		var src = $(this).find('img:first').attr('src');
		if(/jian/.test(src)){
			$(this).find('img:first').attr('src', '/img/jia.png');
		} else {
			$(this).find('img:first').attr('src', '/img/jian.png');
		}
		
	});
});
</script>