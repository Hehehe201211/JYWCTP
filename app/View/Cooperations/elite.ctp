<script type="text/javascript">
{literal}
$(document).ready(function(){
    
    //边框
    $(".xxjs .eliteR li").hover(function(){
        if($(this).children("a").length!=0) $(this).css("border-color","#F50");
    },function(){
        $(this).css("border-color","#ccc");
    });
    
    //地图检索
    var strPosition;
    $(".toggleMap").toggle(function(){
        $(".divMapCon").show("fast",function(){
           strPosition=new googlemapjsv3({lat:"",lng:"",strCompany:"",pChange:false});
        });
        $(this).text("隐藏地图检索");
    },function(){
        $(".divMapCon").hide("fast");
        $(this).text("打开地图检索");
        strPosition=null;
    });
    $("#codeAddress").click(function(){
        var a=document.getElementById("geostrPosition").value;
        strPosition.codeAddress(a);
    });
});
{/literal}
</script>
<div class="zy_z">
    <div class="zy_zs"><!-- InstanceBeginEditable name="EditRegion7" -->
      <p><a href="qy-hyzy.html">我的聚业务</a>&gt;&gt;<a href="qy-jzfbmx.html">兼职管理</a>&gt;&gt;<a href="#">信息概览</a></p>
      <!-- InstanceEndEditable -->
    </div>
    <!-- InstanceBeginEditable name="EditRegion5" --> 
    <div class="xxjs partTime" style="overflow-y:visible;min-height:460px;">
      <div class="biaotit">业务精英检索</div>
      <div class="advance_seach">
        <div class="switch_box">
          <div class="divTable divTableCity">
            <div class="divtt">
              <div class="left fl"><strong>城市选择器</strong>(最多可选5项)</div>
              <div class="right fr">[确定]</div>
            </div>
            <dl>
              <dt class="goback"><a href="#">返回省份</a></dt>
              <dl class="options">
                <dd>
                  <input type="checkbox" class="inpCheckbox"  value="2"/>
                  <a href="#">北京</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="3"/>
                  <a href="#">上海</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="4"/>
                  <a href="#">深圳</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="5"/>
                  <a href="#">天津</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="6"/>
                  <a href="#">福建</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="7"/>
                  <a href="#">广东</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">江苏</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">浙江</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">重庆</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">山东</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">河北</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">四川</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">湖北</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">湖南</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">安徽</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">海南</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">云南</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">黑龙江</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">辽宁</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">吉林</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">广西</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">山西</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">江西</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">陕西</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">贵州</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">甘肃</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">宁夏</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">内蒙古</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">新疆</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">青海</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox"/>
                  <a href="#">西藏</a></dd>
              </dl>
              <dl class="subOptions">
              </dl>
              <dt>您已经选择的城市是:(点击可以取消选择)</dt>
              <dl class="selected">
              </dl>
            </dl>
            <div class="divtt">
              <div class="right fr">[确定]</div>
            </div>
          </div>
          <div class="divTable divTableTrade">
            <div class="divtt">
              <div class="left fl"><strong>行业选择器</strong>(最多可选5项)</div>
              <div class="right fr">[确定]</div>
            </div>
            <dl>
              <dt class="goback"><a href="#">行业</a></dt>
              <dl class="options">
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="1"/>
                  <a href="#">网络</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="2"/>
                  <a href="#">广告</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="3"/>
                  <a href="#">教育培训</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="4"/>
                  <a href="#">人才招聘</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="5"/>
                  <a href="#">原料设备</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="6"/>
                  <a href="#">房产</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="7"/>
                  <a href="#">装修装饰</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="8"/>
                  <a href="#">设计</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="9"/>
                  <a href="#">礼仪庆典</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="10"/>
                  <a href="#">服务咨询</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="11"/>
                  <a href="#">展会</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="12"/>
                  <a href="#">投资理财</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="13"/>
                  <a href="#">保险</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="14"/>
                  <a href="#">旅游</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="15"/>
                  <a href="#">汽车</a></dd>
              </dl>
              <dl class="subOptions">
              </dl>
              <dt>您已经选择的城市是:(点击可以取消选择)</dt>
              <dl class="selected">
              </dl>
            </dl>
            <div class="divtt">
              <div class="right fr">[确定]</div>
            </div>
          </div>
          <div class="divTable divTableProduct">
            <div class="divtt">
              <div class="left fl"><strong>产品或服务</strong>(最多可选5项)</div>
              <div class="right fr">[确定]</div>
            </div>
            <dl>
              <dt class="goback"><a href="#">返回产品或服务</a></dt>
              <dl class="options">
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="1"/>
                  <a href="#">网络</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="2"/>
                  <a href="#">广告</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="3"/>
                  <a href="#">教育培训</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="4"/>
                  <a href="#">人才招聘</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="5"/>
                  <a href="#">原料设备</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="6"/>
                  <a href="#">房产</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="7"/>
                  <a href="#">装修装饰</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="8"/>
                  <a href="#">设计</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="9"/>
                  <a href="#">礼仪庆典</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="10"/>
                  <a href="#">服务咨询</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="11"/>
                  <a href="#">展会</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="12"/>
                  <a href="#">投资理财</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="13"/>
                  <a href="#">保险</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="14"/>
                  <a href="#">旅游</a></dd>
                <dd>
                  <input type="checkbox" class="inpCheckbox" value="15"/>
                  <a href="#">汽车</a></dd>
              </dl>
              <dl class="subOptions">
              </dl>
              <dt>您已经选择的城市是:(点击可以取消选择)</dt>
              <dl class="selected">
              </dl>
            </dl>
            <div class="divtt">
              <div class="right fr">[确定]</div>
            </div>
          </div>
          <ul>
            <li class="city"><span class="title">
              <input type="button" class="inpButton" value="城市（可选）"/>
              </span>
            </li>
            <li class="trade"><span class="title">
              <input type="button" class="inpButton" value="行业（可选）"/>
              </span>
            </li>
            <li class="product"><span class="title">
              <input type="button" class="inpButton" value="产品或服务（可选）"/>
              </span>
            </li>
            <li class="keyword">
              <input type="text" name="inpKeyword" class="inpKeyword" value="请输入关键字"/>
            </li>
          </ul>
          <table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><ul class="ulTable ulTableCity"></ul></td>
    <td><ul class="ulTable ulTableTrade"></ul></td>
    <td><ul class="ulTable ulTableProduct"></ul></td>
  </tr>
</table>
          <ul>            
            <li style="width:190px;">性别：
              <select>
                <option>不限</option>
                <option>男</option>
                <option>女</option>
              </select>
            </li>
          </ul>
        </div>
        <div class="divMap">
          <div class="divMapCon">
            <div class="divInput">
              <input type="text" id="geostrPosition" value="输入地址查询"/>
              <input type="button" value="搜索" id="codeAddress"/>
              <input type="hidden" id="comlatlng" />
            </div>
            <div id="mapLayout"></div>
          </div>
        </div>
        <div class="toggleMap">打开地图检索</div>
        <a class="zclan zclan4" href="#">查询</a> </div>
    <div class="biaotit">检索结果</div>
     <ul class="eliteR">
        <li><a href="qy-ywjyjsxq1.html" target="_blank"><div class="avatar"><img src="images/tx.jpg" alt="xxx5202012"/></div><div class="name">xxx5202012</div><div>教育培训</div></a></li>
        <li><a href="qy-ywjyjsxq1.html" target="_blank"><div class="avatar"><img src="images/tx.jpg" alt="xxx5202012"/></div><div class="name">xxx5202012</div><div>教育培训</div></a></li>
        <li><a href="qy-ywjyjsxq1.html" target="_blank"><div class="avatar"><img src="images/tx.jpg" alt="xxx5202012"/></div><div class="name">xxx5202012</div><div>教育培训</div></a></li>
        <li><a href="qy-ywjyjsxq1.html" target="_blank"><div class="avatar"><img src="images/tx.jpg" alt="xxx5202012"/></div><div class="name">xxx5202012</div><div>教育培训</div></a></li>
        <li><a href="qy-ywjyjsxq1.html" target="_blank"><div class="avatar"><img src="images/tx.jpg" alt="xxx5202012"/></div><div class="name">xxx5202012</div><div>教育培训</div></a></li>
        <li><a href="qy-ywjyjsxq1.html" target="_blank"><div class="avatar"><img src="images/tx.jpg" alt="xxx5202012"/></div><div class="name">xxx5202012</div><div>教育培训</div></a></li>
        <li><a href="qy-ywjyjsxq1.html" target="_blank"><div class="avatar"><img src="images/tx.jpg" alt="xxx5202012"/></div><div class="name">xxx5202012</div><div>教育培训</div></a></li>
        <li>&nbsp;</li>
        <li>&nbsp;</li>
        <li>&nbsp;</li>
      </ul>
    </div>
    <table width="596" border="0" cellspacing="0" cellpadding="0" class="con_2_table">     
      <tr>
        <td class="fanyea_x"><div  class="fanyea">
            <div class="dd_span"><a href="#">上一页</a></div>
            <div class="dd_ym">
              <label>每页显示：</label>
              <select>
                <option>100</option>
                <option>50</option>
                <option>20</option>
                <option>10</option>
              </select>
            </div>
            <div class="dd_ym11"> <font>共64388条</font> <font>第1/644页</font>
              <input/>
              <div class="dd_span1"><a href="#">跳转</a></div>
            </div>
            <div class="dd_span"><a href="#">下一页</a></div>
          </div></td>
      </tr>
    </table>
    <!-- InstanceEndEditable -->
</div>