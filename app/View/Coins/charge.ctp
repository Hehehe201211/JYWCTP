<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.delete').live('click', function(){
        if (confirm('您确定要删除此信息？')) {
            $parent = $(this).parent().parent();
            var order_no = $parent.find('.order_no').text();
            $.ajax({
                url : '/coins/delete',
                type : 'post',
                data : 'order_no=' + order_no,
                success : function(data) {
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        $parent.remove();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
	$("#submit").click(function(){
		if (parseInt($('#topupNum').val()) ==0||$('#topupNum').val()=="") {
			alert("请输入充值金额。");
			return false;
		}
		if (parseInt($('#topupNum').val())>500) {
			alert("充值金额超过500元。");
			return false;
		} else if ($("#iagree").attr("checked")!="checked") {
			alert("请接受协议。");
			return false;
		}
	});
});
//{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">业务币管理</a>&gt;&gt;
      <a href="javascript:void(0)">余额充值</a>
      </p>
    </div>
    <div class="zhanghujil">        
        <div class="rightBody">
        <div class="biaotit">余额</div>
          <p>当前账户：<span class="zwzi">{$memberInfo.Member.nickname}</span></p>
          <p>业务币余额：￥<span class="zwzi">{$balance.MemberAttribute.virtual_coin}</span> 元&nbsp;&nbsp;<a class="rightBody_a" href="/coins/expend">提现&gt;&gt;</a></p>
          <p>聚业务积分：<span class="zwzi">{$balance.MemberAttribute.point}</span> 点&nbsp;&nbsp;<a class="rightBody_a" href="/points/charge">充值&gt;&gt;</a></p>
        </div>
      </div>
     <div class="zhanghujil">        
        <div class="rightBody">
         <div class="biaotit">充值</div>
        <form method="post" action="/alipays/check">
          <p>您的账户：<font color="#FF0000">{$memberInfo.Member.nickname}</font> （请确认账号为您需要充值的账号）</p>
          <p>充值金额:<input type="text" id="topupNum" name="price" class="inpTextBox" onkeyup="onlyNum(this)" onpaste="onlyNum(this)">元&nbsp;（1元人民币=1元业务币，每次充值金额不高于500元）</p>
          <p>
            <label>
              <input type="checkbox" autocomplete="off" value="" name="iagree" id="iagree" class="inpCheckbox" checked="checked">我已仔细阅读过
              <a style="color:#f30;" target="_blank" href="/static?tpl=mianze">《聚业务服务暂定协议》</a>。
            </label>
          </p>
        <div style="TEXT-ALIGN: center">
          <button style="MARGIN: 5px 0px" type="submit" id="submit">请勾选上述条款，进入下一步</button>
        </div>
        </form>
        <div class="biaotit">充值记录</div>
        <div id="result">
        {$form = ['isForm' => true, 'inline' => true]}
        {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
        {$this->Paginator->options($options)}
        {$paginatorParams = $this->Paginator->params()}
      <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
      <thead>
        <tr class="con_2_tr con_2_xq_too"> 
          <th class="tr_td5">途径 </th>
          <th class="tr_td2">交易号 </th>
          <th class="tr_td2">金额 </th>
          <th class="tr_td7">时间 </th>
          <th class="tr_td4">状态 </th>
          <th class="tr_td8">选择操作 </th>
        </tr>
        </thead>
        <tbody>
        {foreach $charges as $charge}
        <tr class="con_2_tr">
          <td class="tr_td5">{if $charge.AlipayCharge.payment_type == 1}支付宝{else}未知{/if}</td>
          <td class="tr_td5 order_no">{$charge.AlipayCharge.order_no}</td>
          <td class="tr_td2">{$charge.AlipayCharge.price}元</td>
          <td class="tr_td7">{$charge.AlipayCharge.created}</td>
          <td class="tr_td4">
          {if $charge.AlipayCharge.status == Configure::read('Alipay.status_confirm')}
          处理中
          {elseif $charge.AlipayCharge.status == Configure::read('Alipay.status_success')}
          充值成功
          {elseif $charge.AlipayCharge.status == Configure::read('Alipay.status_failure')}
          充值失败
          {else}
          未知
          {/if}
          </td>
          <td class="con_2_xq_tofu tofu_anniu">
          <a href="javascript:void(0)" class="delete">删除记录</a>
          </td>
        </tr>
        {/foreach}
      </tbody>
      </table>
            {if $paginatorParams['pageCount'] > 1}
              <div class="fanyea">
                <form id="searchOpt">
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
                            <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                            <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                            <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
                        </div>
                        {if $paginatorParams['nextPage']}
                            <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
                        {/if}
                </form>
                </div>
            {/if}
            {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
            {$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
            {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
            {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
            {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
            {$this->Js->writeBuffer()}
            </div>
        </div>  
      </div>
</div>