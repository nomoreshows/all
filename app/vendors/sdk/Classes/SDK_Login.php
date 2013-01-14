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
class SDK_Login
{
    /**
     * IPB SDK object
     *
     * @var object
     */
    public $sdk;

    /**
     * IPB Registry object
     *
     * @var Object
     */
    public $registry;

    /**
     * Login handler object
     *
     *
     * @var Object
     */
    public $login;

    /**
     * Ajax class
     *
     *
     * @var Object
     */
    public $ajax;

    /**
     * Return the result as a boolean value?
     *
     * @var boolean
     */
    public $returnAsBool = false;

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
     * Constructor - Class construct
     *
     * @author Vadim
     * @param ipsRegistry $registry
     */
    public function __construct( ipsRegistry $registry )
    {
        $this->registry = $registry;
        $this->DB         =  $this->registry->DB();
        $this->settings   =& $this->registry->fetchSettings();
        $this->request    =& $this->registry->fetchRequest();
        $this->lang       =  $this->registry->getClass('class_localization');
        $this->member     =  $this->registry->member();
        $this->memberData =& $this->registry->member()->fetchMemberData();
        $this->cache      =  $this->registry->cache();
        $this->caches     =& $this->registry->cache()->fetchCaches();


        /* Get login handler */
        require_once( IPS_ROOT_PATH . 'sources/handlers/han_login.php' );
        $this->login    = new han_login( $this->registry );
        $this->login->init();

        /* Load ajax class */
        require_once( IPS_KERNEL_PATH . 'classAjax.php' );
        $this->ajax = new classAjax();
    }

    /**
     * Magic method get
     *
     * @author Vadim
     * @param string $key
     * @return Mixed
     */
    public function __get($key)
    {
        return isset($this->$key) ? $this->$key : null;
    }

    /**
     * Magic method set
     *
     * @author Vadim
     * @param string $key
     * @param string $value
     */
    public function __set($key, $value)
    {
        $this->setProperty($key, $value);
    }

    /**
     * Set a property as a class member
     *
     * @author Vadim
     * @param string $key
     * @param string $value
     * @return Object
     */
    public function setProperty($key, $value)
    {
        $this->$key = $value;
        return $this;
    }

    /**
     * Login a memebr without checking credentials
     * << USE WITH CAUTION >>
     *
     * @author Vadim
     * @param Int $memberId
     * @param Bool $setCookies
     */
    public function loginNoCheck($memberId, $setCookies=true)
    {
        $return = $this->login->loginWithoutCheckingCredentials( $memberId, $setCookies );

        if( $this->returnAsBool === true )
        {
            return $return !== false ? true : false;
        }
        else
        {
            return $return;
        }
    }

    /**
     * Check login information to see if it's valid
     *
     * @author Vadim
     * @param string $username
     * @param string $email_address
     * @param string $password
     * @return boolean
     *
     */
    public function checkLoginAuth( $username, $email_address, $password )
    {
        if( !$username && !$email_address )
        {
            throw new IPBSDK_Exception("You must provide at least username or password");
        }

        return $this->login->loginPasswordCheck( $username, $email_address, $password );
    }

    /**
     * Authenticate the user - creates account if possible
     *
     * @author Vadim
     * @param	string		Username or Email address
     * @param	string		Password
     * @param	boolean		Remember me?
     * @param	boolean		Anno login?
     * @return boolean member was logged in or not
     */
    public function authLogin( $username, $password, $rememberMe=false, $annon=false )
    {
        $this->request['anonymous'] = $annon;
        $this->request['password'] = $password;
        $this->request['username'] = $username;
        $this->request['rememberMe'] = $rememberMe;

        $this->login->verifyLogin( );

        return $this->login->return_code == 'SUCCESS' ? true : false;
    }

    /**
     * Check if the email is already in use
     *
     * @author Vadim
     * @param	string		Email address
     * @return	boolean		Authenticate successful
     */
    public function emailExists( $email )
    {
        return $this->login->emailExistsCheck( $email );
    }

    /**
     * Change a user's email address
     *
     * @author Vadim
     * @param	string		Old Email address
     * @param	string		New Email address
     * @return	boolean		Email changed successfully
     */
    public function changeEmail( $old_email, $new_email )
    {
        $duplicate = IPSMember::load( $new_email );

        if( $duplicate )
        {
            return $this->returnAsBool ? false : 'EMAIL_EXISTS';
        }

        $member = IPSMember::load( $old_email );

        if( !$member )
        {
            return $this->returnAsBool ? false : 'NO_USER';
        }

        $this->login->changeEmail( $old_email, $new_email );


        IPSMember::save( $member['member_id'], array( 'core' => array( 'email' => strtolower( $new_email ) ) ) );

        IPSLib::runMemberSync( 'onEmailChange', $member['member_id'], strtolower( $new_email ) );

        return $this->returnAsBool ? true : 'SUCCESS';
    }

    /**
     * Change a user's password
     *
     * @author Vadim
     * @param	string		Email address
     * @param	string		New password
     * @param   string      New salt?
     * @param   string      New member login key?
     * @return	boolean		Password changed successfully
     */
    public function changePass( $email, $new_pass, $new_salt=false, $new_key=false )
    {
        //-----------------------------------------
        // INIT
        //-----------------------------------------

        $password		= $new_pass;
        $salt			= str_replace( '\\', "\\\\", IPSMember::generatePasswordSalt(5) );
        $key			= IPSMember::generateAutoLoginKey();
        $md5_once		= md5( trim($password) );

        //-----------------------------------------
        // Get member
        //-----------------------------------------

        $member = IPSMember::load( $email );

        if( !$member )
        {
            return $this->returnAsBool ? false : 'NO_USER';
        }

        $member_id = $member['member_id'];

        $this->login->changePass( $email, $new_pass );

        //-----------------------------------------
        // Local DB
        //-----------------------------------------

        $update = array();

        if( $new_salt )
        {
            $update['members_pass_salt']	= $salt;
        }

        if( $new_key )
        {
            $update['member_login_key']		= $key;
        }

        if( count($update) )
        {
            IPSMember::save( $member_id, array( 'core' => $update ) );
        }

        IPSMember::updatePassword( $member_id, $md5_once );
        IPSLib::runMemberSync( 'onPassChange', $member_id, $password );

        return $this->returnAsBool ? true : 'SUCCESS';;
    }

    /**
     * Change a login name/display name
     *
     * @author Vadim
     * @param	Int		Member id
	 * @param	string		New name
	 * @param	string		Field to update (name or display name)
	 * @return	mixed		True if update successful, otherwise exception or false
	 * Error Codes:
	 * NO_USER				Could not load the user
	 * NO_PERMISSION		This user cannot change their display name at all
	 * NO_MORE_CHANGES		The user cannot change their display name again in this time period
	 * NO_NAME				No display name (or shorter than 3 chars was given)
	 * ILLEGAL_CHARS		The display name contains illegal characters
	 * USER_NAME_EXISTS		The username already exists
     */
    public function changeName( $member_id, $name, $field='members_display_name' )
    {
        try
        {
            $member = $this->sdk->getClass('member');
            $member->getFunction()->updateName($member_id, $name, $field);
        }
        catch (Exception $e)
        {
            if($e->getMessage())
            {
                return $this->returnAsBool ? false : $e->getMessage();
            }
        }
        
        return $this->returnAsBool ? true : 'SUCCESS';
    }

    /**
     * Create a user's account
     *
     * @author Vadim
     * @param   string          Member username
     * @param   string          Member email address
     * @param   string          Member password
     * @param   int             Member user group
     * @param   string          Member display name
     * @param	array		    Array of member information
     * @return  boolean         Return true/false if the account created?
     */
    public function createAccount( $username, $email, $password, $group=0, $display_name=null, $options=array() )
    {
        //-----------------------------------------
        // INIT
        //-----------------------------------------

        $in_username 			= trim($username);
        $in_password 			= trim($password);
        $in_email    			= trim(strtolower($email));
        $members_display_name           = $display_name ? trim($display_name) : $in_username;
        $member_group                   = $group ? $group : $this->settings['member_group'];

        //-----------------------------------------
        // Check
        //-----------------------------------------

        if( ! IPSText::checkEmailAddress( $in_email ) )
        {
            return $this->returnAsBool ? false : 'INVALID_EMAIL';
        }

        $userName		= IPSMember::getFunction()->cleanAndCheckName( $in_username, array(), 'name' );
        $displayName	= IPSMember::getFunction()->cleanAndCheckName( $members_display_name, array(), 'members_display_name' );

        if( count($userName['errors']) )
        {
            return $this->returnAsBool ? false : $userName['errors'];
        }

        if( $this->settings['auth_allow_dnames'] AND count($displayName['errors']) )
        {
            return $this->returnAsBool ? false : $displayName['errors'];
        }


        $this->login->emailExistsCheck( $in_email );

        if( $this->login->return_code AND $this->login->return_code != 'METHOD_NOT_DEFINED' AND $this->login->return_code != 'EMAIL_NOT_IN_USE' )
        {
            return $this->returnAsBool ? false : 'USER_NAME_EXISTS';
        }

        $data = array(
        'name'						=> $in_username,
        'members_display_name'		=> $members_display_name ? $members_display_name : $in_username,
        'email'					=> $in_email,
        'member_group_id'			=> intval($member_group),
        'joined'					=> time(),
        'ip_address'				=> $this->member->ip_address,
        'time_offset'				=> $this->settings['time_offset'],
        'coppa_user'				=> intval($options['coppa']),
        'allow_admin_mails'		=> 1,
        'password'					=> $in_password,
        );

        //-----------------------------------------
        // Create the account
        //-----------------------------------------

        $member	= IPSMember::create( array( 'members' => $data, 'pfields_content' => $options ) );

        //-----------------------------------------
        // Login handler create account callback
        //-----------------------------------------

        $this->login->createAccount( array(	'email'			=> $in_email,
        'joined'		=> $member['joined'],
        'password'		=> $in_password,
        'ip_address'	=> $member['ip_address'],
        'username'		=> $member['members_display_name'],
        )		);


        //-----------------------------------------
        // Restriction permissions stuff
        //-----------------------------------------

        if ( $this->memberData['row_perm_cache'] )
        {
            if ( $this->caches['group_cache'][ intval($member_group) ]['g_access_cp'] )
            {
                //-----------------------------------------
                // Copy restrictions...
                //-----------------------------------------

                $this->DB->insert( 'admin_permission_rows', array(
                'row_member_id'  => $member_id,
                'row_perm_cache' => $this->memberData['row_perm_cache'],
                'row_updated'    => time()
                )	 );
            }
        }

        //-----------------------------------------
        // Send teh email (I love 'teh' as much as !!11!!1)
        //-----------------------------------------

        if( $options['sendemail'] )
        {
            IPSText::getTextClass('email')->getTemplate("account_created");

            IPSText::getTextClass('email')->buildMessage( array(
            'NAME'         => $member['name'],
            'EMAIL'        => $member['email'],
            'PASSWORD'	   => $in_password
            )
            );

            IPSText::getTextClass('email')->to		= $member['email'];
            IPSText::getTextClass('email')->sendMail();
        }

        //-----------------------------------------
        // Stats
        //-----------------------------------------

        $this->cache->rebuildCache( 'stats', 'global' );

        if($this->returnAsBool)
        {
            return true;
        }

        return $data;
    }

    /**
     * Delete members cookies set by the board
     * And logout the member
     *
     * @author Vadim
     * @return Bool
     */
    public function logOut()
    {
        //-----------------------------------------
        // Set some cookies
        //-----------------------------------------

        IPSCookie::set( "member_id" , "0"  );
        IPSCookie::set( "pass_hash" , "0"  );
        IPSCookie::set( "anonlogin" , "-1" );

        if( is_array( $_COOKIE ) )
        {
            foreach( $_COOKIE as $cookie => $value)
            {
                if ( stripos( $cookie, $this->settings['cookie_id'] . 'ipbforumpass' ) !== false )
                {
                    IPSCookie::set( $cookie, '-', -1 );
                }
            }
        }

        //-----------------------------------------
        // Logout callbacks...
        //-----------------------------------------

        $this->login->logoutCallback();

        //-----------------------------------------
        // Do it..
        //-----------------------------------------

        $this->member->sessionClass()->convertMemberToGuest();

        list( $privacy, $loggedin ) = explode( '&', $this->memberData['login_anonymous'] );

        IPSMember::save( $this->memberData['member_id'], array( 'core' => array( 'login_anonymous' => "{$privacy}&0", 'last_activity'   => time() ) ) );

        return true;

    }

    /**
     * Delete a user's cookies
     *
     * @author Vadim
     * @access	public
     * @param	boolean		Check the key
     * @return	mixed		Output error page if key checking fails, else boolean true
     */
    public function deleteCookies( )
    {

        //-----------------------------------------
        // Wipe out any forum password cookies
        //-----------------------------------------

        if ( is_array($_COOKIE) )
        {
            foreach( $_COOKIE as $cookie => $value )
            {
                if ( stripos( $cookie, $this->settings['cookie_id']."ipbforum" ) !== false )
                {
                    IPSCookie::set( str_replace( $this->settings['cookie_id'], "", $cookie ) , '-', -1 );
                }

                if ( stripos( $cookie, $this->settings['cookie_id']."itemMarking_" ) !== false )
                {
                    IPSCookie::set( str_replace( $this->settings['cookie_id'], "", $cookie ) , '-', -1 );
                }
            }
        }

        //-----------------------------------------
        // And the rest of the cookies
        //-----------------------------------------

        IPSCookie::set('pass_hash' , '-1');
        IPSCookie::set('member_id' , '-1');
        IPSCookie::set('session_id', '-1');
        IPSCookie::set('topicsread', '-1');
        IPSCookie::set('anonlogin' , '-1');
        IPSCookie::set('forum_read', '-1');

        return true;
    }

    /**
     * Check to see if a member is logged in
     *
     * @author Vadim
     * @return boolean
     */
    public function isLoggedIn()
    {
        return (bool) $this->member->member_id;
    }

}