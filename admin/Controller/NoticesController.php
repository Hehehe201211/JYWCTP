<?php
class NoticesController extends AppController
{
    var $helpers = array('Fck');
    public $components = array('Grid');
    protected  $_aliaAppealMap = array(
        'Notice' => array(
            'id',
            'title',
    		'parent_id',
    		'priority',
//            'content',
            'open',
            'close',
            'display',
            'modified'
        )
     );
    
    public function index()
    {
    	$this->set('title_for_layout', '系统信息管理');
        $this->_useJqGrid();
        $this->_appendJs('notices');
        $this->_appendJs('ckeditor/ckeditor');
        $this->_appendJs('ckfinder/ckfinder');
    }
    
    public function edit()
    {
        $this->autoRender = false;
        switch ($this->request->data['oper']) {
            case 'add':
            	$data = array(
            		'title' => $this->request->data['title'],
            		'display' => $this->request->data['display'],
            	);
            	$data['priority'] = !empty($this->request->data['priority']) ? $this->request->data['priority'] : '1';
            	$data['open'] = !empty($this->request->data['open']) ? $this->request->data['open'] : '';
            	$data['close'] = !empty($this->request->data['close']) ? $this->request->data['close'] : '';
            	$data['parent_id'] = !empty($this->request->data['parent_id']) ? $this->request->data['parent_id'] : 0;
                $this->log(print_r($data, true));
            	$this->Notice->save($data);
            	break;
            case 'edit':
            	$data = $this->request->data;
            	if (isset($data['id']) && !empty($data['id'])) {
            		$this->Notice->save($data);
            	}
                break;
            case 'del':
                break;
        }
    }
    
    public function grid()
    {
        $this->autoRender = false;
        $where = array();
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $this->_alialMap, $where);
        }
        
        $conditions = array(
            'conditions' => $where,
            'fields'     => $this->_aliaAppealMap['Notice'],
            'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
            'limit'      =>  $this->request->query['rows'],
            'page'       =>  $this->request->query['page'],
        );
        $countConditions = array('conditions' => $where);
        $data = $this->Notice->find('all', $conditions);
        $count = $this->Notice->find('count', $countConditions);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        foreach ($data as $value) {
            $row['id'] = $value['Notice']['id'];
            $row['cell'] = array(
                $value['Notice']['id'],
                $value['Notice']['title'],
                $value['Notice']['parent_id'],
                $value['Notice']['priority'],
                $value['Notice']['open'],
                $value['Notice']['close'],
                $value['Notice']['display'],
                $value['Notice']['modified']
            );
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    /**
     * 
     * 获取系统消息的大类
     */
    public function getParents()
    {
    	$conditions = array('parent_id' => 0);
    	$parents = $this->Notice->find('all', array('conditions' => $conditions));
    	$data = array();
    	foreach ($parents as $parent)
    	{
    		$data[] = array('id' => $parent['Notice']['id'], 'title' => $parent['Notice']['title']);
    	}
    	$this->_sendJson($data);
    }
    /**
     * 
     * 获取系统消息的内容
     */
    public function getContent()
    {
    	if (!empty($this->request->data['id'])) {
    		$conditions = array(
    			'id' => $this->request->data['id']
    		);
    		$notices = $this->Notice->find('first', array('conditions' => $conditions));
    		$result = array(
    			'result' => 'OK',
    			'content' => $notices['Notice']['content']
    		);
    	} else {
    		$result = array(
    			'result' => 'NG'
    		);
    	}
    	$this->_sendJson($result);
    }
    /**
     * 
     * 保存系统详细的内容
     */
    public function saveContent()
    {
    	if (!empty($this->request->data['id'])) {
    		$data = $this->request->data;
    		$this->Notice->save($data);
    		$result = array(
    			'result' => 'OK'
    		);
    	} else {
    		$result = array(
    			'result'	=> 'NG',
    			'msg'		=> '数据不完善！'
    		);
    	}
    	$this->_sendJson($result);
    }
    
    public function ckfinder()
    {
        $this->autoLayout = false;
        $this->_appendJs('ckfinder/ckfinder');
    }
}