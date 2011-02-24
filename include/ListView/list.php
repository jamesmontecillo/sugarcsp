<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $portal;

class ListData{
    
    function processdata($stats, $where, $orderBy){
        global $portal, $sugar_config;
        $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $_SESSION['user_name'], $_SESSION['user_password']);

        $caseresult = $portal->getEntries('Cases', $where, $orderBy, $offset = 0, $limit = 20);
        return $caseresult;
    }

    function getrelateddata($modulecase, $modulenote, $fields, $id){
        global $portal, $sugar_config;
        $reldata = $portal->getRelated($modulecase, $modulenote, $id, $fields, $orderBy = '', $offset = 0, $limit = -1);
        return $reldata;
    }
    
}
?>
