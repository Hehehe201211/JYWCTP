<?php

class FundComponent extends Component
{
    var $name = "Fund";
//    var $uses = array(
//        'PaymentTransaction',
//        'PaymentHistory',
//        'MemberAttribute'
//    );
    var $componets = array('Paginator');
    /**
     * 
     * 余额
     */
    public function balance()
    {
        $mAttribute = ClassRegistry::init('MemberAttribute');
        $memberAttribute = $mAttribute->find('first', array('fields' => array('virtual_coin', 'point'), 'conditions' => array('members_id' => $this->controller->_memberInfo['Member']['id'])));
        $changeSession = false;
        if ($this->controller->_memberInfo['Attribute']['virtual_coin'] != $memberAttribute['MemberAttribute']['virtual_coin']) {
            $changeSession = true;
            $this->controller->_memberInfo['Attribute']['virtual_coin'] = $memberAttribute['MemberAttribute']['virtual_coin'];
        }
        if ($this->controller->_memberInfo['Attribute']['point'] != $memberAttribute['MemberAttribute']['point']) {
            $changeSession = true;
            $this->controller->_memberInfo['Attribute']['point'] = $memberAttribute['MemberAttribute']['point'];
        }
        if ($changeSession) {
            $this->controller->Session->write('memberInfo', $this->controller->_memberInfo);
        }
        return $memberAttribute;
    }
	/**
     * 
     * 充值
     */
    public function charge($type = "coin")
    {
        
    }
	/**
     * 
     * 收入
     */
    public function income($type = "coin")
    {
        if ($type == "coin") {
            $conditions = array(
            	'PaymentHistory.io' => Configure::read('Payment.io.in'),
                'PaymentHistory.members_id' => $this->controller->_memberInfo['Member']['id'],
                'OR' => array(
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_normal_coin')),
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_back_coin')),
                )
            );
        } else {
            $conditions = array(
            	'PaymentHistory.io' => Configure::read('Payment.io.in'),
                'PaymentHistory.members_id' => $this->controller->_memberInfo['Member']['id'],
                'OR' => array(
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_normal_point')),
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_back_point')),
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_appraisal_point')),
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_sns_point')),
                )
            );
        }
        $joinMember = array(
    		'table' => 'members',
    		'alias' => 'Member',
    		'type'  => 'left',
    		'conditions' => 'PaymentHistory.collaborator = Member.id'
	    );
	    $joinInformation = array(
			'table' => 'information',
            'alias' => 'Information',
            'type'  => 'left',
            'conditions' => 'Information.id = PaymentHistory.information_id'
		);
	    $fields = array('Member.*', 'PaymentHistory.*', 'Information.title');
	    $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : 10;
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'PaymentHistory' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('PaymentHistory.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinMember, $joinInformation)
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("informations", $this->controller->paginate('PaymentHistory'));
    }
    /**
     * 
     * 支出
     */
    public function expenses($type = "coin")
    {
        if ($type == "coin") {
            $conditions = array(
            	'PaymentHistory.io' => Configure::read('Payment.io.out'),
                'PaymentHistory.members_id' => $this->controller->_memberInfo['Member']['id'],
                'OR' => array(
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_normal_coin')),
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_back_coin')),
                )
            );
        } else {
            $conditions = array(
            	'PaymentHistory.io' => Configure::read('Payment.io.out'),
                'PaymentHistory.members_id' => $this->controller->_memberInfo['Member']['id'],
                'OR' => array(
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_normal_point')),
                    array('PaymentHistory.payment_type' => Configure::read('Payment.type_back_point')),
                )
            );
        }
        $joinMember = array(
    		'table' => 'members',
    		'alias' => 'Member',
    		'type'  => 'inner',
    		'conditions' => 'PaymentHistory.collaborator = Member.id'
	    );
	    $joinInformation = array(
			'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = PaymentHistory.information_id'
		);
	    $fields = array('Member.*', 'PaymentHistory.*', 'Information.title');
	    $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : 10;
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'PaymentHistory' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('PaymentHistory.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinMember, $joinInformation)
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("informations", $this->controller->paginate('PaymentHistory'));
    }
	/**
     * 
     * 提现
     */
    public function expend($type = "coin")
    {
        
    }
    
    public function detail($information_id, $type, $payment_type)
    {
        $mHistory = ClassRegistry::init('PaymentHistory');
        $mMember = ClassRegistry::init('Member');
        if ($type == "income") {
            $historyP = array(
                'collaborator' => $this->controller->_memberInfo['Member']['id'],
                'information_id'	=> $information_id,
                'payment_type'		=> $payment_type
            );
            if (isset($this->controller->request->data['members_id'])) {
                $historyP['members_id'] = $this->controller->request->data['members_id'];
            }
            $history = $mHistory->find('first', array('conditions' => $historyP));
            $conditions = array('id' => $history['PaymentHistory']['members_id']);
            $member = $mMember->find('first', array('fields' => array('nickname'), 'conditions' => $conditions));
        } else {
            $historyP = array(
                'members_id' => $this->controller->_memberInfo['Member']['id'],
                'information_id'	=> $information_id,
                'payment_type'		=> $payment_type,
            );
            $history = $mHistory->find('first', array('conditions' => $historyP));
            $conditions = array('id' => $history['PaymentHistory']['author_members_id']);
            $member = $mMember->find('first', array('fields' => array('nickname'), 'conditions' => $conditions));
        }
        if (empty($history)) {
            return true;
        }
        $transactionPa = array(
                'information_id' => $information_id,
                'members_id'	 => $history['PaymentHistory']['members_id'],
                'author_members_id' => $history['PaymentHistory']['collaborator']
            );
        $mInformation = ClassRegistry::init('Information');
        $mAttribute = ClassRegistry::init('InformationAttribute');
        $mTransaction = ClassRegistry::init('PaymentTransaction');
        $information = $mInformation->find('first', array('conditions' => array('id' => $information_id)));
        $attributes = $mAttribute->find('all', array('conditions' => array('information_id' => $information_id)));
        $transaction = $mTransaction->find('first', array('conditions' => $transactionPa));
        
        $this->controller->set('information', $information);
        $this->controller->set('attributes', $attributes);
        $this->controller->set('history', $history);
        $this->controller->set('member', $member);
        $this->controller->set('transaction', $transaction);
        return false;
    }
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}