// JavaScript Document
$(document).ready(function(){
	if ($(".sysDisplayErrorMsg").length!=0) {
	   alert("没有此详细信息！点击确定后将关闭页面。");
	   closeWindow();
	}
	$(".con_2_table tbody tr:odd,.conTable3 tbody tr:odd").addClass("even");
	var tClass=window.setInterval(function(){if (!$(".con_2_table tbody tr:odd:eq(0)").hasClass("even")) {
			$("input:text").addClass("inpTextBox");
			$(".con_2_table tbody tr:odd,.conTable3 tbody tr:odd").addClass("even");
	}},1000);	
	
	$("input:text").live("keydown",function(e){
		e.keyCode==13 ? e.preventDefault() : true;
	});
	
	$("#myTab2 li").mouseenter(function(){
		var tabIndex=$("#myTab2 li").index(this);
		tabSwitching(tabIndex,"#myTab2 li",".myTab1_Content2","active3");
	});
	
	$(".toptoolLogout").live("click",function(e){
		$.cookie("usename",null);
		window.open("zhuce.html","_self");
		e.preventDefault();
	});
		
	$("#closeKuang,#quxiaoKuang,#payWancheng,#payShibai,.payShortage").live("click",function(e){
		e.preventDefault();
		$("#goumaikuang").remove();
		$("#bgKuang").fadeOut("fast");
	});	
	
	$("#closeKuang").live("click",function(e){
		e.preventDefault();
	});	
	$("#mebUpgrade").click(function(e){
		e.preventDefault();
		mebUpgrade();
	});
	
	$(".sltSearchTil").mouseenter(function(){
		searchName(".sltSearchTil","ul.sltSearch",".spanSearchWrap","ul.sltSearch li a",".mbSearchR");
	});
	
	$(".btnAddFri").click(function(e){
		e.preventDefault();
		$(".ddAddFri").toggle("fast");
	});
	
	//会员页面，左半部分，导航提示，如果是初级会员提示升级
	$('a.elementary').click(function(){
		if (confirm("您目前是初级会员，无法使用此项功能，是否免费升级为高级会员？")) {
			location.href = "/members/upgrade";
		}
		return false;
	});
	
	//简历表格高度
	$("table.preview").each(function(){
		if ($(this).find("img").length>0) $(this).addClass("previewTH");
	});	
	
	var zy_zBottomRcdT;
  $(".myTab1_Content2 li a").hover(function(){
	  $(this).parent().css("text-overflow","clip");
	  var selector=".myTab1_Content2 ul li a:eq("+$(".myTab1_Content2 ul li a").index(this)+")";
	  $(".zy_r .con_3 span:eq("+$(".myTab1_Content2 ul li a").index(this)+")").hide();
	  zy_zBottomRcdT=window.setInterval(function(){singleLineTextS(selector);},200);
  },function(){
	   $(this).parent().css("text-overflow","ellipsis");
	   $(this).css("margin-left",0);
	   window.clearInterval(zy_zBottomRcdT);
	   $(".zy_r .con_3 span:eq("+$(".myTab1_Content2 ul li a").index(this)+")").show();
  });
  $(".zy_rzj_tt li a").hover(function(){
	  $(this).parent().css("text-overflow","clip");
	  var selector=".zy_rzj_tt ul li a:eq("+$(".zy_rzj_tt ul li a").index(this)+")";
	  zy_zBottomRcdT=window.setInterval(function(){singleLineTextS(selector);},200);
  },function(){
	   $(this).parent().css("text-overflow","ellipsis");
	   $(this).css("margin-left",0);
	   window.clearInterval(zy_zBottomRcdT);
  });
  $(".zy_z .bottomRcd .fl a").hover(function(){
	  $(this).parent().css("text-overflow","clip");
	  var selector=".zy_z .bottomRcd .fl a:eq("+$(".zy_z .bottomRcd .fl a").index(this)+")";
	  zy_zBottomRcdT=window.setInterval(function(){singleLineTextS(selector);},200);
  },function(){
	   $(this).parent().css("text-overflow","ellipsis");
	   $(this).css("margin-left",0);
	   window.clearInterval(zy_zBottomRcdT);
  });
  
  $("#comment_content").keydown(function(e){
	  if (e.keyCode==13) $(".infoComments .btnReply").click();
	});
});