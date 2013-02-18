{$form = ['isForm' => true, 'inline' => true]}
{$options = ['update' => '#informationList', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Paginator->options($options)}
{$paginatorParams = $this->Paginator->params()}
<ul>
    {foreach $companies as $company}
        <li>
            <a class="title" target="_blank" href="/homes/index/{$company.Homepage.domain}">
            <span>
            {$provincial = $this->City->cityName($company.CompanyAttribute.provincial_id)}
            {$city = $this->City->cityName($company.CompanyAttribute.city_id)}
            {if $provincial != $city}
                {$provincial}{$city}
            {else}
                {$provincial}
            {/if}
            </span>
            &nbsp;{$company.CompanyAttribute.full_name}
            </a>
            <div>
                <p class="textEllipsis left">
                <span>经营范围：</span>{$company.CompanyAttribute.business_scope}
                </p>
                <p class="textEllipsis">
                <span>企业类型：</span>{$company.Homepage.company_type}
                </p>
            </div>
            <div>
                <p class="textEllipsis left">
                <span>行业：</span>{$this->Category->getCategoryName($company.CompanyAttribute.category_id)}
                </p>
            </div>
            <div>
                <p class="textEllipsis left">
                <span>地址：</span>{$company.Homepage.address}
                </p>
            </div>
        </li>
    {/foreach}
</ul>

<div class="fanyea fanyeaNob">
    {if $paginatorParams['prevPage']}
        <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
    {/if}
    <div class="dd_ym">
        <label>每页显示：</label>
        <select name="pageSize" id="pageSize">
            <option value="10" {if $pageSize == "10"} selected {/if}>10</option>
            <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
            <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
            <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
        </select>
    </div>
    <div class="dd_ym11">
        <font>共{$paginatorParams['count']}条</font> <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
        <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
        <div class="dd_span1"><a href="" id="jumpButton">跳转</a></div>
    </div>
    {if $paginatorParams['nextPage']}
        <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
    {/if}
</div>
{$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
{$pageSizeRequestUrl = ['action' => $this->request->params['action']]}
{$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#informationList', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
{$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
{$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
{$this->Js->writeBuffer()}