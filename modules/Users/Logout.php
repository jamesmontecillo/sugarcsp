<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $portal;
$portal->logout();

session_destroy();

// go to the login screen.
header("Location: index.php?module=Users&action=Login");
?>
