<?php
/**
 * 
 * 企业会员管理
 * @author lin_deping
 *
 */
class CompaniesController extends AppController
{
    public $components = array('Grid', 'File');
    public $uses = array('Homepage');
    /**
     * 
     * 基础信息
     */
    public function index()
    {
        $this->_useJqGrid();
        $this->_appendJs('jquery-ui.js');
        $this->_appendJs('company/index.js');
    }
    
    public function gridBase()
    {
        $this->uses = array('Member');
        $aliaMap = array(
            'Member' => array('id', 'nickname', 'type'),
            'CompanyAttribute' => array()
        );
        $this->autoRender = false;
        $where = array('type' => 1);
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $aliaMap, $where);
        }
        $joinCompany = array(
            'table' => 'company_attributes',
            'alias' => 'CompanyAttribute',
            'type'  => 'left',
            'conditions' => 'Member.id = CompanyAttribute.members_id'
        );
        $fields = array(
                'Member.id',
                'Member.nickname',
                'Member.email',
                'Member.grade',
                'Member.continuous_online',
                'Member.lastlogin',
                'Member.mid',
                'CompanyAttribute.full_name',
                'CompanyAttribute.open_date',
                'CompanyAttribute.close_date',
                'CompanyAttribute.agree_normal',
                'CompanyAttribute.agree_fulltime',
                'CompanyAttribute.agree_parttime',
                'CompanyAttribute.contact_method',
                'CompanyAttribute.modified',
        );
        if (!empty($where)) {
            $conditions = array(
                'conditions' =>  $where,
                'fields'     =>  $fields,
                'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
                'limit'      =>  $this->request->query['rows'],
                'page'       =>  $this->request->query['page'],
                'joins'      =>  array($joinCompany)
            );
        } else {
            $conditions = array(
                'fields'     =>  $fields,
                'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
                'limit'      =>  $this->request->query['rows'],
                'page'       =>  $this->request->query['page'],
                'joins'      =>  array($joinCompany)
            );
        }
        $countConditions = array('conditions' => $where);
        $data = $this->Member->find('all', $conditions);
        $count = $this->Member->find('count', $countConditions);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        foreach ($data as $value) {
            $row['id'] = $value['Member']['id'];
            $contact = '';
            $methods = json_decode($value['CompanyAttribute']['contact_method'], true);
            foreach ($methods as $method) {
                $contact .= $method['method'] . ' : ' . $method['content'] . " ";
            }
            $row['cell'] = array(
                $value['Member']['id'],
                $value['Member']['nickname'],
                $value['CompanyAttribute']['full_name'],
                $contact,
                $value['Member']['email'],
                $value['Member']['grade'],
                $value['Member']['continuous_online'],
                $value['Member']['lastlogin'],
                $value['CompanyAttribute']['open_date'],
                $value['CompanyAttribute']['close_date'],
                $value['CompanyAttribute']['agree_normal'],
                $value['CompanyAttribute']['agree_fulltime'],
                $value['CompanyAttribute']['agree_parttime'],
                $value['CompanyAttribute']['modified'],
            );
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    public function editBase()
    {
        $this->autoRender = false;
        $this->uses = array('Member', 'CompanyAttribute');
        switch ($this->request->data['oper']){
            case 'add':
                break;
            case 'edit':
                $now = date('Y-m-d');
                $attributeData = array(
                    'agree_normal' => $this->request->data['agree_normal'],
                    'agree_fulltime' => $this->request->data['agree_fulltime'],
                    'agree_parttime' => $this->request->data['agree_parttime'],
                );
                if (!empty($this->request->data['open_date'])) {
                    $attributeData['open_date'] = $this->request->data['open_date'];
                }
                if (!empty($this->request->data['close_date'])) {
                    $attributeData['close_date'] = $this->request->data['close_date'];
                }
                $this->CompanyAttribute->updateAll($attributeData, array('members_id' => $this->request->data['id']));
                break;
            case 'del':
                break;
        }
    }
    
    public function downLicense()
    {
        $this->autoRender = FALSE;
        $this->uses = array('CompanyAttribute');
        $license = $this->CompanyAttribute->find('first', array('conditions' => array('members_id' => $this->request->query['id']), 'fields' => array('license', 'full_name')));
        if (!empty($license['CompanyAttribute']['license'])) {
            $filePathInfo = pathinfo($license['CompanyAttribute']['license']);
            $filePath = Configure::read('Data.path') . $filePathInfo['dirname'] . '/license.' . $filePathInfo['extension'];
            if (file_exists($filePath)) {
                $this->File->download($filePath, $license['CompanyAttribute']['full_name'] . '_license.' . $filePathInfo['extension']);
            } else {
                $log = array(
                    'members_id'    => $this->request->query['id'],
                    'path'          => $filePath
                );
                $this->log("文件不存在！\n" . print_r($log, true));
            }
        } else {
            $this->log('members_id = ' .$this->request->query['id'] . '没有营业执照！');
        }
    }
    
    /**
     * 
     * 常规招聘相关设置
     */
    public function fulltime()
    {
        $this->_useJqGrid();
        $this->_appendJs('jquery-ui.js');
        $this->_appendJs('fulltime.js');
    }
    public function gridFulltime()
    {
        $aliaMap = array(
            'Member' => array('id', 'nickname', 'type'),
            'Homepage' => array('domain', 'graphic_flg', 'start', 'end', 'modified')
        );
        $this->autoRender = false;
        $where = array();
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $aliaMap, $where);
        }
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'left',
            'conditions' => 'Member.id = Homepage.members_id AND Member.type = 1'
        );
        $fields = array(
            'Member.id',
            'Member.nickname',
            'Homepage.domain',
            'Homepage.graphic_flg',
            'Homepage.start',
            'Homepage.end',
            'Homepage.modified'
        );
        if (!empty($where)) {
            $conditions = array(
                'conditions' =>  $where,
                'fields'     =>  $fields,
                'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
                'limit'      =>  $this->request->query['rows'],
                'page'       =>  $this->request->query['page'],
                'joins'         =>  array($joinMember)
            );
        } else {
            $conditions = array(
                'fields'     =>  $fields,
                'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
                'limit'      =>  $this->request->query['rows'],
                'page'       =>  $this->request->query['page'],
                'joins'         =>  array($joinMember)
            );
        }
        $countConditions = array('conditions' => $where);
        $data = $this->Homepage->find('all', $conditions);
        $count = $this->Homepage->find('count', $countConditions);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        foreach ($data as $value) {
            $row['id'] = $value['Member']['id'];
            $row['cell'] = array(
                $value['Member']['id'],
                $value['Member']['nickname'],
                $value['Homepage']['domain'],
                $value['Homepage']['graphic_flg'],
                $value['Homepage']['start'],
                $value['Homepage']['end'],
            );
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    public function editFulltime()
    {
        $this->autoRender = false;
        $this->uses = array('Homepage');
        switch ($this->request->data['oper']){
            case 'add':
                break;
            case 'edit':
                $now = date('Y-m-d');
                $conditions = array(
                    'graphic_flg' => 1,
                    'start <= ' => $now,
                    'end >= ' => $now
                );
                if ($this->Homepage->find('count', array('conditions' => $conditions)) < 60) {
                    $data = array(
                        'graphic_flg' => "'" . $this->request->data['graphic_flg'] . "'",
                    );
                    if (!empty($this->request->data['start'])) {
                        $data['start'] = "'" . $this->request->data['start'] . "'";
                    }
                    if (!empty($this->request->data['end'])) {
                        $data['end'] = "'" . $this->request->data['end'] . "'";
                    }
                    $conditions = array(
                        'members_id' => $this->request->data['id']
                    );
                    $this->log(print_r($data, TRUE));
                    $this->Homepage->updateAll($data, $conditions);
                } else {
                    echo '图片招聘区域最大只能登陆60个。已经超出！';
                }
                
                break;
            case 'del':
                break;
        }
    }
    
    /**
     * 
     * 兼职招聘相关设置
     */
    public function parttime()
    {
        
    }
}