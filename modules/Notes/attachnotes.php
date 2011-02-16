<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); ?>
<form action="index.php?module=Notes&action=save" method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="returnmodule" value="<?php echo $returnmodule; ?>" />
    <input type="hidden" name="returnaction" value="<?php echo $returnaction; ?>" />
    <div class="mediumFont">
        <label class="left">Subject<br/>
            <input type="text" name="name" class="contentInput" />
        </label>

        <label class="mTop15 left">Note <br/>
            <textarea name='description'></textarea>
        </label>

        <label class="mTop15 left">Attachment <br/>
            <input type="file" name="filename" class="contentInput" />
        </label>

        <label class="mTop15 left"><br/>
            <input type="submit" name="Submit" value="Attach Note" class="submit" />
        </label>
    </div>
</form>

