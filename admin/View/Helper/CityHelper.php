<?php
App::uses('AppHelper', 'View/Helper');

class CityHelper extends AppHelper
{
    public $City;
    public function __construct(View $View, $settings = array())
    {
        parent::__construct($View, $settings);
        $this->City = ClassRegistry::init('City');
    }
    public function cityName($id)
    {
        if (empty($id)) {
            return '';
        }
        //TODO memcache;
        
        $city = $this->City->find('first', array('conditions' => array('id' => $id), 'fields' => 'name'));
        //TODO save into memcache 
        return $city['City']['name'];
    }
    
    public function parentCityList()
    {
        $cityParam = array(
		  'fields' => array('id', 'name'),
		  'conditions' => array('parent' => 0, 'display' => 1),
		  'order' => array('priority')
		);
		$city = $this->City->find('all', $cityParam);
		return $city;
    }
    
    public function childrenCityList($parent_id)
    {
        $cityParam = array(
		  'fields' => array('id', 'name'),
		  'conditions' => array('parent' => $parent_id, 'display' => 1),
		  'order' => array('priority')
		);
		$city = $this->City->find('all', $cityParam);
		return $city;
    }
}