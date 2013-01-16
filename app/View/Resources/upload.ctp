<script type="text/javascript">
{literal}
$(document).ready(function(){
	$(".corFU .btnUpload").click(function(){
		$(".titleFU .btnUpload").click();
	});
	$('.corFU .btnCommit').live('click', function(){		
       if (!errorV()) $('#documentForm').submit();
    })
    $(".corFU .divCorFU .deleFile").live("click",function(){
        if(confirm("确定删除该文档？")) $(this).parents(".corFU .divCorFU").slideUp("fast",function(){
            $(this).parents(".corFU .divCorFU").remove();
        });
    });
    $(".corFU .divCorFU .ctrlText").live("click",function(){
        $(this).toggleClass("active");
        $(this).parent().parent().next().slideToggle("fast");
        if ($(this).text()=="收起") $(this).text("展开");
        else $(this).text("收起");
    });
    $(".itemBd .btnInfo").live("click",function(){
        
    }); 
    $(".titleFU .btnUpload").click(function(){
		$(" .corFU .divCorFU:last").after($(".fileUpload > .divCorFU").clone());
		$(".corFU .divCorFU").last().show();
		$("html,body").animate({scrollTop:$(".corFU .divCorFU").last().offset().top},"normal");
	});    
    $('.btnInfo').live('click', function(){        
		var errorMsg = '<span class="errorMsg">请输入此项目</span>';		
		var error=0;
		$(this).parents('.corFU .divCorFU').find('input').not('.keyword').each(function(index,element){
			if($(element).val() == "") {				
				$(element).parent().append(errorMsg);
				error=1;
			} else {
				$(element).parent().find('.errorMsg').remove();
			}
		});
		var txta=$(this).parents('.corFU .divCorFU').find('textarea');
		if($(txta).val() == "") {
			$(txta).parent().append(errorMsg);
			error=1;
		} else {
			$(txta).parent().find('.errorMsg').remove();
		}
		
		var slt=$(this).parents('.corFU .divCorFU').find('select');
		if($(slt).val() == "") {
			$(slt).parent().append(errorMsg);
			error=1;
		} else {
			$(slt).parent().find('.errorMsg').remove();
		}
       if (!error) $('#documentForm').submit();
    })
});
{/literal}
</script>
<div class="main">
  <div class="conResource">
    <div class="crumbsNav"><a href="plt-zytd.html">资源天地</a>&nbsp;&gt;&nbsp;上传文档</div>
    <div class="fileUpload">
      <div class="titleFU"> <a href="javascript:;" class="fr btnCommit" onclick="alert('文档上传成功。');window.open('plt-zytdI-center.html','_self');">完成上传</a><a href="javascript:;" class="fr btnUpload">添加文档</a>
        <h2>上传文档</h2>
      </div>
      <div class="divCorFU" style="display:none;">
          <div class="itemHd">
            <div>
            <a href="javascript:void(0);" class="deleFile">&nbsp;</a>
                <span >&nbsp;</span>
                <span >&nbsp;</span>
            </div>
            <div>
                <a href="javascript:void(0);" class="ctrlText">收起</a>
                <span>&nbsp;</span>
            </div>
          </div>
          <div class="itemBd">
            <div>标题<font class="facexh">*</font>：</div>
            <div>
              <input type="text" name="title[]"/>
            </div>
            <div>文档文件<font class="facexh">*</font>：</div>
            <div>
              <input type="file" name="file[]"/>
            </div>           
            <div>简介<font class="facexh">*</font>：</div>
            <div>
              <textarea name="introduction[]"></textarea>
            </div>            
            <div><span>分类<font class="facexh">*</font>：<select name="type[]">
                        <option value="">选择分类</option>
                        <option value="1">入门成长</option>
                        <option value="2">培训课件</option>
                        <option value="3">客户管理</option>
                        <option value="4">方案模板</option>
                        <option value="5">总结计划</option>
                        <option value="6">案例分析</option>
                    </select></span>
                    <span>页数<font class="facexh">*</font>：<input type="text" name="pages[]" class="inpTextBoxNum" onkeyup="onlyNum(this)" onpaste="onlyNum(this)"/>页</span>
                    <span>售价<font class="facexh">*</font>：<input type="text" class="inpTextBoxNum" name="point[]" onkeyup="onlyNum(this)" onpaste="onlyNum(this)"/>分</span></div>
            <div>关键词：</div>
            <div>
              <input type="text" name="keyword[]" class="keyword"/>
            </div>
            </div>
        </div>
      <form method="post" action="/resources/finish" id="documentForm" enctype="multipart/form-data">
      <div class="corFU">
        <div class="divCorFU">
          <div class="itemHd">
            <div>
                <a href="javascript:void(0);" class="deleFile">&nbsp;</a>
                <span >&nbsp;</span><span >&nbsp;</span>
            </div>
            <div>
                <a href="javascript:void(0);" class="ctrlText">收起</a>
                <span class="tip"></span>
            </div>
          </div>
          <div class="itemBd">
            <div>标题<font class="facexh">*</font>：</div>
            <div>
                <input type="text" name="title[]"/>
            </div>
            <div>文档文件<font class="facexh">*</font>：</div>
            <div>
                <input type="file" name="file[]"/>
            </div>           
            <div>简介<font class="facexh">*</font>：</div>
            <div>
                <textarea name="introduction[]"></textarea>
            </div>
            <div><span>分类<font class="facexh">*</font>：<select name="type[]">
                        <option value="">选择分类</option>
                        <option value="1">入门成长</option>
                        <option value="2">培训课件</option>
                        <option value="3">客户管理</option>
                        <option value="4">方案模板</option>
                        <option value="5">总结计划</option>
                        <option value="6">案例分析</option>
                    </select></span>
                    <span>页数<font class="facexh">*</font>：<input type="text" name="pages[]" class="inpTextBoxNum" onkeyup="onlyNum(this)" onpaste="onlyNum(this)"/>页</span>
                    <span>售价<font class="facexh">*</font>：<input type="text" class="inpTextBoxNum" name="point[]" onkeyup="onlyNum(this)" onpaste="onlyNum(this)"/>分</span></div>            
            <div>关键词：</div>
            <div>
                <input type="text" name="keyword[]" class="keyword"/>
            </div>
            </div>
        </div>
        <div class="divBtnContainer" style="width:236px"><a href="javascript:;" class="fr btnCommit">完成上传</a><a href="javascript:;" class="fr btnUpload">添加文档</a></div>
      </div>
    </form>
</div>
    <div class="uploadNotice">
      <dl class="mb10">
        <dt>上传须知</dt>
        <dd>每次最多上传20份文档，每份文档不超过20M，支持大部分文档格式</dd>
        <dd>上传涉及侵权内容的文档将会被移除。如何判断文档是否侵权？查看<a target="_blank" href="#">资源协议</a>和<a target="_blank" href="#">用户规则</a></dd>
        <dd>上传有问题需要帮助？查看资源帮助和论坛资源天地区</dd>
        <dd>为了保证文档能正常显示，我们支持以下格式的文档上传</dd>
      </dl>
      <table class="supportType">
        <tbody>
          <tr>
            <td class="txtR">MS Office文档</td>
            <td><span class="spanFileFormat">&nbsp;</span>doc,docx<span class="spanFileFormat spanFFppt">&nbsp;</span>ppt,pptx<span class="spanFileFormat spanFFxls">&nbsp;</span>xls,xlsx<span class="spanFileFormat spanFFvsd">&nbsp;</span>vsd<span class="spanFileFormat spanFFpot">&nbsp;</span>pot<span class="spanFileFormat spanFFpps">&nbsp;</span>pps<span class="spanFileFormat spanFFrtf">&nbsp;</span>rtf</td>
          </tr>
          <tr>
            <td class="txtR">WPS office系列</td>
            <td><span class="spanFileFormat spanFFwps">&nbsp;</span>wps<span class="spanFileFormat spanFFet">&nbsp;</span>et<span class="spanFileFormat spanFFdps">&nbsp;</span>dps</td>
          </tr>
          <tr>
            <td class="txtR">PDF</td>
            <td><span class="spanFileFormat spanFFpdf">&nbsp;</span>pdf</td>
          </tr>
          <tr>
            <td class="txtR">纯文本</td>
            <td><span class="spanFileFormat spanFFtxt">&nbsp;</span>txt</td>
          </tr>
          <tr>
            <td class="txtR">EPUB</td>
            <td><span class="spanFileFormat spanFFepub">&nbsp;</span>epub</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  {if !empty($memberInfo)}
  {$this->element('resource/left_logined')}
  {else}
  {$this->element('resource/left')}
  {/if}
</div>