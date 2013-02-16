<?php
/**
 * 
 * 资源天地控制器
 * @author deping_lin
 *
 */
class ResourcesController extends AppController
{

    var $uses = array('Document', 'DownloadDocument', 'DocumentComment', 'DocumentCommentOption', 'DocumentFavourite');
    var $components = array('Upload', 'File', 'RequestHandler', 'Unit');
    var $helpers = array('Unit');
    public function index()
    {
        $this->set('title_for_layout', "资源天地");
        $params = array(
            'limit' => 6,
            'order' => array('download_cnt')
        );
        $params['conditions'] = array('type' => 1);
        $ru_men = $this->Document->find('all', $params);
        
        $params['conditions'] = array('type' => 2);
        $pei_xun = $this->Document->find('all', $params);
        
        $params['conditions'] = array('type' => 3);
        $ke_hu = $this->Document->find('all', $params);
        
        $params['conditions'] = array('type' => 4);
        $fang_an = $this->Document->find('all', $params);
        
        $params['conditions'] = array('type' => 5);
        $zong_jie = $this->Document->find('all', $params);
        
        $params['conditions'] = array('type' => 6);
        $an_li = $this->Document->find('all', $params);
        
        $this->set('ru_men', $ru_men);
        $this->set('pei_xun', $pei_xun);
        $this->set('ke_hu', $ke_hu);
        $this->set('fang_an', $fang_an);
        $this->set('zong_jie', $zong_jie);
        $this->set('an_li', $an_li);
    }
    /**
     * 
     * 检索页面
     */
    public function search()
    {
        $this->set('title_for_layout', "资源检索");
        $conditions = array();
        if ($this->request->is('post')) {
            if (isset($this->request->data['type']) && !empty($this->request->data['type'])) {
                $conditions['Document.type'] = $this->request->data['type'];
            }
            if (isset($this->request->data['key_word']) && !empty($this->request->data['key_word'])) {
                $conditions['OR'] = array(
                    'Document.title LIKE ' => "%$this->request->data['type']%", 
                    'Document.key_word LIKE ' => "%$this->request->data['type']%"
                );
            }
        } else {
            if (isset($this->request->query['type']) && !empty($this->request->query['type'])) {
                $conditions['Document.type'] = $this->request->query['type'];
                $this->set('type', $this->request->query['type']);
            }
            if (isset($this->request->query['key_word']) && !empty($this->request->query['key_word'])) {
                $conditions['OR'] = array(
                    'Document.title LIKE ' => "%$this->request->query['type']%", 
                    'Document.key_word LIKE ' => "%$this->request->query['type']%"
                );
                $this->set('key_word', $this->request->query['key_word']);
            }
        }
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'Document.members_id = Member.id'
        );
        $fileds = array(
            'Document.*',
            'Member.id',
            'Member.nickname'
        );
        if (!empty($conditions)) {
            $this->paginate = array(
                'Document' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('Document.created' => 'DESC'),
                    'conditions' => $conditions,
                    'fields'    => $fileds,
                    'joins'        => array($joinMember)
                )
            );
        } else {
            $this->paginate = array(
                'Document' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('Document.created' => 'DESC'),
                    'fields'    => $fileds,
                    'joins'        => array($joinMember)
                )
            );
        }
        
        $this->set('pageSize', $pageSize);
        $this->set("documents", $this->paginate('Document'));
        if ($this->RequestHandler->isAjax()) {
            $this->render('search_paginate');
        }
    }
    /**
     * 
     * 上传页面
     */
    public function upload()
    {
        $this->set('title_for_layout', "资源上传");
        if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.company')) {
            $this->redirect('/resources');
        }
    }
    
    public function download()
    {
        $this->autoRender = FALSE;
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $id = $this->request->query['id'];
            $document = $this->Document->find('first', array('conditions' => array('id' => $id, 'close_flg' => 0)));
            if (!empty($document)) {
                
                $conditions = array(
                    'documents_id' => $id,
                    'download_members_id' => $this->_memberInfo['Member']['id']
                );
                if ($this->_memberInfo['Member']['id'] != $document['Document']['members_id'])
                {
                    if ($this->DownloadDocument->find('count', array('conditions' => $conditions)) == 0) {
                        $data = array(
                            'documents_id' => $id,
                            'upload_members_id' => $document['Document']['members_id'],
                            'download_members_id' => $this->_memberInfo['Member']['id'],
                        );
                        $this->DownloadDocument->save($data);
                        $up = array(
                            'download_cnt' => $document['Document']['download_cnt'] + 1
                        );
                        try {
                            $this->Document->updateAll($up, array('id' => $id));
                        } catch (Exception $e) {
                            $this->log($e->getMessage);
                        }
                        //TODO
                        //积分转移处理
                    }
                }
                $filePath = Configure::read('Data.path') . $document['Document']['path'] . DS . $document['Document']['file_name'];
                $this->File->download($filePath, $document['Document']['file_name']);
            }
        }
    }
    
    public function checkPoint()
    {
        $point = $this->request->data['point'];
        if ($point > $this->_memberInfo['Attribute']['point']) {
            $result = array(
                'result' => 'NG',
                'msg'     => '你的积分不足，请你充值积分之后再下载！'
            );
        } else {
            $result = array(
                'result' => 'OK'
            );
        }
        $this->_sendJson($result);
    }
    
    public function finish()
    {
        $path = "document/" . 
                substr(md5(($this->_memberInfo['Member']['id'] / 30000 + 1)), 0, 10) . "/" . 
                substr(md5($this->_memberInfo['Member']['id']), 0, 10);
        if (!file_exists(Configure::read('Data.path') . $path)) {
            $command = "mkdir -p 0755 " . Configure::read('Data.path') . $path;
            try {
                exec($command);
            } catch (Exception $e) {
                $this->log($e->getMessage());
            }
        }
        $saveData = array();
        foreach ($this->request->data['title'] as $key => $title) {
            $file = array(
                'name'  => $_FILES['file']['name'][$key],
                'size'  => $_FILES['file']['size'][$key],
                'tmp_name' => $_FILES['file']['tmp_name'][$key],
            );
//            var_dump($file);
            $result = $this->Upload->upload($file, Configure::read('Data.path') . $path);
//            var_dump($result);
            if ($result['result'] == 'OK') {
                $data = array(
                    'members_id' => $this->_memberInfo['Member']['id'],
                    'title' => $title,
                    'introduction' => $this->request->data['introduction'][$key],
                    'type'         => $this->request->data['type'][$key],
                    'point'        => $this->request->data['point'][$key],
                    'key_word'      => $this->request->data['keyword'][$key],
                    'pages'        => $this->request->data['pages'][$key],
                    'size'         => $_FILES['file']['size'][$key],
                    'file_name'    => $result['name'],
                    'path'         => $path,
                );
                $saveData[] = $data;
            }
        }
        if (!empty($saveData)) {
            $this->Document->saveAll($saveData);
        }
    }
    
    /**
     * 
     * 预览页面
     */
    public function detail()
    {
        $this->set('title_for_layout', "资源详情");
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            if (!$this->RequestHandler->isAjax()) {
                $id = $this->request->query['id'];
                $joinMember = array(
                    'table' => 'members',
                    'alias' => 'Member',
                    'type'  => 'inner',
                    'conditions' => 'Member.id = Document.members_id'
                );
                $fileds = array(
                    'Document.*',
                    'Member.nickname'
                );
                $params = array(
                    'conditions' => array('Document.id' => $id),
                    'joins'         => array($joinMember),
                    'fields'     => $fileds
                );
                $document = $this->Document->find('first', $params);
                if (!empty($document)) {
                    $this->set('document', $document);
                } else {
                    $msg = "对不起！没有你需要的信息！";
                    $this->_sysDisplayErrorMsg($msg);
                }
                $downloaded = false;
                if (!empty($this->_memberInfo['Member'])) {
                    $conditions = array(
                        'documents_id' => $id,
                        'download_members_id' => $this->_memberInfo['Member']['id']
                    );
                    if ($this->DownloadDocument->find('count', array('conditions' => $conditions)) > 0) {
                        $downloaded = true;
                    }
                }
                $this->set('downloaded', $downloaded);
                //评论
                $this->comments();
                
                //是否已经收藏
                $isFavourite = false;
                $conditions = array(
                    'members_id' => $this->_memberInfo['Member']['id'],
                    'documents_id' => $id
                );
                if ($this->DocumentFavourite->find('count', array('conditions' => $conditions)) > 0) {
                    $isFavourite = true;
                }
                $this->set('isFavourite', $isFavourite);
            } else {
                //评论
                $this->comments();
                $this->render('comment_paginate');
            }
            
        } else {
            $msg = "对不起！没有你需要的信息！";
            $this->_sysDisplayErrorMsg($msg);
        }
    }
    
    public function comments()
    {
        $conditions = array(
            'documents_id' => $this->request->query['id']
        );
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'DocumentComment.members_id = Member.id'
        );
        $joinMemberAttribute = array(
            'table' => 'member_attributes',
            'alias' => 'Attribute',
            'type'  => 'inner',
            'conditions' => 'Attribute.members_id = Member.id'
        );
        $joinOption = array(
            'table' => 'document_comment_options',
            'alias' => 'Option',
            'type'  => 'left',
            'conditions' => 'Option.document_comments_id = DocumentComment.id'
        );
        $joinArray = array($joinMember, $joinMemberAttribute);
        $fields = array(
            'DocumentComment.*',
            'Member.nickname',
            'Member.id',
            'Attribute.thumbnail'
        );
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['grade'] == 2) {
            $joinArray[] = $joinOption;
            $fields[] = 'Option.option';
        }
        
        $this->paginate = array(
            'DocumentComment' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('DocumentComment.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => $joinArray
            )
        );
        $this->set('pageSize', $pageSize);
        $this->set("comments", $this->paginate('DocumentComment'));
    }
    /**
     * 
     * 用户针对某条评论，发表支持还是反对意见
     */
    public function support()
    {
        if (!isset($this->request->data['comments_id'])
            || empty($this->request->data['comments_id'])
            || !isset($this->request->data['option'])
            || trim($this->request->data['option'], ' ') == ""){
            
            $result = array(
                'result' => 'NG',
                'msg'     => '数据不完善！'
            );
        } else {
            $comment = $this->DocumentComment->find('first', array('conditions' => array('id' => $this->request->data['comments_id'])));
            if (!empty($comment)) {
                $conditions = array(
                    'members_id' => $this->_memberInfo['Member']['id'],
                    'document_comments_id' => $this->request->data['comments_id']
                );
                if ($this->DocumentCommentOption->find('count', array('conditions' => $conditions)) > 0) {
                    $result = array(
                        'result' => 'NG',
                        'msg'     => '不能重复发表意见！'
                    );
                } else {
                    $conditions['option'] = $this->request->data['option'];
                    if ($this->DocumentCommentOption->save($conditions)) {
                        if ($this->request->data['option'] == 1) {
                            $up = array(
                                'support' => $comment['DocumentComment']['support'] + 1
                            );
                        } else {
                            $up = array(
                                'opposition' => $comment['DocumentComment']['opposition'] + 1
                            );
                        }
                        $conditions = array('id' => $this->request->data['comments_id']);
                        try {
                            $this->DocumentComment->updateAll($up, $conditions);
                        } catch (Exception $e) {
                            $this->log(__CLASS__ . "::" . __FUNCTION__ . "() :" . $e->getMessage());
                        }
                        
                        $result = array(
                            'result' => 'OK',
                        );
                    } else {
                        $result = array(
                            'result' => 'NG',
                            'msg'      => '系统出错，请稍后重试！'
                        );
                    }
                }
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'      => '评论信息不存在！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
    public function addComment()
    {
        if (isset($this->request->data['documents_id'])
            && !empty($this->request->data['documents_id'])
            && isset($this->request->data['comment'])
            && !empty($this->request->data['comment'])
        ) {
            $data = array(
                'documents_id' => $this->request->data['documents_id'],
                'comment'       => $this->request->data['comment'],
                'members_id'   => $this->_memberInfo['Member']['id']
            );
            if ($this->DocumentComment->save($data)) {
                $result = array(
                    'result' => 'OK',
                    'name'      => $this->_memberInfo['Member']['nickname'],
                    'id'     => $this->DocumentComment->id,
                    'thumbnail' => empty($this->_memberInfo['Attribute']['thumbnail']) ? '/img/tx.jpg' : '/' . $this->_memberInfo['Attribute']['thumbnail']
                );
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'     => '对不起，系统出错，请稍后再试！'
                );
            }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'     => '提交数据不规范，请完善！'
            );
        }
        $this->_sendJson($result);
    }
    
    /**
     * 
     * 一览表
     * 其他会员发布的一览表
     * 如果不带会员ID参数则默认是自己的
     * 发布一栏
     */
    public function listview()
    {
        $this->set('title_for_layout', "资源一栏");
        $conditions = array();
        if (isset($this->request->query['mid']) && !empty($this->request->query['mid'])) {
            $conditions['members_id'] = $this->request->query['mid'];
        } elseif (!empty($this->_memberInfo)) {
            $conditions['members_id'] = $this->_memberInfo['Member']['id'];
        }
        if (!empty($conditions)) {
            $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
            $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
            
            $this->paginate = array(
                'Document' => array('limit' => $pageSize,
                    'page'  => $page,
                    'order' => array('Document.created' => 'DESC'),
                    'conditions' => $conditions,
                )
            );
            $this->set('pageSize', $pageSize);
            $this->set("documents", $this->paginate('Document'));
            if ($this->RequestHandler->isAjax()) {
                $this->render('listview_paginate');
            }
        } else {
            $this->set("documents", array());
        }
    }
    
    public function favorite()
    {
        if (!isset($this->request->data['documents_id'])
        || empty($this->request->data['documents_id'])
        || !isset($this->request->data['action'])
        || empty($this->request->data['action'])
        ) {
            $result = array(
                'result' => 'NG',
                'msg'     => '数据不完善，保存失败！'
            );
        } else {
            $document = $this->Document->find('first', array('conditions' => array('id' => $this->request->data['documents_id'])));
            if (empty($this->_memberInfo)) {
                $result = array(
                    'result' => 'login',
                    'msg'     => '你没有登陆系统，请登陆！'
                );
            } elseif (!empty($document)) {
                if ($this->request->data['action'] == 'add') {
                    $data = array(
                        'documents_id' => $this->request->data['documents_id'],
                        'members_id'   => $this->_memberInfo['Member']['id']
                    );
                    if ($this->DocumentFavourite->save($data)) {
                        $result = array(
                            'result' => 'OK',
                        );
                    } else {
                        $result = array(
                            'result' => 'NG',
                            'msg'     => '系统出错，请稍后重试！'
                        );
                    }
                } elseif ($this->request->data['action'] == 'del'){
                    $conditions = array(
                        'documents_id'    => $this->request->data['documents_id'],
                        'members_id'    => $this->_memberInfo['Member']['id']
                    );
                    if ($this->DocumentFavourite->deleteAll($conditions)) {
                        $result = array(
                            'result' => 'OK',
                        );
                    } else {
                        $result = array(
                            'result' => 'NG',
                            'msg'     => '系统出错，请稍后重试！'
                        );
                    }
                } else {
                    $result = array(
                        'result' => 'NG',
                        'msg'     => '你没有权限操作此动作！'
                    );
                }
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'     => '没有你要收藏的资源对象！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
    /**
     * 
     * 最近上传
     */
    public function _getNew()
    {
        $params = array(
            'conditions' => array('members_id' => $this->_memberInfo['Member']['id']),
            'order' => array('Document.created'),
            'limit' => 6
        );
        $newUploads = $this->Document->find('all', $params);
        $this->set('newUploads', $newUploads);
    }
    /**
     * 
     * 热门资源
     */
    public function _getHots()
    {
        $param = array(
            'order' => array('download_cnt'),
            'limit' => 6
        );
        $hots = $this->Document->find('all', $param);
        $this->set('hots', $hots);
    }
    /**
     * 
     * 收藏
     */
    public function getFavourites()
    {
        $pageSize = 2;
        $page = isset($this->request->data['page']) ? $this->request->data['page'] : 1;
        $joinDocument = array(
            'table' => 'documents',
            'alias' => 'Document',
            'type'  => 'inner',
            'conditions' => 'Document.id = DocumentFavourite.documents_id'
        );
        $fields = array(
            'Document.id',
            'Document.title'
        );
        $params = array(
            'conditions'=> array('DocumentFavourite.members_id' => $this->_memberInfo['Member']['id']),
            'limit' => $pageSize,
            'page'    => $page,
            'order' => array('DocumentFavourite.created' => 'DESC'),
            'fields' => $fields,
            'joins' => array($joinDocument)
        );
        $favourites = $this->DocumentFavourite->find('all', $params);
        $this->set('favourites', $favourites);
        $conditions = array('DocumentFavourite.members_id' => $this->_memberInfo['Member']['id']);
        $cnt = $this->DocumentFavourite->find('count', array('conditions' => $conditions));
        $hasPrev = $page > 1 ? true : false;
        $hasNext = $cnt / $pageSize > ($page) ? true : false;
        $this->set('favouriteCnt', $cnt);
        $this->set('hasPrev', $hasPrev);
        $this->set('hasNext', $hasNext);
        $this->set('page', $page);
        if ($this->RequestHandler->isAjax()) {
            $this->render('favourite_paginate');
        }
    }
    /**
     * 
     * 用户下载文档数
     */
    public function _getDownloadCnt()
    {
        $conditions = array(
            'download_members_id' => $this->_memberInfo['Member']['id']
        );
        $downloadCnt = $this->DownloadDocument->find('count', array('conditions' => $conditions));
        $this->set('download_cnt', $downloadCnt);
    }
    /**
     * 
     * 用户上传文档数
     */
    public function _getUploadCnt()
    {
        $conditions = array(
            'members_id' => $this->_memberInfo['Member']['id'],
        );
        $uploadCnt = $this->Document->find('count', array('conditions' =>$conditions));
        $this->set('upload_cnt', $uploadCnt);
    }
    
    public function beforeRender()
    {
        $css = array(
            'common',
            'platform',
        );
        $js = array('platform', 'jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        $this->set('currentTopBar', 'resource');
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['grade'] == 2 && !$this->RequestHandler->isAjax()) {
            //高级会员并且有登陆的情况
            $this->getFavourites();
            $this->_getDownloadCnt();
            $this->_getUploadCnt();
            $this->_getNew();
        }
        if (!$this->RequestHandler->isAjax()) {
            $this->_getHots();
        }
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
    }
    
    public function beforeFilter()
    {
        parent::beforeFilter();
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['type'] == Configure::read('UserType.company')){
            $this->redirect('/members');
        }
    }
}