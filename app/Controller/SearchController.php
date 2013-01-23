<?php
/**
 * 
 * 我要客源，我要悬赏
 * 的检索页面，所有人可以浏览
 * @author deping_lin
 *
 */

class SearchController extends AppController
{
    public $uses = array('Category', 'Information', 'PartTime', 'Homepage', 'Fulltime');
    var $helpers = array('Js', 'City', 'Category');
    var $components = array('RequestHandler', 'Info', 'Parttime', 'SiteAnalyzes');
    var $paginate;
    /**
     * 
     * 我有客源，我要客源
     */
    public function index()
    {
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['type'] == Configure::read('UserType.company')){
            $this->redirect('/members');
        }
        if (isset($this->request->query['type'])) {
            if ($this->request->query['type'] == 'has') {
                $type = 'has';
                $infoType = '0';
                $this->set('title_for_layout', "所有客源");
            } else {
                $type = 'need';
                $infoType = '1';
                $this->set('title_for_layout', "所有悬赏");
            }
        } else {
            $type = 'need';
        }
        $conditions = array(
            'Information.type'  => $infoType,
            'Information.status <= ' => Configure::read('Information.status_flg.transaction'),
        );
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['grade'] == 2) {
            $conditions['Information.members_id != '] = $this->_memberInfo['Member']['id'];
            $conditionsSubQuery['members_id'] = $this->_memberInfo['Member']['id'];
            $db = $this->Information->getDataSource();
            $subQuery = $db->buildStatement(
                array(
                    'fields'     => array('information_id'),
                    'table'      => 'payment_transactions',
                    'alias'      => 'PaymentTransaction',
                    'limit'      => null,
                    'offset'     => null,
                    'joins'      => array(),
                    'conditions' => $conditionsSubQuery,
                    'order'      => null,
                    'group'      => null
                ),
                $this->Information
            );
            $subQuery = 'Information.id NOT IN (' . $subQuery . ')';
            $subQueryExpression = $db->expression($subQuery);
            $conditions[] = $subQueryExpression;
        }
        
        //检索条件
        if (isset($this->request->data['citys'])) {
            $conditions['OR'] = array('provincial' => $this->request->data['citys'], 'city' => $this->request->data['citys']);
        }
        if (isset($this->request->data['categorys'])) {
            $conditions['Information.industries_id'] = $this->request->data['categorys'];
        }
        if (isset($this->request->data['products'])) {
            $conditions['AND'] = array(
                array(
                    'OR' => array(
                        'Information.category' => $this->request->data['products'],
                        'Information.sub_category' => $this->request->data['products']
                    )
                )
            );
        }
        
        if (isset($this->request->params['named']['fromMenu']) && isset($this->request->data['product'])) {
            $conditions['AND'] = array(
                array(
                    'OR' => array(
                        'Information.category' => $this->request->data['product'],
                        'Information.sub_category' => $this->request->data['product']
                    )
                )
            );
        }
        
        if (isset($this->request->data['payment_method'])) {
            if ($this->request->data['payment_method'] === '0') {
                $conditions['Information.payment_type'] = 1;
            } elseif ($this->request->data['payment_method'] == '1') {
                $conditions['Information.payment_type'] = array(2, 3);
            }
        }
        
        if (isset($this->request->data['price']) && !empty($this->request->data['price'])) {
            list($min, $max) = explode('-', $this->request->data['price']);
            $min = trim($min);
            $max = trim($max);
            $conditions['AND'][] = array(
                        'OR' => array(
                            array('Information.price >= ' => $min, 'Information.price <= ' => $max),
                            array('Information.point >= ' => $min, 'Information.point <= ' => $max)
                        )
            );
        }
        
        if (isset($this->request->data['limitTime'])) {
            $limitTime = $this->request->data['limitTime'];
            if ($limitTime === '0') {
                $conditions['DATE_FORMAT(Information.created, "%Y-%m-%d")'] = date('Y-m-d', time());
            } elseif ($limitTime !== "") {
                $conditions['DATE_FORMAT(Information.created, "%Y-%m-%d") > '] = date('Y-m-d', strtotime("-$limitTime day"));
            }
        }
        $this->set('type', $type);
        if (!$this->RequestHandler->isAjax()) {
            $menuList = $this->Category->getMenuList();
            $this->set("menuList", $menuList);
            $this->currentTopBar = $type;
            $this->Info->search($conditions);
        } else {
            $this->Info->search($conditions);
            $this->render('/Elements/common/keyuan-result');
        }
        $this->log(print_r($conditions, true));
    }
    /**
     * 
     * 客源，悬赏详情页面
     */
    public function infodetail()
    {
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['type'] == Configure::read('UserType.company')){
            $this->redirect('/members');
        }
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['grade'] == 2) {
            //TODO 已经登陆，跳转到会员主页
            $this->redirect('/informations/payment/' . $this->request->query['id']);
        }
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $info = $this->Info->detail($this->request->query['id']);
            if ($info['Information']['type'] == Configure::read('Information.type.has')) {
                $this->currentTopBar = 'has';
                $this->set('title_for_layout', "客源详细");
            } else {
                $this->currentTopBar = 'need';
                $this->set('title_for_layout', "悬赏详细");
            }
        }
        
    }
    
    /**
     * 
     * 招聘信息
     */
    public function offer()
    {
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['type'] == Configure::read('UserType.company')){
            $this->redirect('/fulltimes/create');
        }
        $this->set('title_for_layout', "企业招聘");
        $this->currentTopBar = 'offer';
        $this->_graphicOffer();
        $this->_linkOffer();
    }
    /**
     * 
     * 图片区域的招聘
     */
    public function _graphicOffer()
    {
        $now = date('Y-m-d');
        $params = array(
            'conditions' => array(
                'graphic_flg' => 1,
                'start <='        => $now,
                'end >='        => $now
            ),
            'limit'    => 60,
            'order' => array('modified DESC')
        );
        $graphics = $this->Homepage->find('all', $params);
        $this->set('graphics', $graphics);
    }
    /**
     * 
     * 文字区域的招聘
     */
    
    public function _linkOffer()
    {
        $now = date('Y-m-d');
        $conditions = array(
            'Fulltime.begin <= ' => $now,
            'Fulltime.end >='   => $now
        );
        $fields = array(
            'DISTINCT(Member.id)',
            'Fulltime.post',
            'Fulltime.company',
            'Fulltime.id'
        );
        $joinMember = array(
            'table' => 'members',
            'alias' => 'Member',
            'type'  => 'inner',
            'conditions' => 'Fulltime.members_id = Member.id'
        );
        $params = array(
//            'conditions' => $conditions,
            'fields' => $fields,
            'limit' => 30,
            'order' => array('Member.modified DESC'),
            'joins' => array($joinMember)
        );
        $links = $this->Fulltime->find('all', $params);
        $this->set('links', $links);
    }
    
    public function odetail()
    {
        
    }
    
    /**
     * 
     * 兼职信息
     */
    public function parttime()
    {
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['type'] == Configure::read('UserType.company')){
            $this->redirect('/parttimes/create');
        }
        $conditions = array();
//        if (isset($this->request->data['citys'])) {
//            $conditions['OR'] = array('PartTime.provincial' => $this->request->data['citys'], 'PartTime.city' => $this->request->data['citys']);
//        }
        if (isset($this->request->data['products'])) {
            $conditions['AND'] = array(
                array(
                    'OR' => array(
                        'PartTime.category' => $this->request->data['products'],
                        'PartTime.sub_category' => $this->request->data['products']
                    )
                )
            );
        }
        if (!empty($conditions)) {
            $this->Parttime->partimeListNeed($conditions);
        } else {
            $this->Parttime->partimeListNeed();
        }
        
        if ($this->RequestHandler->isAjax()) {
            $this->render('/Elements/common/parttime-result');
        } else {
            $this->set('title_for_layout', "兼职信息");
            $this->currentTopBar = 'parttime';
        }
    }
    
    public function pdetail()
    {
        if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['type'] == Configure::read('UserType.Personal')){
            $this->redirect('/parttimes/create');
        }
        $this->set('title_for_layout', "兼职信息详情");
        $this->currentTopBar = 'parttime';
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $id = $this->request->query['id'];
            $parttime = $this->Parttime->parttimeDetail($id);
            if (!empty($parttime)) {
                $clicked = 0;
                $session = $this->Session->read('PartTime_' . $id);
                if (empty($session)) {
                    $this->PartTime->updateClickCount($id);
                    $this->Session->write('PartTime_' . $id, $id);
                    $clicked = 1;
                }
                $this->set('clicked', $clicked);
            }
        } else {
            $this->set('parttime', array());
        }
    }
    
    public function beforeRender()
    {
        $css = array(
            'common',
            'platform',
        );
        $js = array('platform', 'jquery-ui', 'retrieval');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //网站平台分析信息
        $siteAnalyze = $this->SiteAnalyzes->siteAnalyzeInfo();
        $this->set('siteAnalyzes', $siteAnalyze);
    }
}