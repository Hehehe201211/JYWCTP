<?php
class PaymentController extends AppController
{
	var $uses = array('PaymentTransaction', 'Payment', 'InformationAttribute', 'Information');
	
	
	
	public function pay()
	{
		$this->autoRender = false;
		if (md5($this->request->data['pay_password']) != $this->_memberInfo['Attribute']['pay_password']) {
			$result = array('result' => 'error', 'field' => 'pay_passwrod', 'msg' => '支付密码不正确');
		} else if (strtolower($this->request->data['checkNum']) != strtolower($this->Session->read('checkNum'))) {
			$result = array('result' => 'error', 'field' => 'checkNum', 'msg' => '验证码不正确');
		} else if (($this->request->data['pay_method'] == 'coin' && $this->_memberInfo['Attribute']['virtual_coin'] < $this->request->data['virtual_coin']) ||
		  ($this->request->data['pay_method'] == 'point' && $this->_memberInfo['Attribute']['point'] < $this->request->data['point'])
		) {
	        $result = array('result' => 'error', 'field' => 'checkNum', 'msg' => '余额不足，请充值');
		} else {
			$isPaymented = $this->PaymentTransaction->find('count', array('conditions' => array('members_id' => $this->_memberInfo['Member']['id'], 'information_id' => $this->request->data['information_id']))) > 0 ? true : false;
			if (!$isPaymented) {
			    $information = $this->Information->find('first', array('fields' => array('status', 'sell_count', 'members_id'), 'conditions' => array('id' => $this->request->data['information_id'])));
				if ($information['Information']['sell_count'] >= Configure::read('Information.sell_limit')) {
				    $result = array('result' => 'success', 'msg' => Configure::read('Information.sell_limit_msg'));
				} else {
    			    $result = $this->Payment->pay($this->request->data, $this->_memberInfo, $information);
    				if ($result) {
    					if ($this->request->data['pay_method'] == "coin") {
    						$this->_memberInfo['Attribute']['virtual_coin'] = ((int)$this->_memberInfo['Attribute']['virtual_coin'] - (int)$this->request->data['virtual_coin']);
    					} else {
    						$this->_memberInfo['Attribute']['point'] = ((int)$this->_memberInfo['Attribute']['point'] - (int)$this->request->data['point']);
    					}
    					$result = array(
    						'result' => 'success', 
    					);
    					$this->Session->write('memberInfo', $this->_memberInfo);
    				} else {
    					$result = array('result' => 'error', 'msg' => '系统错误，请重试');
    				}
				}
			} else {
				$result = array('result' => 'success', 'msg' => '已经购买');
			}
		}
		$this->_sendJson($result);
	}
	
	public function beforeRender()
	{
		$css = array(
    	'member'
    	);
    	$js = array('member');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
	}
	
}