<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

    global $portal, $sugar_config;
    $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $_SESSION['user_name'], $_SESSION['user_password']);

    $where = array(
            array('name'=>'portal_viewable', 'value'=>'1', 'operator'=>'='),
            array('name'=>'type', 'value'=>'Question', 'operator'=>'='),
            array('name'=>'status', 'value'=>'Open', 'operator'=>'='),
    );

    $orderBy = 'case_number DESC';
    $case = $portal->getEntries('Cases', $where, $orderBy, $offset = 0, $limit = 20);
//    print_r($case);

?>
<!-- MY QUESTIONS -->
<?php
	for ($i=0; $i<$case['result_count']; $i++){
            $id = $case['entry_list'][$i]['name_value_list']['4']['value'];
		echo '<div class="userListCtn">';
		echo '<h2>'. $case['entry_list'][$i]['name_value_list']['5']['value'] . '</h2>';
		echo '<p>'. $case['entry_list'][$i]['name_value_list']['10']['value'] .'</p>';
?>
        <div class="userListStatCtn">
            <div class="progressCtn">
                <span><b>Status : <?php echo $case['entry_list'][$i]['name_value_list']['17']['value']; ?></b></span>
            </div>
            <div class="dateCtn">
                <span>Feb 8, 2011</span>
            </div>
            <div class="repCtn">
                <span><?php echo $case['entry_list'][$i]['name_value_list']['22']['value']; ?></span>
            </div>
            <div class="attachCtn right">
                <span><a href="#?w=610" rel="popup_name" class="poplight">Create Note</a></span>
            </div>
                <!-- CALL THE ATTACH NOTE -->
                <div id="popup_name" class="popup_block">
                   <?php
                   $returnmodule = 'myquestions';
                   $returnaction = 'myquestions';
                   include_once($attachnote);
                   ?>
                </div>

<?php
$fields = array('id','name','description');
$data = $portal->getRelated('Cases', 'Notes', $id, $fields, '', $offset = 0, $limit = -1);
//print_r($data);
$i=0;
if ($data['entry_list'][$i]['id'] != ""){
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
                        <?php while($data['entry_list'][$i]['id'] != ""){ ?>
                        <div class="noteContent left">
                            <div class="noteSubjects">
                            <?php echo $data['entry_list'][$i]['name_value_list']['1']['value']; ?> &nbsp;
                            </div>
                            <div class="noteDesc">
                            <?php echo $data['entry_list'][$i]['name_value_list']['2']['value']; ?> &nbsp;
                            </div>
                            <div class="attach">
                                Attached &nbsp;
                            </div>
                        </div>
                        <?php $i++; } ?>
                        <!-- END -->
                    </div>
                </div>
<?php } ?>
        </div>
    </div> <!-- end of userListCtn -->
<?php } ?>
<!-- END -->

