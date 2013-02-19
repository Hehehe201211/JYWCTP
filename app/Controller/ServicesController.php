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
    var $components = array('Upload', 'Thumbnail', 'Unit', 'File', 'Recommend', 'RequestHandler');
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
                list($secend, $profix) = explode('.', microtime(true));
                $descParams = array(
                    'imagepath' => Configure::read('Data.path') . $path,
                    'imagename'      => "company_profile_" . $profix,
                    'outx'      => Configure::read('Thumbnail.homepage.width'),
                    'outy'      => Configure::read('Thumbnail.homepage.height')
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $data['thumbnail'] = $path . "/company_profile_"  . $profix . "." .  $this->Upload->getExt($_FILES['thumbnail']);
                    @unlink($result['path'] . '/' . $result['name']);
                }
            }
        }
        if (isset($_FILES['thumbnail_job'])) {
            $filename = $this->_memberInfo['Member']['id'] . '_company_thumbnail_job';
            $path = TMP;
            $result = $this->Upload->upload($_FILES['thumbnail_job'], $path, $filename, "image");
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
                list($secend, $profix) = explode('.', microtime(true));
                $descParams = array(
                    'imagepath' => Configure::read('Data.path') . $path,
                    'imagename'      => "company_job_" . $profix,
                    'outx'      => Configure::read('Thumbnail.job.width'),
                    'outy'      => Configure::read('Thumbnail.job.height')
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $data['thumbnail_job'] = $path . "/company_job_" . $profix  ."." .  $this->Upload->getExt($_FILES['thumbnail_job']);
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
        $conditions = array(
            'members_id' => $this->_memberInfo['Member']['id']
        );
        if ($this->Product->find('count', array('conditions' => $conditions)) >= 5) {
            $this->redirect('material');
        }
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
        $conditions = array(
            'members_id' => $this->_memberInfo['Member']['id']
        );
        if ($this->product->find('count', array('conditions' => $conditions)) >= 5) {
            $this->redirect('material');
        }
        $data = $this->request->data;
        //TODO 上传照片处理
        $small_thumbnail = "";
        $big_thumbnail = "";
        $document_name = "";
        $document_path = "";
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
                    'outx'      => Configure::read('Thumbnail.product_small.width'),
                    'outy'      => Configure::read('Thumbnail.product_small.height')
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
                    'outx'      => Configure::read('Thumbnail.product_big.width'),
                    'outy'      => Configure::read('Thumbnail.product_bit.height')
                );
                if ($this->Thumbnail->resize($srcParams, $descParams)){
                    $big_thumbnail = $path . "/" . $time . "_big." .  $this->Upload->getExt($_FILES['big_thumbnail']);
                    @unlink($result['path'] . '/' . $result['name']);
                }
            }
        }
        
        if (isset($_FILES['document'])) {
            $path = "document/" . 
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
            $newFilename = time() . '_' . $_FILES["document"]['name'];
            $document_name = $_FILES["document"]['name'];
            $document_path = $path . "/" . $newFilename;
            $this->File->upload('document', Configure::read('Data.path') . $path, 2048, $newFilename);
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
                if (!empty($document_name)) {
                    $up['document_name'] = "'" .$document_name . "'";
                    $up['document_path'] = "'" .$document_path . "'";
                    @unlink(Configure::read('Data.path') . $data['old_document_path']);
                }
                $this->Product->updateAll($up, $conditions);
            } else {
                $data['members_id'] = $this->_memberInfo['Member']['id'];
                if (!empty($big_thumbnail)) {
                    $data['big_thumbnail'] = $big_thumbnail;
                }
                if (!empty($small_thumbnail)) {
                    $data['small_thumbnail'] = $small_thumbnail;
                }
                if (!empty($document_name)) {
                    $data['document_name'] = $document_name;
                    $data['document_path'] = $document_path;
                }
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
        $conditions = array(
            'members_id' => $this->_memberInfo['Member']['id']
        );
        if ($this->Service->find('count', array('conditions' => $conditions)) >= 5) {
            $this->redirect('material');
        }
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
        $conditions = array(
            'members_id' => $this->_memberInfo['Member']['id']
        );
        if ($this->Service->find('count', array('conditions' => $conditions)) >= 5) {
            $this->redirect('material');
        }
        $document_name = '';
        $document_path = '';
        $data = $this->request->data;
        //TODO 上传照片处理
        if (isset($_FILES['document'])) {
            $path = "document/" . 
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
            $newFilename = time() . '_' . $_FILES["document"]['name'];
            $document_name = $_FILES["document"]['name'];
            $document_path = $path . "/" . $newFilename;
            $result = $this->File->upload('document', Configure::read('Data.path') . $path, 2048, $newFilename);
            $size = $_FILES['document']['size'] / 1000;
            if (empty($result)) {
                @unlink(Configure::read('Data.path') . $data['old_document_path']);
            }
        }
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
                if (!empty($document_name)) {
                    $up['document_name'] = "'" .$document_name . "'";
                    $up['document_path'] = "'" .$document_path . "'";
                    $up['size'] = $size;
                }
                $this->Service->updateAll($up, $conditions);
            } else {
                $data['members_id'] = $this->_memberInfo['Member']['id'];
                if (!empty($document_name)) {
                    $data['document_name'] = $document_name;
                    $data['document_path'] = $document_path;
                    $data['size'] = $size;
                }
                $this->Service->save($data);
            }
        } catch (Exception $e) {
            //TODO 错误处理
            $this->log(__CLASS__ . "::". __FUNCTION__ . "() " . $e->getMessage());
        }
        $this->redirect('/services/material');
    }
    
    public function delete()
    {
        $data = $this->request->data;
        if (isset($data['id']) && !empty($data['id']) && isset($data['type']) && !empty($data['type'])) {
            if ($data['type'] == 'product') {
                $conditions = array('id' => $data['id'], 'members_id' => $this->_memberInfo['Member']['id']);
                $product = $this->Product->find('first', array('conditions' => $conditions));
                if (!empty($product)) {
                    if ($this->Product->delete($data['id'])) {
                        @unlink(Configure::read('Data.path') . $product['Product']['document_path']);
                        @unlink(Configure::read('Data.path') . $product['Product']['small_thumbnail']);
                        @unlink(Configure::read('Data.path') . $product['Product']['big_thumbnail']);
                        $result = array(
                            'result' => 'OK',
                        );
                    } else {
                        $result = array(
                            'result' => 'NG',
                            'msg'    => '服务器发送错误，请稍后重试！'
                        );
                    }
                } else {
                    $result = array(
                        'result' => 'NG',
                        'msg'    => '没有可以删除的对象！'
                    );
                }
            } elseif ($data['type'] == 'service') {
                $conditions = array('id' => $data['id'], 'members_id' => $this->_memberInfo['Member']['id']);
                $service = $this->Service->find('first', array('conditions' => $conditions));
                if (!empty($service)) {
                    if ($this->Service->delete($data['id'])) {
                        @unlink(Configure::read('Data.path') . $service['Service']['document_path']);
                        $result = array(
                            'result' => 'OK',
                        );
                    } else {
                        $result = array(
                            'result' => 'NG',
                            'msg'    => '服务器发送错误，请稍后重试！'
                        );
                    }
                } else {
                    $result = array(
                        'result' => 'NG',
                        'msg'    => '没有可以删除的对象！'
                    );
                }
            } else {
                $result = array(
                    'result' => 'NG',
                    'msg'    => '参数错误'
                );
            }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'    => '参数错误'
            );
        }
        $this->_sendJson($result);
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
        //系统信息
        $notices = $this->Unit->notice();
        $this->set('notices', $notices);
        //推荐信息
        if (!$this->RequestHandler->isAjax()){
            //系统信息
            $notices = $this->Unit->notice();
            $this->set('notices', $notices);
            if ($this->_memberInfo['Member']['type'] == Configure::read('UserType.Personal')) {
                $this->Recommend->parttime($this->_memberInfo['Member']['id'], $this->_memberInfo['Attribute']['category_id']);
                //提示各种信息所处各种状态
                $this->Recommend->PersonNoticeCount($this->_memberInfo['Member']['id']);
            } else {
                //提示各种信息所处各种状态
                $this->Recommend->CompanyNoticeCount($this->_memberInfo['Member']['id']);
            }
        }
    }
}