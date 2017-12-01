<? $cookie=false;
if (!isset($_COOKIE['visited'])) {
	setcookie("visited",true,time()+72000);
} else { $cookie=true; } 
$cookie=false;
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Namibian Hunting | Hunting and Wildlife Holidays Namibia, Africa</title>
<link href="style.css" rel="stylesheet" />
<meta name="description" content="">
<meta name="geo.region" content="NA" />
<meta name="geo.position" content="-22.958;18.49" />
<meta name="ICBM" content="-22.958, 18.49" />
<link rel="shortcut icon" href="favicon.ico">
</head>
<body onresize="resize()">
<?
if (!$cookie) {
	include("../unvisited.php");
} else {
	include("../visited.php");
}
?>
<script type="text/javascript">
$(window).load( function () {
	$.ajax({
		url: "latest.php",
		cache: false,
		success: function (reply) {
			$("#news p").html(reply);
		}
	});
});
</script>
</body>
</html>