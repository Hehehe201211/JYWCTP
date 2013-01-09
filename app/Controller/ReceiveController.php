<?php
/**
 * 
 * 收到信息控制器
 * @author deping_lin
 *
 */
class ReceiveController extends AppController
{
    var $layout = 'members';
    var $uses = array(
    	'Information', 
    	'PaymentTransaction', 
    	'InformationAttribute', 
		'Member',
	);
    var $helpers = array('Js', 'City', 'Category');
	var $components = array('RequestHandler', 'Info');
	var $paginate;
	
	public function listview()
	{
	    
    }
    
    
    public function detail()
    {
        
    }
}