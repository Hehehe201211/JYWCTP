<?php
App::uses('CakeEmail', 'Network/Email');
class MembersController extends AppController
{
    var $layout = 'members';
    var $uses = array(
        'City', 
        'Category', 
        'TmpMember', 
        'Member', 
        'UpMember',
        'Information',
        'MemberReceived',
        'MemberAttribute',
        'CompanyAttribute',
        'PartTime',
        'Fulltime',
        'Cooperation',
        'Audition',
    
    );
    var $components = array('RequestHandler', 'ImageCheck', 'Unit', 'Upload', 'Thumbnail', 'Recommend');
    var $helpers = array('City', 'Category');
    public function index()
    {
        $this->set('title_for_layout', "会员首页");
        if ($this->_memberInfo['Member']['type'] == 0) {//一般会员
            if ($this->_memberInfo['Member']['grade'] == 0) {//初级
               $this->render('elementary_index');
            } else {
//                $conditions = array('members_id' => $this->_memberInfo['Member']['id'], 'type' => Configure::read('Information.type.has'));
                $conditions = array('members_id' => $this->_memberInfo['Member']['id'], 'type' => array(Configure::read('Information.type.has'), Configure::read('Information.type.parttime')));
                $newInformation = $this->Information->getInformationBaseBy($conditions, array('created'), 5);
                $newReceivedInformation = $this->MemberReceived->getReceiveInformationBase($conditions, array('MemberReceived.created'), 5);
                $conditions['type'] = Configure::read('Information.type.need');
                $newReward = $this->Information->getInformationBaseBy($conditions, array('created'), 5);
                $newReceivedReward = $this->MemberReceived->getReceiveInformationBase($conditions, array('MemberReceived.created'), 5);
                $historyInfo = $this->Member->getHistoryInfo($this->_memberInfo['Member']['id']);
                
                $this->set('newHasInformations', $newInformation);
                $this->set('newReceivedInformations', $newReceivedInformation);
                $this->set('newRewards', $newReward);
                $this->set('newReceivedRewards', $newReceivedReward);
                $this->set('historyInfo', $historyInfo);
                //收到站内信留言
                $this->Recommend->stationMessageCount($this->_memberInfo['Member']['id']);
                
                //
                $this->Recommend->parttime($this->_memberInfo['Member']['id'], $this->_memberInfo['Attribute']['category_id']);
                
                //提示各种信息所处各种状态
                $this->Recommend->PersonNoticeCount($this->_memberInfo['Member']['id']);
            }
        } else {//企业会员
            $this->currentMenu = Configure::read('Menu.parttimeManager');
            if ($this->_memberInfo['Member']['grade'] == 0) {//初级
               $this->render('elementary_company_index');
            } else {
                //
                $params = array(
                    'conditions' => array('members_id' => $this->_memberInfo['Member']['id']),
                    'fields'     => array('id', 'title', 'category', 'sub_category', 'method', 'clicked', 'created'),
                    'order'      => array('created DESC'),
                    'limit'      => 5
                );
                $parttimes = $this->PartTime->find('all', $params);
                
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
                );
                $params = array(
                    'conditions' => array('members_id' => $this->_memberInfo['Member']['id']),
                    'fields'     => $fields,
                    'order'      => array('created DESC'),
                    'limit'      => 5
                );
                $fulltimes = $this->Fulltime->find('all', $params);
                
                $joinMember = array(
                    'table' => 'members',
                    'alias' => 'Member',
                    'type'  => 'inner',
                    'conditions' => 'Member.id = Cooperation.sender'
                );
                
                $joinInformation = array(
                    'table' => 'information',
                    'alias' => 'Information',
                    'type'  => 'inner',
                    'conditions' => 'Information.id = Cooperation.information_id'
                );
                $params = array(
                    'conditions' => array('Cooperation.receiver' => $this->_memberInfo['Member']['id'], 'Cooperation.status' => Configure::read('Cooperation.status.posting')),
                    'fields'     => array(
                        'Cooperation.id', 
                        'Cooperation.status', 
                        'Cooperation.created', 
                        'Member.nickname', 
                        'Information.provincial', 
                        'Information.city', 
                        'Information.category', 
                        'Information.sub_category'
                    ),
                    'order'      => array('Cooperation.created DESC'),
                    'joins'      => array($joinMember,$joinInformation),
                    'limit'      => 5
                );
                
                $newReceived = $this->Cooperation->find('all', $params);
                $this->getNewReceiveAudition();
                
                $this->Recommend->fulltimeCount($this->_memberInfo['Member']['id']);
                $this->Recommend->parttimeCount($this->_memberInfo['Member']['id']);
                $this->Recommend->receiveResumeCount($this->_memberInfo['Member']['id']);
                $this->Recommend->receiveCooperationsCount($this->_memberInfo['Member']['id']);
                $this->set('newParttimes', $parttimes);
                $this->set('newFulltimes', $fulltimes);
                $this->set('newReceived', $newReceived);
                $this->render('index-company');
            }
        }
    }
    
    private function getNewReceiveAudition()
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
        $conditions = array(
            'Audition.status' => Configure::read('Audition.status_active'), 
            'Audition.receiver' => $this->_memberInfo['Member']['id']
        );
        $params = array(
            'conditions'    => $conditions,
            'fields'    => $fields,
            'joins'     => array($joinFulltime, $joinResume, $joinResumeBase),
            'limit'     => 5,
            'order'     => array('Audition.created' => 'DESC'),
        );
        $newAuditions = $this->Audition->find('all', $params);
        $this->set('newAuditions', $newAuditions);
    }
    
    
    public function login()
    {
        $css = array(
        'css.css'
        );
        $this->_appendCss($css);
    }
    
    public function logout()
    {
        $this->Session->delete('memberInfo');
        if (!$this->RequestHandler->isAjax()) {
            $this->redirect('/');
        } else {
            $this->_sendJson(array('result' => 'OK'));
        }
    }
    
    public function register()
    {
        $this->layout = "members-register";
        $cityParam = array(
          'fields' => array('id', 'name'),
          'conditions' => array('parent' => 0, 'display' => 1),
          'order' => array('priority')
        );
        $city = $this->City->find('all', $cityParam);
        $category = $this->Category->getCategoryList();
        $this->set('cityList', $city);
        $this->set('categoryList', $category);
        $this->set("cssClass", '');
        $fromMember = false;
        if (
            isset($this->request->query['mid']) &&
            !empty($this->request->query['mid']) &&
            isset($this->request->query['key']) &&
            !empty($this->request->query['key']) &&
            $this->request->query['key'] == md5($this->request->query['mid'])
            ) {
                $fromMember = true;
            }
        $this->set('fromMember', $fromMember);
    }
    
    public function check()
    {
        $this->layout = "members-register";
        $this->set("nickname", $this->request->data['nickname']);
        $this->set("email", $this->request->data['email']);
        $this->set("cssClass", 'zhucrig_x2');
        if (!$this->_exist($this->request->data['email'], $this->request->data['type'])) {
            $data = array(
                'nickname' => $this->request->data['nickname'],
                'email'        => $this->request->data['email'],
                'password'    => md5($this->request->data['password']),
                'type'      => $this->request->data['type']
             );
            if (isset($this->request->data['mid'])) {
                $data['mid'] = $this->request->data['mid'];
             }
            if ($this->request->data['type'] == 1) {
              $data['company_name'] = $this->request->data['company_name'];
            }
            if ($this->TmpMember->save($data)) {
//                $body = "
//                亲爱的" . $this->request->data['nickname'] .":
//                
//                聚业务真诚的欢迎您！
//                这封邮件是为了核实会员身份的合法性，
//                请你通过下面的连接验证你的身份。
//                http://dev.jukeyuan.com/members/complete/?id=" . $this->TmpMember->getInsertID() . "&ps=" . $data['password'] . "&t=" . $data['type'] .
//                "
//                这封邮件不需要你回复。
//                如果你有什么意见和建议请你在会员主页的
//                【我要提建议】页面和我联系。我们会非常
//                珍惜用户提的每一个宝贵意见和建议。
//                        ";
//        
//                $email = new CakeEmail('default');
//                $email->from(array('norepeat@jukeyuan.com' => '聚业务'));
//                $email->to($this->request->data['email']);
//                $email->subject('会员身份认证');
//                $email->send($body);
                $checkLink = "http://" . $_SERVER['SERVER_NAME'] . '/members/complete/?id=' . $this->TmpMember->getInsertID() . "&ps=" . $data['password'] . "&t=" . $data['type'];
                $email = new CakeEmail();
                $params = array(
                    'domain' => 'http://' . $_SERVER['SERVER_NAME'], 
                    'name' => $this->request->data['nickname'],
                    'password'  => $this->request->data['password'],
                    'checkLink' => $checkLink
                );
                $email->template('register-check', 'register')
                ->viewVars($params)
                ->emailFormat('html')
                ->to($this->request->data['email'])
                ->from(array('norepeat@jukeyuan.com' => '聚业务'))
                ->subject('会员身份认证')
                ->send();
                $error = false;
            } else {
                $error = true;
                $errorMsg = "很抱歉，会员注册失败！请你重新注册！";
                $this->set("errorMsg", $errorMsg);
            }
        } else {
            $error = true;
            $errorMsg = "此用户已经存在！";
            $this->set("errorMsg", $errorMsg);
        }
        $this->set("error", $error);
    }
    
    public function complete()
    {
        $conditions = array(
            'conditions' =>array(
                'id' => $this->request->query['id'], 
                'password' => $this->request->query['ps'], 
                'type' => $this->request->query['t']
            )
        );
        $memberInfo = $this->TmpMember->find('first', $conditions);
        $errorMsg = "";
        $nickname = "";
        if (!empty($memberInfo)) {
            $member = array(
                'nickname'         => $memberInfo['TmpMember']['nickname'],
                'password'         => $memberInfo['TmpMember']['password'],
                'email'            => $memberInfo['TmpMember']['email'],
                'type'          => $memberInfo['TmpMember']['type'],
                'company_name'          => $memberInfo['TmpMember']['company_name'],
                'mid'               => $memberInfo['TmpMember']['mid']
            );
            if ($this->Member->save($member)) {
                $this->TmpMember->delete(array('id' => $this->request->query['id']));
                unset($member['password']);
                $memberInfo = $this->Member->getMemberInfo(array('nickname' => $memberInfo['TmpMember']['nickname'], 'password' => $memberInfo['TmpMember']['password'], 'type' => $memberInfo['TmpMember']['type']));
                $this->Session->write('memberInfo', $memberInfo);
//                $this->flash("会员信息验证成功！欢迎你使用聚客源", "/members/");
//                $this->redirect('/members');
            } else {
                $errorMsg = "认证失败！请稍后重试！";
            }
            $nickname = $memberInfo['Member']['nickname'];
        } else {
            $errorMsg = "此认证用户不存在！";
        }
        $this->layout = "members-register";
        $this->set('nickname', $nickname);
        $this->set("errorMsg", $errorMsg);
        $this->set("cssClass", 'zhucrig_x3');
    }

    public function upgrade()
    {
        $this->set('title_for_layout', "会员升级");
        $css = array(
        'ui/jquery-ui'
        );
        $js = array('jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        $cityParam = array(
          'fields' => array('id', 'name'),
          'conditions' => array('parent' => 0, 'display' => 1),
          'order' => array('priority')
        );
        $city = $this->City->find('all', $cityParam);
        $this->set('cities', $city);
        $param = array(
            'fields' => array('id', 'name'),
            'conditions' => array('parent' => 0, 'display' => 1),
            'order' => array('priority')
        );
        $category = $this->Category->find('all', $param);
        $this->set('category', $category);
        if ($this->_memberInfo['Member']['type'] == 1) {
            $this->render('upgrade-company');
        }
    }
    
    public function upgradecheck()
    {
        $facethumbnail = '';
        if (isset($_FILES['face'])) {
//            $filename = $this->_memberInfo['Member']['id'] . '_face_thumbnail';
//            $path = TMP;
            $path = "thumbnail/" . 
                substr(md5(((int)($this->_memberInfo['Member']['id'] / 30000) + 1)), 0, 10) . "/" . 
                substr(md5($this->_memberInfo['Member']['id']), 0, 10);
            if (!file_exists($path)) {
                $command = "mkdir -p 0755 " . Configure::read('Data.path') . $path;
                try {
                    exec($command);
                } catch (Exception $e) {
                    $this->log($e->getMessage());
                }
            }
            $result = $this->Upload->upload($_FILES['face'], $path, 'license', "image");
            if ($result['result'] == 'OK') {
//                $path = "thumbnail/" . 
//                        substr(md5(((int)($this->_memberInfo['Member']['id'] / 30000) + 1)), 0, 10) . "/" . 
//                        substr(md5($this->_memberInfo['Member']['id']), 0, 10);
//                if (!file_exists($path)) {
//                    $command = "mkdir -p 0755 " . Configure::read('Data.path') . $path;
//                    try {
//                        exec($command);
//                    } catch (Exception $e) {
//                        $this->log($e->getMessage());
//                    }
//                }
                $srcParams = array(
                    'path' => $result['path'],
                    'name' => $result['name']
                );
                $descParams = array(
                    'imagepath' => Configure::read('Data.path') . $path,
                    'imagename'      => "face_thumbnail",
                    'outx'      => Configure::read('Thumbnail.face.width'),
                    'outy'      => Configure::read('Thumbnail.face.height')
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $facethumbnail = $path . "/face_thumbnail." .  $this->Upload->getExt($_FILES['face']);
                    if ($this->request->data['type'] == Configure::read('UserType.Personal')) {
                        @unlink($result['path'] . '/' . $result['name']);
                    }
                }
            }
        }
        $logo = '';
        if (isset($_FILES['logo'])) {
            $filename = $this->_memberInfo['Member']['id'] . '_logo_thumbnail';
            $path = TMP;
            $result = $this->Upload->upload($_FILES['logo'], $path, $filename, "image");
            if ($result['result'] == 'OK') {
                $path = "thumbnail/" . 
                        substr(md5(((int)($this->_memberInfo['Member']['id'] / 30000) + 1)), 0, 10) . "/" . 
                        substr(md5($this->_memberInfo['Member']['id']), 0, 10);
                if (!file_exists($path)) {
                    $command = "mkdir -p 0755 " . Configure::read('Data.path') . $path;
                    try {
                        exec($command);
                    } catch (Exception $e) {
                        $this->log($e->getMessage());
                    }
                }
                $srcParams = array(
                    'path' => $result['path'],
                    'name' => $result['name']
                );
                $descParams = array(
                    'imagepath' => Configure::read('Data.path') . $path,
                    'imagename'      => "logo_thumbnail",
                    'outx'      => Configure::read('Thumbnail.logo.width'),
                    'outy'      => Configure::read('Thumbnail.logo.height')
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $logo = $path . "/logo_thumbnail." .  $this->Upload->getExt($_FILES['logo']);
                    @unlink($result['path'] . '/' . $result['name']);
                }
            }
        }
        $this->set('thumbnail', $facethumbnail);
        $this->set('logo', $logo);
        if (isset($this->request->data['type']) && isset($this->request->data['type']) == 1) {
            $this->render('upgradecheck-company');
        }
    }
    public function upgradecomplete()
    {
        $error = false;
        $member_id = $this->_memberInfo['Member']['id'];
        if (isset($this->request->data['type']) && isset($this->request->data['type']) == 1) {
            if ($this->CompanyAttribute->find('count', array('conditions' => array('members_id' => $member_id))) > 0) {
                $this->redirect('/members');
            }
            $contact_methods = array();
            foreach ($this->request->data['contact_method'] as $key => $value) {
                $method = array(
                    'method' => $value,
                    'content' => $this->request->data['contact_content'][$key]
                );
                $contact_methods[] = $method;
            }
            $data = array(
                'members_id'    => $member_id,
                'full_name'     => $this->request->data['full_name'],
                'established'   => $this->request->data['established'],
                'contact'       => $this->request->data['contact'],
                'contact_method' => json_encode($contact_methods),
                'fax'           => $this->request->data['fax'],
                'provincial_id' => $this->request->data['provincial_id'],
                'city_id'       => $this->request->data['city_id'],
                'address'       => $this->request->data['address'],
                'company_type'  => $this->request->data['company_type'],
                'category_id'   => $this->request->data['category_id'],
                'service'       => implode(",", $this->request->data['service']),
                'business_scope'=> $this->request->data['business_scope'],
                'license'       => $this->request->data['thumbnail'],
                'thumbnail'     => $this->request->data['logo']
            );
            if ($this->Member->upgradeCompany($data)) {
                $message = "您成功升级到高级会员！请等待聚业务平台工作人员的审核。你可以发布相关资料！";
            } else {
                $message = "由于系统原因会员升级失败，请你稍候再试！";
                $error = true;
            }
            $this->set('message', $message);
            $type = 1;
        } else {
            if ($this->MemberAttribute->find('count', array('conditions' => array('members_id' => $member_id))) > 0) {
                $this->redirect('/members');
            }
            
            $data = array(
                'members_id'    => $member_id,
                'name'            => $this->request->data['name'],
                'sex'           => $this->request->data['sex'],
                'mobile'        => $this->request->data['mobile'],
                'provincial_id'    => $this->request->data['provincial'],
                'city_id'        => $this->request->data['city'],
                'category_id'    => $this->request->data['category'],
                'business_scope'=> $this->request->data['business_scope'],
                'pay_account'    => $this->request->data['pay_account'],
                'pay_password'    => md5($this->request->data['pay_password']),
                'last_login'    => date('Y-m-d H:i:s', time()),
                'point'         => Configure::read('Register.point'),
                'service'        => implode(',', $this->request->data['service']),
                'thumbnail'     => $this->request->data['thumbnail']
            );
            if (isset($this->request->data['birthday'])) {
                $data['birthday'] = $this->request->data['birthday'];
            }
            if (isset($this->request->data['telephone'])) {
                $data['telephone'] = $this->request->data['telephone'];
            }
            if (isset($this->request->data['other_category'])) {
                $data['other_category'] = $this->request->data['other_category'];
            }
            if (isset($this->request->data['company'])) {
                $data['company'] = $this->request->data['company'];
            }
            if ($this->Member->upgrade($data)) {
                $message = "您成功升级到高级会员，现在可以免费发布信息或寻找兼职！";
            } else {
                $message = "由于系统原因会员升级失败，请你稍候再试！";
                $error = true;
            }
            $this->set('message', $message);
            $type = 0;
        }
        $memberInfo = $this->Member->getMemberInfo(array('Member.id' => $member_id), $type);
        if (!empty($memberInfo)) {
           $this->Session->write("memberInfo", $memberInfo);
        }
        $this->set('memberInfo', $memberInfo);
        $this->set('type', $type);
        $this->set('error', $error);
    }
    
    public function upgreadfinish()
    {
//        $memberInfo = $this->Session->read('memberInfo');
        $member_id = 5;
        if ($this->UpMember->find('count', array('conditions' => array('member_id' => $member_id)))) {
            $result = false;
            $errorMsg = "会员升级申请正在审核中，请留意你的申请邮箱！";
            $this->set("errorMsg", $errorMsg);
        } else {
            $data = array(
                'member_id' => $member_id,
                'name' => $this->request->data['name'],
                'UID' => $this->request->data['UID'],
                'birthday' => $this->request->data['birthday'],
                'telephone' => $this->request->data['telephone']
            );
            
            if ($this->UpMember->save($data)) {
                $result = true;
            } else {
                $result = false;
                $errorMsg = "会员升级申请失败，请你重新申请！";
                $this->set("errorMsg", $errorMsg);
            }
        }
        $this->set("result", $result);
    }
    
    public function existEmail($email, $type)
    {
        $this->autoRender = false;
        echo $this->_exist($email, $type);
    }
    
    public function existMember()
    {
        $this->autoRender = false;
        $result = 0;
        if (isset($this->request->data['email'])) {
            $email = $this->request->data['email'];
            $type = $this->request->data['type'];
            $exist = $this->Member->find('count', array('conditions' => array('Member.email' => $email, 'type' => $type)));
            if ($exist == 0) {
                $exist = $this->TmpMember->find('count', array('conditions' => array('TmpMember.email' => $email, 'type' => $type)));
            }
            $result = $exist > 0 ? 1 : 0;
        } elseif (isset($this->request->data['nickname'])) {
            $nickname = $this->request->data['nickname'];
            $type = $this->request->data['type'];
//            $exist = $this->Member->find('count', array('conditions' => array('Member.nickname' => $nickname, 'type' => $type)));
            $exist = $this->Member->find('first', array('conditions' => array('Member.nickname' => $nickname, 'type' => $type), 'fields' => array('id')));
            if (empty($exist)) {
                $exist = $this->TmpMember->find('count', array('conditions' => array('TmpMember.nickname' => $nickname, 'type' => $type)));
            } else {
                if (isset($this->_memberInfo['Member']['id']) && $exist['Member']['id'] == $this->_memberInfo['Member']['id']) {
                    $exist = 0;
                } else {
                    $exist = 1;
                }
            }
            $result = $exist > 0 ? 1 : 0;
        }
        echo $result;
    }
    
    protected function _exist($email, $type) 
    {
        $exist = $this->Member->find('count', array('conditions' => array('Member.email' => $email, 'Member.type' => $type)));
        if ($exist == 0) {
            $exist = $this->TmpMember->find('count', array('conditions' => array('TmpMember.email' => $email, 'TmpMember.type' => $type)));
        }
        return $exist > 0 ? 1 : 0;
    }
    /**
     * 
     * 首页的Ajax登陆
     */
    public function ajaxlogin()
    {
        $this->autoRender = false;
        if (strtolower($this->request->data['checkNum']) == strtolower($this->Session->read("checkNum"))) {
            unset($this->request->data['checkNum']);
            $this->request->data['password'] = md5($this->request->data['password']);
            $memberInfo = $this->Member->getMemberInfo($this->request->data, $this->request->data['type']);
            if (empty($memberInfo)) {
                echo "用户名或密码有误，请重新输入！";
            } else {
                $data = array();
                $this->log(print_r($memberInfo, true));
                $sub_day = date("d", (time() - strtotime($memberInfo['Member']['lastlogin'])));
                $this->log($sub_day);
                if ($sub_day != 0) {
                    if ($sub_day == 1) {
                        $data['continuous_online'] = $memberInfo['Member']['continuous_online'] + 1;
                    } else {
                        $data['continuous_online'] = 1;
                    }
                    $data['lastlogin'] = "'" . date('Y-m-d H:i:s', time()) . "'";
                }
                if (!empty($data)) {
                    try {
                        $this->log(print_r($data, true));
                        $this->Member->updateAll($data, array('Member.id' => $memberInfo['Member']['id']));
                        $this->Member->printLog();
                    } catch (Exception $e) {
                        $this->log($e->getMessage());
                    }
                }
                $this->Session->write("memberInfo", $memberInfo);
            }
        } else {
            echo "验证码错误";
        }
        
    }
    
    public function beforeRender()
    {
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
    }
    
    //
    public function image()
    {
        $this->autoRender = false;
        $string = $this->ImageCheck->random(4);
        $this->ImageCheck->createImage($string);
        $this->Session->write("checkNum", $string);
    }
    
    public function getImageNumber()
    {
        $this->autoRender = false;
        $data = $this->Session->read("checkNum");
        echo $data;
    }
}