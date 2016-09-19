<?php
class Api extends AppModel {
	
	var $name = "Api";
	
	var $useTable = false; 
	
	var $paginate = array(
        'limit' => 20
    );
	
}