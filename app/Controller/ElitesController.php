<?php
class ElitesController extends AppController
{
    var $layout = 'members';
    var $uses = array(
        'PartTimeFavourite',
        'PartTime',
        'Member',
        'Cooperation',
        'Invitation'
    );
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Unit');
    var $paginate;
    
    public function listview()
    {
        $js = array(
            'jquery-ui',
            'retrieval'
        );
        $css = array('ui/jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        $this->set('title_for_layout', '业务精英检索');
        $conditions = array(
            'MemberAttribute.locking' => 0,
            'Member.type'             => 0
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $this->_search($conditions, $pageSize, 0);
        $this->set('pageSize', $pageSize);
        if ($this->RequestHandler->isAjax()){
            $this->set('citys', "");
            $this->set('categorys', "");
            $this->render('search');
            
        }
    }
    
    public function detail()
    {
        $this->set('title_for_layout', '业务精英详细');
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $id = $this->request->query['id'];
            $joinAttribute = array(
                'table' => 'member_attributes',
	            'alias' => 'MemberAttribute',
	            'type'  => 'inner',
	            'conditions' => 'MemberAttribute.members_id = Member.id'
            );
            $params = array(
                'fields' => array('Member.*', 'MemberAttribute.*'),
                'conditions' => array('id' => $id),
                'joins' => array($joinAttribute)
            );
            $member = $this->Member->find('first', $params);
            if (empty($member)) {
                $this->_sysDisplayErrorMsg("no information");
            }
            $this->set('member', $member);
            
            //邀请按钮
            $invitationConditions = array(
                'sender'    => $this->_memberInfo['Member']['id'],
                'receiver'  => $id,
                'status'    => Configure::read('Invitation.inviting')
            );
            if ($this->Invitation->find('count', array('conditions' => $invitationConditions)) > 0) {
                $this->set('showInviteBtn', false);
            } else {
                $this->set('showInviteBtn', true);
            }
            
            $conditions = array(
                'Cooperation.sender'    => $id,
                'Cooperation.receiver'  => $this->_memberInfo['Member']['id']
            );
            $joinInformation = array(
                'table' => 'information',
                'alias' => 'Information',
                'type'  => 'inner',
                'conditions' => 'Information.id = Cooperation.information_id'
            );
            $joinPartTime = array(
                'table' => 'part_times',
                'alias' => 'PartTime',
                'type'  => 'inner',
                'conditions' => 'PartTime.id = Cooperation.part_times_id'
            );
            $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
	        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
	        
	        $fields = array(
	           'Information.title',
	           'Cooperation.created',
	           'Cooperation.status',
	           'PartTime.title',
	           'PartTime.method'
	        );
	        $this->paginate = array(
	            'Cooperation' => array('limit' => $pageSize,
	                'page'  => $page,
	                'order' => array('Cooperation.created' => 'DESC'),
	                'conditions' => $conditions,
	                'fields'    => $fields,
	                'joins'     => array($joinInformation, $joinPartTime)
	            )
	        );
	        $this->set('pageSize', $pageSize);
	        $this->set("cooperations", $this->paginate('Cooperation'));
	        if ($this->RequestHandler->isAjax()){
	            $this->render('ajax_paginate');
	        }
        }
    }
    
    public function search()
    {
        $conditions = array(
            'MemberAttribute.locking' => 0,
            'Member.type'             => 0
        );
        $citys = array();
        $categorys = array();
        if (isset($this->request->data['citys'])) {
            $citys = $this->request->data['citys'];
            $conditions['OR'] = array('MemberAttribute.provincial_id' => $citys, 'MemberAttribute.city_id' => $citys);
        } elseif (isset($this->request->query['citys']) && !empty($this->request->query['citys'])) {
            $citys = explode(',', $this->request->query['citys']);
            $conditions['OR'] = array('MemberAttribute.provincial_id' => $citys, 'MemberAttribute.city_id' => $citys);
        }
        if (isset($this->request->data['categorys'])) {
            $categorys = $this->request->data['categorys'];
            $conditions['MemberAttribute.category_id'] = $categorys;
        } elseif (isset($this->request->query["amp;categorys"]) && !empty($this->request->query["amp;categorys"])) {
            $categorys = explode(',', $this->request->query["amp;categorys"]);
            $conditions['MemberAttribute.category_id'] = $categorys;
        }
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $this->_search($conditions, $pageSize, 0);
        $this->set('pageSize', $pageSize);
        $this->set('citys', implode(',', $citys));
        $this->set('categorys', implode(',', $categorys));
//        if ($this->RequestHandler->isAjax()){
            $this->render('search');
//        }
    }
    
    public function _search($conditions, $limit, $page)
    {
        $joinAttribute = array(
            'table' => 'member_attributes',
            'alias' => 'MemberAttribute',
            'type'  => 'inner',
            'conditions' => 'MemberAttribute.members_id = Member.id'
        );
        $fields = array(
            'Member.id',
            'Member.nickname',
            'MemberAttribute.category_id'
        );
        $this->paginate = array(
            'Member' => array('limit' => $limit,
                'page'  => $page,
                'order' => array('Member.condinuous_online' => 'DESC', 'Member.lastlogin' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins' => array($joinAttribute)
            )
        );
        $this->set("elites", $this->paginate('Member'));
    }
    
    public function beforeRender()
    {
        $this->currentMenu = Configure::read('Menu.parttimeManager');
        $css = array(
        'member'
        );
        $js = array('member');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
    }
}