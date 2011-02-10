<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

	global $portal, $sugar_config;
	$response = $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $_SESSION['user_name'], $_SESSION['user_password']);
	//
	//$res = $portal->getCurrentUserID();
	//$username = $_SESSION['user_name'];
	
	$where = array(
		array('name'=>'portal_viewable', 'value'=>'1', 'operator'=>'='),
		array('name'=>'case_type_c', 'value'=>'Question', 'operator'=>'=')
	);
	
	$orderBy = 'case_number DESC';
	$case = $portal->getEntries('Cases', $where, $orderBy, $offset = 0, $limit = 20);
	//print_r($case);

?>
<!-- MY QUESTIONS -->
<?php
	for ($i=0; $i<$case['result_count']; $i++){
		echo '<div class="userListCtn">';
		echo '<h2>'. $case['entry_list'][$i][name_value_list][5]['value'] . '</h2>';
		echo '<p>'. $case['entry_list'][$i][name_value_list][10]['value'] .'</p>';
?>
        <div class="userListStatCtn">
            <div class="progressCtn">
                <span><b>Status : <?php echo $case['entry_list'][$i][name_value_list][17]['value']; ?></b></span>
            </div>
            <div class="dateCtn">
                <span>Feb 8, 2011</span>
            </div>
            <div class="repCtn">
                <span><?php echo $case['entry_list'][$i][name_value_list][22]['value']; ?></span>
            </div>
        </div>
    </div> <!-- end of userListCtn -->
<?php } ?>
<!-- END -->