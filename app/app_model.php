<?php

class AppModel extends Model {

    /*// First, we override save(). On a successful save(), 
    // afterSave() is called. But we want something to be 
    // called on a NOT-successful save().
    function save($data = null, $validate = true, $fieldList = array()) {
        $returnval = parent::save($data, $validate, $fieldList);
        if(false === $returnval) {
            $this->afterSaveFailed();
        }
        return $returnval;
    }

    // Check for dupe errors
    function afterSaveFailed() {
        $db =& ConnectionManager::getDataSource($this->useDbConfig); 
        $lastError = $db->lastError();

        // this holds the match for the key id
        // add more for more database types
        $dupe_check = array(
            'mysql' => '/^\d+: Duplicate entry \'.*\' for key (\d+)$/i',
            'postgres' => '/^ERROR: duplicate key violates .+ "(.+)"$/i',
        );
        
        
        if (preg_match($dupe_check[$db->config['driver']], $lastError, $matches) && !empty($dupe_check[$db->config['driver']])) {
			$this->invalidate('login');
        }
    }*/
	var $actsAs = array('Containable');
} 

?>