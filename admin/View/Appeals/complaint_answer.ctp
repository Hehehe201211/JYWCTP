<script type="text/javascript">
{literal}
$(document).ready(function(){
    var cooperations_id = $('#cooperations_id').val();
    var sender = $('#sender').val();
    var receiver = $('#receiver').val();
    $('#comments').load('/admin/comments/complaintlist', {'cooperations_id':cooperations_id, 'sender':sender, 'receiver':receiver});
	
    $("#company").click(function(){
        $('#company_result input:radio').removeAttr("disabled");
        $('#personal_result input:radio').attr("disabled", "disabled");
        $('#personal_result input:radio').removeAttr("checked");
    });
    $("#personal").click(function(){
        $('#company_result input:radio').attr("disabled", "disabled");
        $('#company_result input:radio').removeAttr("checked");
        $('#personal_result input:radio').removeAttr("disabled");
    });
    $('#submit').live('click', function(){
        if (confirm('确定提交信息？')) {
            var formData = $('#answer').serialize();
            $.ajax({
                url : '/admin/answers/complaint',
                type: 'post',
                data: formData,
                success: function(data) {
                    var result = eval("("+data+")");
                    if(result.result == 'OK') {
                        alert('发送成功！。');
                        window.location.reload();
                    } else {
                        alert('系统出错，处理失败，请稍后重试！');
                    }
                }
            });
        }
    })
});
{/literal}
</script>
<div class="tilAppeal">投诉ID:{$this->request->data['id']}> 回答</div>
<div class="corAppeal">
  <ul class="ulAppeal">
    <li class="active">双方信息</li>
    <li>客源信息</li>
    <li>站内交流</li>
    <li>申诉判定</li>
  </ul>
  <div class="divAppeal">
    <div class="conAppeal" style="display:block">
      <div class="divLeft">
        <div class="biaotit"><strong class="red">投诉方</strong></div>
        <dl class="memInfo">
          <dt><img src="/admin/img/tx.jpg" /></dt>
          <dd>会员昵称：<strong>{$sender.Member.nickname}</strong></dd>
          <dd>会员等级：高级会员</dd>
          <dd>真实姓名：{$sender.MemberAttribute.name}</dd>
          <dd>绑定手机：{$sender.MemberAttribute.mobile}</dd>
          <dd>绑定邮箱：{$sender.Member.email}</dd>
          <dd>行业：{$this->Category->getCategoryName($sender.MemberAttribute.category_id)}</dd>
          <dd>地址：
          {$provincial = $this->City->cityName($sender.MemberAttribute.provincial_id)}
          {$city = $this->City->cityName($sender.MemberAttribute.city_id)}
          {if $provincial == $city}
          {$provincial}
          {else}
          {$provincial} {$city}
          {/if}
          </dd>
          </dd>
        </dl>
        <div class="biaotit">合作投递时间</div>
      <p class="reason">[{date('Y-m-d', strtotime($cooperation.Cooperation.created))}]</p>
        <div class="biaotit">投诉理由</div>
      <p class="reason">{$complaint.CooperationComplaint.reason} [{date('Y-m-d', strtotime($complaint.CooperationComplaint.created))}]</p>
      </div>
      <div class="divLeft divRight">
        <div class="biaotit"><strong class="red">被诉方</strong></div>
        <dl class="memInfo">
          <dt><img src="/admin/img/tx.jpg" /></dt>
          <dd>会员昵称：<strong>{$receiver.Member.nickname}({$receiver.MemberAttribute.full_name})</strong></dd>
          <dd>会员等级：高级会员</dd>
          <dd>公司名称：{$receiver.Member.company_name}</dd>
          <dd>行业：{$this->Category->getCategoryName($receiver.MemberAttribute.category_id)}</dd>
          <dd>地址：
          {$provincial = $this->City->cityName($receiver.MemberAttribute.provincial_id)}
          {$city = $this->City->cityName($receiver.MemberAttribute.city_id)}
          {if $provincial == $city}
          {$provincial}
          {else}
          {$provincial} {$city}
          {/if}
          </dd>
          <dd>联系人：{$receiver.MemberAttribute.contact}</dd>
          {$contacts = json_decode($receiver.MemberAttribute.contact_method, true)}
          {foreach $contacts as $contact}
            <dd>联系方式：{$contact.method} {$contact.content}</dd>
          {/foreach}
          </dd>
          <dd>联系邮箱：{$receiver.Member.email}</dd>
        </dl>
        <div class="biaotit">确认合作时间</div>
      <p class="reason">[{date('Y-m-d', strtotime($cooperation.Cooperation.allow_dt))}]</p>
      </div>
    </div>
   
    <div class="conAppeal">
      <div class="divLeft">
        <div class="xq_zl_xbxq">
          <div class="biaotit">{$information.Information.title}<strong class="red">(客源)</strong></div>
          <table width="100%">
            <tr>
              <td width="96" class="tdRight">客源地区：</td>
              <td width="227" class="tdLeft">
              {$provincial = $this->City->cityName($information.Information.provincial)}
              {$city = $this->City->cityName($information.Information.city)}
              {if $provincial == $city}
              {$provincial}
              {else}
              {$provincial} {$city}
              {/if}
              </td>
            </tr>
            <tr>
              <td width="96" class="tdRight">行业：</td>
              <td class="tdLeft">{$this->Category->getCategoryName($information.Information.industries_id)}</td>
            </tr>
            <tr>
              <td class="tdRight ">采购单位：</td>
              <td class="tdLeft">{$information.Information.company}</td>
            </tr>
            <tr>
              <td class="tdRight">产品名称：</td>
              <td class="tdLeft">
              {$this->Category->getCategoryName($information.Information.category)}
              {$this->Category->getCategoryName($information.Information.sub_category)}
              </td>
            </tr>
            <tr>
              <td class="tdRight">客源有效期：</td>
              <td class="tdLeft">{date("Y-m-d", strtotime({$information.Information.open}))} - {date("Y-m-d", strtotime({$information.Information.close}))}</td>
            </tr>
            <tr>
              <td class="tdRight">联系人：</td>
              <td class="tdLeft">{$information.Information.contact}</td>
            </tr>
            <tr>
              <td class="tdRight">联系人职位：</td>
              <td class="tdLeft">{$information.Information.post}</td>
            </tr>
            {foreach $informationAttributes as $value}
                <tr>
                  <td class="tdRight">联系方式：</td>
                  <td class="tdLeft">{$value.InformationAttribute.mode} {$value.InformationAttribute.contact_method}</td>
                </tr>
            {/foreach}
            <tr>
              <td class="tdRight">单位详细地址：</td>
              <td class="tdLeft">{$information.Information.address}</td>
            </tr>
            <tr>
              <td class="tdRight">预计合作金额：</td>
              <td class="tdLeft">{$information.Information.profit}元人民币</td>
            </tr>
            <tr>
              <td class="tdRight">预计合作时间：</td>
              <td class="tdLeft">{date("Y-m-d", strtotime({$information.Information.finished}))}</td>
            </tr>
            <tr>
              <td class="tdRight">客户选择因素：</td>
              <td class="tdLeft">{$information.Information.reason}</td>
            </tr>
            <tr>
              <td class="tdRight">采购需求描述：</td>
              <td class="tdLeft">
                <p>{$information.Information.introduction}</p>
              </td>
            </tr>
            <tr>
              <td class="tdRight">采购补充：</td>
              <td class="tdLeft"><p>{$information.Information.additional}</p></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="divLeft divRight">
        <div class="xq_zl_xbxq">
          <div class="biaotit">{$parttime.PartTime.title} <strong>(兼职)</strong></div>
          <table width="100%">
              <tr>
              <td width="96" class="tdRight">产品所属分类：</td>
              <td width="227" class="tdLeft">
              {$this->Category->getCategoryName($parttime.PartTime.category)} {$this->Category->getCategoryName($parttime.PartTime.sub_category)}
              </td>
            </tr>
              <tr>
                <td class="tdRight connection">产品具体名称：</td>
                <td class="tdLeft">
                {$parttime.PartTime.sub_title}
                </td>
              </tr>
              <tr>
                <td class="tdRight">兼职时间：</td>
                <td class="tdLeft">
                {date("Y-m-d", strtotime({$parttime.PartTime.open}))} - {date("Y-m-d", strtotime({$parttime.PartTime.close}))}
                </td>
              </tr> 
              <tr>
                <td class="tdRight">客户区域范围：</td>
                <td class="tdLeft">
                {$citys = explode(",", $parttime.PartTime.area)}
                {foreach $citys as $id}
                    {$this->City->cityName($id)}
                {/foreach}
                </td>
              </tr>   
              <tr>
                <td class="tdRight">兼职配合方式：</td>
                <td class="tdLeft">
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
                <td class="tdRight">报酬：</td>
                <td class="tdLeft">
                {if $parttime.PartTime.pay == 1}
                按合同金额百分比  {$parttime.PartTime.pay_rate}
                {else}
                协商确定
                {/if}
                </td>
              </tr> 
              <tr>
                <td class="tdRight">报酬支付时间：</td>
                <td class="tdLeft">
                {if $parttime.PartTime.pay_method == 1}
                收款后{$parttime.PartTime.pay_time}个工作日内转账
                {else}
                其它
                {/if}
                </td>
              </tr>
              <tr>
                <td class="tdRight">产品信息描述：</td>
                <td class="tdLeft">
                <p>
                {$categorys = explode(',', $parttime.PartTime.industry)}
                {foreach $categorys as $id}
                {$this->Category->getCategoryName($id)} 
                {/foreach}
                </p>
                </td>
              </tr>
              <tr>
                <td class="tdRight">联系人：</td>
                <td class="tdLeft">{$parttime.PartTime.contact}</td>
              </tr>
              {$contact_methods = json_decode($parttime.PartTime.contact_method, true)}
              {foreach $contact_methods as $key => $value}
              <tr>
                <td class="tdRight">联系方式：</td>
                <td class="tdLeft">
                {$value.method} {$value.number}
                </td>
              </tr>
              {/foreach}
              <tr>
                <td class="tdRight">联系邮箱：</td>
                <td class="tdLeft">{$parttime.PartTime.email}</td>
              </tr>
              <tr>
                <td class="tdRight">联系地址：</td>
                <td class="tdLeft">{$parttime.PartTime.address}</td>
              </tr>
              <tr>
                <td class="tdRight">报酬支付说明：</td>
                <td class="tdLeft">{$parttime.PartTime.pay_explanation}</td>
              </tr>
              <tr>
                <td class="tdRight">兼职补充说明：</td>
                <td class="tdLeft">{$parttime.PartTime.additional}</td>
              </tr>
            </table>
        </div>
      </div>
    </div>
    <div class="conAppeal" id="comments">

    </div>
    <div class="conAppeal">
        <div class="payProblem">
        {if $complaint.CooperationComplaint.status == 1}
            <form id="answer" >
                <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tablePTSSXQ tableJZSS">
                    <tr>
                       <th colspan="3">平台申诉确认参考标准</th>
                    </tr>
                    <tr>
                        <td width="21%" rowspan="3" style="vertical-align:text-top;font-size:14px;text-align:right;padding:12px 8px 0 0;">请选择评定结果：
                            <div style="height:60px;">&nbsp;</div>
                            <input type="button" value="确定" id="submit" />
                        </td>
                        <td class="tableR tableRJZ" width="19%">
                            <label>
                            <input name="result" value="1" type="radio" id="company" />企业会员违规
                            </label>
                        </td>
                        <td class="table2" width="60%" id="company_result">
                            <label>
                            <input name="result_code" type="radio" value="1" disabled="disabled"/>暂时关闭权限
                            </label>
                            <label>
                            <input name="result_code" type="radio" value="2" disabled="disabled"/>关闭账号并加入黑名单
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="tableR tableRJZ">
                            <label>
                            <input name="result" value="2" type="radio" id="personal"/>个人会员违规
                            </label>
                        </td>
                        <td class="table2" id="personal_result">
                            <!--<label>
                            <input name="result_code" type="radio" value="1"  disabled="disabled"/>违规，已违规2次
                            </label>
                            <label>
                            <input name="result_code" type="radio" value="2" disabled="disabled"/>违规超过3次，关闭此账号
                            </label>-->
                            <label>
                            <input name="inpRadio12" type="radio" class="inpRadio" disabled="disabled"/>违规</label>
                            <label id="">违规超过3次将被关闭账号，该会员之前已违规<span>{$sender.MemberAttribute.violation}</span>次</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="tableR">
                        <textarea class="textarea" name="remark" style="font-size:12px;width:500px;">备注。</textarea>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="cooperations_id" value="{$complaint.CooperationComplaint.cooperations_id}" >
                <input type="hidden" name="complaint_id" value="{$this->request->data['id']}" >
                <input type="hidden" name="sender" value="{$sender.Member.id}">
                <input type="hidden" name="receiver" value="{$receiver.Member.id}">
            </form>
            {else}
                <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tablePTSSXQ">
                    <tr>
                       <th colspan="3">平台申诉确认参考标准</th>
                    </tr>
                    {if $complaint.CooperationComplaint.result == 1}
                    <tr>
                        <td width="21%" rowspan="3" style="vertical-align:text-top;font-size:14px;text-align:right;padding:12px 8px 0 0;">请选择评定结果：
                            <div style="height:60px;">&nbsp;</div>
                        </td>
                        <td class="tableR" width="19%">
                            <label>企业会员违规</label>
                        </td>
                        <td class="table2" width="60%" id="company_result">
                            {if $complaint.CooperationComplaint.result_code == 1}
                            <label> 暂时关闭权限</label>
                            {else}
                            <label> 关闭账号并加入黑名单</label>
                            {/if}
                        </td>
                    </tr>
                    {else}
                    <tr>
                        <td class="tableR">
                            <label>个人会员违规</label>
                        </td>
                        <td class="table2" id="personal_result">
                            <label>记违规1次，该会员已违规<span>{$sender.MemberAttribute.violation}</span>次</label>
                        </td>
                    </tr>
                    {/if}
                    <tr>
                        <td colspan="2" class="tableR">
                        {$complaint.CooperationComplaint.remark}
                        </td>
                    </tr>
                </table>
            {/if}
        </div>
    </div>
    <div class="clearfix1"></div>
  </div>
</div>
<input type="hidden" name="cooperations_id" id="cooperations_id" value="{$complaint.CooperationComplaint.cooperations_id}" />
<input type="hidden" name="sender" id="sender" value="{$sender.Member.id}" />
<input type="hidden" name="receiver" id="receiver" value="{$receiver.Member.id}" />
