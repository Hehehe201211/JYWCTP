<?php
class CommentsController extends AppController
{
    var $uses = array(
        'InformationComment',
        'CooperationComment'
    );
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler');
    public function listview()
    {
        $this->autoLayout = false;
        $information_id = $this->request->data['information_id'];
        $from_members_id = $this->request->data['from_members_id'];
        $to_members_id = $this->request->data['to_members_id'];
        $conditions = array(
            'information_id' => $information_id,
            'OR' => array(
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
            'conditions' => 'InformationComment.members_id = Member.id'
        );
        
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 2;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->paginate = array(
            'InformationComment' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('InformationComment.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinMember)
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("comments", $this->paginate('InformationComment'));
    }
    
    public function complaintlist()
    {
        $this->autoLayout = false;
        $this->uses = array('CooperationComment');
        $cooperations_id = $this->request->data['cooperations_id'];
        $sender = $this->request->data['sender'];
        $receiver = $this->request->data['receiver'];
        $mMember = ClassRegistry::init('Member');
        $senderName = $mMember->find('first', array('fields' => array('nickname'), 'conditions' => array('id' => $sender)));
        $receiverName = $mMember->find('first', array('fields' => array('nickname'), 'conditions' => array('id' => $receiver)));
        $memberNames[$sender] = $senderName['Member']['nickname'];
        $memberNames[$receiver] = $receiverName['Member']['nickname'];
        
        $fields = array(
            'CooperationComment.id',
            'CooperationComment.cooperations_id',
            'CooperationComment.sender',
            'CooperationComment.receiver',
            'CooperationComment.content',
            'CooperationComment.type',
            'CooperationComment.created',
        );
        $conditions = array(
            'cooperations_id' => $cooperations_id,
            'sender'    => $sender,
            'receiver'  => $receiver
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 2;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->paginate = array(
            'CooperationComment' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('CooperationComment.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("comments", $this->paginate('CooperationComment'));
        $this->set('memberNames', $memberNames);
    }
}
