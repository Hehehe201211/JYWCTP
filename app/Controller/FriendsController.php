<?php
App::uses('CakeEmail', 'Network/Email');
class FriendsController extends AppController
{
    var $uses = array('FriendGroup', 'Friendship');
    /**
     * 
     * 添加朋友组
     */
    public function addFriendGroup()
    {
        $this->autoRender = false;
        if (isset($this->request->data['name']) && !empty($this->request->data['name'])) {
            $data = array(
                'members_id' => $this->_memberInfo['Member']['id'],
                'name'       => $this->request->data['name']
            );
            if ($this->FriendGroup->find('count', array('conditions' => $data)) <= 0) {
                if ($this->FriendGroup->save($data)) {
                    $result = array(
                        'result' => 'OK',
                        'id'     => $this->FriendGroup->id,
                        'msg'    => '成功添加朋友组！'
                    );
                } else {
                    $result = array(
                        'result' => 'NG',
                        'msg'    => '系统错误，添加失败，请稍后再试！'
                    );
                }
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '你已经添加过此分组名！'
                );
            }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'    => '参数错误，添加失败！'
            );
        }
        $this->_sendJson($result);
    }
    /**
     * 
     * 删除朋友组
     */
    public function deleteFriendGroup()
    {
        $condition = array(
            'id'    => $this->request->data['id'],
            'members_id' => $this->_memberInfo['Member']['id']
        );
        if ($this->FriendGroup->deleteFriendGroup($condition)) {
            $result = array('result' => 'OK', 'msg' => '删除成功！');
        } else {
            $result = array('result' => 'NG', 'msg' => '删除失败，请稍后重试！');
        }
        
        $this->_sendJson($result);
    }
    /**
     * 
     * 编辑好友组名称
     */
    public function editFriendGroupName()
    {
        $r_data = $this->request->data;
        $result = array();
        if (isset($r_data['id']) && !empty($r_data['id']) && 
            isset($r_data['name']) && !empty($r_data['name'])) {
            
            $condition = array(
                'members_id' => $this->_memberInfo['Member']['id'],
                'name'       => $this->request->data['name']
            );
            $exist = $this->FriendGroup->find('first', array('conditions' => $condition));
            if (!empty($exist) && $exist['FriendGroup']['id'] != $this->request->data['id']) {
                $result['result'] = 'NG';
                $result['msg'] = '此分组名已存在！';
            } else {
                $data = array(
                    'name' => "'{$this->request->data['name']}'"
                );
                $condition = array(
                    'id'    => $this->request->data['id'],
                    'members_id' => $this->_memberInfo['Member']['id']
                );
                
                if ($this->FriendGroup->updateAll($data, $condition)) {
                    $result['result'] = 'OK';
                    $result['msg'] = '修改成功！';
                } else {
                    $result['result'] = 'NG';
                    $result['msg'] = '系统错误，修改失败！请稍后重试！';
                }
            }
            
        } else {
            //TODO
            $result['result'] = 'NG';
            $result['msg'] = '参数错误，请重试！';
        }
        
        $this->_sendJson($result);
    }
    /**
     * 
     * 修改朋友的所属组
     */
    public function setFriendGroup()
    {
        $data = array(
            'friend_groups_id' => $this->request->data['friend_groups_id']
        );
        $condition = array(
            'members_id' => $this->_memberInfo['Member']['id'],
            'friend_members_id' => $this->request->data['friend_members_id']
        );
        if ($this->Friendship->updateAll($data, $condition)) {
            $result['result'] = 'OK';
            $result['msg'] = '分组已经成功修改！';
        } else {
            $result['result'] = 'NG';
            $result['msg'] = '分组修改失败，请稍后重试！';
        }
        $this->_sendJson($result);
    }
    /**
     * 
     * 删除朋友
     */
    public function deleteFriend()
    {
        if (isset($this->request->data['friend_members_id']) && !empty($this->request->data['friend_members_id'])) {
            $conditions = array(
	            'members_id' => $this->_memberInfo['Member']['id'],
	            'friend_members_id' => $this->request->data['friend_members_id']
	        );
	        if ($this->Friendship->deleteAll($conditions, false)) {
	           $result = array(
	                'result' => 'OK',
	                'msg'    => '删除成功！'
	            );
	        } else {
	           $result = array(
	                'result' => 'NG',
	                'msg'    => '删除失败，请稍后重试！'
	            );
	        }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'    => '删除失败，请稍后重试！'
            );
        }
        $this->_sendJson($result);
    }
    /**
     * 
     * 发送推荐邮件
     */
    public function sendRecommendMail()
    {
        $this->autoRender = false;
        try {
            foreach ($this->request->data['emails'] as $key => $emailaddress) {
                $body = "";
                $body .= $this->request->data['names'][$key] . "\n" . $this->request->data['content'];
                $body .= "\n免费会员注册链接: http://" . $_SERVER['SERVER_NAME'] . "/members/register?mid=" . $this->_memberInfo['Member']['id'] . "&key=" . md5($this->_memberInfo['Member']['id']);
                $email = new CakeEmail('default');
                $email->from(array($this->_memberInfo['Member']['email'] => '聚客源'));
                $email->to($emailaddress);
                $email->subject('来自聚客源的好友邀请！');
                $email->send($body);
                unset($email);
            }
            $resule = array('result' => 'OK', 'msg' => '邮件发送成功！');
        } catch (Exception $e) {
            $resule = array('result' => 'NG', 'msg' => '邮件发送失败，请稍后重试！');
        }
        $this->_sendJson($resule);
    }
    
}