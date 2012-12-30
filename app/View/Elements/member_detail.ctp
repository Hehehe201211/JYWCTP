<script type="text/javascript">
{literal}
$(document).ready(function(){
    $(".btnDeliverL").click(function(e){
        e.preventDefault();
        bgKuang("#jsxxxq1","#jsxxxq1 .closeDiv");           
    });
    $(".btnDeliverR").click(function(e){
        e.preventDefault();
        bgKuang("#jsxxxq2","#jsxxxq2 .closeDiv");           
    });
    $('#close #memberInfo').click(function(){
        $('.jsxxxqB .jsxxxq .closeDiv').click();
    });
});
{/literal}
</script>
<div id="jsxxxq1" class="jsxxxq jsxxxqB"> <a class="closeDiv" href="#">&nbsp;</a>
  <div class="xq_zl_xbxq">
  <div class="biaotit">{$sender.MemberAttribute.name}的会员信息</div>
  <div class="xq_zl_xbxq">
    <table width="100%">
      <tbody><tr>
        <th width="114" class="tdRight">真实姓名：</th>
        <td width="221">{$sender.MemberAttribute.name}</td>
        <td width="221" class="top" rowspan="7"><img src="images/tx.jpg" class="portrait">
          <p>&nbsp;</p>
          <input type="button" value="邀请兼职" class="btnDeliver inpButton"></td>
      </tr>
      <tr>
        <th class="tdRight">性别：</th>
        <td>{if $sender.MemberAttribute.sex}男{else}女{/if}</td>
      </tr>
      <tr>
        <th class="tdRight">行业：</th>
        <td>{$this->Category->getCategoryName($sender.MemberAttribute.category_id)}</td>
      </tr>
      <tr>
        <th class="tdRight">联系方式：</th>
        <td>{$sender.MemberAttribute.mobile}</td>
      </tr>
      <tr>
        <th class="tdRight">邮箱：</th>
        <td>{$sender.Member.email}</td>
      </tr>
      <tr>
        <th class="tdRight">所在城市：</th>
        <td>福建省厦门市</td>
      </tr>
      <tr>
        <th class="tdRight">联系地址：</th>
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
    </tbody></table>
  </div>
</div>
</div>