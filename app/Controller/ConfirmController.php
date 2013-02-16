<?php
/**
 * 
 * 待确认交易控制器
 * @author deping_lin
 *
 */
class ConfirmController extends AppController
{
    var $layout = 'members';
    var $uses = array(
        'Information', 
        'PaymentTransaction', 
        'InformationAttribute', 
        'Member',
        'InformationComment',
        'InformationComplaint',
        'Friendship'
    );
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Info', 'Unit', 'Recommend');
    var $paginate;
    public function listview()
    {
        $this->set("msg", "没有待确认交易信息");
        $this->set('title_for_layout', "待确认交易");
        if (isset($this->request->query['type'])) {
            $type = $this->request->query['type'];
            if ($type != "has" && $type != "need") {
                $this->_sysDisplayErrorMsg("没有待确认交易！");
                return 0;
            }
        } else {
            $type = "has";
        }
        if (isset($this->request->data['status']) && !empty($this->request->data['status'])) {
            $status = $this->request->data['status'];
            $this->set('status', $this->request->data['status']);
        } else {
            $status = array(
                Configure::read('Transaction.status_code.transaction'), 
                Configure::read('Transaction.status_code.complaint'),
                Configure::read('Transaction.status_code.appeal')
            );
            $this->set('status', $status);
        }
        $this->Info->transaction($this->_memberInfo['Member']['id'], $type, $status);
        $this->set("type", $type);
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->set('isAjax', true);
            $this->render('/Elements/confirm_paginator');
        }
        $this->set('isAjax', false);
    }
    
    public function detail()
    {
        $this->set('title_for_layout', "待确认交易详细");
        $query = $this->request->params['named'];
        if (isset($query['has'])) {
            if (empty($query['has'])) {
                $this->_sysDisplayErrorMsg("没有此信息的详情！");
                return 0;
            } else {
                $type = "has";
                $information_id = $query['has'];
            }
        } else if(isset($query['need'])){
            if (empty($query['need'])) {
                $this->_sysDisplayErrorMsg("没有此信息的详情！");
                return 0;
            } else {
                $type = "need";
                $information_id = $query['need'];
            }
        } else {
            $this->_sysDisplayErrorMsg("没有此信息的详情！");
            return 0;
        }
        if (!isset($query['mid']) || empty($query['mid'])) {
            $this->_sysDisplayErrorMsg("没有此信息的详情！");
            return 0;
        }
        
        if ($type == "has") {
            $transactionP = array(
                'information_id' => $information_id,
                'members_id' => $query['mid'],
                'author_members_id' => $this->_memberInfo['Member']['id'],
                'status' => Configure::read('Transaction.status_code.transaction')
            );
        } else {
            $transactionP = array(
                'information_id' => $information_id,
                'members_id' => $this->_memberInfo['Member']['id'],
                'author_members_id' => $query['mid'],
                'status' => Configure::read('Transaction.status_code.transaction')
            );
        }
        $transaction = $this->Info->transactionDetail($transactionP);
        if (empty($transaction)) {
            $this->_sysDisplayErrorMsg("<div class='sysDisplayErrorMsg'></div>");
            return 0;
        }
        
        //是否阅读过
        $up = array();
        if ($type == "has") {
            if ($transaction['PaymentTransaction']['send_readed'] == 0) {
                $conditions = array(
	                'information_id' => $information_id,
	                'members_id' => $query['mid'],
	                'author_members_id' => $this->_memberInfo['Member']['id'],
	            );
	            $up = array('send_readed' => 1);
            }
        } else {
            if ($transaction['PaymentTransaction']['receive_readed'] == 0) {
                $conditions = array(
	                'information_id' => $information_id,
	                'members_id' => $this->_memberInfo['Member']['id'],
	                'author_members_id' => $query['mid'],
	            );
	            $up = array('receive_readed' => 1);
            }
        }
        if (!empty($up)) {
            $this->PaymentTransaction->updateAll($up, $conditions);
        }
        
        
        $this->Info->comments($information_id, $this->_memberInfo['Member']['id'], $query['mid']);
        $this->set('type', $type);
        if (!$this->RequestHandler->isAjax()){
            $this->Info->detail($information_id);
            $this->Info->baseMemberInfo($query['mid']);
            if ($type == "need") {
                //投诉
                $params = array(
                    'conditions' => array('members_id' => $this->_memberInfo['Member']['id'], 'information_id' => $information_id)
                );
                $complainted = $this->InformationComplaint->find('count', $params);
                $this->set('complainted', $complainted > 0 ? true : false);
                $friendCond = array(
                  'members_id' => $this->_memberInfo['Member']['id'], 
                  'friend_members_id' => $transaction['PaymentTransaction']['author_members_id']
                );
            } else {
                $this->set('complainted', true);
                $friendCond = array(
                  'members_id' => $this->_memberInfo['Member']['id'], 
                  'friend_members_id' => $transaction['PaymentTransaction']['members_id']
                );
            }
            //是否朋友关系
            $isFriend = $this->Friendship->find('count', array('conditions' => $friendCond));
            $isFriend = $isFriend > 0 ? true : false;
            $this->set('isFriend', $isFriend);
        } else {
            if ($this->RequestHandler->isAjax()) {
                if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                    $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
                    $this->set('jump', $page);
                }
                $this->render('/Elements/comments_paginator');
            }
        }
        
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