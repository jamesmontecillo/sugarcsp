<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

global $portal, $sugar_config;
$response = $portal->login($sugar_config['portal_username'], $sugar_config['portal_password'], $_SESSION['user_name'], $_SESSION['user_password']);

$res = $portal->getCurrentUserID();
$data = $portal->getEntry('Contacts', $res['id'], 
        array(
            'first_name',
            'last_name',
            'email1',
            'phone_mobile',
            'primary_address_street',
            'primary_address_city',
            'primary_address_state',
            'primary_address_postalcode',
            'primary_address_country',
            )
        );

//print_r($data);
$session_id = $response['id'];

//$dataarray = array(
//    array('name' => 'id', 'value' => $res['id']),
//    array('name' => 'description', 'value' => 'Pogi'),
//);
//print_r($portal->getFields('Contacts'));
//print_r($portal->soapClientProxy->portal_set_entry($session_id, 'Contacts', $dataarray));
?>
<!-- SETTING EDIT -->
<form action="index.php?module=settings&action=update" method="POST">
    <div class="regInput left mTop15">
        <div class="mTop15">
            <label>First Name</label>
            <input name="first_name" type="text" id="title7" value="<?php echo $data['data']['first_name']; ?>" />
        </div>
        <div class="mTop15">
            <label>Email Name</label>
            <input name="email" type="text" id="title" value="<?php echo $data['data']['email1']; ?>" />
        </div>
        <div class="mTop15">
            <label>Street 1</label>
            <input name="street_add1" type="text" id="title" value="<?php echo $data['data']['primary_address_street']; ?>" />
        </div>
        <div class="mTop15">
            <label>City</label>
            <input name="city" type="text" id="title" value="<?php echo $data['data']['primary_address_city']; ?>" />
        </div>
        <div class="mTop15">
            <label>Zip</label>
            <input name="zip" type="text" id="title" value="<?php echo $data['data']['primary_address_postalcode']; ?>" />
        </div>
        <!--
        <div class="mTop15">
            <label>Password</label>
            <input name="questiontitle" type="text" id="title" value="<?php echo $data['data']['email1']; ?>" />
        </div>-->
    </div>

    <!-- Reg Input Right -->
    <div class="regInput right mTop15">
        <div class="mTop15">
            <label>Last Name</label>
            <input name="last_name" type="text" id="title" value="<?php echo $data['data']['last_name']; ?>" />
        </div>
        <div class="mTop15">
            <label>Phone</label>
            <input name="phone" type="text" id="title" value="<?php echo $data['data']['phone_mobile']; ?>" />
        </div>
        <!--
        <div class="mTop15">
            <label>Street 2</label>
            <input name="street_add2" type="text" id="title" value="<?php echo $data['data']['email1']; ?>" />
        </div>-->
        <div class="mTop15">
            <label>State</label>
            <input name="state" type="text" id="title" value="<?php echo $data['data']['primary_address_state']; ?>" />
        </div>
        <div class="mTop15">
            <label>Country</label>
            <input name="country" type="text" id="title" value="<?php echo $data['data']['primary_address_country']; ?>" />
        </div>
        <!--
        <div class="mTop15">
            <label>Password Confirm</label>
            <input name="questiontitle" type="text" id="title" value="<?php echo $data['data']['email1']; ?>" />
        </div>-->
    </div>

    <!-- Reg Bottom -->
    <div class="reg-bottom left">
        <input type="submit" value="Update" name="submit" class="submit regsubmit" />
    </div>
</form>