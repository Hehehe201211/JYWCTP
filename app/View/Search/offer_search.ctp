<script type="text/javascript">
{literal}
$(document).ready(function(){
    var ulCHeight=$(".ulCompany1").height();
    $(".switchBox").click(function(){
        if (NaV=="msie6"||NaV=="msie7") {
            $(".ulCompany1").height(ulCHeight);
            if ($(".switchBox .divTable:visible").length==0) {
                $(".ulCompany1 li").show();
            } else {
                $(".ulCompany1 li").hide();
            }
        }
    });
    //检索按钮
    $('#search').click(function(){
       var searchOpt = $('#searchOpt').serializeArray();
        $('#informationList').load('/search/offerSearch', searchOpt, function(){});
    });
});
{/literal}
</script>
<div class="main">
  <div id="loginWarning">
    <div class="area">
      <div class="notice">您输入的密码和账户名不匹配，请重新输入。</div>
      <ul class="question">
        <li>您是否锁定了键盘的大写功能？
          <p>请检查您键盘上的"Caps Lock"或"A"灯是否亮着，<br/>
            如果是，请先按一下"Caps Lock"键然后重新输入。</p>
        </li>
        <li>您是否忘记或不小心输入了错误的密码？
          <p>您可以通过<a href="#">忘记会员名</a>或<a href="#">忘记密码</a>重新设置信息。</p>
        </li>
      </ul>
    </div>
    <div class="arrow"></div>
  </div>
  <form id="searchOpt" action="/search/offerSearch" method="post">
  <div class="wmxxjs_left inviteJobL" style="overflow:visible;">
      {$this->element('common/parttime-search-bar')}
  </div>
  <!--
  <div class="sider inviteJobR">
  
    <div class="login">
      <form action="#" method="post" id="loginBox">
        <ul>
          <li>
            <label>用户名：</label>
            <input type="text" name="username" value="请输入用户名" id="username" class="username" txt="请输入用户名" />
          </li>
          <li>
            <label>密码：</label>
            <input type="password" name="password" value="" id="password" class="password"/>
            <label id="passwordL" for="password">请输入密码</label>
          </li>
          <li>
            <label>验证码：</label>
            <input type="text" name="yanzhengma" value="验证码" class="yanzhengma" txt="验证码"/>
            <a id="getCheckNum" href="javascript:void(0)"><img src="{$this->webroot}img/num_03.jpg"/>看不清？</a></li>
          <li>
            <label>类型：</label>            
            <label class="fl"><input type="radio" name="type" value="person" checked="checked" id="person"/>个人</label>            
            <label class="fl"><input type="radio" name="type" value="enterprise" id="enterprise"/>企业</label>
          </li>
          <li class="zinp"><a id="btnLogin" class="inp" href="new-hyzy.html">登录</a><a id="btnRegister" class="inp" href="zhuce.html" target="_blank">免费注册</a><a class="forget" href="wangjimima.html">忘记密码</a></li>
        </ul>
      </form>
    </div>
    
  </div>
  -->
    <div class="clearfix"></div>
    <div style="margin-top:12px;" class="wmxxjs_left">
        <div class="biaotit">检索结果</div>
        {$this->element('common/offer-result')}
    </div>
  </form>
  <div class="sider">
    {$this->element('common/parttime-right')}
  </div>
  <div class="clear">&nbsp;</div>
</div>
