<?php
/**
 * 
 * 系统管理员
 * @author lin_deping
 *
 */
class UsersController extends AppController
{
    public $components = array('Grid');
    protected  $_aliaMap = array(
        'Admin' => array(
            'id',
            'name',
            'email',
            'last'
        ),
        'Group' => array(
            'id',
            'name'
        ),
        'AdminGroup' => array(
            'admin_id',
            'group_id'
        ),
        'Permission' => array(
            'resource_id',
            'group_id',
            '_read',
            '_create',
            '_update',
            '_delete'
        ),
        'Resource' => array(
            'id',
            'name'
        )
    
    );
    public function index()
    {
        $this->_useJqGrid();
        $this->_appendJs('users.js');
    }
    
    public function users()
    {
        $this->uses = array('Admin');
        $this->autoRender = false;
        $where = array();
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $this->_aliaMap, $where);
        }
        $filters = array(
            'conditions'    => $where,
            'fields'        => array('Admin.id', 'Admin.name', 'Admin.email', 'Admin.last'),
            'order'         =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
            'limit'         =>  $this->request->query['rows'],
            'page'          =>  $this->request->query['page']
        );
        $countFilters = array('conditions' => $where);
        $data = $this->Admin->find('all', $filters);
        $count = $this->Admin->find('count', $countFilters);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        $rows = array();
        foreach ($data as $value) {
            $row['id'] = $value['Admin']['id'];
            $row['cell'] = array_values($value['Admin']);
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    public function usergroup()
    {
        $this->autoRender = false;
        $admin_id = !empty($this->request->params['pass']) ? $this->request->params['pass'][0] : "";
        if (empty($admin_id)){
            return ;
        }
        $this->uses = array('AdminGroup', 'Group');
        $joins = array(
            'table' => 'groups',
            'alias' => 'Group',
            'type'  => 'inner',
            'conditions' => 'AdminGroup.group_id = Group.id'
        );
        $filters = array(
            'conditions'    => array('AdminGroup.admin_id' => $admin_id),
            'fields'        => array('Group.id', 'Group.name'),
            'joins'         => array($joins)
            
        );
        $data = $this->AdminGroup->find('all', $filters);
        foreach ($data as $value) {
            $row['id'] = $value['Group']['id'];
            $row['cell'] = array_values($value['Group']);
            $rows[] = $row;
        }
        $jdata = array(
            'page' => "1",
            'total' => count($data),
            'records'=> count($data),
            'rows'  => $rows
        );
        $this->_sendJson($jdata);
    }
    
    public function groups()
    {
        $this->_useJqGrid();
        $this->_appendJs('groups.js');
    }
    
    public function permission()
    {
        
    }
    
    
    /**
     * 
     * Enter description here ...
     */
    public function grouplist()
    {
        $this->uses = array('Group');
        $this->autoRender = false;
        $data = $this->Group->find('all', array('fields' => array('id', 'name')));
        $this->_sendJson($data);
    }
}