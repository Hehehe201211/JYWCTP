<?php
class SmsController extends AppController
{
    var $layout = 'members';
    var $uses = array('StationMessage', 'Friendship');
    
    public function addMsg()
    {
        $this->autoRender = false;
        if (!isset($this->request->data['receiver']) || empty($this->request->data['receiver'])) {
            $result = array(
                'result'    => 'NG',
                'msg'       => '参数不正确！'
            );
        } else {
            $data = array(
                'sender'    => $this->_memberInfo['Member']['id'],
                'receiver'  => $this->request->data['receiver'],
                'title'     => isset($this->request->data['title']) ? $this->request->data['title'] : '',
                'content'   => $this->request->data['content'],
                'type'      => $this->request->data['type'],
            );
            if ($this->StationMessage->save($data)) {
                $result = array(
                   'result'    => 'OK',
                   'msg'       => '站内信发生成功！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
    public function deleteMsg()
    {
        if (!isset($this->request->data['id']) || empty($this->request->data['id'])) {
            $result = array(
                'result' => 'NG',
                'msg'    => '参数不正确！'
            );
        } else {
            $up_data = array(
                'status' => 2
            );
            $conditons = array(
                'id'    => explode(',', $this->request->data['id']),
                'receiver' => $this->_memberInfo['Member']['id']
            );
            if ($this->StationMessage->updateAll($up_data, $conditons)) {
               $result = array(
                    'result' => 'OK',
                    'msg'    => '成功删除！'
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

    public function agree()
    {
        if (!isset($this->request->data['id']) || 
            empty($this->request->data['id'])
        ) {
            $result = array(
                'result'    => 'NG',
                'msg'       => '参数错误！'
            );
        } else {
            $conditions = array(
                'id'    => $this->request->data['id'],
                'receiver' => $this->_memberInfo['Member']['id']
            );
            $smg = $this->StationMessage->find('first', array('conditions' => $conditions));
            if (!empty($smg)) {
                try {
                    $data = array(
                        'members_id'        => $smg['StationMessage']['sender'],
                        'friend_members_id' => $smg['StationMessage']['receiver']
                    );
                    if ($this->Friendship->find('count', array('conditions' => $data)) == 0) {
                        $this->Friendship->save($data);
                    }
                    $data = array(
                        'members_id'        => $smg['StationMessage']['receiver'],
                        'friend_members_id' => $smg['StationMessage']['sender']
                    );
                    if ($this->Friendship->find('count', array('conditions' => $data)) == 0) {
                        $this->Friendship->save($data);
                    }
                    $up_data = array(
		                'status' => 2
		            );
		            $conditons = array(
		                'id'    => $this->request->data['id'],
		                'receiver' => $this->_memberInfo['Member']['id']
		            );
		            $this->StationMessage->updateAll($up_data, $conditons);
                    $result = array(
                      'result' => 'OK',
                      'msg'    => '成功添加朋友'
                    );
                } catch (Exception $e) {
                    $result = array(
                      'result' => 'NG',
                      'msg'    => '系统错误，请稍后重试！'
                    );
                }
            } else {
                $result = array(
                    'result'    => 'NG',
                    'msg'       => '无朋友请求！'
                );
            }
        }
        $this->_sendJson($result);
    }
    
}