<script type="text/javascript">
{literal}
$(document).ready(function(){
    var checkTarget = ['title','introduction'];
	var checkTargetF = ['document'];
    var errorMsg = '<span class="errorMsg">请完善此项目</span>';
	$("#check").click(function(){
		var error=0;
		$.each(checkTarget, function(target){		    
			if($('#' + this).val() == "") {
				if($('#' + this).parents(".sjle dl dt").find('.errorMsg').length == 0) {
					$('#' + this).parents(".sjle dl dt").append(errorMsg);
				}
				error=1;
			} else {
				$('#' + this).parents(".sjle dl dt").find('.errorMsg').remove();
			}
		});	
		$.each(checkTargetF, function(target){		    
			if($('#' + this).val() == "") {
				if ($('#' + this).next().find('.errorMsg').length == 0) {
					$('#' + this).next().append(errorMsg);
				}
				error=1;
			} else {
				$('#' + this).next().find('.errorMsg').remove();
			}
		});		
				
		if (!error) {
			$("#documentForm").submit();
		}
	});
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
            <a href="javascript:void(0)">企业服务</a>&gt;&gt;
            <a href="javascript:void(0)">文档资料上传</a>
        </p>
    </div>
    <div class="biaotit">文档资料上传</div>
    <div class="sjle">
	  <form action="/services/saveDocument" method="post" id="documentForm" enctype="multipart/form-data">
	  {if isset($document)}
        <dl>
            <dt>
                <label><font class="facexh">*</font>文档标题：</label>
                <input type="text" name="title" id="title" value="{$document.Service.title}">
                <input type="hidden" name="id" id="id" value="{$document.Service.id}">
            </dt>
        <dt>
        <label><font class="facexh">*</font>上传文档：</label>
        <input type="file" name="document" id="document"/> <p class="imgfilesize">（文档文件大小不超过2M）</p>       
        <input type="hidden" name="old_document_path" value="{$document.Service.document_path}" />
        </dt>
        <dt>
            <label><font class="facexh">*</font>资料说明：</label>
            <textarea name="introduction" id="introduction">{$document.Service.introduction}</textarea>
        </dt>   
        </dl>
        {else}
        <dl>
            <dt>
                <label><font class="facexh">*</font>文档标题：</label>
                <input type="text" name="title" id="title">
            </dt>
        <dt>
        <label><font class="facexh">*</font>上传文档：</label>
        <input type="file" name="document" id="document"/> <p class="imgfilesize">（文档文件大小不超过2M）</p>       
        </dt>
        <dt>
            <label><font class="facexh">*</font>资料说明：</label>
            <textarea name="introduction" id="introduction"></textarea>
        </dt>   
        </dl>
        {/if}
		</form>
        <a id="check" href="javascript:void(0)" class="zclan zclan4">保存</a>
    </div>
</div>
