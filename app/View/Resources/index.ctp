<div class="main">
    <div id="loginWarning">
        <div class="area">
            <div class="notice">您输入的密码和账户名不匹配，请重新输入。</div>
            <ul class="question">
            </ul>
        </div>
        <div class="arrow"></div>
    </div>
  <div class="conResource">
    <div class="divResource">
      <h2>
      {if count($ru_men) == 6}
      <a class="fr" href="/resources/search?type=1" target="_blank">更多...</a>
      {/if}
      入门成长
      </h2>
      <table width="360" border="0" cellspacing="0" cellpadding="0">
      {foreach $ru_men as $item}
        <tr>
          <td class="title">
          <a href="/resources/detail?id={$item.Document.id}" target="_blank">{$item.Document.title}</a>
          </td>
          <td class="pages">{$item.Document.pages}页</td>
          <td class="fraction">
            <span>{if empty($item.Document.point)}免费{else}{$item.Document.point}分{/if}</span>
          </td>
        </tr>
      {/foreach}
      </table>
    </div>
    <div class="divResource">
      <h2>
      {if count($pei_xun) == 6}
      <a class="fr" href="/resources/search?type=2" target="_blank">更多...</a>
      {/if}
      培训课件
      </h2>
      <table width="360" border="0" cellspacing="0" cellpadding="0">
        {foreach $pei_xun as $item}
            <tr>
          <td class="title">
          <a href="/resources/detail?id={$item.Document.id}" target="_blank">{$item.Document.title}</a>
          </td>
          <td class="pages">{$item.Document.pages}页</td>
          <td class="fraction">
            <span>{if empty($item.Document.point)}免费{else}{$item.Document.point}分{/if}</span>
          </td>
        </tr>
        {/foreach}
      </table>
    </div>
    <div class="adResource"><img src="{$this->webroot}img/ads/960x100.jpg" width="742" height="65" /></div>
    <div class="divResource">
      <h2>
      {if count($ke_hu) == 6}
      <a class="fr" href="/resources/search?type=3" target="_blank">更多...</a>
      {/if}
      客户管理
      </h2>
      <table width="360" border="0" cellspacing="0" cellpadding="0">
        {foreach $ke_hu as $item}
            <tr>
              <td class="title">
              <a href="/resources/detail?id={$item.Document.id}" target="_blank">{$item.Document.title}</a>
              </td>
              <td class="pages">{$item.Document.pages}页</td>
              <td class="fraction">
                <span>{if empty($item.Document.point)}免费{else}{$item.Document.point}分{/if}</span>
              </td>
            </tr>
        {/foreach}
      </table>
    </div>
    <div class="divResource">
      <h2>
      {if count($fang_an) == 6}
      <a class="fr" href="/resources/search?type=4" target="_blank">更多...</a>
      {/if}
      方案模板
      </h2>
      <table width="360" border="0" cellspacing="0" cellpadding="0">
        {foreach $fang_an as $item}
            <tr>
              <td class="title">
              <a href="/resources/detail?id={$item.Document.id}" target="_blank">{$item.Document.title}</a>
              </td>
              <td class="pages">{$item.Document.pages}页</td>
              <td class="fraction">
                <span>{if empty($item.Document.point)}免费{else}{$item.Document.point}分{/if}</span>
              </td>
            </tr>
        {/foreach}
      </table>
    </div>
    <div class="adResource"><img src="{$this->webroot}img/ads/960x100.jpg" width="742" height="65" /></div>
    <div class="divResource">
      <h2>
      {if count($zong_jie) == 6}
      <a class="fr" href="/resources/search?type=5" target="_blank">更多...</a>
      {/if}
      总结计划
      </h2>
      <table width="360" border="0" cellspacing="0" cellpadding="0">
        {foreach $zong_jie as $item}
            <tr>
              <td class="title">
              <a href="/resources/detail?id={$item.Document.id}" target="_blank">{$item.Document.title}</a>
              </td>
              <td class="pages">{$item.Document.pages}页</td>
              <td class="fraction">
                <span>{if empty($item.Document.point)}免费{else}{$item.Document.point}分{/if}</span>
              </td>
            </tr>
        {/foreach}
      </table>
    </div>
    <div class="divResource">
      <h2>
      {if count($an_li) == 6}
      <a class="fr" href="/resources/search?type=6" target="_blank">更多...</a>
      {/if}
      案例分析
      </h2>
      <table width="360" border="0" cellspacing="0" cellpadding="0">
        {foreach $an_li as $item}
            <tr>
              <td class="title">
              <a href="/resources/detail?id={$item.Document.id}" target="_blank">{$item.Document.title}</a>
              </td>
              <td class="pages">{$item.Document.pages}页</td>
              <td class="fraction">
                <span>{if empty($item.Document.point)}免费{else}{$item.Document.point}分{/if}</span>
              </td>
            </tr>
        {/foreach}
      </table>
    </div>
  </div>
  {if !empty($memberInfo)}
  {$this->element('resource/left_logined')}
  {else}
  {$this->element('resource/left')}
  {/if}
</div>