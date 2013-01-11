<?php
/**
 * 
 * 会员的兼职信息
 * @author deping_lin
 *
 */
class CooperationsController extends AppController
{
    var $layout = 'members';
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Parttime', 'Unit');
    var $uses = array('CooperationComment', 'Cooperation','CooperationComment','PartTime');
    var $paginate;
    /**
     * 
     * 个人会员的提供客源一览
     * 企业会员的收到合作一览
     */
    public function listview()
    {
        $query = $this->request->query;
        if ($query['type'] == 'send') {
            $conditions = array(
                'Cooperation.sender' => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(1)
            );
        } else {
            $conditions = array(
                'Cooperation.receiver' => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(1)
            );
        }
        $this->Parttime->cooperationList($conditions, $query['type']);
        $this->set('type', $query['type']);
    }
    /**
     * 
     * 个人会员提供客源详情
     * 企业会员收到合作详情
     */
    public function detail()
    {
        $query = $this->request->query;
        if (isset($query['send'])) {
            $type = "send";
            $id = $query['send'];
            $conditions = array(
                'Cooperation.id'    => $id,
                'Cooperation.sender'  => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(1)
            );
        } elseif (isset($query['receiver'])) {
            $type = "receiver";
            $id = $query['receiver'];
            $conditions = array(
                'id'    => $id,
                'receiver'  => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(1)
            );
        } else {
            $this->_sysDisplayErrorMsg("error");
        }
        $cooperation = $this->Parttime->cooperationDetail($conditions, $type);
        if ($type == "receiver") {
            $this->render('detail_company');
        }
        if (empty($cooperation)) {
            $this->_sysDisplayErrorMsg("empty cooperation");
        } else {
            ;
        }
    }
    
    /**
     * 
     * 企业会员待确认合作一览
     * 合作中(2)
     * 合作成功待付款(5)
     * 合作失败待确认(6)
     * 企业已付款待确认(8)
     */
    public function waitlist()
    {
        $query = $this->request->query;
        if ($query['type'] == 'send') {
            $conditions = array(
                'Cooperation.sender' => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(2, 5, 6, 8)
            );
        } else {
            $conditions = array(
                'Cooperation.receiver' => $this->_memberInfo['Member']['id'],
                'Cooperation.status'  => array(2, 5, 6, 8)
            );
        }
        $this->Parttime->cooperationList($conditions, $query['type']);
        $this->set('type', $query['type']);
        if ($this->RequestHandler->isAjax()) {
            $this->render('/Elements/wait_cooperations_paginator');
        }
    }
    /**
     * 
     * 企业会员待确认合作详情
     * 合作中(2)
     * 合作成功待付款(5)
     * 合作失败待确认(6)
     * 企业已付款待确认(8)
     */
    public function waitdetail()
    {
        $query = $this->request->query;
        if (isset($query['send'])) {
            $type = "send";
            $id = $query['send'];
            $conditions = array(
                'Cooperation.id'    => $id,
                'Cooperation.sender'  => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(2, 5, 6, 8)
            );
        } elseif (isset($query['receiver'])) {
            $type = "receiver";
            $id = $query['receiver'];
            $conditions = array(
                'id'    => $id,
                'receiver'  => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(2, 5, 6, 8)
            );
        } else {
            $this->_sysDisplayErrorMsg("error");
        }
        $cooperation = $this->Parttime->cooperationDetail($conditions, $type);
        if ($cooperation['Cooperation']['status'] == Configure::read('Cooperation.status.failure')) {
            $this->Parttime->getFailure($cooperation['Cooperation']['id']);
        }
        
        $conditions = array(
            'cooperations_id'   => $cooperation['Cooperation']['id'],
            'sender'            => $cooperation['Cooperation']['sender'],
            'receiver'          => $cooperation['Cooperation']['receiver'],
        );
        $this->Parttime->comments($conditions, $type);
        $this->set('type', $type);
        if (!$this->RequestHandler->isAjax()) {
	        if ($type == "receiver") {
	            $this->render('waitdetail_company');
	        }
	        if (empty($cooperation)) {
	            $this->_sysDisplayErrorMsg("empty cooperation");
	        } else {
	            ;
	        }
        } else {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
                $this->set('jump', $page);
            }
            $this->render('/Elements/cooperation_comments_paginator');
        }
    }
    /**
     * 
     * 企业会员完成合作一览
     */
    public function completelist()
    {
        $query = $this->request->query;
        if ($query['type'] == 'send') {
            $conditions = array(
                'Cooperation.sender' => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(4, 9, 10, 11)
            );
        } else {
            $conditions = array(
                'Cooperation.receiver' => $this->_memberInfo['Member']['id'],
                'Cooperation.status'  => array(4, 9, 10, 11)
            );
        }
        $this->Parttime->cooperationList($conditions, $query['type']);
        $this->set('type', $query['type']);
    if ($this->RequestHandler->isAjax()) {
            $this->render('/Elements/complete_cooperations_paginator');
        }
    }
    /**
     * 
     * 企业会员完成合作信息详情
     */
    public function completedetail()
    {
        $query = $this->request->query;
        if (isset($query['send'])) {
            $type = "send";
            $id = $query['send'];
            $conditions = array(
                'Cooperation.id'    => $id,
                'Cooperation.sender'  => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(3, 9, 10, 11, 12)
            );
        } elseif (isset($query['receiver'])) {
            $type = "receiver";
            $id = $query['receiver'];
            $conditions = array(
                'id'    => $id,
                'receiver'  => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(3, 9, 10, 11, 12)
            );
        } else {
            $this->_sysDisplayErrorMsg("error");
        }
        $cooperation = $this->Parttime->cooperationDetail($conditions, $type);
        
        $conditions = array(
            'cooperations_id'   => $cooperation['Cooperation']['id'],
            'sender'            => $cooperation['Cooperation']['sender'],
            'receiver'          => $cooperation['Cooperation']['receiver'],
        );
        $this->Parttime->comments($conditions, $type);
        $this->set('type', $type);
        if (!$this->RequestHandler->isAjax()) {
            if ($cooperation['Cooperation']['status'] == 10 || $cooperation['Cooperation']['status'] == 11) {
                $conditions = array(
                    'cooperations_id' => $id,
                    'sender'          => $cooperation['Cooperation']['sender'],
                    'receiver'        => $cooperation['Cooperation']['receiver']
                );
                $this->Parttime->complaint($conditions);
            }
            if ($type == "receiver") {
                $this->render('completedetail_company');
            }
            if (empty($cooperation)) {
                $this->_sysDisplayErrorMsg("empty cooperation");
            } else {
                ;
            }
        } else {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
                $this->set('jump', $page);
            }
            $this->render('/Elements/cooperation_comments_paginator');
        }
    }
    /**
     * 
     * 个人会员发送投诉
     */
    public function complaint()
    {
        $this->autoRender = false;
        $conditions = array(
            'id' => $this->request->data['cooperations_id'],
            'sender' => $this->_memberInfo['Member']['id']
        );
        if ($this->Cooperation->find('count', array('conditions' => $conditions)) > 0) {
            if ($this->Cooperation->complaint($this->request->data)) {
                $result = array(
                    'result' => 'OK'
                );
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '系统错误，提交失败，请稍后重试！'
                );
            }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'    => '合作对象不存在！'
            );
        }
        $this->_sendJson($result);
    }
    
    public function complaintlist()
    {
        $query = $this->request->query;
        if ($query['type'] == 'send') {
            $conditions = array(
                'Cooperation.sender' => $this->_memberInfo['Member']['id'],
                'Cooperation.status' => array(7)
            );
        } else {
            $conditions = array(
                'Cooperation.receiver' => $this->_memberInfo['Member']['id'],
                'Cooperation.status'  => array(7)
            );
        }
        $this->Parttime->cooperationList($conditions, $query['type'], true);
        $this->set('type', $query['type']);
        if ($this->RequestHandler->isAjax()) {
            $this->render('/Elements/complaint_cooperations_paginator');
        }
    }
    
    public function complaintdetail()
    {
        $query = $this->request->query;
        if (isset($query['send'])) {
            $type = "send";
            $id = $query['send'];
            $conditions = array(
	            'id' => $id,
	            'sender'          => $this->_memberInfo['Member']['id'],
	        );
        } elseif (isset($query['receiver'])) {
            $type = "receiver";
            $id = $query['receiver'];
            $conditions = array(
	            'id' => $id,
	            'receiver'        => $this->_memberInfo['Member']['id']
	        );
        } else {
            $this->_sysDisplayErrorMsg("error");
        }
        $complaint = $this->Parttime->complaint($conditions);
        if (!empty($complaint)) {
	        $conditions = array(
	                'id' => $complaint['CooperationComplaint']['cooperations_id'],
	                'sender'          => $complaint['CooperationComplaint']['sender'],
	                'receiver'        => $complaint['CooperationComplaint']['receiver'],
	            );
	        $cooperation = $this->Parttime->cooperationDetail($conditions, $type);
	        
	        $conditions = array(
	            'cooperations_id'   => $cooperation['Cooperation']['id'],
	            'sender'            => $cooperation['Cooperation']['sender'],
	            'receiver'          => $cooperation['Cooperation']['receiver'],
	        );
	        $this->Parttime->comments($conditions, $type);
	        $this->set('type', $type);
	        if (!$this->RequestHandler->isAjax()) {
	            if ($type == "receiver") {
	                $parttime = $this->PartTime->find('first', array('fields' => array('pay_time'), 'conditions' => array('id' => $cooperation['Cooperation']['part_times_id'])));
	                $this->set('parttime', $parttime);
	                $this->render('complaintdetail_company');
	            }
	            if (empty($cooperation)) {
	                $this->_sysDisplayErrorMsg("empty cooperation");
	            } else {
	                ;
	            }
	        } else {
	            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
	                $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
	                $this->set('jump', $page);
	            }
	            $this->render('/Elements/cooperation_comments_paginator');
	        }
        } else {
            $this->_sysDisplayErrorMsg("empty cooperations");
        }
    }
    
    /**
     * 
     * 设置合作信息的状态
     */
    public function setStatus()
    {
        $this->autoRender = false;
        
        if (isset($this->request->data['status']) && !empty($this->request->data['status'])) {
            $data = array(
                'status' => $this->request->data['status'],
                'modified' => "'" . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "'"
            );
            if ($this->request->data['status'] == Configure::read('Cooperation.status.waitpay')) {
                $data['allow_dt'] = "'" . date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']) . "'";
            }
            if ($this->request->data['type'] == "send") {
                $conditions = array(
                    'id'    => $this->request->data['id'],
                    'sender'    => $this->_memberInfo['Member']['id']
                );
               if ($this->Parttime->setCooperationStatus($data, $conditions)) {
                   $result = array(
                        'result' => 'OK',
                    );
                } else {
                   $result = array(
                        'result' => 'NG',
                        'msg'   => ''
                    );
                }
            } elseif ($this->request->data['type'] == "receiver") {
                $conditions = array(
                    'id'    => $this->request->data['id'],
                    'receiver'    => $this->_memberInfo['Member']['id']
                );
                if ($this->Parttime->setCooperationStatus($data, $conditions)) {
                   $result = array(
                        'result' => 'OK',
                    );
                } else {
                   $result = array(
                        'result' => 'NG',
                        'msg'   => ''
                    );
                }
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'   => ''
                );
            }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'   => ''
            );
        }
        $this->_sendJson($result);
    }
    
    /**
     * 
     * 企业会员点击合作失败
     */
    public function failure()
    {
        $this->autoRender = false;
        $conditions = array(
            'id' => $this->request->data['cooperations_id'],
            'receiver' => $this->_memberInfo['Member']['id']
        );
        if ($this->Cooperation->find('count', array('conditions' => $conditions)) > 0) {
            if ($this->Cooperation->failure($this->request->data, $this->_memberInfo['Member']['id'])) {
                $result = array(
                    'result' => 'OK'
                );
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '系统错误，提交失败，请稍后重试！'
                );
            }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'    => '合作对象不存在！'
            );
        }
        $this->_sendJson($result);
    }
    
    public function comment()
    {
        $this->autoRender = false;
        if (!$this->RequestHandler->isAjax()) {
            return 0;
        }
        
        $data = $this->request->data;
        if ($this->CooperationComment->save($data)) {
            $result = array(
                'result' => 'OK', 
                'time' => date('Y-m-d H:i:s', time())
            );
        } else {
            $result = array('result' => 'NG');
        }
        $this->_sendJson($result);
    }
    /**
     * 
     * 企业会员业务精英
     */
    public function elite()
    {
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'MemberAttribute.members_id = Member.id'
        );
        $fields = array(
            'Member.id',
            'Member.nickname',
            'provincial_id',
            'city_id',
            'category_id',
            'Attribute.thumbnail'
        );
        $conditions = array();
        if (isset($this->request->data['sex'])) {
            $conditions['sex'] = $this->request->data['sex'];
        }
        if (isset($this->request->data['city'])) {
            $conditions['OR'] = array('provincial_id' => $this->request->data['city'], 'city_id' => $this->request->data['city']);
        }
        
        
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 10;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        if (!empty($conditions)) {
            $this->paginate = array(
                'MemberAttribute' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('MemberAttribute.last_login' => 'DESC'),
                    'conditions' => $conditions,
                    'fields'    => $fields,
                    'joins'     => array($joinMember)
                )
            );
        } else {
            $this->paginate = array(
                'MemberAttribute' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('MemberAttribute.last_login' => 'DESC'),
                    'fields'    => $fields,
                    'joins'     => array($joinMember)
                )
            );
        }
        $this->set('pageSize', $pageSize);
        $this->set("elites", $this->paginate('MemberAttribute'));
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/elite_paginator');
        }
    }
    /**
     * 
     * 企业会员业务精英详情
     */
    public function elitedetail()
    {
        
    }
    /**
     * 
     * 个人会员收藏某兼职
     */
    public function favorite()
    {
        
    }
    
    public function beforeRender()
    {
        $this->currentMenu = Configure::read('Menu.parttimeManager');
        $css = array(
        'member'
        );
        $js = array('member');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
    }
}