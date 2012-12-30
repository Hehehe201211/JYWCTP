{App::uses('Debugger', 'Utility')}
<h3>Stack Trace</h3>
<ul class="cake-stack-trace">
{foreach $error->getTrace() as $i => $stack}
    <li>
        {$excerpt = $arguments = ''}
        {$params = array()}
        {if isset($stack['file']) && isset($stack['line'])}
            {printf(
                    '<a href="#" onclick="traceToggle(event, \'file-excerpt-%s\')">%s line %s</a>',
                    $i,
                    Debugger::trimPath($stack['file']),
                    $stack['line']
                )}
            {$excerpt = sprintf('<div id="file-excerpt-%s" class="cake-code-dump" style="display:none;"><pre>', $i)}
            {$excerpt|cat:implode("\n", Debugger::excerpt($stack['file'], $stack['line'] - 1, 2))}
            {$excerpt|cat:'</pre></div> '}
        {else}
            <a href="#">[internal function]</a>
        {/if}
         &rarr;
         {if $stack['function]}
            {$args = array()}
            {if !empty($stack['args'])}
                {foreach (array)$stack['args'] as $arg}
                    {$args[] = Debugger::getType($arg)}
                    {$params[] = Debugger::exportVar($arg, 2)}
                {/foreach}
            {/if}
            {$called = isset($stack['class']) ? $stack['class']|cat:$stack['type']|cat:$stack['function'] : $stack['function']}
            {
                printf(
                    '<a href="#" onclick="traceToggle(event, \'trace-args-%s\')">%s(%s)</a> ',
                    $i,
                    $called,
                    implode(', ', $args)
                );
            }
            {$arguments = sprintf('<div id="trace-args-%s" class="cake-code-dump" style="display: none;"><pre>', $i)}
            {$arguments|cat:implode("\n", $params)}
            {$arguments|cat:'</pre></div>'}
         {/if}
         {$excerpt}
         {$arguments}
    </li>
{/foreach}
</ul>

<script type="text/javascript">
function traceToggle(event, id) {
    var el = document.getElementById(id);
    el.style.display = (el.style.display == 'block') ? 'none' : 'block';
    event.preventDefault();
    return false;
}
</script>