{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('#provincial').change(function(){
            $('#city').find('option:gt(0)').remove();
            if ($(this).val() != "") {
                $.ajax({
                    'type' : 'Get',
                    'url'  : '/informations/getCityList/' + $(this).val(),
                    'success':function(data){
                        var dataobj=eval("("+data+")");
                        var optionStr = "";
                        $.each(dataobj, function(idx, item){
                            optionStr += '<option value="'+item.City.id+'">' + item.City.name + '</option>'
                        });
                        $('#city').append(optionStr);
                    }
                });
            }
        });
    });

</script>
{/literal}
<div class="zy_z">
    <div class="xxjs">
        <div class="biaotit">悬赏检索</div>
        <ul>
            <li>
                <label>产品：</label>
                <select name="产品">
                    <option>请选择省份</option>
                    <option>福建</option>
                    <option>陕西</option>
                    <option>山西</option>
                </select>
            </li>
            <li>
                <label>省份：</label>
                <select name="provincial" id="provincial">
                    <option value="">请选择省份</option>
                    {foreach $cityList as $city}
                        <option value="{$city.City.id}">{$city.City.name}</option>
                    {/foreach}
                </select>
            </li>
            <li>
                <label>城市：</label>
                <select name="city" id="city">
                    <option>请选择省份</option>
                </select>
            </li>
            <li>
                <label>行业：</label>
                <select name="hangye">
                    <option>请选择省份</option>
                    <option>福建</option>
                    <option>陕西</option>
                    <option>山西</option>
                </select>
            </li>
            <li>
                <label>发布日期：</label>
                <select id="faburiqi" name="faburiqi">
                    <option value="0">当天</option>
                    <option value="1">一天内</option>
                    <option value="2">两天内</option>
                    <option value="3">三天内</option>
                    <option value="7" selected="selected">一周内</option>
                    <option value="15">半月内</option>
                    <option value="30">一月内</option>
                    <option value="60">两月内</option>
                    <option value="90">三月内</option>
                    <option value="180">半年内</option>
                    <option value="365">全部有效信息</option>
                </select>
            </li>
            <li>
                <label>关键字：</label>
                <input type="text" name="keyword">
            </li>
            <li>
                <label style="margin-top: 7px">信息价格：</label>
                <input type="text" id="amount-jiage">
                <div style="margin-left: 80px" id="slider-price" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                    <div class="ui-slider-range ui-widget-header" style="left: 4%; width: 56%;"></div>
                    <a href="#" class="ui-slider-handle ui-state-default ui-corner-all" style="left:4%;"></a>
                    <a href="#" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 60%;"></a>
                </div>
            </li>
            <li>
                <label style="margin-top: 7px">收益：</label>
                <input type="text" id="amount-shouyi">
                <div style="margin-left: 80px" id="slider-shouyi" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                    <div class="ui-slider-range ui-widget-header" style="left: 4%; width: 56%;"></div>
                    <a href="#" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 4%;"></a>
                    <a href="#" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 60%;"></a>
                </div>
            </li>
        </ul>
        <a href="#" class="zclan">查询</a>
    </div>
    <div class="xijs_dtu"><img src="{$this->webroot}img/dt.jpg"></div>
    <div class="biaotit">检索结果</div>
    <div id="informationList">
    {$this->element('paginator')}
    </div>
</div>