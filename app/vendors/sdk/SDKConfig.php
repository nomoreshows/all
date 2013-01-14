<?php
/**
 * IP.Board 3.0 SDK
 * 
 * Written by InvisionModding.com Staff Team
 * 
 * Last Updated: $Date: 2009-07-29 12:00:50 +0300 (Wed, 29 Jul 2009) $
 *
 * @author 		$Author: vadimg88 $
 * @copyright	(c) 2009 - InvisionModding.com
 * @license		http://www.invisionpower.com/community/board/license.html
 * @package		Invision Power Board
 * @subpackage  IPB SDK
 * @link		http://www.InvisionModding.com
 * @version		$Rev: 3 $
 *
 */


/**
 * Define the fill path to your forums root directory
 * Where index.php, initdata.php, conf_global.php files located
 * You must put a forward slash at the end of the directory!
 * 
 * Example: C:/wamp/www/ipb300/
 */

define( 'IPB_FULL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/app/webroot/forum/' );


/**
 * Define the main IPB SDK directory
 *
 * Usually this should be set automatically, But if you see
 * All sorts of Warning: require_once(SDKConfig.php) [function.require-once]: 
 * failed to open stream: No such file or directory in C:\wamp\www\community\SDK\Classes\SDKLoader.php on line 38
 * 
 * Then enter the path to the SDK directory manually the 
 * full path including a trailing slash
 * 
 */

define('SDK_ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR );

require_once('IPBSDK.php');