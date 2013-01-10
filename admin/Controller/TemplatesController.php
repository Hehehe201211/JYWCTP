<?php
class TemplatesController extends AppController
{
//    var $uses = array('Template');
    var $helpers = array('Fck');
    public $components = array('Grid');
    var $_aliaMap = array(
        'Template' => array(
            'id',
            'name',
            'alias',
            'category',
            'parent_menu',
            'menu',
            'url',
            'display',
            'modified'
        )
    );
    
    
    public function index()
    {
        $this->_useJqGrid();
        $this->_appendJs('template');
        $this->_appendJs('ckeditor/ckeditor');
        $this->_appendJs('ckfinder/ckfinder');
        $this->set('showIFrame', true);
    }
    
    public function templateGrid()
    {
        $this->autoRender = false;
        $where = array();
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $this->_aliaMap, $where);
        }
        $filters = array(
            'conditions'    => $where,
            'fields'        => $this->_aliaMap['Template'],
            'order'         =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
            'limit'         =>  $this->request->query['rows'],
            'page'          =>  $this->request->query['page']
        );
        $countFilters = array('conditions' => $where);
        $data = $this->Template->find('all', $filters);
        $count = $this->Template->find('count', $countFilters);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count / $this->request->query['rows'];
        $jdata['records'] = count($data);
        $rows = array();
        foreach ($data as $value) {
            $row['id'] = $value['Template']['id'];
            $row['cell'] = array_values($value['Template']);
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    public function templateEdit()
    {
        $this->autoRender = false;
        switch ($this->request->data['oper']){
            case 'add':
                $data = $this->request->data;
                $this->Template->save($data);
                break;
            case 'edit':
                $data = $this->request->data;
                $this->Template->save($data);
                break;
            case 'del':
                $this->Template->delete($this->request->data['id']);
                break;
        }
    }
    
    
    public function check()
    {
        $this->uses = array('TemplateTmp');
        $conditions = array(
            'templates_id' => $this->request->data['templates_id']
        );
        if ($this->TemplateTmp->find('count', array('conditions' => $conditions)) > 0) {
            $up_data = array(
                'content' => "'" . htmlspecialchars($this->request->data['content'], ENT_QUOTES) . "'"
            );
            if ($this->TemplateTmp->updateAll($up_data, $conditions)) {
                $result = array(
                    'result' => 'OK',
                );
            } else {
                $result = array(
                    'result' => 'NG',
                );
            }
        } else {
            $data = array(
                'templates_id'  => $this->request->data['templates_id'],
                'content'       => "'" . htmlspecialchars($this->request->data['content'], ENT_QUOTES) . "'"
            );
            if ($this->TemplateTmp->save($data)) {
                $result = array(
                    'result' => 'OK',
                );
            } else {
                $result = array(
                    'result' => 'NG',
                );
            }
        }
        $this->_sendJson($result);
    }
    
    public function getContent()
    {
        $this->uses = array('TemplateTmp');
        $templates_id = isset($this->request->data['templates_id']) ? $this->request->data['templates_id'] : 0;
        if (!empty($templates_id)) {
            $content = $this->TemplateTmp->find('first', array('conditions' => array('templates_id' => $templates_id)));
            $result = array(
                'result' => 'OK',
                'content' => trim(htmlspecialchars_decode($content['TemplateTmp']['content'], ENT_QUOTES), "'")
            );
        } else {
            $result = array(
                'result' => 'NG'
            );
        }
        $this->_sendJson($result);
    }
    
    
    public function complete()
    {
        $this->uses = array('TemplateTmp', 'Template');
        $templates_id = isset($this->request->data['templates_id']) ? $this->request->data['templates_id'] : 0;
        if (!empty($templates_id)) {
            $content = $this->TemplateTmp->find('first', array('conditions' => array('templates_id' => $templates_id)));
            $conditions = array('id' => $templates_id);
            $up_data = array('content' => "'" . $content['TemplateTmp']['content'] . "'");
            if ($this->Template->updateAll($up_data, $conditions)) {
                $result = array(
                    'result' => 'OK',
                );
            } else {
                $result = array(
                    'result' => 'NG',
                );
            }
        } else {
            $result = array(
                'result' => 'NG'
            );
        }
        $this->_sendJson($result);
    }
    
    public function ckfinder()
    {
        $this->autoLayout = false;
        $this->_appendJs('ckfinder/ckfinder');
    }
    
    public function notice()
    {
        
    }
    
    public function noticeGrid()
    {
        
    }
    
    public function noticeEdit()
    {
        
    }
    
}