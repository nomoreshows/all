<?php 
class GravatarHelper extends Helper {

    var $helpers = array('Html');
	var $grav_url = "http://www.gravatar.com/avatar.php?"; // Url to gravatar service
	var $default = "http://serieall.fr/img/gravatar.png"; // Url to the default picture (ie if  the user has no gravatar)
    

    
/**
 * Retrieves an gravatar image and returns an image tag
 *
 * @param string  $email address used for gravatar generation
 * @param integer $size image size
 * @param array    $htmlAttributes Array of HTML attributes.
 * @param boolean $return Wheter this method should return a value or output it. This overrides AUTO_OUTPUT.
 * @return mixed    Either string or echos the value, depends on AUTO_OUTPUT and $return.
 * @access public
 */
    function image($email, $size, $htmlAttributes = array(), $return = false) {
        $gravatar_url = $this->grav_url."gravatar_id=".md5($email)."&amp;default=".urlencode($this->default)."&amp;size=".$size;        
        return $this->output(sprintf($this->Html->tags['image'], $gravatar_url, $this->Html->_parseAttributes($htmlAttributes, null, '', ' ')), $return);
    }


}
?>
