<div class="zy_z">
    <div class="zy_zs">
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="qy-jzfbmx.html">兼职管理</a>&gt;&gt;<a href="#">发布兼职</a></p>     
    </div>   
<ul class="ulFormStep ulFormStep3">
      <li>1.填写兼职信息</li>
      <li>2.确认兼职信息</li>
      <li>3.兼职发布成功</li>
    </ul>
      {if !$error}
      <div class="success">
        <p class="gongxi">{$msg}</p>
        <p class="gongxiLink">
            <a href="qy-jzfbmxxq.html">查看该信息&gt;&gt;</a>
            <a href="qy-fbjz.html">完善该信息&gt;&gt;</a>
            <a href="/parttimes/create">再发布一条&gt;&gt;</a>
        </p>
      </div>
      {else}
      <div class="failure">
        <p class="gongxi">{$msg}</p>
        {if $duplicate}
        <p class="gongxiLink"><a href="/parttimes/detail/?id={$id}">查看此兼职</a></p>
        {else}
        <p class="gongxiLink"><a href="javascript:void()" onclick="window.location.reload();">重新发送&gt;&gt;</a></p>
        {/if}
      </div>
      {/if}
    </div>