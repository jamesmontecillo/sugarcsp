<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
if (!isset($_SESSION['session_id'])){
    $_SESSION["login_error"] = 'Session Timed Out';
    header('Location: index.php?module=Users&action=Login&sessiontimeout=1');
}
?>
<!-- ASK A QUESTION -->
<form action="index.php?module=myquestions&action=save" method="POST">
    <div class="mTop30">
        <textarea name="message" rows="0" cols="0"></textarea>
        <h1 class="mTop30">Ask a question. We'll look for answers.</h1>
        <input name="questiontitle" type="text" id="title" value="" class="contentInput"/>
        <p class="mediumFont">Question Title | sum up the question in 10 words or less</p>
    </div>
    <div class="mTop15">
        <input type="submit" value="Continue" name="submit" class="submit" />
    </div>
</form>