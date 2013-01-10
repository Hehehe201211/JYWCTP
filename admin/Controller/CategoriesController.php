<?php
/**
 * 分类管理控制器
 */

App::import("Lib", "UpDownFile");
class CategoriesController extends AppController
{
    public $components = array('Grid');
    protected  $_aliaMap = array(
        'Category' => array(
            'id',
            'parent',
            'name',
            'priority',
            'display',
            'modified'
        )
    );
    public function index()
    {
        $this->_useJqGrid();
        $this->_appendJs('category.js');
    }
    /**
     * 
     * 一级分类
     */
    public function father()
    {
        $this->autoRender = false;
        $where = array('Category.parent = ' => 0);
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $this->_aliaMap, $where);
        }
        $filters = array(
            'conditions'    => $where,
            'fields'        => $this->_aliaMap['Category'],
            'order'         =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
            'limit'         =>  $this->request->query['rows'],
            'page'          =>  $this->request->query['page']
        );
        $countFilters = array('conditions' => $where);
        $data = $this->Category->find('all', $filters);
        $count = $this->Category->find('count', $countFilters);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        $rows = array();
        foreach ($data as $value) {
            $row['id'] = $value['Category']['id'];
            unset($value['Category']['parent']);
            $row['cell'] = array_values($value['Category']);
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    /**
     * 
     * 二级分类
     * @param int $parent_id
     */
    public function child($parent_id)
    {
        $this->autoRender = false;
        if (empty($parent_id)){
            return ;
        }
        $where = array('Category.parent = ' => $parent_id);
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $this->_aliaMap, $where);
        }
        $filters = array(
            'conditions'    => $where,
            'fields'        => $this->_aliaMap['Category'],
            'order'         =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
            'limit'         =>  $this->request->query['rows'],
            'page'          =>  $this->request->query['page']
        );
        $countFilters = array('conditions' => $where);
        $data = $this->Category->find('all', $filters);
        $count = $this->Category->find('count', $countFilters);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        $rows = array();
        foreach ($data as $value) {
            $row['id'] = $value['Category']['id'];
            unset($value['Category']['parent']);
            $row['cell'] = array_values($value['Category']);
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    public function fatheredit()
    {
        $this->autoRender = false;
        switch ($this->request->data['oper']){
            case 'add':
                $data = array(
                    'name' => $this->request->data['name'],
                    'priority' => $this->request->data['priority'],
                    'display' => $this->request->data['display']
                );
                $this->Category->save($data);
                break;
            case 'edit':
                $data = array(
                    'id'   => $this->request->data['id'],
                    'name' => $this->request->data['name'],
                    'priority' => $this->request->data['priority'],
                    'display' => $this->request->data['display']
                );
                $this->Category->save($data);
                break;
            case 'del':
                $this->Category->delete($this->request->data['id']);
                break;
        }
    }
    
    public function childedit()
    {
        $this->autoRender = false;
        switch ($this->request->data['oper']) {
            case 'add':
                $data = array(
                    'parent' => $this->request->data['parent_id'],
                    'name' => $this->request->data['name'],
                    'priority' => $this->request->data['priority'],
                    'display' => $this->request->data['display']
                );
                $this->Category->save($data);
                break;
            case 'edit':
                $data = array(
                    'id' => $this->request->data['id'],
                    'name' => $this->request->data['name'],
                    'priority' => $this->request->data['priority'],
                    'display' => $this->request->data['display']
                );
                $this->Category->save($data);
                break;
            case 'del':
                $this->Category->delete($this->request->data['id']);
                break;
        }
    }
    
    public function upload()
    {
        $this->_useJqGrid();
        $this->_appendJs('category.js');
        $filePath = "../tmp/data/uploads/cms/categories/";
        if (!is_dir($filePath)) {
            mkdir($filePath, '0664', true);
        }
        $fileName = date("Y-m-d H-i-s", $_SERVER['REQUEST_TIME']) . "." . $_FILES['file']['name'];
        $maxSize = 2048;
        $message = UpDownFile::upload("file", $filePath, $maxSize, $fileName, ".tsv");
        if (empty($message)) {
            $this->Category->saveCategoryFromFile($filePath . $fileName);
        } else {
            $this->set("error", $message);
        }
    }
}