<?php
/**
 * 
 * 首页
 * @author lin_deping
 *
 */
class IndexController extends AppController
{
    public $uses = array('Category', 'Information', 'Notice', 'Blog', 'Question', 'Document', 'PartTime');
    var $components = array('Unit');
    public function index()
    {
    	$this->set('title_for_layout', "聚业务");
    	$css = array(
    	'common',
    	'platform',
    	'index',
    	);
    	$js = array(
    	'platform',
    	);
        $this->_appendCss($css);
        $this->_appendJs($js);
        $menuList = $this->Category->getMenuList();
        $this->set("menuList", $menuList);
        
        //blog information
        $blogComment = array(
            'table' => 'comments',
            'alias' => 'Comment',
            'type'  => 'left',
            'conditions' => 'Comment.blog_id = Blog.id'
        );
        $this->Blog->virtualFields = array(
            'cnt' => 'count(Comment.id)'
        );
        $blogParam = array(
            'fields' => array('title', 'cnt', 'Blog.modified'),
            'conditions' => array('Blog.display' => 1, 'Blog.draft' => 0, 'Blog.permission' => 0),
            'joins' => array($blogComment),
            'order' => array('Blog.modified DESC', 'cnt DESC'),
            'group' => array('Blog.id')
        );
        $blogList = $this->Blog->find('all', $blogParam);
        
        //请你支招
        $questionList = $this->Question->getQuestion(5);
        //资源天地
        $this->_resources();
        //客源，悬赏信息
        $this->_informations();
        //兼职信息
        $this->_parttimes();
        
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
    }
    /**
     * 
     * 首页资源天地
     * 显示6条
     */
    public function _resources()
    {
    	$params = array(
    		'order' => array('created DESC'),
    		'limit' => 6,
    		'conditions' => array('type' => 1)
    	);
    	$chengzhang = $this->Document->find('all', $params);
    	$params['conditions'] = array('type' => 2);
    	$peixun = $this->Document->find('all', $params);
    	$params['conditions'] = array('type' => 3);
    	$kehu = $this->Document->find('all', $params);
    	$params['conditions'] = array('type' => 4);
    	$fangan = $this->Document->find('all', $params);
    	$params['conditions'] = array('type' => 5);
    	$zongjie = $this->Document->find('all', $params);
    	$params['conditions'] = array('type' => 6);
    	$anli = $this->Document->find('all', $params);
    	$documents = array(
    		'chengzhang' => $chengzhang,
    		'peixun'	 => $peixun,
    		'kehu'		 => $kehu,
    		'fangan'	 => $fangan,
    		'zongjie'	 => $zongjie,
    		'anli'		 => $anli
    	);
    	$this->set('documents', $documents);
    }
    /**
     * 
     * 我要客源
     * 我要客源
     */
    public function _informations()
    {
    	$now = date('Y-m-d');
    	$fields = array(
    		'id',
    		'title',
    		'provincial',
    		'city',
    		'payment_type',
    		'price',
    		'point',
    		'created'
    	);
    	$params = array(
    		'conditions' => array('type' => Configure::read('Information.type.need'), 'status' => 1),
    		'fields'	 => $fields,
    		'order' 	 => array('created DESC'),
    		'limit'	 	 => 15
    	);
    	$needTaskList = $this->Information->find('all', $params);
    	$params['conditions']['type'] = Configure::read('Information.type.has');
    	$hasTaskList = $this->Information->find('all', $params);
    	$this->set('needTaskList', $needTaskList);
    	$this->set('hasTaskList', $hasTaskList);
    }
    /**
     * 
     * 我要兼职
     */
    public function _parttimes()
    {
    	$now = date('Y-m-d');
    	$conditions = array(
    		'open <= ' => $now,
    		'close >= '	=> $now,
    		'status'	=> 1
    	);
    	$fields = array(
            'PartTime.id',
            'PartTime.category',
            'PartTime.sub_category',
            'PartTime.method',
            'PartTime.created',
            'PartTime.pay',
            'PartTime.pay_rate',
            'PartTime.additional',
            'Member.company_name'
        );
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'PartTime.members_id = Member.id'
        );
        $params = array(
    		'conditions' => $conditions,
    		'order'		 => array('PartTime.created'),
    		'limit'		 => 5,
        	'fields'	 => $fields,
        	'joins' 	 => array($joinMember)
    	);
        $parttimes = $this->PartTime->find('all', $params);
        $this->set('parttimes', $parttimes);
    }
    /**
     * 
     * 公告
     */
    public function _notice()
    {
    	
    }
    /**
     * 
     * 企业服务
     */
    public function _company()
    {
    	
    }
    
}