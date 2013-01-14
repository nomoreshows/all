<?php

class Role extends AppModel {
	
    var $name = 'Role';   
    var $belongsTo = array('Show','Actor');
	var $hasMany = array('Article', 'Quote');
	
	var $order = "Role.name ASC";
	
}
?>