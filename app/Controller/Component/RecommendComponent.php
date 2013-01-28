<?php
/**
 * 
 * 针对会员的一些推荐信息
 * @author deping_lin
 *
 */
class RecommendComponent extends Component
{
    var $name = 'Recommend';
    
    /**
     * 
     * 推荐简历
     */
    public function resume()
    {
        
    }
    /**
     * 
     * 推荐兼职
     */
    public function parttime($members_id, $category_id)
    {
        $mPartTime = ClassRegistry::init('PartTime');
        $conditions = array(
            'status'    => 1,
            'category'  => $category_id
        );
        $conditionsSubQuery['sender'] = $members_id;
        $db = $mPartTime->getDataSource();
        $subQuery = $db->buildStatement(
            array(
                'fields'     => array('part_times_id'),
                'table'      => 'cooperations',
                'alias'      => 'Cooperation',
                'limit'      => null,
                'offset'     => null,
                'joins'      => array(),
                'conditions' => $conditionsSubQuery,
                'order'      => null,
                'group'      => null
            ),
            $mPartTime
        );
        $subQuery = 'PartTime.id NOT IN (' . $subQuery . ')';
        $subQueryExpression = $db->expression($subQuery);
        $conditions[] = $subQueryExpression;
        
        $params = array(
            'fields'        => array('PartTime.id', 'PartTime.title', 'PartTime.area', 'PartTime.method', 'PartTime.pay', 'PartTime.pay_rate', 'PartTime.pay_method', 'PartTime.category'),
            'conditions'    => $conditions,
            'limit'         => 5,
            'order'         => array('created DESC')
        );
        $recommendParttimes = $mPartTime->find('all', $params);
        $this->controller->set('recommendParttimes', $recommendParttimes);
    }
    
    public function newCompany()
    {
        $mCompany = ClassRegistry::init('CompanyAttribute');
        $joinHomepage = array(
            'table' => 'homepages',
            'alias' => 'Homepage',
            'type'  => 'inner',
            'conditions' => 'CompanyAttribute.members_id = Homepage.members_id'
        );
        $params = array(
            'fields'=> array('CompanyAttribute.members_id', 'CompanyAttribute.thumbnail', 'CompanyAttribute.full_name', 'CompanyAttribute.business_scope', 'Homepage.domain'),
            'order' => array('CompanyAttribute.created DESC'),
            'limit' => 5,
            'joins' => array($joinHomepage)
        );
        $newCompanies = $mCompany->find('all', $params);
        $this->controller->set('newCompanies', $newCompanies);
    }
    
    
    function startup(Controller $controller)
    {
        $this->controller =$controller;
    }
}