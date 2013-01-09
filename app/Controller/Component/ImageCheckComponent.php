<?php
class ImageCheckComponent extends Component
{
	const WIDTH = 45;
	const HEIGHT = 23;
	public function createImage($string) 
	{
		$image = imagecreate(self::WIDTH, self::HEIGHT);
		$red = 255;
		$green = 255;
		$blue = 255;
		$color = imagecolorallocate($image, $red, $green, $blue);
		$backColor = imagecolorallocate($image, 255, 255, 255);
		$pix = imagecolorallocate($image, 187, 230, 247);
		$font = imagecolorallocate($image, 41, 163, 238);
		
		mt_srand();
		for($i=0;$i<20;$i++)
		{
			imagesetpixel($image,mt_rand(0,self::WIDTH),mt_rand(0,self::HEIGHT),$pix);
		}
		
		
		imagestring($image, 5, 5, 5, $string, $font);
		imagerectangle($image,0,0,self::WIDTH-1,self::HEIGHT-1,$font);
		header('Content-type: image/png');
		imagepng($image);
		imagedestroy($image);
	}
	
	public function random($len)
	{
		$srcstr="ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		mt_srand();
		$strs="";
		for($i=0;$i<$len;$i++){
			$strs.=$srcstr[mt_rand(0,35)];
		}
		return strtoupper($strs);
	}
}