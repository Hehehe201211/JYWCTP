<?php
class UploadComponent extends Component
{
    var $deafultFileExt = array(
        'doc',
        'docx',
	    'ppt',
	    'pptx',
	    'xls',
	    'xlsx',
	    'vsd',
	    'pot',
	    'pps',
	    'rtf',
	    'wps',
	    'et',
	    'dps',
	    'pdf',
	    'txt',
	    'epub',
    );
    var $defaultImageExt = array(
        'jpg',
        'jpeg',
        'png',
        'gif',
    );
    
    var $allowSize = 2000000;
    var $defaultModel = 0755;
    public function upload($file, $path, $new_file_name = "", $type = "txt")
    {
        if (empty($new_file_name)) {
            list($filename, $ext) = explode(".", $file['name']);
        } else {
            $filename = $new_file_name;
        }
        if (is_uploaded_file($file['tmp_name'])) {
            if ($this->isAllowExt($file, $type)) {
                $fileSize = $this->getSize($file);
                if ($fileSize < $this->allowSize) {
                    if (file_exists($path)) {
                        if (is_writable($path)) {
                            if (!@move_uploaded_file($file['tmp_name'], $path . "/" . $filename . "." . $this->getExt($file))){
                                $result = array(
                                    'result' => 'NG',
                                    'msg'    => 'can not upload file!'
                                );
                            } else {
                                $result = array(
                                    'result'    => 'OK',
                                    'path'      => $path,
                                    'name'      => $filename . "." . $this->getExt($file),
                                );
                            }
                        }
                    } else {
                        if (@mkdir($path, $this->defaultModel, true)) {
                            if (!@move_uploaded_file($file['tmp_name'], $path . "/" . $filename . "." . $this->getExt($file))){
                                $result = array(
                                    'result' => 'NG',
                                    'msg'    => 'can not upload file!'
                                );
                            } else {
                                $result = array(
                                    'result'    => 'OK',
                                    'path'      => $path,
                                    'name'      => $filename . "." . $this->getExt($file),
                                );
                            }
                        } else {
                            $result = array(
		                        'result' => 'NG',
		                        'msg'    => 'can not create folder!'
		                    );
                        }
                    }
                } else {
                    $result = array(
	                    'result' => 'NG',
	                    'msg'    => 'this file too big!',
                    	'file'	 => $file,
                		'type'	=> $type,
                    	'fileSize' => $fileSize
	                );
	                $this->log(__CLASS__ . "::" . __FUNCTION__ . "()" . print_r($result, true));
                }
            } else {
                $result = array(
	                'result' => 'NG',
	                'msg'    => 'this is not allow file extensions!',
                	'file'	 => $file,
                	'type'	=> $type
	            );
	            $this->log(__CLASS__ . "::" . __FUNCTION__ . "()" . print_r($result, true));
            }
        } else {
            $result = array(
                'result' => 'NG',
                'msg'    => 'this is not upload file!'
            );
        }
        return $result;
    }
    
    public function mv($srcPath, $descPath)
    {
        
    }
    
    public function getSize($file)
    {
        return $file['size'];
    }
    
    public function getName($file)
    {
        return $file['name'];
    }
    
    public function getExt($file)
    {
        $extension = explode(".", $file["name"]);
        return end($extension);
    }
    /**
     * 
     * 判断是否系统允许的文件格式
     * @param array $file
     * @param string $type
     * @return boolean
     */
    public function isAllowExt($file, $type = "txt")
    {
        if ($type == "txt") {
            return in_array($this->getExt($file), $this->deafultFileExt);
        } elseif ($type == "image") {
            return in_array($this->getExt($file), $this->defaultImageExt);
        }
        return false;
    }
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}