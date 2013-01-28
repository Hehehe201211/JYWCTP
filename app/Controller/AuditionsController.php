<?php
/**
 * 
 * 简历投递，面试相关
 * @author lin_deping
 *
 */
class AuditionsController extends AppController
{
    var $layout = 'members';
    var $components = array('RequestHandler', 'Unit', 'Recommend');
    var $helpers = array('Js', 'City', 'Category');
    var $uses = array('Audition', 'Fulltime');
    public function listView()
    {
        if ($this->request->query['type'] == "send") {
            $conditions = array(
                'Audition.status' => Configure::read('Audition.status_active'),
                'Audition.sender_delete' => 0
            );
            $this->set('title', '简历投递记录');
            $this->set('title_for_layout', '简历投递记录');
            $this->_listSend($conditions);
        } else {
            $conditions = array(
                'Audition.status' => Configure::read('Audition.status_active'),
                'Audition.receiver_delete' => 0
            );
            $this->set('title', '收到的简历');
            $this->set('title_for_layout', '收到的简历');
            $this->_listReceive(array('Audition.status' => Configure::read('Audition.status_active')));
        }
    }
    /**
     * 
     * 简历投递记录一览
     */
    public function _listSend($conditions = array())
    {
        $joinFulltime = array(
            'table' => 'fulltimes',
            'alias' => 'Fulltime',
            'type'  => 'left',
            'conditions' => 'Fulltime.id = Audition.fulltimes_id'
        );
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'Member.id = Audition.receiver'
        );
        $fields = array(
            'Audition.id',
            'Audition.created',
            'Fulltime.company',
            'Fulltime.post',
            'Fulltime.id',
            'Fulltime.salary',
            'Fulltime.type',
            'Fulltime.provincial',
            'Fulltime.city',
            'Member.company_name'
        );
        $conditions['Audition.sender'] = $this->_memberInfo['Member']['id'];
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'Audition' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('Audition.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinFulltime, $joinMember)
            )
        );
        $this->set("auditions", $this->paginate('Audition'));
        $this->set('pageSize', $pageSize);
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('send-listview-paginate');
        } else {
//            $this->set('title_for_layout', '简历投递记录');
            $this->render('send-listview');
        }
        
    }
    /**
     * 
     * 收到的简历一览
     */
    public function _listReceive($conditions = array())
    {
        $joinResume = array(
            'table' => 'resumes',
            'alias' => 'Resume',
            'type'  => 'left',
            'conditions' => 'Resume.id = Audition.resumes_id'
        );
        $joinResumeBase = array(
            'table' => 'resume_bases',
            'alias' => 'ResumeBase',
            'type'  => 'left',
            'conditions' => 'ResumeBase.members_id = Audition.sender'
        );
        $fields = array(
            'Audition.id',
            'Audition.created',
            'ResumeBase.name',
            'Fulltime.post',
            'Resume.educated',
            'Resume.continued',
            'ResumeBase.provincial_now',
            'ResumeBase.city_now',
        );
        $joinFulltime = array(
            'table' => 'fulltimes',
            'alias' => 'Fulltime',
            'type'  => 'left',
            'conditions' => 'Fulltime.id = Audition.fulltimes_id'
        );
        
        $conditions['Audition.receiver'] = $this->_memberInfo['Member']['id'];
        $pageSize = isset($this->request->data['pageSize']) ? $this->request->data['pageSize'] : Configure::read('Paginate.pageSize');
        $page = isset($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize']) ? $this->request->data['jump'] : 0;
        
        $this->paginate = array(
            'Audition' => array('limit' => $pageSize,
                'page'  => $page,
                'order' => array('Audition.created' => 'DESC'),
                'conditions' => $conditions,
                'fields'    => $fields,
                'joins'     => array($joinResume, $joinResumeBase, $joinFulltime)
            )
        );
        $this->set("auditions", $this->paginate('Audition'));
        $this->set('pageSize', $pageSize);
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('receiver-listview-paginate');
        } else {
//            $this->set('title_for_layout', '收到的简历');
            $this->render('receiver-listview');
        }
    }
    
    public function detail()
    {
        if (isset($this->request->query['type']) && $this->request->query['type'] == "send") {
            $this->_detailSend();
        } else {
            $this->_detailReceive();
        }
    }
    
    public function _detailSend()
    {
        $error = false;
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $joinFulltime = array(
                'table' => 'fulltimes',
                'alias' => 'Fulltime',
                'type'  => 'left',
                'conditions' => 'Fulltime.id = Audition.fulltimes_id'
            );
            $joinMember = array(
                'table' => 'members',
                'alias' => 'Member',
                'type'  => 'inner',
                'conditions' => 'Member.id = Audition.receiver'
            );
            $conditions = array(
                'Audition.sender' => $this->_memberInfo['Member']['id'],
                'Audition.id'       => $this->request->query['id'],
                'Audition.sender_delete'     => 0
            );
            $fields = array('Fulltime.*', 'Audition.*', 'Member.company_name', 'Member.id');
            $params = array(
               'conditions' => $conditions,
               'fields'    => $fields,
               'joins'     => array($joinFulltime, $joinMember)
            );
            $audition = $this->Audition->find('first', $params);
            if (!empty($audition)) {
                $this->set('audition', $audition);
                $this->set('title_for_layout', '面试邀请详情');
            } else {
                $this->set('title_for_layout', '简历投递详情');
                $error = true;
            }
            
        } else {
            $error = true;
        }
        $this->set('error', $error);
        $this->render('fulltime-detail');
    }
    
    public function _detailReceive()
    {
        $error = false;
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $joinResume = array(
	            'table' => 'resumes',
	            'alias' => 'Resume',
	            'type'  => 'left',
	            'conditions' => 'Resume.id = Audition.resumes_id'
	        );
	        $joinResumeBase = array(
	            'table' => 'resume_bases',
	            'alias' => 'ResumeBase',
	            'type'  => 'left',
	            'conditions' => 'ResumeBase.members_id = Audition.sender'
	        );
	        $joinResumeWork = array(
                'table' => 'resume_works',
                'alias' => 'ResumeWork',
                'type'  => 'left',
                'conditions' => 'Resume.id = ResumeWork.resumes_id'
            );
            $joinResumeEdu = array(
                'table' => 'resume_educations',
                'alias' => 'ResumeEducation',
                'type'  => 'left',
                'conditions' => 'Resume.id = ResumeEducation.resumes_id'
            );
            $joinFulltime = array(
	            'table' => 'fulltimes',
	            'alias' => 'Fulltime',
	            'type'  => 'left',
	            'conditions' => 'Fulltime.id = Audition.fulltimes_id'
	        );
            $conditions = array(
	            'Audition.receiver' => $this->_memberInfo['Member']['id'],
                'Audition.id'       => $this->request->query['id'],
                'Audition.receiver_delete' => 0
	        );
	        $fields = array(
	           "Resume.*",
	           "Audition.*",
	           "ResumeBase.*",
	           "ResumeWork.*",
	           "ResumeEducation.*",
	           "Fulltime.post"
	        );
	        $params = array(
	           'conditions' => $conditions,
	           'fields'    => $fields,
	           'joins'     => array($joinResume, $joinResumeBase, $joinResumeEdu, $joinResumeWork, $joinFulltime)
	        );
	        $audition = $this->Audition->find('first', $params);
	        if (!empty($audition)) {
	           $this->set('audition', $audition);
	           $this->set('title_for_layout', '面试邀请详情');
	        } else {
	            $this->set('title_for_layout', '收到的简历详情');
	            $error = true;
	        }
	        
        } else {
            $error = true;
        }
        $this->set('error', $error);
        $this->render('resume-detail');
    }
    
    /**
     * 
     * 个人会员发送简历，应聘职位
     */
    public function addAudition()
    {
        $data = array(
            'sender'        => $this->_memberInfo['Member']['id'],
            'receiver'      => $this->request->data['receiver'],
            'resumes_id'    => $this->request->data['resumes_id'],
            'fulltimes_id'  => $this->request->data['fulltimes_id'],
            'status'        => 1,
        );
        if ($this->Audition->find('count', array('conditions' => $data)) > 0) {
            $result = array(
                'result' => 'NG',
                'msg'    => '你已经投递过此简历，请耐心等待对方回应！'
            );
        } else {
            try {
                $this->Audition->save($data);
                //TODO更新招聘信息的应聘人数，有可能要把这个数据从数据表删除
//                $fulltime =  $this->Fulltime->find('first', array('conditions' => array('id' => $this->request->data['fulltimes_id'])));
//                $up = array('audition_cnt' => ($fulltime['Fulltime']['audition_cnt'] + 1));
//                $this->Fulltime->updateAll($up, array('id' => $this->request->data['fulltimes_id']));
                $result = array(
                    'result'    => 'OK',
                    'msg'       => '投递成功！'
                );
            } catch (Exception $e) {
                $this->log(__CLASS__ . '::' . __FUNCTION__ . '()' . $e->getMessage());
                $result = array(
                    'result'    => 'NG',
                    'msg'       => '系统发生错误，投递失败，请稍后重试！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
    /**
     * 
     * 面试邀请一览
     */
    public function inviteList()
    {
        if ($this->request->query['type'] == "send") {
            $conditions = array(
                'Audition.status' => Configure::read('Audition.status_accept'),
                'Audition.sender_delete' => 0
            );
            $this->set('title', '面试邀请');
            $this->set('title_for_layout', '面试邀请');
            $this->_listSend($conditions);
        } else {
            $conditions = array(
                'Audition.status' => Configure::read('Audition.status_accept'),
                'Audition.receiver_delete' => 0
            );
            $this->set('title', '面试邀请');
            $this->set('title_for_layout', '面试邀请');
            $this->_listReceive($conditions);
        }
    }
    
    /**
     * 
     * 面试邀请删除
     */
    public function delete()
    {
        if (isset($this->request->data['type']) &&
            !empty($this->request->data['type']) &&
            isset($this->request->data['id']) &&
            !empty($this->request->data['id'])
            ) {
                if ($this->request->data['type'] == "send") {
                    $updata = array('sender_delete' => 1);
                    $conditions = array(
                        'id' => $this->request->data['id'],
                        'sender' => $this->_memberInfo['Member']['id']
                    );
                } else {
                    $updata = array('receiver_delete' => 1);
                    $conditions = array(
                        'id' => $this->request->data['id'],
                        'receiver' => $this->_memberInfo['Member']['id']
                    );
                }
                try {
                    $this->Audition->updateAll($updata, $conditions);
                    $result = array(
                        'result' => 'OK'
                    );
                } catch (Exception $e) {
                    $result = array(
                        'result' => 'NG',
                        'msg'   => '系统发生错误，请稍后重试！'
                    );
                }
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '参数错误！'
                );
            }
        $this->_sendJson($result);
    }
    
    /**
     * 
     * 企业会员接受个人会员投递的简历
     */
    public function accept()
    {
        $updata = array(
            'status' => Configure::read('Audition.status_accept'),
            'message' => "'" . $this->request->data['message'] . "'", 
            'modified' => "'" . date('Y-m-d H:i:s', time()) . "'"
        );
        $conditions = array(
            'id'    => $this->request->data['id'],
            'receiver' => $this->_memberInfo['Member']['id'],
            'receiver_delete' => 0
        );
        
        try {
            if ($this->Audition->updateAll($updata, $conditions)) {
                $result = array(
                    'result' => 'OK'
                );
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '次应聘信息不存在！'
                );
            }
        } catch (Exception $e) {
            $this->log($e->getMessage());
            $result = array(
                'result' => 'NG',
                'msg'    => '系统发生错误，请稍后重试！'
            );
        }
        $this->_sendJson($result);
    }
    
    /**
     * 
     * 企业会员发送面试邀请
     */
    public function companySendInvite()
    {
        $data = array(
            'sender'        => $this->request->data['sender'],
            'receiver'      => $this->_memberInfo['Member']['id'],
            'resumes_id'    => $this->request->data['resumes_id'],
            'status'        => 2,
        );
        if (isset($this->request->data['fulltimes_id']) && !empty($this->request->data['fulltimes_id'])) {
            $data['fulltimes_id'] = $this->request->data['fulltimes_id'];
        }
        if ($this->Audition->find('count', array('conditions' => $data)) > 0) {
            $result = array(
                'result' => 'NG',
                'msg'    => '你已经发送给过面试邀请！'
            );
        } else {
            try {
                $data['message'] = $this->request->data['message'];
                $this->Audition->save($data);
                $result = array(
                    'result'    => 'OK',
                    'msg'       => '邀请成功！'
                );
            } catch (Exception $e) {
                $this->log(__CLASS__ . '::' . __FUNCTION__ . '()' . $e->getMessage());
                $result = array(
                    'result'    => 'NG',
                    'msg'       => '系统发生错误，邀请失败，请稍后重试！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
    public function beforeRender()
    {
        $this->currentMenu = Configure::read('Menu.fulltimeManager');
        $css = array(
        'member'
        );
        $js = array('member');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
        //推荐信息
        if (!$this->RequestHandler->isAjax()){
            if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.Personal')) {
                $this->Recommend->parttime($this->_memberInfo['Member']['id'], $this->_memberInfo['Attribute']['category_id']);
            } else {
                ;
            }
        }
    }
}