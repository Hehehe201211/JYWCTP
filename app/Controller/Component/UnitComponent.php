<?php
/**
 * 
 * 前台页面，公共内容
 * @author lin_deping
 *
 */
class UnitComponent extends Component
{
	/**
	 * 
	 * 公告信息
	 */
	public function notice($limit = 5)
	{
		$mNotice = ClassRegistry::init('Notice');
		$pConditions = array(
			'parent_id' => 0,
			'display'	=> 1
		);
		$parents = $mNotice->find('all', array('conditions' => $pConditions, 'order' => array('priority ASC', 'created DESC')));
		$now = date('Y-m-d');
		for ($i = 0; $i < count($parents); $i++) {
			$subConditions = array(
				'parent_id' => $parents[$i]['Notice']['id'],
				'open <= ' => $now,
				'close >= ' => $now,
				'display'	=> 1
			);
			$params = array(
				'conditions' => $subConditions, 
				'order'=> array('priority ASC', 'created DESC'), 
				'limit' => $limit
			);
			$suNotices = $mNotice->find('all', $params);
			$parents[$i]['subNotice'] = $suNotices;
		}
		return $parents;
	}
}