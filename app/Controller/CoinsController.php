<?php
/**
 * 
 * 聚客币管理控制器
 * @author deping_lin
 *
 */
App::uses("Alipay", "Lib");
class CoinsController extends AppController
{
    var $layout = 'members';
    var $helpers = array('Js', 'City', 'Category');
      var $components = array('RequestHandler', 'Fund', 'Unit', 'Recommend');
      var $uses = array(
          'PaymentHistory',
          'MemberAttribute',
          'Information',
          'InformationTransaction',
          'AlipayCharge',
          'AlipayExpend'
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
     * 聚客币充值
     */
    public function charge()
    {
        $conditions = array(
            'members_id'    => $this->_memberInfo['Member']['id'],
            'delete_flg'    => 0
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        $this->paginate = array(
            'AlipayCharge' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('AlipayCharge.created' => 'DESC'),
                'conditions' => $conditions,
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("charges", $this->paginate('AlipayCharge'));
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('charge-paginate');
        } else {
            $balance = $this->Fund->balance();
            $this->set('balance', $balance);
        }
    }
    /**
     * 
     * 删除充值履历
     */
    public function delete()
    {
        if (isset($this->request->data['order_no']) && !empty($this->request->data['order_no'])) {
            $conditions = array(
                'order_no' => $this->request->data['order_no'],
                'members_id' => $this->_memberInfo['Member']['id']
            );
            $updata = array('delete_flg' => 1);
            try {
                $this->AlipayCharge->updateAll($updata, $conditions);
                $result = array(
	                'result' => 'OK',
	            );
            } catch (Exception $e) {
                $result = array(
	                'result' => 'NG',
	                'msg'    => '系统发生错误，请稍后再试！'
	            );
	            $this->log($e->getMessage());
            }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'    => '没有可以删除的对象！'
            );
        }
        $this->_sendJson($result);
    }
    
    /**
     * 
     * 聚客币收入详细
     */
    public function income()
    {
        $this->Fund->income();
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/coins_paginator');
        }
    }
    /**
     * 
     * 聚客币支出详细
     */
    public function expenses()
    {
        $this->Fund->expenses();
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/coins_paginator');
        }
    }
    /**
     * 
     * 聚客币提现
     */
    public function expend()
    {
        $this->set('title_for_layout', "提现申请");
        $conditions = array(
            'members_id'    => $this->_memberInfo['Member']['id'],
            'delete_flg'    => 0
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        $this->paginate = array(
            'AlipayExpend' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('AlipayExpend.created' => 'DESC'),
                'conditions' => $conditions,
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("expends", $this->paginate('AlipayExpend'));
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('expend-paginate');
        }
    }
    
    public function expend_send()
    {
        $data = $this->request->data;
        if (isset($data['pay_account']) &&
            !empty($data['pay_account']) &&
            isset($data['price']) &&
            !empty($data['price'])
        ) {
            $out_trade_no = Alipay::makeOrderNo();
            $result = $this->AlipayCharge->expendAlipay($data, $this->_memberInfo['Member']['id'], $out_trade_no);
            if ($result['result'] == 'OK') {
                $this->_memberInfo['Attribute']['virtual_coin'] = $this->_memberInfo['Attribute']['virtual_coin'] - $data['price'];
                $this->Session->write('memberInfo', $this->_memberInfo);
            }
        } else {
            $result = array(
                'result'    => 'NG',
                'msg'       => '参数错误，系统无法处理当前提现处理！'
            );
            $this->log(__CLASS__ . "::" . __FUNCTION__ . "() params error! " . print_r($data, true));
        }
        $this->_sendJson($result);
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
              $error = $this->Fund->detail($information_id, $type, Configure::read('Information.payment_type_coin'));
        }
        
        $this->set('error', $error);
    }
    
    public function beforeRender()
    {
        $this->set("msg", "没有待确认交易信息");
        $this->currentMenu = Configure::read('Menu.coinManager');
        $css = array(
        'member',
        'ui/jquery-ui',
        'ui/calendar'
        );
        $js = array('member', 'jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //推荐信息
        if (!$this->RequestHandler->isAjax()){
            //系统信息
	        $notices = $this->Unit->notice();
	        $this->set('notices', $notices);
            if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.Personal')) {
                $this->Recommend->parttime($this->_memberInfo['Member']['id'], $this->_memberInfo['Attribute']['category_id']);
                //提示各种信息所处各种状态
                $this->Recommend->PersonNoticeCount($this->_memberInfo['Member']['id']);
            } else {
                //提示各种信息所处各种状态
                $this->Recommend->CompanyNoticeCount($this->_memberInfo['Member']['id']);
            }
        }
    }
}