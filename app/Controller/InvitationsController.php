<?php
class InvitationsController extends AppController
{
    var $layout = 'members';
    var $uses = array(
        'Invitation',
        'PartTime'
    );
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Info', 'Unit');
    var $paginate;
    
    
    public function listview()
    {
        $conditions = array(
            'receiver'  => $this->_memberInfo['Member']['id'],
            'status'    => Configure::read('Invitation.inviting')
        );
        $joinCompany = array(
            'table' => 'company_attributes',
            'alias' => 'MemberAttribute',
            'type'  => 'left',
            'conditions' => 'Invitation.sender = MemberAttribute.members_id'
        );
        $fields = array(
            'Invitation.id',
            'MemberAttribute.full_name',
            'MemberAttribute.provincial_id',
            'MemberAttribute.city_id',
            'MemberAttribute.category_id',
        );
        
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 10;
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'Invitation' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('Invitation.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinCompany)
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("invites", $this->paginate('Invitation'));
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('invites');
        }
        
    }
    
    public function detail()
    {
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $id = $this->request->query['id'];
            $conditions = array(
                'id'    => $id,
                'status' => Configure::read('Invitation.inviting')
            );
            $invitation = $this->Invitation->find('first', array('conditions' => $conditions));
            if (!empty($invitation)) {
                $conditions = array(
                    'members_id' => $invitation['Invitation']['sender']
                );
                $fields = array(
                    'PartTime.id',
                    'PartTime.title',
                    'PartTime.category',
                    'PartTime.sub_category',
                    'PartTime.method',
                    'PartTime.pay',
                    'PartTime.pay_rate',
                    'PartTime.created'
                );
                $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : 2;
                $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
                $this->paginate = array(
                    'PartTime' => array('limit' => $pageSize,
                        'page'  => $page,
                        'order' => array('PartTime.created' => 'DESC'),
                        'conditions' => $conditions,
                        'fields'    => $fields,
                    )
                );
                $this->set('pageSize', $pageSize);
                $this->set("parttimes", $this->paginate('PartTime'));
                if ($this->RequestHandler->isAjax()) {
                    if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                        $this->set('jump', $page);
                    }
                    $this->render('parttimes');
                }
            } else {
                $this->_sysDisplayErrorMsg('没有此信息！');
            }
        } else {
            $this->_sysDisplayErrorMsg('没有此信息！');
        }
    }
    
    
    
    /**
     * 
     * 企业会员邀请处理
     */
    public function add()
    {
        $conditions = array(
            'sender'    => $this->_memberInfo['Member']['id'],
            'receiver'  => $this->request->data['receiver'],
            'status'    => Configure::read('Invitation.inviting')
        );
        if ($this->Invitation->find('count', $conditions) > 0) {
            $result = array(
                'result' => 'NG',
                'msg'    => '你已邀请此会员，不能重复邀请，请查看回复！'
            );
        } else {
            if ($this->Invitation->save($conditions)) {
                $result = array(
                    'result' => 'OK'
                );
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '发生系统错误，请稍后重试！'
                );
            }
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
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
    }
}