<script type="text/javascript">
{literal}
$(document).ready(function(){
    /*$(".btnAddFri").click(function(){
		$(this).parents(".mebBaseinfo").find(".mebBaseinfoR dd").toggle();
	});*/
	var errorMsg = '<span class="errorMsg">请输入此项目</span>';
	var checkTarget = ['title', 'content'];
    $('#sendMsg').click(function(){
		var error=0;
		$.each(checkTarget, function(target){
			if($('#' + this).val() == "") {
				$('#' + this).parent('dd').append(errorMsg);
				error=1;
			} else {
				$('#' + this).parent('dd').find('.errorMsg').remove();
			}
		});
		if (!error) {
			$.ajax({
				url : '/sms/addMsg',
				type : 'post',
				data : $('#msgForm').serializeArray(),
				success : function(data) {
					var result = eval("("+data+")");
					var date = new Date();
					date = date.getFullYear() + '-' + date.getMonth()+1 + '-' + date.getDate();
					if (result.result == "OK") {						
						var str = '<div class="comment"><div class="name sender">我</div><div class="time">' +date +'</div><div class="content">'+ $('#content').val() + '</div></div>';
						$('.infoComments').prepend(str);
						$('#title').val("");
						$('#content').val("");
						alert(result.msg);
					  } else {
						alert(result.msg);
					}
				}
			});
		}
    });
});
//{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0">好友管理</a>&gt;&gt;
      <a href="javascript:void(0)">好友联系</a>
      </p>
    </div>
    <div class="mebBaseinfo">
        <div class="mebBaseinfoL">
          <table width="100%" height="100%" border="0">
            <tr>
              <td width="34%" rowspan="6">
              {if !empty($firend.Attribute.thumbnail)}
                {$thumbnail = Configure::read('Data.path')|cat:$firend.Attribute.thumbnail}
                {if file_exists($thumbnail)}
                    <img src="{$this->webroot}{$firend.Attribute.thumbnail}">
                {else}
                    <img src="{$this->webroot}img/tx.jpg">
                {/if}
              {else}
              <img src="{$this->webroot}img/tx.jpg">
              {/if}
              </td>
              <td width="66%"><!--<a href="javascript:;" class="btnAddFri">修改备注</a>-->会员名称：{$firend.Member.nickname}</td>
            </tr>
            <tr>
              <td>公司名称：{$firend.Attribute.name}</td>
            </tr>
            <tr>
              <td>行业：{$this->Category->getCategoryName($firend.Attribute.category_id)}</td>
            </tr>
            <tr>
              <td>发布信息数：{$sendCount}次</td>
            </tr>
            <tr>
              <td>交易次数：{$transactionCount}次</td>
            </tr>
            <tr>
              <td>好评率：100%</td>
            </tr>
          </table>
        </div>
        <div class="mebBaseinfoR">
          <dl>
            <dd style="display:none"><input type="text" value="请输入备注名" onfocus="this.select();" placeholder="请输入备注名"/>
            <input type="button" value="修改" onclick="javascript:alert('备注成功。');"/></dd>
          </dl>
        </div>
      </div>    
    <div class="biaotit">与<em>{$firend.Member.nickname}</em>的联系记录</div>
    <div class="znx">
        <dl>
        <form id="msgForm">
          <dd>
            <label><font class="facexh">*</font>主题：</label><input type="text" name="title" class="inpTextBox" id="title">
          </dd>
          <dd>
            <label><font class="facexh">*</font>内容：</label>
            <textarea name="content" id="content"></textarea>
          </dd>
          <input type="hidden" name="receiver" value="{$this->request->query['fid']}" />
          <input type="hidden" name="type" value="1" />
        </form>
        </dl>
        <a class="zclan zclan4" href="javascript:void(0);" id="sendMsg">发送</a>
        <p class="hx"></p>
        <div id="result">
        <div class="infoComments">
        {$form = ['isForm' => true, 'inline' => true]}
        {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
        {$this->Paginator->options($options)}
        {$paginatorParams = $this->Paginator->params()}
        {foreach $messages as $message}            
              <div class="comment">
              {if $message.StationMessage.sender == $memberInfo.Member.id}
                    <div class="name sender">我</div>                    
              {else}
                    <div class="name">{$message.Member.nickname}</div>
              {/if}        
              <div class="time">{$message.StationMessage.created|date_format:"%Y-%m-%d"}</div>
              <div class="content">{$message.StationMessage.content}</div>
      </div>          
        {/foreach}        
        <form id="searchOpt">
          <div class="fanyea">
            {if $paginatorParams['prevPage']}
                <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
            {/if}
            <div class="dd_ym">
                <label>每页显示：</label>
                <select name="pageSize" id="pageSize">
                    <option value="10" {if $pageSize == "10"} selected {/if}>10</option>
                    <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                    <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                    <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
                </select>
            </div>
            <div class="dd_ym11">
                <font>共{$paginatorParams['count']}条</font>
                <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                <div class="dd_span1"><a href="javascript:void(0)" id="jumpButton">跳转</a></div>
            </div>
            {if $paginatorParams['nextPage']}
                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
            {/if}
          </div>
          </form>
            {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
            {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
            {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
            {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
            {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
            {$this->Js->writeBuffer()}
        </div>
        </div>
      </div>      
</div>