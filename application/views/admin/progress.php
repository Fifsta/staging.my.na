<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
	<meta name="author" content="">
	<title></title>
	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script>


</head>
<body>

<p><?php echo $string;?></p>
<div class="progress progress-striped active" id="barcover" style="display:block">
    <div class="bar" style="width:<?php echo $progress;?>%;"></div>
</div>
<?php if (isset($java)){
	echo $java;
}?>

</body>
</html>