<?php
/**
 * 
 * 申诉相关控制器
 * @author deping_lin
 *
 */
class AppealsController extends AppController
{
    var $layout = 'members';
    var $uses = array(
        'InformationComment',
        'Appeal',
        'InformationComplaint',
        'AppealAnswerTemplate'
    );
	var $helpers = array('Js', 'City', 'Category');
	var $components = array('RequestHandler', 'Info');
	var $paginate;
	
	public function listview()
	{
	    $this->set("msg", "没有申诉信息");
	    $this->set('title_for_layout', "我的申诉");
	    $status = Configure::read('Appeal.status_code.appealing');
	    $conditions = array(
	        'Appeal.members_id' => $this->_memberInfo['Member']['id'],
	        'Appeal.status'	 => $status
	    );
	    $joinMember = array(
	        'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'Information.members_id = Member.id'
	    );
	    $joinInformation = array(
	        'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = Appeal.information_id'
	    );
	    $fields = array(
	        'Member.nickname',
	        'Information.title',
	        'Appeal.*'
	    );
	    $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 2;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'Appeal' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('Appeal.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinInformation, $joinMember)
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("appeals", $this->paginate('Appeal'));
	    if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/appeals_paginator');
        }
	}
	
	public function detail()
	{
	    $this->set('title_for_layout', "申诉详细");
	    $query = $this->request->params['named'];
	    if (!isset($query['id']) || empty($query['id'])) {
	        $this->_sysDisplayErrorMsg("没有此信息的详情！");
            return 0;
	    }
	    $appeal = $this->Appeal->find('first', array('conditions' => array('id' => $query['id'])));
	    if (empty($appeal)) {
	        $this->_sysDisplayErrorMsg("没有此信息的详情！");
            return 0;
	    }
	    $this->Info->detail($appeal['Appeal']['information_id']);
	    $this->Info->baseMemberInfo($appeal['Appeal']['buyer_members_id']);
        //投诉
        $complaint = $this->Info->complaint($appeal['Appeal']['information_id'], $appeal['Appeal']['buyer_members_id']);
        //投诉答案
        if (!empty($complaint)) {
            $this->Info->answer($complaint['InformationComplaint']['id']);
        }
	    $this->Info->comments($appeal['Appeal']['information_id'], $this->_memberInfo['Member']['id'], $appeal['Appeal']['buyer_members_id']);
	    $this->set('type', 'has');
	   if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/comments_paginator');
        }
        
        //platform
        $this->Info->appealAnswer($query['id']);
        $templates = $this->AppealAnswerTemplate->find('all');
        $this->set('templates', $templates);
        $this->set('appeal', $appeal);
        $this->set('complaint', $complaint);
	}
	
	public function add()
	{
	    $this->autoRender = false;
	    $complaint = $this->InformationComplaint->find('first', array('conditions' => array('id' => $this->request->data['complaints_id'])));
	    if (empty($complaint)) {
	       $result = array(
	           'result' => 'NG',
	           'msg'    => '此投诉信息不存在，不能申诉！'
	       );
	    } else {
	        $conditions = array(
	           'information_id' => $complaint['InformationComplaint']['information_id'],
	           'members_id'     => $this->_memberInfo['Member']['id'],
	           'buyer_members_id' => $complaint['InformationComplaint']['members_id'],
	        );
	        if ($this->Appeal->find('count', array('conditions' => $conditions)) > 0) {
	            $result = array(
                   'result' => 'NG',
                   'msg'    => '此交易已经申诉过，不能重复申诉！'
               );
	        } else {
                $data = array(
                    'information_id'    => $complaint['InformationComplaint']['information_id'],
                    'members_id'        => $this->_memberInfo['Member']['id'],
                    'buyer_members_id'  => $complaint['InformationComplaint']['members_id'],
                    'content'           => $this->request->data['content'],
                    'status'            => Configure::read('Appeal.status_code.appealing')
                );
                if ($this->Appeal->add($data, $this->request->data['complaints_id'])){
                   $result = array(
                       'result' => 'OK',
                   );
               } else {
                   $result = array(
                       'result' => 'NG',
                       'msg'    => '对不起！系统发生错误，申诉失败！请你稍候重试！'
                   );
               }
	        }
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