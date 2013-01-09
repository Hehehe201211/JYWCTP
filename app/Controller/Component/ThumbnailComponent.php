<?php
/**
 * 
 * 会员上传的图片按规格进行
 * 不失真裁剪
 * @author lin_deping
 *
 */
class ThumbnailComponent extends Component
{
    var $name = 'Thumbnail';
    
    /**
     * 
     * 裁剪函数
     * 先根据原图片长宽, 和输出图片的长宽
     * 计算出输出图像的实际长宽和
     * 起点，终点
     * @param $srcFileParams
     * array(
     *  'path' => '/xx/xx/xx',
     *  'name' => 'xx.png'
     * )
     * @param $imageParams
     * array(
     *  'imagename' => 'xx',
     *  'imagepath' => '/xx/xx/xx',
     *  'outx'      => 100,
     *  'outy'      => 100,
     *  'endx'      => 200, 不是必须
     *  'endy'      => 200 不是必须
     *  )
     */
    public function resize($srcFileParams = array(), $imageParams = array())
    {
        if (empty($srcFileParams) || empty($imageParams)) {
            throw new Exception('srcFileParams or imageParams is empty');
            return false;
        }
        if (!file_exists($srcFileParams['path'] . '/' . $srcFileParams['name'])) {
            throw new Exception('source file ' . $srcFileParams['path'] . '/' . $srcFileParams['name'] . ' is not exist!');
            return false;
        }
        
        if (!file_exists($imageParams['imagepath'])) {
            if (!mkdir($imageParams['imagepath'])) {
                throw new Exception('image path is not allow');
                return false;
            }
        }
        
        $nameInfo = explode('.', $srcFileParams['name']);
        $inputImageFileExtension = $nameInfo[1];
        
        if (!empty($imageParams['imagename'])) {
            $outputFileName = $imageParams['imagename'];
        } else {
            $outputFileName = $nameInfo[0];
        }
        
        $file_src = $imageParams['imagepath'] . '/' . $outputFileName . '.' . $inputImageFileExtension;
        if (file_exists($file_src)) {
            unlink($file_src);
        }
        
        switch (strtolower($inputImageFileExtension)) {
            case 'jpg' :
                $src_image = imagecreatefromjpeg($srcFileParams['path'] . '/' . $srcFileParams['name']);
                break;
            case 'gif' :
                $src_image = imagecreatefromgif($srcFileParams['path'] . '/' . $srcFileParams['name']);
                break;
            case 'png':
                $src_image = imagecreatefrompng($srcFileParams['path'] . '/' . $srcFileParams['name']);
                break;
        }
        $src_image_x = imagesx($src_image);
        $src_image_y = imagesy($src_image);
        $ratiox = $imageParams['outx'] / $src_image_x;
        $ratioy = $imageParams['outy'] / $src_image_y;
        if (empty($imageParams['endy'])) {
            $imageParams['endy'] = $src_image_y;
        }
        
        if (empty($imageParams['endx'])) {
            $imageParams['endx'] = $src_image_x;
        }
        
        if ($ratioy > $ratiox) {
            //x 优先
            $dst_w =  $imageParams['outx'];
            //$imageParams['outx']/$src_image_x = $dst_h / $src_image_y;
            $dst_h = $imageParams['outx'] * $src_image_y / $src_image_x;
            $dst_x = 0;
            $dst_y = ($imageParams['outy'] - $dst_h) / 2;
        } else {
            //$dst_w/$src_image_x = $imageParams['outy'] / $src_image_y;
            $dst_w = $imageParams['outy'] * $src_image_x / $src_image_y;
            $dst_h = $imageParams['outy'];
            $dst_x = ($imageParams['outx'] - $dst_w) / 2;
            $dst_y = 0;
        }
        
        $desc_image = imagecreatetruecolor($imageParams['outx'], $imageParams['outy']);
        $white = imagecolorallocate($desc_image, 255, 255, 255);
        imagefilledrectangle($desc_image, 0, 0, $imageParams['outx'], $imageParams['outy'], $white);
        $createimage = imagecopyresampled($desc_image, $src_image, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $imageParams['endx'], $imageParams['endy']);
        if (!$createimage) {
            imagedestroy($desc_image);
            imagedestroy($src_image);
            throw new Exception('failure on imagecopyresampled');
            return false;
        } else {
            imagedestroy($src_image);
            switch (strtolower($inputImageFileExtension)) {
                case 'jpg' :
                    $i = imagejpeg($desc_image, $file_src);
                    break;
                case 'gif' :
                    $i = imagegif($desc_image, $file_src);
                    break;
                case 'png' :
                    $i = imagepng($desc_image, $file_src);
                    break;
            }
            imagedestroy($desc_image);
            if (!$i) {
                throw new Exception('failure to output file');
                return false;
            }
        }
        return $file_src;
    }
}