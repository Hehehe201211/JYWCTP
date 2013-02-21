<div class="renzheng">    
    {if empty($message)}
      <h2 style="margin-bottom:20px;">
            <span class="reg-email-icon"></span>找回密码邮件发送成功！
        </h2>
        <p class="reg-email">邮件已发送至您的邮箱
            <strong class="b-n">{$email}</strong>，请及时查收。
        </p>
    {else}
    <div style="padding-left:0" class="RZfailure">
        <h2 style="margin-bottom:20px;">
            <span class="reg-email-icon"></span>找回密码邮件发送失败！
        </h2>
        <p class="reg-email">
            {$message}
            <strong class="b-n">{$email}</strong>
        </p>
     </div>
    {/if}
    </div>
</div>