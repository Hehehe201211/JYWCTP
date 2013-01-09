<?php
/**
 * 
 * 企业会员的企业服务管理
 * @author deping_lin
 *
 */
class ServicesController extends AppController
{
    var $layout = 'members';
    public $uses = array('Homepage', 'Product', 'Service');
    var $components = array('Upload', 'Thumbnail');
    /**
     * 
     * 公司主页
     */
    public function home()
    {
        $this->set('title_for_layout', "公司主页设置");
        $conditions = array('members_id' => $this->_memberInfo['Member']['id']);
        $homepage = $this->Homepage->find('first',array('conditions' => $conditions));
        $this->set('homepage', $homepage);
    }
    
    public function saveHome()
    {
        $data = $this->request->data;
        if (isset($_FILES['thumbnail'])) {
            $filename = $this->_memberInfo['Member']['id'] . '_company_thumbnail';
            $path = TMP;
            $result = $this->Upload->upload($_FILES['thumbnail'], $path, $filename, "image");
            if ($result['result'] == 'OK') {
                $path = "thumbnail/" . 
                        substr(md5(($this->_memberInfo['Member']['id'] / 30000 + 1)), 0, 10) . "/" . 
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
                    'imagename'      => "company_profile",
                    'outx'      => 300,
                    'outy'      => 200
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $data['thumbnail'] = $path . "/company_profile." .  $this->Upload->getExt($_FILES['thumbnail']);
                    @unlink($result['path'] . '/' . $result['name']);
                }
            }
        }
        $contact_method = array();
        foreach ($data['contact_methods'] as $key => $value) {
            $contact_method[] = array('method' => $value, 'number' => $data['contact_numbers'][$key]);
        }
        unset($data['contact_methods']);
        unset($data['contact_numbers']);
        $data['contact_method'] = json_encode($contact_method);
        $data['members_id'] = $this->_memberInfo['Member']['id'];
        $data['introduction'] = str_replace("\n", "<br/>", $data['introduction']);
        $data['introduction'] = str_replace(" ", "&nbsp;", $data['introduction']);
        if ($this->Homepage->saveHome($data)) {
            $this->redirect('/services/home');
        } else {
            //TODO
            $this->redirect('/services/home');
        }
    }
    
    /**
     * 
     * 产品及服务资料
     */
    public function material()
    {
        $this->set('title_for_layout', "产品及服务资料");
        $conditions = array(
            'members_id' => $this->_memberInfo['Member']['id']
        );
        $products = $this->Product->find('all', array('conditions' => $conditions));
        $services = $this->Service->find('all', array('conditions' => $conditions));
        
        $this->set('products', $products);
        $this->set('services', $services);
    }
    /**
     * 
     * 添加产品
     */
    public function editProduct()
    {
        if (isset($this->request->query['id'])) {
            $conditions = array(
                'id' => $this->request->query['id'],
                'members_id' => $this->_memberInfo['Member']['id']
            );
            $product = $this->Product->find('first', array('conditions' => $conditions));
            if (!empty($product)) {
                $this->set('product', $product);
            }
        }
    }
    
    public function saveProduct()
    {
        $data = $this->request->data;
        //TODO 上传照片处理
        $small_thumbnail = "";
        $big_thumbnail = "";
        $path = "thumbnail/" . 
                substr(md5(($this->_memberInfo['Member']['id'] / 30000 + 1)), 0, 10) . "/" . 
                substr(md5($this->_memberInfo['Member']['id']), 0, 10);
        if (isset($_FILES['small_thumbnail'])) {
            $time = time();
            $filename = $this->_memberInfo['Member']['id'] . $time . '_small_thumbnail';
            $tmpPath = TMP;
            $result = $this->Upload->upload($_FILES['small_thumbnail'], $tmpPath, $filename, "image");
            if ($result['result'] == 'OK') {
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
                    'imagename'      => $time . "_small",
                    'outx'      => 150,
                    'outy'      => 150
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $small_thumbnail = $path . "/" . $time . "_small." .  $this->Upload->getExt($_FILES['small_thumbnail']);
                    @unlink($result['path'] . '/' . $result['name']);
                }
            }
        }
        if (isset($_FILES['big_thumbnail'])) {
            $time = time();
            $filename = $this->_memberInfo['Member']['id'] . $time . '_big_thumbnail';
            $tmpPath = TMP;
            $result = $this->Upload->upload($_FILES['big_thumbnail'], $tmpPath, $filename, "image");
            if ($result['result'] == 'OK') {
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
                    'imagename'      => $time . "_big",
                    'outx'      => 300,
                    'outy'      => 300
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $big_thumbnail = $path . "/" . $time . "_big." .  $this->Upload->getExt($_FILES['big_thumbnail']);
                    @unlink($result['path'] . '/' . $result['name']);
                }
            }
        }
        try {
            if (isset($data['id'])) {
                $conditions = array(
                    'id' => $data['id'],
                    'members_id' => $this->_memberInfo['Member']['id']
                );
                $up = array(
                    'title'         => "'" . $data['title'] . "'",
                    'name'          => "'" . $data['name'] . "'",
                    'introduction'  => "'" . $data['introduction'] . "'",
                    'additional'    => "'" . $data['additional'] . "'"
                );
                if (!empty($big_thumbnail)) {
                    $up['big_thumbnail'] = "'" .$big_thumbnail . "'";
                    @unlink(Configure::read('Data.path') . $data['old_big_thumbnail']);
                }
                if (!empty($small_thumbnail)) {
                    $up['small_thumbnail'] = "'" .$small_thumbnail . "'";
                    @unlink(Configure::read('Data.path') . $data['old_small_thumbnail']);
                }
                $this->Product->updateAll($up, $conditions);
            } else {
                $data['members_id'] = $this->_memberInfo['Member']['id'];
                $this->Product->save($data);
            }
        } catch (Exception $e) {
            //TODO 错误处理
        }
        $this->redirect('/services/material');
    }
    
    public function _image()
    {
        
    }
    
    /**
     * 
     * 添加服务
     */
    public function editDocument()
    {
        if (isset($this->request->query['id'])) {
            $conditions = array(
                'id' => $this->request->query['id'],
                'members_id' => $this->_memberInfo['Member']['id']
            );
            $document = $this->Service->find('first', array('conditions' => $conditions));
            if (!empty($document)) {
                $this->set('document', $document);
            }
        }
    }
    
    public function saveDocument()
    {
        $data = $this->request->data;
        //TODO 上传照片处理
        try {
            if (isset($data['id'])) {
                $conditions = array(
                    'id' => $data['id'],
                    'members_id' => $this->_memberInfo['Member']['id']
                );
                $up = array(
                    'title' => "'" . $data['title'] . "'",
                    'introduction' => "'" . $data['introduction'] . "'"
                );
                $this->Service->updateAll($up, $conditions);
            } else {
                $data['members_id'] = $this->_memberInfo['Member']['id'];
                $this->Service->save($data);
            }
        } catch (Exception $e) {
            //TODO 错误处理
            $this->log(__CLASS__ . "::". __FUNCTION__ . "() " . $e->getMessage());
        }
        $this->redirect('/services/material');
    }
    
    /**
     * 
     * 广告位申请
     */
    public function advertising()
    {
        
    }
    
    public function beforeRender()
    {
        $this->currentMenu = Configure::read('Menu.serviceManager');
        $css = array(
        'member'
        );
        $js = array('member');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
    }
}