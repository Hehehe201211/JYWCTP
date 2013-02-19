<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("ul.nav li a:eq(0)").addClass("current");   
    $(".content_mid .keyuan .ulLists").Scroll({line:2,speed:200,timer:3000,up:"",down:"",selector:".content_mid .keyuan .ulLists"});
    $(".keyuan .fr .ulLists").Scroll({line:2,speed:200,timer:3000,up:"",down:"",selector:".keyuan .fr .ulLists"});
    $("#banners").KinSlideshow({moveStyle:"left",intervalTime:6,mouseEvent:"click",titleFont:{TitleFont_size:14,TitleFont_color:"#FFF"}});
    $(".duwu_bottm_con").imageScroller({next: "duwu_bottm_left",prev: "duwu_bottm_right",frame:"bookListCon",child: "li",auto: true,num:6,timer:5000,moveDistance:-95});
    
    //选项卡切换
    $("#myTab1 li").mouseenter(function(){
        var tabIndex=$("#myTab1 li").index(this);
        tabSwitching(tabIndex,"#myTab1 li",".myTab1_Content1","active2");
    });
    
    $("#myTab2 li").mouseenter(function(){
        var tabIndex=$("#myTab2 li").index(this);
        tabSwitching(tabIndex,"#myTab2 li",".myTab1_Content2","active3");
    });
    
    $("#myTab0 li").mouseenter(function(){
        var tabIndex=$("#myTab0 li").index(this);
        tabSwitching(tabIndex,"#myTab0 li",".myTab0_Content0","active");
    });
    
    $("#ss li").mouseenter(function(){
        var tabIndex=$("#ss li").index(this);
        tabSwitching(tabIndex,"#ss li",".myTab4_Content0","active4");
    });
    $(".tilziyuan ul li").mouseenter(function(){
        var tabIndex=$(".tilziyuan ul li").index(this);
        tabSwitching(tabIndex,".tilziyuan ul li",".listZYTD","active4");
    }); 
    
    //搜索下拉表
    $('#top_select').mouseenter(function(){
        $(".main").css("z-index",-10);
        searchName("#top_select","#topSearchUl",".header_top_search","#topSearchUl li a","#topSearch");
    });
    
    $(".fuwu .imgParttime .content a").each(function(index, element) {
        var str=$(this).text();     
        if (str.length>34) {
            str=str.slice(0,32)+"...";
            $(this).text(str)
        }
    });     
    
  //单行新闻滚动
  var zy_zBottomRcdT;
  $(".con_3 li a").hover(function(){
      $(this).parent().css("text-overflow","clip");
      var selector=".myTab1_Content2 ul li a:eq("+$(".myTab1_Content2 ul li a").index(this)+")";
      $(this).next().hide();
      zy_zBottomRcdT=window.setInterval(function(){singleLineTextS(selector);},200);
  },function(){
       $(this).parent().css("text-overflow","ellipsis");
       $(this).css("margin-left",0);
       window.clearInterval(zy_zBottomRcdT);
       $(this).next().show();
  });
  
  $(".content_mid .keyuan .lists a").hover(function(){
      $(this).parent().css("text-overflow","clip");
      var selector=".content_mid .keyuan .lists a:eq("+$(".content_mid .keyuan .lists a").index(this)+")";
      zy_zBottomRcdT=window.setInterval(function(){singleLineTextS(selector);},200);
  },function(){
       $(this).parent().css("text-overflow","ellipsis");
       $(this).css("margin-left",0);
       window.clearInterval(zy_zBottomRcdT);
  });

  $(".serTable .applyFor").click(function(e){
        e.preventDefault();
        bgKuang("#jsxxxqB",".jsxxxqB .closeDiv");           
  });
  
  $(".footer .links .close").click(function(){
      $(this).parent().slideUp("fast");
  });
    
      //验证码
    $('#yanzhengma').after('<img id="code" src="/members/image">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
    
    //login
    $('#btnLogin').click(function(e){
        var msg = '';
        var error = false;
        var nickname = $('#loginBox input[name="nickname"]').val();
        var password = $('#loginBox input[name="password"]').val();
        var checkNum = $('#loginBox input[name="checkNum"]').val();
        var type = $('#loginBox input[name="type"]:checked').val();
        if (nickname == '' || nickname == '请输入用户名') {
            msg = '<li>请输入用户名</li>'
            error = true;
        }
        if (password == '') {
            msg += '<li>请输入密码</li>';
            error = true;
        }
        if (checkNum == '' || checkNum == '验证码') {
            msg += '<li>请输入验证码</li>';
            error = true;
        }
        if (type == null) {
            msg += '<li>请选择类型</li>';
            error = true;
        }
        if (error) {
            e.preventDefault();
            $('#loginWarning .question').html(msg);
            $("#loginWarning").fadeIn("fast");
            var t=setTimeout("hideWarning()",10000);
        }
        
        if(!error) {
             params = "nickname=" + nickname + "&password=" + password + "&checkNum=" + checkNum + "&type=" + type;
             $.ajax({
                type : 'post',
                url  : '/members/ajaxlogin',
                data : params,
                success : function(data) {
                    if (data == '') {
                        window.location.href = location.href;
                    }                    
                    if (data != '') {
                        msg = '<li>' + data + '</li>';
                        $('#loginWarning ul').html(msg);
                        $("#loginWarning").fadeIn("fast");
                        var t=setTimeout("hideWarning()",10000);
                    } else {
                        $('#loginWarning').hide();
                    }
                }
             });
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
    <div class="content_mid" >
        <div id="banners">
           <a href="/members/register" target="_blank"><img src="{$this->webroot}img/banners/banner5a.jpg" alt="马上注册，体验聚业务为您精心打造的服务" /></a>
           <a href="/static?tpl=about-us" target="_blank"><img src="{$this->webroot}img/banners/banner1a.jpg" alt="聚业务——为您提供业务生涯一站式服务" /></a>
           <a href="/static?tpl=kehufuwu" target="_blank"><img src="{$this->webroot}img/banners/banner2b.jpg" alt="聚业务——助力您的企业" /></a>
           <a href="/static?tpl=haoyou" target="_blank"><img src="{$this->webroot}img/banners/banner4a.jpg" alt="参加聚业务网站平台推广活动，轻松赚取积分" /></a>            
           <a href="/static?tpl=youhui" target="_blank"><img src="{$this->webroot}img/banners/banner6a.jpg" alt="你有一条经验，我有一条经验，我们彼此交换，每人可拥有两条经验。" /></a>
            <a href="/members/register" target="_blank"><img src="{$this->webroot}img/banners/banner7a.jpg" alt="聚业务——汇聚各行各业" /></a>
        </div>
        <div class="keyuan">
      <div class="fl"> 
      <h3><a href="/search?type=need" target="_blank" class="fr">更多..</a>最新客源</h3>
        <div class="ulLists">        
          <ul class="lists">
          {foreach $hasTaskList as $information}
            <li><a href="/search/infodetail?id={$information.Information.id}" target="_blank"><p>{$information.Information.title}</p><p>/{if $information.Information.payment_type == 1}业务币：{$information.Information.price}元{/if}
                  {if $information.Information.payment_type == 2}积分：{$information.Information.point}分{/if}
                  {if $information.Information.payment_type == 3}业务币：{$information.Information.price}元 积分：{$information.Information.point}分{/if}</p><p>/{$information.Information.created|date_format:"%Y-%m-%d"}</p><p>/{$provincial = $this->City->cityName({$information.Information.provincial})}
                  {$city = $this->City->cityName({$information.Information.city})}
                  {if $provincial != $city}{$provincial} {$city}{else}{$provincial}{/if}</p></a></li>              
          {/foreach}
          </ul>
        </div>
      </div>
      <div class="fl fr">
      <h3><a href="/search?type=has" target="_blank" class="fr">更多..</a>最新悬赏</h3>
        <div class="ulLists">
          <ul class="lists">
              {foreach $needTaskList as $information}
                <li><a href="/search/infodetail?id={$information.Information.id}" target="_blank"><p>{$information.Information.title}</p><p>/{if $information.Information.payment_type == 1}业务币：{$information.Information.price}元{/if}
                      {if $information.Information.payment_type == 2}积分：{$information.Information.point}分{/if}
                      {if $information.Information.payment_type == 3}业务币：{$information.Information.price}元 积分：{$information.Information.point}分{/if}</p><p>/{$information.Information.created|date_format:"%Y-%m-%d"}</p><p>/{$provincial = $this->City->cityName({$information.Information.provincial})}
                      {$city = $this->City->cityName({$information.Information.city})}
                      {if $provincial != $city}{$provincial} {$city}{else}{$provincial}{/if}/</p></a></li>                  
              {/foreach}
          </ul>
        </div>
      </div>
    </div>
    </div>
    <div class="content_right">
        <div class="login">
            {if empty($memberInfo)}
            <h3>会员登录</h3>
            <form action="#" method="post" id="loginBox">
                <ul>
                    <li>
                        <input type="text" name="nickname" value="请输入用户名" id="username" class="username" txt="请输入用户名" />
                    </li>
                    <li>
                        <input type="password" name="password" value="" id="password" class="password"/>
                        <label id="passwordL" for="password">请输入密码</label>
                    </li>
                    <li>
                        <input type="text" name="checkNum" value="验证码" class="yanzhengma" id="yanzhengma" txt="验证码"/>
                        <a id="getCheckNum" href="javascript:void(0)">看不清？</a>
                    </li>
                    <li style="margin-bottom:4px;">
                        <label>类型：</label>
                        <label><input type="radio" name="type" value="0" checked="checked"/>个人</label>
                        <label><input type="radio" name="type" value="1" />企业</label>
                    </li>
                    <li class="zinp">
                        <a href="javascript:void(0)" id="btnLogin" class="inp">登录</a>
                        <a href="/members/register" class="inp">免费注册</a>
                    </li>
                    <li class="liForget"><a href="/account/forget">忘记密码？</a>&nbsp;&nbsp;</li>
                </ul>
            </form>
            {else}
                {if $memberInfo.Member.type == Configure::read('UserType.Personal')}
                    {if $memberInfo.Member.grade != 2}
                      <h3>{$memberInfo.Member.nickname}</h3>
                      <dl class="mebLinks">
                        <dt>你还不是高级会员，点击<a class="upgrade" href="/members/upgrade">立即升级</a></dt>
                        <dd><a target="_blank" href="/informations/search/has">检索客源</a></dd>
                        <dd><a target="_blank" href="/informations/search/need">检索悬赏</a></dd>
                        <dd><a target="_blank" href="/fulltimes/search">检索职位</a></dd>
                        <dd><a target="_blank" href="/parttimes/listview?type=need">检索兼职</a></dd>
                        <dd>&nbsp;</dd>
                        <dd><a class="logout"href="javascript:void(0)">退出</a></dd>
                      </dl>
                      {else}
                          <h3>{$memberInfo.Member.nickname}</h3>
                          <dl class="mebLinks">        
                            <dd><a href="/informations/search/has" target="_blank">检索客源</a></dd>
                            <dd><a href="/informations/create/has" target="_blank">发布客源</a></dd>
                            <dd><a href="/informations/search/need" target="_blank">检索悬赏</a></dd>
                            <dd><a href="/informations/create/need" target="_blank">发布悬赏</a></dd>
                            <dd><a href="/fulltimes/search" target="_blank">检索职位</a></dd>
                            <dd><a href="/resumes/listview" target="_blank">简历管理</a></dd>   
                            <dd><a href="/parttimes/listview?type=need" target="_blank">检索兼职</a></dd>     
                            <dd><a href="/invitations/listview" target="_blank">兼职管理</a></dd> 
                            <dd><a href="/resources/listview?mid={$memberInfo.Member.id}" target="_blank">文档管理</a></dd>       
                            <dd><a href="javascript:void(0)" class="logout">退出</a></dd>
                          </dl>
                      {/if}
                  {else}

                          {if $memberInfo.Member.grade != 2}
                          <h3>{$memberInfo.Member.nickname}</h3>
                          <dl class="mebLinks">
                            <dt>你还不是高级会员，点击<a href="/members/upgrade" class="upgrade">立即升级</a></dt>
                            <dd><a href="/resumes/search" target="_blank">检索简历</a></dd>
                            <dd><a href="/elites/listview" target="_blank">检索精英</a></dd>
                            <dd>&nbsp;</dd>
                            <dd><a href="javascript:void(0)" class="logout">退出</a></dd>
                          </dl>
                          {else}
                          <h3>{$memberInfo.Member.nickname}</h3>
                          <dl class="mebLinks">        
                            <dd><a href="/services/material" target="_blank">产品管理</a></dd>
                            <dd><a href="/resumes/search" target="_blank">检索简历</a></dd>
                            <dd><a href="/auditions/listview?type=receive" target="_blank">招聘管理</a></dd>
                            <dd><a href="/elites/listview" target="_blank">检索精英</a></dd>
                            <dd><a href="/parttimes/listview?type=send" target="_blank">兼职管理</a></dd>   
                            <dd>&nbsp;</dd>
                            <dd><a href="javascript:void(0)" class="logout">退出</a></dd>
                          </dl>
                          {/if}
                  {/if}
            {/if}
        </div>
        <div class="crAd"><a href="/accounts/invite"><img src="{$this->webroot}img/ads/20110615175842023378.jpg" /></a></div>
        <div class="change2">
            <div class="nTab3">
                <div class="TabTitle3">
                    <ul id="myTab2">
                    {foreach $notices as $key => $notice}
                        {if $key == 0}
                            <li class="active3"><a href="/notices/listview?pid={$notice.Notice.id}">{$notice.Notice.title}</a></li>
                        {elseif $key+1 == count($notices)}
                            <li style="width:71px;"><a href="/notices/listview?pid={$notice.Notice.id}">{$notice.Notice.title}</a></li>
                        {else}
                            <li><a href="/notices/listview?pid={$notice.Notice.id}">{$notice.Notice.title}</a></li>
                        {/if}
                    {/foreach}
                    </ul>
                </div>
                <div class="TabContent3">
                {foreach $notices as $key => $notice}
                    {if $key == 0}
                    <div class="myTab1_Content2" style="display:block">
                        <div class="con_3">
                            <ul>
                                {foreach $notice.subNotice as $sub}
                                    <li><a href="/notices/detail?id={$sub.Notice.id}">{$sub.Notice.title}</a><span>[{$sub.Notice.created|date_format:"%Y-%m-%d"}]</span></li>
                                {/foreach}
                            </ul>
                            {if count($notice.subNotice) == 5}
                                <h5><a href="/notices/listview?pid={$notice.Notice.id}">查看更多&gt;&gt;</a></h5>
                            {/if}
                        </div>
                    </div>
                    {else}
                    <div class="myTab1_Content2">
                        <div class="con_3">
                            <ul>
                                {foreach $notice.subNotice as $sub}
                                    <li><a href="/notices/detail?id={$sub.Notice.id}">{$sub.Notice.title}</a><span>[{$sub.Notice.created|date_format:"%Y-%m-%d"}]</span></li>
                                {/foreach}
                            </ul>
                            {if count($notice.subNotice) == 5}
                                <h5><a href="/notices/listview?pid={$notice.Notice.id}">查看更多&gt;&gt;</a></h5>
                            {/if}
                        </div>
                    </div>
                    {/if}
                {/foreach}

                </div>
            </div>
        </div>
    </div>

    <div class="cont">
        <div class="nTab"> 
          <!-- 标题开始 -->
            <div class="TabTitle">
                <ul id="myTab0">
                   <li class="active">企业服务</li>
                   <li>我要兼职</li>
                </ul>
            </div>
          <!-- 内容开始 -->
            <div class="TabContent">
                <div class="myTab0_Content0">
                    <div class="con_c">
                        <div class="con_c_zuo">
                            <div class="con_c_zuo_wm"><a class="icon" href="#" ></a>
                                <p class="con_c_zuo_bt">企业从事产品及服务</p>
                                <p class="con_c_zuo_kj"><a href="#">[展示模板]</a><a href="#">[企业资料录入]</a> </p>
                                <p class="con_c_zuo_slnr">聚业务通过互联网平台，为广大企业用户，提供产品展示、服务宣传的平台，帮助企业用户提升产品知名度，轻松招聘优秀商务人员。 </p>
                            </div>
                            <div class="con_c_zuo_wm"><a class="icon icon1" href="#"></a>
                                <p class="con_c_zuo_bt">企业产品资料</p>
                                <p class="con_c_zuo_kj"><a href="#">[展示模板]</a><a href="#">[产品资料上传]</a> </p>
                                <p class="con_c_zuo_slnr">通过该栏目，企业用户可以上传企业的产品，资料（图片、文字、说明书等），方便有意向从事兼职的会员下载浏览 </p>
                            </div>
                        </div>
                        <div class="con_c_zuo">
                            <div class="con_c_zuo_wm"><a class="icon icon2" href="#"></a>
                                <p class="con_c_zuo_bt">发布兼职信息</p>
                                <p class="con_c_zuo_kj"><a href="#">[展示模板]</a><a href="#">[兼职信息录入]</a><a href="#">[简历检索 ]</a> </p>
                                <p class="con_c_zuo_slnr">用最少的成本，获得更多的客户资源，招聘兼职业务人员是企业用户最理想的选择；聚业务网站汇聚了全国最优秀的各行业业务人员 </p>
                            </div>
                            <div class="con_c_zuo_wm"><a class="icon icon3" href="#"></a>
                                <p class="con_c_zuo_bt">广告位合作方式</p>
                                <p class="con_c_zuo_kj"><a href="#">[广告位资源]</a><a href="#">[申请广告位]</a> </p>
                                <p class="con_c_zuo_slnr">酒香也怕巷子深，聚业务为企业用户量身定制广告位，且根据网站访问者的身份精准投放，让您的企业“有的放矢” </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="myTab0_Content0" style="display:none;" >
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="con_2_table">
                        <thead>
                            <tr class="con_2_tr con_2_xq_too">
                                <th width="15%" class="tr_td1">产品或服务</th>
                                <th width="27%" class="tr_td2">公司名称</th>
                                <th width="13%" class="tr_td3">兼职配合方式</th>
                                <th width="19%" class="tr_td4">提成比例</th>
                                <th width="13%" class="tr_td5">发布日期</th>
                                <th width="13%" class="tr_td6">&nbsp;</th>
                            </tr>
                        </thead>
                    </table>
                    {foreach $parttimes as $parttime}
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="serTable">        
                    <tbody>                
                            <tr class="con_2_tr">
                                <td width="15%">
                                <a href="/search/pdetail?id={$parttime.PartTime.id}" target="_blank">
                                {$this->Category->getCategoryName($parttime.PartTime.category)} 
                                {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
                                </a>
                                </td>
                                <td width="27%">
                                <a href="/search/pdetail?id={$parttime.PartTime.id}" target="_blank">
                                {$parttime.Member.company_name}
                                </a>
                                </td>
                                <td width="13%">
                                <a href="/search/pdetail?id={$parttime.PartTime.id}" target="_blank">
                                {if $parttime.PartTime.method == 1}提供客户信息
                                {elseif $parttime.PartTime.method == 2} 协助跟单
                                {else}独立签单
                                {/if}
                                </a>
                                </td>
                                <td width="19%">
                                <a href="/search/pdetail?id={$parttime.PartTime.id}" target="_blank">
                                {if $parttime.PartTime.pay == 1}
                                {$parttime.PartTime.pay_rate}%
                                {else}协商确定
                                {/if}
                                </a>
                                </td>
                                <td width="13%">
                                <a href="/search/pdetail?id={$parttime.PartTime.id}" target="_blank">{$parttime.PartTime.created|date_format:"%Y-%m-%d"}</a>
                                </td>
                                <td width="13%">
                                <a class="detail " href="/search/pdetail?id={$parttime.PartTime.id}" target="_blank">详细信息</a>
                                </td>
                            </tr>      
                            <tr class="con_2_tr">
                                <th class="right top">兼职说明：</th>
                                <td colspan="5" class="left">
                                <p class="textEllipsis">{$parttime.PartTime.additional}</p>
                                </td>
                            </tr>    
                            </tbody>                    
                    </table>
                    {/foreach}
                </div>
            <!-- 结束切换 --> 
            </div>
        </div>
        
        <div class="index_xshdm">
            <div class="ziyuan_tit tilziyuan"> <span>资源天地</span>
                <ul>
                    <li class="active4"><a href="/resources/search?type=1">入门成长</a></li>
                    <li><a href="/resources/search?type=2">培训课件</a></li>
                    <li><a href="/resources/search?type=3">客户管理</a></li>
                    <li><a href="/resources/search?type=4">方案模板</a></li>
                    <li><a href="/resources/search?type=5">总结计划</a></li>
                    <li style="border:0 none;"><a href="/resources/search?type=6">案例分析</a></li>
                </ul>
            </div>
            <div class="index_xshdm_xm">
                <ul>
                    <li class="listZYTD" style="display:block;">                    
                        <table width="100%" border="0">
                        {if !empty($documents.chengzhang)}
                                {foreach $documents.chengzhang as $key => $document}
                                    <tr>
    <td width="60%"><p class="textEllipsis"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></p></td>
    <td width="9%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{if $document.Document.point == 0}免费{else}{$document.Document.point}分{/if}</a></td>
    <td width="8%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.pages}页</a></td>
    <td width="13%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">下载：{$document.Document.download_cnt}次</a></td>
    <td width="10%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.created|date_format:"%Y-%m-%d"}</a></td>
  </tr>
                                {/foreach}
                            {else}
                            没有入门成长相关的资源。
                            {/if}   
                             <tr><td colspan="5" class="more"> 
  {if count($documents.chengzhang) >= 5}                           
                           <a href="/resources/search?type=1" target="_blank">更多...</a>
                           {else}&nbsp;
                        {/if}
                        </td></tr>
</table>                      
                    </li>
                    <li class="listZYTD" >   
                        <table width="100%" border="0">
                       {if !empty($documents.peixun)}
                                {foreach $documents.peixun as $key => $document}
                                    <tr>
    <td width="60%"><p class="textEllipsis"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></p></td>
    <td width="9%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{if $document.Document.point == 0}免费{else}{$document.Document.point}分{/if}</a></td>
    <td width="8%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.pages}页</a></td>
    <td width="13%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">下载：{$document.Document.download_cnt}次</a></td>
    <td width="10%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.created|date_format:"%Y-%m-%d"}</a></td>
  </tr>
                                {/foreach}
                            {else}
                            没有入门成长相关的资源。
                            {/if}   
                             <tr><td colspan="5" class="more"> 
   {if count($documents.peixun) >= 5}                           
                           <a href="/resources/search?type=2" target="_blank">更多...</a>
                           {else}&nbsp;
                        {/if}
                        </td></tr>
</table>
                    </li>
                    <li class="listZYTD" >
                        <table width="100%" border="0">
                            {if !empty($documents.kehu)}
                                {foreach $documents.kehu as $key => $document}
                                    <tr>
    <td width="60%"><p class="textEllipsis"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></p></td>
    <td width="9%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{if $document.Document.point == 0}免费{else}{$document.Document.point}分{/if}</a></td>
    <td width="8%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.pages}页</a></td>
    <td width="13%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">下载：{$document.Document.download_cnt}次</a></td>
    <td width="10%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.created|date_format:"%Y-%m-%d"}</a></td>
  </tr>
                                {/foreach}
                            {else}
                            没有入门成长相关的资源。
                            {/if}   
                             <tr><td colspan="5" class="more"> 
   {if count($documents.kehu) >= 5}                           
                           <a href="/resources/search?type=3" target="_blank">更多...</a>
                           {else}&nbsp;
                        {/if}
                        </td></tr>
</table>
                    </li>
                    <li class="listZYTD" >                       
                        <table width="100%" border="0">
                            {if !empty($documents.fangan)}
                                {foreach $documents.fangan as $key => $document}
                                    <tr>
    <td width="60%"><p class="textEllipsis"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></p></td>
    <td width="9%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{if $document.Document.point == 0}免费{else}{$document.Document.point}分{/if}</a></td>
    <td width="8%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.pages}页</a></td>
    <td width="13%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">下载：{$document.Document.download_cnt}次</a></td>
    <td width="10%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.created|date_format:"%Y-%m-%d"}</a></td>
  </tr>
                                {/foreach}
                            {else}
                            没有入门成长相关的资源。
                            {/if}   
                             <tr><td colspan="5" class="more"> 
   {if count($documents.fangan) >= 5}                           
                           <a href="/resources/search?type=4" target="_blank">更多...</a>
                           {else}&nbsp;
                        {/if}
                        </td></tr>
</table>
                    </li>
                    <li class="listZYTD" >
                    <table width="100%" border="0">
                            {if !empty($documents.zongjie)}
                                {foreach $documents.zongjie as $key => $document}
                                    <tr>
    <td width="60%"><p class="textEllipsis"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></p></td>
    <td width="9%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{if $document.Document.point == 0}免费{else}{$document.Document.point}分{/if}</a></td>
    <td width="8%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.pages}页</a></td>
    <td width="13%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">下载：{$document.Document.download_cnt}次</a></td>
    <td width="10%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.created|date_format:"%Y-%m-%d"}</a></td>
  </tr>
                                {/foreach}
                            {else}
                            没有入门成长相关的资源。
                            {/if}   
                             <tr><td colspan="5" class="more"> 
   {if count($documents.zongjie) >= 5}                           
                           <a href="/resources/search?type=5" target="_blank">更多...</a>
                           {else}&nbsp;
                        {/if}
                        </td></tr>
</table>                        
                    </li>
                    <li class="listZYTD" >
                        <table width="100%" border="0">
                            {if !empty($documents.anli)}
                                {foreach $documents.anli as $key => $document}
                                    <tr>
    <td width="60%"><p class="textEllipsis"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></p></td>
    <td width="9%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{if $document.Document.point == 0}免费{else}{$document.Document.point}分{/if}</a></td>
    <td width="8%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.pages}页</a></td>
    <td width="13%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">下载：{$document.Document.download_cnt}次</a></td>
    <td width="10%"><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.created|date_format:"%Y-%m-%d"}</a></td>
  </tr>
                                {/foreach}
                            {else}
                            没有入门成长相关的资源。
                            {/if}   
                             <tr><td colspan="5" class="more"> 
   {if count($documents.anli) >= 5}
                           <a href="/resources/search?type=6" target="_blank">更多...</a>
                           {else}&nbsp;
                        {/if}
                        </td></tr>
</table>
                    </li>
                </ul>
                <a href="/resources/upload" class="btnUploadDoc ">我要上传</a>
            </div>
        </div>
    </div>
    <div class="sider">
        <div class="fuwu">
            <h1><a href="javascript:void(0)"><span class="fr">更多...</span>最新企业会员认证</a></h1>
            {foreach $newCompanies as $company}
            <dl class="imgParttime">
                <dt>
                    <a href="/homes/index/{$company.Homepage.domain}" target="_blank">
                    {if !empty($company.CompanyAttribute.thumbnail)}
                        {$thumbnail = Configure::read('Data.path')|cat:$company.CompanyAttribute.thumbnail}
                        {if file_exists($thumbnail)}
                            <img src="{$this->webroot}{$company.CompanyAttribute.thumbnail}">
                        {else}
                            <img src="{$this->webroot}img/tx.jpg">
                        {/if}
                      {else}
                      <img src="{$this->webroot}img/tx.jpg">
                      {/if}
                    </a>
                </dt>
                <dd class="title">
                    <a href="/homes/index/{$company.Homepage.domain}" target="_blank" title="{$company.CompanyAttribute.full_name}">{$company.CompanyAttribute.full_name}</a>
                </dd>
                <dd class="content">
                    <a href="/homes/index/{$company.Homepage.domain}" target="_blank">{$company.CompanyAttribute.business_scope}</a>
                </dd>
            </dl>
            {/foreach}
        </div>
    </div>

</div>