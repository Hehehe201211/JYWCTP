<?php
class InvitationsController extends AppController
{
    var $layout = 'members';
    var $uses = array(
        'Invitation',
        'PartTime',
        'CompanyAttribute',
        'Cooperation'
    );
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Info', 'Unit', 'Recommend');
    var $paginate;
    
    
    public function listview()
    {
        $this->set('title_for_layout', "收到的邀请");
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
        $this->set('title_for_layout', "收到的邀请详情");
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
                } else {
                    //企业会员信息
                    $conditions = array(
                        'members_id' => $invitation['Invitation']['sender']
                    );
                    $company = $this->CompanyAttribute->find('first', array('conditions' => $conditions));
                    $this->set('company', $company);
                    //和企业的兼职合作
                    $cooperationCond = array(
                        'sender'    => $this->_memberInfo['Member']['id'],
                        'receiver'  => $invitation['Invitation']['sender'],
                        'status'    => array()
                    );
                    $cooperationCond['status'] = array(
                        Configure::read('Cooperation.status.cooperating'),
                        Configure::read('Cooperation.status.waitpay'),
                        Configure::read('Cooperation.status.failure'),
                        Configure::read('Cooperation.status.complaint'),
                        Configure::read('Cooperation.status.paid'),
                        Configure::read('Cooperation.status.complete'),
                        Configure::read('Cooperation.status.platform_company'),
                        Configure::read('Cooperation.status.platform_personal')
                    );
                    $cooperationNum = $this->Cooperation->find('count', array('conditions' => $cooperationCond));
                    
                    $cooperationCond['status'] = array(
                        Configure::read('Cooperation.status.paid'),
                        Configure::read('Cooperation.status.complete'),
                    );
                    $cooperationSuccess = $this->Cooperation->find('count', array('conditions' => $cooperationCond));
                    $this->set('cooperationNum', $cooperationNum);
                    $this->set('successNum', $cooperationSuccess);
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
        //推荐信息
        if (!$this->RequestHandler->isAjax()){
            if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.Personal')) {
                $this->Recommend->parttime($this->_memberInfo['Member']['id'], $this->_memberInfo['Attribute']['category_id']);
            } else {
                ;
            }
        }
    }
}