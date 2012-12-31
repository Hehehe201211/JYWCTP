<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="new-wyjz.html">兼职管理</a>&gt;&gt;<a href="#">兼职收藏夹</a></p>
    </div> 
    <div class="biaotit">兼职收藏夹</div>
      <div class="tableSort">
          <input type="radio" checked="checked" id="time" value="time" name="zjSort" class="inpRadio">
          <label for="time">发布时间</label>
          <input type="radio" value="company" id="company" name="zjSort" class="inpRadio">
          <label for="company">单位名称</label>
          <input type="radio" id="position" value="position" name="zjSort" class="inpRadio">
          <label for="position">职位</label>
          <select>
              <option>降序</option>
              <option>升序</option>
          </select>
          <input type="button" value="排序" class="inpButton">
      </div>
      <table width="100%" cellspacing="0" cellpadding="0" border="0" class="conTable3">
      <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th width="137" class="tr_td2">兼职标题</th>
          <th width="128" class="tr_td1">公司名称</th>          
          <th width="84" class="tr_td3">产品或服务</th>          
          <th width="85" class="tr_td5">兼职配合方式</th>
          <th width="66" class="tr_td4">发布日期</th>
          <th width="117" class="tr_td6">选择操作</th>
        </tr>
      </thead>
      <tbody>
      {foreach $favourites as $favourite}
          <tr class="con_2_tr even">
            <td class="tr_td2"><a target="_blank" href="/favourites/detail?id={$favourite.PartTimeFavourite.id}">{$favourite.PartTime.title}</a></td>
            <td class="tr_td1"><a target="_blank" href="/favourites/detail?id={$favourite.PartTimeFavourite.id}">{$favourite.Member.company_name}</a></td>        
            <td class="tr_td3"><a target="_blank" href="/favourites/detail?id={$favourite.PartTimeFavourite.id}">{$favourite.PartTime.sub_title}</a></td>        
            <td class="tr_td5">
            <a target="_blank" href="/favourites/detail?id={$favourite.PartTimeFavourite.id}">
            {if $favourite.PartTime.method == 1}
            提供客户信息
            {elseif $favourite.PartTime.method == 2}
            协助跟单
            {elseif $favourite.PartTime.method == 3}
            独立签单
            {/if}
            </a>
            </td>
            <td class="tr_td4"><a target="_blank" href="/favourites/detail?id={$favourite.PartTimeFavourite.id}">{$favourite.PartTime.created|date_format:"%Y-%m-%d"}</a></td>
            <td class="con_2_xq_tofu xiushan_anniu">
            <a target="_blank" href="/favourites/detail?id={$favourite.PartTimeFavourite.id}" style="font-weight: normal;">详情</a>
            <a href="javascript:void(0)" style="font-weight: normal;">删除</a>
            </td>
          </tr>
      {/foreach}       
    </tbody></table> 
    <div class="fanyea">
            <div class="dd_span"><a href="#">上一页</a></div>
            <div class="dd_ym">
              <label>每页显示：</label>
              <select>
                <option>100</option>
                <option>50</option>
                <option>20</option>
                <option>10</option>
              </select>
            </div>
            <div class="dd_ym11"> <font>共64388条</font> <font>第1/644页</font>
              <input style="" class="inpTextBox" id="acpro_inp5">
              <div class="dd_span1"><a href="#">跳转</a></div>
            </div>
            <div class="dd_span"><a href="#">下一页</a></div>
          </div>    
  </div>