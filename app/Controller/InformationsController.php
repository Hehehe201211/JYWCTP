<?php
class InformationsController extends AppController
{
    var $layout = 'members';
    var $uses = array(
        'City', 
        'Category', 
        'Information', 
        'PaymentTransaction', 
        'PaymentHistory', 
        'InformationAttribute', 
        'InformationComplaint',
        'MemberReceived',
        'InformationComment',
        'Member',
        'Payment',
        'Appraisal',
        'PartTime',
        'Friendship',
    );
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Info', 'Unit', 'Recommend');
    var $paginate;
    
    public function index()
    {
        $this->set('title_for_layout', "信息详情");
    }
    /**
     * 
     * 发布需求，发布客源
     */
    public function create()
    {
        $this->set('title_for_layout', "信息发布");
        $type = isset($this->request->params['pass'][0]) ? ($this->request->params['pass'][0] == "has" ? 0 : 1) : 0;
        $target = (isset($this->request->query['target'])) ? $this->request->query['target'] : "";
        $target_member = (isset($this->request->query['target_member'])) ? $this->request->query['target_member'] : "";
        if (!empty($target) && !$this->request->is('post')) {
            $targetInfo = $this->Information->find('first', array('conditions' => array('id' => $target)));
            if (!empty($targetInfo)) {
                $this->set('targetInfo', $targetInfo);
            }
        } elseif (isset($this->request->query['parttime'])) {
            $parttime = $this->PartTime->find('first', array('fields' => array('category', 'sub_category'), 'conditions' => array('id' => $this->request->query['parttime'])));
            $type = 2;
            if (empty($parttime)) {
                $this->_sysDisplayErrorMsg("没有相对于的兼职信息！");
            } else {
	            $this->set('parttime', $parttime);
            }
        }
        $this->_appendJs(array('jquery-ui'));
        $this->_appendCss(array('ui/jquery-ui', 'ui/calendar'));
        $this->set('type', $type);
        $this->set('target', $target);
        $this->set('target_member', $target_member);
        if ($type == 1) {
            $this->render('create_reward');
        }
    }
    /**
     * 
     * 发布确认
     */
    public function check()
    {
        $this->set('title_for_layout', "信息内容确认");
        $param = array(
            'fields' => array('name'),
            'conditions' => array('id' => $this->request->data['provincial'])
        );
        $provincial = $this->City->find('first', $param);
        $param['conditions'] = array('id' => $this->request->data['city']);
        $city = $this->City->find('first', $param);
        $this->set("provincial", $provincial['City']['name']);
        $this->set('c