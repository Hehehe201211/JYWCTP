<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".navMiddle li a:eq(1)").addClass("active");    
    if ($.browser.msie) {
		$(".products img").each(function(index) {
			var mTop=($(this).parent().height()-$(this).height())/2;
			$(this).css("margin-top",mTop);
		});
	}
    
    //切换详情
    var n=-1;
    $(".products a").click(function(e){
        e.preventDefault();
        var m=$(".products a").index(this);
        if (n!=m) {
			$(".pcontent").eq(n).slideUp(600);	
			$(".pcontent").eq(m).slideDown(600);			
			n=m;
		}
    });
    $('.download').live('click', function(){
        var src = '/homes/download_product?id=' + $(this).next('.id').val();
        $('#downloadIframe').attr('src', src);
    })
});
{/literal}
</script>

<div class="main">
  <div class="left">
    <div class="divnavLeft">
      <div class="navLeft"></div>
    </div>
    <div class="divconLeft"></div>
  </div>
  <div class="middle">
    <div class="navMiddle">
       <ul>
            <li><a class="aleft" href="/homes/index/{$domain}">公司简介</a></li>
            <li><a href="/homes/service/{$domain}">产品或服务</a></li>
            <li><a href="/homes/download/{$domain}">资料下载</a></li>
            <li><a href="/homes/fulltime/{$domain}">招聘岗位</a></li>
            <li><a href="/homes/parttime/{$domain}">兼职需求及政策</a></li>
            <li><a class="aright" href="/homes/contact/{$domain}">联系方式</a></li>
        </ul>
    </div>
    <div class="divconMiddle">
    <table width="100%" border="0" class="products">
        <tr>
        {foreach $products as $product}            
            <td><a href="javascript:;">
            <span class="borderImg">  {if !empty($product.Product.big_thumbnail)}
                <img src="{$this->webroot}{$product.Product.small_thumbnail}" alt="{$product.Product.name}" />
                {else}
                <img src="{$this->webroot}img/noimage.gif" alt="not image" />
                {/if} </span>
            <p>{$product.Product.name}</p>
            </a></td>
        {/foreach}
        </tr>
      </table>      
    </div>
  </div>
  <div class="left right">
    <div class="divnavLeft">
      <div class="navLeft navRight"></div>
    </div>
    <div class="divconLeft"></div>
  </div>
</div>

<div class="main main1">
    <div class="middle">
    {foreach $products as $product}
        <div class="pcontent">
          <h2>{$product.Product.title}</h2>
          <div class="divImg">
          {if !empty($product.Product.big_thumbnail)}
          <img class="img" src="{$this->webroot}{$product.Product.big_thumbnail}"/>
          {else}
          <img  style="margin:0px auto;display:block;" src="{$this->webroot}img/noimage.gif" alt="not image" />
          {/if}
          </div>
          <h3>{$product.Product.name}</h3>
          {if !empty($product.Product.document_path)}
          {$thumbnail = Configure::read('Data.path')|cat:$product.Product.document_path}
          {if file_exists($thumbnail)}
          <table width="100%" class="hyxzyemian22" >
               <thead>
                <tr>
                  <th width="147">产品或服务相关资料</th>
                  <th width="69">发布时间</th>
                  <th width="289">内容提要</th>
                  <th width="64">下载文档</th>
                </tr>
                </thead>
              <tr>
                <td>
                    <a href="javascript:void(0)" target="_blank">{$product.Product.title}</a>
                </td>
                <td>
                    <a href="javascript:void(0)" target="_blank">{$product.Product.created|date_format:"%Y-%m-%d"}</a>
                </td>
                <td class="content">
                    <a href="javascript:void(0)" target="_blank">{$product.Product.additional}</a>
                </td>
                <td class="btnInfoDl" title="下载文档">
                    <a href="javascript:void(0)" class="download">我要下载</a>
                    <input type="hidden" class="id" value="{$product.Product.id}" />
                </td>
              </tr>
            </table>
            {/if}
            {/if}
			<div class="biaotit">产品描述</div>    
          <div class="proInfo">{$product.Product.introduction}</div>
        </div>
    {/foreach}
    </div>
</div>
<iframe style="display:none" id="downloadIframe">
</iframe>