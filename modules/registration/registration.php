<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); ?>
<div id="regCtn">
    <div class="pagePadding pageDesign left">
        <div class="loginLogo"></div>
        <form action="index.php?module=registration&action=submit" method="POST" id="regForm">

            <!-- Reg Input Left -->
            <div class="regInput left mTop15">
                <div class="mTop15">
                    <label>First Name</label>
                    <input name="first_name" type="text" id="title7" value="" tabindex="1" />
                </div>
                <div class="mTop15">
                    <label>Email Name / Username</label>
                    <input name="email" type="text" id="title" value="" tabindex="3" />
                </div>
                <div class="mTop15">
                    <label>Street 1</label>
                    <input name="street_add1" type="text" id="title" value="" tabindex="5" />
                </div>
                <div class="mTop15">
                    <label>City</label>
                    <input name="city" type="text" id="title" value="" tabindex="7" />
                </div>
                <div class="mTop15">
                    <label>Zip</label>
                    <input name="zip" type="text" id="title" value="" tabindex="9" />
                </div>
                <div class="mTop15">
                    <label>Password</label>
                    <input id="password" name="password" type="password" value="" class="required" tabindex="11" />
                </div>
            </div>

            <!-- Reg Input Right -->
            <div class="regInput right mTop15">
                <div class="mTop15">
                    <label>Last Name</label>
                    <input name="last_name" type="text" id="title" value="" tabindex="2" />
                </div>
                <div class="mTop15">
                    <label>Phone</label>
                    <input name="phone" type="text" id="title" value="" tabindex="4"/>
                </div>
                <div class="mTop15">
                    <label>Street 2</label>
                    <input name="street_add2" type="text" id="title" value="" tabindex="6" />
                </div>
                <div class="mTop15">
                    <label>State</label>
                    <input name="state" type="text" id="title" value="" tabindex="8" />
                </div>
                <div class="mTop15">
                    <label>Country</label>
                    <input name="country" type="text" id="title" value="" tabindex="10" />
                </div>
                <div class="mTop15">
                    <label>Password Confirm</label>
                    <input name="password_confirm" type="password" value="" tabindex="12" />
                </div>
            </div>

            <!-- Reg Bottom -->
            <div class="reg-bottom left">
                <span class="mediumFont">Already a member? <a href="index.php?module=Users&action=Login">Login Here</a></span>
                <input type="submit" value="Register" name="submit" class="submit regsubmit" />
            </div>
        </form>
    </div>
</div>