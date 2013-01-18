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
        $this->autoRender = false;
        $out_trade_no = Alipay::makeOrderNo();
        $subject = "聚业务 业务币充值";
        $body = "";
        $total_fee = $this->request->params['price'];
        
        $pay_mode = $this->request->params['pay_bank'];
        if ($pay_mode == "directPay"){
            $paymethod = "directPay";
            $defaultbank = "";
        } else {
            $paymethod = "bankPay";
            $defaultbank = $pay_mode;
        }
        
        $encrypt_key = "";
        $exter_invoke_ip = "";
        if (Configure::read("Alipay.antiphishing") == 1){
            $encrypt_key = Alipay::query_timestamp($partner);
            $exter_invoke_ip = $this->_getClientIp();
        }
        
        $extra_common_param = "";
        $buyer_email = "";
        
        $parameter = array(
            "servie"            => "create_direct_pay_by_user",
            "payment_type"      => "1",
            "partner"           => Configure::read("Alipay.partner"),
            "seller_email"      => Configure::read("Alipay.seller_email"),
            "return_url"        => Configure::read("Alipay.return_url"),
            "notify_url"        => Configure::read("Alipay.notify"),
            "_input_charset"    => Configure::read("Alipay._input_charset"),
            "show_url"          => Configure::read("Alipay.show_url"),
            
            "out_trade_no"      => $out_trade_no,
            "subject"           => $subject,
            "body"              => $body,
            "total_fee"         => $total_fee,
            
//            "paymethod"         => $paymethod,
//            "defaultbank"       => $defaultbank,
            
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
            $this->set('parameter', $parameter);
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
    }
    /**
     * 
     * 支付宝处理结束后返回函数
     */
    public function callback()
    {
        $this->autoRender = false;
    }
    
    /**
     * 
     * 用户取消支付处理
     */
    public function cancel()
    {
        $this->autoRender = false;
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