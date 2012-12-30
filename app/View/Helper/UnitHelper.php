<?php
App::uses('AppHelper', 'View/Helper');
/**
 * 
 * 站点共有的helper
 * @author lin_deping
 *
 */
class UnitHelper extends AppHelper
{
	/**
	 * 
	 * 资源天地
	 * 根据文档的类型，返回对应的小图标
	 * @param string $ext
	 * @return String
	 */
	public static function getFileIcon($ext)
	{
		$fileIconMap = array(
			'xls' => 'spanFFxls',
			'xlsx' => 'spanFFxls',
			'ppt' => 'spanFFppt',
			'pptx' => 'spanFFppt',
			'pot' => 'spanFFpot',
			'pps' => 'spanFFpps',
			'vsd' => 'spanFFvsd',
			'rtf' => 'spanFFrtf',
			'wps' => 'spanFFwps',
			'et'  => 'spanFFet',
			'dps' => 'spanFFdps',
			'pdf' => 'spanFFpdf',
			'epub'=> 'spanFFepub',
			'txt' => 'spanFFtxt',
			'folder' => 'spanFFfolder'
		);
		if (isset($fileIconMap[$ext])) {
			return $fileIconMap[$ext];
		}
		return '';
	}
}
