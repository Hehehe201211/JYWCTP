<div class="title">静态页面管理</div>
<br />
<table id="templates" width="400px"></table>
<div id="templatesPage"></div>
<br />


<div class="title">
<label for="file">页面内容编辑</label>
</div>
<form id="contentForm">
<textarea id="contents" name="content"></textarea>
{$this->Fck->load('contents', '/admin/templates/ckfinder')}
<input type="hidden" name="templates_id" value="" id="templates_id">
<input type="button" value="确认" id="check">
</form>
<br />
<br />
<br />
