{literal}
<script type="text/javascript">
$(document).ready(function(){
    //check number
    $('#getCheckNum').prepend('<img id="code" src="/members/image">');
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
                <label><input type="checkbox" name="information_id[]" class="information_id" value="{$info.Information.id}" />{$info.Information.title}</label>
            </li>
        {/foreach}
        </ul>
      </li>
      <li>
        <label><font class="facexh">*</font>验证码：</label>
        <input type="text" class="yanzhengma" id="yanzhengma" name="checkNum" style="width:40px">
        <a href="javascript:void(0)" id="getCheckNum">看不清楚？换一个</a>
    </li>
    </ul>   
    <div class="clear">&nbsp;</div> 
    <div class="divBtnContainer" style="width:200px">
    <a href="javascript:void(0);" id="candidate" class="zclan zclan7">马上投递</a> 
    <a href="/informations/create/has/?parttime={$this->request->data['parttime_id']}&target_member={$this->request->data['target_member']}" target="_blank" class="zclan zclan7" onclick='$(".jsxxxqB .closeDiv").click();'>不在现有中</a>
    </div>
    {else}
    <ul class="products keyuan">
            没有相关行业的客源可以选择，请点击【不在现有中】按钮！
    </ul>
    <div class="clear">&nbsp;</div>
    <a href="/informations/create/has/?parttime={$this->request->data['parttime_id']}&target_member={$this->request->data['target_member']}" target="_blank" class="zclan zclan4" onclick='$(".jsxxxqB .closeDiv").click();'>不在现有中</a>
    {/if}    
  </div>
