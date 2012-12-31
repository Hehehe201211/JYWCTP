<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("ul.nav li a:eq(0)").addClass("current");
    $(".index_tj").Scroll({line:1,speed:200,timer:3000,up:"index_tj_sp",down:"index_tj_sp1",selector:".index_tj"});
    $(".content_mid .keyuan .ulLists").Scroll({line:2,speed:200,timer:3000,up:"",down:"",selector:".content_mid .keyuan .ulLists"});
    $(".keyuan .fr .ulLists").Scroll({line:2,speed:200,timer:3000,up:"",down:"",selector:".keyuan .fr .ulLists"});
    $("#banners").KinSlideshow({moveStyle:"left",intervalTime:4,mouseEvent:"click",titleFont:{TitleFont_size:14,TitleFont_color:"#FFF"}});
    $(".duwu_bottm_con").imageScroller({next: "duwu_bottm_left",prev: "duwu_bottm_right",frame:"bookListCon",child: "li",auto: true,num:6,timer:5000,moveDistance:-95});
    
    $("#btnLogin").click(function(){
        if (!($("#username").val()==""||$("#username").val()=="请输入用户名"||$("#password").val()==""||$("#yanzhengma").val()==""||$("#yanzhengma").val()=="输入验证码"))  window.open("new-hyzy.html","_blank");
    });
    
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
    
  $(".linkLogin").click(function(e){
        e.preventDefault();
        bgKuang("#divDjbuz",".divDjbuz .closeDiv");         
  });
  $(".serTable .applyFor").click(function(e){
        e.preventDefault();
        bgKuang("#jsxxxqB",".jsxxxqB .closeDiv");           
  });
  
  $(".footer .links .close").click(function(){
      $(this).parent().slideUp("fast");
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
            <a href="http://www.lanrentuku.com" target="_blank"><img src="{$this->webroot}img/banners/1.jpg" alt="这是标题一" /></a>
            <a href="http://www.lanrentuku.com" target="_blank"><img src="{$this->webroot}img/banners/2.jpg" alt="这是标题二" /></a>
            <a href="http://www.lanrentuku.com" target="_blank"><img src="{$this->webroot}img/banners/3.jpg" alt="这是标题三" /></a>
            <a href="http://www.lanrentuku.com" target="_blank"><img src="{$this->webroot}img/banners/4.jpg" alt="这是标题四" /></a>
            <a href="http://www.lanrentuku.com" target="_blank"><img src="{$this->webroot}img/banners/5.jpg" alt="这是标题五" /></a>
            <a href="http://www.lanrentuku.com" target="_blank"><img src="{$this->webroot}img/banners/6.jpg" alt="这是标题六" /></a>
        </div>
        <div class="keyuan">
      <div class="fl"> 
      <h3><a href="/search?type=need" target="_blank" class="fr">更多..</a>我要客源</h3>
        <div class="ulLists">        
          <ul class="lists">
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/聚客币：50元/上海 上海/66/2012-11-24</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/聚客币：50元；积分：100分/上海 上海/99/2012-11-24</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/聚客币：50元/上海 上海/66/2012-11-24</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/聚客币：50元；积分：100分/上海 上海/99/2012-11-24</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-wyky2xq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
          </ul>
        </div>
      </div>
      <div class="fl fr">
      <h3><a href="/search?type=has" target="_blank" class="fr">更多..</a>我有客源</h3>
        <div class="ulLists">
          <ul class="lists">
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/聚客币：50元/上海 上海/66/2012-11-24</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/聚客币：50元；积分：100分/上海 上海/99/2012-11-24</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/聚客币：50元；积分：100分/上海 上海/99/2012-11-24</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/聚客币：50元/上海 上海/66/2012-11-24</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/聚客币：50元；积分：100分/上海 上海/99/2012-11-24</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/聚客币：50元；积分：100分/上海 上海/99/2012-11-24</a></li>
            <li><a href="plf-woyoukeyuanxq.html" target="_blank">聚业务悬赏测试1/50元/上海 上海/0</a></li>
          </ul>
        </div>
      </div>
    </div>
    </div>

    <div class="content_right">
        <div class="login">
            <h3>会员登录</h3>
            <form action="#" method="post" id="loginBox">
                <ul>
                    <li>
                        <input type="text" name="username" value="请输入用户名" id="username" class="username" txt="请输入用户名" />
                    </li>
                    <li>
                        <input type="password" name="password" value="" id="password" class="password"/>
                        <label id="passwordL" for="password">请输入密码</label>
                    </li>
                    <li>
                        <input type="text" name="yanzhengma" value="验证码" class="yanzhengma" txt="验证码"/>
                        <a id="getCheckNum" href="javascript:void(0)"><img src="{$this->webroot}img/num_03.jpg"/>看不清？</a>
                    </li>
                    <li style="margin-bottom:4px;">
                        <label>类型：</label>
                        <label><input type="radio" name="type" checked="checked"/>个人</label>
                        <label><input type="radio" name="type" />企业</label>
                    </li>
                    <li class="zinp">
                        <a href="new-hyzy.html" id="btnLogin" class="inp">登录</a>
                        <a href="zhuce.html" class="inp">免费注册</a>
                    </li>
                    <li class="liForget"><a href="wangjimima.html">忘记密码？</a>&nbsp;&nbsp;</li>
                </ul>
            </form>
        </div>
        <div class="crAd"><img src="{$this->webroot}img/ads/20110615175842023378.jpg" /></div>
        <div class="change2">
            <div class="nTab3">
                <div class="TabTitle3">
                    <ul id="myTab2">
                        <li class="active3"><a href="/static?tpl=gonggao">公告</a></li>
            <li><a href="/static?tpl=guize">规则</a></li>
            <li><a href="/static?tpl=tixian">提现</a></li>
            <li style="width:71px;"><a href="/static?tpl=jiaoyianquan">交易安全</a></li>
                    </ul>
                </div>
                <div class="TabContent3">
                    <div class="myTab1_Content2" style="display:block">
                        <div class="con_3">
                            <ul>
                                <li><a href="#1">新fea新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新faer闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻awrra新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻闻闻新闻新闻</a><span>[2011-9-19]</span></li>
                            </ul>
                            <h5><a href="/static?tpl=gonggao">查看更多&gt;&gt;</a></h5>
                        </div>
                    </div>
                    <div class="myTab1_Content2">
                        <div class="con_3">
                            <ul>
                                <li><a href="#1">新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                            </ul>
                            <h5><a href="/static?tpl=guize">查看更多&gt;&gt;</a></h5>
                        </div>
                    </div>
                    <div class="myTab1_Content2">
                        <div class="con_3">
                            <ul>
                                <li><a href="#1">新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新新闻新闻新闻新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                            </ul>
                            <h5><a href="/static?tpl=tixian">查看更多&gt;&gt;</a></h5>
                        </div>
                    </div>
                
                    <div class="myTab1_Content2">
                        <div class="con_3">
                            <ul>
                                <li><a href="#1">新新festet闻新闻新闻新新闻新闻新闻新新闻新新闻新新闻新闻新闻新新闻新闻新闻新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                                <li><a href="#1">新闻新闻新闻新闻</a><span>[2011-9-19]</span></li>
                            </ul>
                            <h5><a href="/static?tpl=jiaoyianquan">查看更多&gt;&gt;</a></h5>
                        </div>
                    </div>
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
                            <div class="con_c_zuo_wm"><a href="#"><img src="{$this->webroot}img/zjfk_1.jpg"  alt=""/></a>
                                <p class="con_c_zuo_bt">企业从事产品及服务</p>
                                <p class="con_c_zuo_kj"><a href="#">[展示模板]</a><a href="#">[企业资料录入]</a> </p>
                                <p class="con_c_zuo_slnr">聚业务通过互联网平台，为广大企业用户，提供产品展示、服务宣传的平台，帮助企业用户提升产品知名度，轻松招聘优秀商务人员。 </p>
                            </div>
                            <div class="con_c_zuo_wm"> <a href="#"><img src="{$this->webroot}img/zjfk_1.jpg"  alt=""/></a>
                                <p class="con_c_zuo_bt">企业产品资料</p>
                                <p class="con_c_zuo_kj"><a href="#">[展示模板]</a><a href="#">[产品资料上传]</a> </p>
                                <p class="con_c_zuo_slnr">通过该栏目，企业用户可以上传企业的产品，资料（图片、文字、说明书等），方便有意向从事兼职的会员下载浏览 </p>
                            </div>
                        </div>
                        <div class="con_c_zuo">
                            <div class="con_c_zuo_wm"><a href="#"><img src="{$this->webroot}img/zjfk_1.jpg"  alt=""/></a>
                                <p class="con_c_zuo_bt">发布兼职信息</p>
                                <p class="con_c_zuo_kj"><a href="#">[展示模板]</a><a href="#">[兼职信息录入]</a><a href="#">[简历检索 ]</a> </p>
                                <p class="con_c_zuo_slnr">用最少的成本，获得更多的客户资源，招聘兼职业务人员是企业用户最理想的选择；聚业务网站汇聚了全国最优秀的各行业业务人员 </p>
                            </div>
                            <div class="con_c_zuo_wm"> <a href="#"><img src="{$this->webroot}img/zjfk_1.jpg"  alt=""/></a>
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
                    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="serTable">
                        <tr class="con_2_tr">
                            <td width="15%"><a href="plt-jzxxxq.html" target="_blank">（未登陆）<br />冠捷T223M</a></td>
                            <td width="27%"><a href="plt-jzxxxq.html" target="_blank">（未登陆）<br />厦门XXXXX有限公司</a></td>
                            <td width="13%"><a href="plt-jzxxxq.html" target="_blank">（未登陆）<br />提供客户信息</a></td>
                            <td width="19%"><a href="plt-jzxxxq.html" target="_blank">（未登陆）<br />10%</a></td>
                            <td width="13%"><a href="plt-jzxxxq.html" target="_blank">（未登陆）<br />2012.09.24</a></td>
                            <td width="13%"><a class="detail linkLogin" href="javascript:;" target="_blank">我要申请</a></td>
                        </tr>      
                        <tr class="con_2_tr">
                            <th class="right top">兼职说明：</th>
                            <td colspan="5" class="left"><p class="textEllipsis">LCD 液晶显示器是 Liquid Crystal Display 的简称，LCD 的构造是在两片平行的玻璃基板当中放置液晶盒。</p></td>
                        </tr>
                    </table>
                </div>
            <!-- 结束切换 --> 
            </div>
        </div>
        
        <div class="index_xshdm">
            <div class="ziyuan_tit tilziyuan"> <span>资源天地</span>
                <ul>
                    <li class="active4"><a href="plt-zytdrmcz.html">入门成长</a></li>
                    <li><a href="#">培训课件</a></li>
                    <li><a href="#">客户管理</a></li>
                    <li><a href="#">方案模板</a></li>
                    <li><a href="#">总结计划</a></li>
                    <li style="border: medium none;"><a href="#">案例分析</a></li>
                </ul>
            </div>
            <div class="index_xshdm_xm">
                <ul>
                    <li class="listZYTD" style="display:block;">
                        <ul>
                            <li><a href="plt-zytdI-article.html" target="_blank">入门成长红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span><span class="time">2012-08-31 14:46</span></a></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">入门成长红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span><span class="time">2012-08-31 14:46</span></a></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">入门成长红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span><span class="time">2012-08-31 14:46</span></a></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">入门成长红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span><span class="time">2012-08-31 14:46</span></a></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">入门成长红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span><span class="time">2012-08-31 14:46</span></a></li>
                        </ul>
                        <p><a href="plt-zytdI-list.html" target="_blank">更多...</a></p>
                    </li>
                    <li class="listZYTD" >
                        <ul>
                            <li><a href="plt-zytdI-article.html" target="_blank">培训课件红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">培训课件红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">培训课件红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">培训课件红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">培训课件红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                        </ul>
                        <p><a href="plt-zytdI-list.html" target="_blank">更多...</a></p>
                    </li>
                    <li class="listZYTD" >
                        <ul>
                            <li><a href="plt-zytdI-article.html" target="_blank">客户管理红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">客户管理红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">客户管理红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">客户管理红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">客户管理红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                        </ul>
                        <p><a href="plt-zytdI-list.html" target="_blank">更多...</a></p>
                    </li>
                    <li class="listZYTD" >
                        <ul>
                            <li><a href="plt-zytdI-article.html" target="_blank">方案模板红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">方案模板红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">方案模板红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">方案模板红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">方案模板红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                        </ul>
                        <p><a href="plt-zytdI-list.html" target="_blank">更多...</a></p>
                    </li>
                    <li class="listZYTD" >
                        <ul>
                            <li><a href="plt-zytdI-article.html" target="_blank">总结计划红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">总结计划红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">总结计划红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">总结计划红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">总结计划红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                        </ul>
                        <p><a href="plt-zytdI-list.html" target="_blank">更多...</a></p>
                    </li>
                    <li class="listZYTD" >
                        <ul>
                            <li><a href="plt-zytdI-article.html" target="_blank">案例分析红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">案例分析红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">案例分析红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">案例分析红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                            <li><a href="plt-zytdI-article.html" target="_blank">案例分析红杏招聘网可靠吗？<span class="coin">10分</span><span class="coin">10页</span><span class="count">下载：10次</span></a><span class="time">2012-08-31 14:46</span></li>
                        </ul>
                        <p><a href="plt-zytdI-list.html" target="_blank">更多...</a></p>
                    </li>
                </ul>
                <a href="javascript:;" class="btnUploadDoc linkLogin">我要上传</a>
            </div>
        </div>
    </div>
    <div class="sider">
        <div class="fuwu">
            <h1><a href="plt-jzxx.html"><span class="fr">更多...</span>最新企业会员认证</a></h1>
            <dl class="imgParttime">
                <dt><a href="gsqt-index.html" target="_blank" title="猪八戒猪八戒猪八戒猪八戒猪八戒"><img src="{$this->webroot}img/pig_03.jpg" width="77" height="73" alt="" /></a></dt>
                <dd class="title"><a href="gsqt-index.html" target="_blank" title="猪八戒猪八戒猪八戒猪八戒猪八戒">猪八戒猪八戒猪八戒猪八戒猪八戒</a></dd>
                <dd class="content"><a href="jzxxxq2.html" target="_blank">中国最大的威客网站600万服务商随您选中国最大的威客网站600万威客0万站600万威客0万威客</a></dd>
            </dl>
            <dl class="imgParttime">
                <dt><a href="gsqt-index.html" target="_blank" title="猪八戒猪八戒猪八戒猪八戒猪八戒"><img src="{$this->webroot}img/pig_03.jpg" width="77" height="73" alt="" /></a></dt>
                <dd class="title"><a href="gsqt-index.html" target="_blank" title="猪八戒猪八戒猪八戒猪八戒猪八戒">猪八戒猪八戒猪八戒猪八戒猪八戒</a></dd>
                <dd class="content"><a href="jzxxxq2.html" target="_blank">中国最大的威客网站600万服务商随您选中国最大的威客网站600万威客0万站600万威客0万威客</a></dd>
            </dl>
            <dl class="imgParttime">
                <dt><a href="gsqt-index.html" target="_blank" title="猪八戒猪八戒猪八戒猪八戒猪八戒"><img src="{$this->webroot}img/pig_03.jpg" width="77" height="73" alt="" /></a></dt>
                <dd class="title"><a href="gsqt-index.html" target="_blank" title="猪八戒猪八戒猪八戒猪八戒猪八戒">猪八戒猪八戒猪八戒猪八戒猪八戒</a></dd>
                <dd class="content"><a href="jzxxxq2.html" target="_blank">中国最大的威客网站600万服务商随您选中国最大的威客网站600万威客0万站600万威客0万威客</a></dd>
            </dl>
        </div>
    </div>

</div>