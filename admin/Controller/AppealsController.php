<?php

class AppealsController extends AppController
{
    var $components = array('Grid');
    var $helpers = array('Js', 'City', 'Category');
    protected  $_aliaAppealMap = array(
        'Appeal' => array(
            'id',
//            'members_id',
//            'buyer_members_id',
            'reason',
            'status'
        ),
        'Author' => array(
            'nickname'
        ),
        'Buyer' => array(
            'nickname'
        ),
        'Information' => array(
            'title'
        )
    );
    public function index()
    {
        $this->_useJqGrid();
        $this->_appendJs('appealTemplate');
    }
    
    public function templateData()
    {
        $this->autoRender = false;
        $jdata = $this->Appeal->getAppealAnswerTemplate($this->request);
        $this->_sendJson($jdata);
    }
    
    public function templateEdit()
    {
        $this->autoRender = false;
        switch ($this->request->data['oper']){
            case 'add':
                $data = array(
                    'title' => $this->request->data['title'],
                    'label' => $this->request->data['label'],
                    'content' => $this->request->data['content'],
                );
                $this->Appeal->saveAppealAnswerTemplate($data);
                break;
            case 'edit':
                $data = array(
                    'id'   => $this->request->data['id'],
                    'title' => $this->request->data['title'],
                    'label' => $this->request->data['label'],
                    'content' => $this->request->data['content'],
                );
                $this->Appeal->saveAppealAnswerTemplate($data);
                break;
            case 'del':
                $this->Appeal->deleteAppealAnswerTemplate($this->request->data['id']);
                break;
        }
    }
    public function appeal()
    {
        $this->_useJqGrid();
        $this->_appendJs('appeal');
    }
    
    public function appealData()
    {
        $this->autoRender = false;
//        $where = "";
        $where = array(
            'Appeal.status < ' => 4
        );
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $this->_aliaAppealMap, $where);
        }
        $fields = array(
            'Appeal.id',
            'Appeal.content',
            'Appeal.status',
//            'Appeal.members_id',
//            'Appeal.buyer_members_id',
            'Author.nickname',
            'Buyer.nickname',
        	'Appeal.created',
            'Information.title'
        );
        $joinInformation = array(
            'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = Appeal.information_id'
        );
        $joinMemberAuthor = array(
            'table' => 'members',
            'alias' => 'Author',
            'type'  => 'inner',
            'conditions' => 'Author.id = Appeal.members_id'
        );
        $joinMemberBuyer = array(
            'table' => 'members',
            'alias' => 'Buyer',
            'type'  => 'inner',
            'conditions' => 'Buyer.id = Appeal.buyer_members_id'
        );
        $conditions = array(
            'conditions' => $where,
            'fields' 	 => $fields,
            'joins'		 => array($joinInformation, $joinMemberAuthor, $joinMemberBuyer),
            'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
            'limit'      =>  $this->request->query['rows'],
            'page'       =>  $this->request->query['page'],
        );
        $countConditions = array('conditions' => $where);
        $data = $this->Appeal->find('all', $conditions);
        $count = $this->Appeal->find('count', $countConditions);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        foreach ($data as $value) {
            $row['id'] = $value['Appeal']['id'];
            $row['cell'] = array(
                $value['Appeal']['id'],
                $value['Information']['title'],
//                $value['Appeal']['members_id'],
//                $value['Appeal']['buyer_members_id'],
                $value['Author']['nickname'],
                $value['Buyer']['nickname'],
                $value['Appeal']['content'],
                $value['Appeal']['status'],
                $value['Appeal']['created']
            );
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    public function appealEdit()
    {
        $this->autoRender = false;
        switch ($this->request->data['oper']){
            case 'add':
//                $data = array(
//                    'title' => $this->request->data['title'],
//                    'content' => $this->request->data['content'],
//                );
//                $this->Appeal->save($data);
                break;
            case 'edit':
                $data = array(
                    'id'   => $this->request->data['id'],
                    'status' => $this->request->data['status'],
                );
                $this->Appeal->save($data);
                break;
            case 'del':
//                $this->Appeal->delete($this->request->data['id']);
                break;
        }
    }
    
    public function appeal_answer()
    {
        $this->autoRender = false;
        
    }
    public function appealAnswerData($appeals_id)
    {
        $this->autoRender = false;
        $jdata = $this->Appeal->getAppealAnswer($appeals_id);
        $this->_sendJson($jdata);
        
    }
    public function appealAnswerEdit()
    {
        $this->autoRender = false;
        switch ($this->request->data['oper']){
            case 'add':
                $data = array(
                    'appeals_id' => $this->request->data['appeals_id'],
                    'appeal_answer_templates_id' => $this->request->data['appeal_answer_templates_id'],
                    'answer' => $this->request->data['answer'],
                    'content' => $this->request->data['content'],
                );
                $this->Appeal->saveAppealAnswer($data);
                break;
            case 'edit':
                $data = array(
                    'id'   => $this->request->data['id'],
                    'appeal_answer_templates_id' => $this->request->data['appeal_answer_templates_id'],
                    'answer' => $this->request->data['answer'],
                    'content' => $this->request->data['content'],
                );
                $this->Appeal->saveAppealAnswer($data);
                break;
            case 'del':
                $this->Appeal->deleteAppealAnswer($this->request->data['id']);
                break;
        }
        
    }
    
    public function getTemplate()
    {
        $this->autoRender = false;
        $template = $this->Appeal->getAllTemplate();
        $this->_sendJson($template);
    }
    
    public function information()
    {
        $this->autoLayout = false;
        $id = $this->request->data['id'];
        //
        $result = $this->Appeal->information($id);
        extract($result);
        $this->set('information', $information);
        $this->set('informationAttributes', $informationAttributes);
        $this->set('author', $author);
        $this->set('buyer', $buyer);
        $this->set('appeal', $appeal);
        $this->set('transaction', $transaction);
        $this->set('templates', $templates);
        $this->set('answers', $answers);
        $this->set('compalint', $compalint);
        $this->set('target', $target);
    }
    
    
    
    
    public function complaint()
    {
        $this->_useJqGrid();
        $this->_appendJs('complaint');
    }
    
    public function complaintData()
    {
        $this->autoRender = false;
        $mCooperationComplaint = ClassRegistry::init('CooperationComplaint');
        $aliaAppealMap = array(
            'CooperationComplaint' => array(
                'id',
                'cooperations_id',
                'sender',
                'receiver',
                'type',
                'reason',
                'status',
                'created'
            )
        );
        if ($this->request->query['_search'] == 'true'){
            $where = $this->Grid->getWhereByFilter($this->request->query['filters'], $aliaAppealMap);
        }
        
        $joinInformation = array(
            'table' => 'information',
            'alias' => 'Information',
            'type'  => 'inner',
            'conditions' => 'Information.id = CooperationComplaint.information_id'
        );
        $joinParttime = array(
            'table' => 'part_times',
            'alias' => 'PartTime',
            'type'  => 'inner',
            'conditions' => 'PartTime.id = CooperationComplaint.part_times_id'
        );
        $joinMemberSender = array(
            'table' => 'members',
            'alias' => 'Sender',
            'type'  => 'inner',
            'conditions' => 'Sender.id = CooperationComplaint.sender'
        );
        $joinMemberReceiver = array(
            'table' => 'members',
            'alias' => 'Receiver',
            'type'  => 'inner',
            'conditions' => 'Receiver.id = CooperationComplaint.receiver'
        );
        
        $fields = array(
            'CooperationComplaint.id',
            'PartTime.title',
            'Information.title',
            'Sender.nickname',
            'Receiver.nickname',
            'CooperationComplaint.reason',
            'CooperationComplaint.type',
            'CooperationComplaint.status',
            'CooperationComplaint.created'
        );
        $conditions = array(
            'conditions' => $where,
            'fields'     => $fields,
            'joins'      => array($joinInformation, $joinParttime, $joinMemberSender, $joinMemberReceiver),
            'order'      =>  array($this->request->query['sidx'] . " ". $this->request->query['sord']),
            'limit'      =>  $this->request->query['rows'],
            'page'       =>  $this->request->query['page'],
        );
        $countConditions = array('conditions' => $where);
        $data = $mCooperationComplaint->find('all', $conditions);
        $count = $mCooperationComplaint->find('count', $countConditions);
        $jdata = array();
        $jdata['page'] = $this->request->query['page'];
        $jdata['total'] = $count;
        $jdata['records'] = count($data);
        $rows = array();
        foreach ($data as $value) {
            $row['id'] = $value['CooperationComplaint']['id'];
            $row['cell'] = array(
                $value['CooperationComplaint']['id'],
                $value['PartTime']['title'],
                $value['Information']['title'],
                $value['Sender']['nickname'],
                $value['Receiver']['nickname'],
                $value['CooperationComplaint']['type'],
                $value['CooperationComplaint']['reason'],
                $value['CooperationComplaint']['status'],
                $value['CooperationComplaint']['created'],
            );
            $rows[] = $row;
        }
        $jdata['rows'] = $rows;
        $this->_sendJson($jdata);
    }
    
    
    public function complaintAnswer()
    {
        $this->autoLayout = false;
        $id = $this->request->data['id'];
        //
        $result = $this->Appeal->complaint($id);
        extract($result);
        $this->set('information', $information);
        $this->set('informationAttributes', $informationAttributes);
        $this->set('parttime', $parttime);
        $this->set('sender', $sender);
        $this->set('receiver', $receiver);
        $this->set('complaint', $complaint);
        $this->set('cooperation', $cooperation);
    }
    
}