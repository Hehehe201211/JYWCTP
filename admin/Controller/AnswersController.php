<?php
class AnswersController extends AppController
{
    var $uses = array('AppealAnswer');
    public function add()
    {
//        $this->autoRender = false;
        $result = $this->AppealAnswer->saveAnswer($this->request->data);
        if ($result) {
            $result = array('result' => 'OK', 'appeal_id' => $this->request->data['appeal_id']);
        } else {
            $result = array('result' => 'NG');
        }
        $this->_sendJson($result);
    }
    
    /**
     * 
     * 系统平台对兼职投诉处理
     */
    public function complaint()
    {
        $mCooperationComplaint = ClassRegistry::init('CooperationComplaint');
        $result = $mCooperationComplaint->answer($this->request->data);
        if ($result) {
            $result = array('result' => 'OK');
        } else {
            $result = array('result' => 'NG');
        }
        $this->_sendJson($result);
    }
}