<?php

class ParttimeComponent extends Component
{
    var $name = "Parttime";
    
    /**
     * 
     * Enter description here ...
     * @param unknown_type $members_id
     */
    public function partimeList($members_id, $sort="DESC")
    {
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $conditions = array('members_id' => $members_id);
        $fields = array(
            'id',
            'title',
            'category',
            'sub_category',
            'method',
            'created',
            'number',
            'sub_title',
            'area'
        );
        $this->controller->paginate = array(
            'PartTime' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('PartTime.created' => $sort),
                'conditions' => $conditions,
                'fields'    => $fields,
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("parttimes", $this->controller->paginate('PartTime'));
    }
    
    public function partimeListNeed($conditions = array())
    {
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $fields = array(
            'PartTime.id',
            'PartTime.category',
            'PartTime.sub_category',
            'PartTime.method',
            'PartTime.created',
            'PartTime.pay',
            'PartTime.pay_rate',
            'PartTime.additional',
            'Member.company_name'
        );
        $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'PartTime.members_id = Member.id'
            );
        if (!empty($conditions)){
	        $this->controller->paginate = array(
	            'PartTime' => array('limit' => $pageSize,
	                'page'  => $page,
	                'order' => array('PartTime.created' => 'DESC'),
	                'conditions' => $conditions,
	                'fields'    => $fields,
	                'joins' => array($joinMember)
	            )
        );
        } else {
                 $this->controller->paginate = array(
	            'PartTime' => array('limit' => $pageSize,
	                'page'  => $page,
	                'order' => array('PartTime.created' => 'DESC'),
	                'fields'    => $fields,
	                'joins' => array($joinMember)
	            )
	        );
        }
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("parttimes", $this->controller->paginate('PartTime'));
    }
    
    /**
     * 
     * Enter description here ...
     * @param int $id
     * @param int $members_id
     */
    public function parttimeDetail($id, $parttimeFields = 'PartTime.*', $members_id = null)
    {
        $mPartTime = ClassRegistry::init('PartTime');
        $conditions = array('PartTime.id' => $id);
        if (!empty($members_id)) {
            $conditions['PartTime.members_id'] = $members_id;
        }
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'PartTime.members_id = Member.id'
        );
        $params = array(
            'conditions' => $conditions,
            'fields'     => array($parttimeFields, 'Member.company_name', 'Member.id'),
            'joins'      => array($joinMember)
        );
        $parttime = $mPartTime->find('first', $params);
        $this->controller->set('parttime', $parttime);
        return $parttime;
    }
    /**
     * 
     * Enter description here ...
     * @param unknown_type $members_id
     * @param unknown_type $type
     */
    public function invitationList($members_id, $type = "send")
    {
        $joinParttime = array(
            'table' => 'part_times',
            'alias' => 'PartTime',
            'type'  => 'inner',
            'conditions' => 'Invitation.part_times_id = PartTime.id'
        );
        if ($type == "send") {
            $conditions = array(
                'sender' => $members_id
            );
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'Invitation.sender = Member.id'
            );
        } else {
            $conditions = array(
                'receiver' => $members_id
            );
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'Invitation.receiver = Member.id'
            );
        }
        $fields = array(
            'Member.nickname',
            'PartTime.title',
            'PartTime.category',
            'PartTime.sub_category',
            'PartTime.method',
            'Invitation.id',
            'Invitation.created',
        );
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'Invitation' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('Invitation.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinMember, $joinParttime)
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("invitations", $this->controller->paginate('Invitation'));
    }
    
    public function invitationDetail($id, $members_id, $type = "send")
    {
        if ($type == "send") {
            $conditions = array(
                'id' => $id,
                'sender' => $members_id
            );
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'Invitation.sender = Member.id'
            );
        } else {
            $conditions = array(
                'id' => $id,
                'receiver' => $members_id
            );
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'Invitation.receiver = Member.id'
            );
        }
        $joinParttime = array(
            'table' => 'part_times',
            'alias' => 'PartTime',
            'type'  => 'inner',
            'conditions' => 'Invitation.part_times_id = PartTime.id'
        );
        $fields = array(
            'Member.nickname',
            'PartTime.title',
            'PartTime.category',
            'PartTime.sub_category',
            'PartTime.method',
            'Invitation.id',
            'Invitation.created',
        );
        $params = array(
            'fields' => $fields,
            'conditons' => $conditions,
            'joins' => array($joinMember, $joinParttime)
        );
        $invitation = $mInvitation->find('first', $params);
    }
    
    /**
     * 
     * 兼职相关一览表
     * @param array $conditions
     * @param string $type
     */
    public function cooperationList($conditions, $type = 'send', $complaint = false, $sort = 'DESC')
    {
        $joinPartime = array(
            'table' => 'part_times',
            'alias' => 'PartTime',
            'type'  => 'inner',
            'conditions' => 'Cooperation.part_times_id = PartTime.id'
        );
        if ($type == 'send') {
            $joinMember = array(
                'table' => 'members',
	            'alias' => 'Member',
	            'type'  => 'inner',
	            'conditions' => 'Cooperation.receiver = Member.id'
            );
        } else {
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'Cooperation.sender = Member.id'
            );
        }
        $joinInformation = array(
                'table' => 'information',
                'alias' => 'Information',
                'type'  => 'inner',
                'conditions' => 'Cooperation.information_id = Information.id'
            );
        if ($complaint) {
            $joinComplaint = array(
                'table' => 'cooperation_complaints',
                'alias' => 'Complaint',
                'type'  => 'inner',
                'conditions' => 'Cooperation.id = Complaint.cooperations_id'
            );
            $joins = array($joinPartime, $joinMember, $joinComplaint, $joinInformation);
            $fields = array(
	            'Member.nickname',
	            'Member.company_name',
	            'PartTime.category',
	            'PartTime.sub_category',
	            'PartTime.area',
	            'Cooperation.id',
	            'Cooperation.status',
	            'Cooperation.created',
                'Complaint.id',
                'Complaint.type',
                'Complaint.created',
                'Information.provincial',
                'Information.city'
	        );
        } else {
            $joins = array($joinPartime, $joinMember, $joinInformation);
            $fields = array(
	            'Member.nickname',
	            'Member.company_name',
	            'PartTime.category',
	            'PartTime.sub_category',
	            'PartTime.area',
	            'Cooperation.id',
	            'Cooperation.status',
	            'Cooperation.created',
                'Information.provincial',
                'Information.city'
	        );
        }
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'Cooperation' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('Cooperation.created' => $sort),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => $joins
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("cooperations", $this->controller->paginate('Cooperation'));
    }
    
    public function cooperationDetail($conditions, $type = "send")
    {
        $mCooperation = ClassRegistry::init('Cooperation');
        $result = $mCooperation->find('first', array('conditions' => $conditions));
        $this->controller->set('cooperation', $result);
        if (!empty($result)) {
            if ($type == "send") {
                $this->parttimeDetail($result['Cooperation']['part_times_id']);
            } else {
                $this->parttimeDetail($result['Cooperation']['part_times_id']);
                $this->memberInfo($result['Cooperation']['sender']);
            }
            $this->informattionDetail($result['Cooperation']['information_id']);
        }
        return $result;
    }
    /**
     * 
     * 投诉
     * @param unknown_type $conditions
     */
    public function complaint($conditions)
    {
        $mComplaint = ClassRegistry::init('CooperationComplaint');
        $result = $mComplaint->find('first', array('conditions' => $conditions));
        $this->controller->set('complaint', $result);
        return $result;
    }
    
    public function informattionDetail($id)
    {
        $mInformation = ClassRegistry::init('Information');
        $information = $mInformation->find('first', array('conditions' => array('id' => $id)));
        
        $mAttribute = ClassRegistry::init('InformationAttribute');
        $attributes = $mAttribute->find('all', array('conditions' => array('information_id' => $id)));
        $this->controller->set('information', $information);
        $this->controller->set('inforAttr', $attributes);
    }
    
    public function memberInfo($id)
    {
//        $mMember = ClassRegistry::init('Member');
        $mMemberAttr = ClassRegistry::init('MemberAttribute');
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'MemberAttribute.members_id = Member.id'
        );
        $params = array(
            'fields' => array(
                'MemberAttribute.members_id',
                'MemberAttribute.name',
                'MemberAttribute.sex',
                'MemberAttribute.mobile',
                'MemberAttribute.telephone',
                'MemberAttribute.provincial_id',
                'MemberAttribute.city_id',
                'MemberAttribute.category_id',
                'MemberAttribute.business_scope',
                'Member.email'
                
            ),
            'conditions' => array(
                'members_id' => $id
            ),
            'joins' => array($joinMember)
        );
        $attribute = $mMemberAttr->find('first', $params);
        $this->controller->set('sender', $attribute);
    }
    
    public function setCooperationStatus($data, $conditions)
    {
        $mCooperation = ClassRegistry::init('Cooperation');
        $result = $mCooperation->updateAll($data, $conditions);
        return $result;
    }
    
    public function getFailure($cooperations_id)
    {
        $mCooperationFailure = ClassRegistry::init('CooperationFailure');
        $failure = $mCooperationFailure->find('first', array('conditions' => array('cooperations_id' => $cooperations_id)));
        $this->controller->set('failure', $failure);
    }
    
    /**
     * 
     * 站内信
     * @param int $information_id
     * @param int $from_members_id
     * @param int $to_members_id
     */
    public function comments($conditions, $type = "send")
    {
        $fields = array(
            'CooperationComment.id',
            'CooperationComment.cooperations_id',
            'CooperationComment.sender',
            'CooperationComment.receiver',
            'CooperationComment.content',
            'CooperationComment.type',
            'CooperationComment.created',
            'Member.nickname'
        );
        if ($type == "send") {
            $joinMember = array(
	            'table' => 'members',
	            'alias' => 'Member',
	            'type'  => 'inner',
	            'conditions' => 'CooperationComment.receiver = Member.id'
	        );
        } else {
            $joinMember = array(
	            'table' => 'members',
	            'alias' => 'Member',
	            'type'  => 'inner',
	            'conditions' => 'CooperationComment.sender = Member.id'
	        );
        }
        
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'CooperationComment' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('CooperationComment.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinMember)
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("comments", $this->controller->paginate('CooperationComment'));
    }
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}