


<div class="title">首页导航菜单分类管理</div>
<br />
<table id="father" width="400px"></table>
<div id="fatherPage"></div>
<br />

<table id="child"></table>
<div id="childPage"></div>
<br />

<table id="child2"></table>
<div id="childPage2"></div>
<br />

<div class="title">
<label for="file">文件上传（TSV）</label>
<form action="categories/upload" method = "post" enctype="multipart/form-data">
<input type="file" id="categoryFile" name="file" /> 
<br />
<input id="category" type="submit" name="submit" value="上传" onclick="return checkFile('category')"/>

</form>
</div>
<br />