<div class="renzheng">
    <div style="width:auto; line-height:2.4;" class="password-tip">
    {if empty($message)}
        <h2 style="margin-bottom:20px;">
            <span class="reg-email-icon"></span>找回密码邮件发送成功！
        </h2>
        <p class="reg-email">邮件已发送至您的邮箱
            <strong class="b-n">{$email}</strong>
        </p>
    {else}
        <h2 style="margin-bottom:20px;">
            <span class="reg-email-icon"></span>找回密码邮件发送失败！
        </h2>
        <p class="reg-email">
            {$message}
            <strong class="b-n">{$email}</strong>
        </p>
    {/if}
    </div>
</div>