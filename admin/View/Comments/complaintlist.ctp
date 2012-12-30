{assign var=options value=['update' => '#commentList', 'evalScripts' => true]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<div class="divBtmcontact" id="commentList">
  <h3>双方交流</h3>
  {foreach $comments as $comment}
  <div class="pContact">
    <div class="addressee">
        <strong>{$comment.CooperationComment.content}</strong>
        <span>{$comment.CooperationComment.content}</span>
        <div class="time">{$comment.CooperationComment.created}</div>
    </div>
    <div class="clearfix1"></div>
  </div>
  {/foreach}
  <div class="paging clear">
    {if $paginatorParams['prevPage']}
      <a href="javascript:void(0)">{$this->Paginator->prev('上一页', array(), null, null)}</a>
    {/if}
        <label>每页显示：</label>
        <select name="pageSize" id="pageSize">
            <option value="2" {if $pageSize == "2"} selected {/if}>10</option>
            <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
            <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
            <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
        </select>
        <div>共{$paginatorParams['count']}条</div>
        <div>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</div>
        <input type="text" class="inpTextBox" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}" />
        <a href="javascript:void(0)" id="jumpButton">跳转</a>
        {if $paginatorParams['nextPage']}
        <a href="javascript:void(0)">{$this->Paginator->next('下一页', array(), null, array())}</a>
        {/if}
    </div>
</div>