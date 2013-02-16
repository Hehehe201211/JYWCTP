<?php

class FulltimesController extends AppController
{
    var $layout = 'members';
    var $uses = array('Fulltime', 'FulltimeFavourite', 'Homepage');
    var $components = array('RequestHandler', 'Ft', 'Unit', 'Recommend');
    var $helpers = array('Js', 'City', 'Category');
    public function create()
    {
        $this->set('title_for_layout', "发布招聘");
    }
    
    public function edit()
    {
        $this->set('title_for_layout', "招聘信息修改");
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $conditions = array(
                'id'            => $this->request->query['id'],
                'members_id'    => $this->_memberInfo['Member']['id']
            );
            $fulltime = $this->Fulltime->find('first', array('conditions' => $conditions));
            if (!empty($fulltime)) {
                $this->set('fulltime', $fulltime);
            } else {
                $this->_sysDisplayErrorMsg('没有你可以编辑的对象');
            }
        } else {
            $this->_sysDisplayErrorMsg('没有你可以编辑的对象');
        }
    }
    
    public function check()
    {
        $this->set('title_for_layout', "发布招聘确认");
        switch ($this->request->data['continued']) {
            case 1:
                $continued = '1年以内';
                break;
            case 2:
                $continued = '1-2年';
                break;
            case 3:
                $continued = '2-3年';
                break;
            case 4:
                $continued = '3年以上';
                break;
            default:
                $continued = '不限';
            break;
        }
        $educateds = Configure::read('Fulltime.educated');
        $educated = $educateds[$this->request->data['educated']];
        $this->set('continued', $continued);
        $this->set('educated', $educated);
    }
    
    public function complete()
    {
        $data = array(
            'members_id'    => $this->_memberInfo['Member']['id'],
            'title'         => $this->request->data['title'],
            'post'          => $this->request->data['post'],
            'company'       => $this->request->data['company'],
            'type'          => $this->request->data['type'],
            'begin'         => $this->request->data['begin'],
            'end'           => $this->request->data['end'],
            'number'        => $this->request->data['number'],
            'category'      => $this->request->data['category'],
            'provincial'    => $this->request->data['provincial'],
            'city'          => $this->request->data['city'],
            'contact'       => $this->request->data['contact'],
            'educated'      => $this->request->data['educated'],
            'continued'     => $this->request->data['continued'],
            'sex'           => $this->request->data['sex'],
            'salary'        => $this->request->data['salary'],
            'treatment'     => $this->request->data['treatment'],
            'require'       => $this->request->data['require'],
            'additional'    => $this->request->data['additional']
        );
        $method = array();
        foreach ($this->request->data['method'] as $key => $value) {
            $method[]= array('method' => $value, 'number' => $this->request->data['method_number'][$key]);
        }
        $data['contact_method'] = json_encode($method);
        try {
            if (isset($this->request->data['id'])) {
                $data['id'] = $this->request->data['id'];
            }
            $this->Fulltime->save($data);
            $this->redirect('/fulltimes/listview');
        } catch (Exception $e) {
            $this->log(__CLASS__ . '::' . __FUNCTION__ . '() :' . $e->getMessage());
        }
    }
    
    public function search()
    {
        $this->set('title_for_layout', "我要工作");
        if (!$this->RequestHandler->isAjax()) {
            $js = array('retrieval');
            $css = array(
		        'common'
	        );
	        $this->_appendCss($css);
            $this->_appendJs($js);
            $this->Ft->fulltimeList();
        } else {
            //检索条件
            $conditions = array();
            if (isset($this->request->data['citys'])) {
                $or = array();
                foreach ($this->request->data['citys'] as $city) {
                    $or[] = array('Fulltime.city LIKE' => "%$city%");
                }
                $conditions['OR'] = $or;
            }
            if (isset($this->request->data['categorys'])) {
                $or = array();
               foreach ($this->request->data['categorys'] as $category) {
                    $or[] = array('Fulltime.category LIKE' => "%$category%");
                }
                $conditions['AND'] = array(array('OR' => $or));
            }
            if (isset($this->request->data['continued']) && !empty($this->request->data['continued'])) {
                $conditions['Fulltime.continued'] = $this->request->data['continued'];
                switch ($this->request->data['continued']) {
                    case '0-1':
                        $conditions['Fulltime.continued'] = 1;
                        break;
                    case '1-2':
                        $conditions['Fulltime.continued'] = 2;
                        break;
                    case '2-3':
                        $conditions['Fulltime.continued'] = 3;
                        break;
                    case '4-':
                        $conditions['Fulltime.continued'] = 4;
                        break;
                }
            }
            if (isset($this->request->data['type']) && !empty($this->request->data['type'])) {
                $conditions['Fulltime.type'] = $this->request->data['type'];
            }
            if (isset($this->request->data['created'])) {
                $limitTime = $this->request->data['created'];
                if ($limitTime === '0') {
                    $conditions['DATE_FORMAT(Fulltime.created, "%Y-%m-%d")'] = date('Y-m-d', time());
                } elseif ($limitTime !== "") {
                    $conditions['DATE_FORMAT(Fulltime.created, "%Y-%m-%d") > '] = date('Y-m-d', strtotime("-$limitTime day"));
                }
            }
            if (isset($this->request->data['educated']) && !empty($this->request->data['educated'])) {
                $conditions['Fulltime.educated >='] = $this->request->data['educated'];
            }
            if (isset($this->request->data['salary']) && !empty($this->request->data['salary'])) {
                list($min, $max) = explode('-', $this->request->data['salary']);
                if (empty($max)) {
                    $conditions['Fulltime.salary >='] = $min;
                } else {
                    $conditions['Fulltime.salary between ? and ?'] = array($min, $max);
                }
            }
            $this->Ft->fulltimeList($conditions);
            $this->render('search-paginate');
            $this->Fulltime->printLog();
        }
    }
    
    public function detail()
    {
        $this->set('title_for_layout', "职位信息详情");
        $showFavourite = 'no';
        $isAuthor = false;
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $fulltime = $this->Fulltime->find('first', array('conditions' => array('id' => $this->request->query['id'])));
            if ($fulltime['Fulltime']['members_id'] != $this->_memberInfo['Member']['id']) {
                //TODO
                //如果不是本人发布的职位，这个时候就要显示发布人的信息
//                $author = $this->Member->find();
                $conditions = array(
                    'members_id' => $this->_memberInfo['Member']['id'],
                    'fulltimes_id' => $this->request->query['id']
                );
                if ($this->FulltimeFavourite->find('count', array('conditions' => $conditions)) > 0) {
                    $showFavourite = 'delete';
                } else {
                    $showFavourite = 'add';
                }
                $conditions = array('members_id' => $fulltime['Fulltime']['members_id']);
		        $homepage = $this->Homepage->find('first',array('conditions' => $conditions, 'fields' => array('domain')));
		        $this->set('homepage', $homepage);
            } else {
                $showFavourite = 'no';
                $isAuthor = true;
            }
        } else {
            $fulltime = array();
        }
        $this->set('showFavourite', $showFavourite);
        $this->set('isAuthor', $isAuthor);
        $this->set('fulltime', $fulltime);
    }
    /**
     * 
     * 添加职位到收藏夹
     */
    public function addFavourite()
    {
        $data = array(
            'members_id' => $this->_memberInfo['Member']['id'],
            'fulltimes_id' => $this->request->data['fulltimes_id']
        );
        if ($this->FulltimeFavourite->find('count', array('conditions' => $data)) > 0) {
            $result = array(
                'result' => 'OK',
                'msg'    => '此职位已经添加到收藏夹'
            );
        } else {
            try {
                $this->FulltimeFavourite->save($data);
                $result = array(
                    'result' => 'OK',
                    'msg'    => '成功添加到收藏夹！'
                );
            } catch (Exception $e) {
                $this->log($e->getMessage());
                $result = array(
                    'result'    => 'NG',
                    'msg'       => '系统发生错误，请稍后重试！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
    /**
     * 
     * 删除收藏夹
     */
    public function delFavourite()
    {
        $data = array(
            'members_id' => $this->_memberInfo['Member']['id'],
            'fulltimes_id' => $this->request->data['fulltimes_id']
        );
        if ($this->FulltimeFavourite->find('count', array('conditions' => $data)) == 0) {
            $result = array(
                'result' => 'OK',
                'msg'    => '此职位已经删除'
            );
        } else {
            try {
                $this->FulltimeFavourite->deleteAll($data);
                $result = array(
                    'result' => 'OK',
                    'msg'    => '成功删除！'
                );
            } catch (Exception $e) {
                $this->log($e->getMessage());
                $result = array(
                    'result'    => 'NG',
                    'msg'       => '系统发生错误，请稍后重试！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
    public function delete()
    {
        $conditions = array(
            'id'    => $this->request->data['id'],
            'members_id' => $this->_memberInfo['Member']['id']
        );
        $data = array('delete_flg' => 1);
        try {
            $this->Fulltime->updateAll($data, $conditions);
            $result = array(
                'result' => 'OK',
                'msg'    => '成功删除！'
            );
        } catch (Exception $e) {
            $this->log($e->getMessage());
            $result = array(
                'result'    => 'NG',
                'msg'       => '系统发生错误，请稍后重试！'
            );
        }
        $this->_sendJson($result);
    }
    
    public function favouriteList()
    {
        $joinFulltime = array(
            'table' => 'fulltimes',
            'alias' => 'Fulltime',
            'type'  => 'inner',
            'conditions' => 'Fulltime.id = FulltimeFavourite.fulltimes_id'
        );
        $fields = array(
            'FulltimeFavourite.created',
            'Fulltime.company',
            'Fulltime.post',
            'Fulltime.id',
            'Fulltime.type',
            'Fulltime.provincial',
            'Fulltime.city'
        );
        $conditions = array(
            'FulltimeFavourite.members_id' => $this->_memberInfo['Member']['id']
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'FulltimeFavourite' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('FulltimeFavourite.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinFulltime)
            )
        );
        $this->set("favourites", $this->paginate('FulltimeFavourite'));
        $this->set('pageSize', $pageSize);
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('favourite-paginate');
        }
    }
    
    
    public function listview()
    {
        $conditions = array('Fulltime.members_id' => $this->_memberInfo['Member']['id'], 'Fulltime.delete_flg' => 0);
        $this->Ft->fulltimeList($conditions);
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('listview-paginate');
        } else {
            $this->set('title_for_layout', "职位管理");
        }
    }
    
    public function beforeRender()
    {
        $this->currentMenu = Configure::read('Menu.fulltimeManager');
        $css = array(
        'ui/jquery-ui',
        'member'
        );
        $js = array('member', 'jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //推荐信息
        if (!$this->RequestHandler->isAjax()){
            //系统信息
	        $notices = $this->Unit->notice();
	        $this->set('notices', $notices);
            if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.Personal')) {
                $this->Recommend->parttime($this->_memberInfo['Member']['id'], $this->_memberInfo['Attribute']['category_id']);
                //提示各种信息所处各种状态
                $this->Recommend->PersonNoticeCount($this->_memberInfo['Member']['id']);
            } else {
                //提示各种信息所处各种状态
                $this->Recommend->CompanyNoticeCount($this->_memberInfo['Member']['id']);
            }
        }
    }
}