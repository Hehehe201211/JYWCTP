<?php
/**
 * 
 * 招聘相关信息
 * @author lin_deping
 *
 */
class FtComponent extends Component
{
    var $name = 'Ft';
    
    
    public function fulltimeList($conditions = array(), $joins = array())
    {
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $fields = array(
            'id',
            'post',
            'company',
            'modified',
            'provincial',
            'city',
            'salary',
            'educated',
            'continued',
            'require',
            'category',
            'type',
            'number',
            'modified'
        );
        if (!empty($joins)) {
	        $this->controller->paginate = array(
	            'Fulltime' => array('limit' => $pageSize,
	                'page'  => $page,
	                'order' => array('Fulltime.created' => 'DESC'),
	                'conditions' => $conditions,
	                'fields'    => $fields,
	            )
	        );
        } else {
            $this->controller->paginate = array(
                'Fulltime' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('Fulltime.created' => 'DESC'),
                    'conditions' => $conditions,
                    'joins'      => $joins,
                    'fields'    => $fields,
                )
            );
        }
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("fulltimes", $this->controller->paginate('Fulltime'));
    }
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}