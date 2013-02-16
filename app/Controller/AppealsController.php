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
        'AppealAnswerTemplate',
        'Friendship',
        'PaymentTransaction'
    );
	var $helpers = array('Js', 'City', 'Category');
	var $components = array('RequestHandler', 'Info', 'Unit', 'Recommend');
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
	    /*
	    $query = $this->request->params['named'];
	    if (!isset($query['id']) || empty($query['id'])) {
	        $this->_sysDisplayErrorMsg("没有此信息的详情！");
            return 0;
	    }
	    */
	   $query = $this->request->query;
        if ((!isset($query['active']) && !isset($query['been'])) || (isset($query['active']) && isset($query['been']))){
            //TODO error 
            $this->_sysDisplayErrorMsg("没有你要确认的信息！");
            return 0;
        }
	   if (isset($query['active']) && !empty($query['active'])) {
            $id = $query['active'];
            $conditions = array(
                'information_id' => $id, 
                'members_id' => $this->_memberInfo['Member']['id'], 
                'buyer_members_id' => $query['mid'], 
            );
            $friendCond = array(
                'members_id' => $this->_memberInfo['Member']['id'], 
                'friend_members_id' => $query['mid']
            );
            $transaction_conditions = array(
                'information_id' => $id,
                'members_id' => $query['mid'], 
                'author_members_id' => $this->_memberInfo['Member']['id'], 
                'send_readed'       => 0
            );
            $up = array('send_readed' => 1);
        }
        if (isset($query['been']) && !empty($query['been'])) {
            $id = $query['been'];
            $conditions = array(
                'information_id' => $id, 
                'members_id' => $query['mid'], 
                'buyer_members_id' => $this->_memberInfo['Member']['id'], 
            );
            $friendCond = array(
                'members_id' => $query['mid'], 
                'friend_members_id' => $this->_memberInfo['Member']['id']
            );
            $up = array('receive_readed' => 1);
            $transaction_conditions = array(
                'information_id' => $id,
                'members_id' => $this->_memberInfo['Member']['id'], 
                'author_members_id' => $query['mid'], 
                'receive_readed' => 0
            );
        }
	    $appeal = $this->Appeal->find('first', array('conditions' => $conditions));
	    if (empty($appeal)) {
	        $this->_sysDisplayErrorMsg("没有此信息的详情！");
            return 0;
	    }
	    
	    //是否阅读过
	    $this->PaymentTransaction->updateAll($up, $transaction_conditions);
	    
	    $this->Info->detail($appeal['Appeal']['information_id']);
	    $this->Info->baseMemberInfo($query['mid']);
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
        
        //是否朋友关系
        $isFriend = $this->Friendship->find('count', array('conditions' => $friendCond));
        $isFriend = $isFriend > 0 ? true : false;
        $this->set('isFriend', $isFriend);
        
        //platform
        $this->Info->appealAnswer($appeal['Appeal']['id']);
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