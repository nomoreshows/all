
	<br /><br />
	<?php 
		echo $form->create('Upload', array('action' => 'step3', 'type' => 'file'));	
		echo $form->input('id');
		echo $form->hidden('name');
		echo $cropimage->createJavaScript($uploaded['imageWidth'],$uploaded['imageHeight'],100,100); 
		echo $cropimage->createForm($uploaded["imagePath"], 100, 100);
		echo $form->submit('Valider', array("id" => "save_thumb"));
		echo $form->end();
	?>