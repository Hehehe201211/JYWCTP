// JavaScript Document
$(document).ready(function(){
	$(".con_2_table tbody tr:odd,.conTable3 tbody tr:odd").addClass("even");
	var tClass=window.setInterval(function(){if (!$(".con_2_table tbody tr:odd:eq(0)").hasClass("even")) {
			$("input:text").addClass("inpTextBox");
			$(".con_2_table tbody tr:odd,.conTable3 tbody tr:odd").addClass("even");
	}},1000);	
	
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
	
	//是否看过
	$(".con_2_tr td").each(function() {
       $(this).eq(0).find("a").css("font-weight","bold"); 
    });
	$(".con_2_xq_tofu a").each(function() {
       $(this).css("font-weight","normal"); 
    });
	$(".con_2_tr th a,.con_2_tr td a").live("click",function(){
		$(this).parent().parent().find("a").css("font-weight","normal");
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
});