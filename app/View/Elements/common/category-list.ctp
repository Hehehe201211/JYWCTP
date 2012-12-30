<div class="suckerdiv">
    <h3>产品分类</h3>
    <ul id="suckertree1">
    {foreach $menuList as $menu}
        <li>
            <a href="javascript:void(0)" class="search_category">
            {$menu.Category.name}
            <input type="hidden" value="{$menu.Category.id}" class="category_id" />
            </a>
            <ul>
                {foreach $menu.Category.subMenu as $sub}
                    <li>
                        <a href="javascript:void(0)" class="search_category">
                        {$sub.Category.name}
                        <input type="hidden" value="{$sub.Category.id}" class="category_id" />
                        </a>
                    </li>
                {/foreach}
            </ul>
        </li>
    {/foreach}
    </ul>
</div>