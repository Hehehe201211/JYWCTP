<form action="/registers/send" method="post">
{$this->data['nickname']}<br/>
********
<input type="hidden" name="nickname" value="{$this->data['nickname']}" /><br>
<input type="hidden" name="password" value="{$this->data['password']}" /><br>
<input type="submit" value="submit" />
</form>
