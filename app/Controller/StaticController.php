<?php
/**
 * 
 * 静态页面控制器
 * @author lin_deping
 *
 */
class StaticController extends AppController
{
    var $layout = 'static';
    var $uses = array('Template', 'TemplateTmp');
    var $helpers = array('Static');
    var $components = array('SiteAnalyzes');
    
    /**
     * 
     * 静态页面
     */
    public function index()
    {
        $this->currentTopBar = 'static';
        $template = $this->request->query['tpl'];
        $content = $this->Template->find('first', array('conditions' => array('name' => $template)));
        $menu = "";
        if (!empty($content)) {
            if (!empty($content['Template']['parent_menu'])) {
                $menu = $this->Template->find('first', array('conditions' => array('name' => $content['Template']['parent_menu'])));
                $menu = trim(urldecode(htmlspecialchars_decode($menu['Template']['content'], ENT_QUOTES)), "'");
            }
            $content = trim(urldecode(htmlspecialchars_decode($content['Template']['content'], ENT_QUOTES)));
        }
        $this->set("menu", $menu);
        $this->set('content', $content);
    }
    /**
     * 
     * 静态页面测试
     */
    public function test()
    {
        $template = $this->request->query['tpl'];
        $joinTmp = array(
            'table' => 'template_tmps',
            'alias' => 'Tmps',
            'type'  => 'left',
            'conditions' => 'Template.id = Tmps.templates_id'
        );
        $params = array(
            'fields'    => array('Template.*', 'Tmps.*'),
            'conditions' => array('Template.id' => $template),
            'joins'      => array($joinTmp)
        );
        $content = $this->Template->find('first', $params);
        $menu = "";
        if (!empty($content['Template']['parent_menu'])) {
            $menu = $this->Template->find('first', array('conditions' => array('name' => $content['Template']['parent_menu'])));
            $menu = trim(urldecode(htmlspecialchars_decode($menu['Template']['content'], ENT_QUOTES)), "'");
        }
        $content = trim(urldecode(htmlspecialchars_decode($content['Tmps']['content'], ENT_QUOTES)), "'");
        $this->set("menu", $menu);
        $this->set('content', $content);
    }
    
    public function beforeRender()
    {
        $css = array(
        'platform'
        );
        $js = array('platform');
        $this->_appendCss($css);
        $this->_appendJs($js);
        parent::beforeRender();
        //网站平台分析信息
        $siteAnalyze = $this->SiteAnalyzes->siteAnalyzeInfo();
        $this->set('siteAnalyzes', $siteAnalyze);
    }
}