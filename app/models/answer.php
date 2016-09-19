<?php
class Answer extends AppModel {
	
	var $name = 'Answer';
	var $belongsTo = array('Question');
	var $hasMany = array('Vote');

	var $order = 'Answer.id ASC';
}