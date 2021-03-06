<?php
/**
 * 企业会员公司主要相关
 * @author lin_deping
 */

class HomesController extends AppController
{
    var $layout = 'homes';
    var $uses = array('Homepage', 'CompanyAttribute', 'Service', 'Product', 'Fulltime', 'PartTime');
    var $components = array('Ft', 'Parttime', 'RequestHandler', 'Unit', 'File');
    var $helpers = array('Js', 'City', 'Category');
    
    /**
     * 
     * Enter description here ...
     */
    public function index($domain)
    {
        if (!isset($domain)) {
            //TODO
            return 0;
        }
        $this->_getHomepage($domain);
    }
    /**
     * 
     * 产品或服务
     */
    public function service($domain)
    {
        if (!isset($domain)) {
            //TODO
            return 0;
        }
        $homepage = $this->_getHomepage($domain);
        $products = $this->Product->find('all', array('conditions' => array('members_id' => $homepage['Homepage']['members_id'])));
        $this->set('products', $products);
    }
    /**
     * 
     * 资料下载
     */
    public function download($domain)
    {
        if (!isset($domain)) {
            //TODO
            return 0;
        }
        $homepage = $this->_getHomepage($domain);
        $documents = $this->Service->find('all', array('conditions' => array('members_id' => $homepage['Homepage']['members_id'])));
        $this->set('documents', $documents);
    }
    /**
     * 
     * 产品或服务资料下载
     */
    public function download_product()
    {
        $this->autoRender = FALSE;
        $this->log('test');
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $id = $this->request->query['id'];
            $product = $this->Product->find('first', array('conditions' => array('id' => $id)));
            if (!empty($product)) {
                $filePath = Configure::read('Data.path') . $product['Product']['document_path'];
                $this->File->download($filePath, $product['Product']['document_name']);
            }
        }
    }
    /**
     * 
     * 资料下载
     */
    public function download_service()
    {
        $this->autoRender = FALSE;
        if (isset($this->request->query['id']) && !empty($this->request->query['id'])) {
            $id = $this->request->query['id'];
            $service = $this->Service->find('first', array('conditions' => array('id' => $id)));
            if (!empty($service)) {
                $download_cnt = $service['Service']['download_cnt'] + 1;
                $up = array('download_cnt' => $download_cnt);
                $this->Service->updateAll($up, array('id' => $id));
                $filePath = Configure::read('Data.path') . $service['Service']['document_path'];
                $this->File->download($filePath, $service['Service']['document_name']);
            }
        }
    }
    
    /**
     * 
     * 招聘岗位
     */
    public function fulltime($domain)
    {
        if (!isset($domain)) {
            //TODO
            return 0;
        }
        $homepage = $this->_getHomepage($domain);
        $conditions = array(
            'members_id' => $homepage['Homepage']['members_id']
        );
        $this->Ft->fulltimeList($conditions);
        if ($this->RequestHandler->isAjax()) {
            $this->render('fulltime-paginator');
        }
    }
    
    public function detailFulltime()
    {
        $id = $this->request->data['id'];
        $fulltime = $this->Fulltime->find('first', array('conditions' => array('id' => $id)));
        if ($fulltime['Fulltime']['members_id'] != $this->_memberInfo['Member']['id']) {
            //TODO
            //如果不是本人发布的职位，这个时候就要显示发布人的信息
        }
        $this->set('fulltime', $fulltime);
    }
    
    /**
     * 
     * 兼职
     */
    public function parttime($domain)
    {
        if (!isset($domain)) {
            //TODO
            return 0;
        }
        $homepage = $this->_getHomepage($domain);
        $conditions = array(
            'members_id' => $homepage['Homepage']['members_id']
        );
        $this->Parttime->partimeList($homepage['Homepage']['members_id']);
        if ($this->RequestHandler->isAjax()) {
            $this->render('parttime-paginator');
        }
    }
    
    public function detailParttime()
    {
        $id = $this->request->data['id'];
        $detail = $this->Parttime->parttimeDetail($id);
        if (!empty($detail)) {
            $clicked = 0;
            $session = $this->Session->read('PartTime_' . "_" . $id);
            if (empty($session)) {
                if (!empty($this->_memberInfo) && $this->_memberInfo['Member']['id'] != $detail['Parttime']['members_id']) {
	                $this->PartTime->updateClickCount($id);
	                $this->Session->write('PartTime_' . $id, $id);
	                $clicked = 1;
                }
            }
            $this->set('clicked', $clicked);
        }
    }
    
    /**
     * 
     * 联系方式
     */
    public function contact($domain)
    {
        if (!isset($domain)) {
            //TODO
            return 0;
        }
        $this->_getHomepage($domain);
    }
    
    public function _getHomepage($domain)
    {
        $homepage = $this->Homepage->find('first', array('conditions' => array('domain' => $domain)));
        if (empty($homepage)) {
            //TODO
            return 0;
        }
        $params = array(
            'fields' => array('full_name', 'thumbnail'),
            'conditions' => array('members_id' => $homepage['Homepage']['members_id'])
        );
        $companyName = $this->CompanyAttribute->find('first', $params);
        
        $this->set('homepage', $homepage);
        $this->set('title_for_layout', $companyName['CompanyAttribute']['full_name']);
        $this->set('company_thumbnail', $companyName['CompanyAttribute']['thumbnail']);
        $this->set('domain', $domain);
        return $homepage;
    }
    
    public function beforeRender()
    {
        $css = array(
        'ui/jquery-ui',
        'gsqt'
        );
        $js = array('member', 'jquery-ui');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
    }
    
}