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
        'InformationComplaint'
	);
    var $helpers = array('Js', 'City', 'Category');
	var $components = array('RequestHandler', 'Info');
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
        $this->Info->transaction($this->_memberInfo['Member']['id'], $type, Configure::read('Transaction.status_code.transaction'));
        $this->set("type", $type);
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/confirm_paginator');
        }
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
            $this->_sysDisplayErrorMsg("没有此待确认详细信息！");
            return 0;
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
	        } else {
	            $this->set('complainted', true);
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
	}
}