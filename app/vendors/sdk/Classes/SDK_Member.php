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

class SDK_Member
{
    /**
     * IPB Registry object
     *
     * @var Object
     */
    public $registry;

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
	 * memberFunctions object reference
	 *
	 * @access	private
	 * @var		object
	 */
    static private $_memberFunctions;

    /**
     * Constructor
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
	 * Easy peasy way to grab a function from member/memberFunctions.php
	 * without having to bother setting it up each time.
	 *
	 * @access	public
	 * @return	object		memberFunctions object
	 * @author	MattMecham
	 */
    public function getFunction()
    {
        if ( ! is_object( self::$_memberFunctions ) )
        {
            require_once( IPS_ROOT_PATH . 'sources/classes/member/memberFunctions.php' );
            self::$_memberFunctions = new memberFunctions( ipsRegistry::instance() );
        }

        return self::$_memberFunctions;
    }

    /**
	 * Cleans a username or display name, also checks for any errors
	 *
	 * @access	public
	 * @param	string  $name			Username or display name to clean and check
	 * @param	array	$member			[ Optional Member Array ]
	 * @param	string  $field			name or members_display_name
	 * @return	array   Returns an array with 2 keys: 'username' OR 'members_display_name' => the cleaned username, 'errors' => Any errors found
	 **/
    public function cleanAndCheckName( $name, $member=array(), $field='members_display_name' )
    {
        return $this->getFunction()->cleanAndCheckName($name, $member, $field);
    }

    /**
	 * Check for an existing display or user name
	 *
	 * @access	public
	 * @param	string	Name to check
	 * @param	array	[ Optional Member Array ]
	 * @param	string	name or members_display_name
	 * @param	bool	Ignore display name changes check (e.g. for registration)
	 * @param	bool	Do not clean name again (e.g. coming from cleanAndCheckName)
	 * @return	mixed	Either an exception or ( true if name exists. False if name DOES NOT exist )
	 * Error Codes:
	 * NO_PERMISSION		This user cannot change their display name at all
	 * NO_MORE_CHANGES		The user cannot change their display name again in this time period
	 * NO_NAME				No display name (or shorter than 3 chars was given)
	 * ILLEGAL_CHARS		The display name contains illegal characters
	 */
    public function checkNameExists( $name, $member=array(), $field='members_display_name', $ignore=false, $cleaned=false )
    {
        try
        {
            return $this->getFunction()->checkNameExists( $name, $member, $field, $ignore, $cleaned );
        }
        catch (Exception $e)
        {
            if($e->getMessage())
            {
                return $e->getMessage();
            }
        }
    }

    /**
	 * Delete personal photo function
	 * Assumes all security checks have been performed by this point
	 *
	 * @access	public
	 * @param	integer		[Optional] member id instead of current member
	 * @return 	boolean     photo deleted or not
	 */
    public function deleteMemberPhoto( $member_id = 0 )
    {
        $_POST['delete_photo'] = 1;

        $return = $this->getFunction()->uploadPhoto( $member_id );

        return ($return['status'] == 'deleted') ? true : false;
    }

    /**
	 * Upload personal photo function
	 * Assumes all security checks have been performed by this point
	 * the input file name must be called 'upload_photo'
	 * For example:
	 * 
	 * Right:
	 * <input type='file' name='upload_photo' />
	 * 
	 * Wrong:
	 * <input type='file' name='photoupload' />
	 * <input type='file' name='photo' />
	 * <input type='file' name='upload' />
	 *
	 * @access	public
	 * @param	integer		[Optional] member id instead of current member
	 * @return 	boolean/array 
	 * 
	 * Array consists of:
	 * final_location - final image location
	 * final_width - large image width
	 * final_height - large image height
	 * t_final_location - thumb image location
	 * t_final_width - thumb image width
	 * t_final_height - thumb image height
	 * status - status ok == true, fail == false
	 * error - error string key (ex: upload_to_big)
	 *   		
	 */
    public function uploadMemberPhoto( $member_id = 0 )
    {
        if( !isset($_FILES) || !count($_FILES) )
        {
            return array('error' => 'upload_failed');
        }

        $return = $this->getFunction()->uploadPhoto( $member_id );

        return $this->returnAsBool ? ($return['status'] == 'ok') ? true : false : $return;
    }

    /**
	 * Remove member uploaded photos
	 *
	 * @access	public
	 * @param	integer		[Optional] member id instead of current member
	 * @param	string		[Optional] Directory to check
	 */
    public function removeUploadedPhotos( $member_id = 0, $upload_path='' )
    {
        if(!intval($member_id))
        {
            $member_id = $this->member->member_id;
        }
        return $this->getFunction()->removeUploadedPhotos( $member_id, $upload_path );
    }

    /**
	 * Remove member's avatar
	 *
	 * @access	public
	 * @param	int			[Optional] member id instead of current member
	 * @return	mixed		Exception or true
	 * <code>
	 * Exception Codes:
	 * NO_MEMBER_ID:					A valid member ID was not passed.
	 * NO_PERMISSION:				You do not have permission to change the avatar
	 * </code>
	 */
    public function removeAvatar( $member_id = 0 )
    {
        if(!intval($member_id))
        {
            $member_id = $this->member->member_id;
        }

        try
        {
            return $this->getFunction()->removeAvatar( $member_id );
        }
        catch (Exception $e)
        {
            return $this->returnAsBool ? false : $e->getMessage();
        }
    }

    /**
	 * Saves the member's avatar
	 *
	 * @param		INT			    [Optional] member id instead of current member
	 * @param		string		    Upload field name [Default is "upload_avatar"]
	 * @param		string		    Avatar URL Field [Default is "avatar_url"]
	 * @param		string		    Gallery Avatar Directory Field [Default is "avatar_gallery"]
	 * @param		string		    Gallery Avatar Image Field [Default is "avatar_image"]
	 * @return      Boolean/Mixed   Boolean value if the $this->returnAsBool is true or the error message thrown
	 *                              or the array of the avatar information updated
	 * 
	 * @author		Brandon Farber, Stolen By Matt 'Haxor' Mecham
	 * <code>
	 * Excepton Codes:
	 * NO_MEMBER_ID:				A valid member ID was not passed.
	 * NO_PERMISSION:				You do not have permission to change the avatar
	 * UPLOAD_NO_IMAGE:				Nothing to upload
	 * UPLOAD_INVALID_FILE_EXT:		Incorrect file extension (not an image)
	 * UPLOAD_TOO_LARGE:			Upload is larger than allowed
	 * UPLOAD_CANT_BE_MOVED:		Upload cannot be moved into the uploads directory
	 * UPLOAD_NOT_IMAGE:			Upload is not an image, despite what the file extension says!
	 * NO_AVATAR_TO_SAVE:			Nothing to save!
	 * </code>
	 */
    public function saveNewAvatar( $member_id = 0, $uploadFieldName='upload_avatar', $urlFieldName='avatar_url', $galleryFieldName='avatar_gallery', $avatarGalleryImage='avatar_image', $gravatarFieldName='gravatar_email' )
    {
        if(!intval($member_id))
        {
            $member_id = $this->member->member_id;
        }

        try
        {
            $return = $this->getFunction()->saveNewAvatar( $member_id, $uploadFieldName, $urlFieldName, $galleryFieldName, $avatarGalleryImage, $gravatarFieldName );
        }
        catch (Exception $e)
        {
            return $this->returnAsBool ? false : $e->getMessage();
        }

        $member = IPSMember::load( $member_id, 'extendedProfile' );

        return $this->returnAsBool ? true : array( 'avatar_location' => $member['avatar_location'], 'avatar_size' => $member['avatar_size'], 'avatar_type' => $member['avatar_type'] );
    }

    /**
	 * Grab all images within a particular avatar gallery directory
	 *
	 * @access	public
	 * @param	string		Selected category name
	 * @return	array 		Array of image names
	 */
    public function getHostedAvatarsFromCategory( $catName )
    {
        return $this->getFunction()->getHostedAvatarsFromCategory( $catName );
    }

    /**
	 * Grab all hosted avatar gallery directories
	 *
	 * @access	public
	 * @author	Brandon Farber, Matt Mecham
	 * @return	array 	Array of hosted avatar cats
	 */
    public function getHostedAvatarCategories()
    {
        return $this->getFunction()->getHostedAvatarCategories( );
    }

    /**
	 * Create new member
	 * Very basic functionality at this point.
	 *
	 * @access	public
	 * @param	array 	Fields to save in the following format: array( 'members'      => array( 'email'     => 'test@test.com',
	 *																				         'joined'   => time() ),
	 *															   'extendedProfile' => array( 'signature' => 'My signature' ) );
	 *					Tables: members, pfields_content, profile_portal.
	 *					You can also use the aliases: 'core [members]', 'extendedProfile [profile_portal]', and 'customFields [pfields_content]'
	 * @param	bool	Flag to attempt to auto create a name if the desired is taken
	 * @param	bool	Bypass custom field saving (if using the sso session integration this is required as member object isn't ready yet)
	 * @return	array 	Final member Data including member_id
	 * 
	 * Options aviable for the members table
	 * 
	 *   members_l_username
     *   joined
     *   email
     *   member_group_id
     *   ip_address
     *   members_created_remote
     *   member_login_key
     *   member_login_key_expire
     *   view_sigs
     *   email_pm
     *   view_img
     *   view_avs
     *   restrict_post
     *   view_pop
     *   msg_count_total
     *   msg_count_new
     *   msg_show_notification
     *   coppa_user
     *   auto_track
     *   last_visit
     *   last_activity
     *   language
     *   members_editor_choice
     *   members_pass_salt
     *   members_pass_hash
     *   members_display_name
     *   members_l_display_name
     *   fb_uid
     *   fb_emailhash
     *   members_seo_name
     *   bw_is_spammer
	 *
	 * EXCEPTION CODES
	 * CUSTOM_FIELDS_EMPTY    - Custom fields were not populated
	 * CUSTOM_FIELDS_INVALID  - Custom fields were invalid
	 * CUSTOM_FIELDS_TOOBIG   - Custom fields too big
	 */
    public function fullCreateMember($tables=array(), $autoCreateName=FALSE, $bypassCfields=FALSE)
    {
        $return = IPSMember::create($tables, $autoCreateName, $bypassCfields);

        return $return;
    }

    /**
	 * Save member
	 *
	 * @access	public
	 * @param 	int		[Optional] Member key: Either Array, ID or email address. If it's an array, it must be in the format:
	 *					 array( 'core' => array( 'field' => 'member_id', 'value' => 1 ) ) - useful for passing custom fields through
	 *                   If omitted then the current member id will be used
	 * @param 	array 	Fields to save in the following format: array( 'members'      => array( 'email'     => 'test@test.com',
	 *																				         'joined'   => time() ),
	 *															   'extendedProfile' => array( 'signature' => 'My signature' ) );
	 *					Tables: members, pfields_content, profile_portal.
	 *					You can also use the aliases: 'core [members]', 'extendedProfile [profile_portal]', and 'customFields [pfields_content]'
	 * @return	boolean	True if the save was successful
	 *
	 * Exception Error Codes:
	 * NO_DATA 		  : No data to save
	 * NO_VALID_KEY    : No valid key to save
	 * NO_AUTO_LOAD    : Could not autoload the member as she does not exist
	 * INCORRECT_TABLE : Table one is attempting to save to does not exist
	 * NO_MEMBER_GROUP_ID: Member group ID is in the array but blank
	 */
    public function save( $member_key = '', $save=array() )
    {
        if( !intval($member_key) )
        {
            $member_key = $this->member->member_id;
        }

        try
        {
            $return = IPSMember::save($member_key, $save);
        }
        catch (Exception $e)
        {
            return $this->returnAsBool ? false : $e->getMessage();
        }

        return $return;
    }

    /**
	 * Load member
	 *
	 * @access	public
	 * @param 	string	[Optional] Member key: Either ID or email address OR array of IDs when $key_type is either ID or not set OR a list of $key_type strings (email address, name, etc)
	 *                  If omitted then the current member id will be used
	 * @param 	string	Extra tables to load(all, none or comma delisted tables) Tables: members, pfields_content, profile_portal, groups, sessions, core_item_markers_storage.
	 *					You can also use the aliases: 'extendedProfile', 'customFields' and 'itemMarkingStorage'
	 * @param	string  Key type. Leave it blank to auto-detect or specify "id", "email", "username", "displayname".
	 * @return	array   Array containing member data
	 * <code>
	 * # Single member
	 * $member = IPSMember::load( 1, 'extendedProfile,groups' );
	 * $member = IPSMember::load( 'matt@email.com', 'all' );
	 * $member = IPSMember::load( 'MattM', 'all', 'displayname' ); // Can also use 'username', 'email' or 'id'
	 * # Multiple members
	 * $members = IPSMember::load( array( 1, 2, 10 ), 'all' );
	 * $members = IPSMember::load( array( 'MattM, 'JoeD', 'DaveP' ), 'all', 'displayname' );
	 * </code>
	 */
    public function load( $member_key = '', $extra_tables='all', $key_type='' )
    {
        if( !intval($member_key) )
        {
            $member_key = $this->member->member_id;
        }

        return IPSMember::load($member_key, $extra_tables, $key_type);
    }

    /**
	 * Delete member(s)
	 *
	 * @access	public
	 * @param 	mixed		[Integer] member ID or [Array] array of member ids
	 * @param	boolean		Check if request is from an admin
	 * @return	boolean		Action completed successfully
	 */
    public function remove( $id=0, $check_admin=true )
    {
        if( !is_array($id) && !intval($id) )
        {
            $id = $this->member->member_id;
        }

        $return = IPSMember::remove($id, $check_admin);

        return $return === null ? true : false;
    }

    /**
	 * Fetches SEO name, updating the table if required
	 *
	 * @access	public
	 * @param	array		Member data either an array of key value pairs or 
	 *                      an integer of the member id, if ommited then it will use
	 *                      The current member id instead
	 * @return	string		SEO Name
	 */
    public function fetchSeoName( $memberData=array() )
    {
        if( !count($memberData) )
        {
            $memberData = $this->load();
        }

        return IPSMember::fetchSeoName($memberData);
    }

    /**
	 * Determine if two members are friends
	 *
	 * @access	public
	 * @author	Brandon Farber
	 * @param	integer		Member ID to check for
	 * @param	integer 	Member ID to check against (defaults to current member id)
	 * @return	boolean		Whether they are friends or not
	 * @since	IPB 3.0
	 **/
    public function checkFriendStatus( $memberId, $checkAgainst=0 )
    {
        return IPSMember::checkFriendStatus($memberId, $checkAgainst);
    }

    /**
	 * Determine if a member is ignoring another member
	 *
	 * @access	public
	 * @author	Brandon Farber
	 * @param	integer		Member ID to check for
	 * @param	integer 	Member ID to check against (defaults to current member id)
	 * @param	string		Type of ignoring to check [messages|topics].  Omit to check any type.
	 * @return	boolean		Whether the member id to check for is being ignored by the member id to check against
	 * @since	IPB 3.0
	 **/
    public function checkIgnoredStatus( $memberId, $checkAgainst=0, $type=false )
    {
        return IPSMember::checkIgnoredStatus($memberId, $checkAgainst, $type );
    }

    /**
	 * Retrieve all IP addresses a user (or multiple users) have used
	 *
	 * @access	public
	 * @param 	mixed		[Integer] member ID or [Array] array of member ids
	 * @param	string		Defaults to 'All', otherwise specify which tables to check (comma separated)
	 * @return	array		Multi-dimensional array of found IP addresses in which sections
	 */
    public function findIPAddresses( $id=0, $tables_to_check='all' )
    {
        if( !count($id) && !intval($id) )
        {
            $id = $this->member->member_id;
        }

        return IPSMember::findIPAddresses($id, $tables_to_check);
    }

    /**
	 * Check forum permissions
	 * 
	 * Forum perms can be:
	 * view
	 * read
	 * start
	 * reply
	 * upload
	 * download
	 *
	 * @access	public
	 * @param	string		Permission type
	 * @param	int			Forum ID to check against
	 * @return	boolean
	 * @since	2.0
	 */
    public function checkPermissions( $perm="", $forumID=0 )
    {
        return IPSMember::checkPermissions( $perm, $forumID );
    }

    /**
	 * Check forum permissions
	 *
	 * @access	public
	 * @param	string	Comma delim. of group IDs (2,4,5,6)
	 * @return	string  Comma delim of PERM MASK ids
	 * @since	2.1.1
	 */
    public function createPermsFromGroup( $in_group_ids )
    {
        return IPSMember::createPermsFromGroup( $in_group_ids );
    }

    /**
	 * Set up defaults for a guest user
	 *
	 * @access	public
	 * @param	string	Guest name
	 * @return	array 	Guest record
	 * @since	2.0
	 * @todo		[Future] We may want to move this into the session class at some point
	 */
    public function setUpGuest($name='Guest')
    {
        return IPSMember::setUpGuest($name);
    }

    /**
	 * Parse a member's profile photo
	 *
	 * @access	public
	 * @param	mixed	[Optional] Member key: Either ID or email address
	 *                  If omitted then the current member id will be used
	 * @return	array 	Member's photo details
	 */
    public function buildProfilePhoto( $member_key=null )
    {
        if( !$member_key )
        {
            $member_key = $this->member->member_id;
        }

        $memberData = $this->load($member_key, 'extendedProfile');

        return IPSMember::buildProfilePhoto($memberData);
    }

    /**
	 * Parse a member for display
	 *
	 * @access	public
	 * @param	mixed	[Optional] Member key: Either ID or email address
	 *                  If omitted then the current member id will be used
	 * @param	array 	Array of flags to parse: 'signature', 'customFields', 'avatar', 'warn'
	 * @return	array 	Parsed member data
	 */
    public function buildDisplayData( $member_key=null, $_parseFlags=array() )
    {
        if( !$member_key )
        {
            $member_key = $this->member->member_id;
        }

        $memberData = $this->load($member_key);

        return IPSMember::buildDisplayData($memberData, $_parseFlags);
    }
    
    /**
	 * Returns user's avatar
	 *
	 * @access	public
	 * @param	mixed		[Optional] Member key: Either ID or email address
	 *                      If omitted then the current member id will be used
	 * @param	bool		Whether to avoid caching
	 * @param	bool		Whether to show avatar even if view_avs is off for member
	 * @return	string		HTML
	 * @since	2.0
	 */
    public function buildAvatar( $member_key=null, $no_cache=0, $overRide=0 )
    {
        if( !$member_key )
        {
            $member_key = $this->member->member_id;
        }

        $memberData = $this->load($member_key);
        
        return IPSMember::buildAvatar($memberData, $no_cache, $overRide);
    }
    
    /**
	 * Checks for a DB row that matches $email
	 *
	 * @access	public
	 * @param	string 		Email address
	 * @return	boolean		Record exists
	 */
	public function checkByEmail( $email )
	{
	    return IPSMember::checkByEmail($email);
	}
	
	/**
	 * Updates member's DB row password
	 *
	 * @access	public
	 * @param	string		[Optional] Member key: Either ID or email address
	 *                      If omitted then the current member id will be used
	 * @param	string		MD5-once hash of new password
	 * @return	boolean		Update successful
	 */
	public function updatePassword( $member_key=null, $new_md5_pass )
	{
	    if( !$member_key )
        {
            $member_key = $this->member->member_id;
        }
        
	    IPSMember::updatePassword( $member_key, $new_md5_pass );
	}
	
	/**
	 * Generates a compiled passhash.
	 * Returns a new MD5 hash of the supplied salt and MD5 hash of the password
	 *
	 * @access	public
	 * @param	string		User's salt (5 random chars)
	 * @param	string		User's MD5 hash of their password
	 * @return	string		MD5 hash of compiled salted password
	 */
	public function generateCompiledPasshash( $salt, $md5_once_password )
	{
	    return IPSMember::generateCompiledPasshash( $salt, $md5_once_password );
	}
	
	/**
	 * Generates a password salt.
	 * Returns n length string of any char except backslash
	 *
	 * @access	public
	 * @param	integer		Length of desired salt, 5 by default
	 * @return	string		n character random string
	 */
	public function generatePasswordSalt($len=5)
	{
	    return IPSMember::generatePasswordSalt($len);
	}
	
	/**
	 * Generates a log in key
	 *
	 * @access	public
	 * @param	integer		Length of desired random chars to MD5
	 * @return	string		MD5 hash of random characters
	 */
	public function generateAutoLoginKey( $len=60 )
	{
	    IPSMember::generateAutoLoginKey($len);
	}
	
	/**
	 * Check to see if a member is banned (or not)
	 *
	 * @access	public
	 * @param	string		Type of ban check (ip/ipAddress, name, email)
	 * @param	string		String to check
	 * @return	boolean		TRUE (banned) - FALSE (not banned)
	 */
	public function isBanned( $type, $string )
	{
	    return IPSMember::isBanned($type, $string);
	}
	
	/**
	 * Sends a query to the IPS Spam Service
	 *
	 * @access	public
	 * @param	string		$email		Email address to check/report
	 * @param	string		[$ip]		IP Address to check report, ipsRegistry::member()->ip_address will be used if the address is not specified
	 * @param	string		[$type]		Either register or markspam, register is default
	 * @return	string
	 */
	public function querySpamService( $email, $ip='', $type='register', $test=0 )
	{
	    return IPSMember::querySpamService($email, $ip, $type, $test);
	}
}

