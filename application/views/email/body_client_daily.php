<?php 
//TEST]
if(!isset($preview)){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Email from My Namibia</title>
<?php if(isset($preview_mail)){?>
<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.grid.css">
	
<?php	
}
?>

<style type="text/css">
html,body {
   margin:0;
   padding:0;
   height:100%;
   width:100%;
   background-color: #FFFFFF;
   text-align:center;
}


h1,h2,h3{
   font-family:Arial, Helvetica, sans-serif;
   font-weight:800;
   color: #666;
   font-size:21px;

}
	
.main{
border:1px solid #666666;
}	

.links {
    color: #CC0000;
	font-size:10px;
	font-weight: 600;
	font-family: Arial, Helvetica, sans-serif;
	line-height:5px;
	text-align:justify;
		}

.links  a { color: #CC0000; text-decoration: none; }
.links  a:hover { color:#47C7EA; text-decoration:none;  }
.links  a:visted { color:#47C7EA; text-decoration: none;}	

.info {
    color: #999999;
	font-size:10px;
	font-weight:300;
	font-family: Arial, Helvetica, sans-serif;
	line-height:5px;
	text-align:justify;
		}

.info  a { color: #CC0000; text-decoration: none; }
.info  a:hover { color:#47C7EA; text-decoration:none;  }
.info  a:visted { color:#47C7EA; text-decoration: none;}	

.toplinks {
    color: #999999;
	font-size:13px;
	font-weight: 800;
	font-family: Arial, Helvetica, sans-serif;
	text-align: right;
		}

.toplinks  a { color: #47C7EA; text-decoration: none; }
.toplinks  a:hover { color:#CC0000; text-decoration:none;  }
.toplinks  a:visted { color:#47C7EA; text-decoration: none;}	

.footerlinks {
    color: #FFFFFF;
	font-size:10px;
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
		}

.footerlinks  a { color: #FFFFFF; text-decoration: underline; }
.footerlinks  a:hover { color: #FF0000; text-decoration:none;  }
.footerlinks  a:visted { color:#47C7EA; text-decoration: none;}	

.white_box{
		padding:10px;
		background-color:#fff;
		margin-bottom:10px;
		  background:#fff;
	  -moz-box-shadow:      0 0 10px #666;
	   -webkit-box-shadow:  0 0 10px #666;
	   box-shadow:         0 0 10px #666;
	   -moz-border-radius: 5px;
	  -webkit-border-radius: 5px;
	  border-radius: 5px; /* future proofing */
	  -khtml-border-radius: 5px; /* for old Konqueror browsers */
	}

*, p{font-family:Arial, Helvetica, sans-serif; color: #666;}

a{text-decoration:none}
.btn{display:inline-block;*display:inline;*zoom:1;padding:4px 12px;margin-bottom:0;font-size:14px;line-height:20px;text-align:center;vertical-align:middle;cursor:pointer;color:#333333;text-shadow:0 1px 1px rgba(255, 255, 255, 0.75);background-color:#f5f5f5;background-image:-moz-linear-gradient(top, #ffffff, #e6e6e6);background-image:-webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));background-image:-webkit-linear-gradient(top, #ffffff, #e6e6e6);background-image:-o-linear-gradient(top, #ffffff, #e6e6e6);background-image:linear-gradient(to bottom, #ffffff, #e6e6e6);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);border-color:#e6e6e6 #e6e6e6 #bfbfbf;border-color:rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);*background-color:#e6e6e6;filter:progid:DXImageTransform.Microsoft.gradient(enabled = false);border:1px solid #cccccc;*border:0;border-bottom-color:#b3b3b3;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;*margin-left:.3em;-webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);-moz-box-shadow:inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);box-shadow:inset 0 1px 0 rgba(255,255,255,.2), 0 1px 2px rgba(0,0,0,.05);}.btn:hover,.btn:focus,.btn:active,.btn.active,.btn.disabled,.btn[disabled]{color:#333333;background-color:#e6e6e6;*background-color:#d9d9d9;}
.btn:active,.btn.active{background-color:#cccccc \9;}
.btn:first-child{*margin-left:0;}
.btn:hover,.btn:focus{color:#333333;text-decoration:none;background-position:0 -15px;-webkit-transition:background-position 0.1s linear;-moz-transition:background-position 0.1s linear;-o-transition:background-position 0.1s linear;transition:background-position 0.1s linear;}
.btn:focus{outline:thin dotted #333;outline:5px auto -webkit-focus-ring-color;outline-offset:-2px;}
</style>
</head>

<body bgcolor="#FF7401">
<?php 
//TEST]
}?>
<?php $base = base_url('/');?>
<table width="100%"  bgcolor="#FF7401" border="0" cellspacing="0" cellpadding="0">
   <?php if (isset($link)){?>
  <?php }else{?>
   <tr>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;text-align:center;color:#FFFFFF; vertical-align:top">Problems viewing this email? <a href="<?php echo site_url('/')?>cron_jobs/preview_email/<?php echo $client_id;?>/">View in your browser</a></td>
  </tr>
   <?php }?>
  <tr>
    <td><table width="700px" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" align="center" style="background-color:#FFF;border: 1px solid #999999; width:700px;">
  
  <tr>
    <td bgcolor="#333" style="background-color: #333;text-align:left; height:30px;padding:10px 0px 5px 0px"><img src="<?php echo $base;?>/images/icons/my-na-favicon.png" style="float:left;width:auto;margin:10px 20px 15px 20px" alt="Download Pictures to view" /></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="630" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr >
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;" align="center"></td>
  </tr>
  
</table></td>
  </tr>
  <tr>
    <td width="593" style="width:593px"><table width="593px" style="background-color:#FFF;width:593px" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" id="preview_holder" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; background-color:#FFF; color:#666666; text-align:left">
		<div style="width:593px;">
		<?php 
		if(isset($preview_mail)){
			
			$this->cron_model->preview_daily_email($client_id);
		}else{
			
			$this->cron_model->send_daily_email($client_id, $name);	
		}
		 ?>
        </div>
        </td>
      </tr>
      <tr>
        <td width="2428928" colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">&nbsp;</td>
      </tr>
  
      <tr>
        <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; text-align:left"></td>
      </tr>
      </table></td>
  </tr>
  
  
  <tr>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px; " align="center">&nbsp;</td>
  </tr>
   <tr style="background-color: #f9f9f9">
     <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;" align="center"></td>
   </tr>
   <tr style="background-color: #f9f9f9">
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;" align="center"><img src="<?php echo $base;?>/images/bground/my-na-bottom-mail.png" style="float:none;width:600px;margin:5px 20px 5px 0px" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="center" style="text-align:center;width:100%"><div style="text-align:center">
      <div style="margin:auto;width:600px;font-size:10px;color:#fff; font-family:Arial, Helvetica, sans-serif; text-align:center">You have received this email because you have registered on the My Namibia platform to help you connect with Namibia.  If you really want to change this and unsubscribe from the updates please click on the following link. <a href="<?php echo site_url('/')?>members/unsubscribe_daily/<?php echo $client_id;?>/" style="font-size:10px; color: #000; text-decoration: underline; font-weight:bold;" >unsubscribe</a> <br />
    This email was sent with your permission from My Namibia, 8 Schinz Street Windhoek Namibia - +264 61 231 006</div></div></td>
  </tr>
</table>
<?php 
//TEST]
if(!isset($preview)){ ?>
</body>
</html>
<?php 
//TEST]
} ?>