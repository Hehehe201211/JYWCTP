<?php
class ResumesComponent extends Component
{
    var $name = 'Resume';
    
    public function fulltimeList($conditions, $joins = array())
    {
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $fields = array(
            'id',
            'title',
            'category',
            'city',
            'nature',
            'created',
        );
        if (!empty($joins)) {
            $this->controller->paginate = array(
                'Resume' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('Resume.created' => 'DESC'),
                    'conditions' => $conditions,
                    'fields'    => $fields,
                )
            );
        } else {
            $this->controller->paginate = array(
                'Resume' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('Resume.created' => 'DESC'),
                    'conditions' => $conditions,
                    'joins'      => $joins,
                    'fields'    => $fields,
                )
            );
        }
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("resumes", $this->controller->paginate('Resume'));
    }
    
    public function search($conditions = array())
    {
        $pageSize = isset($this->controller->request->data['pageSize']) ? $this->controller->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->controller->request->data['jump']) && !isset($this->controller->request->params['named']['setPageSize']) ? $this->controller->request->data['jump'] : 0;
        $fields = array(
            'Resume.id',
            'Resume.title',
            'Resume.category',
            'Resume.city',
            'Resume.nature',
            'Resume.modified',
            'Base.name',
            'Base.sex',
            'Education.educated'
        );
        $joinBase = array(
            'table' => 'resume_bases',
            'alias' => 'Base',
            'type'  => 'inner',
            'conditions' => 'Base.members_id = Resume.members_id'
        );
        $joinEdu = array(
            'table' => 'resume_educations',
            'alias' => 'Education',
            'type'  => 'inner',
            'conditions' => 'Education.resumes_id = Resume.id'
        );
//        $joinWork = array(
//            'table' => 'resume_works',
//            'alias' => 'Work',
//            'type'  => 'inner',
//            'conditions' => 'Work.resumes_id = Resume.id'
//        );
        if (!empty($conditions)) {
            $this->controller->paginate = array(
                'Resume' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('Resume.modified' => 'DESC'),
                    'conditions' => $conditions,
                    'joins'      => array($joinBase, $joinEdu),
                    'fields'    => $fields,
                )
            );
        } else {
            $this->controller->paginate = array(
                'Resume' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('Resume.created' => 'DESC'),
                    'joins'      => array($joinBase, $joinEdu),
                    'fields'    => $fields,
                )
            );
        }
        $this->controller->set('pageSize', $pageSize);
        $this->controller->set("resumes", $this->controller->paginate('Resume'));
    }
    
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}