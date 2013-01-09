<?php
/**
 * 
 * 站内信组件
 * @author lin_deping
 *
 */
class CommentsComponent extends Component
{
    var $name = "Comments";
    
    
    public function comments($information_id, $members_id, $target_members_id)
    {
        $joinMembers = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'InformationComment.members_id = Member.id'
        );
        $conditions = array(
            'information_id' => $information_id, 
            "OR" => array(
                'members_id' => $members_id, 
                'members_id' => $target_members_id
            )
        );
        $fields = array(
            'InformationComment.id', 
            'InformationComment.members_id', 
            'InformationComment.content', 
            'InformationComment.created' , 
            'Member.nickname'
        );
        $params = array(
             'fields' => $fields,
             'conditions' => $conditions,
             'joins' => array($joinMembers)
        );
        
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : 10;
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
        $this->controller->set("informations", $this->controller->paginate('InformationComment'));
    }
    
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}