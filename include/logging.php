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

 * Description:  Kicks off log4php.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
 
// This file should no longer be used in the main product.  It is provided for backwards compatibility only.

require_once('config.php');

if(!defined('LOG4PHP_DIR')){
	define('LOG4PHP_DIR', 'log4php');
}
if(!defined('LOG4PHP_DEFAULT_INIT_OVERRIDE')){
	define('LOG4PHP_DEFAULT_INIT_OVERRIDE', true);
}

require_once(LOG4PHP_DIR.'/LoggerManager.php');
require_once(LOG4PHP_DIR.'/LoggerPropertyConfigurator.php');

if (! isset($simple_log) || $simple_log == false)
{
$config = new LoggerPropertyConfigurator();
$config->configure('log4php.properties');
}

class SimpleLog
{
        var $fp;
        var $logfile = 'sugarcrm.log';
        var $loglevel = 5;
				var $nolog = false;
        function SimpleLog()
        {
					global $loglevel,$logfile;
					if (! empty($loglevel))
					{
							if ( $loglevel == 'fatal') $this->loglevel = 5;
							else if ( $loglevel == 'error') $this->loglevel = 4;
							else if ( $loglevel == 'warn') $this->loglevel = 3;
							else if ( $loglevel == 'debug') $this->loglevel = 2;
							else if ( $loglevel == 'info') $this->loglevel = 1;
					}
					if (! empty($logfile))
					{
							$this->logfile = $logfile;	
					}
 					$this->fp = @ fopen($this->logfile, 'a+');
					if (! $this->fp )
					{
						$this->nolog = true;
					}
        }
        function info($string)
        {
								if ($this->loglevel > 1 || $this->nolog) return;
                fwrite($this->fp, "info:[".strftime("%Y-%m-%d %T")."] $string\n")
                        or die("Logger Failed to write to:". $this->logfile);
        }
        function debug($string)
        {
								if ( $this->loglevel > 2 || $this->nolog ) return;
                fwrite($this->fp, "debug:[".strftime("%Y-%m-%d %T")."] $string\n")
                        or die("Logger Failed to write to:". $this->logfile);
        }
        function warn($string)
        {
								if ( $this->loglevel > 3 || $this->nolog ) return;
                fwrite($this->fp, "warn:[".strftime("%Y-%m-%d %T")."] $string\n")
                        or die("Logger Failed to write to:". $this->logfile);
        }
        function error($string)
        {
								if ( $this->loglevel > 4 || $this->nolog ) return;
                fwrite($this->fp, "error:[".strftime("%Y-%m-%d %T")."] $string\n")
                        or die("Logger Failed to write to:". $this->logfile);
        }
        function fatal($string)
        {
								if (  $this->loglevel > 5)  return;
								if ( $this->nolog ) die($string);
                fwrite($this->fp, "fatal:[".strftime("%Y-%m-%d %T")."] $string\n") 
                        or die("Logger Failed to write to:". $this->logfile);
								die($string);
        }
}

?>
