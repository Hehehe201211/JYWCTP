<?php
/**
 * 和支付宝接口相关的控制器
 * @author lin deping
 */
App::uses("Alipay", "Lib");
App::uses('HttpSocket', 'Network/Http');
class AlipaysController extends AppController
{
    var $uses = array('AlipayCharge');
    /**
     * 
     * 支付手段选择
     */
    public function check()
    {
        $this->layout = 'resume_preview';
    }
    
    /**
     * 
     * 发送支付宝结账请求
     */
    public function send()
    {
        $this->layout = 'alipay';
        $out_trade_no = Alipay::makeOrderNo();
        $subject = "聚业务 业务币充值";
        $body = "";
        $total_fee = $this->request->data['price'];
        
        $encrypt_key = "";
        $exter_invoke_ip = "";
        if (Configure::read("Alipay.antiphishing") == 1){
        }
        
        $extra_common_param = "";
        $buyer_email = "";
        
        $parameter = array(
            "service"            => "create_direct_pay_by_user",
            "payment_type"      => "1",
            "partner"           => Configure::read("Alipay.partner"),
            "seller_id"      => Configure::read("Alipay.partner"),
            "return_url"        => Configure::read("Alipay.return_url"),
            "notify_url"        => Configure::read("Alipay.notify"),
            "_input_charset"    => Configure::read("Alipay._input_charset"),
            "show_url"          => Configure::read("Alipay.show_url"),
            
            "out_trade_no"      => $out_trade_no,
            "subject"           => $subject,
            "body"              => $body,
            "total_fee"         => $total_fee,
            "anti_phishing_key" => $encrypt_key,
            "exter_invoke_ip"   => $exter_invoke_ip,
            
        );
        $chargeData = array(
            'members_id'    => $this->_memberInfo['Member']['id'],
            'order_no'      => $out_trade_no,
            'price'         => $total_fee,
            'status'        => Configure::read('Alipay.status_confirm')
        );
        try {
            $this->AlipayCharge->save($chargeData);
            $para_filter = Alipay::paraFilter($parameter);
            $para_sort = Alipay::argSort($para_filter);
            $mySign = Alipay::makeRequestMySign($para_sort);
            $para_sort['sign'] = $mySign;
            $para_sort['sign_type'] = strtoupper(trim(Configure::read('Alipay.sign_type')));
            $this->set('parameters', $para_sort);
        } catch (Exception $e) {
            $this->log($e->getMessage());
        }
        
    }
    /**
     * 
     * 接收支付宝的实时处理信息
     */
    public function notify()
    {
        $this->autoRender = false;
        $this->autoLayout = false;
        $data = $this->request->data;
        $error = false;
        $this->log(__FUNCTION__ . " This request params from alipay platform.\n" . print_r($data, true));
        if (isset($data['notify_id']) && 
            !empty($data['notify_id']) && 
            isset($data['out_trade_no']) && 
            !empty($data['out_trade_no']) &&
            isset($data['sign']) &&
            isset($data['sign_type'])
        ) {
            $sign = $data['sign'];
            unset($data['sign']);
            unset($data['sign_type']);
            $para_filter = Alipay::paraFilter($data);
            $para_sort = Alipay::argSort($para_filter);
            if (Alipay::checkAlipaySign($para_sort, $sign)) {
                if ($this->_isAlipayRequest($data['notify_id'])) {
                    $alipayCharge = $this->AlipayCharge->find('first', array('conditions' => array('order_no' => $data['out_trade_no'])));
                    if (!empty($alipayCharge)) {
                        if ($alipayCharge['AlipayCharge']['status'] == Configure::read('Alipay.status_confirm')) {
                            $error = !$this->AlipayCharge->updateStatus($data, $alipayCharge, 'notify');
                        }
                    } else {
                        $this->log(__FUNCTION__ . " This order_no is not exist.\n" . print_r($data, true));
                    }
                } else {
                    $this->log(__FUNCTION__ . " This request is not from alipay platform.\n" . print_r($data, true));
                    $error = true;
                }
            } else {
                $this->log(__FUNCTION__ . " This sign is wrong.\n" . print_r($data, true));
                $error = true;
            }
        } else {
            $this->log(__FUNCTION__ . " This request params are error from alipay platform.\n" . print_r($data, true));
            $error = true;
        }
        if (!$error) {
            echo 'success';
        } else {
            echo 'failure';
        }
        
    }
    /**
     * 
     * 支付宝处理结束后返回函数
     */
    public function callback()
    {
        $this->autoRender = false;
        $data = $this->request->query;
        $error = false;
        if (isset($data['notify_id']) && 
            !empty($data['notify_id']) && 
            isset($data['out_trade_no']) && 
            !empty($data['out_trade_no']) &&
            isset($data['sign']) &&
            isset($data['sign_type'])
        ) {
            $sign = $data['sign'];
            unset($data['sign']);
            unset($data['sign_type']);
            $para_filter = Alipay::paraFilter($data);
            $para_sort = Alipay::argSort($para_filter);
            if (Alipay::checkAlipaySign($para_sort, $sign)) {
	            if ($this->_isAlipayRequest($data['notify_id'])) {
		            $alipayCharge = $this->AlipayCharge->find('first', array('conditions' => array('order_no' => $data['out_trade_no'])));
	               if (!empty($alipayCharge)) {
                        if ($alipayCharge['AlipayCharge']['status'] == Configure::read('Alipay.status_confirm')) {
                            $error = !$this->AlipayCharge->updateStatus($data, $alipayCharge);
                        }
                    } else {
                        $this->log(__FUNCTION__ . " This order_no is not exist.\n" . print_r($data, true));
                    }
	            } else {
	                $this->log(__FUNCTION__ . " This request is not from alipay platform.\n" . print_r($data, true));
	                $error = true;
	            }
            } else {
                $this->log(__FUNCTION__ . " This sign is wrong.\n" . print_r($data, true));
                $error = true;
            }
        } else {
            $this->log(__FUNCTION__ . " This request params are error from alipay platform.\n" . print_r($data, true));
            $error = true;
        }
        if (!$error) {
            $this->_memberInfo['Attribute']['virtual_coin'] = $this->_memberInfo['Attribute']['virtual_coin'] + $data['total_fee'];
            $this->Session->write('memberInfo', $this->_memberInfo);
            $this->redirect('/coins/charge');
        } else {
            $this->redirect(array('controller' => 'coins', 'action' => 'error', 'order_no' => $data['out_trade_no']));
        }
    }
    
    /**
     * 
     * 用户取消支付处理
     */
    public function cancel()
    {
        $this->autoRender = false;
    }
    /**
     * 
     * Enter description here ...
     */
    private function _isAlipayRequest($notify_id)
    {
        $request = new HttpSocket();
        $url = Configure::read('Alipay.alipay_gateway_new');
        $query = array(
            'service'   => 'notify_verify',
            'partner'   => Configure::read('Alipay.partner'),
            'notify_id' => $notify_id
        );
        $request = $request->get($url, $query);
        return $request;
    }
    
    public function beforeRender()
    {
        $css = array(
        'ui/jquery-ui',
        'member',
        );
        $js = array('member', 'jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
    }
}