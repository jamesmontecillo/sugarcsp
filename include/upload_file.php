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
require_once('config.php');

class UploadFile {

	var $field_name;
	var $stored_file_name;
	var $original_file_name;
	var $temp_file_location;
	var $use_soap = false;
	var $file;
	var $file_ext;
	
	function UploadFile ($field_name) {
		// $field_name is the name of your passed file selector field in your form
		// i.e., for Emails, it is "email_attachmentX" where X is 0-9
		$this->field_name = $field_name;
	}

	function set_for_soap($filename, $file) {
		$this->stored_file_name = $filename;
		$this->use_soap = true;
		$this->file = $file;
	}

	function get_url($stored_file_name,$bean_id) {
		global $sugar_config;
		return UploadFile::get_file_path($stored_file_name,$bean_id);
	}
	
	function get_file_path($stored_file_name,$bean_id) {
		global $sugar_config;
		return $sugar_config['upload_dir'] . $bean_id . rawurlencode($stored_file_name);
	}

	function duplicate_file($old_id, $new_id, $file_name) {
		global $sugar_config;

		$source = $sugar_config['upload_dir'] . $old_id . $file_name;
		$destination = $sugar_config['upload_dir'] . $new_id . $file_name;
		copy($source, $destination);
	}

	function confirm_upload()
	{
		global $sugar_config;

		if (!is_uploaded_file($_FILES[$this->field_name]['tmp_name']) )
		{
			return false;
		}
		else if ($_FILES[$this->field_name]['size'] > $sugar_config['upload_maxsize'])
		{
			die("ERROR: uploaded file was too big: max filesize: {$sugar_config['upload_maxsize']}");
		}

		if(!is_writable($sugar_config['upload_dir']))
		{
			die ("ERROR: cannot write to directory: {$sugar_config['upload_dir']} for uploads");
		}


		$this->mime_type =$this->getMime($_FILES[$this->field_name]);
		$this->stored_file_name = $this->create_stored_filename();
		$this->temp_file_location = $_FILES[$this->field_name]['tmp_name'];

		return true;
	}

	function getMimeSoap($filename){

		if( function_exists( 'ext2mime' ) )
		{
			$mime = ext2mime($filename);
		}
		else
		{
			$mime = ' application/octet-stream';
		}
		return $mime;

	}
	function getMime(&$_FILES_element)
	{

		$filename = $_FILES_element['name'];

		if( $_FILES_element['type'] )
		{
			$mime = $_FILES_element['type'];
		}
		elseif( function_exists( 'mime_content_type' ) )
		{
			$mime = mime_content_type( $_FILES_element['tmp_name'] );
		}
		elseif( function_exists( 'ext2mime' ) )
		{
			$mime = ext2mime( $_FILES_element['name'] );
		}
		else
		{
			$mime = ' application/octet-stream';
		}
		return $mime;
	}

	function get_stored_file_name()
	{
		return $this->stored_file_name;
	}

	function create_stored_filename()
	{
		global $sugar_config;
		if(!$this->use_soap){
           $stored_file_name = $_FILES[$this->field_name]['name'];
		}else{
			$stored_file_name = $this->stored_file_name;
		}
		$this->original_file_name = $stored_file_name;
        $ext_pos = strrpos($stored_file_name, ".");

		$this->file_ext = substr($stored_file_name, $ext_pos + 1);
        
        // cn: bug 6347 - fix file extension detection 
        foreach($sugar_config['upload_badext'] as $badExt) {
            if(strtolower($this->file_ext) == strtolower($badExt)) {
                $stored_file_name .= ".txt";
                $this->file_ext="txt";
                break; // no need to look for more
            }
        }
		return $stored_file_name;
	}

	function final_move($bean_id)
	{
		global $sugar_config;

        $destination = $this->get_upload_path($bean_id);
        if($this->use_soap){
        	$fp = fopen($destination, 'wb');
        	if(!fwrite($fp, $this->file)){
        		die ("ERROR: can't save file to $destination");
        	}
        	fclose($fp);
        }else{
			if (!move_uploaded_file($_FILES[$this->field_name]['tmp_name'], $destination))
                {
					die ("ERROR: can't move_uploaded_file to $destination. You should try making the directory writable by the webserver");
                }
        }
		 return true;
	}

	function get_upload_path($bean_id){
			global $sugar_config;
			 $file_name = $bean_id.$this->stored_file_name;
			 return $sugar_config['upload_dir'].$file_name;
	}

	function unlink_file($bean_id,$file_name) {
		global $sugar_config;
        return unlink($sugar_config['upload_dir'].$bean_id.$file_name);
    }
}
?>
