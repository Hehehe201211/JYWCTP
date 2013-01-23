<?php
/**
 * 
 * 客源交易组件
 * @author deping_lin
 *
 */
class InfoComponent extends Component
{
    var $name = 'Info';
    /**
     * 
     * 交易中的各个状态
     * @param int $members_id
     * @param string $type
     * @param int $status
     */
    public function transaction($members_id, $type = 'has', $status = 2)
    {
        if ($type == 'has') {//我有客源的各个状态
            $conditions = array(
                'PaymentTransaction.author_members_id' => $members_id,
                'PaymentTransaction.status'			=> $status
            );
            $joinMember = array(
                'table' => 'members',
	    		'alias' => 'Member',
	    		'type'  => 'inner',
	    		'conditions' => 'PaymentTransaction.members_id = Member.id'
            );
        } else {//我要客源的各个状态
            $conditions = array(
                'PaymentTransaction.members_id' => $members_id,
                'PaymentTransaction.status'	 => $status	
            );
            $joinMember = array(
                'table' => 'members',
	    		'alias' => 'Member',
	    		'type'  => 'inner',
	    		'conditions' => 'PaymentTransaction.author_members_id = Member.id'
            );
        }
        $joinInformation = array(
			'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = PaymentTransaction.information_id'
		);
        $fields = array(
        	'Member.*', 
        	'PaymentTransaction.*', 
        	'Information.title', 
        	'Information.provincial', 
        	'Information.city', 
        	'Information.id'
        );
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'PaymentTransaction' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('PaymentTransaction.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinMember, $joinInformation)
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("informations", $this->controller->paginate('PaymentTransaction'));
    }
    /**
     * 
     * 客源信息，联系人信息的详细
     * @param int $information_id
     */
    public function detail($information_id)
    {
        $mInformation = ClassRegistry::init('Information');
        $baseInfo = $mInformation->find('first', array('conditions' => array('id' => $information_id)));
        if (empty($baseInfo)) {
            return 0;
        }
        $this->controller->set('information', $baseInfo);
        $this->information_attr($information_id);
        return $baseInfo;
    }
    /**
     * 
     * 交易信息详细
     * @param int $information_id
     * @param int $members_id
     * @param int $author_members_id
     */
    public function transactionDetail($params)
    {
        $mTransaction = ClassRegistry::init('PaymentTransaction');
        $transactionDetail = $mTransaction->find('first', array('conditions' =>$params));
        $this->controller->set('transaction', $transactionDetail);
        return $transactionDetail;
    }
    
    /**
     * 
     * 信息状态一览，已撤销和过期
     * @param int $members_id
     * @param string $type
     * @param int $status
     */
    public function information($members_id, $type = 'has', $status = 4)
    {
        if ($type == 'has') {
            $conditions = array(
                'members_id' => $members_id,
                'type'		 => 0,
                'status'	 => $status
            );
        } else {
            $conditions = array(
                'members_id' => $members_id,
                'type'		 => 1,
                'status'	 => $status
            );
        }
        $fields = array(
            'id',
            'title',
            'provincial',
            'city',
            'industries_id',
            'category',
            'sub_category',
            'price',
            'point',
            'payment_type',
            'status',
            'clicked'
        );
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'Information' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('Information.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("informations", $this->controller->paginate('Information'));
    }
    /**
     * 
     * 站内信
     * @param int $information_id
     * @param int $from_members_id
     * @param int $to_members_id
     */
    public function comments($information_id, $from_members_id, $to_members_id, $show = 1)
    {
        $conditions = array(
            'information_id' => $information_id,
            'show'           => $show,
            'OR' => array(
//                array('from_members_id' => $from_members_id, 'to_members_id' => $to_members_id),
//                array('from_members_id' => $to_members_id, 'to_members_id' => $from_members_id)
                array('members_id' => $from_members_id, 'target_members_id' => $to_members_id),
                array('members_id' => $to_members_id, 'target_members_id' => $from_members_id)
            )
        );
        $fields = array(
            'InformationComment.id',
            'InformationComment.information_id',
            'InformationComment.members_id',
            'InformationComment.target_members_id',
            'InformationComment.content',
            'InformationComment.created',
            'Member.nickname'
        );
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
//            'conditions' => 'InformationComment.from_members_id = Member.id'
            'conditions' => 'InformationComment.members_id = Member.id'
        );
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'InformationComment' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('InformationComment.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinMember)
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("comments", $this->controller->paginate('InformationComment'));
    }
    
    /**
     * 
     * 投诉
     * @param $information_id
     * @param $members_id
     */
    public function complaint($information_id, $members_id, $show = 1, $status = null)
    {
        if ($status !== null) {
            $conditions = array(
                'information_id' => $information_id,
                'members_id'     => $members_id,
                'show'           => $show,
                'status'         => $status
            );
        } else {
            $conditions = array(
                'information_id' => $information_id,
                'members_id'     => $members_id,
                'show'           => $show,
            );
        }
        $mComplaint = ClassRegistry::init('InformationComplaint');
        $complaint = $mComplaint->find('first', array('conditions' => $conditions));
        $this->controller->set('complaint', $complaint);
        return $complaint;
    }
    /**
     * 
     * 投诉回复
     * @param $complaint_id
     */
    public function answer($complaint_id)
    {
        $conditions = array(
            'information_complaints_id' => $complaint_id
        );
        $mAnswer = ClassRegistry::init('ComplaintAnswer');
        $answer = $mAnswer->find('first', array('conditions' => $conditions));
        $this->controller->set('answer', $answer);
    }
    /**
     * 
     * 客源信息的附加部分
     * 联系人，联系方式等
     * @param $information_id
     */
    public function information_attr($information_id)
    {
        $conditions = array(
            'information_id' => $information_id
        );
        $mAttribute = ClassRegistry::init('InformationAttribute');
        $attributes = $mAttribute->find('all', array('conditions' => $conditions));
        $this->controller->set('attributes', $attributes);
    }
    /**
     * 
     * 会员头部信息
     * @param unknown_type $members_id
     */
    public function baseMemberInfo($members_id)
    {
        $mHistory = ClassRegistry::init('PaymentHistory');
        $mMember = ClassRegistry::init('Member');
        $params = array(
                'conditions' => array('id' => $members_id)
            );
        $author = $mMember->find('first', $params);
        
        $conditions = array(
            'members_id' => $members_id,
            'io'		 => Configure::read('Payment.io.in'),
            'OR' => array(
                'payment_type' => Configure::read('Payment.type_normal_coin'),
                'payment_type' => Configure::read('Payment.type_normal_point'),
            )
        );
        $transaction_has_num = $mHistory->find('count', array('conditions' => $conditions));
        $conditions['io'] = Configure::read('Payment.io.out');
        $transaction_need_num = $mHistory->find('count', array('conditions' => $conditions));
        $this->controller->set('author', $author);
        $this->controller->set('transaction_has_num', $transaction_has_num);
        $this->controller->set('transaction_need_num', $transaction_need_num);
    }
    /**
     * 
     * 评价
     * @param array $conditions
     */
    public function appraisal($conditions)
    {
        $mAppraisal = ClassRegistry::init('Appraisal');
        $appraisal = $mAppraisal->find('first', array('conditions' => $conditions));
        $this->controller->set('appraisal', $appraisal);
        return $appraisal;
    }
    /**
     * 
     * 申诉
     * @param array $conditions
     */
    public function appeal($conditions)
    {
        $mAppeal = ClassRegistry::init('Appeal');
        $appeal = $mAppeal->find('first', array('conditions' => $conditions));
        if (!empty($appeal)) {
            $this->appealAnswer($appeal['Appeal']['id']);
            $this->controller->set('appeal', $appeal);
        }
    }
    
    /**
     * 
     * 平台回答申诉
     * @param int $appeal_id
     */
    public function appealAnswer($appeal_id)
    {
        $mAppealAnswer = ClassRegistry::init('AppealAnswer');
        $answerCon = array(
            'appeals_id' => $appeal_id
        );
        $answers = $mAppealAnswer->find('all', array('conditions' => $answerCon));
        $this->appealAnswerTemplate();
        $this->controller->set('answers', $answers);
    }
    /**
     * 
     * Enter description here ...
     */
    public function appealAnswerTemplate()
    {
        $mAppealAnswerTemplate = ClassRegistry::init('AppealAnswerTemplate');
        $templates = $mAppealAnswerTemplate->find('all');
        $this->controller->set('templates', $templates);
    }
    //首页导航的我有客源，和我要客源检索
    public function search($conditions = array())
    {
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
            'Information.clicked',
            'Member.nickname'
        );
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'Information.members_id = Member.id'
        );
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        if (!empty($conditions)) {
            $this->controller->paginate = array(
	            'limit' => $pageSize,
	            'page'  => $page,
	            'order' => array('Information.created' => 'DESC', 'Information.id' => 'ASC'),
	            'conditions' => $conditions,
	            'fields' => $fields,
                'joins' => array($joinMember),
	            'group' => array('Information.id')
	        );
        } else {
            $this->controller->paginate = array(
	            'limit' => $pageSize,
	            'page'  => $page,
	            'order' => array('Information.created' => 'DESC', 'Information.id' => 'ASC'),
	            'fields' => $fields,
                'joins' => array($joinMember),
	            'group' => array('Information.id')
            );
        }
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("informations", $this->controller->paginate('Information'));
    }
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}