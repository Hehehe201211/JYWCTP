<?php
App::uses('CakeEmail', 'Network/Email');
class ForgetController extends AppController
{
    var $layout = 'resume_preview';
    var $uses = array('Member', 'AccountTmp');
    public function index()
    {
        $this->set('title_for_layout', "忘记密码");
        if (!empty($this->_memberInfo)) {
            $this->redirect('/members');
        }
        $this->Session->delete('forget');
    }
    
    public function send()
    {
        $this->set('title_for_layout', "忘记密码");
        if (!empty($this->_memberInfo)) {
            $this->redirect('/members');
        }
        $message = "";
        $session = $this->Session->read('forget');
        if (empty($session)) {
            if (isset($this->request->data['email'])) {
                $member = $this->Member->find('first', array('conditions' => array('email' => $this->request->data['email'], 'type' => $this->request->data['type'])));
                if (!empty($member)) {
                    try {
                        $data = array(
                            'members_id'    => $member['Member']['id'],
                            'members_type'  => $member['Member']['type'],
                            'type'          => 'forget',
                            'data'          => $this->request->data['email']
                        );
                        $this->AccountTmp->save($data);
                        $newId = $this->AccountTmp->getInsertID();
                        $checkLink = "http://" . $_SERVER['SERVER_NAME'] . '/forget/reset/?id=' . $newId . "&key=" . md5($this->request->data['email']);
                        $email = new CakeEmail();
                        $params = array(
                            'nickname' => $member['Member']['nickname'],
                            'checkLink' => $checkLink,
                            'title_for_layout'  => "找回密码"
                        );
                        $email->template('forget', 'register')
                        ->viewVars($params)
                        ->emailFormat('html')
                        ->to($this->request->data['email'])
                        ->from(array('norepeat@jukeyuan.com' => '聚业务'))
                        ->subject('找回密码')
                        ->send();
                        $this->Session->write('forget', $this->request->data['email']);
                    } catch (Exception $e) {
                        $this->log($e->getMessage());
                        $message = "系统发生错误，请稍后重试！";
                    }
                } else {
                    $message = "系统不存在次邮箱用户！";
                }
            } else {
                $message = "系统不存在此邮箱用户！";
            }
            $this->set('email', $this->request->data['email']);
        } else {
            $this->set('email', $session);
        }
        $this->set('message', $message);
    }
    
    public function reset()
    {
        $this->set('title_for_layout', "重新设置密码");
        if (!empty($this->_memberInfo)) {
            $this->redirect('/members');
        }
        $error = false;
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])
            && isset($this->request->query['key']) && !empty($this->request->query['key'])
        ) {
            $tmp = $this->AccountTmp->find('first', array('conditions' => array('id' => $this->request->query['id'], 'type' => 'forget')));
            if (!empty($tmp)) {
                if (md5($tmp['AccountTmp']['data']) != $this->request->query['key']) {
                    $error = true;
                }
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }
        $this->set("error", $error);
    }
    
    public function complete()
    {
        $this->set('title_for_layout', "设置密码");
        if (!empty($this->_memberInfo)) {
            $this->redirect('/members');
        }
        if (isset($this->request->data['tmp_id']) && !empty($this->request->data['tmp_id'])
            && isset($this->request->data['password']) && !empty($this->request->data['password'])
        ) {
            $tmp = $this->AccountTmp->find('first', array('conditions' => array('id' => $this->request->data['tmp_id'])));
            if (!empty($tmp)) {
                $data = array(
                    'id'    => $tmp['AccountTmp']['members_id'],
                    'password'  => md5($this->request->data['password']),
                    'modified'  => date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME'])
                );
                try {
                    $dataSource = $this->Member->getDataSource();
                    $dataSource->begin();
                    $this->Member->save($data);
                    $this->AccountTmp->delete($this->request->data['tmp_id']);
                    $dataSource->commit();
                    $memberInfo = $this->Member->getMemberInfo(array('id' => $tmp['AccountTmp']['members_id']), $tmp['AccountTmp']['members_type']);
                    $this->Session->write('memberInfo', $memberInfo);
                    $this->redirect('/members');
                } catch (Exception $e) {
                    $dataSource->rollback();
                    $this->log(__CLASS__ . "::" . __FUNCTION__ . "() :" . $e->getMessage());
                    $error = "系统错误，密码设置失败，请稍后重试！";
                }
            } else {
                $error = "认证信息不存在！";
            }
        } else {
            $error = "认证信息不存在！";
        }
        $this->set("error", $error);
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