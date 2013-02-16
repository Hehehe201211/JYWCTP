<?php
/**
 * 
 * 简历相关
 * @author deping_lin
 *
 */
class ResumesController extends AppController
{
    var $layout = 'members';
    var $helpers = array('Js', 'City', 'Category');
    var $uses = array('ResumeBase', 'Resume', 'ResumeWork', 'ResumeEducation', 'Fulltime', 'MemberAttribute');
    var $components = array('RequestHandler', 'Resumes', 'Unit', 'Recommend');
    var $paginate;
    public function create()
    {
        
    }
    public function check()
    {
        $conditions = array('members_id' => $this->_memberInfo['Member']['id']);
        $this->_getResumeBase($conditions);
    }
    public function complete()
    {
        $work_data = array(
            'begin'         => $this->request->data['work_begin'],
            'end'           => $this->request->data['work_end'],
            'department'    => $this->request->data['department'],
            'category'      => $this->request->data['work_category'],
            'post'          => $this->request->data['post'],
            'company'       => $this->request->data['company'],
            'service'       => $this->request->data['service'],
            'responsiblly'  => $this->request->data['responsiblly'],
            'salary'   => $this->request->data['wrok_salary'],
            'reason'        => $this->request->data['reason'],
        );
        $continued = ceil((strtotime($this->request->data['work_end']) - strtotime($this->request->data['work_begin'])) / (24*3600*365));
        $edu_data = array(
            'begin'         => $this->request->data['edu_begin'],
            'end'           => $this->request->data['edu_end'],
            'educated'      => $this->request->data['educated'],
            'discipline'    => $this->request->data['discipline'],
            'school'        => $this->request->data['school'],
            'school_type'   => $this->request->data['school_type'],
        );
        $resume_data = array(
            'members_id'    => $this->_memberInfo['Member']['id'],
            'title'         => $this->request->data['title'],
            'evaluation'    => $this->request->data['evaluation'],
            'nature'        => $this->request->data['nature'],
            'intention'     => $this->request->data['intention'],
            'category'      => $this->request->data['category'],
            'city'          => $this->request->data['city'],
            'salary'        => $this->request->data['salary'],
            'start'         => $this->request->data['start'],
            'continued'     => $continued,
            'educated'      => $this->request->data['educated'],
        );
        $error = false;
        $has_worked = $this->request->data['has_worked'];
        $audition = array();
        if (isset($this->request->data['fid'])) {
            $audition['sender'] = $this->_memberInfo['Member']['id'];
            $audition['fulltimes_id'] = $this->request->data['fid'];
        }
        if (!$this->Resume->insertResume($resume_data, $edu_data, $work_data, $has_worked, $audition)) {
            $error = true;
        } else {
            $this->redirect('/resumes/listview');
        }
        $this->set('error', $error);
    }
    
    public function listview()
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->set('title_for_layout', "我的简历");
            $conditions = array('members_id' => $this->_memberInfo['Member']['id']);
            $this->_getResumeBase($conditions);
            $conditions = array('members_id' => $this->_memberInfo['Member']['id']);
            $this->Resumes->fulltimeList($conditions);
        } else {
            $conditions = array('members_id' => $this->_memberInfo['Member']['id']);
            $this->Resumes->fulltimeList($conditions);
            $this->render('list_paginate');
        }
    }
    
    public function detail()
    {
        $this->set('title_for_layout', "简历详情");
        $conditions = array(
            'id' => $this->request->query['id'],
        );
        if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.Personal')) {
            $conditions['members_id'] = $this->_memberInfo['Member']['id'];
            $resume = $this->Resume->find('first', array('conditions' => $conditions));
            if (!empty($resume)) {
                $conditions = array('members_id' => $this->_memberInfo['Member']['id']);
                $this->_getResumeBase($conditions);
                $conditions = array(
                    'resumes_id' => $this->request->query['id']
                );
                $this->_getEducationInfo($conditions);
                $this->_getWorkInfo($conditions);
                $this->set('thumbnail', $this->_memberInfo['Attribute']['thumbnail']);
            }
        } else {
            $resume = $this->Resume->find('first', array('conditions' => $conditions));
            if (!empty($resume)) {
                $conditions = array('members_id' => $resume['Resume']['members_id']);
                $this->_getResumeBase($conditions);
                $conditions = array(
                    'resumes_id' => $this->request->query['id']
                );
                $this->_getEducationInfo($conditions);
                $this->_getWorkInfo($conditions);
                $author = $this->MemberAttribute->find('first', array('conditions' => array('members_id' => $resume['Resume']['members_id']), 'fields' => array('thumbnail')));
                $this->set('thumbnail', $author['MemberAttribute']['thumbnail']);
                //职位信息
                $fulltimes = $this->Fulltime->find('all', array('conditions' => array('members_id' => $this->_memberInfo['Member']['id']), 'fields' => array('id', 'post')));
                $this->set('fulltimes', $fulltimes);
            }
        }
        
        $this->set('resume', $resume);
        if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.company')) {
            $this->render('company-detail');
        }
    }
    
    public function preview()
    {
        $this->layout = 'resume_preview';
        $this->set('title_for_layout', "简历预览");
        $conditions = array(
            'id' => $this->request->query['id'],
//            'members_id' => $this->_memberInfo['Member']['id']
        );
        $resume = $this->Resume->find('first', array('conditions' => $conditions));
        if (!empty($resume)) {
            $conditions = array('members_id' => $resume['Resume']['members_id']);
            $this->_getResumeBase($conditions);
            $conditions = array(
                'resumes_id' => $this->request->query['id']
            );
            $this->_getEducationInfo($conditions);
            $this->_getWorkInfo($conditions);
        }
        $this->set('resume', $resume);
    }
    
    public function search()
    {
        if (!$this->RequestHandler->isAjax()) {
            $this->set('title_for_layout', "简历检索");
            $js = array('retrieval');
            $this->_appendJs($js);
            $this->Resumes->search();
        } else {
            //检索条件
            $conditions = array();
            if (isset($this->request->data['citys'])) {
                $or = array();
                foreach ($this->request->data['citys'] as $city) {
                    $or[] = array('Resume.city LIKE' => "%$city%");
                }
                $conditions['OR'] = $or;
            }
            if (isset($this->request->data['categorys'])) {
                $or = array();
               foreach ($this->request->data['categorys'] as $category) {
                    $or[] = array('Resume.category LIKE' => "%$category%");
                }
                $conditions['AND'] = array(array('OR' => $or));
            }
            if (isset($this->request->data['sex']) && $this->request->data['sex'] !== "") {
                $conditions['Base.sex'] = $this->request->data['sex'];
            }
            if (isset($this->request->data['nature']) && !empty($this->request->data['nature'])) {
                $conditions['Resume.nature'] = $this->request->data['nature'];
            }
            if (isset($this->request->data['modified'])) {
                $limitTime = $this->request->data['modified'];
                if ($limitTime === '0') {
                    $conditions['DATE_FORMAT(Resume.modified, "%Y-%m-%d")'] = date('Y-m-d', time());
                } elseif ($limitTime !== "") {
                    $conditions['DATE_FORMAT(Resume.modified, "%Y-%m-%d") > '] = date('Y-m-d', strtotime("-$limitTime day"));
                }
            }
            if (isset($this->request->data['educated'])) {
                $conditions['Education.educated >='] = $this->request->data['educated'];
            }
            $this->Resumes->search($conditions);
            $this->render('search_paginate');
        }
    }
    
    
    public function editBase()
    {
        $data = array(
            'name'              => $this->request->data['name'],
            'sex'               => $this->request->data['sex'],
            'birthday'          => $this->request->data['birthday'],
            'nationality'       => $this->request->data['nationality'],
            'ethnic'            => $this->request->data['ethnic'],
            'provincial_local'  => $this->request->data['provincial_local'],
            'city_local'        => $this->request->data['city_local'],
            'provincial_now'    => $this->request->data['provincial_now'],
            'city_now'          => $this->request->data['city_now'],
            'address'           => $this->request->data['address'],
            'email'             => $this->request->data['email'],
            'telephone'         => $this->request->data['telephone'],
        );
        try {
            if (isset($this->request->data['id'])) {
//                $condition = array('id' => $this->request->data['id'], 'members_id' => $this->_memberInfo['Member']['id']);
                $data['id'] = $this->request->data['id'];
                $this->ResumeBase->save($data);
            } else {
                $data['members_id'] = $this->_memberInfo['Member']['id'];
                $resumeBase = $this->ResumeBase->find('first', array('conditions' => $data));
                if (!empty($resumeBase)) {
                    $data['id'] = $resumeBase['ResumeBase']['id'];
                }
                $this->ResumeBase->save($data);
            }
            $result = array('result' => 'OK', 'msg' => '基础信息保存成功！');
        } catch (Exception $e) {
            $this->log(__CLASS__ . "->" . __FUNCTION__ .'() :' . $e->getMessage());
            $result = array('result' => 'NG', 'msg' => '系统错误，基础信息保存失败，请稍后再试！');
        }
        $this->_sendJson($result);
    }
    
    public function getBase()
    {
        $conditions = array('members_id' => $this->_memberInfo['Member']['id']);
        $this->_getResumeBase($conditions);
        $this->render('resume_base');
    }
    
    public function _getResumeBase($conditions)
    {
        $result = $this->ResumeBase->find('first', array('conditions' => $conditions));
        $this->set('resumeBase', $result);
    }
    
    public function _getEducationInfo($conditions)
    {
        $resule = $this->ResumeEducation->find('first', array('conditions' => $conditions));
        $this->set('resumeEducation', $resule);
    }
    
    public function _getWorkInfo($conditions)
    {
        $resule = $this->ResumeWork->find('first', array('conditions' => $conditions));
        $this->set('resumeWork', $resule);
    }

    public function candidate()
    {
        $category = $this->request->data['category'];
        $params = array(
            'conditions' => array('category LIKE ' => "%$category%", 'members_id' => $this->_memberInfo['Member']['id']),
            'fields' => array('title', 'id')
        );
        $resumes = $this->Resume->find('all', $params);
        $this->set('resumes', $resumes);
    }
    
    public function beforeRender()
    {
        $this->currentMenu = Configure::read('Menu.fulltimeManager');
        $css = array(
        'ui/jquery-ui',
        'member',
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