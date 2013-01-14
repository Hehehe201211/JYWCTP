<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#sendMsg').click(function(){
        if ($('#title').val() == "") {
            
            return false;
        }
        if ($('#content').val() == "") {
            
            return false;
        }
        $.ajax({
            url : '/sms/addMsg',
            type : 'post',
            data : $('#msgForm').serializeArray(),
            success : function(data) {
                var result = eval("("+data+")");
                var date = new Date();
                date = date.getFullYear() + '-' + date.getMonth()+1 + '-' + date.getDate();
                if (result.result == "OK") {
                    var str = '<div class="xq_huif_tet">'+
                                    '<p class="xq_huif_tet11">'+
                                            '<strong class="sender">我</strong>' + $('#content').val() +
                                    '</p>'+
                                    '<p class="xq_huif_riq">' + date +'</p>'+
                              '</div>';
                    $('#result').prepend(str);
                    $('#title').val("");
                    $('#content').val("");
                    alert(result.msg);
                  } else {
                    alert(result.msg);
                }
            }
        });
    });

});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs"><!-- InstanceBeginEditable name="EditRegion7" -->
      <p>
      <a href="javascript:void(0">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0">好友管理</a>&gt;&gt;
      <a href="javascript:void(0)">好友联系</a>
      </p>
    </div>
    <!-- InstanceBeginEditable name="EditRegion5" --> 
    <div class="zy_zszl">
          <div class="zy_zszl_z">
            <dl>
              <dt>
                <dl>
              <dt class="borBlue"><img src="{$this->webroot}img/tx.jpg"></dt>
              <dd class="member">
                  <span>会员名称：{$firend.Member.nickname}</span>
                  <span>公司名称：{$firend.Member.company_name}</span>
                  <span>行业：互联网</span><span>发布信息数：8次</span>
                  <span>交易次数：8次</span><span>好评率：100%</span>
              </dd>
            </dl>
              </dt>              
            </dl>
          </div>
          <div class="zy_zszl_r">
            <dl>
        </dl>
          </div>
        </div>
    <div class="biaotit">与<em>{$firend.Member.nickname}</em>的联系记录</div>
    <div class="znx">
        <dl>
        <form id="msgForm">
          <dd>
            <label>主题：</label><input type="text" name="title" class="inpTextBox" id="title">
          </dd>
          <dd>
            <label><font class="facexh">*</font>内容：</label>
            <textarea name="content" id="content"></textarea>
          </dd>
          <input type="hidden" name="receiver" value="{$this->request->query['fid']}" />
          <input type="hidden" name="type" value="1" />
        </form>
        </dl>
        <a class="zclan zclan4" href="javascript:void(0);" id="sendMsg">发送</a>
        <p class="hx"></p>
        <div id="result">
        {$form = ['isForm' => true, 'inline' => true]}
        {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
        {$this->Paginator->options($options)}
        {$paginatorParams = $this->Paginator->params()}
        {foreach $messages as $message}
            <div class="xq_huif_tet">
                <p class="xq_huif_tet11">
                    {if $message.StationMessage.sender == $memberInfo.Member.id}
                        <strong class="sender">我</strong>
                    {else}
                        <strong>{$message.Member.nickname}</strong>
                    {/if}
                    {$message.StationMessage.content}
                </p>
                <p class="xq_huif_riq">{$message.StationMessage.created|date_format:"%Y-%m-%d"}</p>
          </div>
        {/foreach}
        <form id="searchOpt">
          <div class="fanyea">
            {if $paginatorParams['prevPage']}
                <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
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
                <font>共{$paginatorParams['count']}条</font>
                <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                <div class="dd_span1"><a href="javascript:void(0)" id="jumpButton">跳转</a></div>
            </div>
            {if $paginatorParams['nextPage']}
                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
            {/if}
          </div>
          </form>
            {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
            {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
            {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
            {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
            {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
            {$this->Js->writeBuffer()}
        </div>
      </div>
    <!-- InstanceEndEditable -->     
    <div class="bottomRcd" style="position: fixed; display: none;">
      <div class="fl">
        <h3>热门悬赏<a href="#" class="more">更多...</a></h3>
        <ul>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元&nbsp;厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        </ul>
      </div>
      <div class="fl fr">
        <h3>最新客源<a href="#" class="more">更多...</a></h3>
        <ul>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元&nbsp;厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        <li><a class="li" href="#">厦门市/装修装饰 家庭装修/聚客币：10元</a></li>
        </ul>
      </div>
    </div>  
    <div class="bottomRcdPos" style="display: none;"></div>   
</div>