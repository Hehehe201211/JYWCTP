<?php
/**
 * 
 * 企业会员管理
 * @author lin_deping
 *
 */
class CompaniesController extends AppController
{
	public $components = array('Grid');
	public $uses = array('Homepage');
	/**
	 * 
	 * 基础信息
	 */
	public function index()
	{
		
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
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $alialMap, $where);
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
	        	'joins'	     =>  array($joinMember)
	        );
        } else {
        	$conditions = array(
	            'fields'     =>  $fields,
	            'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
	            'limit'      =>  $this->request->query['rows'],
	            'page'       =>  $this->request->query['page'],
	        	'joins'	     =>  array($joinMember)
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