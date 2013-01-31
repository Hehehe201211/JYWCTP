<?php
/**
 * 
 * 个人会员，企业会员的
 * 兼职信息控制器
 * @author lin_deping
 *
 */
class ParttimesController extends AppController
{
    var $layout = 'members';
    var $helpers = array('Js', 'City', 'Category');
    var $uses = array('PartTime', 'Information', 'Cooperation', 'PartTimeFavourite', 'Homepage');
    var $components = array('RequestHandler', 'Parttime', 'Unit', 'Recommend');
    public function create()
    {
        $js = array(
            'jquery-ui',
            'retrieval'
        );
        $css = array('ui/jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
    }
    
    public function check()
    {
        
    }
    
    public function complete()
    {
        $data = $this->request->data;
        $data['members_id'] = $this->_memberInfo['Member']['id'];
        $area = implode(',', $data['citys']);
        $data['area'] = $area;
        unset($data['citys']);
        $contact_method = array();
        foreach ($data['contact_method'] as $key => $value) {
            $contact_method[] = array('method' => $value, 'number' => $data['contact_content'][$key]);
        }
        unset($data['contact_method']);
        unset($data['contact_content']);
        $data['contact_method'] = json_encode($contact_method);
        if (isset($data['categorys'])) {
            $industry = implode(',', $data['categorys']);
            $data['industry'] = $industry;
            unset($data['cagetorys']);
        }
        $conditions = array(
            'members_id'    => $data['members_id'],
            'title'         => $data['title'],
            'category'      => $data['category'],
            'sub_category'  => $data['sub_category']
        );
        $error = false;
        $duplicate = false;
        $parttime = $this->PartTime->find('first', array('conditions' => $conditions));
        if (!empty($parttime) && !isset($data['id'])) {
            $msg = "不能重复发布相同兼职内容！";
            $error = true;
            $duplicate = true;
            $this->set('id', $parttime['PartTime']['id']);
        } else {
            if ($this->PartTime->save($data)) {
                if (isset($data['id'])) {
                    $this->set('id', $data['id']);
                } else {
                    $this->set('id', $this->PartTime->getLastInsertId());
                }
                
                $msg = "兼职发布成功！";
            } else {
                $msg = "兼职发布失败，请稍后重试！";
                $error = true;
            }
        }
        $this->set('msg', $msg);
        $this->set('error', $error);
        $this->set('duplicate', $duplicate);
    }
    
    public function edit()
    {
        $js = array(
            'jquery-ui',
            'retrieval'
        );
        $css = array('ui/jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        if (!empty($this->request->query['id'])) {
            $conditions = array(
	            'id' => $this->request->query['id'], 
	            'members_id' => $this->_memberInfo['Member']['id']
            );
            $parttime = $this->PartTime->find('first', array('conditions' => $conditions));
            if (!empty($parttime)) {
                $this->set('parttime', $parttime);
            } else {
                $this->_sysDisplayErrorMsg("没有你可以编辑的信息！");
            }
        } else {
            $this->_sysDisplayErrorMsg("没有你可以编辑的信息！");
        }
    }
    
    public function listview()
    {
        if (isset($this->request->query['type']) && $this->request->query['type'] == 'need') {
            $js = array(
	            'jquery-ui',
	            'retrieval'
	        );
	        $css = array('ui/jquery-ui');
	        $this->_appendCss($css);
	        $this->_appendJs($js);
            $this->set('title_for_layout', "我要兼职");
            
            $this->Parttime->partimeListNeed();
            if ($this->RequestHandler->isAjax()){
                $this->render('search-need');
            } else {
                $this->render('listview-need');
            }
        } else{
            $this->set('title_for_layout', "兼职发布列表");
            $this->Parttime->partimeList($this->_memberInfo['Member']['id']);
            if ($this->RequestHandler->isAjax()){
                $this->render('search-send');
            }
        }
        
    }
    
    public function search()
    {
        $this->autoRender = false;
        if ($this->request->query['type'] == 'need') {
            $conditions = array();
            if (isset($this->request->data['method']) && !empty($this->request->data['method'])) {
                $conditions['PartTime.method'] = $this->request->data['method'];
            }
            if (isset($this->request->data['citys'])) {
                foreach ($this->request->data['citys'] as $city) {
//                    $or['area LIKE'] = 
                }
                $conditions['OR'] = array('c');
            }
            if (isset($this->request->data['categorys'])) {
                $conditions['PartTime.category'] = $this->request->data['categorys'];
            }
            if (isset($this->request->data['created']) && $this->request->data['created'] !== "-1") {
                if ($this->request->data['created'] == 0) {
                    $conditions["DATE_FORMAT(PartTime.created, 'Y-m-d')"] = date('Y-m-d', time());
                } elseif ($this->request->data['created'] == 30) {
                    $conditions["PartTime.created <= "] = date('Y-m-d', strtotime("-30 day"));
                } else {
                    $conditions["PartTime.created >= "] = date('Y-m-d', strtotime("-{$this->request->data['created']} day"));
                }
             }
             $this->Parttime->partimeListNeed($conditions);
             $this->render('search-need');
        } else {
            
        }
    }
    
    public function detail()
    {
        $this->set('title_for_layout', "平台兼职详情");
        $id = $this->request->query['id'];
        if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.Personal')) {
            $detail = $this->Parttime->parttimeDetail($id);
            if (!empty($detail)) {
	            $clicked = 0;
		        $session = $this->Session->read('PartTime_' . "_" . $id);
		        if (empty($session)) {
		            $this->PartTime->updateClickCount($id);
		            $this->Session->write('PartTime_' . $id, $id);
		            $clicked = 1;
		        }
		        $this->set('clicked', $clicked);
		        $conditions = array(
		          'members_id' => $this->_memberInfo['Member']['id'],
		          'part_times_id' => $id
		        );
		        $favourite = $this->PartTimeFavourite->find('count', array('conditions' => $conditions)) > 0;
		        $this->set('isFavourite', $favourite);
		        
		        $companyHome = $this->Homepage->find('first', array('conditions' => array('members_id' => $detail['Member']['id'])));
		        $this->set('homepage', $companyHome);
            }
        } else {
            $this->set('clicked', 0);
            $detail = $this->Parttime->parttimeDetail($id, 'PartTime.*', $this->_memberInfo['Member']['id']);
        }
    }
    
    public function informationList()
    {
        $members_id = $this->_memberInfo['Member']['id'];
        $categorys = $this->request->data['category'];
        $sender = $members_id;
        $reciever = $this->request->data['target_member'];
        $part_times_id = $this->request->data['parttime_id'];
        $fields = array(
            'id',
            'title'
        );
//        $params = array(
//            'conditions' => array('members_id' => $members_id, 'sub_category' => $categorys, 'status' => Configure::read('Information.status_code.active')),
//            'fields' => $fields
//        );
        //area
        $params = array(
            'fields' => array('area'),
            'conditions' => array('id' => $part_times_id)
        );
        $parttimes = $this->PartTime->find('first', $params);
        $area = explode(',', $parttimes['PartTime']['area']);
        
        $conditionsSubQuery = array(
            'sender'    => $sender,
            'receiver'  => $reciever,
            'part_times_id' => $part_times_id
        );
        $db = $this->Information->getDataSource();
        $subQuery = $db->buildStatement(
            array(
                'fields'    => array('information_id'),
                'table'     => 'cooperations',
                'alias'     => 'Cooperation',
                'limit'     => null,
                'offset'    => null,
                'joins'     => array(),
                'conditions'=> $conditionsSubQuery,
                'order'     => null,
                'group'     => null,
            ),
            $this->Information
        );
        $subQuery = 'id NOT IN (' . $subQuery . ')';
        $subQueryExpression = $db->expression($subQuery);
        $conditions = array(
            'members_id' => $members_id, 
            'sub_category' => $categorys, 
            'status' => Configure::read('Information.status_code.active'),
            'OR'     => array('provincial' => $area, 'city' => $area),
            $subQueryExpression
        );
        
        $params = array(
            'conditions' => $conditions,
            'fields'     => $fields
        );
        $informations = $this->Information->find('all', $params);
        $this->set('informations', $informations);
    }
    
    /**
     * 
     * 个人用户在现有的客源中，应征兼职
     */
    public function addCandidates()
    {
        $this->autoRender = false;
        $information_ids = explode(',', $this->request->data['information_ids']);
        $conditions = array(
            'members_id' => $this->_memberInfo['Member']['id'],
            'id'         => $information_ids,
            'status'     => Configure::read('Information.status_code.active')
        );
        $count = $this->Information->find('count', array('conditions' => $conditions));
        if ($count != count($information_ids)) {
            $result = array(
                'result' => 'NG',
                'msg'    => '客源信息错误！'
            );
        } else {
            $cooperations = array();
            foreach ($information_ids as $id) {
                $cooperations[] = array(
                    'sender'        => $this->_memberInfo['Member']['id'],
                    'receiver'       => $this->request->data['receiver'],
                    'part_times_id' => $this->request->data['part_times_id'],
                    'information_id'=> $id
                );
            }
            if ($this->Cooperation->addCopperation($cooperations)) {
                $result = array(
                    'result' => 'OK'
                );
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '系统错误，请稍后重试！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
    public function beforeRender()
    {
        $this->currentMenu = Configure::read('Menu.parttimeManager');
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