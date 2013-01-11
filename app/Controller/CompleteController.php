<?php
/**
 * 
 * 已交易控制器
 * @author deping_lin
 *
 */
class CompleteController extends AppController
{
    var $layout = 'members';
    var $uses = array(
    	'Information', 
    	'PaymentTransaction', 
    	'InformationAttribute', 
		'Member',
        'InformationComment',
        'InformationComplaint'
	);
    var $helpers = array('Js', 'City', 'Category');
	var $components = array('RequestHandler', 'Info', 'Unit');
	var $paginate;
	
	public function listview()
	{
	    $this->set("msg", "没有已交易信息");
	    $this->set('title_for_layout', "已交易");
        if (isset($this->request->query['type'])) {
            $type = $this->request->query['type'];
            if ($type != "has" && $type != "need") {
                $this->_sysDisplayErrorMsg("已交易记录！");
                return 0;
            }
        } else {
            $type = "has";
        }
        $this->Info->transaction($this->_memberInfo['Member']['id'], $type, array(Configure::read('Transaction.status_code.complete'), Configure::read('Transaction.status_code.complaint_cancel'), Configure::read('Transaction.status_code.appeal_effective')));
        $this->set("type", $type);
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/transaction_paginator');
        }
    }
    
    
    public function detail()
    {
        $this->set('title_for_layout', "已交易详细");
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
				'status' => array(Configure::read('Transaction.status_code.complete'), Configure::read('Transaction.status_code.complaint_cancel'), Configure::read('Transaction.status_code.appeal_effective'))
            );
            $conditionsAppraisal = array(
                'information_id' => $information_id,
                'from_members_id' => $query['mid']
            );
        } else {
            $transactionP = array(
				'information_id' => $information_id,
                'members_id' => $this->_memberInfo['Member']['id'],
                'author_members_id' => $query['mid'],
				'status' => array(Configure::read('Transaction.status_code.complete'), Configure::read('Transaction.status_code.complaint_cancel'), Configure::read('Transaction.status_code.appeal_effective'))
            );
            $conditionsAppraisal = array(
                'information_id' => $information_id,
                'from_members_id' => $this->_memberInfo['Member']['id']
            );
        }
        $transaction = $this->Info->transactionDetail($transactionP);
        if (empty($transaction)) {
            $this->_sysDisplayErrorMsg("没有此待确认详细信息！");
            return 0;
        }
        
        $this->Info->comments($information_id, $this->_memberInfo['Member']['id'], $query['mid']);
        $this->set('type', $type);
        if (!$this->RequestHandler->isAjax()){
            $this->Info->detail($information_id);
	        $this->Info->baseMemberInfo($query['mid']);
	        //评价
	        $showAppraisal = false;
            $appraisal = $this->Info->appraisal($conditionsAppraisal);
            if (empty($appraisal)) {
                $showAppraisal = true;
            }
	        if ($type == "has") {
	            $showAppraisal = false;
            }
            $this->set('showAppraisal', $showAppraisal);
            
            if ($transaction['PaymentTransaction']['status'] > 
                Configure::read('Transaction.status_code.complete')
            ) {
                $this->Info->complaint($transactionP['information_id'], $transactionP['members_id']);
                $conditions = array(
                    'information_id' => $transactionP['information_id'],
                    'members_id'     => $transactionP['author_members_id'],
                    'buyer_members_id' => $transactionP['members_id']
                );
                $this->Info->appeal($conditions);
            }
            
            
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
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
	}
}