<?php
class GridComponent extends Component
{
    public function getWhereByFilter($filter, $aliasMap = array(), $defaultFilter = array()){
        $whereArray = $defaultFilter;
        if (!is_array($filter)){
            $filter = json_decode($filter, true);
        }
        foreach ($filter['rules'] as $rule) {
            $field = $rule['field'];
            foreach ($aliasMap as $alias => $fields) {
                if (in_array($field, $fields)){
                    $field = $alias . "." . $field;
                    break;
                }
                if (isset($fields[$field])){
                    if(preg_match('/(count|sum|max|min|avg)\(/i', $fields[$field])) {
                        $field = '';
                    } else {
                        $field = $fields[$field];
                    }
                    break;
                }
            }
            if ($field != ""){
                if (empty($rule['data'])){
                    $rule['data'] = null;
                }
                $whereArray[] = $this->_makeWhereArray($field, $rule['op'], $rule['data']);
            }
            
        }
        if ($filter['groupOp'] == 'AND'){
            return array('AND' => $whereArray);
        } else {
            return array('OR' => $whereArray);
        }
    }
    
    public function makeGridData($data)
    {
        
    }
    
    
    protected function _makeWhereArray($field, $op, $value)
    {
        /*
        bw - begins with ( LIKE val% )
        eq - equal ( = )
        ne - not equal ( <> )
        lt - little ( < )
        le - little or equal ( <= )
        gt - greater ( > )
        ge - greater or equal ( >= )
        ew - ends with (LIKE %val )
        cn - contain (LIKE %val% )
        */
        $where = array();
        switch ($op){
            case 'eq':
                if ($value === null){
                    $where['IS'] = array("$field" => null);
                } else {
                    $where[$field] = array($value);
                }
                break;
            case 'ne':
                if ($value === null){
                    $where['NOT'] = array("$field" => null);
                } else {
                    $where[$field . "<>"] = array($value);
                }
                break;
            case 'lt':
                $where[$field . " < "] = $value;
                break;
            case 'le':
                $where[$field . " <= "] = $value;
                break;
            case 'gt':
                $where[$field . " > "] = $value;
                break;
            case 'ge':
                $where[$field . " >= "] = $value;
                break;
            case 'bw':
                $where[$field . " LIKE "] = $value . "%";
                break;
            case 'ew':
                $where[$field . " LIKE "] = "%" . $value;
                break;
            case 'cn':
                $where[$field . " LIKE "] = "%" . $value . "%";
                break;
            default:
                $where[$field] = array($value);
                break;
        }
        return $where;
    }
}