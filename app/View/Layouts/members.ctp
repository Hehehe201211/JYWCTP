<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
    {$this->Html->charset()}
    <title>
    {$title_for_layout}
    </title>
    {$this->Html->meta('icon')}
    {$this->Html->meta($meta)}
    {$this->Html->css($css)}
    {$this->Html->script($js)}
</head>
<body>
{$this->element('members-header')}
  <div class="zy_zhud">
    {if $memberInfo.Member.type == 0}
	{$this->element('members-left')}
	{else}
	{$this->element('members-left-company')}
	{/if}
	{$this->fetch('content')}
	{if $memberInfo.Member.type == Configure::read('UserType.Personal')}
	   {$this->element('members-right')}
	{else}
	   {$this->element('company-members-right')}
	{/if}
    <div class="clearfix"></div>
  </div>
{$this->element('members-footer')}
</body>
</html>
