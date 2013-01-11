<?php
/**
 * 
 * 积分管理控制器
 * @author lin_deping
 *
 */
class PointsController extends AppController
{
    var $layout = 'members';
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Fund', 'Unit');
    var $uses = array(
        'PaymentHistory',
        'MemberAttribute',
        'Information'
    );
    var $paginate;
    
    /**
     * 
     * 聚客币余额
     */
    public function balance()
    {
        $balance = $this->Fund->balance();
        $this->set('balance', $balance);
    }
    
    /**
     * 
     * 积分充值
     */
    public function charge()
    {
        
    }
    /**
     * 
     * 积分收入详细
     */
    public function income()
    {
        $this->Fund->income('point');
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/coins_paginator');
        }
    }
    
    /**
     * 
     * 积分支出详细
     */
    public function expenses()
    {
        $this->Fund->expenses('point');
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/coins_paginator');
        }
    }
    
    public function detail()
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->_sysDisplayErrorMsg("没有你想要的信息");
            return 0;
        }
        $error = false;
        if (!isset($this->request->data['information_id']) || 
            !isset($this->request->data['type']) || 
            empty($this->request->data['information_id']) ||
            empty($this->request->data['type'])
        ) {
            $error = true;
        } else {
            $information_id = $this->request->data['information_id'];
            $type = $this->request->data['type'];
            $error = $this->Fund->detail($information_id, $type, Configure::read('Information.payment_type_point'));
        }
        
        $this->set('error', $error);
    }
    
    public function beforeRender()
    {
        $this->set("msg", "没有待确认交易信息");
        $this->currentMenu = Configure::read('Menu.pointManager');
        $css = array(
        'member',
        'ui/jquery-ui',
        'ui/calendar'
        );
        $js = array('member', 'jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
    }
}