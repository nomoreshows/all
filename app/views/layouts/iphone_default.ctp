<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta content="minimum-scale=1.0, width=device-width, maximum-scale=0.6667, user-scalable=no" name="viewport" />
<?php
	echo $html->css('iphone');
	echo $javascript->link('iphone', true);
?>
<title>
	<?php __('Serie All -'); ?>
    <?php echo $title_for_layout; ?>
</title>
</head>

<body>

        <?php echo $content_for_layout; ?>

</body>
</html>
