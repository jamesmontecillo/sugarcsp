<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once ('include/dir_inc.php');
require_once ('include/utils/file_utils.php');
require_once ('include/utils/zip_utils.php');

function convert_disc_client(){
	set_time_limit(3600);
	ini_set('default_socket_timeout', 360);
	global $sugar_config;
	require_once('include/nusoap/nusoap.php');

    $errors = array();

    $server_url = "http://";
    $user_name  = "";
    $admin_name  = "";
    $password   = "";
    
    $oc_install = false;
    if(isset($_SESSION['oc_install']) && $_SESSION['oc_install'] == true){
    	$oc_install = true;
    }

    // run options are: convert, sync
    // default behavior of this page
    $run = "convert";
    if(!$oc_install){
	    if( isset( $_REQUEST['run'] ) ){
	        $run = $_REQUEST['run'];
	    }
	
	    if( $run == "convert" ){
	        if( isset($_REQUEST['server_url']) ){
	            $server_url = $_REQUEST['server_url'];
	            if( $server_url == "" ){
	                $errors[] = "Server URL cannot be empty.";
	            }
	        }
	    }
	    else if( $run == "sync" ){
	        $server_url = $sugar_config['sync_site_url'];
	    }
	
	    if( isset($_REQUEST['user_name']) ){
	        $user_name = $_REQUEST['user_name'];
	        if( $user_name == "" ){
	            $errors[] = "User Name cannot be empty.";
	        }
	    }
	    if( isset($_REQUEST['password']) ){
	        if( $_REQUEST['password'] == "" ){
	            $errors[] = "Password cannot be empty.";
	        }
	        else{
	        	$password = $_REQUEST['password'];
	        }
	    }
    }
    else{
    	//this is an offline client install
    	if( isset( $_SESSION['oc_run'] ) ){
	        $run = $_SESSION['oc_run'];
	    }
	
	    if( $run == "convert" ){
	        if( isset($_SESSION['oc_server_url']) ){
	            $server_url = $_SESSION['oc_server_url'];
	            if( $server_url == "" ){
	                $errors[] = "Server URL cannot be empty.";
	            }
	        }
	    }
	    else if( $run == "sync" ){
	        $server_url = $sugar_config['sync_site_url'];
	    }
	
	    if( isset($_SESSION['oc_username']) ){
	        $user_name = $_SESSION['oc_username'];
	        if( $user_name == "" ){
	            $errors[] = "User Name cannot be empty.";
	        }
	    }
	    if( isset($_SESSION['oc_password']) ){
	        if( $_SESSION['oc_password'] == "" ){
	            $errors[] = "Password cannot be empty.";
	        }
	         else{
	        	$password = $_SESSION['oc_password'];
	        }
	    }
    }//end check for offline client install
    
    if(!isset($_SESSION['is_oc_conversion']) || $_SESSION['is_oc_conversion'] == false){
        $password = md5($password);    
    }

    $sugar_config['oc_username'] = $user_name;
    $sugar_config['oc_password'] = $password;
    $sugar_config['oc_converted'] = false;
    $sugar_config['disc_client']    = true;
   
    if((isset( $_REQUEST['submitted']) || $oc_install) && sizeof( $errors ) == 0 ){
          if(empty($server_url) || $server_url == 'http://'){
        	 $errors[] = "Server URL is required";
        }else{
        $sugar_config['sync_site_url']  = $server_url;	
         
        $soapclient = new nusoapclient( "$server_url/soap.php" );
        $soapclient->response_timeout = 360;
		if($soapclient->call('is_loopback', array())){
			$errors[] = "Server and Client must be on seperate machines with unique ip addresses";	
		}
		if(!$soapclient->call('offline_client_available', array())){
			$errors[] = "No licenses available for offline client";	
		}
        $result = $soapclient->call( 'login', array('user_auth'=>array('user_name'=>$user_name,'password'=>$password, 'version'=>'.01'), 'application_name'=>'Disconnected Client Setup'));
        if( $soapclient->error_str ){
            $errors[] = "Login failed with error: " . $soapclient->error_str;
        }
        
        if( $result['error']['number'] != 0 ){
        	 $errors[] = "Login failed with error: " . $result['error']['name'] . ' ' . $result['error']['description'];
        	
        }
          
      
        $session = $result['id'];
          }
		 $errorString = "";
		 if(!empty($errors)){
	   		 foreach( $errors as $error ){
	      		 $errorString .= $error . "<br>" ;
	  		  }
		 }
       
        if( $session  && empty($errors)){
            if( $run == "convert" ){
                // register this client/user with server

                // update local config.php file
                if(empty($sugar_config['unique_key'])){
                    $sugar_config['unique_key'] = create_guid();   
                }

               	//attempt to obtain the system_id from the server
        		$result = $soapclient->call('get_unique_system_id', array('session'=>$session, 'unique_key'=>$sugar_config['unique_key']));
         		if( $soapclient->error_str ){
            		$errors[] = "Unable to obtain unique system id from server: " . $soapclient->error_str;
        		}
        		else{
                    if( $result['error']['number'] != 0 ){
                       $errors[] =  $result['error']['description'];
                    }else{
					   require_once("modules/Administration/Administration.php");
					   $admin = new Administration();
					   $system_id = $result['id'];
					   if(!isset($system_id)){
						  $system_id = 1;
					   }
					   $admin->saveSetting('system', 'system_id', $system_id);
                    } 
        		}
            }

            // data sync triggers
            if(empty($errors)){
                require_once("modules/Sync/SyncHelper.php");
                sync_users($soapclient, $session, true);
                $sugar_config['oc_converted'] = true;
                
			    echo 'Updating Local Information<br>';
			 	//echo 'Done - will auto logout in <div id="seconds_left">10</div> seconds<script> function logout_countdown(left){document.getElementById("seconds_left").innerHTML = left; if(left == 0){document.location.href = "index.php?module=Users&action=Logout";}else{left--; setTimeout("logout_countdown("+ left+")", 1000)}};setTimeout("logout_countdown(10)", 1000)</script>';
                // done with soap calls
                $result = $soapclient->call( 'logout', array('session'=>$session) );
            }
        }
    }

    ksort( $sugar_config );
    if( !write_array_to_file( "sugar_config", $sugar_config, "config.php" ) ){
        return;
    }
    $errorString = "";
    foreach( $errors as $error ){
       $errorString .= $error . "<br>" ;
    }
   
    return $errorString;
}

function disc_client_utils_print( $str, $verbose ){

    if( $verbose ){

        print( $str );

    }

}

/*
 * disc_client_get_zip: This method will be used during an Offline Client sync.  It works by
 * generated an md5 file for the files on the client and then passes this file onto the server.
 * The server then generates its own md5 file and compares the server md5 file to the client md5 file
 * and builds a list of files that need to be passed back to the client.
 * The server then puts these files into a zip and passes this zip back to the client.  The client will
 * then unzip this file into the root directory.
 */
function disc_client_get_zip( $soapclient, $session, $verbose=false , $attempts = 0){
	$max_attempts = 3;
    global $sugar_config, $timedate;
     // files might be big
    ini_set( "memory_limit", "-1" );
    set_time_limit(3600);
	ini_set('default_socket_timeout', 3600);
    $return_str  = "";
    
    //1) rather than using md5, we will use the date_modified
    if (file_exists('modules/Sync/file_config.php')) {
		require_once ('modules/Sync/file_config.php');
        global $file_sync_info;
		if(!isset($file_sync_info['last_local_sync']) && !isset($file_sync_info['last_server_sync'])){
			$last_local_sync = $timedate->get_gmt_db_datetime();	
    		$last_server_sync = $timedate->get_gmt_db_datetime();	
    		$is_first_sync = true;
		}else{	
			$last_local_sync = $file_sync_info['last_local_sync'];
			$last_server_sync = $file_sync_info['last_server_sync'];
			$is_first_sync = false;
		}
    }
    else{
    	$last_local_sync = $timedate->get_gmt_db_datetime();	
    	$last_server_sync = $timedate->get_gmt_db_datetime();	
    	$is_first_sync = true;
    }

    $temp_file  = tempnam(getcwd()."/".$sugar_config['tmp_dir'], "sug" );
    $file_list = array();
    if(!$is_first_sync){
    	$all_src_files  = findAllTouchedFiles( ".", array(), $last_local_sync);

    	foreach( $all_src_files as $src_file ){
        	$file_list[$src_file] = $src_file;
    	}
    }else{
    	$all_src_files  = findAllFiles( ".", array());
    	 require("install/data/disc_client.php");
    	 foreach( $all_src_files as $src_file ){
    		foreach($disc_client_ignore as $ignore_pattern ){
            	if(!preg_match( "#" . $ignore_pattern . "#", $src_file ) ){
                	$md5 = md5_file( $src_file );
        			$file_list[$src_file] = $md5;
            	}
        	}
    	}	
    }
    
    
    
    //2) save the list of md5 files to file system
    if( !write_array_to_file( "client_file_list", $file_list, $temp_file ) ){
        echo "Could not save file.";
    }

	$md5 = md5_file($temp_file);
	// read file
    $fh = fopen($temp_file, "rb" );
    $contents = fread( $fh, filesize($temp_file) );
    fclose( $fh );
	
    // encode data
    $data = base64_encode($contents);
   $md5file  = array('filename'=>$temp_file, 'md5'=>$md5, 'data'=>$data, 'error' => null);
    $result = $soapclient->call('get_encoded_zip_file', array( 'session'=>$session, 'md5file'=>$md5file, 'last_sync' => $last_server_sync, 'is_md5_sync' => $is_first_sync));

    //3) at this point we could have the zip file
    $zip_file = tempnam(getcwd()."/".$sugar_config['tmp_dir'], "zip" ).'.zip';
    if(isset($result['result']) && !empty($result['result'])){
    	$fh = fopen($zip_file, 'w');
    	fwrite($fh, base64_decode($result['result']));
		fclose($fh);
	
    	$archive = new PclZip($zip_file);
    	if( $archive->extract( PCLZIP_OPT_PATH, ".", 
    					   PCLZIP_OPT_REPLACE_NEWER) == 0 ){
        	die( "Error: " . $archive->errorInfo(true) );
    	}
    }
    unlink($zip_file);
	$file_sync_info['last_local_sync'] = $timedate->get_gmt_db_datetime();
	$server_time = $soapclient->call('get_gmt_time', array ());
	$file_sync_info['last_server_sync'] = $server_time;
	$file_sync_info['is_first_sync'] = $is_first_sync;
	write_array_to_file('file_sync_info', $file_sync_info, 'modules/Sync/file_config.php');
	echo "File sync complete.";
}

/*
 * Obtain a list of required upgrades from the server
 * 
 * @param soapclient           the nusoap client to use for request
 * @param session              the authenticated session to use for request
 *                             
 * return                   an array containing all of the upgrades which are
 *                          required by the offline client
 */
function get_required_upgrades($soapclient, $session){
	global $sugar_config, $sugar_version;
	require_once('include/nusoap/nusoap.php');

    $errors = array();
    
    require_once("modules/Administration/UpgradeHistory.php");
    $upgrade_history = new UpgradeHistory();
    $upgrade_history->disable_row_level_security = true;
    $installeds = $upgrade_history->getAllOrderBy('date_entered ASC');
    $history = array();
    foreach($installeds as $installed)
	{
		$history[] = array('id' => $installed->id, 'filename' => $installed->filename, 'md5' => $installed->md5sum, 'type' => $installed->type, 'status' => $installed->status, 'version' => $installed->version, 'date_entered' => $installed->date_entered, 'error' => $error->get_soap_array());
	}
    
    $result = $soapclient->call('get_required_upgrades', array('session'=>$session, 'client_upgrade_history' => $history, 'client_version' => $sugar_version));

    $temp_dir = mk_temp_dir($sugar_config['tmp_dir'], "sug" );

    if(empty($soapclient->error_str) && $result['error']['number'] == 0){
        foreach($result['upgrade_history_list'] as $upgrade){
            $file_result = $soapclient->call('get_encoded_file', array( 'session'=>$session, 'filename'=>$upgrade['filename']));
            
            if(empty($soapclient->error_str) && $result['error']['number'] == 0){
                if($file_result['md5'] == $upgrade['md5']){
                    $newfile = write_encoded_file($file_result, $temp_dir);
                    unzip($newfile, $temp_dir);
            
                    if(file_exists("$temp_dir/scripts/pre_install.php")){
                        require_once("$temp_dir/scripts/pre_install.php");
                        pre_install();
                    }
                    if(file_exists("$temp_dir/manifest.php")){
                        require_once("$temp_dir/manifest.php");
                        if( isset( $manifest['copy_files']['from_dir'] ) && $manifest['copy_files']['from_dir'] != "" ){
                            $zip_from_dir   = $manifest['copy_files']['from_dir'];
                        }
                        $source = "$temp_dir/$zip_from_dir";
                        $dest = getcwd();
                       
                         copy_recursive($source, $dest);     
                    }
                    if(file_exists("$temp_dir/scripts/post_install.php")){
                        require_once("$temp_dir/scripts/post_install.php");
                        post_install();
                    }
                
                    //save newly installed upgrade
                    $new_upgrade = new UpgradeHistory();
                    $new_upgrade->filename      = $upgrade['filename'];
                    $new_upgrade->md5sum        = $upgrade['md5'];
                    $new_upgrade->type          = $upgrade['type'];
                    $new_upgrade->version       = $upgrade['version'];
                    $new_upgrade->status        = "installed";
                    $new_upgrade->save();
                }
            }
        }
    }   
}

function disc_client_file_sync( $soapclient, $session, $verbose=false , $attempts = 0){
	$max_attempts = 3;
    global $sugar_config;



    // files might be big

    ini_set( "memory_limit", "-1" );



    $return_str  = "";



    $temp_dir = mk_temp_dir( getcwd() . '/' . $sugar_config['tmp_dir'], "sug" );

    if( !is_dir( $temp_dir ) ){

        die( "Could not create a temp dir." );

    }



    // get pattern file

    $result = $soapclient->call( 'get_encoded_file', array( 'session'=>$session, 'filename'=>"install/data/disc_client.php" ) );

    if( !empty($soapclient->error_str)){
		if($attempts < $max_attempts && substr_count($soapclient->error_str, 'HTTP Error: socket read of headers timed out') > 0){
			echo "Could not retrieve file patterns list.  Error was: " . $soapclient->error_str;
			
			$attempts++;
			echo "<BR> $attempts of $max_attempts attempts trying again<br>";
			flush();
			ob_flush();
			return disc_client_file_sync($soapclient, $session, $verbose, $attempts);
				
		}
        die( "Failed: Could not retrieve file patterns list.  Error was: " . $soapclient->error_str);

    }
    if($result['error']['number'] != 0){
    	die( "Failed: Could not retrieve file patterns list.  Error was: " . $result['error']['name'] . ' - ' . $result['description']);
    }

	

    $newfile = write_encoded_file( $result, $temp_dir );

    if( !copy( $newfile, $result['filename'] ) ){

        die( "Could not copy $newfile to new location." );

    }



    // get array definitions: $disc_client_ignore

    require( "install/data/disc_client.php" );





    // get file list/md5s, write as temp file, then require_once from tmp location

    $result = $soapclient->call( 'get_disc_client_file_list',  array( 'session'=>$session ) );



    if( !empty($soapclient->error_str)){
		if($attempts < $max_attempts && substr_count($soapclient->error_str, 'HTTP Error: socket read of headers timed out') > 0){
			echo "Could not retrieve file patterns list.  Error was: " . $soapclient->error_str;
			$attempts++;
			echo "<BR> $attempts of $max_attempts attempts trying again<br>";
			flush();
			ob_flush();
			return disc_client_file_sync($soapclient, $session, $verbose, $attempts);
				
		}
        die( "Failed: Could not retrieve file  list.  Error was: " . $soapclient->error_str);

    }
    if($result['error']['number'] != 0){
    	die( "Failed: Could not retrieve file  list.  Error was: " . $result['error']['name'] . ' - ' . $result['description']);
    }



    $temp_file  = tempnam( $temp_dir, "sug" );

    write_encoded_file( $result, $temp_dir, $temp_file );



    require_once( $temp_file );





    // determine which files are needed locally

    $needed_file_list   = array();

    $server_files       = array();  // used later for removing unneeded local files

    foreach( $server_file_list as $result ){

        $server_filename    = $result['filename'];

        $server_md5         = $result['md5'];

        $server_files[]     = $server_filename;



        $ignore = false;

        foreach( $disc_client_ignore as $ignore_pattern ){

            if( preg_match( "#" . $ignore_pattern . "#", $server_filename ) ){

                $ignore = true;

            }

        }


		if(file_exists($server_filename)){
       		if(!$ignore && ( md5_file( $server_filename ) != $server_md5 ) ){

            	// not on the ignore list and the client's md5sum does not match the server's

           		 $needed_file_list[] = $server_filename;

       		 }
		}else{
			if(!$ignore){
				 $return_str .= disc_client_utils_print( "File missing from client : $temp_dir/$server_filename<br>", $verbose );		
				 $needed_file_list[] = $server_filename;
			}	
		}

    }



    if( sizeof( $server_files ) < 100 ){
		if($attempts < $max_attempts && substr_count($soapclient->error_str, 'HTTP Error: socket read of headers timed out') > 0){
			echo "Could not retrieve file patterns list.  Error was: " . $soapclient->error_str;
			$attempts++;
			echo "<BR> $attempts of $max_attempts attempts trying again<br>";
			flush();
			ob_flush();
			return disc_client_file_sync($soapclient, $session, $verbose, $attempts);
				
		}
        die( "Failed: Empty file list returned from server.  Please try again." );

    }



    // get needed files

    foreach( $needed_file_list as $needed_file ){

        $result = $soapclient->call( 'get_encoded_file', array( 'session'=>$session, 'filename'=>"$needed_file" ) );

        write_encoded_file( $result, $temp_dir );

    }



    // all files recieved, copy them into place
    foreach( $needed_file_list as $needed_file ){
		if(file_exists("$temp_dir/$needed_file")){
		 mkdir_recursive(dirname($needed_file), true);
       	 copy( "$temp_dir/$needed_file", $needed_file );
       	  $return_str .= disc_client_utils_print( "Updated file: $needed_file <br>", $verbose );
		}else{
			 $return_str .= disc_client_utils_print( "File missing from client : $temp_dir/$needed_file<br>", $verbose );		
		}

       

    }

    if( sizeof( $needed_file_list ) == 0 ){

        $return_str .= disc_client_utils_print( "No files needed to be synchronized.<br>", $verbose );

    }



    // scrub local files that are not part of client application

    $local_file_list = findAllFiles( ".", array() );

    $removed_file_count = 0;

    foreach( $local_file_list as $local_file ){

        $ignore = false;

        foreach( $disc_client_ignore as $ignore_pattern ){

            if( preg_match( "#" . $ignore_pattern . "#", $local_file ) ){

                $ignore = true;

            }

        }



        if( !$ignore && !in_array( $local_file, $server_files ) ){

            // not on the ignore list and the server does not know about it

            unlink( $local_file );

            $return_str .= disc_client_utils_print( "Removed file: $local_file <br>", $verbose );

            $removed_file_count++;

        }

    }

    if( $removed_file_count == 0 ){

        $return_str .= disc_client_utils_print( "No files needed to be removed.<br>", $verbose );

    }




    return( $return_str );

}

?>

