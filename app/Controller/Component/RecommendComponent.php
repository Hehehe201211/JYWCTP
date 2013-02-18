<?php
/**
 * 
 * 针对会员的一些推荐信息
 * @author deping_lin
 *
 */
class RecommendComponent extends Component
{
    var $name = 'Recommend';
    
    /**
     * 
     * 推荐简历
     */
    public function resume()
    {
        
    }
    /**
     * 
     * 推荐兼职
     */
    public function parttime($members_id, $category_id)
    {
        $mPartTime = ClassRegistry::init('PartTime');
        $conditions = array(
            'status'    => 1,
            'category'  => $category_id
        );
        $conditionsSubQuery['sender'] = $members_id;
        $db = $mPartTime->getDataSource();
        $subQuery = $db->buildStatement(
            array(
                'fields'     => array('part_times_id'),
                'table'      => 'cooperations',
                'alias'      => 'Cooperation',
                'limit'      => null,
                'offset'     => null,
                'joins'      => array(),
                'conditions' => $conditionsSubQuery,
                'order'      => null,
                'group'      => null
            ),
            $mPartTime
        );
        $subQuery = 'PartTime.id NOT IN (' . $subQuery . ')';
        $subQueryExpression = $db->expression($subQuery);
        $conditions[] = $subQueryExpression;
        
        $params = array(
            'fields'        => array('PartTime.id', 'PartTime.title', 'PartTime.area', 'PartTime.method', 'PartTime.pay', 'PartTime.pay_rate', 'PartTime.pay_method', 'PartTime.category'),
            'conditions'    => $conditions,
            'limit'         => 5,
            'order'         => array('created DESC')
        );
        $recommendParttimes = $mPartTime->find('all', $params);
        $this->controller->set('recommendParttimes', $recommendParttimes);
    }
    
    public function newParttime()
    {
        $mPartTime = ClassRegistry::init('PartTime');
        $conditions = array(
            'status'    => 1
        );
        $joinAttribute = array(
            'table' => 'company_attributes',
            'alias' => 'CompanyAttribute',
            'type'  => 'inner',
            'conditions' => 'CompanyAttribute.members_id = PartTime.members_id'
        );
        $fields = array(
            'PartTime.id', 
            'PartTime.title', 
            'PartTime.sub_title', 
            'PartTime.area', 
            'PartTime.method', 
            'PartTime.pay', 
            'PartTime.pay_rate', 
            'PartTime.pay_method', 
            'PartTime.category',
            'CompanyAttribute.thumbnail'
        );
        $params = array(
            'conditions' => $conditions,
            'fields'     => $fields,
            'order'      => array('PartTime.created DESC'),
            'group'      => 'PartTime.members_id',
            'limit'      => 10,
            'joins'      => array($joinAttribute)
        );
        $parttimes = $mPartTime->find('all', $params);
        $this->controller->set('recommend_parttimes', $parttimes);
    }
    
    public function newFulltime()
    {
        $mFulltime = ClassRegistry::init('Fulltime');
        $conditions = array(
            'status'    => 1
        );
        $joinAttribute = array(
            'table' => 'company_attributes',
            'alias' => 'CompanyAttribute',
            'type'  => 'inner',
            'conditions' => 'CompanyAttribute.members_id = Fulltime.members_id'
        );
        $fields = array(
            'Fulltime.id', 
            'Fulltime.title', 
            'Fulltime.post', 
            'Fulltime.type', 
            'Fulltime.salary', 
            'Fulltime.require', 
            'CompanyAttribute.thumbnail'
        );
        $params = array(
            'conditions' => $conditions,
            'fields'     => $fields,
            'order'      => array('Fulltime.created DESC'),
            'group'      => 'Fulltime.members_id',
            'limit'      => 10,
            'joins'      => array($joinAttribute)
        );
        $fulltimes = $mFulltime->find('all', $params);
        $this->controller->set('recommend_fulltimes', $fulltimes);
    }
    
    public function newInformation($type = 0)
    {
        $mInformation = ClassRegistry::init('Information');
        $conditions = array(
            'type'      => $type,
            'status'    => 1,
            'display'   => 1,
        );
        $fields = array(
            'Information.id', 
            'Information.title', 
            'Information.provincial', 
            'Information.city', 
            'Information.category', 
            'Information.sub_category', 
            'Information.created', 
        );
        $params = array(
            'conditions' => $conditions,
            'fields'     => $fields,
            'order'      => array('Information.created DESC'),
            'group'      => 'Information.members_id',
            'limit'      => 10,
        );
        $newInformations = $mInformation->find('all', $params);
        $this->controller->set('newInformations', $newInformations);
    }
    
    public function newCompany()
    {
        $mCompany = ClassRegistry::init('CompanyAttribute');
        $joinHomepage = array(
            'table' => 'homepages',
            'alias' => 'Homepage',
            'type'  => 'inner',
            'conditions' => 'CompanyAttribute.members_id = Homepage.members_id'
        );
        $params = array(
            'fields'=> array('CompanyAttribute.members_id', 'CompanyAttribute.thumbnail', 'CompanyAttribute.full_name', 'CompanyAttribute.business_scope', 'Homepage.domain'),
            'order' => array('CompanyAttribute.created DESC'),
            'limit' => 5,
            'joins' => array($joinHomepage)
        );
        $newCompanies = $mCompany->find('all', $params);
        $this->controller->set('newCompanies', $newCompanies);
    }
    /**
     * 
     * 会员收到的客源，悬赏的信息数
     * @param array $conditions
     */
    public function receivedCount($conditions = array())
    {
        $mInformation = ClassRegistry::init('MemberReceived');
        $count = $mInformation->find('count', array('conditions' => $conditions));
        return $count;
    }
    /**
     * 
     * 没有查看的交易中信息
     * @param array $conditions
     */
    public function confirmCount($conditions = array())
    {
        $mTransaction = ClassRegistry::init('PaymentTransaction');
        $count = $mTransaction->find('count', array('conditions' => $conditions));
        return $count;
    }
    
    /**
     * 
     * 个人会员面试邀请。
     * @param array $conditions
     */
    public function auditionCount($conditions)
    {
        $mAudition = ClassRegistry::init('Audition');
        $count = $mAudition->find('count', array('conditions' => $conditions));
        return $count;
    }
    /**
     * 
     * 个人会员兼职邀请
     * @param array $conditions
     */
    public function invitationCount($conditions)
    {
        $mInvitation = ClassRegistry::init('Invitation');
        $count = $mInvitation->find('count', array('conditions' => $conditions));
        return $count;
    }
    /**
     * 
     * 合作中的兼职
     * @param array $conditions
     */
    public function cooperationCount($conditions)
    {
        $mCooperation = ClassRegistry::init('Cooperation');
        $count = $mCooperation->find('count', array('conditions' => $conditions));
        return $count;
        
    }
    /**
     * 
     * 企业会员收到的简历
     * @param array $conditions
     */
    public function auditionsReceiveCount($conditions)
    {
        
    }
    
    public function PersonNoticeCount($members_id)
    {
        //收到的悬赏，收到的客源。
                $conditions = array(
                    'members_id' => $members_id,
                    'status'     => 1
                );
                $receiveHas = $this->receivedCount($conditions);
                $this->controller->set('receiveHas', $receiveHas);
                
                //交易中的信息数
                $conditions = array(
                    'author_members_id' => $members_id,
                    'status'     => array(
                        Configure::read('Transaction.status_code.transaction'), 
                        Configure::read('Transaction.status_code.complaint'),
                        Configure::read('Transaction.status_code.appeal')
                    ),
                    'send_readed'     => 0
                );
                $confirmHas = $this->confirmCount($conditions);
                $this->controller->set('confirmHas', $confirmHas);
                $conditions = array(
                    'members_id' => $members_id,
                    'status'     => array(
                        Configure::read('Transaction.status_code.transaction'), 
                        Configure::read('Transaction.status_code.complaint'),
                        Configure::read('Transaction.status_code.appeal')
                    ),
                    'receive_readed'     => 0
                );
                $confirmNeed = $this->confirmCount($conditions);
                $this->controller->set('confirmNeed', $confirmNeed);
                
                //面试邀请
                $conditions = array(
                    'sender'      => $members_id,
                    'status'        => Configure::read('Audition.status_accept'),
                    'sender_delete' => 0,
                    'send_readed'        => 0
                );
                $auditionSend = $this->auditionCount($conditions);
                $this->controller->set('auditionSend', $auditionSend);
                
                //兼职收到的邀请
                $conditions = array(
                    'receiver'  => $members_id,
                    'status'    => 1,
                    'receive_readed' => 0
                );
                $parttimeReceiveInvitation = $this->invitationCount($conditions);
                $this->controller->set('parttimeReceiveInvitation', $parttimeReceiveInvitation);
                //合作中的兼职
                $conditions = array(
                    'sender'    => $members_id,
                    'status'    => $status = array(2, 5, 6, 8),
                    'send_readed' => 0
                );
                $cooperationCount = $this->cooperationCount($conditions);
                $this->controller->set('cooperationCount', $cooperationCount);
    }
    
    public function CompanyNoticeCount($members_id)
    {
        //面试简历
        $conditions = array(
            'receiver'      => $members_id,
            'status'        => Configure::read('Audition.status_active'),
            'sender_delete' => 0,
            'receive_readed'   => 0
        );
        $resumeReceive = $this->auditionCount($conditions);
        $this->controller->set('resumeReceive', $resumeReceive);
        //收到的合作
        $conditions = array(
            'Cooperation.receiver' => $members_id,
            'Cooperation.status' => array(1),
            'receive_readed'    => 0
        );
        $receiveCooperationCount = $this->cooperationCount($conditions);
        $this->controller->set('receiveCooperationCount', $receiveCooperationCount);
        
        //被投诉的合作
        $conditions = array(
            'Cooperation.receiver' => $members_id,
            'Cooperation.status' => array(Configure::read('Cooperation.status.complaint')),
            'receive_readed'    => 0
        );
        $complaintCooperationCount = $this->cooperationCount($conditions);
        $this->controller->set('complaintCooperationCount', $complaintCooperationCount);
        
        
        //合作中的兼职
//        $conditions = array(
//            'receiver'    => $members_id,
//            'status'    => $status = array(2, 5, 6, 8),
//            'receive_readed' => 0
//        );
//        $cooperationCount = $this->cooperationCount($conditions);
//        $this->controller->set('cooperationCount', $cooperationCount);
    }
    /**
     * 
     * 个人会员收到的站内信条数
     * @param int $members_id
     */
    public function stationMessageCount($members_id)
    {
        $constions = array(
            'receiver' => $members_id,
            'status'    => 1
        );
        $mStationMessage = ClassRegistry::init('StationMessage');
        $countStationMessage = $mStationMessage->find('count', array('conditions' => $constions));
        $this->controller->set('countStationMessage', $countStationMessage);
    }
    
    /**
     * 
     * 企业会员发布职位信息数
     * @param int $members_id
     */
    public function fulltimeCount($members_id)
    {
        $mFulltime = ClassRegistry::init('Fulltime');
        $conditions = array('members_id' => $members_id, 'delete_flg' => 0);
        $fulltimeCount = $mFulltime->find('count', array('conditions' => $conditions));
        $this->controller->set('fulltimeCount', $fulltimeCount);
    }
    /**
     * 
     * 企业会员发布兼职信息数
     * @param int $members_id
     */
    public function parttimeCount($members_id)
    {
        $mPartTime = ClassRegistry::init('PartTime');
        $conditions = array('members_id' => $members_id, 'status' => 1);
        $parttimeCount = $mPartTime->find('count', array('conditions' => $conditions));
        $this->controller->set('parttimeCount', $parttimeCount);
    }
    /**
     * 
     * 企业会员收到简历数
     * @param int $members_id
     */
    public function receiveResumeCount($members_id)
    {
        $mAudition = ClassRegistry::init('Audition');
        $conditions = array(
            'receiver'  => $members_id,
            'status' => Configure::read('Audition.status_active'),
            'receiver_delete' => 0,
        );
        $receiveResumeCount = $mAudition->find('count', array('conditions' => $conditions));
        $this->controller->set('receiveResumeCount', $receiveResumeCount);
    }
    /**
     * 
     * 企业会员收到兼职合作数
     * @param int $members_id
     */
    public function receiveCooperationsCount($members_id)
    {
        $mCooperation = ClassRegistry::init('Cooperation');
        $conditions = array(
            'Cooperation.receiver' => $members_id,
            'Cooperation.status' => array(1)
        );
        $receiveCooperationsCount = $mCooperation->find('count', array('conditions' => $conditions));
        $this->controller->set('receiveCooperationsCount', $receiveCooperationsCount);
    }
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}