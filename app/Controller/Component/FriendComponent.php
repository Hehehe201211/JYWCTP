<?php
class FriendComponent extends Component
{
    var $name = 'Friend';
    
    
    public function friendList($conditions)
    {
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'Friendship.friend_members_id = Member.id'
        );
        $joinMemberAttribute = array(
            'table' => 'member_attributes',
            'alias' => 'Attribute',
            'type'  => 'inner',
            'conditions' => 'Attribute.members_id = Member.id'
        );
        $fields = array(
            'Friendship.friend_members_id',
            'Friendship.friend_groups_id',
            'Member.nickname',
            'Attribute.name',
            'Attribute.company'
        );
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $this->controller->paginate = array(
            'Friendship' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('Friendship.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinMember, $joinMemberAttribute)
            )
        );
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("friendships", $this->controller->paginate('Friendship'));
    }
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}