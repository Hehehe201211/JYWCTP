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
 * 后台管理基础控制器
 */
class AppController extends Controller {
    protected $cssArray = array(
        'blueprint/screen.css', 
        'blueprint/plugins/link-icons/screen.css', 
        'admin.css'
    );
    protected $jsArray = array('jquery-1.6.2.min.js', 'site-common.js');
    protected $metaArray = array();
    public $viewClass = 'Smarty';
    const DEFAULT_THEME = 'south-street';
    
    //用户访问各个页面的权限
    protected $_permission = array();
    
    /**
     * 
     * Enter description here ...
     * @param array $css
     */
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
    /**
     * 
     * Enter description here ...
     * @param array $js
     */
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
    /**
     * 
     * Enter description here ...
     * @param array $data
     */
    protected function _sendJson($data)
    {
        $this->autoRender = false;
        if (!is_array($data)){
            $data = (array)$data;
        }
        echo json_encode($data);
    }
    
    protected function _useJqGrid($theme = self::DEFAULT_THEME)
    {
        $this->_appendJs(array(
            'jqGrid/js/i18n/grid.locale-cn.js',
            'jqGrid/js/jquery.jqGrid.min.js',
        ));
        $this->_appendCss(array(
            'ui.jqgrid.css'
        ));
        if(!empty($theme)) {
            $this->_appendCss(array(
                "themes/$theme/jquery-ui-1.8.15.custom.css",
            ));
        }
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
        $this->set("admin", $this->Session->read('admin'));
        
        //各级导航菜单
        $this->uses = array('Menu', 'SubMenu');
        
        $menus = $this->Menu->find('all', array('order' => array('Menu.priority ASC'), 'fields' => array('name', 'controller', 'action')));
        $this->set('menus', $menus);
        
        $conditions = array('link' => $this->request->params['controller'] . "/" . $this->request->params['action']);
        $current = $this->SubMenu->find('first', array('conditions' => $conditions));
        $conditions = array('menu_id' => $current['SubMenu']['menu_id'], 'display' => 1);
        $sub_menus = $this->SubMenu->find('all', array('conditions' => $conditions));
        /*
        
        $joins = array(
            'table' => 'sub_menus',
            'alias' => 'SubMenu',
            'type'  => 'inner',
            'conditions' => array('SubMenu.display = 1', 'SubMenu.menu_id = Menu.id')
        );
        $params = array(
            'conditions' => array('Menu.controller' => $this->request->params['controller'], 'SubMenu.display' => 1),
            'fields' => array('SubMenu.name', 'SubMenu.link'),
            'joins' => array($joins)
        );
        $sub_menus = $this->Menu->find('all', $params);
//        var_dump($sub_menus);
        */
        $this->set('sub_menus', $sub_menus);
        
    }
    
    public function beforeFilter()
    {
        //登陆情况确认
        $admin = $this->Session->read('admin');
        if (empty($admin)){
            $this->redirect(array('controller' => 'index', 'action' => 'login'));
        }
        //用户权限确认
        $this->uses = array('SubMenu');
        $joins = array(
            'table' => 'permissions',
            'alias' => 'Permission',
            'type' => 'inner',
            'conditions' => array('SubMenu.resource_id = Permission.resource_id')
        );
        $params = array(
            'conditions' => array('SubMenu.link' => $this->request->url),
            'fields' => array('SubMenu.*' ,'Permission._read', 'Permission._create', 'Permission._update', 'Permission._delete'),
            'joins' => array($joins)
        );
        $data = $this->SubMenu->find('first', $params);
        $this->_permission = $data;
        $this->set('permission', $this->_permission);
    }
    
    protected function _sqlLog()
    {
        $sources = ConnectionManager::sourceList();
        $logs = array();
        foreach ($sources as $source) {
            $db = ConnectionManager::getDataSource($source);
            if (!method_exists($db, 'getLog')){
                continue;
            }
            $logs[$source] = $db->getLog();
        }
        return $logs;
    }
}
