<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); ?>
<!-- SHARE AN IDEA -->
<form action="index.php?module=ideas&action=save" method="POST" >
    <div class="mTop30">
        <textarea name="message" rows="0" cols="0"></textarea>
        <h1 class="mTop30">Share an idea. We'll see if other people have this idea, too.</h1>
        <input name="questiontitle" type="text" id="title" value="" class="contentInput"/>
        <p class="mediumFont">Idea Title | sum up the idea in 10 words or less</p>
    </div>
    <div class="mTop15">
        <input type="submit" value="Continue" name="submit" class="submit" />
    </div>
</form>
        