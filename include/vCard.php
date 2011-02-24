<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Enterprise Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/products/sugar-enterprise-eula.html
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2010 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/
/*********************************************************************************

 * Description:  
 ********************************************************************************/

class vCard{
	var $properties = array();
	var $name = 'no_name';
	function clear(){
		$this->properties = array();	
	}
	function loadContact($contactid, $module='Contact'){
			require_once("modules/".$module."s/$module.php");
			$contact = new $module();
			$contact->retrieve($contactid);
			$this->setName(from_html($contact->first_name), from_html($contact->last_name), from_html($contact->salutation));
			$this->setBirthDate(from_html($contact->birthdate));
			$this->setPhoneNumber(from_html($contact->phone_fax), 'FAX');
			$this->setPhoneNumber(from_html($contact->phone_home), 'HOME');
			$this->setPhoneNumber(from_html($contact->phone_mobile), 'CELL');
			$this->setPhoneNumber(from_html($contact->phone_work), 'WORK');
			$this->setEmail(from_html($contact->email1));
			$this->setAddress(from_html($contact->primary_address_street), from_html($contact->primary_address_city), from_html($contact->primary_address_state), from_html($contact->primary_address_postalcode), from_html($contact->primary_address_country), 'WORK');
			$this->setORG(from_html($contact->account_name), from_html($contact->department));
			$this->setTitle(from_html($contact->title));
	}
	
	function setTitle($title){
		$this->setProperty("TITLE",$title );	
	}
	function setORG($org, $dep){
		$this->setProperty("ORG","$org;$dep" );	
	}
	function setAddress($address, $city, $state,$postal, $country, $type){
		$this->setProperty("ADR;$type",";;$address;$city;$state;$postal;$country" );	
	}
	
	function setName($first_name, $last_name, $prefix){
		$this->name = strtr($first_name.'_'.$last_name, ' ' , '_');
		$this->setProperty('N',$last_name.';'.$first_name.';'.$prefix );
		$this->setProperty('FN',"$prefix $first_name $last_name"); 
	}
	
	function setEmail($address){
		$this->setProperty('EMAIL;INTERNET', $address);
	}
	
	function setPhoneNumber( $number, $type){
		$this->setProperty("TEL;$type", $number);
	}
	function setBirthDate($date){
			$this->setProperty('BDAY',$date);
	}
	function getProperty($name){
		if(isset($this->properties[$name]))
			return $this->properties[$name];
		return null;	
	}
	
	function setProperty($name, $value){
		$this->properties[$name] = $value;		
	}
	
	function toString(){
		$temp = "BEGIN:VCARD\n";
		foreach($this->properties as $key=>$value){
			$temp .= $key. ':'.$value."\n";	
		}	
		$temp.= "END:VCARD\n";
		return $temp;
	}	
	
	function saveVCard(){
		global $locale;
		
		$content = $this->toString();
		header("Content-Disposition: attachment; filename={$this->name}.vcf");
		header("Content-Type: text/x-vcard; charset=".$locale->getExportCharset());
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
		header("Cache-Control: max-age=0");
		header("Pragma: public");
		header("Content-Length: ".strlen($content));

		print $locale->translateCharset($content, 'UTF-8', $locale->getExportCharset());
	}
	
	function importVCard($filename, $module='Contact'){
		global $current_user;
		$lines =	file($filename);
		$start = false;
		require_once("modules/".$module."s/$module.php");
		$contact = new $module();
		$contact->title = 'imported';
		$contact->assigned_user_id = $current_user->id;
		$fullname = '';
		for($index = 0; $index < sizeof($lines); $index++){
			$line = $lines[$index];
			
			$line = trim($line);
			if($start){
				//VCARD is done
				if(substr_count(strtoupper($line), 'END:VCARD')){
					if(!isset($contact->last_name)){
						$contact->last_name = $fullname;	
					}
					return $contact->save();
					
				}
				$keyvalue = split(':',$line);
				if(sizeof($keyvalue)==2){
					$value = $keyvalue[1];
					for($newindex= $index + 1;  $newindex < sizeof($lines), substr_count($lines[$newindex], ':') == 0; $newindex++){
							$value .= $lines[$newindex];
							$index = $newindex;
					}
					$values = split(';',$value );
					$key = strtoupper($keyvalue[0]);
					$key = strtr($key, '=', '');
					$key = strtr($key, ',',';');
					$keys = split(';' ,$key);
					
					if($keys[0] == 'TEL'){
						if(substr_count($key, 'WORK') > 0){
								if(substr_count($key, 'FAX') > 0){
										if(!isset($contact->phone_fax)){
											$contact->phone_fax = $value;
										}
								}else{
									if(!isset($contact->phone_work)){
											$contact->phone_work = $value;
									}	
								}
						}
						if(substr_count($key, 'HOME') > 0){
								if(substr_count($key, 'FAX') > 0){
										if(!isset($contact->phone_fax)){
											$contact->phone_fax = $value;
										}
								}else{
									if(!isset($contact->phone_home)){
											$contact->phone_home = $value;
									}	
								}
						}
						if(substr_count($key, 'CELL') > 0){
								if(!isset($contact->phone_mobile)){
										$contact->phone_mobile = $value;
								}	
								
						}
						if(substr_count($key, 'FAX') > 0){
										if(!isset($contact->phone_fax)){
											$contact->phone_fax = $value;
						}
						
						}
							
					}
					if($keys[0] == 'N'){
						if(sizeof($values) > 0)
							$contact->last_name = $values[0];
						if(sizeof($values) > 1)
							$contact->first_name = $values[1];
						
						
						
							
					}
					if($keys[0] == 'FN'){
						$fullname = $value;				
						
							
					}
					
	}
					if($keys[0] == 'ADR'){
						if(substr_count($key, 'WORK') > 0 && (substr_count($key, 'POSTAL') > 0|| substr_count($key, 'PARCEL') == 0)){

								if(!isset($contact->primary_address_street) && sizeof($values) > 2){
										$contact->primary_address_street = $values[2];
								}
								if(!isset($contact->primary_address_city) && sizeof($values) > 3){
										$contact->primary_address_city = $values[3];
								}
								if(!isset($contact->primary_address_state) && sizeof($values) > 4){
										$contact->primary_address_state = $values[4];
								}
								if(!isset($contact->primary_address_postalcode) && sizeof($values) > 5){
										$contact->primary_address_postalcode = $values[5];
								}
								if(!isset($contact->primary_address_country) && sizeof($values) > 6){
										$contact->primary_address_country = $values[6];
								}
						}
					}
					
					if($keys[0] == 'TITLE'){
						$contact->title = $value;
						
					}
					if($keys[0] == 'EMAIL'){
						if(!isset($contact->email1)){
							$contact->email1 = $value;
						}else if(!isset($contact->email2)){
							$contact->email2 = $value;
						}
						
					}
					
					if($keys[0] == 'ORG'){
						if(sizeof($values) > 1){
								$contact->department = $values[1];
						}
						
					}
					
				}
					
				
					
			
			//FOUND THE BEGINING OF THE VCARD
			if(!$start && substr_count(strtoupper($line), 'BEGIN:VCARD')){
				$start = true;	
			}
			
		}

		return $contact->save();
	}
	}
	
	
	
	
	



?>