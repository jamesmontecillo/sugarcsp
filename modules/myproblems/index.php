<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if (!isset($_SESSION['session_id'])){
    $_SESSION["login_error"] = 'Session Timed Out';
    header('Location: index.php?module=Users&action=Login&sessiontimeout=1');
}
?>
<!-- REPORT A PROBLEM -->
<form action="index.php?module=myproblems&action=save" method="POST">
    <div class="mTop30">
        <textarea name="message" rows="0" cols="0"></textarea>
        <h1 class="mTop30">Report a problem. We'll look for solutions.</h1>
        <input name="problemstitle" type="text" id="title" value="" class="contentInput"/>
        <p class="mediumFont">Problem Title | sum up the question in 10 words or less</p>
    </div>
    <div class="mTop15">
        <input type="submit" value="Continue" name="submit" class="submit" />
    </div>
</form>