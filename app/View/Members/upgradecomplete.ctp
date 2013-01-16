<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="grxxxg.html">账号管理</a>&gt;&gt;<a href="#">个人会员升级</a></p>
    </div>
      <ul class="ulFormStep ulFormStep3">
        <li>1.填写个人资料</li>
        <li>2.信息确认</li>
        <li>3.升级成功</li>
      </ul>
      <p class="{if $error}failure {/if}gongxi">{$message}</p>
      <p class="gongxiLink">
      {if $type == 0}
          <a href="/informations/create/need">发布业务&gt;&gt;</a>
          <a href="/informations/create/has">发布需求&gt;&gt;</a>
          <a href="/parttimes/listview?type=need">搜索兼职&gt;&gt;</a>
      {else}
          <a href="/services/home">完善公司主页&gt;&gt;</a>
          <a href="/parttimes/create">发布兼职&gt;&gt;</a>
          <a href="/fulltimes/create">发布招聘&gt;&gt;</a>
      {/if}
      </p>
    </div>