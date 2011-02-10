<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); ?>
<!-- SETTING EDIT -->
<form action="index.php?module=registration&action=reg" method="POST">
    <div class="regInput left mTop15">
        <div class="mTop15">
            <label>First Name</label>
            <input name="first_name" type="text" id="title7" value="" />
        </div>
        <div class="mTop15">
            <label>Email Name</label>
            <input name="email" type="text" id="title" value="" />
        </div>
        <div class="mTop15">
            <label>Street 1</label>
            <input name="street_add1" type="text" id="title" value="" />
        </div>
        <div class="mTop15">
            <label>City</label>
            <input name="city" type="text" id="title" value="" />
        </div>
        <div class="mTop15">
            <label>Zip</label>
            <input name="zip" type="text" id="title" value="" />
        </div>
        <div class="mTop15">
            <label>Password</label>
            <input name="questiontitle" type="text" id="title" value="" />
        </div>
    </div>

    <!-- Reg Input Right -->
    <div class="regInput right mTop15">
        <div class="mTop15">
            <label>Last Name</label>
            <input name="last_name" type="text" id="title" value="" />
        </div>
        <div class="mTop15">
            <label>Phone</label>
            <input name="phone" type="text" id="title" value="" />
        </div>
        <div class="mTop15">
            <label>Street 2</label>
            <input name="street_add2" type="text" id="title" value="" />
        </div>
        <div class="mTop15">
            <label>State</label>
            <input name="state" type="text" id="title" value="" />
        </div>
        <div class="mTop15">
            <label>Country</label>
            <input name="country" type="text" id="title" value="" />
        </div>
        <div class="mTop15">
            <label>Password Confirm</label>
            <input name="questiontitle" type="text" id="title" value="" />
        </div>
    </div>

    <!-- Reg Bottom -->
    <div class="reg-bottom left">
        <input type="submit" value="Update" name="submit" class="submit regsubmit" />
    </div>
</form>