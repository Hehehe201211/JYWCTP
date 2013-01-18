<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#send_alipay').submit();
});
{/literal}
</script>
<form id="send_alipay" method="post" action="{Configure::read('Alipay.alipay_gateway_new')}">
    <input type="hidden" name="service" value="" />
    <input type="hidden" name="partner" value="" />
    <input type="hidden" name="payment_type" value="" />
    <input type="hidden" name="notify_url" value="" />
    <input type="hidden" name="return_url" value="" />
    <input type="hidden" name="seller_email" value="" />
    <input type="hidden" name="out_trade_no" value="" />
    <input type="hidden" name="subject" value="" />
    <input type="hidden" name="total_fee" value="" />
    <input type="hidden" name="body" value="" />
    <input type="hidden" name="show_url" value="" />
    <input type="hidden" name="anti_phishing_key" value="" />
    <input type="hidden" name="exter_invoke_ip" value="" />
    <input type="hidden" name="_input_charset" value="" />
</form>