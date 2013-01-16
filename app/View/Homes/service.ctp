<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".navMiddle li a:eq(1)").addClass("active");    
    var mulLR=$(".main .middle .ulProducts").width()/$(".middle .ulProducts li").length-$(".middle .ulProducts li").width();
    var mulLR=mulLR/2;
    $(".middle .ulProducts li").css({"margin-left":mulLR,"margin-right":mulLR});
    
    //切换详情
    var n=-1;
    $(".middle .ulProducts li a").click(function(e){
        e.preventDefault();
        var m=$(".middle .ulProducts li a").index(this);
        if (n!=m) {
            for (i=0;i<$(".main1 .middle .pcontent").length;i++) {
                $(".main1 .middle .pcontent:eq("+i+")").slideUp(600);           
            }           
            n=m;
            $(".main1 .middle .pcontent:eq("+m+")").slideDown(600); 
            $(".main1 .middle .pcontent:eq("+m+") ul").css("width",$(".main1 .middle .pcontent:eq("+m+") ul li").width()*$(".main1 .middle .pcontent:eq("+m+") ul li").length);
        }
    });         
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
      <div class="productslist">
        <ul class="ulProducts">
        {foreach $products as $product}
            <li>
            <a href="javascript:void(0)">
                <div class="borderImg">
				<table width="100%" border="0" height="100%">
              <tr>
                <td> {if !empty($product.Product.big_thumbnail)}
                <img src="{$this->webroot}{$product.Product.small_thumbnail}" alt="{$product.Product.name}" />
                {else}
                <img src="{$this->webroot}img/noimage.gif" alt="not image" />
                {/if}</td>
              </tr>
            </table>               
                </div>
                <p>{$product.Product.name}</p>
            </a>
            </li>
        {/foreach}
        </ul>
      </div>
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
                <td><a href="gsqt-zlxz.html" target="_blank">{$product.Product.document_name}</a></td>
                <td><a href="gsqt-zlxz.html" target="_blank">{$product.Product.created|date_format:"%Y-%m-%d"}</a></td>
                <td class="content"><a href="gsqt-zlxz.html" target="_blank">{$product.Product.additional}</a></td>
                <td class="btnInfoDl" title="下载文档"><a href="files/file.doc">我要下载</a></td>
              </tr>
            </table>  
			<div class="biaotit">产品描述</div>    
          <div class="proInfo">{$product.Product.introduction}</div>
        </div>
    {/foreach}
    </div>
</div>



