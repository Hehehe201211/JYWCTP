<?php

class StationMsgComponent extends Component
{
    public $name = 'StationMsg';
    
    public function getMessageList($conditions)
    {
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'StationMessage.sender = Member.id'
        );
        $joinMemberAttribute = array(
            'table' => 'member_attributes',
            'alias' => 'Attribute',
            'type'  => 'inner',
            'conditions' => 'Attribute.members_id = Member.id'
        );
        $fields = array(
            'Member.id',
            'Member.nickname',
            'Member.created',
            'Attribute.provincial_id',
            'Attribute.city_id',
            'Attribute.category_id',
            'Attribute.company',
            'StationMessage.id',
            'StationMessage.sender',
            'StationMessage.title',
            'StationMessage.type',
            'StationMessage.content',
            'StationMessage.created'
        );
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'StationMessage' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('StationMessage.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinMember, $joinMemberAttribute)
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("messages", $this->controller->paginate('StationMessage'));
    }
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}