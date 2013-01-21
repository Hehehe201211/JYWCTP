$(document).ready(function(){	
     $(".switchBox .divTable input:checkbox").attr("checked",false);
	$(".switchBox .inpButton").click(function(){
		$(this).parent().next().toggle();
		if ($(".switchBox .divTable:visible").length==0) $(".inviteJobB .ulCompany1 li").css("z-index",0);
		else $(".inviteJobB .ulCompany1 li").css("z-index",-1);
	});
	$(".goback a").click(function(e){
		e.preventDefault();
		$(this).parent().next().find(".options").show();
		$(this).parent().next().find(".subOptions").hide();
	});
	//打开子目录
	$(".city .options input:checkbox,.product .options input:checkbox").live("click",function(){
		$(this).attr("checked",false);
		var parent=$(this).parents(".options");
		parent.hide();
		if ($(this).parents(".lists").hasClass("city"))	{
			var parentName = $(this).parent().text();
			var parent_id = $(this).parent().find('.inpCheckbox').val();
			var strCity = loadSubCity(parentName, parent_id);
			parent.next().html(strCity);
		}
		if ($(this).parents(".lists").hasClass("product"))	{
			var parentName = $(this).parent().text();
			var parent_id = $(this).parent().find('.inpCheckbox').val();
			var strProduct = loadSubCategory(parentName, parent_id)
			parent.next().html(strProduct);
		}
		parent.next().show();
		var optsSel=$(this).parents(".divTable>dl").find(".selected input");
		var optsSub=parent.next().find("input");
		if (optsSel.length!=0) {
			for (i=0;i<optsSel.length;i++) {
				for (j=0;j<optsSub.length;j++) {
					if (optsSel.eq(i).val()==optsSub.eq(j).val()) optsSub.eq(j).attr("checked",true);
				}
			}
		}
	});	
	//选择项目
	$(".city .subOptions input:checkbox,.trade .options input:checkbox,.product .subOptions input:checkbox").live("click",function(){
		  var selected=$(this).parents(".divTable>dl").find(".selected");
		  selected.show();
		  var ddSelected=selected.find("dd");
		  if (ddSelected.length==0) {
			  $(this).attr("checked",true);
			 selected.append("<dd><label>"+$(this).parent().html()+"</label></dd>");
			 return;
		  }	  
		  for (i=0;i<ddSelected.length;i++) {
			  if (ddSelected.eq(i).find("input").val()==$(this).val()) {
				  $(this).attr("checked",false);	
				  ddSelected.eq(i).remove();
				  if (ddSelected.length==0) selected.hide();
				  return;		
			  }
		  }
		  if (ddSelected.length==5) {
			  $(this).attr("checked",false);	
			  alert("你已经选择5个项目。");
		  } else {
			  $(this).attr("checked",true);
			  selected.append("<dd><label>"+$(this).parent().html()+"</label></dd>");
		  }
	});		
	$(".selected  input:checkbox").live("click",function(){
		if ($(this).parents(".divTable>dl").find(".subOptions").length==1) var optsSel=$(this).parents(".divTable>dl").find(".subOptions input:checkbox:checked");
		else var optsSel=$(this).parents(".divTable>dl").find(".options input:checkbox:checked");
		for (i=0;i<optsSel.length;i++) {
			if (optsSel.eq(i).val()==$(this).val()) {
				optsSel.eq(i).attr("checked",false);
				break;
			}
		}
		$(this).parents(".selected dd").remove();		
	});
	$(".divtt .right").click(function(){
		$(this).parents(".divTable").hide();
		var optsSel=$(this).parents(".divTable").find(".selected label");
		if (optsSel.length==0) {
			$(this).parents(".divTable").next().find('li').remove();
			$(this).parents(".divTable").next().hide();
		}
		else {
			if ($(this).parents(".lists").hasClass("city"))	var kind="citys[]";
			if ($(this).parents(".lists").hasClass("trade"))	var kind="categorys[]";
			if ($(this).parents(".lists").hasClass("product"))	var kind="products[]";			
			var txtLi="";
			for (i=0;i<optsSel.length;i++) {
				txtLi+= "<li>"+"<input name='"+kind+"' type='hidden' value='" +optsSel.eq(i).find("input").val() + "' />" +optsSel.eq(i).text()+"</li>";
			}
			$(this).parents(".divTable").next().html(txtLi).show();
		}
		if ($(".switchBox .divTable:visible").length==0) $(".inviteJobB .ulCompany1 li").css("z-index",0);
		else $(".inviteJobB .ulCompany1 li").css("z-index",-1);
	});
	function loadSubCity(parentName, parent_id)
	{
		var strCity="<dd class='dt'><label><input type='checkbox' class='inpCheckbox' value='" + parent_id + "'/> " + parentName + "</label>(选择此大类，将包括以下所有小类)</dd>";
		$.ajax({
			url  : '/informations/getCityList/' + parent_id,
			type : 'post',
			async: false,
			success : function(data){
				var dataobj=eval("("+data+")");
				$.each(dataobj, function(idx, item){
                    strCity+="<dd><label><input type='checkbox' class='inpCheckbox' value='" + item.City.id + "'/> " + item.City.name + "</label></dd>";
                });
			}
		});
		return strCity;
	}	
	function loadSubCategory(parentName, parent_id)
	{
		var subCategory="<dd class='dt'><label><input type='checkbox' class='inpCheckbox' value='" + parent_id + "'/> " + parentName + "</label>(选择此大类，将包括以下所有小类)</dd>"
		$.ajax({
			url  : '/informations/getCategoryList/' + parent_id,
			type : 'post',
			async: false,
			success : function(data){
				var dataobj=eval("("+data+")");
				$.each(dataobj, function(idx, item){
					subCategory += "<dd><label><input type='checkbox' class='inpCheckbox' value='" + item.Category.id + "'/> " + item.Category.name + "</label></dd>"
		        });
			}
		});
		return subCategory;
	}
});