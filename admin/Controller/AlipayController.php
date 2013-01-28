<?php
/**
 * 
 * 支付宝批量付款
 * @author deping_lin
 *
 */
class AlipayController extends AppController
{
    var $components = array('Grid', 'File');
    /**
     * 
     * 支付宝批量付款时间预约
     */
    public function index()
    {
        $this->_useJqGrid();
        $this->_appendJs('alipay-index');
    }
    
    public function alipayReservation()
    {
        $this->uses = array('AlipayReservation');
        $aliaAlipayMap = array(
            'AlipayReservation' => array('id', 'deal_date', 'status', 'created')
        );
        $where = array();
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $aliaAlipayMap, $where);
        }
        $fields = array('id', 'deal_date', 'status', 'created');
        $conditions = array(
            'conditions' => $where,
            'fields'     => $fields,
            'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
            'limit'      =>  $this->request->query['rows'],
            'page'       =>  $this->request->query['page'],
        );
        $countConditions = array('conditions' => $where);
        $data = $this->AlipayReservation->find('all', $conditions);
        $count = $this->AlipayReservation->find('count', $countConditions);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        $rows = array();
        foreach ($data as $value) {
            $row['id'] = $value['AlipayReservation']['id'];
            $row['cell'] = array_values($value['AlipayReservation']);
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    public function alipayReservationEdit()
    {
        $this->autoRender = false;
        $this->uses = array('AlipayReservation');
        switch ($this->request->data['oper']){
            case 'add':
                $data = array(
                    'deal_date' => $this->request->data['deal_date'],
                    'status' => 1,
                );
                $this->AlipayReservation->save($data);
                break;
            case 'edit':
                $data = array(
                    'id'   => $this->request->data['id'],
                    'deal_date' => $this->request->data['deal_date'],
                );
                $this->AlipayReservation->save($data);
                break;
            case 'del':
                $this->AlipayReservation->delete($this->request->data['id']);
                break;
        }
    }
    
    /**
     * 
     * 批量付款处理文件下载
     */
    public function file()
    {
        $this->_useJqGrid();
        $this->_appendJs('alipay-file');
    }
    
    public function fileData()
    {
        $this->uses = array('Reservation');
        $aliaAlipayMap = array(
            'Reservation' => array('sequence', 'status', 'created')
        );
        $where = array();
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $aliaAlipayMap, $where);
        }
        $fields = array('sequence', 'status', 'created');
        $conditions = array(
            'conditions' => $where,
            'fields'     => $fields,
            'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
            'limit'      =>  $this->request->query['rows'],
            'page'       =>  $this->request->query['page'],
        );
        $countConditions = array('conditions' => $where);
        $data = $this->Reservation->find('all', $conditions);
        $count = $this->Reservation->find('count', $countConditions);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        $rows = array();
        foreach ($data as $value) {
            $row['id'] = $value['Reservation']['sequence'];
            $row['cell'] = array_values($value['Reservation']);
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    
    public function report()
    {
        $this->autoRender = FALSE;
        $this->uses = array('Reservation');
        $sequence = $this->request->query['sequence'];
        $conditions = array(
            'sequence'  => $sequence
        );
        $exist = $this->Reservation->find('count', array('conditions' => $conditions));
        $this->log("ll" . $exist);
        if ($exist > 0) {
            $this->log($exist);
            $filePath = Configure::read('Alipay.report_path') . $sequence . ".xlsx";
            if (file_exists($filePath)) {
                $this->File->download($filePath, 'alipay_report_' . $sequence . ".xlsx");
            }
        }
    }
    
    /**
     * 
     * 支付宝批量付款处理完
     * 之后，上传文件，更新聚业务平台
     * 提现申请状态
     */
    public function status()
    {
        
    }
}