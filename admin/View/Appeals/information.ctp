<script type="text/javascript">
{literal}
$(document).ready(function(){
    var information_id = $('#information_id').val();
    var from_members_id = $('#from_members_id').val();
    var to_members_id = $('#to_members_id').val();
    $('#comments').load('/admin/comments/listview', {'information_id':information_id, 'from_members_id':from_members_id, 'to_members_id':to_members_id});
});
{/literal}
</script>
<div class="tilAppeal">申诉ID:{$this->request->data['id']}> 回答</div>
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
        <div class="biaotit"><strong class="red">申诉方</strong></div>
        <dl class="memInfo">
          <dt><img src="/admin/img/tx.jpg" /></dt>
          <dd>会员昵称：<strong>{$author.Member.nickname}({$author.MemberAttribute.name})</strong></dd>
          <dd>会员等级：高级会员</dd>
          <dd>绑定手机：{$author.MemberAttribute.mobile}</dd>
          <dd>绑定邮箱：{$author.Member.email}</dd>
          <dd>行业：{$this->Category->getCategoryName($author.MemberAttribute.category_id)}</dd>
          <dd>地址：
          {$provincial = $this->City->cityName($author.MemberAttribute.provincial_id)}
          {$city = $this->City->cityName($author.MemberAttribute.city_id)}
          {if $provincial == $city}
          {$provincial}
          {else}
          {$provincial} {$city}
          {/if}
          </dd>
          </dd>
        </dl>
        <div class="biaotit">申诉理由</div>
      <p class="reason">{$appeal.Appeal.content}</p>
      </div>
      <div class="divLeft divRight">
        <div class="biaotit"><strong class="red">投诉方</strong></div>
        <dl class="memInfo">
          <dt><img src="/admin/img/tx.jpg" /></dt>
          <dd>会员昵称：<strong>{$buyer.Member.nickname}({$buyer.MemberAttribute.name})</strong></dd>
          <dd>会员等级：高级会员</dd>
          <dd>绑定手机：{$buyer.MemberAttribute.mobile}</dd>
          <dd>绑定邮箱：{$buyer.Member.email}</dd>
          <dd>行业：{$this->Category->getCategoryName($buyer.MemberAttribute.category_id)}</dd>
          <dd>地址：
          {$provincial = $this->City->cityName($buyer.MemberAttribute.provincial_id)}
          {$city = $this->City->cityName($buyer.MemberAttribute.city_id)}
          {if $provincial == $city}
          {$provincial}
          {else}
          {$provincial} {$city}
          {/if}
          </dd>
          </dd>
        </dl>
        <div class="biaotit">投诉理由</div>
      <p class="reason">{$compalint.InformationComplaint.reason}</p>
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
              <td class="tdRight">信息交易价格：</td>
              <td class="tdLeft">
              {if $transaction.PaymentTransaction.payment_type == 1}
                            聚客币：{$transaction.PaymentTransaction.number}元
            {else if $transaction.PaymentTransaction.payment_type == 2}
                            积分：{$transaction.PaymentTransaction.number}分
            {/if}
              </td>
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
      {if !empty($target)}
        <div class="xq_zl_xbxq">
          <div class="biaotit">{$target.Information.title} <strong>(悬赏)</strong></div>
          <table width="100%">
              <tr>
              <td width="96" class="tdRight">客源地区：</td>
              <td width="227" class="tdLeft">
              {$provincial = $this->City->cityName($target.Information.provincial)}
              {$city = $this->City->cityName($target.Information.city)}
              {if $provincial == $city}
              {$provincial}
              {else}
              {$provincial} {$city}
              {/if}
              </td>
            </tr>
              <tr>
                <td class="tdRight connection">产品提供单位：</td>
                <td class="tdLeft">
                {$target.Information.company}
                </td>
              </tr>
              <tr>
                <td class="tdRight">产品名称：</td>
                <td class="tdLeft">
                {$this->Category->getCategoryName($target.Information.category)}
                {$this->Category->getCategoryName($target.Information.sub_category)}
                </td>
              </tr>   
              <tr>
                <td class="tdRight">悬赏有效期：</td>
                <td class="tdLeft">{date("Y-m-d", strtotime({$target.Information.open}))} - {date("Y-m-d", strtotime({$target.Information.close}))}</td>
              </tr>           
              <tr>
                <td class="tdRight">客源悬赏价格：</td>
                <td class="tdLeft">
                {if $target.Information.payment_type != 2}聚客币：{$target.Information.price}元{/if}
                {if $target.Information.payment_type != 1}积分：{$target.Information.price}分{/if}
                </td>
              </tr> 
              <tr>
                <td class="tdRight">客源选择因素：</td>
                <td class="tdLeft">
                {$target.Information.reason}
                </td>
              </tr>
              <tr>
                <td class="tdRight">产品信息描述：</td>
                <td class="tdLeft">
                <p>{$information.Information.introduction}</p>
                </td>
              </tr>
              <tr>
                <td class="tdRight">产品的补充说明：</td>
                <td class="tdLeft">{$information.Information.additional}</td>
              </tr>
            </table>
        </div>
        {/if}
      </div>
    </div>
    <div class="conAppeal" id="comments">

    </div>
      
<div class="conAppeal">
<div class="payProblem">
<form id="answer" >
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tablePTSSXQ">
    <tr>
    <th colspan="3">平台申诉确认参考标准</th>
    </tr>
    {foreach $templates as $key => $template}
    <tr>
    {$label = explode(';', {$template.AppealAnswerTemplate.label})}
        <td width="32%">{$key + 1}、{$template.AppealAnswerTemplate.title}</td>
        <td class="tableR" width="15%">
            <input name="template_answer{$template.AppealAnswerTemplate.id}" type="radio" class="inpRadio" {if empty($answers)} {else if $answers[$key]['AppealAnswer']['answer'] == 1}{/if}  value="1" />
                <label for="inpRadio11">{$label[0]}</label>
            <div class="clearfix1"></div>
            <input type="radio" name="template_answer{$template.AppealAnswerTemplate.id}" {if !empty($answers) && $answers[$key]['AppealAnswer']['answer'] == 0}{/if} class="inpRadio" value="0"/>
                <label for="inpRadio12">{$label[1]}</label>
        </td>
        <td width="53%">
            <textarea class="textarea" name="content{$template.AppealAnswerTemplate.id}">{if !empty($answers)}{$answers[$key]['AppealAnswer']['content']}{/if}</textarea>
        </td>
    </tr>
    {if !empty($answers)}
    <input type="hidden" name="id{$template.AppealAnswerTemplate.id}" value="{$answers[$key]['AppealAnswer']['id']}">
    {/if}
    <input type="hidden" name="templateId[]" value="{$template.AppealAnswerTemplate.id}">
    {/foreach}
  <tr>
    <td align="right">请选择评定结果：</td>
    <input type="hidden" value="1" id="result" name="result" />
    <input type="hidden" value="{$this->data['id']}" id="appeal_id" name="appeal_id" />
    <td class="tableR"><input type="button" value="有效" id="active" />
    <div style="height:8px;">&nbsp;</div>
    <input type="button" value="无效" id="unactive" /></td>
    <td>
        <textarea class="textarea" name="answerPlatform">{if !empty($answers)}{$appeal['Appeal']['platform_answer']}{/if}</textarea>
    </td>
  </tr>
</table>
</form>
  </div>
    </div>
    <div class="clearfix1"></div>
  </div>
</div>

<input type="hidden" name="information_id" id="information_id" value="{$information.Information.id}" />
<input type="hidden" name="from_members_id" id="from_members_id" value="{$author.Member.id}" />
<input type="hidden" name="to_members_id" id="to_members_id" value="{$buyer.Member.id}" />
