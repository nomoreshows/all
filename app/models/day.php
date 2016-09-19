<?php
class Day extends AppModel {
	
	var $name = 'Day';
	var $hasAndBelongsToMany = array('Artist');
	var $belongsTo = array('Festival');
	
	var $displayField = 'date';
	var $order = 'Day.date DESC';
	
	var $actsAs = 'ExtendAssociations'; 
}