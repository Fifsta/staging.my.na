
 
 <h2><?php echo $BUSINESS_NAME;?><small> Advertorial</small></h2>
 <div class="clearfix"></div>

<form id="advertorial-update" name="advertorial-update" method="post" action="<?php echo site_url('/');?>my_admin/update_business_advertorial" class="form-horizontal">
 <fieldset>
    		  

               <legend>Update Your Business Advertorial</legend>
              <textarea id="advertorial_body" name="advertorial_body" style="display:block" class="redactor"><?php echo $ADVERTORIAL;?></textarea>
     	  	  <div></div>
              
              <input type="hidden" name="advertorial_bus_id" value="<?php echo $ID;?>"> 
              <input type="hidden" name="id" value="<?php echo $this->session->userdata('admin_id');?>">
              <div style="height:10px; clear:both"></div>
              <div id="advert_result_msg"></div>
              <div style="height:10px; clear:both"></div>
              <button type="submit" class="btn-large btn pull-right" name="submit" id="but_advertorial"><b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" /></button>
               
   </fieldset> 
 </form>
 <script type="text/javascript">



$('#but_advertorial').click(function(e) {
	

	
	e.preventDefault();
	/*//Validate
	if($('#advertorial_body').val().length < 2){
		
		  $('#advertorial_body').popover({  
		  delay: { show: 100, hide: 2000 },
		  placement:"top",
		  html:true,trigger: "manual", 
		  title:"Name Required", 
		  content: "Please give provide us with a valid Business Advertorial"});
		  $('#advertorial_body').popover('show');
		  $('#advertorial_body').focus();

	}else{*/
		
		submit_form_advertorial();
		
	/*}*/
});


function submit_form_advertorial(){
		
		var frm = $('#advertorial-update');
		//frm.submit();
		$('#but_advertorial').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'my_admin/update_business_advertorial';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#advert_result_msg').html(data);
				 $('#but_advertorial').html('<b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
				
			}
		});	

}


</script>