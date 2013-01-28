<?php
/**
 * 
 * 系统通知相关信息控制器
 * @author lin_deping
 *
 */
class NoticesController extends AppController
{
    var $helpers = array('Js');
    var $components = array('RequestHandler', 'Unit');
    public function listview()
    {
        $this->set('title_for_layout', "系统信息");
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        $conditions = array('parent_id > ' => 0);
        if (isset($this->request->query['pid']) && !empty($this->request->query['pid'])) {
            $conditions['parent_id'] = $this->request->query['pid'];
        }
        if (isset($this->request->data['keyword']) && !empty($this->request->data['keyword'])) {
            $keyword = $this->request->data['keyword'];
            $conditions['OR'] = array(
                'title LIKE ' => "%$keyword%",
                'content LIKE ' => "%$keyword%"
            );
        }
        $this->paginate = array(
            'Notice' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('Notice.created' => 'DESC'),
                'conditions' => $conditions,
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("notices", $this->paginate('Notice'));
        if ($this->RequestHandler->isAjax()) {
            $this->render('paginator');
        }
    }
    
    public function detail()
    {
        $this->set('title_for_layout', "系统信息详情");
        if (!isset($this->request->query['id']) || empty($this->request->query['id'])) {
            
        } else {
            $now = date('Y-m-d');
            $conditions = array(
                'id' => $this->request->query['id'],
                'display'   => 1,
                'open <= ' => $now,
                'close >= ' => $now 
            );
            $notice = $this->Notice->find('first', array('conditions' => $conditions));
            $this->set('notice', $notice);
            $this->_makePrevNext($notice['Notice']['parent_id'], $this->request->query['id']);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param id $pid
     * @param id $current
     */
    public function _makePrevNext($pid, $current)
    {
        $now = date('Y-m-d');
        $conditions = array(
            'parent_id' => $pid,
            'display'   => 1,
            'open <= ' => $now,
            'close >= ' => $now
        );
        $notices = $this->Notice->find('all', array('conditions' => $conditions, 'order' => array('id')));
        $prev = '';
        $next = '';
        foreach ($notices as $key => $notice) {
            if ($notice['Notice']['id'] == $current) {
                if ($key+1 < count($notices)) {
                    $next = $notices[$key+1]['Notice'];
                    break;
                }
            } else {
                $prev = $notices[$key]['Notice'];
            }
        }
        $this->set('prev', $prev);
        $this->set('next', $next);
    }
    
    public function _getParentList()
    {
        $conditions = array(
            'parent_id' => 0,
            'display'   => 1
        );
        $parents = $this->Notice->find('all', array('conditions' => $conditions, 'order' => array('priority ASC')));
        $this->set('noticeParents', $parents);
    }
    
    public function beforeRender()
    {
        $this->_getParentList();
        $css = array(
	        'common',
	        'platform',
        );
        $js = array(
            'platform',
        );
        $this->currentTopBar = 'static';
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //系统信息
//        $notices = $this->Unit->notice();
//        $this->set('notices', $notices);
    }
}