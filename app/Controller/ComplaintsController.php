<?php
/**
 * 
 * 会员投诉相关处理控制器
 * @author lin_deping
 *
 */
class ComplaintsController extends AppController
{
    var $layout = 'members';
    var $uses = array(
        'InformationComplaint', 
        'Information', 
        'InformationAttribute', 
        'InformationComment', 
        'Member', 
        'PaymentHistory',
        'ComplaintAnswer',
        'Appeal',
        'PaymentTransaction',
        'Friendship'
    );
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Unit', 'Info', 'Recommend');
    var $paginate;
    public function index($type)
    {
        if (!isset($type) || ($type != Configure::read('Complaint.ActiveText') && $type != Configure::read('Complaint.BeenText'))) {
            $msg = "投诉";
            $this->_sysDisplayErrorMsg($msg);
        }
        if ($type == Configure::read('Complaint.ActiveText')) {
            $conditions = array(
            'InformationComplaint.members_id' => $this->_memberInfo['Member']['id'],
            'InformationComplaint.status' => array(Configure::read('Complaint.status_code.discuss'), Configure::read('Complaint.status_code.platform'))
            );
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'Member.id = InformationComplaint.target_members_id'
            );
            $this->set("msg", "没有投诉信息");
            
        } elseif ($type == Configure::read('Complaint.BeenText')) {
            $conditions = array(
            'InformationComplaint.target_members_id' => $this->_memberInfo['Member']['id'],
            'InformationComplaint.status' => Configure::read('Complaint.status_code.discuss')
            );
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'Member.id = InformationComplaint.members_id'
            );
            $this->set("msg", "没有被投诉信息");
        }
        $this->set('complaint_type', $type);
        $joinInformation = array(
            'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = InformationComplaint.information_id'
        );
        
        $fields = array(
            'Member.nickname',
            'Information.title',
            'InformationComplaint.id',
            'InformationComplaint.reason',
            'InformationComplaint.status',
            'InformationComplaint.created'
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 2;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'InformationComplaint' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('InformationComplaint.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinInformation, $joinMember)
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("informations", $this->paginate('InformationComplaint'));
        $this->set("type", "receive");
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/complaint_paginator');
        }
    }
    
    public function detail()
    {
        $this->set('title_for_layout', "投诉详细");
        if (!$this->RequestHandler->isAjax()) {
            $query = $this->request->query;
            if ((!isset($query['active']) && !isset($query['been'])) || (isset($query['active']) && isset($query['been']))){
                //TODO error 
                $this->_sysDisplayErrorMsg("没有你要确认的信息！");
                return 0;
            }
            $id = '';
            if (isset($query['active']) && !empty($query['active'])) {
                $id = $query['active'];
                $type = "active";
                $conditions = array(
                    'information_id' => $id, 
                    'members_id' => $this->_memberInfo['Member']['id'], 
                    'target_members_id' => $query['mid'],  
                    'status' => array(Configure::read('Complaint.status_code.discuss'), Configure::read('Complaint.status_code.platform'))
                );
            }
            if (isset($query['been']) && !empty($query['been'])) {
                $id = $query['been'];
                $type = "been";
                $conditions = array(
                    'information_id' => $id, 
                    'members_id' => $query['mid'], 
                    'target_members_id' => $this->_memberInfo['Member']['id'],
                    'status' => Configure::read('Complaint.status_code.discuss')
                );
            }
            if (empty($id)) {
                //TODO
                $this->_sysDisplayErrorMsg("没有你要确认的信息！");
                return 0;
            }
            $joinAnswer = array(
                'table' => 'complaint_answers',
                'alias' => 'Answer',
                'type'  => 'left',
                'conditions' => 'InformationComplaint.id = Answer.information_complaints_id'
            );
            $fields = array('InformationComplaint.*', 'Answer.answer');
            $complaint = $this->InformationComplaint->find('first', array('conditions' => $conditions, 'fields' => $fields, 'joins' => array($joinAnswer)));
            if (empty($complaint)) {
                //TODO
                $this->_sysDisplayErrorMsg("没有你要确认的信息！1");
                return 0;
            }
            $this->Info->comments($complaint['InformationComplaint']['information_id'], $this->_memberInfo['Member']['id'], $query['mid']);
            $appealCon = array('information_id' => $complaint['InformationComplaint']['information_id']);
            if ($type == "active") {
                $appealCon['members_id'] = $complaint['InformationComplaint']['members_id'];
                $appealCon['buyer_members_id'] = $complaint['InformationComplaint']['target_members_id'];
                $seller_type = "被投诉者";
                $this->set('type', "need");
                $friendCond = array(
                    'members_id' => $this->_memberInfo['Member']['id'], 
                    'friend_members_id' => $complaint['InformationComplaint']['target_members_id']
                );
            } else {
                $appealCon['members_id'] = $complaint['InformationComplaint']['target_members_id'];
                $appealCon['buyer_members_id'] = $complaint['InformationComplaint']['members_id'];
                $seller_type = "投诉者";
                $this->set('type', "has");
                $friendCond = array(
                    'members_id' => $this->_memberInfo['Member']['id'], 
                    'friend_members_id' => $complaint['InformationComplaint']['members_id']
                );
            }
            $information = $this->Information->find('first', array('conditions' => array('id' => $complaint['InformationComplaint']['information_id'])));
            $informationAttributes = $this->InformationAttribute->find('all', array('conditions' => array('information_id' => $complaint['InformationComplaint']['information_id'])));
            
            $transaction_conditions = array(
                'information_id'    => $complaint['InformationComplaint']['information_id'],
                'members_id'        => $complaint['InformationComplaint']['members_id'],
                'author_members_id' => $complaint['InformationComplaint']['target_members_id']
            );
            $transaction = $this->PaymentTransaction->find('first', array('conditions' => $transaction_conditions));
            
            //是否阅读过
            $up = array();
            if ($type == "active") {
                if ($transaction['PaymentTransaction']['receive_readed'] == 0) {
                    $up = array('receive_readed' => 1);
                }
            } else {
                if ($transaction['PaymentTransaction']['send_readed'] == 0) {
                    $up = array('send_readed' => 1);
                }
            }
            
            if (!empty($up)) {
                $this->PaymentTransaction->updateAll($up, $transaction_conditions);
            }
            
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'InformationComment.members_id = Member.id'
            );
            $fields = array(
                'InformationComment.members_id',
                'InformationComment.content',
                'InformationComment.created',
                'Member.id',
                'Member.nickname'
            );
            
            //会员信息
            $this->Info->baseMemberInfo($query['mid']);
            
            //是否朋友关系
            $isFriend = $this->Friendship->find('count', array('conditions' => $friendCond));
            $isFriend = $isFriend > 0 ? true : false;
            $this->set('isFriend', $isFriend);
            $appeal = $this->Appeal->find('first', array('conditions' => $appealCon));
            $this->set('complaint', $complaint);
            $this->set('information', $information);
            $this->set('attributes', $informationAttributes);
            $this->set('seller_type', $seller_type);
            $this->set('information_id', $complaint['InformationComplaint']['information_id']);
            $this->set('mid', $query['mid']);
            $this->set('complaints_type', $type);
            $this->set('appeal', $appeal);
            $this->set('transaction', $transaction);
        } else {
            $this->Info->comments($this->request->data['information_id'], $this->_memberInfo['Member']['id'], $this->request->data['mid']);
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
                $this->set('jump', $page);
            }
            $this->set('information_id', $this->request->data['information_id']);
            $this->set('mid', $this->request->data['mid']);
            $this->render('/Elements/comments_paginator');
        }
    }
    
    public function answer()
    {
        $this->autoRender = false;
        if ($this->ComplaintAnswer->find('count', array('conditions' => array('information_complaints_id' => $this->request->data['information_complaints_id']))) > 0) {
            $result = array('result' => 'EXIST');
        } else {
            try {
                $this->ComplaintAnswer->save($this->request->data);
                $result = array('result' => 'OK', 'text' => $this->request->data['answer']);
            } catch (Exception $e) {
                $result = array('result' => 'NG');
                $this->log(__CLASS__ . "->" . __FUNCTION__ . "()" . "msg:" . $e->getMessage());
            }
        }
        $this->_sendJson($result);
    }
    
    public function agree()
    {
        $this->autoRender = false;
        $complaints_id = $this->request->data['complaints_id'];
        $complaint = $this->InformationComplaint->find('first', array('conditions' => array('id' => $complaints_id, 'target_members_id' => $this->_memberInfo['Member']['id'])));
        if (!empty($complaint)) {
            if ($complaint['InformationComplaint']['status'] == Configure::read('Complaint.status_code.discuss')
                || $complaint['InformationComplaint']['status'] == Configure::read('Complaint.status_code.platform')
            ) {
                if ($this->InformationComplaint->agree($complaint)) {
                    $result = array('result' => 'OK');
                } else {
                    $result = array('result' => 'NG');
                }
            } else {
                $result = array('result' => 'unable');
            }
        } else {
            $result = array('result' => 'not exist');
        }
        $this->_sendJson($result);
    }
    
    public function cancel()
    {
//        $this->autoRender = false;
        // show -> 0 appeal.cancel_flg = 1, transaction.status -> 2
        $complaints_id = $this->request->data['complaints_id'];
        $conditions = array(
            'id' => $complaints_id,
            'show' => 1,
            'status' => array(Configure::read('Complaint.status_code.discuss'), Configure::read('Complaint.status_code.platform'))
        );
        $complaint = $this->InformationComplaint->find('first', array('conditions' => $conditions));
        if (empty($complaint)) {
            $result = array(
                'result' => 'NG',
                'msg'    => '没有你可以撤销的投诉！'
            );
        } else {
            if ($this->InformationComplaint->cancel($complaints_id)) {
                $result = array('result' => 'OK');
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '系统出错，撤销投诉失败，请稍后重试！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
    public function add()
    {
       $this->autoRender = false;
       if (!$this->RequestHandler->isAjax()) {
           return 0;
       }
        $conditions = array(
            'members_id' => $this->_memberInfo['Member']['id'],
            'information_id' => $this->request->data['information_id'],
            'target_members_id'     => $this->request->data['target_members_id'],
        );
        if ($this->InformationComplaint->find('count', array('conditions' => $conditions)) == 0) {
            $data = array(
                'members_id' => $this->_memberInfo['Member']['id'],
                'information_id' => $this->request->data['information_id'],
                'target_members_id'     => $this->request->data['target_members_id'],
                'status'                => Configure::read('Complaint.status_code.discuss'),
                'reason' => $this->request->data['content']
           );
           if ($this->InformationComplaint->complaint($data)) {
                $result = array('result' => 'OK');
           } else {
                $result = array('result' => 'NG');
           }
        } else {
            $result = array('result' => 'NG', 'msg' => '已经投诉过了，不能重复投诉！');
        }
       
       $this->_sendJson($result);
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