<?php
class FileComponent extends Component
{
    var $name="File";
    
    public function read($filePaht, $mode = 'r')
    {
        /* file exist check */
        if (!file_exists($filePath)) {
            throw new Exception('error: file :'. $filePath .'is not exist.');
            return '';
        }
        /* permission check */
        if (!is_readable($filePath)) {
            throw new Exception('error: file :'. $filePath .'can not read.');
            return '';
        }
        $handle = fopen($filePath, $mode);
        $contents = fread($handle, filesize($filePath));
        fclose($handle);
        return $contents;
    }
    
    public function writeTextFile($filePath, $contents, $encoding = null)
    {
        if(!is_writeable($filePath)) {
            throw new Exception('error: file :'. $filePath .'can not write!');
            return false;
        }
        if(isset($encoding)) {
            $contents = mb_convert_encoding($contents, $encoding, 'auto');
        }
        return file_put_contents($filePath, $contents);
    }
    
    public function download($filePath, $fileName)
    {
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($filePath));
        readfile($filePath);
    }
    
    public function upload($inputName, $destPath, $maxSize=2048, $newFileName='', $allowTypes='', $refuseTypes='.php|.jsp|.pl|.sh|.csh|.asp|.exe')
    {
        $uploadInfo =& $_FILES["$inputName"];

        if(!empty($uploadInfo['error'])) {
            switch($uploadInfo['error']) {
                case '1':
                    return '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值。';
                    break;
                case '2':
                    return '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。';
                    break;
                case '3':
                    return '文件只有部分被上传。';
                    break;
                case '4':
                    return '没有文件被上传。';
                    break;
                case '6':
                    return '临时文件夹不存在。';
                    break;
                case '7':
                    return '文件保存失败。';
                    break;
                case '8':
                    return '不支持的文件扩展名。';
                    break;
                case '999':
                default:
                    break;
            }
        }

        $uploadName = $uploadInfo['name'];

        //--ディレクトリ一気に作成*
        if(!file_exists($destPath)) {
            //system("mkdir -p $destPath");
            mkdir($destPath, 0775, true);
        }

        if (!is_writeable($destPath)) {
            return "路径 \"$destPath\" 没有写权限。";
        }

        if (!is_uploaded_file($uploadInfo['tmp_name'])) {
            return "文件（\"".$uploadName."\"）发送错误。";
        }

        if ($maxSize > 0 && $uploadInfo['size']/1024 > $maxSize) {
            return '文件大小超出允许范围。(制限値: ' . $maxSize . 'kb)';
        }

        $fileExt = strtolower(strrchr($uploadName, "."));

        //拡張子許可チェック*
        if($fileExt == '' && !empty($allowTypes)) {
            $allowTypes = ereg_replace("\|","，",$allowTypes);
            return "文件类型不支持。".$allowTypes."文件可以上传。";
        }
        if (!empty($allowTypes)    && !strpos("|" . $allowTypes, $fileExt)) {
            $allowTypes = ereg_replace("\|","，",$allowTypes);
            return "文件类型($fileExt)不支持。".$allowTypes."文件可以上传。";
        }

        //拡張子禁止チェック*
        if (strpos("|" . $refuseTypes, $fileExt)) {
            $refuseTypes = ereg_replace("\|","，",$refuseTypes);
            return "文件类型($fileExt)不支持。".$refuseTypes."以外的文件可以上传。";
        }

        if(!empty($newFileName)) {
            $fileName = $newFileName;
        } else {
            $fileName = $uploadName;
        }

        $fullPath = "$destPath/$fileName";
        if (!move_uploaded_file($uploadInfo['tmp_name'], $fullPath)) {
            return "文件上传失败!";
        }
        return '';
    }
}