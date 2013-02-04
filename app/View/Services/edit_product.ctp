<script type="text/javascript">
{literal}
$(document).ready(function(){
    var checkTarget = ['title','name','introduction','additional'];
	var checkTargetF = ['small_thumbnail','big_thumbnail'];
    var errorMsg = '<span class="errorMsg">请完善此项目</span>';
	$("#check").click(function(){
		var error=false;
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
		if ($('#id').val() == "") {
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
		}		
		if (!error) {
			$("#productForm").submit();
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
            <a href="javascript:void(0)">产品图片上传</a>
        </p>
    </div>    
    <div class="biaotit">新增产品</div>
    <div class="sjle">
      <form action="/services/saveProduct" method="post" id="productForm" enctype="multipart/form-data">
      {if isset($product)}
        <dl>
            <dt>
                <label><font class="facexh">*</font>产品标题：</label>
                <input type="text" name="title" id="title" value="{$product.Product.title}"/>
                <input type="hidden" name="id" id="id" value="{$product.Product.id}">
            </dt>
            <dt>
                <label><font class="facexh">*</font>产品名称：</label>
                <input type="text" name="name" id="name" value="{$product.Product.name}" />
            </dt>
            <dt>
                <label><font class="facexh">*</font>产品缩览图：</label>
                <input type="file" name="small_thumbnail" id="small_thumbnail"/><p class="imgfilesize">（图片文件大小不超过300K）</p>
                <input type="hidden" name="old_small_thumbnail" value="{$product.Product.small_thumbnail}"/>
            </dt>
            {if !empty($product.Product.small_thumbnail)}
            <dt>
                <label><font class="facexh"></font>现有产品缩览图：</label>
                <img src="{$this->webroot}{$product.Product.small_thumbnail}" />
            </dt>
            {/if}
            <dt>
                <label><font class="facexh">*</font>产品大图：</label>
                <input type="file" name="big_thumbnail" id="big_thumbnail"/><p class="imgfilesize">（图片文件大小不超过300K）</p>
                
                <input type="hidden" name="old_big_thumbnail" value="{$product.Product.big_thumbnail}"/>
            </dt>
            {if !empty($product.Product.big_thumbnail)}
            <dt>
                <label><font class="facexh"></font>现有产品大图：</label>
                <img src="{$this->webroot}{$product.Product.big_thumbnail}" />
            </dt>
            {/if}
            <dt>
                <label><font class="facexh">*</font>产品描述：</label>
                <textarea rows="5" cols="45" name="introduction" id="introduction">{$product.Product.introduction}</textarea>
            </dt>
            <dt>
                <label>相关文档上传：</label>
                <input type="file" name="document" /><p class="imgfilesize">（文档文件大小不超过2M）</p>
                <input type="hidden" name="old_document_path" value="{$product.Product.document_path}"/>
            </dt>  
            <dt>
                <label><font class="facexh">*</font>内容提要：</label>
                <textarea rows="5" cols="45" name="additional" id="additional">{$product.Product.additional}</textarea>
            </dt> 
        </dl>
        {else}
        <dl>
            <dt>
                <label><font class="facexh">*</font>产品标题：</label>
                <input type="text" name="title" id="title"/>
            </dt>
            <dt>
                <label><font class="facexh">*</font>产品名称：</label>
                <input type="text" name="name" id="name"/>
            </dt>
            <dt>
                <label><font class="facexh">*</font>产品缩览图：</label>
                <input type="file" name="small_thumbnail" id="small_thumbnail"/><p class="imgfilesize">（图片文件大小不超过300K）</p>
            </dt>
            <dt>
                <label><font class="facexh">*</font>产品大图：</label>
                <input type="file" name="big_thumbnail" id="big_thumbnail"/><p class="imgfilesize">（图片文件大小不超过300K）</p>
            </dt>
            <dt>
                <label><font class="facexh">*</font>产品描述：</label>
                <textarea rows="5" cols="45" name="introduction" id="introduction"></textarea>
            </dt>
            <dt>
                <label>相关文档上传：</label>
                <input type="file" name="document" /><p class="imgfilesize">（文档文件大小不超过2M）</p>
            </dt>  
            <dt>
                <label><font class="facexh">*</font>内容提要：</label>
                <textarea rows="5" cols="45" name="additional" id="additional"></textarea>
            </dt> 
        </dl>
        {/if}
        </form>
        <a id="check" href="javascript:void(0)" class="zclan zclan4">保存</a>
    </div>
</div>