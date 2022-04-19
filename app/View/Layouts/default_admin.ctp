<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!doctype html>
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
<meta charset="UTF-8">
<meta http-equiv="X-Frame-Options" content="deny">
<?php echo $this->element('metadata'); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 

echo $this->Html->meta('icon');

if(defined('RELEASE_V') && RELEASE_V){
    #echo $this->Html->css('bootstrap.min.css');
    echo $this->Html->css('bootstrap-material-design.min.css');
    echo $this->Html->css('ripples.min.css');
    echo $this->Html->css('jquery.dropdown.css');
    echo $this->Html->css('custom.css?v='.RELEASE);
}
echo $this->Html->css('style_admin.css?v='.RELEASE);
#echo $this->Html->css('colors_admin.css?v='.RELEASE);
echo $this->Html->css('jquery.fileinput');
#echo $this->Html->css('stylesheet_admin.css?v='.RELEASE);
echo $this->Html->css('jquery-ui');
echo $this->Html->css('google-font');
echo $this->Html->css('chromatron-red_admin.css?v='.RELEASE);
echo $this->Html->css('multiautocomplete');
echo $this->Html->css('osadmin');
echo $this->Html->css('material-icon');

?>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<?php if(defined('RELEASE_V') && RELEASE_V){ ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>material.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.dropdown.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>ripples.min.js" defer></script>
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" /> -->

<?php } ?>
<script type="text/javascript">
		var emlRegExpRFC = RegExp(
			/^[a-zA-Z0-9.’*+/_-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
		);
    var HTTP_ROOT = '<?php echo HTTP_ROOT; ?>'
</script>
</head>
<body id="easycase">
	<?php echo $this->element('admin_header_inner'); ?>
	<div style="min-height:350px"><?php echo $content_for_layout; ?></div>
	<?php echo $this->element('admin_footer_inner');?>
</body>
</html>