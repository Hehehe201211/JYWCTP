<div class="zy_z">
    <div class="zy_zs">
      <p><a href="javascript:void(0)">我的聚业务</a>&gt;&gt;<a href="javascript:void(0)">资金管理</a>&gt;&gt;<a href="javascript:void(0)">充值记录</a></p>
    </div>
    <!-- InstanceBeginEditable name="EditRegion5" --> 
     <div class="zhanghujil">
        <div class="zhanghujil_top">
            <a href="new-zhye.html">账户余额</a>
            <a id="dangq" href="new-czjl.html">账户充值</a>
            <a href="new-qbmx.html">账户明细</a>
        </div>
        <div class="rightBody">
         <div class="biaotit">给本账户充值</div>
        <form method="post" action="/alipays/check">
          <p>您的账户：{$memberInfo.Member.nickname} （请确认账号为您需要充值的账号）</p>
          <p>充值金额:<input type="text" id="topupNum" name="money" class="inpTextBox">元&nbsp;（1元聚客币=1元人民币）</p>
          <p>
            <label>
              <input type="checkbox" autocomplete="off" value="" name="iagree" class="inpCheckbox">我已仔细阅读过
              <a style="color:#f30;" target="_blank" href="#">《聚业务服务暂定协议》</a>。
            </label>
          </p>
        <div style="TEXT-ALIGN: center">
          <button style="MARGIN: 5px 0px" type="submit">请勾选上述条款，进入下一步</button>
        </div>
        </form>
        <div class="biaotit">充值记录</div>
      <table width="596" cellspacing="0" cellpadding="0" border="0" class="con_2_table">
      <thead>
        <tr class="con_2_tr con_2_xq_too"> 
          <th class="tr_td5">途径 </th>
          <th class="tr_td2">金额 </th>
          <th class="tr_td7">时间 </th>
          <th class="tr_td4">状态 </th>
          <th class="tr_td1">备注</th>
          <th class="tr_td8">选择操作 </th>
        </tr>
        </thead>
        <tbody>
        <tr class="con_2_tr">
          <td class="tr_td5">支付宝</td>
          <td class="tr_td2">2000元</td>
          <td class="tr_td7">2012-8-1 11:11</td>
          <td class="tr_td4">充值成功</td>
          <td class="tr_td1">公司标志制作</td>      
          <td class="con_2_xq_tofu tofu_anniu">
          <a href="javascript:void(0)" style="font-weight: normal;">删除记录</a>
          </td>
        </tr>
        <tr class="even">
          <td class="fanyea_x" colspan="6"><div class="fanyea">
              <div class="dd_span"><a href="#" style="font-weight: bold;">上一页</a></div>
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
                <input class="inpTextBox" id="acpro_inp3">
                <div class="dd_span1"><a href="#" style="font-weight: bold;">跳转</a></div>
              </div>
              <div class="dd_span"><a href="#" style="font-weight: bold;">下一页</a></div>
            </div></td>
        </tr>
      </tbody></table>
        </div>  
      </div>         
  </div>