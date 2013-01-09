<?php
class InformationsController extends AppController
{
	var $layout = 'members';
	var $uses = array(
    	'City', 
    	'Category', 
    	'Information', 
    	'PaymentTransaction', 
    	'PaymentHistory', 
    	'InformationAttribute', 
    	'InformationComplaint',
    	'MemberReceived',
		'InformationComment',
		'Member',
		'Payment'
	);
	var $helpers = array('Js', 'City', 'Category');
	var $components = array('RequestHandler');
	var $paginate;
	
	public function index()
	{
		$this->set('title_for_layout', "信息详情");
	}
	/**
	 * 
	 * 发布需求，发布客源
	 */
	public function create()
	{
		$this->set('title_for_layout', "信息发布");
		$type = isset($this->request->params['pass'][0]) ? ($this->request->params['pass'][0] == "has" ? 0 : 1) : 0;
		$target = (isset($this->request->query['target'])) ? $this->request->query['target'] : "";
		$target_member = (isset($this->request->query['target_member'])) ? $this->request->query['target_member'] : "";
		if (!empty($target) && !$this->request->is('post')) {
		    $targetInfo = $this->Information->find('first', array('conditions' => array('id' => $target)));
//		    var_dump($targetInfo);
		    if (!empty($targetInfo)) {
	            $this->set('targetInfo', $targetInfo);
		    }
		}
		$this->_appendJs(array('jquery-ui'));
		$this->_appendCss(array('ui/jquery-ui', 'ui/calendar'));
		$this->set('type', $type);
		$this->set('target', $target);
		$this->set('target_member', $target_member);
		if ($type) {
            $this->render('create_reward');
		}
	}
	/**
	 * 
	 * 发布确认
	 */
	public function check()
	{
		$this->set('title_for_layout', "信息内容确认");
		$param = array(
			'fields' => array('name'),
			'conditions' => array('id' => $this->request->data['provincial'])
		);
		$provincial = $this->City->find('first', $param);
		$param['conditions'] = array('id' => $this->request->data['city']);
		$city = $this->City->find('first', $param);
		$this->set("provincial", $provincial['City']['name']);
		$this->set('city', $city['City']['name']);
		$category = $this->Category->find('first', array('fields' => array('name'), 'conditions' => array('id' => $this->request->data['category'])));
		$sub_category = $this->Category->find('first', array('fields' => array('name'), 'conditions' => array('id' => $this->request->data['sub_category'])));
		if (!$this->request->data['type']) {
			$industry = $this->Category->find('first', array('fields' => array('name'), 'conditions' => array('id' => $this->request->data['industries_id'])));
			$this->set('industry', $industry['Category']['name']);
		}
		$this->set('category', $category['Category']['name']);
		if ($this->request->data['type'] == 1) {
			$this->render('check_reward');
		}
	}
	/**
	 * 
	 * 发布完成
	 */
	public function complete()
	{
	    $this->set('title_for_layout', "信息发布完成");
	    if ($this->request->data['type'] == 0) {
	    	$data = array(
		    	'members_id'		=> $this->_memberInfo['Member']['id'],
		    	'type'          	=> $this->request->data['type'],
		        'title'         	=> $this->request->data['title'],
		    	'provincial'    	=> $this->request->data['provincial'],
				'city'    			=> $this->request->data['city'],
	    		'company'			=> $this->request->data['company'],
				'industries_id'    	=> $this->request->data['industries_id'],
				'category'    		=> $this->request->data['category'],
		    	'sub_category'    	=> $this->request->data['sub_category'],
		    	'other_category'    => $this->request->data['other_category'],
		    	'open'				=> $this->request->data['open'],
		    	'close'				=> $this->request->data['close'],
		    	'payment_type'		=> 0,
		    	'introduction'		=> $this->request->data['introduction'],
		    	'profit'			=> $this->request->data['profit'],
		    	'finished'			=> $this->request->data['finished'],
		    	'reason'			=> $this->request->data['reason'],
		    	'additional'		=> $this->request->data['additional'],
		    	'stauts'			=> 0,
		    	'display'			=> 1
		    );
		    foreach ($this->request->data['contact'] as $key => $value) {
	    	    	$attributes[] = array(
	    	    	'contact' => $value, 
	    	    	'post' => $this->request->data['post'][$key], 
	    	    	'address' => $this->request->data['address'][$key],
	    	    	'contact_method' => $this->request->data['contact_method'][$key],
		    	);
		    }
	    } else {
	    	$data = array(
	    		'members_id'		=> $this->_memberInfo['Member']['id'],
		    	'type'          	=> $this->request->data['type'],
		        'title'         	=> $this->request->data['title'],
		    	'provincial'    	=> $this->request->data['provincial'],
				'city'    			=> $this->request->data['city'],
	    		'company'			=> $this->request->data['company'],
	    		'category'    		=> $this->request->data['category'],
		    	'sub_category'    	=> $this->request->data['sub_category'],
		    	'other_category'    => $this->request->data['other_category'],
	    		'open'				=> $this->request->data['open'],
		    	'close'				=> $this->request->data['close'],
		    	'payment_type'		=> 0,
	    	    'introduction'		=> $this->request->data['introduction'],
	    		'reason'			=> $this->request->data['reason'],
		    	'additional'		=> $this->request->data['additional'],
		    	'stauts'			=> 0,
		    	'display'			=> 1
	    	);
	    }
	    if (isset($this->request->data['pay_coin'])) {
	    	$data['price'] = $this->request->data['price'];
	    	$data['payment_type'] += 1;
	    }
	    if (isset($this->request->data['pay_point'])) {
	    	$data['point'] = $this->request->data['point'];
	    	$data['payment_type'] += 2;
	    }
	    if ($this->request->data['type'] == 0) {
	        $target_members_id = isset($this->request->data['target_member']) ? $this->request->data['target_member'] : null;
	    	if ($this->Information->insertInformation($data, $attributes, $target_members_id)) {
	    		$message = "您已成功发布信息！";
	    	} else {
	    		$message = "发布失败！请重新发布！";
	    	}
	    } else {
	    	if ($this->Information->insertRewardInformation($data)) {
	    		$message = "您已成功发布信息！";
	    	} else {
	    		$message = "发布失败！请重新发布！";
	    	}
	    }
		$this->set('message', $message);
	}
	
	public function edit()
	{
	   
	}
	
	public function editcheck()
	{
	   
	}
	
	public function editcomplete()
	{
	   
	}
	
	public function cancellist()
	{
	    
	}
    public function canceldetail()
	{
	    
	}
	
	public function ajax_cancel()
	{
	    $this->autoRender = false;
	    if (!isset($this->request->data['information_id']) || empty($this->request->data['information_id'])) {
			$reuslt = $reuslt = array('result'=> 'NG', 'msg' => '系统出错，请稍后重试！');
		} else {
		    $id = $this->request->data['information_id'];
			$params = array('conditions' => array('information_id' => $id));
			$paid = $this->PaymentTransaction->find('count', $params);
			if ($paid > 0) {
			    $reuslt = array('result'=> 'NG', 'msg' => '已经有人购买，不能撤销这条信息！');
			} else {
			    $up_info = array('status' => Configure::read('Information.status_flg.cancel'));
			    try {
			        $this->Information->updateAll($up_info, array('id' => $id));
			        $reuslt = array('result'=> 'OK', 'msg' => 'OK');
			    } catch (Exception $e) {
			        $reuslt = array('result'=> 'NG', 'msg' => '系统出错，请稍后重试！');
			    }
			}
		}
		$this->_sendJson($reuslt);
	}
	
	/**
	 * 
	 * 会员自己发布的信息，查看详细页面
	 * @param int $id
	 */
	public function detail($id)
	{
	    $this->set('title_for_layout', "发布信息详细");
		if (!isset($id)) {
			
		}
        $joinsA = array(
            'table' => 'information_attributes',
            'alias' => 'Attributes',
            'type'  => 'left',
            'conditions' => 'Information.id = Attributes.information_id'
        );
		$params = array(
			'fields' => array('Information.*', 'Attributes.*'),
			'conditions' => array('id' => $id, 'members_id' => $this->_memberInfo['Member']['id'], 'status' => Configure::read('Information.status_flg.active')),
			'joins' => array($joinsA)
		);
		$information = $this->Information->find('first', $params);
		if (empty($information)) {
		    $this->_sysDisplayErrorMsg("没有相关信息");
		    return 0;
		}
		$params = array('conditions' => array('information_id' => $id));
		$attributes = $this->InformationAttribute->find('all', $params);
		
		$paid = $this->PaymentTransaction->find('count', $params);
		$paid = $paid > 0;
		//TODO
		$this->set('paid', $paid);
		$this->set("information", $information);
		$this->set('attributes', $attributes);
	}
	/**
	 * 
	 * 购买页面
	 * @param int $id
	 */
	public function payment($id)
	{
	    $this->set('title_for_layout', "购买信息");
		if (!isset($id)){
			//TODO error 
			return 0;
		}
		$comments = array();
		$params = array(
			'conditions' => array('id' => $id)
		);
		$information = $this->Information->find('first', $params);
		
		//history
		$paid = false;
		$params = array(
			'conditions' => array('information_id' => $id, 'members_id'	 => $this->_memberInfo['Member']['id'])
		);
		if ($this->PaymentHistory->find('count', $params) > 0
			|| $this->PaymentTransaction->find('count', $params) > 0
		) {
			$paid = true;
			
			
			//zhan nei xin
			$params = array(
			     'fields' => array('id', 'content', 'created'),
			     'conditions' => array('information_id' => $id),
			);
			$comments = $this->InformationComment->find('all', $params);
		}
		$params = array(
            'conditions' => array('information_id' => $id)
        );
        $attributes = $this->InformationAttribute->find('all', $params);
        $this->set('attributes', $attributes);
		$this->set('memberInfo', $this->_memberInfo);
		$this->set('information', $information);
		$this->set('comments', $comments);
		$this->set('paid', $paid);
	}
	
	public function ajax_payment()
	{
	    $id = $this->request->data['id'];
	    $type = $this->request->data['type'];
	    $comments = array();
		$params = array(
			'conditions' => array('id' => $id)
		);
		$information = $this->Information->find('first', $params);
		
		//history
		$paid = false;
		$params = array(
			'conditions' => array('information_id' => $id, 'members_id'	 => $this->_memberInfo['Member']['id'])
		);
		if ($this->PaymentHistory->find('count', $params) > 0
			|| $this->PaymentTransaction->find('count', $params) > 0
		) {
			$paid = true;
//			$params = array(
//				'conditions' => array('information_id' => $id)
//			);
//			$attributes = $this->InformationAttribute->find('all', $params);
//			$this->set('attributes', $attributes);
			
			//zhan nei xin
//			$params = array(
//			     'fields' => array('id', 'content', 'created'),
//			     'conditions' => array('information_id' => $id),
//			);
//			$comments = $this->InformationComment->find('all', $params);
		}
		$clicked = 0;
		$session = $this->Session->read('Information_' . $this->_memberInfo['Member'][id] . "_" . $id);
		if (empty($session)) {
		    $this->Information->updateClickCount($id);
		    $this->Session->write('Information_' . $this->_memberInfo['Member'][id] . "_" . $id, $id);
		    $clicked = 1;
		}
		
		$params = array(
			'conditions' => array('information_id' => $id)
		);
		$attributes = $this->InformationAttribute->find('all', $params);
		$this->set('attributes', $attributes);
		
		$this->set('memberInfo', $this->_memberInfo);
		$this->set('information', $information);
		$this->set('comments', $comments);
		$this->set('paid', $paid);
		$this->set('type', $type);
		$this->set('clicked', $clicked);
	}
	
	
	/**
	 * 
	 * 会员待确认信息
	 */
	public function confirmlist($type)
	{
	    $this->set('title_for_layout', "待确认交易");
		if (!isset($type) || ($type != "need" && $type != "has")) {
			//TODO error
			return 0;
		}
		if ($type == "has") {
		    $this->set("msg", "没有待确认交易信息");
		} else {
		    $this->set("msg", "没有待确认悬赏信息");
		}
		
		$fields = array(
			'PaymentTransaction.payment_type',
			'PaymentTransaction.number',
			'PaymentTransaction.information_id',
            'Information.title',
            'Information.provincial',
            'Information.city',
		    'Information.payment_type',
		    'Information.price',
		    'Information.point',
		    'Information.status',
            'Member.id',
            'Member.nickname',
            'PaymentTransaction.payment_type',
            'PaymentTransaction.number',
            'PaymentTransaction.status',
            'PaymentTransaction.created'
		);
		$joinInformation = array(
			'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = PaymentTransaction.information_id'
		);
		if ($type == "has") {
    		$conditions = array(
    			'PaymentTransaction.author_members_id' => $this->_memberInfo['Member']['id'],
    			'PaymentTransaction.status' => Configure::read('Information.status_flg.transaction')
    		);
    		$joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'PaymentTransaction.members_id = Member.id'
            );
		} else {
                $conditions = array(
                'PaymentTransaction.members_id' => $this->_memberInfo['Member']['id'],
                'PaymentTransaction.status' => Configure::read('Information.status_flg.transaction')
            );
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'PaymentTransaction.author_members_id = Member.id'
            );
		}
		$pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 10;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'PaymentTransaction' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('PaymentTransaction.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinInformation, $joinMember)
            )
        );
        $this->set('info_type', $type);
        $this->set('pageSize', $pageSize);
        $this->set("informations", $this->paginate('PaymentTransaction'));
        $this->set("type", "receive");
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/cinfirm_paginator');
        }
	}
	
	/**
	 * 
	 * 会员待确认信息详细
	 * @param int $id
	 */
	public function confirmdetail()
	{
	    $this->set('title_for_layout', "待确认详细");
	    $query = $this->request->query;
	    
        if ((!isset($query['has']) && !$query['need']) || (isset($query['has']) && isset($query['need']))){
            //TODO error 
            $this->_sysDisplayErrorMsg("没有你要确认的信息！");
            return 0;
        }
        $id = '';
        if (isset($query['has']) && !empty($query['has'])) {
            $id = $query['has'];
            $type = "has";
        }
        if (isset($query['need']) && !empty($query['need'])) {
            $id = $query['need'];
            $type = "need";
        }
        
        if (!isset($query['mid']) || empty($query['mid'])) {
            //TODO
            $this->_sysDisplayErrorMsg("没有你要确认的信息！");
            return 0;
        }
        
        if (empty($id)) {
            //TODO
            $this->_sysDisplayErrorMsg("没有你要确认的信息！");
            return 0;
        }
        //客源的基本信息
        $params = array(
            'conditions' => array('id' => $id)
        );
        $information = $this->Information->find('first', $params);
        
        if ($type == "need") {//我购买别人的客源
            $params = array(
                'conditions' => array('information_id' => $id, 'members_id'  => $this->_memberInfo['Member']['id'], 'author_members_id' => $query['mid'])
            );
            $paymentTransaction = $this->PaymentTransaction->find('first', $params);
            if (empty($paymentTransaction)){
                //TODO error 
                $this->_sysDisplayErrorMsg("没有你要确认的信息！");
                return 0;
            }
            //发布者
            $params = array(
                'conditions' => array('id' => $information['Information']['members_id'])
            );
            $author = $this->Member->find('first', $params);
            $this->set('author', $author);
            $this->set('seller_type', "卖家");
        } else {//自己发布的客源，被别人购买
            $params = array(
                'conditions' => array('information_id' => $id, 'author_members_id'  => $this->_memberInfo['Member']['id'], 'members_id' => $query['mid']),
            );
            $paymentTransaction = $this->PaymentTransaction->find('first', $params);
            if (empty($paymentTransaction)){
                //TODO error 
                $this->_sysDisplayErrorMsg("没有你要确认的信息！");
                return 0;
            }
            $params = array(
                'conditions' => array('id' => $query['mid'])
            );
            $author = $this->Member->find('first', $params);
            $this->set('author', $author);
            $this->set('seller_type', "买家");
        }
        
        //客源的联系人相关信息
        $params = array(
                'conditions' => array('information_id' => $id)
        );
        $attributes = $this->InformationAttribute->find('all', $params);
        
        
        $conditions = array(
            'members_id' => $author['Member']['id']
        );
        $transaction_has_num = $this->PaymentHistory->find('count', array('conditions' => $conditions));
        $conditions = array(
            'author_members_id' => $author['Member']['id']
        );
        $transaction_need_num = $this->PaymentHistory->find('count', array('conditions' => $conditions));
        
        //投诉
        $params = array(
        	'conditions' => array('members_id' => $this->_memberInfo['Member']['id'], 'information_id' => $id)
        );
        $complainted = $this->InformationComplaint->find('count', $params);
        $this->set('complainted', $complainted > 0 ? true : false);
        
        //站内信
        $joinMembers = array(
        	'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'InformationComment.members_id = Member.id'
        );
        $params = array(
             'fields' => array('InformationComment.id', 'InformationComment.members_id', 'InformationComment.content', 'InformationComment.created' , 'Member.nickname'),
             'conditions' => array('information_id' => $id, "OR" => array('members_id' => $this->_memberInfo['Member']['id'], 'members_id' => $author['Member']['id'])),
        	 'joins' => array($joinMembers)
        );
        
        $comments = array();
        $comments = $this->InformationComment->find('all', $params);
        
        $this->set('info_type', $type);
        $this->set('information', $information);
        $this->set('attributes', $attributes);
        $this->set('comments', $comments);
        $this->set('memberInfo', $this->_memberInfo);
        $this->set('transaction_has_num', $transaction_has_num);
        $this->set('transaction_need_num', $transaction_need_num);
        $this->set('paymentTransaction', $paymentTransaction);
	}
	
	/**
	 * 
	 * 围绕着信息的站内信
	 */
	public function comment()
	{
	   $this->autoRender = false;
	   if (!$this->RequestHandler->isAjax()) {
	       return 0;
	   }
	   
	   $data = array(
	       'members_id' => $this->_memberInfo['Member']['id'],
	       'information_id' => $this->request->data['information_id'],
	       'target_members_id' => $this->request->data['target_members_id'],
	       'content' => $this->request->data['content']
	   );
	   if ($this->InformationComment->save($data)) {
	       $result = array(
		       'result' => 'OK', 
		       'author' => ($this->request->data['members_id'] == $this->_memberInfo['Member']['id']), 
//		       'name' => $this->_memberInfo['Member']['nickname'],
               'name' => "我",
	       	   'time' => date('Y-m-d H:i:s', time())
	       );
	   } else {
	       $result = array('result' => 'NG');
	   }
//	   $result = array();
	   $this->_sendJson($result);
	}
	
	/**
	 * 
	 * 针对某条信息的投诉
	 */
	public function complaint()
	{
	   $this->autoRender = false;
	   if (!$this->RequestHandler->isAjax()) {
           return 0;
       }
       $data = array(
            'members_id' => $this->_memberInfo['Member']['id'],
            'information_id' => $this->request->data['information_id'],
            'target_members_id'     => $this->request->data['target_members_id'],
            'reason' => $this->request->data['content']
       );
       if ($this->InformationComplaint->complaint($data)) {
            $result = array('result' => 'OK');
       } else {
            $result = array('result' => 'NG');
       }
       $this->_sendJson($result);
	}
	
	/**
	 * 
	 * 收到的悬赏，收到的客源
	 * @param $type
	 */
	public function received($type)
	{
	   if (!isset($type)) {
	       //TODO
	   }
	   $fields = array(
            'Information.id',
            'Information.title',
            'Information.profit',
            'Information.provincial',
            'Information.city',
            'Information.status',
            'Information.clicked'
        );
        $joinInformation = array(
            'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = MemberReceived.information_id'
        );
        $members_id = $this->_memberInfo['Member']['id'];
        $conditions = array('MemberReceived.members_id' => $members_id);
        if ($type == 'has'){
           $conditions['MemberReceived.type'] = 0;
        } else {
           $conditions['MemberReceived.type'] = 1;
        }
        
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 2;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        $this->paginate = array(
            'MemberReceived' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('MemberReceived.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinInformation)
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("informations", $this->paginate('MemberReceived'));
        $this->set("type", "receive");
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/paginator');
        }

	}
	/**
	 * 
	 * 交易完成
	 */
	public function close()
	{
		$this->autoRender = false;
		if (!$this->RequestHandler->isAjax()) {
			return 0;
		}
		$params = array(
            'fields' => array('members_id'),
        	'conditions' => array('id' => $this->request->data['information_id'])
        );
		$information = $this->Information->find('first', $params);
		$params = array(
        	'conditions' => array('information_id' => $this->request->data['information_id'], 'members_id' => $this->_memberInfo['Member']['id'])
        );
		$transactions = $this->PaymentTransaction->find('first', $params);
		$data = array(
			'members_id' => $this->_memberInfo['Member']['id'],
            'author_members_id' => $information['Information']['members_id'],
			'information_id' => $this->request->data['information_id'],
			'type'	 => $transactions['PaymentTransaction']['type'],
			'payment_type'	 => $transactions['PaymentTransaction']['payment_type'],
			'number' => $transactions['PaymentTransaction']['number']
		);
		if ($this->Payment->completeTrade($data)) {
			$result = array('result' => 'OK');
		} else {
			$result = array('result' => 'NG');
		}
		$this->_sendJson($result);
	}
	
	/**
	 * 
	 * 已交易，一览
	 * @param int $id
	 */
	public function closelist($type)
	{
	    if (!isset($type) || ($type != "need" && $type != "has")) {
			//TODO error
			return 0;
		}
		if ($type == "has") {
//		    $type = 0;
		    $conditions = array(
                'PaymentHistory.author_members_id' => $this->_memberInfo['Member']['id'],
//                'PaymentHistory.type' => $type,
            );
//            $this->set('type', $type);
		    $this->set("msg", "没有待确认交易信息");
		} else {
//		    $type = 1;
		    $conditions = array(
                'PaymentHistory.members_id' => $this->_memberInfo['Member']['id'],
//                'PaymentHistory.type' => $type,
            );
//            $this->set('type', $type);
		    $this->set("msg", "没有待确认悬赏信息");
		}
		$this->set('info_type', $type);
	    $fields = array(
			'PaymentHistory.payment_type',
			'PaymentHistory.number',
			'PaymentHistory.information_id',
            'Information.title',
            'Information.provincial',
            'Information.city',
	        'Information.payment_type',
	        'Information.price',
	        'Information.point',
	        'Information.payment_type',
	        'Information.price',
	        'Information.point',
	        'Information.status',
            'Member.nickname',
            'PaymentHistory.created'
            
		);
		$joinInformation = array(
			'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = PaymentHistory.information_id'
		);
		$joinMember = array(
			'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'Information.members_id = Member.id'
		);
		
//		$conditions = array(
//			'PaymentHistory.members_id' => $this->_memberInfo['Member']['id'],
//			'PaymentHistory.type' => $type,
//		);
		$pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 2;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'PaymentHistory' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('PaymentHistory.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinInformation, $joinMember)
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("informations", $this->paginate('PaymentHistory'));
        $this->set("type", "receive");
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/confirm_paginator');
        }
	}
	/**
	 * 
	 * 已交易，详细
	 * @param int $id
	 */
	public function closedetail()
	{
	    $this->set('title_for_layout', "交易完成详细");
        $query = $this->request->query;
        $myself = false;
        if ((!isset($query['has']) && !$query['need']) || (isset($query['has']) && isset($query['need']))){
            //TODO error 
            return 0;
        }
        $id = '';
        if (isset($query['has']) && !empty($query['has'])) {
            $id = $query['has'];
            $type = "has";
        }
        if (isset($query['need']) && !empty($query['need'])) {
            $id = $query['need'];
            $type = "need";
        }
        if (empty($id)) {
            //TODO
            return 0;
        }
        //客源的基本信息
        $params = array(
            'conditions' => array('id' => $id)
        );
        $information = $this->Information->find('first', $params);
        $params = array(
                'conditions' => array('information_id' => $id)
        );
        $attributes = $this->InformationAttribute->find('all', $params);
        if ($type == "need") {//我购买别人的客源
            $params = array(
                'conditions' => array('information_id' => $id, 'members_id'  => $this->_memberInfo['Member']['id'])
            );
            $history = $this->PaymentHistory->find('first', $params);
            if (empty($history)){
                //TODO error 
                $this->_sysDisplayErrorMsg("没有你要确认的信息！");
                return 0;
            }
            //发布者
            $params = array(
                'conditions' => array('id' => $information['Information']['members_id'])
            );
            $author = $this->Member->find('first', $params);
            $this->set('author', $author);
            $this->set('seller_type', "卖家");
        } else {//自己发布的客源，被别人购买
            $params = array(
                'conditions' => array('information_id' => $id, 'author_members_id'  => $this->_memberInfo['Member']['id'])
            );
            $history = $this->PaymentHistory->find('first', $params);
            if (empty($history)){
                //TODO error 
                $this->_sysDisplayErrorMsg("没有你要确认的信息！");
                return 0;
            }
            $params = array(
                'conditions' => array('id' => $history['PaymentHistory']['members_id'])
            );
            $buyersInfo = $this->Member->find('first', $params);
            $author = $buyersInfo;
            $this->set('author', $author);
            $this->set('seller_type', "买家");
            $myself = true;
        }
        
        $conditions = array(
            'members_id' => $author['Member']['id']
        );
        $transaction_has_num = $this->PaymentHistory->find('count', array('conditions' => $conditions));
        $conditions = array(
            'author_members_id' => $author['Member']['id']
        );
        $transaction_need_num = $this->PaymentHistory->find('count', array('conditions' => $conditions));
        /*
        //投诉
        $params = array(
            'conditions' => array('members_id' => $this->_memberInfo['Member']['id'], 'information_id' => $id)
        );
        $complainted = $this->InformationComplaint->find('count', $params);
        $this->set('complainted', $complainted > 0 ? true : false);
        
        //站内信
        $joinMembers = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'InformationComment.members_id = Member.id'
        );
        $params = array(
             'fields' => array('InformationComment.id', 'InformationComment.members_id', 'InformationComment.content', 'InformationComment.created' , 'Member.nickname'),
             'conditions' => array('information_id' => $id, "OR" => array('members_id' => $this->_memberInfo['Member']['id'], 'members_id' => $author['Member']['id'])),
             'joins' => array($joinMembers)
        );
        
        $comments = array();
        $comments = $this->InformationComment->find('all', $params);
        */
        $this->set('type', $type);
        $this->set('information', $information);
        $this->set('attributes', $attributes);
        $this->set('myself', $myself);
        $this->set('history', $history);
//        $this->set('comments', $comments);
//        $this->set('memberInfo', $this->_memberInfo);
        $this->set('transaction_has_num', $transaction_has_num);
        $this->set('transaction_need_num', $transaction_need_num);
	}
	
	/**
	 * 
	 * 我有客源，我要客源
	 * 我发布的
	 * @param string $type
	 */
	public function issue($type)
	{
        $member_id = $this->_memberInfo['Member']['id'];
        $conditions = array('members_id' => $member_id);
        if (isset($type)) {
            if ($type == 'has'){
               $conditions['type'] = 0;
               $this->set('title_for_layout', "客源列表");
               $this->set('naviText', "客源列表");
            } else {
               $conditions['type'] = 1;
               $this->set('title_for_layout', "悬赏列表");
               $this->set('naviText', "悬赏列表");
            }
        } else {
            $this->set('paramError', true);
        }
        $conditions['status'] = Configure::read('Information.status_flg.active');
        $fields = array(
            'id',
            'title',
            'profit',
            'provincial',
            'city',
            'category',
            'sub_category',
            'payment_type',
            'price',
            'point',
            'status',
            'clicked'
            
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 2;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        $this->paginate = array(
            'limit' => $pageSize,
            'page'  => $page,
            'order' => array('Information.created' => 'DESC', 'Information.id' => 'ASC'),
            'conditions' => $conditions,
            'fields' => $fields
        );
        $this->set('pageSize', $pageSize);
        $this->set("informations", $this->paginate('Information'));
        $this->set("type", "myself");
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/paginator');
        }
	}

	
	public function search($type)
	{
	    
	   if (isset($type)) {
            if ($type == 'has'){
               $type = 0;
               $this->set("type", "has");
               $this->set('title_for_layout', "所有客源");
            } else {
               $type = 1;
               $this->set("type", "need");
               $this->set('title_for_layout', "所有悬赏");
            }
        } else {
            $this->set('paramError', true);
        }
        $js = array(
	        'jquery-ui',
	        'retrieavl'
	    );
	    $css = array('ui/jquery-ui');
	    $this->_appendCss($css);
	    $this->_appendJs($js);
	    
//        $conditions['members_id !='] = $this->_memberInfo['Member']['id'];
        $fields = array(
            'DISTINCT(Information.id)',
        	'Information.members_id',
            'Information.title',
            'Information.category',
            'Information.sub_category',
            'Information.provincial',
            'Information.city',
            'Information.payment_type',
            'Information.price',
            'Information.point',
            'Information.status',
            'Information.clicked'
        );
        
        $joinHistory = array(
            'table' => 'payment_histories',
            'alias' => 'History',
            'type'  => 'left',
            'conditions' => 'History.information_id = Information.id'
        );
        $joinTransaction = array(
            'table' => 'payment_transactions',
            'alias' => 'Transaction',
            'type'  => 'left',
            'conditions' => 'Transaction.information_id = Information.id'
        );
        
        $conditions = array(
            'Information.members_id !=' => $this->_memberInfo['Member']['id'],
            'Information.type'  => $type,
            'Information.status <= ' => Configure::read('Information.status_flg.transaction'),
            "OR" => array(
                'Transaction.members_id !=' => $this->_memberInfo['Member']['id'],
                'Transaction.members_id is null'
            )
        );
        
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 2;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        $this->paginate = array(
            'limit' => $pageSize,
            'page'  => $page,
            'order' => array('Information.created' => 'DESC', 'Information.id' => 'ASC'),
            'conditions' => $conditions,
            'fields' => $fields,
            'joins' => array($joinTransaction),
            'group' => array('Information.id')
        );
        $this->set('pageSize', $pageSize);
        $this->set("informations", $this->paginate('Information'));
        $this->Information->printLog();
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/search_paginator');
        }
	}
	
	public function invalid($type)
	{
	    $this->set('title_for_layout', "无效交易");
		if (!isset($type) || ($type != "need" && $type != "has")) {
			//TODO error
			return 0;
		}
		if ($type == "has") {
		    $this->set("msg", "没有待确认交易信息");
		} else {
		    $this->set("msg", "没有待确认悬赏信息");
		}
		
		$fields = array(
			'PaymentTransaction.payment_type',
			'PaymentTransaction.number',
			'PaymentTransaction.information_id',
            'Information.title',
            'Information.provincial',
            'Information.city',
		    'Information.payment_type',
		    'Information.price',
		    'Information.point',
		    'Information.status',
            'Member.id',
            'Member.nickname',
            'PaymentTransaction.payment_type',
            'PaymentTransaction.number',
            'PaymentTransaction.status',
            'PaymentTransaction.created'
		);
		$joinInformation = array(
			'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = PaymentTransaction.information_id'
		);
		if ($type == "has") {
    		$conditions = array(
    			'PaymentTransaction.author_members_id' => $this->_memberInfo['Member']['id'],
    			'PaymentTransaction.status' => Configure::read('Information.status_flg.agree')
    		);
    		$joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'PaymentTransaction.members_id = Member.id'
            );
		} else {
                $conditions = array(
                'PaymentTransaction.members_id' => $this->_memberInfo['Member']['id'],
                'PaymentTransaction.status' => Configure::read('Information.status_flg.agree')
            );
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'PaymentTransaction.author_members_id = Member.id'
            );
		}
		$pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 10;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'PaymentTransaction' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('PaymentTransaction.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinInformation, $joinMember)
            )
        );
        $this->set('info_type', $type);
        $this->set('pageSize', $pageSize);
        $this->set("informations", $this->paginate('PaymentTransaction'));
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/invalid_paginator');
        }
	}
	
	/**
	 * 
	 * get city list by ajax
	 */
	public function getCityList($parent)
	{
	   $cityList = $this->City->getCityList($parent);
	   $this->_sendJson($cityList);
	}
	
	public function getCategoryList($parent)
	{
		$categoryList = $this->Category->getSubCategoryList($parent);
		$this->_sendJson($categoryList);
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