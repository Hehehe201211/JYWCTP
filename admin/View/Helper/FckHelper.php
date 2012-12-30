<?php
App::import('Vendor', 'CKEditor', array('file' => 'ckeditor' . DS . 'ckeditor_php5.php'));
class FckHelper extends AppHelper
{
    var $helpers = array('Html', 'Js');
    var $skins = 'office2003';
    var $toolbar = "[
        { name: 'document', items : [ 'Source'] },
	    { name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	    { name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'insert', items : [ 'Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak'] },
	   	'/',
	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
	'-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },	
	'/',
	{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
	{ name: 'colors', items : [ 'TextColor','BGColor' ] }
    ]";
	var $ignoreEmptyParagraph = true;
    
    public function load($id = null, $toolbar = null)
    {
        if (empty($id)) {
            return;
        }
        if (empty($toolbar)) {
            $toolbar = $this->toolbar;
        }
//        filebrowserBrowseUrl : 'ckeditor/ckfinder/ckfinder.html',
//        filebrowserImageBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?Type=Images',
//        filebrowserFlashBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?Type=Flash',
//        filebrowserUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
//        filebrowserImageUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
//        filebrowserFlashUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        
        $code = "var frckeditor = CKEDITOR.replace('" . $id . "', {toolbar : " . $toolbar . ", filebrowserImageBrowseUrl : 'templates/ckfinder?Type=Images'})";
        return $this->Html->scriptBlock($code);
    }
    public function set($name, $value)
    {
        
    }
}