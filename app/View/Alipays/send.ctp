<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#send_alipay').submit();
});
{/literal}
</script>
<form id="send_alipay" method="post" action="{Configure::read('Alipay.alipay_gateway_new')}?_input_charset={Configure::read('Alipay._input_charset')}">
    {foreach $parameters as $key => $value}
        {if !empty($value)}
            <input type="hidden" name="{$key}" value="{$value}" />
        {/if}
    {/foreach}
</form>

