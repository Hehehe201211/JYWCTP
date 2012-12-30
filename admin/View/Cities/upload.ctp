<div class="title">全国城市区域管理</div>
<br />
<table id="father" width="400px"></table>
<div id="fatherPage"></div>
<br />

<table id="child"></table>
<div id="childPage"></div>
<br />

<div class="title">
<label for="file">文件上传（TSV）</label>
<form action="cities/upload" method = "post" enctype="multipart/form-data">
<input type="file" id="citiesFile" name="file" /> 
<br />
<input id="category" type="submit" name="submit" value="上传" onclick="return checkFile('category')"/>

</form>
</div>
<br />

{if isset($error)}
    <div class = "title" style="color:red">
    {$error}
    </div>
{/if}