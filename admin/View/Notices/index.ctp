<div class="title">系统通知管理</div>
<br />
<table id="notices" width="400px"></table>
<div id="noticesPage"></div>
<br />


<div class="title">
<label for="file">文件上传（TSV）</label>
<form action="notices/upload" method = "post" enctype="multipart/form-data">
<input type="file" id="categoryFile" name="file" /> 
<br />
<input id="category" type="submit" name="submit" value="上传" onclick="return checkFile('category')"/>

</form>
</div>
<br />