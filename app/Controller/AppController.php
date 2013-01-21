<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    var $siteTitle;
    protected $cssArray = array('common');
    protected $jsArray = array('jquery.js', 'common.js');
    protected $metaArray = array();
    public $viewClass = 'Smarty';
    protected $headerElement = 'top-header';
    protected $footerElement = 'top-footer';
    
    public $_memberInfo = array();
    //会员主页菜单选择
    public $currentMenu = 'one';
    //主页导航选择
    public $currentTopBar = 'index';
    protected function _appendCss($css)
    {
        if (is_array($css)){
            $this->cssArray = array_merge($this->cssArray, $css);
        } else {
            if (!in_array($css, $this->cssArray)){
                $this->cssArray[] = $css;
            }
        }
        $this->cssArray = array_unique($this->cssArray);
    }
    
    protected function _appendJs($js){
        if (is_array($js)){
            $this->jsArray = array_merge($this->jsArray, $js);
        } else {
            if (!in_array($js, $this->jsArray)){
                $this->jsArray[] = $js;
            }
        }
        $this->jsArray = array_unique($this->jsArray);
    }
    
    protected function _appendMeta($meta){
        if (is_array($meta)) {
            $this->metaArray = array_merge($this->metaArray, $meta);
        } else {
            if (!in_array($meta, $this->metaArray)) {
                $this->metaArray[] = $meta;
            }
        }
        $this->metaArray = array_unique($this->metaArray);
    }
    
    public function beforeRender() {
        if (empty($this->siteTitle)){
            $this->set("siteTitle", Configure::read('sietTitle'));
        } else {
            $this->set("siteTitle", $this->siteTitle);
        }
        $this->set("css", $this->cssArray);
        $this->set("js", $this->jsArray);
        $this->set("meta", $this->metaArray);
        $this->set("headerElement", $this->headerElement);
        $this->set("footerElement", $this->footerElement);
        $this->set('memberInfo', $this->_memberInfo);
        $this->set('currentMenu', $this->currentMenu);
        $this->set('currentTopBar', $this->currentTopBar);
        
    }
    
    public function beforeFilter()
    {
        $except = array(
        	'index' => array(),
        	'members' => array('login', 'register', 'check', 'complete', 'ajaxlogin', 'image', 'existEmail', 'existMember'),
        	'informations' => array('getCityList', 'getCategoryList'),
            'static'        => array(),
            'search'        => array(),
            'accounts'      => array('eComplete'),
            'homes'         => array(),
            'resources'     => array('index', 'detail', 'listview', 'search'),
            'notices'       => array(),
            'alipays'       => array('notify', 'callback')
        );
        $checkSession = true;
        $this->_memberInfo = $this->Session->read('memberInfo');
        if (array_key_exists($this->request->params['controller'], $except)) {
        	if (empty($except[$this->request->params['controller']]) || 
        	in_array($this->request->params['action'], $except[$this->request->params['controller']])) {
        		$checkSession = false;
        	}
        }
        if ($checkSession) {
        	if (empty($this->_memberInfo)) {
        		$this->redirect('/members/register');
        	}
        }
    }
    
    protected function _sendJson($data)
    {
        $this->autoRender = false;
        if (!is_array($data)){
            $data = (array)$data;
        }
        echo json_encode($data);
    }
    
    public function permissionFaile($message)
    {
        
    }
    
    protected function _getClientIp()
    {
        
    }
    
    protected function _getClientAddress()
    {
        
    }
    
    public function _sysDisplayErrorMsg($msg) {
        $this->set('message', $msg);
        $this->render("/Errors/syserror");
    }
    
}
