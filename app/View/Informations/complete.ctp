<div class="zy_z">
    <ul class="ulFormStep ulFormStep3">
        <li>1.填写发布信息</li>
        <li>2.确认信息</li>
        <li>3.发布成功</li>
    </ul>
        {if $error}
            <p class="gongxi">{$message}</p>
        {else}
            <p class="gongxi">{$message}</p>
            <p class="gongxiLink">
                <a id="xxChakan" href="/informations/detail/{$id}">查看该信息&gt;&gt;</a>
                <a id="xxWanshan" href="/informations/edit?id={$id}">完善该信息&gt;&gt;</a>
                {if $this->data['type'] != Configure::read('Information.type.need')}
                <a id="xxXinjian" href="/informations/create/has">再发布一条&gt;&gt;</a>
                {else}
                <a id="xxXinjian" href="/informations/create/need">再发布一条&gt;&gt;</a>
                {/if}
            </p>
        {/if}
</div>