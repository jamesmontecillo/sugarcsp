<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $portal;

class SavePortal {
    function save($module, $action, $dataarray) {
        global $portal, $sugar_config;

        $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'],$_SESSION['user_name'],$_SESSION['user_password']);

        $result = $portal->save('Cases', $dataarray);
        $header = 'index.php?module=' . $module . '&action='.$action;
        header('Location: ' . $header);
        return $result;
    }
}

?>
