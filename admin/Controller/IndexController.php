<?php
/**
 * 
 * 后台管理系统首页
 * @author lin_deping
 *
 */
class IndexController extends AppController
{
    public $uses = array('Admin');
    public function index()
    {
//        $this->Session->delete('admin');
        $admin = $this->Session->read('admin');
        if (empty($admin)){
            $this->redirect('login');
        }
        $this->set("admin", $admin);
    }
    public function login()
    {
        $admin = $this->Session->read('admin');
        if (!empty($admin)){
            $this->redirect('index');
        }
    }
    public function check()
    {
        $this->autoRender = false;
        $params = array(
            'conditions' => array(
                                  'Admin.id' => $this->request->data['id'], 
                                  'Admin.password' => md5($this->request->data['password'])
                               ),
            'fields' => array(
                'id',
                'name',
                'email'
            )
        );
        $adminInfo = $this->Admin->find('first', $params);
        if (empty($adminInfo)){
            $this->redirect('login');
        } else {
            $this->Session->write('admin', $adminInfo);
            $this->redirect(array('controller' => 'index', 'action' => 'index'));
        }
    }
    
    public function logout()
    {
        $this->Session->delete('admin');
        $this->redirect('login');
    }
    
    public function beforeFilter()
    {
        
    }
}