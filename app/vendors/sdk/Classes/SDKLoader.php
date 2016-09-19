<?php
/**
 * IP.Board 3.0 SDK
 *
 * Written by InvisionModding.com Staff Team
 *
 * Last Updated: $Date: 2009-07-29 12:08:39 +0300 (Wed, 29 Jul 2009) $
 *
 * @author 		$Author: vadimg88 $
 * @copyright	(c) 2009 - InvisionModding.com
 * @license		http://www.invisionpower.com/community/board/license.html
 * @package		Invision Power Board
 * @subpackage  IPB SDK
 * @link		http://www.InvisionModding.com
 * @version		$Rev: 5 $
 *
 */

/**
 * Define the IPB SDK classes path
 *
 */

define('SDK_CLASSES_PATH', SDK_ROOT_PATH . 'Classes/' );


/* Make sure it's defined */
if( !defined('IPB_FULL_PATH') || IPB_FULL_PATH == '' )
{
    die("You must define the full path to the IPB directory in the SDKConfig.php file.");
}

/* Sort the path with the slashes */
if( substr(IPB_FULL_PATH, -1) != '/' )
{
    define('SDK_IPB_PATH', IPB_FULL_PATH . '/');
}
else
{
    define('SDK_IPB_PATH', IPB_FULL_PATH);
}

/* The path exists and valid? */
if( !is_dir(SDK_IPB_PATH) || !is_file( SDK_IPB_PATH . 'conf_global.php' ) )
{
    die(sprintf("Error: The path <b>%s</b> does not exists or is not valid.", SDK_IPB_PATH));
}

/* Load required IPB Files */
define( 'IPB_THIS_SCRIPT', 'public' );
require_once( SDK_IPB_PATH . 'initdata.php' );
require_once( IPS_ROOT_PATH . 'sources/base/ipsRegistry.php' );
require_once( IPS_ROOT_PATH . 'sources/base/ipsController.php' );

/* Load the registry instance */
$ipbRegistry    = ipsRegistry::instance();
$ipbRegistry->init();

/* Done! */