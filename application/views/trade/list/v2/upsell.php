<?php
//+++++++++++++++++++++++++++++++++
//UPSELL
//+++++++++++++++++++++++++++++++++

$str = '';
if (isset($bus_id) && $bus_id != 0) {

    $str = ' for Business';

}
?>



        
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
<div class="white_box padding10">
   
	<div class="col-lg-8 col-lg-offset-2">
        <div class="clearfix">&nbsp;</div>  
        <div class="clearfix">&nbsp;</div>
        <p>Your item has been listed for free.</p>
		<h1 style="text-transform: uppercase">Do you want to <strong>FEATURE</strong> your item Online?</h1>
		<h5 style="text-transform:uppercase">For only N$350 per month, let over a  <strong>million</strong> people see your item online through all our partner sites. </h5>
        <p class="text-right"><a class="btn upsell" onclick="finish_up(false, 'classifieds');">No, I don't</a>
        <a class="btn btn-primary animated pulse infinite upsell" onclick="finish_up(true, 'classifieds');">Yes, Feature Me!</a></p>
         
        <div class="clearfix">&nbsp;</div>
    </div>

</div>
<script type="text/javascript">
 

</script>
 
    