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
        'PaymentTransaction'
    );
    var $helpers = array('Js', 'City', 'Category');
	var $components = array('RequestHandler');
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
        $query = $this->request->query;
        
        if ((!isset($query['active']) && !$query['been']) || (isset($query['active']) && isset($query['been']))){
            //TODO error 
            $this->_sysDisplayErrorMsg("没有你要确认的信息！");
            return 0;
        }
        $id = '';
        if (isset($query['active']) && !empty($query['active'])) {
            $id = $query['active'];
            $type = "active";
            $conditions = array('id' => $id, 'members_id' => $this->_memberInfo['Member']['id'], 'status' => array(Configure::read('Complaint.status_code.discuss'), Configure::read('Complaint.status_code.platform')));
//            $conditions = array('id' => $id, 'members_id' => $this->_memberInfo['Member']['id']);
        }
        if (isset($query['been']) && !empty($query['been'])) {
            $id = $query['been'];
            $type = "been";
            $conditions = array('id' => $id, 'target_members_id' => $this->_memberInfo['Member']['id'], 'status' => Configure::read('Complaint.status_code.discuss'));
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
        $appealCon = array('information_id' => $complaint['InformationComplaint']['information_id']);
        if ($type == "active") {
            $mCondition = array('id' => $complaint['InformationComplaint']['target_members_id']);
            $appealCon['members_id'] = $complaint['InformationComplaint']['members_id'];
            $appealCon['buyer_members_id'] = $complaint['InformationComplaint']['target_members_id'];
            $seller_type = "被投诉者";
            $this->set('type', "need");
        } else {
            $mCondition = array('id' => $complaint['InformationComplaint']['members_id']);
            $appealCon['members_id'] = $complaint['InformationComplaint']['target_members_id'];
            $appealCon['buyer_members_id'] = $complaint['InformationComplaint']['members_id'];
            $seller_type = "投诉者";
            $this->set('type', "has");
        }
        $author = $this->Member->find('first',array('conditions' => $mCondition));
        $conditions = array(
            'members_id' => $author['Member']['id'],
            'io'		 => Configure::read('Payment.io.in'),
            'OR' => array(
                'payment_type' => Configure::read('Payment.type_normal_coin'),
                'payment_type' => Configure::read('Payment.type_normal_point'),
            )
        );
        $transaction_has_num = $this->PaymentHistory->find('count', array('conditions' => $conditions));
        $conditions['io'] = Configure::read('Payment.io.out');
        $transaction_need_num = $this->PaymentHistory->find('count', array('conditions' => $conditions));
        
        
        $information = $this->Information->find('first', array('conditions' => array('id' => $complaint['InformationComplaint']['information_id'])));
        $informationAttributes = $this->InformationAttribute->find('all', array('conditions' => array('information_id' => $complaint['InformationComplaint']['information_id'])));
        
        $transaction_conditions = array(
            'information_id'    => $complaint['InformationComplaint']['information_id'],
            'members_id'        => $complaint['InformationComplaint']['members_id'],
            'author_members_id' => $complaint['InformationComplaint']['target_members_id']
        );
        $transaction = $this->PaymentTransaction->find('first', array('conditions' => $transaction_conditions));
        
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
        $commentParams = array(
            'fields' => $fields,
            'conditions' => array(
                'information_id' => $complaint['InformationComplaint']['information_id'],
                'show' => 1,
                'OR' => array(
                    array(
                        'members_id' => $complaint['InformationComplaint']['members_id'],
                        'target_members_id' => $complaint['InformationComplaint']['target_members_id']
                    ),
                    array(
                        'members_id' => $complaint['InformationComplaint']['target_members_id'],
                        'target_members_id' => $complaint['InformationComplaint']['members_id']
                    ),
                )
            ),
            'joins' => array($joinMember),
            'order' => array('InformationComment.created DESC')
        );
        $comments = $this->InformationComment->find('all', $commentParams);
        
        $appeal = $this->Appeal->find('first', array('conditions' => $appealCon));
        $this->set('complaint', $complaint);
        $this->set('information', $information);
        $this->set('attributes', $informationAttributes);
        $this->set('author', $author);
        $this->set('seller_type', $seller_type);
        $this->set('transaction_has_num', $transaction_has_num);
        $this->set('transaction_need_num', $transaction_need_num);
        $this->set('comments', $comments);
        $this->set('complaints_type', $type);
        $this->set('appeal', $appeal);
        $this->set('transaction', $transaction);
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
	}
}