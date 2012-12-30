{if empty($menu)}
    {if !empty($content)}
        {$content}
    {else}
        该页面不存在！
    {/if}
{else}
    {$menu}
    {$content}
{/if}