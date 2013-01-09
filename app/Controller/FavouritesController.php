<?php
class FavouritesController extends AppController
{
    var $layout = 'members';
    var $uses = array(
        'PartTimeFavourite',
        'PartTime'
    );
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Info');
    var $paginate;
    public function listview()
    {
        $fields = array(
            'PartTimeFavourite.id',
            'PartTime.title',
            'PartTime.sub_title',
            'Member.company_name',
            'PartTime.method',
            'PartTime.created'
        );
        $joinPartTime = array(
            'table' => 'part_times',
            'alias' => 'PartTime',
            'type'  => 'inner',
            'conditions' => 'PartTime.id = PartTimeFavourite.part_times_id'
        );
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'Member.id = PartTime.members_id'
        );
        $conditions = array(
            'PartTimeFavourite.members_id' => $this->_memberInfo['Member']['id']
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 10;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'PartTimeFavourite' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('PartTimeFavourite.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinPartTime, $joinMember)
            )
        );
        $this->set("favourites", $this->paginate('PartTimeFavourite'));
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
//            $this->render('/Elements/cinfirm_paginator');
        }
    }
    
    public function detail()
    {
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $id = $this->request->query['id'];
            $conditions = array(
                'id' => $id,
                'members_id' => $this->_memberInfo['Member']['id']
            );
            $favourite = $this->PartTimeFavourite->find('first', array('conditions' => $conditions));
            if (!empty($favourite)) {
                $parttime = $this->PartTime->find('first', array('conditions' => array('id' => $favourite['PartTimeFavourite']['part_times_id'])));
                $this->set('parttime', $parttime);
            } else {
                $this->_sysDisplayErrorMsg("没有此信息！");
            }
        } else {
            $this->_sysDisplayErrorMsg("没有此信息！");
        }
    }
    
    public function add()
    {
        $this->autoRender = false;
        $conditions = array(
            'members_id'    => $this->_memberInfo['Member']['id'],
            'part_times_id' => $this->request->data['part_times_id']
        );
        if ($this->PartTimeFavourite->find('count', array('conditions' => $conditions)) == 0) {
            if ($this->PartTimeFavourite->save($conditions)) {
                $result = array(
                    'result' => 'OK'
                );
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '系统错误，请稍后再设置！'
                );
            }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'    => '不能重复设置！'
            );
        }
        $this->_sendJson($result);
    }
    
    public function delete()
    {
        $this->autoRender = false;
        $conditions = array(
            'id' => $this->request->data['id'],
            'members_id' => $this->_memberInfo['Member']['id']
        );
        try {
            if ($this->PartTimeFavourite->deleteAll($conditions)) {
                $result = array(
                    'result' => 'OK'
                );
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '没有你要删除的对象！'
                );
            }
        } catch (Exception $e) {
            $this->log(__CLASS__ . "->" . __FUNCTION__ . "()" . "msg:" . $e->getMessage());
            $result = array(
                'result' => 'NG',
                'msg'    => '系统发生错误，请稍后重试！'
            );
        }
        $this->_sendJson($result);
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
    }
}