<?php
class AnswersController extends AppController {
	
	var $name = "Answers";
	var $layout = 'admin_default';

	var $paginate = array(
		'limit'     => 10,
		'recursive' => -1
	);

}