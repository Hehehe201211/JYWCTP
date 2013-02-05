<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.deleteProduct').click(function(){
        if (confirm('确定要删除此产品？')) {
            var id = $(this).next('.id').val();
            deleteItem('product', id);
        }
    });
    $('.deleteService').click(function(){
        if (confirm('确定要删除此文档？')) {
            var id = $(this).next('.id').val();
            deleteItem('service', id);
        }
    });
    
    function deleteItem(actionType, id)
    {
        $.ajax({
            url : '/services/delete',
            type : 'post',
            data : 'type=' + actionType + '&id=' + id,
            success : function(data)
            {
                var result = eval("("+data+")");
                if (result.result == 'OK') {
                    location.href = location.href;
                } else {
                    alert(result.msg);
                }
            }
        });
    }
    
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">企业服务</a>&gt;&gt;
      <a href="javascript:void(0)">产品及服务资料</a>
      </p>
    </div>
    <div class="biaotit">
    {if count($products) < 5}
    <a href="/services/editProduct" class="mebgszyT">新增产品</a>产品图片（产品数量不超过5个）
    {/if}
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
      <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="215">产品标题</th>
          <th width="100">产品型号</th>
          <th width="64">浏览次数</th>
          <th width="123">上传时间</th>
          <th width="115">选择操作</th>
        </tr>
      </thead>
      {foreach $products as $product}
      <tr class="con_2_tr">
        <td><a target="_blank" href="/services/editProduct?id={$product.Product.id}">{$product.Product.title}</a></td>
        <td><a target="_blank" href="/services/editProduct?id={$product.Product.id}">{$product.Product.name}</a></td>
        <td><a target="_blank" href="/services/editProduct?id={$product.Product.id}">{$product.Product.clicked}次</a></td>
        <td><a target="_blank" href="/services/editProduct?id={$product.Product.id}">{$product.Product.created|date_format:"%Y-%m-%d"}</a></td>
        <td class="con_2_xq_tofu xiushan_anniu">
            <a target="_blank" href="/services/editProduct?id={$product.Product.id}">编辑</a>
            <a href="javascript:void(0)" class="deleteProduct">删除</a>
            <input type="hidden" class="id" value="{$product.Product.id}" />
        </td>
      </tr> 
      {/foreach}
    </table>
    <div class="biaotit">
    {if count($services) < 5}
    <a href="/services/editDocument" class="mebgszyT">新增文档</a>文档资料（文档数量不超过5个）
    {/if}
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
      <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="216">文档标题</th>
          <th width="100">文件大小</th>
          <th width="63">下载次数</th>
          <th width="123">上传时间</th>
          <th width="115">选择操作</th>
        </tr>
      </thead>
      {foreach $services as $service}
      <tr class="con_2_tr">
        <td><a target="_blank" href="/services/editDocument?id={$service.Service.id}">{$service.Service.title}</a></td>
        <td><a target="_blank" href="/services/editDocument?id={$service.Service.id}">{$service.Service.size}k</a></td>
        <td><a target="_blank" href="/services/editDocument?id={$service.Service.id}">{$service.Service.download_cnt}次</a></td>
        <td><a target="_blank" href="/services/editDocument?id={$service.Service.id}">{$service.Service.created|date_format:"%Y-%m-%d"}</a></td>
        <td class="con_2_xq_tofu xiushan_anniu">
        <a target="_blank" href="/services/editDocument?id={$service.Service.id}">编辑</a>
        <a href="javascript:void(0)" class="deleteService">删除</a>
        <input type="hidden" class="id" value="{$service.Service.id}" />
        </td>
      </tr>
      {/foreach}
    </table>
</div>