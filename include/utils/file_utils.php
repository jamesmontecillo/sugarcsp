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

require_once('include/utils/array_utils.php');

function clean_path( $path ){
    // clean directory/file path with a functional equivalent
    $path = str_replace( "\\", "/", $path );
    $path = str_replace( "//", "/", $path );
    $path = str_replace( "/./", "/", $path );
    return( $path );
}

function create_cache_directory($file){
    $paths = explode('/',$file);
    $dir = 'cache';
    if(!file_exists($dir)){
        mkdir($dir, 0755);
    }
    for($i = 0; $i < sizeof($paths) - 1; $i++){
        $dir .= '/' . $paths[$i];
        if(!file_exists($dir)){
            mkdir($dir, 0755);
        }
    }
    return $dir . '/'. $paths[sizeof($paths) - 1];
}

function get_module_dir_list(){
	$modules = array();
	$path = 'modules';
	$d = dir($path);
	while($entry = $d->read()){	
		if($entry != '..' && $entry != '.'){
			if(is_dir($path. '/'. $entry)){
				$modules[$entry] = $entry;
			}
		}
	}
	return $modules;
}

function mk_temp_dir( $base_dir, $prefix="" ){
    $temp_dir = tempnam( getcwd() .'/'. $base_dir, $prefix );
    if( !$temp_dir || !unlink( $temp_dir ) ){
        return( false );
    }

    if( mkdir( $temp_dir ) ){
        return( $temp_dir );
    }

    return( false );
}

function remove_file_extension( $filename ){
    return( substr( $filename, 0, strrpos($filename, ".") ) );
}

function write_array_to_file( $the_name, $the_array, $the_file ){
    $the_string =   "<?php\n" .
                    '// created: ' . date('Y-m-d H:i:s') . "\n" .
                    "\$$the_name = " .
                    var_export_helper( $the_array ) .
                    ";\n?>\n";

    if( $fh = @fopen( $the_file, "w" ) ){
        fputs( $fh, $the_string, strlen($the_string) );
        fclose( $fh );
        return( true );
    }
    else{
        return( false );
    }
}

function write_encoded_file( $soap_result, $write_to_dir, $write_to_file="" ){
    // this function dies when encountering an error -- use with caution!
    // the path/file is returned upon success

    require_once('include/dir_inc.php');

    if( $write_to_file == "" ){
        $write_to_file = $write_to_dir . "/" . $soap_result['filename'];
    }

    $file = $soap_result['data'];
    $write_to_file = str_replace( "\\", "/", $write_to_file );

    $dir_to_make = dirname( $write_to_file );
    if( !is_dir( $dir_to_make ) ){
        mkdir_recursive( $dir_to_make );
    }
    $fh = fopen( $write_to_file, "wb" );
    fwrite( $fh, base64_decode( $file ) );
    fclose( $fh );

    if( md5_file( $write_to_file ) != $soap_result['md5'] ){
        die( "MD5 error after writing file $write_to_file" );
    }
    return( $write_to_file );
}

function create_custom_directory($file){
    $paths = explode('/',$file);
    $dir = 'custom';
    if(!file_exists($dir)){
        mkdir($dir, 0755);
    }
    for($i = 0; $i < sizeof($paths) - 1; $i++){
        $dir .= '/' . $paths[$i];
        if(!file_exists($dir)){
            mkdir($dir, 0755);
        }
    }
    return $dir . '/'. $paths[sizeof($paths) - 1];
}

/**
 * This function will recursively generates md5s of files and returns an array of all md5s. 
 * 
 * @param	$path The path of the root directory to scan - must end with '/'
 * @param	$ignore_dirs array of filenames/directory names to ignore running md5 on - default 'cache' and 'upload'
 * @result	$md5_array an array containing path as key and md5 as value
 */
function generateMD5array($path, $ignore_dirs = array('cache', 'upload')){
	$dh  = opendir($path);
	while (false !== ($filename = readdir($dh)))
	{
		$current_dir_content[] = $filename;
	}
	
	// removes the ignored directories
	$current_dir_content = array_diff($current_dir_content, $ignore_dirs);
	
	sort($current_dir_content);
	$md5_array = array();
	
	foreach($current_dir_content as $file)
	{
		// make sure that it's not dir '.' or '..'
		if(strcmp($file, ".") && strcmp($file, ".."))
		{
			if(is_dir($path.$file))
			{
				// For testing purposes - uncomment to see all files and md5s
				//echo "<BR>Dir:  ".$path.$file."<br>";
				//generateMD5array($path.$file."/");
				
				$md5_array += generateMD5array($path.$file."/", $ignore_dirs);
			}
			else
			{
				// For testing purposes - uncomment to see all files and md5s
				//echo "   File: ".$path.$file."<br>";
				//echo md5_file($path.$file)."<BR>";
				
				$md5_array[$path.$file] = md5_file($path.$file);
			}
		}
	}
	
	return $md5_array;
	
}

/**
 * Function to compare two directory structures and return the items in path_a that didn't match in path_b
 * 
 * @param	$path_a The path of the first root directory to scan - must end with '/'
 * @param	$path_b The path of the second root directory to scan - must end with '/'
 * @param	$ignore_dirs array of filenames/directory names to ignore running md5 on - default 'cache' and 'upload'
 * @result	array containing all the md5s of everything in $path_a that didn't have a match in $path_b
 */
function md5DirCompare($path_a, $path_b, $ignore_dirs = array('cache', 'upload'))
{
	$md5array_a = generateMD5array($path_a, $ignore_dirs);
	$md5array_b = generateMD5array($path_b, $ignore_dirs);
	
	$result = array_diff($md5array_a, $md5array_b);
	
	return $result;
}

/**
 * Function to retrieve all file names of matching pattern in a directory (and it's subdirectories)
 * example: getFiles($arr, './modules', '.+/EditView.php/'); // grabs all EditView.phps
 * @param array $arr return array to populate matches
 * @param string $dir directory to look in [ USE ./ in front of the $dir! ]
 * @param regex $pattern optional pattern to match against
 */
function getFiles(&$arr, $dir, $pattern = null) { 
    $contents = glob("{$dir}/*"); 
    if(is_array($contents)) {
        foreach($contents as $file) { 
            if(is_dir($file)) {
                getFiles($arr, $file, $pattern);
            }
            else {
                if(empty($pattern)) $arr[] = $file;
                else if(preg_match($pattern, $file)) 
                $arr[] = $file;
            }
        }
    }
}
?>
