<?php
/**
 * IP.Board 3.0 SDK
 * 
 * Written by InvisionModding.com Staff Team
 * 
 * Last Updated: $Date: 2009-07-29 12:19:58 +0300 (Wed, 29 Jul 2009) $
 *
 * @author 		$Author: vadimg88 $
 * @copyright	(c) 2009 - InvisionModding.com
 * @license		http://www.invisionpower.com/community/board/license.html
 * @package		Invision Power Board
 * @subpackage  IPB SDK
 * @link		http://www.InvisionModding.com
 * @version		$Rev: 7 $
 *
 */

class IPBSDK
{
    /**
     * IPB Registry object
     *
     * @var object
     */
    public $registry;

    /**
     * Initated flag
     *
     * @var bool
     */
    private $_initated = false;

    /**
     * Holds instance of registry (singleton implementation)
     *
     * @access	private
     * @var		object
     */
    private static $instance;

    /**
     * Holds the classes that were loaded already to return an instance of them
     * Instead of reloading the same classes
     *
     * @var Array
     */
    private $loadedClasses = array();

    /**
     * Shortcut keys for the registry
     *
     * @var Mixed Object/Array
     */
    public $settings;
    public $DB;
    public $request;
    public $lang;
    public $member;
    public $memberData;
    public $cache;
    public $caches;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        /* Did we load it already? */
        if( ! self::$instance )
        {
            require_once( 'Classes/SDKLoader.php' );

            $this->registry   =  $ipbRegistry;
            $this->DB         =  $this->registry->DB();
            $this->settings   =& $this->registry->fetchSettings();
            $this->request    =& $this->registry->fetchRequest();
            $this->lang       =  $this->registry->getClass('class_localization');
            $this->member     =  $this->registry->member();
            $this->memberData =& $this->registry->member()->fetchMemberData();
            $this->cache      =  $this->registry->cache();
            $this->caches     =& $this->registry->cache()->fetchCaches();
            
            /* Change Flag */
            $this->_initated = true;
        }

    }

    /**
     * Magic method
     *
     * @param string $key
     * @return Object
     */
    public function __get($key)
    {
        return $this->$key;
    }

    /**
     * Initialize singleton
     *
     * @return	object
     */
    static public function instance()
    {
        if ( ! self::$instance )
        {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Wrapper to load a class from the classes directory
     *
     * @param string $className
     * @return Object
     */
    public function getClass( $className='' )
    {
        /* Class name added? */
        if( !$className )
        {
            throw new IPBSDK_Exception("You must enter a class name to load");
        }

        /* Work out name */
        $className = 'SDK_' . ucfirst($className);

        if( !array_key_exists($className, $this->loadedClasses) )
        {
            /* Exists? */
            if( !file_exists( SDK_CLASSES_PATH . $className . '.php' ) )
            {
                throw new IPBSDK_Exception("The class '{$className}' was not found under the Classes directory.");
            }

            /* Load */
            require_once( SDK_CLASSES_PATH . $className . '.php' );
            $obj = new $className( $this->registry );
            $obj->sdk = $this;
            $this->loadedClasses[ $className ] = $obj;
            return $obj;
        }
        else
        {
            return $this->loadedClasses[ $className ];
        }
    }

}

/**
 * IP.Board 3.0 SDK
 *
 * Written by InvisionModding.com Staff Team
 *
 * Last Updated: $Date: 2009-07-29 12:19:58 +0300 (Wed, 29 Jul 2009) $
 *
 * @author 		$Author: vadimg88 $
 * @copyright	(c) 2009 - InvisionModding.com
 * @license		http://www.invisionpower.com/community/board/license.html
 * @package		Invision Power Board
 * @subpackage  IPB SDK
 * @link		http://www.InvisionModding.com
 * @version		$Rev: 7 $
 *
 */
class IPBSDK_Exception extends Exception {}