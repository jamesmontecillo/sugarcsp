<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if (!isset($_SESSION['session_id'])){
    $_SESSION["login_error"] = 'Session Timed Out';
    header('Location: index.php?module=Users&action=Login&sessiontimeout=1');
}
require_once('include/ListView/list.php');

    if (!empty ($_REQUEST['stats'])){
        $stats = $_REQUEST['stats'];
    }else{
        $stats = 'New';
    }
    $where = array(
            array('name'=>'portal_viewable', 'value'=>'1', 'operator'=>'='),
            array('name'=>'type', 'value'=>'Problem', 'operator'=>'='),
            array('name'=>'status', 'value'=>$stats, 'operator'=>'=')
    );

    $orderBy = 'case_number DESC';

    $cases = new ListData();
    $case = $cases->processdata($stats, $where, $orderBy);

//    print_r($case);
    $result_count = $case['result_count'];

?>
<!-- MY PROBLEMS -->
<?php
	for ($i=0; $i<$result_count; $i++){
            $id = $case['entry_list'][$i]['id'];
?>
    <div class="userListCtn">
        <h2><?php echo $case['entry_list'][$i]['name_value_list']['5']['value']; ?></h2>
	<p><?php echo $case['entry_list'][$i]['name_value_list']['10']['value']; ?></p>

    	<div class="userListStatCtn">
            <div class="progressCtn">
                <span><b>Status : <?php echo $case['entry_list'][$i]['name_value_list']['17']['value']; ?></b></span>
            </div>
            <?php /* ?>
            <div class="dateCtn">
                <span>
                <?php
                    $dateentered = $case['entry_list'][$i]['name_value_list']['6']['value'];
                    $date = new DateTime($dateentered);
                    echo $date->format('m-d-Y');
                ?>
                </span>
            </div> <? */ ?>
            <?php if (!empty($case['entry_list'][$i]['name_value_list']['0']['value'])) { ?>
            <div class="repCtn">
                <span><?php echo $case['entry_list'][$i]['name_value_list']['0']['value']; ?></span>
            </div>
            <?php } ?>
            <div class="attachCtn right">
                <span><a href="#?w=610" rel="popup_name" class="poplight">Create Note</a></span>
            </div>
                <!-- CALL THE ATTACH NOTE -->
                <div id="popup_name" class="popup_block">
                   <?php
                   $returnmodule = 'myproblems';
                   $returnaction = 'myproblems';
                   include($attachnote);
                   ?>
                </div>

<?php
$fields = array('id','name','description');
$relateddata = new ListData();
$data = $relateddata->getrelateddata('Cases', 'Notes', $fields, $id);
//print_r($data);
$j=0;
if (!empty($data['entry_list'][$j]['id'])){
?>
            <div class="noteCtn right bright">
                 <span><a href="#">View Note</a></span>
            </div>
                <div class="showNote">
                    <div class="mTop30 smallFont left">
                        <div class="noteHeading left">
                            <div class="noteSubjects">Subject</div>
                            <div class="noteDesc">Note</div>
                            <div class="attach">Attachment</div>
                        </div>
                        <?php while(!empty($data['entry_list'][$j]['id'])){ ?>
                        <div class="noteContent left">
                            <div class="noteSubjects">
                            <?php echo $data['entry_list'][$j]['name_value_list']['1']['value']; ?> &nbsp;
                            </div>
                            <div class="noteDesc">
                            <?php echo $data['entry_list'][$j]['name_value_list']['2']['value']; ?> &nbsp;
                            </div>
                            <div class="attach">
                                Attached &nbsp;
                            </div>
                        </div>
                        <?php $j++; } ?>
                        <!-- END -->
                    </div>
                </div>
<?php } ?>
        </div>
    </div> <!-- end of userListCtn -->
<?php } ?>
<!-- END -->

