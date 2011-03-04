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
            array('name'=>'type', 'value'=>'Question', 'operator'=>'='),
            array('name'=>'status', 'value'=>$stats, 'operator'=>'=')
    );

    $orderBy = 'case_number DESC';

    $cases = new ListData();
    $case = $cases->processdata($stats, $where, $orderBy);

//    $neededdata = array('assigned_user_name','name', 'description','status');

    foreach ($case['entry_list'] as $casedata){
        $id = $casedata['id'];
//        foreach ($casedata['name_value_list'] as $casevalue){
//            foreach ($neededdata as $data){
//                if ($casevalue['name']==$data){
////                    echo $casevalue['value'];
//                }
//            }
////            print_r($casevalue);
//        }
//        print_r($casedata);
//    }
//    print_r($case);

?>
<!-- MY QUESTIONS -->
    <div class="userListCtn">
        <h2><?php echo $casedata['name_value_list']['5']['value']; ?></h2>
	<p><?php echo $casedata['name_value_list']['10']['value']; ?></p>

        <div class="userListStatCtn">
            <div class="progressCtn">
                <span><b>Status : <?php echo $casedata['name_value_list']['17']['value']; ?></b></span>
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
            <?php if (!empty($casedata['name_value_list']['0']['value'])) { ?>
            <div class="repCtn">
                <span><?php echo $casedata['name_value_list']['0']['value']; ?></span>
            </div>
            <?php } ?>
            <div class="attachCtn right">
                <span><a href="#?w=610" rel="popup_name_<?php echo $id; ?>" class="poplight">Create Note</a></span>
            </div>
                <!-- CALL THE ATTACH NOTE -->
                <div id="popup_name_<?php echo $id; ?>" class="popup_block">
                   <?php
                   $returnmodule = 'myquestions';
                   $returnaction = 'myquestions';
                   include($attachnote);
                   ?>
                </div>

        <?php
        $fields = array('id','name','description','filename');
        $relateddata = new ListData();
        $notedata = $relateddata->getrelateddata('Cases', 'Notes', $fields, $id);
        //print_r($data);
        if (!empty($notedata['entry_list'][0]['id'])){
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
                        <?php
                        foreach ($notedata['entry_list'] as $notevalue){
//                                    echo $notevalue['id'];
//                                    print_r($notevalue);
                            if (!empty($notevalue['id'])){
                        ?>
                        <div class="noteContent left">
                            <div class="noteSubjects">
                            <?=$notevalue['name_value_list']['1']['value']?> &nbsp;
                            </div>
                            <div class="noteDesc">
                            <?php
                            $notedescription = $notevalue['name_value_list']['3']['value'];
                            $title='';
                            $title1 = '';
                            $title2 = '';
                                if (strlen($notedescription) > 30){
                                    $val = strlen($notedescription)-30;
                                    $title1 = substr($notedescription,0,-$val);
                                    echo $title1 .= "<span class='noteread-more'><a href='#'>Read More</a></span>";

                                    $title2 = substr($notedescription,30);

                                    $pos = strpos($title2, " ");
                                    if(empty($pos)){
                                        while(strlen($title2) > 0){
                                            $val2 = strlen($title2)-30;
                                            $title .= substr($title2,0,-$val2) . "\n";

                                            $title2 = substr($title2,30);
                                        }
                                        $title2 = $title;
                                    }
                                    echo "<dt class='read-more'>-".$title2."</dt>";
                                }else{
                                    echo $notedescription ;
                                }

                            ?> &nbsp;
                            </div>
                            <div class="attach">
                            <?php
                            $attach = $notevalue['name_value_list']['2']['value'];

                                if (strlen($attach)>17){
                                    $pos = strpos($attach, " ");
                                    if(empty($pos)){
                                        while(strlen($attach) > 0){
                                            $val = strlen($attach)-17;
                                            $att .= substr($attach,0,-$val) . "\n";

                                            $attach = substr($attach,17);
                                        }
                                        $attach = $att;
                                    }
                                }
                                echo $attach;
                            ?> &nbsp;
                            </div>
                        </div>
                        <?php
                            }
                        }
                        ?>
                        <!-- END -->
                    </div>
                </div>
        <?php } ?>
        </div>
    </div> <!-- end of userListCtn -->
<?php } ?>
<!-- END -->

