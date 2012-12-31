{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#comments', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div id="comments">
      <div class="tilComment">共&nbsp;{$paginatorParams['count']}&nbsp;条评论</div>
      <div class="commentContent">
        <ul>
        {foreach $comments as $key => $comment}
          <li>
            <div class="photo fl"><img src="{$this->webroot}{if !empty($comment.Attribute.thumbnail)}{$comment.Attribute.thumbnail}{else}img/tx.jpg{/if}" /></div>
            <div class="name"><b>{$comment.Member.nickname}</b><span>{$comment.DocumentComment.created|date_format:"%Y-%m-%d"}</span></div>
            <div class="body">
              <p>{$comment.DocumentComment.comment}</p>
              <div class="menu">
              	  <input type="hidden" class="comments_id" value="{$comment.DocumentComment.id}" />
	              <a target="_self" href="javascript:void(0);" class="btnDing">支持</a>({$comment.DocumentComment.support})
	              <a target="_self" href="javascript:void(0);" class="btnCai">反对</a>({$comment.DocumentComment.opposition})<span>|</span>
              </div>
            </div>
          </li>
          {/foreach}
        </ul>
      </div>
      {if $paginatorParams['count'] > 0}
      <div class="fanyea">
      <form id="searchOpt">
        {if $paginatorParams['prevPage']}
            <div style="margin-left:30px;" class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
        {/if}
        <div class="dd_ym">
            <label>每页显示：</label>
            <select name="pageSize" id="pageSize">
                <option value="10" {if $pageSize == "10"} selected {/if}>10</option>
                <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
            </select>
        </div>
        <div class="dd_ym11">
            <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
            <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
            <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
        </div>
        {if $paginatorParams['nextPage']}
            <div style="float:left; margin-left:6px;" class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
        {/if}
        </form>
    </div>
    {/if}
	</div>
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']|cat:'?id='|cat:$this->request->query['id']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']|cat:'?id='|cat:$this->request->query['id']]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#comments', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}
</div>