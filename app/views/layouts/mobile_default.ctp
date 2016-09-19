<!DOCTYPE html>
<html>
<head>
<title>
	<?php __('Serie All -'); ?>
    <?php echo $title_for_layout; ?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	echo $html->css('jquery.mobile-1.0a2.min');
	echo $html->css('mobile');
	echo $javascript->link('jquery-1.4.3.min', true);
	echo $javascript->link('jquery.mobile-1.0a2.min', true);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<link rel="apple-touch-icon" href="/favicons/touch-icon-iphone.png"/>
<link rel="apple-touch-icon" sizes="72x72" href="/favicons/touch-icon-ipad.png" />
<link rel="apple-touch-icon" sizes="114x114" href="/favicons/touch-icon-iphone4.png" />

<body>
        <?php echo $content_for_layout; ?>
</body>
</html>
