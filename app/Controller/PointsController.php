<?php
/**
 * 
 * 积分管理控制器
 * @author lin_deping
 *
 */
App::uses("Alipay", "Lib");
class PointsController extends AppController
{
    var $layout = 'members';
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Fund', 'Unit', 'Recommend');
    var $uses = array(
        'PaymentHistory',
        'MemberAttribute',
        'Information',
        'PointCharge'
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
        $conditions = array(
            'members_id'    => $this->_memberInfo['Member']['id'],
            'delete_flg'    => 0
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        $this->paginate = array(
            'PointCharge' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('PointCharge.created' => 'DESC'),
                'conditions' => $conditions,
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("charges", $this->paginate('PointCharge'));
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
    
    public function check()
    {
        $this->layout = 'resume_preview';
    }
    
    public function send()
    {
        $this->layout = 'alipay';
        $out_trade_no = Alipay::makeOrderNo();
        $chargeData = array(
            'members_id'    => $this->_memberInfo['Member']['id'],
            'order_no'      => $out_trade_no,
            'price'         => $this->request->data['price'],
            'status'        => Configure::read('Alipay.status_success')
        );
        try {
            $dataSource = $this->PointCharge->getDataSource();
            $dataSource->begin();
            $params = array(
                'conditions' => array('members_id' => $this->_memberInfo['Member']['id']),
                'fields' => array('virtual_coin','point')
            );
            $mMemberAttribute = $this->MemberAttribute->find('first', $params);
            $newPoint = $mMemberAttribute['MemberAttribute']['point'] + $this->request->data['price'] * Configure::read('Alipay.CoinToPoint_rate');
            $newCoin = $mMemberAttribute['MemberAttribute']['virtual_coin'] - $this->request->data['price'];
            if ($newCoin >= 0) {
	            $upData = array(
	                'point' => $newPoint,
	                'virtual_coin' => $newCoin
	            );
	            $this->MemberAttribute->updateAll($upData, array('members_id' => $this->_memberInfo['Member']['id']));
	            $this->PointCharge->save($chargeData);
	            $this->_memberInfo['Attribute']['point'] = $newPoint;
	            $this->Session->write('memberInfo', $this->_memberInfo);
            } else {
                $chargeData['status'] = Configure::read('Alipay.status_failure');
                $this->PointCharge->save($chargeData);
                throw new Exception('业务币余额不足！members_id' . $this->_memberInfo['Member']['id'], $this->_memberInfo['Member']['id']);
            }
            $dataSource->commit();
            $this->redirect('/points/charge');
        } catch (Exception $e) {
            $dataSource->rollback();
            $this->log($e->getMessage());
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
                $this->PointCharge->updateAll($updata, $conditions);
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