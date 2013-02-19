<?php
App::uses('CakeEmail', 'Network/Email');
class AccountsController extends AppController
{
    var $layout = 'members';
    var $uses = array(
                    'Member', 
                    'MemberAttribute', 
                    'AccountTmp', 
                    'FriendGroup', 
                    'Friendship', 
                    'StationMessage', 
                    'CompanyAttribute',
                    'PaymentTransaction',
                    'Information',
                    'SystemMessage'
    );
    var $components = array('RequestHandler', 'Friend', 'StationMsg', 'Unit', 'Upload', 'Thumbnail', 'Recommend');
    var $helpers = array('Js', 'City', 'Category');
    /**
     * 
     * 账号安全
     */
    public function security()
    {
        $this->set('title_for_layout', "账号安全");
        if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.company')) {
            $this->render('security-company');
        } else {
            $historyInfo = $this->Member->getHistoryInfo($this->_memberInfo['Member']['id']);
            $this->set('historyInfo', $historyInfo);
        }
    }
    /**
     * 
     * 修改信息
     */
    public function edit()
    {
        $this->set('title_for_layout', "信息修改");
        $css = array(
                'jquery-ui'
            );
        $js = array('jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.company')) {
            if (!$this->request->is('post')) {
                $memberBase = $this->Member->find('first', array('conditions' => array('id' => $this->_memberInfo['Member']['id'])));
                $memberAttribute = $this->CompanyAttribute->find('first', array('conditions' => array('members_id' => $this->_memberInfo['Member']['id'])));
                $this->set('memberBase', $memberBase);
                $this->set('memberAttribute', $memberAttribute);
            }
            $this->render('company-edit');
        } else {
            if (!$this->request->is('post')) {
                $memberBase = $this->Member->find('first', array('conditions' => array('id' => $this->_memberInfo['Member']['id'])));
                $memberAttribute = $this->MemberAttribute->find('first', array('conditions' => array('members_id' => $this->_memberInfo['Member']['id'])));
                $this->set('memberBase', $memberBase);
                $this->set('memberAttribute', $memberAttribute);
            }
        }
    }
    
    public function editCheck()
    {
        $thumbnail = '';
        if (isset($_FILES['face'])) {
            $filename = $this->_memberInfo['Member']['id'] . '_face_thumbnail';
            $path = TMP;
            $result = $this->Upload->upload($_FILES['face'], $path, $filename, "image");
            if ($result['result'] == 'OK') {
                $path = "thumbnail/" . 
                        substr(md5(((int)($this->_memberInfo['Member']['id'] / 30000) + 1)), 0, 10) . "/" . 
                        substr(md5($this->_memberInfo['Member']['id']), 0, 10);
                if (!file_exists($path)) {
                    $command = "mkdir -p 0755 " . Configure::read('Data.path') . $path;
                    try {
                        exec($command);
                    } catch (Exception $e) {
                        $this->log($e->getMessage());
                    }
                }
                $srcParams = array(
                    'path' => $result['path'],
                    'name' => $result['name']
                );
                $descParams = array(
                    'imagepath' => Configure::read('Data.path') . $path,
                    'imagename'      => "face_thumbnail",
                    'outx'      => Configure::read('Thumbnail.face.width'),
                    'outy'      => Configure::read('Thumbnail.face.height')
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $thumbnail = $path . "/face_thumbnail." .  $this->Upload->getExt($_FILES['face']);
                    @unlink($result['path'] . '/' . $result['name']);
                }
            }
        }
        if (isset($_FILES['logo'])) {
            $filename = $this->_memberInfo['Member']['id'] . '_logo_thumbnail';
            $path = TMP;
            $result = $this->Upload->upload($_FILES['logo'], $path, $filename, "image");
            if ($result['result'] == 'OK') {
                $path = "thumbnail/" . 
                        substr(md5(((int)($this->_memberInfo['Member']['id'] / 30000) + 1)), 0, 10) . "/" . 
                        substr(md5($this->_memberInfo['Member']['id']), 0, 10);
                if (!file_exists($path)) {
                    $command = "mkdir -p 0755 " . Configure::read('Data.path') . $path;
                    try {
                        exec($command);
                    } catch (Exception $e) {
                        $this->log($e->getMessage());
                    }
                }
                $srcParams = array(
                    'path' => $result['path'],
                    'name' => $result['name']
                );
                $descParams = array(
                    'imagepath' => Configure::read('Data.path') . $path,
                    'imagename'      => "logo_thumbnail",
                    'outx'      => Configure::read('Thumbnail.logo.width'),
                    'outy'      => Configure::read('Thumbnail.logo.height')
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $thumbnail = $path . "/logo_thumbnail." .  $this->Upload->getExt($_FILES['logo']);
                    @unlink($result['path'] . '/' . $result['name']);
                }
            }
            echo $thumbnail;
        }
        $this->set('thumbnail', $thumbnail);
        if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.company')) {
            $this->render('edit-check-company');
        }
    }
    
    public function editComplete()
    {
        if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.company')) {
            $contact_methods = array();
            foreach ($this->request->data['contact_method'] as $key => $value) {
                $method = array(
                    'method' => $value,
                    'content' => $this->request->data['contact_content'][$key]
                );
                $contact_methods[] = $method;
            }
            $contact_methods = json_encode($contact_methods);
            $service = implode(',', $this->request->data['service']);
            $attributeInfo = array(
                'full_name'         => "'{$this->request->data['full_name']}'",
                'established'       => "'{$this->request->data['established']}'",
                'contact'           => "'{$this->request->data['contact']}'",
                'fax'               => "'{$this->request->data['fax']}'",
                'provincial_id'     => "'{$this->request->data['provincial_id']}'",
                'city_id'           => "'{$this->request->data['city_id']}'",
                'address'           => "'{$this->request->data['address']}'",
                'company_type'      => "'{$this->request->data['company_type']}'",
                'category_id'       => "'{$this->request->data['category_id']}'",
                'business_scope'    => "'{$this->request->data['business_scope']}'",
                'thumbnail'         => "'{$this->request->data['thumbnail']}'",
                'service'           => "'{$service}'",
                'business_scope'    => "'{$this->request->data['business_scope']}'",
                'contact_method'    => "'{$contact_methods}'"
            );
            $this->CompanyAttribute->updateAll($attributeInfo, array('members_id' => $this->_memberInfo['Member']['id']));
        } else {
            $baseInfo = array(
                'nickname'  => "'{$this->request->data['nickname']}'"
            );
            $service = implode(',', $this->request->data['service']);
            $attributeInfo = array(
                'name'              => "'{$this->request->data['name']}'",
                'sex'               => "'{$this->request->data['sex']}'",
                'birthday'          => "'{$this->request->data['birthday']}'",
                'provincial_id'     => "'{$this->request->data['provincial_id']}'",
                'city_id'           => "'{$this->request->data['city_id']}'",
                'mobile'            => "'{$this->request->data['mobile']}'",
                'telephone'         => "'{$this->request->data['telephone']}'",
                'company'           => "'{$this->request->data['company']}'",
                'category_id'       => "'{$this->request->data['category_id']}'",
                'business_scope'    => "'{$this->request->data['business_scope']}'",
                'thumbnail'         => "'{$this->request->data['thumbnail']}'",
                'service'           => "'{$service}'"
            );
            $this->Member->updateAll($baseInfo, array('id' => $this->_memberInfo['Member']['id']));
            $this->MemberAttribute->updateAll($attributeInfo, array('members_id' => $this->_memberInfo['Member']['id']));
        }
    }
    
    /**
     * 
     * Enter description here ...
     */
    public function friend()
    {
        $friend_group = $this->FriendGroup->find('all', array('conditions' => array('members_id' => $this->_memberInfo['Member']['id'])));
        $conditions = array('Friendship.members_id' => $this->_memberInfo['Member']['id']);
        if (isset($this->request->data['group'][0]) && $this->request->data['group'][0] != "") {
            $conditions['friend_groups_id'] = $this->request->data['group'][0];
        }
        $this->Friend->friendList($conditions);
        $this->set('groups', $friend_group);
        if (!$this->RequestHandler->isAjax()) {
            $this->set('title_for_layout', "好友管理");
        } else {
            $this->render('friend_list');
        }
    }
    /**
     * 
     * 好友邀请
     */
    public function invite()
    {
        $this->set('title_for_layout', "好友邀请");
        $sns_link = "http://" . $_SERVER['SERVER_NAME'] . "/members/register?mid=" . $this->_memberInfo['Member']['id'] . "&key=" . md5($this->_memberInfo['Member']['id']);
        $this->set('sns_link', $sns_link);
		$js = array('zeroclipboard');
        $this->_appendJs($js);
    }
    /**
     * 
     * 站内信页面
     */
    public function sms()
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->set('title_for_layout', "站内信");
            $css = array(
                'jquery-ui'
            );
            $js = array('jquery-ui');
            $this->_appendCss($css);
            $this->_appendJs($js);
            $constions = array(
                'receiver' => $this->_memberInfo['Member']['id'],
                'status'    => 1
            );
            $this->StationMsg->getMessageList($constions);
            $constions = array(
                'members_id' => $this->_memberInfo['Member']['id'],
                'status'    => 1
            );
            $this->StationMsg->getSystemMessage($constions);
        } else {
            if (isset($this->request->data['msg_type']) && 
                $this->request->data['msg_type'] == "station") {
                $constions = array(
	                'receiver'  => $this->_memberInfo['Member']['id'],
	                'status'    => 1
	            );
                $this->StationMsg->getMessageList($constions);
                $this->render('station_paginator');
            } else {
                $constions = array(
	                'members_id'  => $this->_memberInfo['Member']['id'],
	                'status'    => 1
	            );
                $this->StationMsg->getSystemMessage($constions);
                $this->render('system_paginator');
            }
        }
        
        
        
    }
    
    /**
     * 
     * Enter description here ...
     */
    public function load()
    {
        $this->autoLayout = false;
        $this->render($this->request->data['name']);
    }
    /**
     * 
     * Enter description here ...
     */
    public function editSecurity()
    {
        $this->autoRender = false;
        $result = array('result' => 'NG');
        $data = array();
        switch ($this->request->data['type']) {
            case 'password':
                $ps = md5($this->request->data['old_password']);
                $conditions = array('Member.id' => $this->_memberInfo['Member']['id'], 'Member.password' => $ps);
                $data['old_data'] = $ps;
                break;
            case 'pay_password':
                $ps = md5($this->request->data['old_password']);
                $conditions = array('Member.id' => $this->_memberInfo['Member']['id'], 'Attribute.pay_password' => $ps);
                $data['old_data'] = $ps;
                break;
            case 'zhifubao':
                $conditions = array('Member.id' => $this->_memberInfo['Member']['id'], 'Attribute.pay_account' => $this->request->data['old_zhifubao']);
                $data['old_data'] = $this->request->data['old_zhifubao'];
                break;
            case 'mobile':
                $conditions = array('Member.id' => $this->_memberInfo['Member']['id'], 'Attribute.mobile' => $this->request->data['old_mobile']);
                $data['old_data'] = $this->request->data['old_mobile'];
                break;
            default:
                break;
        }
        $memberInfo = $this->Member->getMemberInfo($conditions, $this->_memberInfo['Member']['type']);
        if (!empty($memberInfo)) {
            $data['members_id'] = $this->_memberInfo['Member']['id'];
            $data['type']       = $this->request->data['type'];
            $data['members_type'] = $this->_memberInfo['Member']['type'];
            if ($this->request->data['type'] == 'password' || 
                $this->request->data['type'] == 'pay_password') {
                $data['data'] = md5($this->request->data['new_password']);
            } elseif ($this->request->data['type'] == 'zhifubao') {
                $data['data'] = $this->request->data['new_zhifubao'];
            } elseif ($this->request->data['type'] == 'mobile') {
                $data['data'] = $this->request->data['new_mobile'];
            }
            if ($id = $this->AccountTmp->save($data)) {
                $body = 'http://dev.jukeyuan.com/accounts/eComplete/?id=' . $this->AccountTmp->id . '&mid=' . md5($this->_memberInfo['Member']['id']);
                $email = new CakeEmail('default');
                $email->from(array('norepeat@jukeyuan.com' => '聚客源'));
                $email->to($memberInfo['Member']['email']);
                $email->subject('会员身份认证');
                if ($email->send($body)) {
                    $result['result'] = 'OK';
                    $result['msg'] = '修改请求已提交，请登录认证邮箱确认！';
                } else {
                    $result['msg'] = '你输入的信息有误，请确认后重新输入！';
                }
            }
        } else {
            $result['msg'] = '你输入的信息有误，请确认后重新输入！';
        }
        $this->_sendJson($result);
    }
    /**
     * 
     * 账号相关信息修改之后的
     * 认证处理
     */
    public function eComplete()
    {
        $this->layout = "members-register";
        $query = $this->request->query;
        $msg = "没有认证处理信息";
        $field = "";
        if (isset($query['id']) && !empty($query['id']) && 
            isset($query['mid']) && !empty($query['mid'])
        ) {
            $tmp = $this->AccountTmp->find('first', array('conditions' => array('id' => $query['id'])));
            if (!empty($tmp)) {
                if (md5($tmp['AccountTmp']['members_id']) == $query['mid']) {
                    
                        switch ($tmp['AccountTmp']['type']){
                            case 'password':
                                $conditions = array('Member.id' => $tmp['AccountTmp']['members_id']);
                                $memberInfo = $this->Member->find('first', array('conditions' => $conditions));
                                if ($memberInfo['Member']['password'] == $tmp['AccountTmp']['old_data']) {
                                    $field = "password";
                                    $msg = "密码修改成功，下次登录生效！";
                                }
                                break;
                            case 'pay_password':
                                $conditions = array('MemberAttribute.members_id' => $tmp['AccountTmp']['members_id']);
                                $memberInfo = $this->MemberAttribute->find('first', array('conditions' => $conditions));
                                if ($memberInfo['MemberAttribute']['pay_password'] == $tmp['AccountTmp']['old_data']) {
                                    $field = 'pay_password';
                                    $msg = "支付密码修改成功，下次登录生效！";
                                }
                                break;
                            case 'zhifubao':
                                $conditions = array('MemberAttribute.members_id' => $tmp['AccountTmp']['members_id']);
                                $memberInfo = $this->MemberAttribute->find('first', array('conditions' => $conditions));
                                if ($memberInfo['MemberAttribute']['pay_account'] == $tmp['AccountTmp']['old_data']) {
                                    $field = 'pay_account';
                                    $msg = "支付宝账号修改成功，下次登录生效！";
                                }
                                break;
                            case 'mobile':
                                $conditions = array('MemberAttribute.members_id' => $tmp['AccountTmp']['members_id']);
                                $memberInfo = $this->MemberAttribute->find('first', array('conditions' => $conditions));
                                if ($memberInfo['MemberAttribute']['mobile'] == $tmp['AccountTmp']['old_data']) {
                                    $field = 'mobile';
                                    $msg = "认证手机号码修改成功，下次登录生效！";
                                }
                                break;
                            default:
                                break;
                        }
                        if (!empty($field)) {
                            if ($tmp['AccountTmp']['type'] == "password") {
                                try {
                                    $this->Member->id = $tmp['AccountTmp']['members_id'];
                                    $this->Member->saveField($field, $tmp['AccountTmp']['data']);
                                } catch (Exception $e) {
                                    $this->log(__CLASS__ . '->' . __FUNCTION__. $e->getMessage());
                                    $msg = "系统发生错误，请你稍候重新认证！";
                                }
                                $this->Member->printLog();
                            } else {
                                if ($tmp['AccountTmp']['members_type'] == Configure::read('UserType.Personal')) {
                                    $data = array("$field" => "'{$tmp['AccountTmp']['data']}'");
                                    if (!$this->MemberAttribute->updateAll($data, array('members_id' => $tmp['AccountTmp']['members_id']))) {
                                        $msg = "系统发生错误，请你稍候重新认证！";
                                    }
                                } else {
                                    //企业会员
                                }
                            }
                        }
                }
            }
        }
        $this->set("cssClass", 'zhucrig_x3');
        $this->set('msg', $msg);
    }
    /**
     * 
     * 好友详情
     * 站内信交流记录等
     */
    public function fdetail()
    {
        if (isset($this->request->query['fid']) && !empty($this->request->query['fid'])) {
            $constions = array(
                'StationMessage.status'    => 1,
                'StationMessage.type'      => 1
            );
            $constions['OR'] = array(
                array('sender' => $this->_memberInfo['Member']['id'], 'receiver' => $this->request->query['fid']),
                array('sender' => $this->request->query['fid'], 'receiver' => $this->_memberInfo['Member']['id'])
            );
            $this->StationMsg->getMessageList($constions);
            if ($this->RequestHandler->isAjax()) {
                $this->render('fdetail-paginator');
            } else {
                $this->set('title_for_layout', "好友详细");
                $joinAttribute = array(
                    'table' => 'member_attributes',
                    'alias' => 'Attribute',
                    'type'  => 'inner',
                    'conditions' => 'Attribute.members_id = Member.id'
                );
                $params = array(
                    'conditions' => array('id' => $this->request->query['fid']),
                    'fields'     => array('Member.nickname', 'Attribute.name', 'Attribute.category_id', 'Attribute.thumbnail'),
                    'joins'      => array($joinAttribute)
                );
                $firend = $this->Member->find('first', $params);
                $sendCount = $this->Information->find('count', array('conditions' => array('members_id' => $this->request->query['fid'])));
                $transactionCount = $this->PaymentTransaction->find('count', array('conditions' => array('members_id' => $this->request->query['fid'])));
                $this->set('sendCount', $sendCount);
                $this->set('transactionCount', $transactionCount);
                $this->set('firend', $firend);
            }
        } else {
            ;
        }
    }
    
    public function beforeRender()
    {
        $this->currentMenu = Configure::read('Menu.accountManager');
        $css = array(
        'member'
        );
        $js = array('member');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //推荐信息
        if (!$this->RequestHandler->isAjax()){
            //系统信息
	        $notices = $this->Unit->notice();
	        $this->set('notices', $notices);
            if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.Personal')) {
                $this->Recommend->parttime($this->_memberInfo['Member']['id'], $this->_memberInfo['Attribute']['category_id']);
                //提示各种信息所处各种状态
                $this->Recommend->PersonNoticeCount($this->_memberInfo['Member']['id']);
            } else {
                //提示各种信息所处各种状态
                $this->Recommend->CompanyNoticeCount($this->_memberInfo['Member']['id']);
            }
        }
    }
    
}