{if class_exists('ConnectionManager') && Configure::read('debug') >= 2}
    {$noLogs = !isset($logs)}
    {if $noLogs}
        {$sources = ConnectionManager::sourceList()}
        {$logs = array()}
        {foreach $sources as $source}
            {$db = ConnectionManager::getDataSource($source)}
            {if method_exists($db, 'getLog')}
                {$logs[$source] = $db->getLog()}
            {/if}
        {/foreach}
    {/if}
    
    {if $noLogs || isset($_forced_from_dbo_)}
        {foreach $logs as $source => $logInfo}
            {if $logInfo['count'] > 1}
                {$text = 'queries'}
            {else}
                {$text = 'query'}
            {/if}
            {printf('<div><table class="cake-sql-log" id="cakeSqlLog_%s" summary="Cake SQL Log" cellspacing="0">',
            preg_replace('/[^A-Za-z0-9_]/', '_', uniqid(time(), true))
            )}
            {printf('<caption>(%s) %s %s took %s ms</caption>', $source, $logInfo['count'], $text, $logInfo['time'])}
            <thead>
                <tr><th>Nr</th><th>Query</th><th>Error</th><th>Affected</th><th>Num. rows</th><th>Took (ms)</th></tr>
            </thead>
            <tbody>
            {$er['error'] = ''}
            {foreach $logInfo['log'] as $k => $i}
                {$i = $i+$er}
                {if !empty($i['params']) && is_array($i['params'])}
                    {$bindParam = null}
                    {$bindType = null}
                    {if preg_match('/.+ :.+/', $i['query'])}
                        {$bindType = true}
                        {foreach $i['params'] as $bindKey => $bindVal}
                            {if $bindType === true}
                                {$bindParam = $bindParam|cat:h($bindKey)|cat:" => "|cat:h($bindVal)|cat:", "}
                            {else}
                                {$bindParam = $bindParam|cat:h($bindVal)|cat:", "}
                            {/if}
                        {/foreach}
                        {$i['query'] = $i['query']|cat:" , params[ "|cat: rtrim($bindParam, ', ')|cat:" ]"}
                    {/if}
                {/if}
                {"<tr><td>"|cat:($k + 1)|cat:"</td><td>"|cat:h($i['query'])|cat:"</td><td>{$i['error']}</td><td style = \"text-align: right\">{$i['affected']}</td><td style = \"text-align: right\">{$i['numRows']}</td><td style = \"text-align: right\">{$i['took']}</td></tr>\n"}
            {/foreach}
            </tbody></table></div>
        {/foreach}
    {else}
    <p>Encountered unexpected {$logs} cannot generate SQL log</p>
    {/if}
{/if}
