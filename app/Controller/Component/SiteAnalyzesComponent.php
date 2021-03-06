<?php
/**
 * 
 * 前端页面，网站平台分析信息
 * @author lin_deping
 *
 */
class SiteAnalyzesComponent extends Component
{
    var $name = "SiteAnalyzes";
    public function siteAnalyzeInfo()
    {
        $tomorrow       = date('Y-m-d', strtotime("+1 day"));
        $today          = date('Y-m-d');
        $yesterday      = date('Y-m-d', strtotime("-1 day"));
        $currentWeek    = date("Y-m-d",mktime(0, 0 , 0,date("m"),date("d")-date("w"),date("Y")));
        $currentMonth   = date('Y-m') . '-01';
        $mSiteAnalyze   = ClassRegistry::init('SiteAnalyze');
        $mSiteAnalyze->virtualFields = array(
            'personSum' => 'SUM(person)',
            'companySum' => 'SUM(company)',
            'hasSum' => 'SUM(has)',
            'needSum' => 'SUM(need)',
            'resumeSum' => 'SUM(resume)',
            'fulltimeSum' => 'SUM(fulltime)',
            'parttimeSum' => 'SUM(parttime)'
        );
        $yesterdayConditions = array(
            'target_date' => $yesterday,
        );
        $lastWeekConditions = array(
            'target_date >= ' => $currentWeek,
            'target_date < ' => $today
        );
        $lastMonthConditions = array(
            'target_date >= ' => $currentMonth,
            'target_date <= ' => $today
        );
        $allConditions = array(
            'target_date <= ' => $tomorrow
        );
        $yesterdayInfo  = $mSiteAnalyze->find('first', array('conditions' => $yesterdayConditions));
        $lastWeekInfo   = $mSiteAnalyze->find('first', array('conditions' => $lastWeekConditions));
        $lastMonthInfo  = $mSiteAnalyze->find('first', array('conditions' => $lastMonthConditions));
        $allInfo        = $mSiteAnalyze->find('first', array('conditions' => $allConditions));
        return array(
            'yester'    => $yesterdayInfo,
            'lastWeek'   => $lastWeekInfo,
            'lastMonth' => $lastMonthInfo,
            'all'       => $allInfo
        );
    }
}