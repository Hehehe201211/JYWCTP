<?php
/**
 * 
 * 会员注册
 * @author lin_deping
 *
 */
App::uses('CakeEmail', 'Network/Email');
class RegistersController extends AppController
{
    public function index()
    {
        
    }
    /**
     * 
     * 输入内容确认
     */
    public function check()
    {
        if (!$this->request->is('post')){
            $this->redirect("index");
        }
    }
    /**
     * 
     * 发送认证邮件
     */
    public function send()
    {
        if (!$this->request->is('post')){
            $this->redirect("index");
        }
        $this->request->data['password'] = md5($this->request->data['password']);
        $result = $this->Register->save($this->request->data);
        $email = new CakeEmail();
        $from_address = Configure::read("Register.email");
        $from = Configure::read("Register.from");
        $subject = Configure::read("Register.subject");
        $email->from(array($from_address => $from));
        $email->to('deping_lin@yahoo.co.jp');
        $email->subject($subject);
        $body = file_get_contents("files/check_mail_template.txt");
        $url = 'http://www.jukeyuan.com/registers/complete/' . $this->request->data['nickname'] . '/' . md5($this->request->data['password']);
        $body = str_replace(array("{name}", "{url}"), array($this->request->data['nickname'], $url), $body);
        $email->send($body);
    }
    
    /**
     * 
     * 邮箱认证
     */
    public function complete()
    {
        if (empty($this->request->params['pass'])){
//            $this->redirect('index');
        }
        $nickname = isset($this->request->params['pass']) ? $this->request->params['pass'][0] : "";
        $password = isset($this->request->params['pass']) ? $this->request->params['pass'][1] : "";
        
        $this->uses = array('User', 'Register', 'UserAttribute');
        $userInfo = $this->User->find('first', array('nickname' => $nickname, 'password' => $password));
        if (!empty($userInfo)){
            //TODO
            $this->Session->write('user', $userInfo);
            $this->redirect("/users/");
        } else {
            $registerInfo = $this->Register->find('first', array('nickname' => $nickname, 'password' => $password));
            if (empty($registerInfo)){
                //TODO
            } else {
                if (date('Ymd', strtotime("-7 days")) > date('Ymd', strtotime($registerInfo['Register']['created']))){
                    //TODO
                } else {
                    //TODO
                    $data = array(
                        'nickname'      => $registerInfo['nickname'],
                        'password'      => $registerInfo['password'],
                        'email'         => $registerInfo['email'],
                        'provincial_id' => $registerInfo['provincial_id'],
                        'city_id'       => $registerInfo['city_id'],
                        'category_id'   => $registerInfo['category_id'],
                        'type'          => 1
                    );
                    $result = $this->User->save($data);
                    //TODO
//                    $user_id = $result['User']['id'];
//                    $attr = array(
//                        'user_id'   => $user_id,
//                        'integral'  => Configure::read('User.default_integral'),
//                        'credit'    => Configure::read('User.credit'),
//                        'last'      => date("Y-m-d H:i:s", now)
//                    );
                }
            }
        }
        
    }
}