<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('#agree').click(function(){
        var data = 'id=' + $('#cooperations_id').val() + '&status=2&type=receiver';
        var action = '/cooperations/waitlist/?type=receiver'
        sendAjax(data, action);
    });
    $('#refuse').click(function(){
        var data = 'id=' + $('#cooperations_id').val() + '&status=3&type=receiver';
        var action = '/cooperations/completelist/?type=receiver'
        sendAjax(data, action);
    });
    function sendAjax(data, action)
    {
        $.ajax({
            url : '/cooperations/setStatus',
            type : 'post',
            data : data,
            success : function(data) {
                var result = eval("("+data+")");
                if (result.result == 'OK') {
                    location.href = action;
                } else {
                    alter(result.msg);
                }
            }
        })
    }
    $(".btnDeliverL").click(function(e){
        e.preventDefault();
        bgKuang("#jsxxxq1","#jsxxxq1 .closeDiv");           
    });
    $(".btnDeliverR").click(function(e){
        e.preventDefault();
        bgKuang("#jsxxxq2","#jsxxxq2 .closeDiv");           
    });
    $('#close').click(function(){
        $('.jsxxxqB .jsxxxq .closeDiv').click();
    });
});
{/literal}
</script>
<div class="zy_z">
  <div class="zy_zs">
    <p>
    <a href="javascript:void(0)">我的聚业务</a>&gt;&gt;
    <a href="javascript:void(0)">兼职管理</a>&gt;&gt;
    <a href="javascript:void(0)">客源提供记录详情</a>
    </p>
  </div>
  <div class="mebleft">
    <div class="biaotit"><strong>{$sender.MemberAttribute.name}的会员信息</strong></div>
    <table width="100%">
        <tbody><tr>
          <th width="114" class="tdRight">真实姓名：</th>
          <td width="221">{$sender.MemberAttribute.name}</td>
        </tr>
        <tr>
          <th class="tdRight">性别：</th>
          <td>{if $sender.MemberAttribute.sex}男{else}女{/if}</td>
        </tr>
        <tr>
          <th class="tdRight">行业：</th>
          <td>
          {$this->Category->getCategoryName($sender.MemberAttribute.category_id)}
          </td>
        </tr>  
        <tr>
          <th class="tdRight">联系方式：</th>
          <td>{$sender.MemberAttribute.mobile}</td>
        </tr>
        <tr>
          <th class="tdRight">所在城市：</th>
          <td>
          {$provincial = $this->City->cityName($sender.MemberAttribute.provincial_id)} 
          {$city = $this->City->cityName($sender.MemberAttribute.city_id)}
          {if $provincial != $city}
          {$provincial} {$city}
          {else}
          {$provincial}
          {/if}
          </td>
        </tr>
        <tr>
          <th class="tdRight">业务范围：</th>
          <td>{$sender.MemberAttribute.business_scope}</td>
        </tr>  
        <tr>
          <th class="tdRight">与公司合作：</th>
          <td>12次</td>
        </tr> 
        <tr>
          <th class="tdRight">成功合作：</th>
          <td>3次</td>
        </tr>      
      </tbody>
      </table>  
      <a class="btnMoreInfo btnDeliverL" href="javascript:void(0)" target="_blank">查看详情</a>
  </div>
  <div class="mebleft mebright">
    <div class="biaotit"><strong class="red">{$information.Information.title}(客源)</strong></div>
    <table width="100%">
      <tr>
        <th>采购单位：</th>
        <td>******</td>
      </tr>
      <tr>
        <th width="95">客户区域范围：</th>
        <td width="195">
            {$provincial = $this->City->cityName($information.Information.provincial)} 
            {$city = $this->City->cityName($information.Information.city)}
            {if $provincial != $city}
            {$provincial} {$city}
            {else}
            {$provincial}
            {/if}
        </td>
      </tr>
      <tr>
        <th>行业：</th>
        <td>{$this->Category->getCategoryName($information.Information.industries_id)} </td>
      </tr>
      <tr>
        <th>产品名称：</th>
        <td>
        {$this->Category->getCategoryName($information.Information.category)} 
        {$this->Category->getCategoryName($information.Information.sub_category)} 
        </td>
      </tr>
      <tr>
        <th>客源有效期：</th>
        <td>
        {$information.Information.open|date_format:"%Y-%m-%d"} 至  {$information.Information.close|date_format:"%Y-%m-%d"}
        </td>
      </tr>
      <tr>
        <th>联系人：</th>
        <td>******</td>
      </tr>
      <tr>
        <th>联系人职位：</th>
        <td>******</td>
      </tr>
      {foreach $inforAttr as $attr}
      <tr>
        <th>联系方式：</th>
        <td>
            {$attr.InformationAttribute.mode} ******
        </td>
      </tr>
      {/foreach}
      <tr>
        <th>单位详细地址：</th>
        <td>******</td>
      </tr>
      <tr>
    </table>
    <a class="btnMoreInfo btnDeliverR" href="javascript:void(0)" target="_blank">查看详情</a>  
  </div>
  <div class="clear">&nbsp;</div>
  <div class="xq_zl">
  <input type="hidden" id="cooperations_id" value="{$this->request->query['receiver']}">
  <div class="divBtnContainer" style="width:200px;">
  <a href="javascript:void(0)" id="agree" class="zclan zclan7">同意合作</a>
  <a href="javascript:void(0)" id="refuse" class="zclan zclan7">谢绝合作</a>
  </div>
  </div>
</div>
{$this->element('member_detail')}
{$hiddenContact = ['hiddenContact'=>1]}
{$this->element('information_detail', $hiddenContact)}