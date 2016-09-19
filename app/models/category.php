<?php
class Category extends AppModel {
	
	var $name = "Category";
	
	var $hasMany = 'Article';
	
	var $order = "";

}
?>
