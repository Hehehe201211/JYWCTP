<?php
/**
 * 
 * 已过期客源控制器
 * @author deping_lin
 *
 */
class OvertimeController extends AppController
{
    var $layout = 'members';
    var $uses = array(
    	'Information', 
    	'PaymentTransaction', 
    	'InformationAttribute', 
		'Member',
	);
    var $helpers = array('Js', 'City', 'Category');
	var $components = array('RequestHandler', 'Info');
	var $paginate;
	
	public function listview()
	{
	    if (isset($this->request->query['type'])) {
            $type = $this->request->query['type'];
            if ($type != "has" && $type != "need") {
                $this->_sysDisplayErrorMsg("无过期记录！");
                return 0;
            }
        } else {
            $type = "has";
        }
        if ($type == "has") {
            $this->set('title_for_layout', "已过期客源");
            $this->set("msg", "没有已过期客源");
            $this->set("typeText", "我有客源");
        } else {
            $this->set('title_for_layout', "已过期悬赏");
            $this->set("msg", "没有已过期悬赏");
            $this->set("typeText", "我要悬赏");
        }
        $this->Info->information($this->_memberInfo['Member']['id'], $type, Configure::read('Information.status_code.overtime'));
        $this->set("type", "myself");
        if ($this->RequestHandler->isAjax()) {
            if (isset($this->request->data['jump']) && !empty($this->request->data['jump']) && !isset($this->request->params['named']['setPageSize'])) {
                $this->set('jump', $page);
            }
            $this->render('/Elements/paginator');
        }
    }
    
    
    public function detail()
    {
        
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
	}
}