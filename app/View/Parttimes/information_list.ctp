{literal}
<script type="text/javascript">
$(document).ready(function(){
    //check number
    $('#yanzhengma').after('<img id="code" src="/members/image">');
    $('#getCheckNum').click(function(){
        var src = '/members/image/' + Math.random();
        $('#code').attr('src', src);
    });
})
</script>
{/literal}
<a href="#" class="closeDiv">&nbsp;</a>
  <div class="sjle">
    <ul>      
      <li>
        <label><font class="facexh">*</font>选择客源：</label>
        {if !empty($informations)}
        <ul class="products keyuan">
        {foreach $informations as $info}
            <li>
                <input type="checkbox" name="information_id[]" class="information_id" value="{$info.Information.id}" />
                <label for="devResume1">{$info.Information.title}</label>
            </li>
        {/foreach}
        </ul>
      </li>
      <li>
        <label><font class="facexh">*</font>验证码：</label>
        <input type="text" txt="输入验证码" class="yanzhengma" id="yanzhengma" value="输入验证码" name="checkNum">
        <a href="javascript:void(0)" id="getCheckNum">看不清楚？换一个</a>
    </li>
    </ul>   
    <div class="clear">&nbsp;</div> 
    <a href="javascript:void(0);" id="candidate" class="zclan zclan2">马上投递</a> 
    <a href="/informations/create/has/?parttime={$this->request->data['parttime_id']}&target_member={$this->request->data['target_member']}" target="_blank" class="zclan zclan2">不在现有中</a>
    {else}
    <ul class="products keyuan">
            没有相关行业的客源可以选择，请点击【不在现有中】按钮！
    </ul>
    <div class="clear">&nbsp;</div>
    <a href="/informations/create/has/?parttime={$this->request->data['parttime_id']}&target_member={$this->request->data['target_member']}" target="_blank" class="zclan zclan4">不在现有中</a>
    {/if}    
  </div>
