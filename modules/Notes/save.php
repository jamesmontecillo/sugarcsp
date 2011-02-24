<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('include/upload_file.php');
global $portal, $sugar_config;
$portal->login($sugar_config['portal_username'], $sugar_config['portal_password'],$_SESSION['user_name'],$_SESSION['user_password']);

$module = 'Notes';

$dataValues = array();
$dataToSave = array('name', 'description');
foreach($dataToSave as $name) {
    if(!empty($_REQUEST[$name]))
        $dataValues[] = array('name' => $name, 'value' => $_REQUEST[$name]);
}
$result = $portal->save($module, $dataValues);
//print_r($result);
print_r($portal->relateNote($result['id'],'Cases',$_REQUEST['id']));

$noteId = $result['id'];
if(!empty($_FILES['filename'])) {
    $portal->setAttachmentToNote($noteId, $_FILES['filename']['tmp_name'], $_FILES['filename']['name']);
}

if(!empty($_REQUEST['returnmodule']) && !empty($_REQUEST['returnaction']) && !empty($_REQUEST['stats']) && !empty($_REQUEST['id'])) {
    $header = 'index.php?module=' . $_REQUEST['returnmodule'] . '&action=' . $_REQUEST['returnaction'] . '&stats=' . $_REQUEST['stats'] . '&id=' . $_REQUEST['id'];
}else{
    $header = 'index.php?module='.$_REQUEST['returnmodule'].'&action='. $_REQUEST['returnaction'];
}

//header('Location: ' . $header);
?>