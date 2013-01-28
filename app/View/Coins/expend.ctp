<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".zclan4").click(function(){
		var price=parseInt($("#price").val());
        if (typeof(price)==true) {
            alert("请输入预提现金额。");
		} else if (price<50) {
			alert("请输入不小于50的数值。");
        } else if ($("#price").val()>500) {
            alert("请输入不超过500的数值。");
		} else if ($("#pay_accountN").val()=="") {
            alert("请输入与支付宝账号对应的真实姓名。");
        } else {
            $.ajax({
                url  : '/coins/expend_send',
                type : 'post',
                data : 'price=' + $('#price').val() + '&pay_account=' + $('#pay_account').val() + '&pay_name=' + $('#pay_accountN').val(),
                async : false,
                success : function(data) {
                    var result = eval("("+data+")");
                    if (result.result != 'OK') {
                        alert(result.msg);
                    }
                    location.href = location.href;
                }
            });
        }
    });
	$("#pay_account").focus(function(){
		$(this).after($(".errorMsg"));
		$(".errorMsg").text("若需要变动支付宝账号，请到账户安全中心修改后操作提现。").width(174);
	});
	$("#pay_accountN").focus(function(){
		$(this).after($(".errorMsg"));
		$(".errorMsg").text("请确认支付宝真实姓名与账号对应，避免提现失败。").width(174);
	});
	$("#price").focus(function(){
		$(this).after($(".errorMsg"));
		$(".errorMsg").text("50元起提，提现金额为整数，不超过500元。").width(234);
	});
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
            <a href="javascript:void(0)">聚客币管理</a>&gt;&gt;
            <a href="javascript:void(0)">提现</a>
        </p>
    </div>
    <div class="biaotit">申请提现</div>
    <div class="sjle withdraw">
        <ul>
            <li>
                <label><font class="facexh">*</font>我的账户余额：</label>
                <span class="red14Bold">￥{$memberInfo.Attribute.virtual_coin}元</span>  
            </li>
            <li>
                <label><font class="facexh">*</font>核对您的支付宝账号：</label>
                <input type="text" value="{$memberInfo.Attribute.pay_account}" readonly="readonly" class="inpTextBox" id="pay_account">
                <span class="errorMsg" style="width:174px;">若需要变动支付宝账号，请到账户安全中心修改后操作提现。</span>
            </li>
			<li>
          <label><font class="facexh">*</font>请输入支付宝的真实姓名：</label>
          <input type="text" value="" class="inpTextBox" name="pay_name" id="pay_accountN">
          </li>
            <li>
                <label><font class="facexh">*</font>本次提现金额（元）：</label>
                <input type="text" class="sum inpTextBox" id="price" name="price" onkeyup="onlyNum(this)" onpaste="onlyNum(this)"/>
            </li>
            <li>
                <a href="javascript:void(0);" class="zclan zclan4">确定</a>
            </li>
        </ul>
    </div>
    <div class="biaotit">提现记录</div>
    <div id="result">
        {$form = ['isForm' => true, 'inline' => true]}
        {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
        {$this->Paginator->options($options)}
        {$paginatorParams = $this->Paginator->params()}
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
            <thead>
                <tr class="con_2_tr con_2_xq_too">
                    <th class="tr_td2">交易号</th>
                    <th class="tr_td5">提现账号</th>
                    <th class="tr_td2">金额 </th>
                    <th class="tr_td7">时间 </th>
                    <th class="tr_td4">状态 </th>
                    <th class="tr_td8">选择操作 </th>
                </tr>
            </thead>
            <tbody>
            {foreach $expends as $expend}
                <tr class="con_2_tr">
                    <td class="tr_td2 order_no">{$expend.AlipayExpend.order_no}</td>
                    <td class="tr_td5">{$expend.AlipayExpend.pay_account}</td>
                    <td class="tr_td2">{$expend.AlipayExpend.price}元</td>
                    <td class="tr_td7">{$expend.AlipayExpend.created|date_format:"%Y-%m-%d"}</td>
                    <td class="tr_td4">
                    {if $expend.AlipayExpend.status == Configure::read('Alipay.status_confirm')} 
                    &nbsp;等待处理
                    {elseif $expend.AlipayExpend.status == Configure::read('Alipay.status_success')}
                    &nbsp;提现成功
                    {elseif $expend.AlipayExpend.status == Configure::read('Alipay.status_failure')}
                    &nbsp;提现失败
                    {elseif $expend.AlipayExpend.status == Configure::read('Alipay.status_report')}
                    &nbsp;提现处理中
                    {else}
                    &nbsp;未知
                    {/if}
                    </td>
                    <td class="con_2_xq_tofu tofu_anniu">
                        {if $expend.AlipayExpend.status == Configure::read('Alipay.status_confirm')}
                        <a href="javascript:void(0)" class="cancel">取消提现</a>
                        {elseif $expend.AlipayExpend.status != Configure::read('Alipay.status_report')}
                        <a href="javascript:void(0)" class="delete">删除记录</a>
                        {/if}
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