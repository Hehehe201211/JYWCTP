var NaV=browserNaV();
$(document).ready(function(){
	$(window).resize(function(){
		gototopL();
		$("body").css("min-height",$(window).height()+1);
	});
	$(window).scroll(function(){
		if($(document).scrollTop() < 100) $("#gototop").fadeOut("fast"); 
		else  $("#gototop").fadeIn("fast");
		if(NaV=="msie6") ie6GTT();
	});
	$("input:button,input:submit,input:reset").addClass("inpButton");
	$("input:checkbox").addClass("inpCheckbox");
	$("input:radio").addClass("inpRadio");
	$("input:text,input:password").addClass("inpTextBox");
	$("input:file").addClass("inpFile");
	
	$("body").css("min-height",$(window).height()+1);	
	
	var tableTrH=".posInfo tbody tr:odd,.tableJobInfo tbody tr:odd";
	$(tableTrH).addClass("even");
	var tClass=window.setInterval(function(){
		$(tableTrH).addClass("even");
		$("input:button,input:submit,input:reset").addClass("inpButton");
		$("input:checkbox").addClass("inpCheckbox");
		$("input:radio").addClass("inpRadio");
		$("input:text,input:password").addClass("inpTextBox");			
	},1000);
	
	var dhHeight=$("#daohang").height()+14+"px";
	$("#siteNavi").toggle(function(e){
		e.preventDefault();
		$("#daohang").slideDown("fast");
		$(".daohang").animate({"top":dhHeight},200);		
		$(".daohang").addClass("daohangD");
		$(".main").css("z-index",-10);
	},function(e){
		e.preventDefault();
		$("#daohang").slideUp("fast");
		$(".daohang").animate({top:"0px"},200);
		$(".daohang").removeClass("daohangD");
		$(".main").css("z-index",0);
	});		
	
  //登录框填写提示
  if (document.getElementById("loginBox")) document.getElementById("loginBox").reset();  
  if ($(".username").attr("txt")!="")  $(".username").css("color","#999");
  if ($(".login .yanzhengma").attr("txt")!="")  $(".login .yanzhengma").css("color","#999");
  $(".username,.yanzhengma").focus(function(){
	  txt=$(this).attr("txt");
	  if ($(this).val()==txt || $(this).val()=="") {
		$(this).val("");
		$(this).css("color","#333");
	  }	
	});
  $(".username,.login .yanzhengma").blur(function(){
	  txt=$(this).attr("txt");
	  if ($(this).val()==txt || $(this).val()=="") {
		$(this).val(txt);
		$(this).css("color","#999");
	  }
  });
  $("#password").focus(function(){
	$("#passwordL").hide();
  });
  $("#password").change(function(){
	$("#passwordL").hide();
  });
  $("#password").blur(function(){
	if ($(this).val()=="") $("#passwordL").show();
  });  
  //datepicker处理
  $("#birthday").change(function(){
	 if($(this).val().slice(0,6)>"2010") $($(this).val("1960"+$(this).val().slice(4)));
  });   
  //IE7  
  $(".toplist .daohang").hover(function(){
		$(".zy_zhud,.main").css("z-index",-1);
	},function(){
		$(".zy_zhud,.main").css("z-index",0);
	});  
});
String.prototype.trim = function () {
	return this .replace(/^\s\s*/, '' ).replace(/\s\s*$/, '' ); 
}
//browser name and version
function browserNaV() {
	var NaV="";
	if (document.documentMode=="7") return "msie7";
	if ($.browser.msie) NaV="msie"; 
	else if ($.browser.chrome) NaV="chrome";
	else if ($.browser.mozilla) NaV="mozilla";
	else if($.browser.opera) NaV="opera"
	else if ($.browser.safari) NaV="safari";
	NaV+=parseInt($.browser.version);
	return NaV;
}
//隐藏框  setTimoOut等	
function hideWarning(){$("#loginWarning").fadeOut("slow");}
//关闭窗口
function closeWindow() {
   var browserName=navigator.appName; if (browserName=="Netscape") { window.open('','_parent',''); window.close(); } else if (browserName=="Microsoft Internet Explorer") { window.opener = "whocares"; window.close(); }}
//gotuTop	
$(function(){	
	$("<div id='gototop'></div>").appendTo("body").hide();
    gototopL();	
	$("#gototop").click(function(){
		$("html,body").animate({scrollTop:0},"normal");
		return false;
	});	
});
function gototopL(){
	if ($(window).width()<1060) var gototopL=$(window).width()-45;
	else var gototopL=($(document).width()-1000)/2+1030;
	$("#gototop").css("left",gototopL);
}
function ie6GTT(){	
	var top=$(window).scrollTop()+$(window).height()-90;
	$("#gototop").css("top",top);
}	
//搜索下拉框
function searchName(seaKind,seaChild,seaParent,seaOption,seaText){
	$(seaKind).bind("click",function(e){
		e.preventDefault();
		$(seaChild).slideDown(150);		
	});
	$(seaParent).bind("mouseleave",function(e){
		$(seaChild).slideUp("fast");
		$(".main").css("z-index",0);
	});
	$(seaOption).bind("click",function(e){
		e.preventDefault();		
		$(seaText).text($(this).text());
		$(seaChild).slideUp("fast");
		$(".main").css("z-index",0);
	});
}

//文字上滚含上下控制
(function($){
$.fn.extend({
        Scroll:function(opt,callback){
                if(!opt) var opt={};
                var _btnUp = $("#"+ opt.up);
                var _btnDown = $("#"+ opt.down);
                var timerID;
                var _this=$(opt.selector+">ul:first");			
                var     lineH=_this.find("li:first").height(),
                        line=opt.line?parseInt(opt.line,10):parseInt(this.height()/lineH,10), 
                        speed=opt.speed?parseInt(opt.speed,10):500; 
                        timer=opt.timer 
                if(line==0) line=1;
                var upHeight=0-line*lineH;
                var scrollUp=function(){
                        _btnUp.unbind("click",scrollUp); 
                        _this.animate({
                                marginTop:upHeight
                        },speed,function(){
                                for(i=1;i<=line;i++){
                                        _this.find("li:first").appendTo(_this);
                                }
                                _this.css({marginTop:0});
                                _btnUp.bind("click",scrollUp); 
                        });
                }               
                var scrollDown=function(){
                        _btnDown.unbind("click",scrollDown);
                        for(i=1;i<=line;i++){
                                $(opt.selector+">ul>li:last").show().prependTo(_this);
                        }
                        _this.css({marginTop:upHeight});
                        _this.animate({
                                marginTop:0
                        },speed,function(){
                                _btnDown.bind("click",scrollDown);
                        });
                }
                var autoPlay = function(){
                        if(timer) timerID = window.setInterval(scrollUp,timer);
                };
                var autoStop = function(){
                        if(timer) window.clearInterval(timerID);
                };
                _this.hover(autoStop,autoPlay).mouseout();
                _btnUp.css("cursor","pointer").click( scrollUp ).hover(autoStop,autoPlay);
                _btnDown.css("cursor","pointer").click( scrollDown ).hover(autoStop,autoPlay);
        }       
})
})(jQuery);

//文字左滚
function txtScrollLeft(timer,demo,demo1,demo2){
	var speed=timer;//数值越大，速度越慢
	var demo=document.getElementById(demo);
	var demo1=document.getElementById(demo1);
	var demo2=document.getElementById(demo2);
	if (!(demo||demo1||demo2))  return false;	
	demo2.innerHTML=demo1.innerHTML;
		function MarqueeLeft(){
			if(demo2.offsetWidth-demo.scrollLeft<=0) demo.scrollLeft-=demo1.offsetWidth;			
		else{
			demo.scrollLeft++;
		}
	}
	var MyMar=setInterval(MarqueeLeft,speed);
	demo.onmouseover=function() {clearInterval(MyMar);}
	demo.onmouseout=function() {MyMar=setInterval(MarqueeLeft,speed);}
}

//可控图片横向滚动
jQuery.fn.imageScroller = function(params) {
    var p = params || {
        next: "buttonNext",
        prev: "buttonPrev",
        frame: "viewerFrame",
        child: "a",
        auto: true,
		num:6,
		timer:3000,
		moveDistance:-95
    };
    var _btnNext = $("." + p.next);
    var _btnPrev = $("." + p.prev);
    var _imgFrame = $("." + p.frame);
    var _child = p.child;
    var _auto = p.auto;
    var _itv;
	var _timer=p.timer;
	var _n=p.num;
	var _nLast=_imgFrame.find(_child).length-p.num-1;
	var listWidth=_imgFrame.find(_child).width()+parseInt(_imgFrame.find(_child).css("margin-right"));
	var _moveDistance = p.moveDistance;	
	_imgFrame.width(listWidth*_imgFrame.find(_child).length);

    var turnLeft = function() {
        _btnPrev.unbind("click", turnLeft);
        if (_auto) autoStop();		
        _imgFrame.animate({"marginLeft":_moveDistance}, 'fast', '', function() {
            _imgFrame.find(_child + ":lt("+_n+")").appendTo(_imgFrame);
            _imgFrame.css("marginLeft", 0);
            _btnPrev.bind("click", turnLeft);
            if (_auto) autoPlay();
        });
    };
    var turnRight = function() {
        _btnNext.unbind("click", turnRight);
        if (_auto) autoStop();
        _imgFrame.find(_child + ":gt("+_nLast+")").show().prependTo(_imgFrame);
        _imgFrame.css("marginLeft",_moveDistance);
        _imgFrame.animate({ marginLeft: 0 }, 'fast', '', function() {
            _btnNext.bind("click", turnRight);
            if (_auto) autoPlay();
        });
    };
    _btnNext.css("cursor", "hand").click(turnRight);
    _btnPrev.css("cursor", "hand").click(turnLeft);

    var autoPlay = function() {
        _itv = window.setInterval(turnLeft,_timer);
    };
    var autoStop = function() {
        window.clearInterval(_itv);
    };
    if (_auto) autoPlay();
};

//选项卡切换
function tabSwitching(tabIndex,tabsSelector,conSelector,activeName){
	var num=$(tabsSelector).length;
	for (var i=0;i<num;i++) {
		if ($(conSelector+":eq("+i+")").css("display")!="none"&&i==tabIndex) return; 
	}
	for (var i=0;i<num;i++) {
		if (tabIndex==i) {	
			$(tabsSelector+":eq("+i+")").addClass(activeName);
			$(conSelector+":eq("+i+")").show();
		} else {
			$(tabsSelector+":eq("+i+")").removeClass(activeName);
			$(conSelector+":eq("+i+")").hide();
		}
	}
}

function singleLineTextS(selector){
	if ($(selector).parent().width()<$(selector).width()){		
		var mLeft=parseInt($(selector).css("margin-left"));
		if ($(selector).parent().width()>$(selector).width()+mLeft+40) {$(selector).css("margin-left",0);}	
		else $(selector).css("margin-left",mLeft-5);
	}
}

//jQuery Cookie插件
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { 
        options = options || {};
        if (value === null) {
            value = '';
            options = $.extend({}, options);
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString();
        }        
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else {
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);                
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

//datepicker初始化
function datepickerIni(selector){
	$(selector).datepicker({monthNames: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayNamesMin: ["日","一","二","三","四","五","六"],dateFormat:"yy-mm-dd"})
}
function datepIniChange(selector,start,end) {
	var stryearRange;
	if (/^[1-9]d*|0$/.test(start)) stryearRange=start+":"+end;
	else if (start=="birth") stryearRange="1960:2010";
	else if (start=="coins") stryearRange="2012:2016";
	else if (start=="Eindate") stryearRange="1980:2013";
	else if (start=="EPbirth") stryearRange="1960:2013";
	else if (start=="indate") stryearRange="2012:2016";
	$(selector).datepicker({changeYear:true,changeMonth:true,yearRange:stryearRange,monthNamesShort: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],dayNamesMin: ["日","一","二","三","四","五","六"],dateFormat:"yy-mm-dd"});
}
//今天日期
function todayDate(type){
	var timer=new Date();
	var day="";
	switch(timer.getDay()) {
	  case 0: day="日";break;
	  case 1: day="一";break;
	  case 2: day="二";break;
	  case 3: day="三";break;
	  case 4: day="四";break;
	  case 5: day="五";break;
	  case 6: day="六";break;
	}
	var Timer="";
	if(type=="YMD") {Timer=timer.getFullYear()+"年"+(timer.getMonth()+1)+"月"+timer.getDate();return Timer;}
	if(type=="YMDW") {Timer=timer.getFullYear()+"年"+(timer.getMonth()+1)+"月"+timer.getDate()+"日  星期"+day;return Timer;}
	if(type=="YMDHM") {
		Timer=timer.getFullYear()+"年"+(timer.getMonth()+1)+"月"+timer.getDate()+"日  "+timer.getHours()+":"+timer.getMinutes();
		return Timer;
	}
}

//侧边栏伸缩
function sidebarSF(n){
	$(".zy_lt").next("div").hide();
	$(".zy_lt:eq("+n+")").next("div").show(); 
	$(".zy_lt:eq("+n+")").find("img:first").attr("src","/img/jian.png");
	$(".zy_lt").click(function(){
		$(this).next("div").slideToggle(300);
		var src = $(this).find("img:first").attr("src");
		if(/jian/.test(src)){
			$(this).find("img:first").attr("src", "/img/jia.png");
		} else {
			$(this).find("img:first").attr("src", "/img/jian.png");
		}
	});
}

//隐藏DIV弹出层
function bgKuang(divS,btnC,divOffset){	
    if ($("#bgKuang").length==1) {				
		$(".jsxxxqB").hide();
		var bgW=$(document).width();if ($(document).width()<screen.availWidth) bgW=screen.availWidth; 
	} else {
		$("body").append("<div id='bgKuang'></div>");
		var bgW=$(document).width();if ($(document).width()<screen.availWidth) bgW=screen.availWidth; 
		var bgH=$(document).height();if ($(document).height()<screen.availHeight) bgH=screen.availHeight; 
		$("#bgKuang").css({width:"100%",height:bgH});
		$("#bgKuang").fadeTo(200,0.5);
	}
	
	$(divS).show();		
	if ($(window).height()>$(divS).height()) var divST=$(window).scrollTop()+($(window).height()-$(divS).height())/2+"px";
	else var divST=$(window).scrollTop()+160+"px";
	var divSL=(bgW-$(divS).width())/2+"px";
	$(divS).css({"top":divST,"left":divSL});
	var newBgH=parseInt($(divS).css("top"))+$(divS).height()+100;
	if (bgH<newBgH) $("#bgKuang").css("height",newBgH);
	
	if(divOffset==null) divOffset=".zy_z .mebleft";
	$(btnC).live("click",function(e){
		e.preventDefault();		
		$("#bgKuang").fadeOut("fast",function(){
			$("#bgKuang").remove();
		});
		$(divS).hide();	
		if ($(divOffset)!=null&&$(divOffset).offset()!=null) {
			var wST=$(divOffset).offset().top;
			if ($(window).scrollTop()>wST) $("html,body").animate({scrollTop:wST},"normal");
		}
	});
}

//输入字符验证
function onlyNum(Selector){
	Selector.value=Selector.value.replace(/[^0-9]/g,'')
}
function phoneNum(Selector){
	Selector.value=Selector.value.replace(/[^0-9\-]/g,'')
}
function coinNum(Selector){
	Selector.value=Selector.value.replace(/[^0-9\.]/g,'')
}
function letterNum(Selector){
	Selector.value=Selector.value.replace(/[^0-9A-Za-z]/g,'')
}
function Emailstr(Selector){
	Selector.value=Selector.value.replace(/[^0-9A-Za-z\.\-\_\@\:]/g,'')
}