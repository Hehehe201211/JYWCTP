<h3 style="width:216px;">
  <div class="fr btnPage">
  {if $hasPrev}
  	<a href="/{$this->request->params['controller']}/{$this->request->params['action']}?page={$page-1}" class="prev"></a>
  {/if}
  {if $hasNext}
  	<a href="/{$this->request->params['controller']}/{$this->request->params['action']}?page={$page + 1}" class="next"></a>
  {/if}
  </div>我的收藏(<span id="favourite_cnt">{$favouriteCnt}</span>)
  </h3>
<ul>
{foreach $favourites as $document}
  	<li><a href="/resources/detail?id={$document.Document.id}" target="_blank">{$document.Document.title}</a></li>
{/foreach}
</ul>
<div class="clearfix"></div>