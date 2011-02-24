<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if (!isset($_SESSION['session_id'])){
    $_SESSION["login_error"] = 'Session Timed Out';
    header('Location: index.php?module=Users&action=Login&sessiontimeout=1');
}

global $portal, $sugar_config;
$response = $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $_SESSION['user_name'], $_SESSION['user_password']);

$search = $_REQUEST['search'];

$where = array(
    array('name'=>'portal_viewable', 'value'=>'1', 'operator'=>'='),
    array('name'=>'name', 'value'=> '%'.$search.'%', 'operator'=>'LIKE')
);

$orderBy = 'case_number DESC';
$case = $portal->getEntries('Cases', $where, $orderBy, $offset = 0, $limit = 20);
//print_r($case);
?>




<div class="mTop30 smallFont left">
    <div class="searchHeading left">
        <div class="case">Case #</div>
        <div class="subjects">Subjects</div>
        <div class="name">Account Name</div>
        <div  class="status">Status</div>
    </div>

    <?php for ($i=0; $i<$case['result_count']; $i++){ ?>
    <div class="searchContent left">
        <div class="case">
        	<?php echo $case['entry_list'][$i][name_value_list][15]['value']; ?>
        </div>
        <div class="subjects">
        	<?php echo $case['entry_list'][$i][name_value_list][5]['value']; ?>
        </div><!--
        <div class="name">
        	<?php echo $case['entry_list'][$i][name_value_list][22]['value']; ?>
        </div>-->
        <div class="status">
        	<?php echo $case['entry_list'][$i][name_value_list][17]['value']; ?>
        </div>
    </div>
    <? } ?>
    <!-- END -->
    
    <div class="searchPagenavi smallFont">
        <span class="current">Page 2 of 3</span>
        <a href="#">&laquo;</a>
        <a href="#">1</a>
        <span class="current">2</span>
        <a href="#">3</a>
        <a href="#">&raquo;</a>
    </div>
    
</div>