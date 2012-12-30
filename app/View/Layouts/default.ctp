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
<body>
{$this->element($headerElement)}
{$this->fetch('content')}
{$this->element($footerElement)}
</body>
</html>

