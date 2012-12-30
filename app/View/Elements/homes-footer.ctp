<div class="width1000 footer">
    <div class="left">
        <p>2007 © Copyright <a href="gsqt-index.html">Jewellery shop</a></p>
        <p>All rights reserved.</p>
    </div>
    <div class="left right">
        <p><span>地址:</span>{$homepage.Homepage.address}</p>
        {$contact_methods = json_decode($homepage.Homepage.contact_method, true)}
        {foreach $contact_methods as $method}
            <p><span>{$method.method}:</span>{$method.number}</p>
        {/foreach}
        <p><span>E-mail:</span><a href="mailto:{$homepage.Homepage.email}">{$homepage.Homepage.email}</a></p>
    </div>
</div>