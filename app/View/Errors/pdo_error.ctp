{var_dump($error)}
{*
<h2>{__d('cake_dev', 'Database Error')}</h2>
<p class="error">
    <strong>{__d('cake_dev', 'Error')}: </strong>
    {h($error->getMessage())}
</p>
{if !empty($error->queryString)}
    <p class="notice">
        <strong>{__d('cake_dev', 'SQL Query')}: </strong>
        {$error->queryString}
    </p>
{/if}

{if !empty($error->params)}
    <strong>{__d('cake_dev', 'SQL Query Params')}: </strong>
    {Debugger::dump($error->params)}
{/if}
<p class="notice">
    <strong>{__d('cake_dev', 'Notice')}: </strong>
    {__d('cake_dev', 'If you want to customize this error message, create %s', APP_DIR|cat:DS|cat'View'|cat:DS|cat:'Errors'|cat:DS|cat:'pdo_error.ctp')}
</p>
{$this->element('exception_stack_trace')}

*}