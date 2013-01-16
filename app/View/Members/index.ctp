<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="#">会员主页</a></p>
	{$this->element('base_info')}
    </div>
    <div class="biaotit"><a class="atitle" href="new-ywfbmx.html">最近发布的客源</a></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
      <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th class="tr_td1">产品 </th>
          <th class="tr_td2">信息价格 </th>
          <th class="tr_td7">城市 </th>
          <th class="tr_td4">状态 </th>
          <th class="tr_td5">点击次数 </th>
          <th class="tr_td8">选择操作</th>
        </tr>
        </thead>
        <tbody>
        {foreach $newHasInformations as $information}
        	<tr class="con_2_tr">
	          <td class="tr_td1">
		          <a target="_blank" href="/informations/detail/{$information.Information.id}" >
		          {$this->Category->getCategoryName($information.Information.category)}<br/>
		          {$this->Category->getCategoryName($information.Information.sub_category)}
		          </a>
	          </td>
	          <td class="tr_td2">
		          <a target="_blank" href="{if $information.Information.status == Configure::read('Information.status_flg.cancel')}/informations/canceldetail/{$information.Information.id}{else}/informations/detail/{$information.Information.id}{/if}" >
			          {if $information.Information.payment_type == 1}业务币：{$information.Information.price}元
			          {else if $information.Information.payment_type == 2}积分：{$information.Information.point}点
			          {else}
			          	业务币：{$information.Information.price}元<br/>积分：{$information.Information.point}点
			          {/if}
		          </a>
	          </td>
	          <td class="tr_td7">
	          	<a target="_blank" href="/informations/detail/{$information.Information.id}" >
	          		{$this->City->cityName($information.Information.provincial)}<br/>{$this->City->cityName($information.Information.city)}
				</a>
			  </td>
	          <td class="tr_td4">
	          <a target="_blank" href="new-xxxq.html" >
				{$status = Configure::read("Information.status")}
				{$status[{$information.Information.status} - 1]}
	          </a>
	          </td>
	          <td class="tr_td5"><a target="_blank" href="new-xxxq.html" >{$information.Information.clicked}</a></td>
	          <td class="con_2_xq_tofu xiushan_anniu"><a target="_blank" href="/informations/detail/{$information.Information.id}" >详情</a><a onclick="confirm('确定删除这条信息吗？')" href="#" >删除</a></td>
	        </tr>
        {/foreach}
      </tbody>
      </table>
           <div class="biaotit"><a class="atitle" href="new-sddxq.html">最近收到的客源</a></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
          <tbody>
                <tr class="con_2_tr con_2_xq_too">
          <th class="tr_td5">发布人</th>
          <th class="tr_td1">产品 </th>
          <th class="tr_td2">信息价格 </th>
          <th class="tr_td7">城市 </th>
          <th class="tr_td4">状态 </th>
          <th class="tr_td8">选择操作</th>
        </tr>                
                {foreach $newReceivedInformations as $information}
                	<tr class="con_2_tr">
			          <td class="tr_td1">
				          <a target="_blank" href="/informations/payment/{$information.Information.id}" >
				          {$this->Category->getCategoryName($information.Information.category)}<br/>
                          {$this->Category->getCategoryName($information.Information.sub_category)}
				          </a>
			          </td>
			          <td class="tr_td2">
				          <a target="_blank" href="/informations/payment/{$information.Information.id}" >
					          {if $information.Information.payment_type == 1}业务币：{$information.Information.price}元
					          {else if $information.Information.payment_type == 2}积分：{$information.Information.point}点
					          {else}
					          	业务币：{$information.Information.price}元<br/>积分：{$information.Information.point}点
					          {/if}
				          </a>
			          </td>
			          <td class="tr_td7">
			          	<a target="_blank" href="/informations/payment/{$information.Information.id}" >
			          		{$this->City->cityName($information.Information.provincial)}<br/>{$this->City->cityName($information.Information.city)}
						</a>
					  </td>
			          <td class="tr_td4">
			          <a target="_blank" href="/informations/payment/{$information.Information.id}" >
			          {$status[{$information.Information.status} - 1]}
			          </a>
			          </td>
			          <td class="tr_td5"><a target="_blank" href="/informations/payment/{$information.Information.id}" >{$information.Information.clicked}</a></td>
			          <td class="con_2_xq_tofu xiushan_anniu"><a target="_blank" href="/informations/payment/{$information.Information.id}" >我需要</a><a onclick="confirm('确定删除这条信息吗？')" href="#" >删除</a></td>
			        </tr>
                {/foreach}
                
           </tbody>
           </table>
           <div class="biaotit"><a class="atitle" href="xslb.html">最近发布的悬赏</a></div>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
          <tbody>
                <tr class="con_2_tr con_2_xq_too">
                   <th class="tr_td1">产品 </th>
                  <th class="tr_td2">信息价格 </th>
                  <th class="tr_td7">城市 </th>
                  <th class="tr_td4">状态 </th>
                  <th class="tr_td5">点击次数 </th>
                  <th class="tr_td8">选择操作</th>          
                </tr>

                {foreach $newRewards as $information}
                	<tr class="con_2_tr">
			          <td class="tr_td1">
				          <a target="_blank" href="/informations/detail/{$information.Information.id}" >
				          {$this->Category->getCategoryName($information.Information.category)}<br/>
                          {$this->Category->getCategoryName($information.Information.sub_category)}
				          </a>
			          </td>
			          <td class="tr_td2">
				          <a target="_blank" href="/informations/detail/{$information.Information.id}" >
					          {if $information.Information.payment_type == 1}业务币：{$information.Information.price}元
					          {else if $information.Information.payment_type == 2}积分：{$information.Information.point}点
					          {else}
					          	业务币：{$information.Information.price}元<br/>积分：{$information.Information.point}点
					          {/if}
				          </a>
			          </td>
			          <td class="tr_td7">
			          	<a target="_blank" href="/informations/detail/{$information.Information.id}" >
			          		{$this->City->cityName($information.Information.provincial)}<br/>{$this->City->cityName($information.Information.city)}
						</a>
					  </td>
			          <td class="tr_td4">
			          <a target="_blank" href="/informations/detail/{$information.Information.id}" >
			          {$status[{$information.Information.status} - 1]}
			          </a>
			          </td>
			          <td class="tr_td5"><a target="_blank" href="/informations/detail/{$information.Information.id}" >{$information.Information.clicked}</a></td>
			          <td class="con_2_xq_tofu xiushan_anniu"><a target="_blank" href="/informations/detail/{$information.Information.id}" >详情</a><a onclick="confirm('确定删除这条信息吗？')" href="#" >删除</a></td>
			        </tr>
                {/foreach}
           </tbody>
           </table>
   <div class="biaotit"><a class="atitle" href="new-sddsx.html">最近收到的悬赏</a></div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
          <thead>
        <tr class="con_2_tr con_2_xq_too">
          <th class="tr_td8">发布人</th>
          <th class="tr_td1">产品</th>
          <th class="tr_td2">信息价格 </th>
          <th class="tr_td7">城市</th>
          <th class="tr_td5">状态</th>
          <th class="tr_td8">选择操作</th>
        </tr>
          </thead>
                <tbody>
                {foreach $newReceivedRewards as $information}
                	<tr class="con_2_tr">
			          <td class="tr_td1">
				          <a target="_blank" href="/informations/create/{if $information.Information.type == 0}has{else}need{/if}/{$information.Information.id}" >
                            {$this->Category->getCategoryName($information.Information.category)}<br/>
                            {$this->Category->getCategoryName($information.Information.sub_category)}
				          </a>
			          </td>
			          <td class="tr_td2">
				          <a target="_blank" href="/informations/create/{if $information.Information.type == 0}has{else}need{/if}/{$information.Information.id}" >
					          {if $information.Information.payment_type == 1}业务币：{$information.Information.price}元
					          {else if $information.Information.payment_type == 2}积分：{$information.Information.point}点
					          {else}
					          	业务币：{$information.Information.price}元<br/>积分：{$information.Information.point}点
					          {/if}
				          </a>
			          </td>
			          <td class="tr_td7">
			          	<a target="_blank" href="/informations/create/{if $information.Information.type == 0}has{else}need{/if}/{$information.Information.id}" >
			          		{$this->City->cityName($information.Information.provincial)}<br/>{$this->City->cityName($information.Information.city)}
						</a>
					  </td>
			          <td class="tr_td4">
			          <a target="_blank" href="/informations/create/{if $information.Information.type == 0}has{else}need{/if}/{$information.Information.id}" >
			          {$status[{$information.Information.status} - 1]}
			          </a>
			          </td>
			          <td class="tr_td5"><a target="_blank" href="/informations/create/{if $information.Information.type == 0}has{else}need{/if}/{$information.Information.id}l" >{$information.Information.clicked}</a></td>
			          <td class="con_2_xq_tofu xiushan_anniu"><a target="_blank" href="/informations/create/{if $information.Information.type == 0}has{else}need{/if}/{$information.Information.id}" >我有该客源 </a><a onclick="confirm('确定删除这条信息吗？')" href="#" >删除</a></td>
			        </tr>
                {/foreach}
           </tbody>
       </table>
    </div>