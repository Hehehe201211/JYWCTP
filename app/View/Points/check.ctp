<script type="text/javascript">
{literal}
$(document).ready(function(){
	var price=parseInt($("#price").val())/10;
	$("#price").val(price)
	$("#coins").text(price);
});
//{/literal}
</script>

<div class="zhifu">
    <div class="cashier-box-min">
        <h4>账户充值</h4>
        <form action="/points/send" method="post">
            <table width="100%" class="user-account">
                <tbody>
                    <tr>
                        <th>会员:</th>
                        <td>{$memberInfo.Attribute.name}</td>
                    </tr>
                    <tr>
                        <th>充值账户:</th>
                        <td>{$memberInfo.Attribute.pay_account}</td>
                    </tr>
                    <tr>
                        <th>充值积分:</th>
                        <td><span>{$this->request->data['price']}</span>分</td>
                        <input type="hidden" name="price" value="{$this->request->data['price']}" />
                    </tr>
                    <tr>
                        <th>应付业务币:</th>
                        <td><span id="coins"></span>元</td>
                        <input type="hidden" name="price" id="price" value="{$this->request->data['price']}" />
                    </tr>
                    <tr>
                        <th>支付方式:</th>
                        <td>
                            <div class="zhifubao">
                                <ul class="ui-list-icons">
                                <li>
                                    <label title="支付宝支付" class="icon-box  points">
                                        <input type="radio" checked="checked" name="payment_type" value="1" class="inpRadio">
                                    </label>
                                </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td><input type="submit" value="下一步" class="inpButton"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>  
</div>