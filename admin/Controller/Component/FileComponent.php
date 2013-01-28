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
    
    public static function upload($inputName, $destPath, $maxSize=2048, $newFileName='', $allowTypes='', $refuseTypes='.php|.jsp|.pl|.sh|.csh|.asp|.exe')
    {
        $uploadInfo =& $_FILES["$inputName"];

        if(!empty($uploadInfo['error'])) {
            switch($uploadInfo['error']) {
                case '1':
                    return 'ファイルサイズが php.ini の upload_max_filesize 設定値に超えています。';
                    break;
                case '2':
                    return 'ファイルサイズが HTML form の MAX_FILE_SIZE 設定値に超えています。';
                    break;
                case '3':
                    return 'ファイルの一部だけアップされました。';
                    break;
                case '4':
                    return 'ファイルがアップされませんでした。';
                    break;
                case '6':
                    return 'ファイルアップ用一時フォルダが見つかりません。';
                    break;
                case '7':
                    return 'ファイルの保存が失敗。';
                    break;
                case '8':
                    return '拡張子によるファイルのアップが中止。';
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
            return "ディレクトリ \"$destPath\" に書き込みできません。\nシステム管理者にお問い合わせ下さい。";
        }

        if (!is_uploaded_file($uploadInfo['tmp_name'])) {
            return "指定したファイル（\"".$uploadName."\"）が不正です。\nシステム管理者にお問い合わせ下さい。";
        }

        if ($maxSize > 0 && $uploadInfo['size']/1024 > $maxSize) {
            return 'ファイルサイズが制限値を超えています。(制限値: ' . $maxSize . 'kb)';
        }

        $fileExt = strtolower(strrchr($uploadName, "."));

        //拡張子許可チェック*
        if($fileExt == '' && !empty($allowTypes)) {
            $allowTypes = ereg_replace("\|","または",$allowTypes);
            return "ファイルタイプが正しくありません。".$allowTypes."ファイルをアップロードして下さい。";
        }
        if (!empty($allowTypes)    && !strpos("|" . $allowTypes, $fileExt)) {
            $allowTypes = ereg_replace("\|","または",$allowTypes);
            return "ファイルタイプ($fileExt)が正しくありません。".$allowTypes."ファイルをアップロードして下さい。";
        }

        //拡張子禁止チェック*
        if (strpos("|" . $refuseTypes, $fileExt)) {
            $refuseTypes = ereg_replace("\|","または",$refuseTypes);
            return "ファイルタイプ($fileExt)が正しくありません。".$refuseTypes."以外のファイルをアップロードして下さい。";
        }

        if(!empty($newFileName)) {
            $fileName = $newFileName;
        } else {
            $fileName = $uploadName;
        }

        $fullPath = "$destPath/$fileName";
        if (!move_uploaded_file($uploadInfo['tmp_name'], $fullPath)) {
            return "ファイルのアップロードうまくできませんでした!";
        }
        return '';
    }
}