<?php 
//TEST]
if(!isset($preview)){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Email from My Namibia</title>

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
   font-style:italic;
   font-weight:800;
   color: #666;
   font-size:21px;

}
	
.main{
border:1px solid #666666;
}	

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
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;text-align:center;color:#FFFFFF; vertical-align:top">&nbsp;</td>
  </tr>
   <?php }?>
  <tr>
    <td><table width="700px" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" align="center" style="background-color:#FFF;border: 3px solid #000">
  
  <tr>
    <td bgcolor="#000" style="background-color: #000; text-align: left"><?php if(isset($logo)){echo $logo; }else{ echo '<img src="'.base_url('/').'images/my-na-logo-black.png" style="float:left;width:auto;margin:10px 20px 15px 20px" />';}?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><table width="630" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr >
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;" align="center"></td>
  </tr>
  
</table></td>
  </tr>
  <tr>
    <td><table width="593" style="background-color:#FFF;" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#666666; text-align:left">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" id="preview_holder" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; background-color:#FFF; color:#666666; text-align:left"><?php if(isset($body)){ echo $body;};?></td>
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
   <tr style="background-color: #000">
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:10px;" align="center"><img src="<?php echo $base;?>/images/bground/my-na-bottom-mail.jpg" style="float:none;width:700px;margin:0px" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="center" style="text-align:center;width:100%"><div style="text-align:center">
      <div style="margin:auto;width:600px;font-size:10px;color:#fff; font-family:Arial, Helvetica, sans-serif; text-align:center">You have received this email because you have registered on the My Namibia platform to help you connect with Namibia.  If you really want to change this and unsubscribe from the updates please click on the following link. <a href="<?php echo site_url('/')?>members/unsubscribe_daily/" style="font-size:10px; color: #000; text-decoration: underline; font-weight:bold;" >unsubscribe</a> <br />
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