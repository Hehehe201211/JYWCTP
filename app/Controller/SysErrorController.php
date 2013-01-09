<?php

class SysErrorController extends AppController
{
    
    public function message() 
    {
//        $this->set('message', $message);
    }
    
    public function beforeRender()
    {
        $css = array(
        'member'
        );
        $js = array('member');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
    }
}