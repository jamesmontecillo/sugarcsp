<div id="contentWrapper">
    <div class="pagePadding pageDesign left">
    <!-- LEFT CONTENT -->
        <div class="ctnContent left">
            <div class="ctnTop">
                <div id="userTopmenu">
                    <div class="topmenu">
                        <ul>
                            <li class="borderRight"><a href="index.php?module=myquestions&action=index">Ask a question</a></li>
                            <li class="borderRight"><a href="index.php?module=ideas&action=index">Share an idea</a></li>
                            <li class="borderRight"><a href="index.php?module=myproblems&action=index">Report a problem</a></li>
                            <li><a href="index.php?module=FAQ&action=index">FAQ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="userSearch right">
                    <form action="index.php?module=search&action=search" method="POST">
                	<input name="search" type="text" class="search smallFont" value="Search for answers" ONFOCUS="clearDefault(this)" />
                    </form>
                </div>
            </div>
            <?php if($_REQUEST['action']=='myquestions'||$_REQUEST['action']=='myproblems'||$_REQUEST['action']=='myideas'){ ?>

            <div class="caseStat">
                <ul>
                    <li<?php if (empty($_REQUEST['stats'])){ echo ' class="caseActive" '; } ?>><a href="index.php?module=<?php echo $_REQUEST['module']; ?>&action=<?php echo $_REQUEST['action']; ?>">New</a></li>
                    <li<?php if ($_REQUEST['stats'] == 'Pending'){ echo ' class="caseActive" '; } ?>><a href="index.php?module=<?php echo $_REQUEST['module']; ?>&action=<?php echo $_REQUEST['action']; ?>&stats=Pending">Pending</a></li>
                    <li<?php if ($_REQUEST['stats'] == 'Open'){ echo ' class="caseActive" '; } ?>><a href="index.php?module=<?php echo $_REQUEST['module']; ?>&action=<?php echo $_REQUEST['action']; ?>&stats=Open">Open</a></li>
                    <li<?php if ($_REQUEST['stats'] == 'Closed'){ echo ' class="caseActive" '; } ?>><a href="index.php?module=<?php echo $_REQUEST['module']; ?>&action=<?php echo $_REQUEST['action']; ?>&stats=Closed">Closed</a></li>
                </ul>
            </div>
            <?php } ?>
            <div class="clear"></div>

