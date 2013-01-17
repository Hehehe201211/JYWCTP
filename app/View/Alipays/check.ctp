<div class="zhifu">
    <div class="cashier-box-min">
        <h4>账户充值</h4>
        <form action="/alipays/send" method="post">
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
                        <th>充值金额:</th>
                        <td><span>{$this->request->data['price']}</span>元</td>
                        <input type="hidden" name="price" value="{$this->request->data['price']}" />
                    </tr>
                    <tr>
                        <th>支付方式:</th>
                        <td>
                            <div class="zhifubao">
                                <ul class="ui-list-icons">
                                <li>
                                    <label title="支付宝支付" class="icon-box  alipay">
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