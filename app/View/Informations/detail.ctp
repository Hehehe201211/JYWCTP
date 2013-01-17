<script type="text/javascript">
{literal}
$(document).ready(function(){
    $('.cancel').click(function(){
        if (confirm("你确定要撤销此信息吗？")) {
            $.ajax({
                url : '/informations/ajax_cancel',
                type : 'post',
                data : 'information_id=' + $('#information_id').val(),
                success : function(data){
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        //$('.buttons').hide();
                        //location.href = "/cancel/listview";
                        location.href = "/informations/issue/?type=" + $('#info_type').val();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
    
    $('.delete').click(function(){
        if (confirm("你确定要删除此信息吗？")) {
            $.ajax({
                url : '/informations/ajax_delete',
                type : 'post',
                data : 'information_id=' + $('#information_id').val(),
                success : function(data){
                    var result = eval("("+data+")");
                    if (result.result == 'OK') {
                        location.href = "/informations/issue/?type=" + $('#info_type').val();
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
});
{/literal}
</script>
<div class="zy_z">
{if $information.Information.type == Configure::read('Information.type.need')}
<input type="hidden" id="info_type" value="need" />
{else}
<input type="hidden" id="info_type" value="has" />
{/if}
        <div class="sjle">
            <div class="tableDetail">
            <div class="biaotit">{$information.Information.title}</div>
      <table width="100%">
        <tr>
          <th width="25%">所在区域：</th>
          <td width="75%">
          {$provincial = $this->City->cityName({$information.Information.provincial})}
          {$city = $this->City->cityName({$information.Information.city})}
          {if $provincial == $city}
          {$provincial}
          {else}
          {$provincial}&nbsp;{$city}
          {/if}
          </td>
        </tr>
        {if $information.Information.type == 0}
         <tr>
          <th>行业：</th>
          <td>{$this->Category->getCategoryName({$information.Information.industries_id})}</td>
        </tr>
        {/if}
        <tr>
          <th>采购产品：</th>
          <td class="red">{$this->Category->getCategoryName({$information.Information.category})}
                                    {$this->Category->getCategoryName({$information.Information.sub_category})}
</td>
        </tr>
        <tr>
          <th>采购单位</th>
          <td class="red">{$information.Information.company}</td>
        </tr>               
        <tr>
          <th>信息交易价格：</th>
          <td>{if $information.Information.payment_type != 2}业务币：{$information.Information.price}元{/if}
                  {if $information.Information.payment_type != 1}积分：{$information.Information.point}分{/if}</td>
        </tr> 
        {if $information.Information.type == 0}        
        <tr>
          <th>联系人：</th>
          <td class="red">{$information.Information.contact}</td>
        </tr>
        <tr>
          <th>联系人职位：</th>
          <td class="red">{$information.Information.post}</td>
        </tr>
        {foreach $attributes as $att}
        <tr>
          <th>联系方式：</th>
          <td class="red">{$att.InformationAttribute.mode} {$att.InformationAttribute.contact_method}</td>
        </tr>
        {/foreach}
        <tr>
          <th>单位详细地址：</th>
          <td class="red">{$information.Information.address}</td>
        </tr>  
        {/if}  
                <tr>
          <th>有效期：</th>
          <td>{$information.Information.open|date_format:"%Y-%m-%d"} - {$information.Information.close|date_format:"%Y-%m-%d"}</td>
        </tr>
        {if $information.Information.type == 0}
        <tr>
          <th>预计合作金额：</th>
          <td>{if empty($information.Information.profit)}0{else}{$information.Information.profit}{/if}元人民币</td>
        </tr>
        <tr>
          <th>预计合作时间：</th>
          <td>{$information.Information.finished|date_format:"%Y-%m-%d"}</td>
        </tr>
   {/if}
        <tr>
          <th>客户选择服务商因素：</th>
          <td>{$information.Information.reason}</td>
        </tr>
        <tr>
          <th>信息详情：</th>
          <td><P>{$information.Information.introduction}</P></td>
        </tr>
        <tr>
          <th>采购补充：</th>
          <td><p>{$information.Information.additional}</p></td>
        </tr>
      </table>
      {if !$paid}
      <div class="divBtnContainer" style="width:300px;">
        {if $information.Information.status == Configure::read('Information.status_code.active')}
        <a class="zclan zclan7" href="/informations/edit?id={$information.Information.id}">修改</a>
        <a class="zclan zclan7 cancel" href="javascript:void(0)">撤销</a>
        {/if}
        <a class="zclan zclan7 delete" href="javascript:void(0)">删除</a>
        <input type="hidden" id="information_id" value="{$information.Information.id}" />                            
     </div>{/if}
 </div>
        </div>
</div>