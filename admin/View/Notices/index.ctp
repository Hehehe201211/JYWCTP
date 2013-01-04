<div class="title">系统信息管理</div>
<br />
<table id="notices" width="400px"></table>
<div id="noticesPage"></div>
<br />


<div class="title">
<label for="file">内容编辑</label>
</div>
<form id="contentForm">
<textarea id="contents" name="content"></textarea>
{$this->Fck->load('contents')}
<input type="hidden" name="templates_id" value="" id="templates_id">
<input type="button" value="确认" id="check">
</form>
<br />
<br />
<br />