<div class="span-8 prepend-7">
    <form id="login_form" action="/admin/index/check" method="post">
    <fieldset>
        <legend>登陆后台系统</legend>
        <p>
            <label for="user_nm" class="required">管理者ID:</label>
            <input type="text" name="id" id="user_nm" class="required" style="width:150px;" maxlength="255" value="" />
        </p>
        <p>
            <label for="user_pwd" class="required">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:</label>
            <input type="password" name="password" id="user_pwd" class="required" style="width:150px;" maxlength="255" value="" />
        </p>
        <div class="prepend-3">
            <input type="submit" value="登陆">
        </div>
    </fieldset>
    </form>

</div>