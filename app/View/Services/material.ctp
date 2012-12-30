<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="qy-cpzlsc.html">企业服务</a>&gt;&gt;<a href="#">产品及服务资料</a></p>
    </div>
    <div class="biaotit">
    {if count($products) < 5}
    <a href="/services/editProduct" target="_blank" class="mebgszyT">新增产品</a>产品图片
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
        <td><a target="_blank" href="/services/editProduct?id={$product.Product.id}" style="font-weight: bold;">{$product.Product.title}</a></td>
        <td><a target="_blank" href="/services/editProduct?id={$product.Product.id}" style="font-weight: bold;">{$product.Product.name}</a></td>
        <td><a target="_blank" href="/services/editProduct?id={$product.Product.id}" style="font-weight: bold;">{$product.Product.clicked}次</a></td>
        <td><a target="_blank" href="/services/editProduct?id={$product.Product.id}" style="font-weight: bold;">{$product.Product.created|date_format:"%Y-%m-%d"}</a></td>
        <td class="con_2_xq_tofu xiushan_anniu">
            <a target="_blank" href="/services/editProduct?id={$product.Product.id}" style="font-weight: normal;">编辑</a>
            <a href="javascript:void(0)" style="font-weight: normal;">删除</a>
        </td>
      </tr> 
      {/foreach}
    </table>
    <div class="biaotit">
    {if count($services) < 5}
    <a href="/services/editDocument" target="_blank" class="mebgszyT">新增资料</a>文档资料
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
        <td><a target="_blank" href="/services/editDocument?id={$service.Service.id}" style="font-weight: bold;">{$service.Service.title}</a></td>
        <td><a target="_blank" href="/services/editDocument?id={$service.Service.id}" style="font-weight: bold;">{$service.Service.size}k</a></td>
        <td><a target="_blank" href="/services/editDocument?id={$service.Service.id}" style="font-weight: bold;">{$service.Service.download_cnt}次</a></td>
        <td><a target="_blank" href="/services/editDocument?id={$service.Service.id}" style="font-weight: bold;">{$service.Service.created|date_format:"%Y-%m-%d"}</a></td>
        <td class="con_2_xq_tofu xiushan_anniu">
        <a target="_blank" href="/services/editDocument?id={$service.Service.id}" style="font-weight: normal;">编辑</a>
        <a href="javascript:void(0)" style="font-weight: normal;">删除</a>
        </td>
      </tr>
      {/foreach}
    </table>
</div>