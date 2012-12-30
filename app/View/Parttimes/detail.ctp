{literal}
<script type="text/javascript">
$(document).ready(function(){
    //sidebarSF(3);
	$("body").append("<div class='jsxxxq jsxxxqB'><a href='javascript:;' class='closeDiv'> </a><div class='sjle'></div></div>");
    $(".btnDeliverR").click(function(e){
        e.preventDefault();
        var category = $('#category').val();
        var parttime_id = $('#parttime_id').val();
        var target_member = $('#target_member').val();
        $('.jsxxxqB').load('/parttimes/informationList', {'category':category, 'parttime_id':parttime_id, 'target_member':target_member})
        bgKuang(".jsxxxqB",".jsxxxqB .closeDiv");
    });
    
    $("#candidate").live('click',function(){
        var information = [];
        $('.information_id').each(function(){
            if ($(this).attr('checked') == 'checked') {
                information.push($(this).val())
            }
        });
        if(information.length > 0) {
            var reveiver = $('#target_member').val();
            $.ajax({
                url : '/parttimes/addCandidates',
                type : 'post',
                data : 'receiver=' + $('#target_member').val() + '&part_times_id=' + $('#parttime_id').val() + '&information_ids=' + information.join(','),
                success : function(data){
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        alert('客源提交成功！');
                         location.href = '/cooperations/listview?type=send'
                    } else {
                        if ($('.sjle span').length == 0) {
                            var errMsg = '<span style="color:red" >请选择客源！</span>';
                            $('.sjle ul:first').before(errMsg);
                        } else {
                            $('.sjle span').html(result.msg);
                        }
                    }
                }
            })
        } else {
            if ($('.sjle span').length == 0) {
                var errMsg = '<span style="color:red" >请选择客源！</span>';
                $('.sjle ul:first').before(errMsg);
            }
        }
    });
    
    //收藏
    $('#favourite').click(function(){
        $.ajax({
            url : '/favourites/add',
            type : 'post',
            data : 'part_times_id=' + $('#part_times_id').val(),
            success : function(data)
            {
                var result = eval("("+data+")");
                if(result.result == 'OK') {
                    $('#favourite').hide();
                    alert('收藏成功！');
                } else {
                    alert(result.msg);
                    document.URL = location.href;
                }
            }
        });
    });
});
</script>
{/literal}
<div class="zy_z">
    <div class="zy_zs">
      <p><a href="new-hyzy.html">我的聚业务</a>&gt;&gt;<a href="new-wwtj.html">兼职管理</a>&gt;&gt;<a href="#">平台兼职详情</a></p>
     </div>
    <div class="biaotit">{$parttime.PartTime.title}</div>
    <div class="gongsichakan_jobs jsxxxq">
      <div class="gongsichakan_post">
        <p class="jinggao">发布时间：{$parttime.PartTime.created|date_format:"%Y-%m-%d"}  信息编号：{$parttime.PartTime.id}  该信息被浏览 {$parttime.PartTime.clicked + $clicked} 次 </p>
        <table class="posInfo" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th width="119" scope="row">公司名称：</th>
            <td width="373"><a href="javascript:void(0)" target="_blank" class="red">{$parttime.Member.company_name}</a></td>
          </tr>
          <tr>
            <th width="119" scope="row">营业执照：</th>
            <td width="373"><font color="#FF0000">已验证</font></td>
          </tr>
          <tr>
            <th width="25%" scope="row">产品所属分类：</th>
            <td width="68%">
            {$this->Category->getCategoryName($parttime.PartTime.category)} 
            {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
            </td>
          </tr>
          <tr>
            <th width="25%" scope="row">产品具体名称：</th>
            <td width="68%">{$parttime.PartTime.sub_title}</td>
          </tr>
          <tr>
            <th scope="row">兼职时间：</th>
            <td>{$parttime.PartTime.open|date_format:"%Y-%m-%d"} 至 {$parttime.PartTime.close|date_format:"%Y-%m-%d"}</td>
          </tr>
          <tr>
            <th scope="row">客户区域范围：</th>
            <td>
            {$citys = explode(',', $parttime.PartTime.area)}
            {foreach $citys as $city_id}
            {$this->City->cityName($city_id)}&nbsp;&nbsp;
            {/foreach}
            </td>
          </tr>
          <tr>
            <th scope="row">兼职配合方式：</th>
            <td>
                {if $parttime.PartTime.method == 1}
                提供客户信息
                {elseif $parttime.PartTime.method == 2}
                协助跟单
                {else}
                独立签单
                {/if}
            </td>
          </tr>
          <tr>
            <th scope="row">报酬：</th>
            <td>
            {if $parttime.PartTime.pay == 1}
                按合同金额：{$parttime.PartTime.pay_rate}%
                {else}
                协商确定
                {/if}
            </td>
          </tr>
          <tr>
            <th scope="row">报酬支付时间：</th>
            <td>
                {if $parttime.PartTime.pay_method == 1}
                收款后{$parttime.PartTime.pay_time}个工作日内转账
                {else}
                其它
                {/if}
            </td>
          </tr>
          <tr>
            <th scope="row" style="vertical-align:top">报酬支付补充说明：</th>
            <td>{$parttime.PartTime.pay_explanation}</td>
          </tr>
          <tr>
            <th scope="row">推荐参与行业：</th>
            <td>
            {$categorys = explode(',', $parttime.PartTime.industry)}
            {foreach $categorys as $id}
            {$this->Category->getCategoryName($id)} 
            {/foreach}
            </td>
          </tr>
          <tr>
            <th scope="row">联系人：</th>
            <td>{$parttime.PartTime.contact}</td>
          </tr>
          {$contact_methods = json_decode($parttime.PartTime.contact_method, true)}
          {foreach $contact_methods as $value}
          <tr>
            <th scope="row">联系方式：</th>
            <td>{$value.method} {$value.number}</td>
          </tr>
          {/foreach}
          <tr>
            <th scope="row">联系邮箱：</th>
            <td>{$parttime.PartTime.email}</td>
          </tr>
          <tr>
            <th scope="row">公司地址：</th>
            <td>{$parttime.PartTime.address}</td>
          </tr>
          <tr>
            <th scope="row">兼职补充说明：</th>
            <td><p>{$parttime.PartTime.additional}</p></td>
          </tr>
        </table>
      </div>    
        {if $memberInfo.Member.type == Configure::read('UserType.Personal')} 
            <div class="divBtnContainer" style="width:200px">       
            <a class="zclan zclan7 btnDeliverR" href="javascript:void(0)">我有客源</a>
            <input type="hidden" id="part_times_id" name="part_times_id" value="{$this->request->query['id']}" />
            {if !$isFavourite}             
                <a class="zclan zclan7" href="javascript:void(0)" id="favourite">收藏</a>                      
            {/if}
            </div>  
        {else}
          <div class="divBtnContainer" style="width:200px">
            <a class="zclan zclan7" href="qy-fbjz.html">编辑</a>
            <a class="zclan zclan7" href="javascript:if(confirm('确定删除此兼职？')) window.open('qy-jzfblb.html','_self');">删除</a>
          </div>
        {/if}
    </div>    
</div>
<input type="hidden" id="category" value="{$parttime.PartTime.sub_category}">
<input type="hidden" id="parttime_id" value="{$parttime.PartTime.id}">
<input type="hidden" id="target_member" value="{$parttime.PartTime.members_id}">
{if $memberInfo.Member.type == Configure::read('UserType.Personal')}
{/if}
