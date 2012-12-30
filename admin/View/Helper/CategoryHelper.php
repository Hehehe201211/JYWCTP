<?php
APP::uses('AppHelper', 'View/Hepler');

class CategoryHelper extends AppHelper
{
	public $Category;
	public function __construct($View, $settings = array())
	{
		parent::__construct($View, $settings);
		$this->Category = ClassRegistry::init('Category');
	}
	
	public function getCategoryName($id)
	{
		if (empty($id)) {
			return "";
		}
		$category = $this->Category->find('first', array('conditions' => array('id' => $id), 'fields' => 'name'));
		return $category['Category']['name'];
		
	}
	
	public function parentCategoryList()
	{
	    $param = array(
            'fields' => array('id', 'name'),
            'conditions' => array('parent' => 0, 'display' => 1),
            'order' => array('priority')
        );
		$category = $this->Category->find('all', $param);
		return $category;
	}
	public function childrenCategoryList($parent_id)
	{
	    $param = array(
            'fields' => array('id', 'name'),
            'conditions' => array('parent' => $parent_id, 'display' => 1),
            'order' => array('priority')
        );
		$category = $this->Category->find('all', $param);
		return $category;
	}
}