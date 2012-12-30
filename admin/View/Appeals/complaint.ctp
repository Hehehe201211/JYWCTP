<table id="complaint" width="400px">
</table>
<div id="complaintPage"></div>
<br />

<script type="text/javascript" language="javascript">
{literal}
  $(document).ready(function(){      
      $(".corAppeal .ulAppeal li").live('mouseenter', function(){
        var tabIndex=$(".corAppeal .ulAppeal li").index(this);
        tabSwitching(tabIndex,".corAppeal .ulAppeal li",".corAppeal .conAppeal","active");
		$("#wrap").height(1500);
      });
      $(".tablePTSSXQ .inpRadio:eq(0)").live('click', function(){
        $(".tablePTSSXQ .inpRadio:gt(1),.tablePTSSXQ textarea,.tablePTSSXQ .inpButton").attr("disabled",false);
      });
      $(".tablePTSSXQ .inpRadio:eq(1)").live('click', function(){
        $(".tablePTSSXQ .inpRadio:gt(1),.tablePTSSXQ textarea,.tablePTSSXQ .inpButton").attr("disabled",true);
        $(".tablePTSSXQ .inpButton:eq(1)").attr("disabled",false);
      });
    $('#active').live('click', function(){
        var i=0;
        $("#answer .tablePTSSXQ input:radio").each(function(){
           if ($(this).attr("checked") ==true || $(this).attr("checked") =="checked") i+=1; 
        });
        if(i!=5) {alert("请完成所有选项。");return;}
       
        if (confirm('确定该信息有效，同意申述方的申请？')) {
            //alert('评价成功，该信息有效。');
            $('#result').val(1);
            var formData = $('#answer').serialize();
            $.ajax({
                url: '/admin/answers/add',
                type:'post',
                data:formData + "&",
                success:function(data) {
                    var result = eval("("+data+")");
                    if(result.result == 'OK') {
                        var id = result.appeal_id;
                        /*
                        $('#info').load('/admin/appeals/information', {'id' : id}, function(){
                            
                            $('ul.ulAppeal li').removeClass('avtive');
                            $('ul.ulAppeal li:last').addClass('avtive');
                            $('div.conAppeal').hide();
                            $('div.conAppeal:last').show();
                            
                        });
                        */
                        alert('评价成功，该信息有效。');
                        window.location.reload();
                    } else {
                        alert('系统出错，处理失败，请稍后重试！');
                    }
                }
                
            });
        }
    });
    $('#unactive').live('click', function(){
        var i=0;
        $("#answer .tablePTSSXQ input:radio").each(function(){
           if ($(this).attr("checked") ==true || $(this).attr("checked") =="checked") i+=1; 
        });
        if(i!=5) {alert("请完成所有选项。");return;}
        if (confirm('确定该信息无效，同意投诉方的申请？')) {
            //alert('评价成功，该信息无效。');
            $('#result').val(0);
            var formData = $('#answer').serialize();
            $.ajax({
                url: '/admin/answers/add',
                type:'post',
                data:formData + "&",
                success:function(data) {
                    var result = eval("("+data+")");
                    if(result.result == 'OK') {
                        var id = result.appeal_id;
                        $('#info').load('/admin/appeals/information', {'id' : id}, function(){
                            $('ul.ulAppeal li').removeClass('avtive');
                            $('ul.ulAppeal li:last').addClass('avtive');
                            $('div.conAppeal').hide();
                            $('div.conAppeal:last').show();
                        });
                        
                        alert('评价成功，该信息无效。');
                    } else {
                        alert('系统出错，处理失败，请稍后重试！');
                    }
                }
            });
        }
    });
  });
{/literal}
</script>


<div class="width700" id="info">

</div>