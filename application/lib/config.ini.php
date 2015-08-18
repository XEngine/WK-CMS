<?php 
	/** 
	* Configuration

	* @package Webkokteyli CMS
	* @author wkcms.com
	* @copyright 2015
	* @version 1.0 31/07/2015 14:00 | Webkokteyli Labs.
	*/
 
	 if (!defined("_VALID_PHP")) 
     die('Direct access to this location is not allowed.');
 
	/** 
	* Database Constants - these constants refer to 
	* the database configuration settings. 
	*/
	 define('DB_SERVER', 'localhost'); 
	 define('DB_USER', 'root'); 
	 define('DB_PASS', 'mysql'); 
	 define('DB_DATABASE', 'cms');
 
	/** 
	* Show MySql Errors. 
	* Not recomended for live site. true/false 
	*/
	$DEBUG = false; 
?>