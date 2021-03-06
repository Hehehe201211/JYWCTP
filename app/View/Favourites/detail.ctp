<script>
{literal}
$(document).ready(function(){
    $("body").append($('.jsxxxqB'));
    $('#delete').click(function(){
		if  (confirm("确定删除该收藏？")) {
		  $.ajax({
			  url : '/favourites/delete',
			  type : 'post',
			  data : 'id=' + $('#favourite_id').val(),
			  success : function(data){
				  var result = eval("("+data+")");
				  if (result.result == 'OK') {
					  location.href = '/favourites/listview';
				  } else {
					  alter(result.msg);
				  }
			  }
		  });
		}
    });

    $(".btnDeliverR").click(function(e){
        e.preventDefault();
        var category = $('#category').val();
        var parttime_id = $('#parttime_id').val();
        var target_member = $('#target_member').val();
        $('.jsxxxqB').load('/parttimes/informationList', {'category':category, 'parttime_id':parttime_id, 'target_member':target_member})
        bgKuang(".jsxxxqB",".jsxxxqB .closeDiv");
    });
});
//{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs">
      <p>
      <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
      <a href="javascript:void(0)">兼职管理</a>&gt;&gt;
      <a href="javascript:void(0)">{$parttime.PartTime.title}</a>
      </p>      
    </div>   
    <div class="tableDetail">
    <div class="biaotit">{$parttime.PartTime.title}</div>
        <p class="jinggao">发布时间：{$parttime.PartTime.created|date_format:"%Y-%m-%d"}  信息编号：{$parttime.PartTime.id}  该信息被浏览 {$parttime.PartTime.clicked} 次 </p>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="posInfo">
          <tbody><tr>
            <th width="25%">公司名称：</th>
            <td width="75%">
             {if !empty($homepage)}
            <a href="/homes/index/{$homepage.Homepage.domain}" target="_blank" class="red">{$parttime.Member.company_name}</a>
            {else}
            {$parttime.Member.company_name}
            {/if}
            </td>
          </tr>
          <tr>
            <th>营业执照：</th>
            <td class="red">已验证</td>
          </tr>
          <tr>
            <th>产品所属分类：</th>
            <td>
            {$this->Category->getCategoryName($parttime.PartTime.category)}
            {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
            </td>
          </tr>
          <tr>
            <th>产品具体名称：</th>
            <td>{$parttime.PartTime.sub_title}</td>
          </tr>
          <tr>
            <th>兼职时间：</th>
            <td>{$parttime.PartTime.open|date_format:"%Y-%m-%d"} 至 {$parttime.PartTime.close|date_format:"%Y-%m-%d"}</td>
          </tr>
          <tr>
            <th>客户区域范围：</th>
            <td>
            {$citys = explode(',', $parttime.PartTime.area)}
            {foreach $citys as $id}
            {$this->City->cityName($id)}
            {/foreach}
            </td>
          </tr>
          <tr>
            <th>兼职配合方式：</th>
            <td>
            {if $parttime.PartTime.method == 1}
            提供客户信息
            {elseif $parttime.PartTime.method == 2}
            协助跟单
            {elseif $parttime.PartTime.method == 3}
            独立签单
            {/if}
            </td>
          </tr>
          <tr>
            <th>报酬：</th>
            <td>
                {if $parttime.PartTime.pay == 1}
                按合同金额百分比  {$parttime.PartTime.pay_rate}
                {else}
                协商确定
                {/if}
            </td>
          </tr>
          <tr>
            <th>报酬支付时间：</th>
            <td>
            {if $parttime.PartTime.pay_method == 1}
                收款后{$parttime.PartTime.pay_time}个工作日内转账
            {else}
            其它
            {/if}
            </td>
          </tr>
          <tr>
            <th>报酬支付补充说明：</th>
            <td>
            {$parttime.PartTime.pay_explanation}
            </td>
          </tr>
          <tr>
            <th>推荐参与行业：</th>
            <td>
            {if !empty($parttime.PartTime.industry)}
                {$categorys = explode(',', $parttime.PartTime.industry)}
                {foreach $categorys as $id}
                {$this->Category->getCategoryName($id)} 
                {/foreach}
            {/if}
            </td>
          </tr>
          <tr>
            <th>联系人：</th>
            <td>{$parttime.PartTime.contact}</td>
          </tr>
          <tr>
            <th>联系方式：</th>
            <td>
            {$methods = json_decode($parttime.PartTime.contact_method, true)}
            {foreach $methods as $method}
            {$method.method} {$method.number}
            {/foreach}
            </td>
          </tr>
          <tr>
            <th>联系邮箱：</th>
            <td>{$parttime.PartTime.email}</td>
          </tr>
          <tr>
            <th>公司地址：</th>
            <td><p>{$parttime.PartTime.address}</p></td>
          </tr>
          <tr>
            <th>补充说明：</th>
            <td><p>{$parttime.PartTime.additional}</p></td>
          </tr>
        </tbody>
        </table>        
	  <div class="divBtnContainer" style="width:200px;">
      <a href="javascript:void(0)" class="zclan zclan7 btnDeliverR">我有客源</a>
      <input type="hidden" id="favourite_id" value="{$this->request->query['id']}">
      <a href="javascript:void(0)" class="zclan zclan7" id="delete">删除</a>
	  </div>
  </div>
  </div>
<input type="hidden" id="category" value="{$parttime.PartTime.sub_category}">
<input type="hidden" id="parttime_id" value="{$parttime.PartTime.id}">
<input type="hidden" id="target_member" value="{$parttime.PartTime.members_id}">
<div class="jsxxxq jsxxxqB">
    <a href="#" class="closeDiv">&nbsp;</a>
    <div class="sjle">    
    </div>
</div>