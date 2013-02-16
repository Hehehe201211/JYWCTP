<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    {$this->Html->charset()}
    <title>{$title_for_layout}</title>
    {$this->Html->meta('icon')}
    {$this->Html->meta($meta)}
    {$this->Html->css($css)}
    {$this->Html->script($js)}
</head>
<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("ul.nav li a:eq(7)").addClass("current");    
    $(".ntcLeft .category p a").eq($(".corContent .crumbs").attr("mnum")).parent().next().show();
	$(".ntcLeft .category p a").eq($(".corContent .crumbs").attr("mnum")).parent().prev().addClass("cActive");  	
	$(".searchBox .inpButton").click(function(){
	  if (document.getElementById("keywrod").value!="") document.getElementById("staticForm").submit();
	});
});
{/literal}
</script>
<body>
    {$this->element($headerElement)}
    <div class="main">
        {$this->fetch('content')}
    </div>
    {$this->element($footerElement)}
</body>
</html>