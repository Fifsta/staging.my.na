 <?php 
 //+++++++++++++++++
 //My.Na SCRATCH AND WIN ADMIN
 //+++++++++++++++++
 //Roland Ihms
 //Get Account Details


 ?>
<h3>Scratch and Win</h3>
<!--<a class="btn pull-right disabled" style="margin:5px;" onclick="load_prizes()" >Prizes </a>&nbsp;
<a class="btn pull-right disabled" style="margin:5px;" onclick="load_winners()">Scratch Winners </a>&nbsp;
<a class="btn pull-right" style="margin:5px;" onclick="load_promos()">Promotions </a>&nbsp;
<a class="btn pull-right disabled" style="margin:5px;" onclick="load_logs()">Play Logs </a>&nbsp;-->

<div id="scratch_prizes" style="width:100%"></div>
<div id="scratch_promotions" style="width:100%"></div>
<div id="scratch_logs" style="width:100%"></div>
<div id="scratch_winners" style="width:100%"></div>
<div id="scratch_win_content">
<?php

//$this->scratch_model->canUserWinPrize_test('1');
$this->admin_model->get_scratch_promotions();	
//$this->admin_model->get_scratch_prizes('1');
//$this->admin_model->get_scratch_logs();	

?>
</div>

<div class="row-fluid">
    <div class="span6">
    <?php
    
    $this->scratch_model->canUserWinPrize_test('1');

    ?>
    </div>
    <div class="span6">
      <?php
    
   
    $this->scratch_model->canUserWinPrize_test('3');	
   
    ?>
    </div>
</div>

<div id="scratch_win_body">

</div>

<div id="modal-promo-update" class="modal hide fade">

    <div class="modal-header">
      <a href="#" onclick="javascript:$('#modal-promo-update').modal('hide')" class="close">&times;</a>
      <h3>Update the Promotion</h3>
    </div>
     <div class="modal-body">
      <div id="promo_content"></div>
          
      <div id="promo_msg"></div>
    </div>

    <div class="modal-footer">
      <a href="#" onclick="javascript:$('#modal-promo-update').modal('hide')" class="btn btn-secondary">Close</a>
    </div>
 
</div>
<style>
.datepicker{z-index:1151;}
</style>
<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>
<script type="text/javascript">


	$(document).ready(function(){
					
			//$('#dpstart').datepicker()
			
			//$('#dpend').datepicker()
	});	

	function set_prize_status(id, status){
			  $("#scratch_win_content").empty().addClass("loading_img");
			  $.ajax({
				  type: "get",
				  cache: false,
				  url: "<?php echo site_url('/')?>my_admin/set_prize_status/"+id+"/"+status ,
				  success: function (data) {
					 
					 $("#msg_admin").html(data);
					 window.setTimeout( load_ajax("scratch") , "2000");
						  
				  }
			  });	 					
	}
	function update_prize(id){
		
			  var x = $("#scratch_win_content").empty().addClass("loading_img");
			 
			  $.ajax({
				  type: "get",
				  cache: false,
				  url: "<?php echo site_url('/')?>my_admin/get_prize/"+id ,
				  success: function (data) {
					 x.removeClass("loading_img");
					 x.html(data);
					 $("#admin_content").removeClass("loading_img"); 

				  }
			  });	 					
	}
	function update_promo(id){
		
		$('#modal-promo-update').unbind('show').bind('show', function() {
			
			$('#promo_content').addClass("loading_img");
			$.ajax({
				  type: "get",
				  cache: false,
				  url: "<?php echo site_url('/')?>my_admin/update_promotion/"+id ,
				  success: function (data) {
					 
					$('#promo_content').html(data).removeClass("loading_img");
					 //window.setTimeout( load_ajax("scratch") , "2000");

				  }
			  });	
			
			
		}).modal({ backdrop: false });
			  					
	}

function update_promo_do(){
		
	
		var btn = $('#update_promo_btn'), frm = $('#promo_update');
		//frm.preventDefault();
		if($('#starttxt').val().length == 0){
			var x = $('#dpend');
			x.popover({  delay: { show: 100, hide: 3000 },
			 placement:"top",html: true,trigger: "manual",
			 title:"Duration Required", content:"Please give the promotion a valid duration."});
			x.popover('show');
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
				
		}else{
			
			btn.html('<img src="<?php echo base_url('/'). 'img/load.gif';?>"/> Processing...');
				$.ajax({
					type: 'post',
					cache: false,
					data:frm.serialize(),
					url: '<?php echo site_url('/').'win/update_promo/';?>' ,
					success: function (data) {
						$('#promo_msg').html(data);
						btn.html('Update Promo');
	
						
					}
				});	
				
		}			
	
}


	function load_prizes(id){
			  var x = $("#scratch_win_body");
			  x.empty().addClass("loading_img");
			  $.ajax({
				  type: "get",
				  cache: false,
				  url: "<?php echo site_url('/')?>my_admin/load_scratch_prizes/"+id ,
				  success: function (data) {
					 
					x.html(data).removeClass("loading_img");
					 //window.setTimeout( load_ajax("scratch") , "2000");
						  
				  }
			  });	 					
	}
	
	function load_promos(){
		var x = $("#scratch_promotions");
			  x.empty().addClass("loading_img");
			  $.ajax({
				  type: "get",
				  cache: false,
				  url: "<?php echo site_url('/')?>my_admin/load_scratch_promotions/" ,
				  success: function (data) {
					 
					 x.html(data).removeClass("loading_img");
					 
					 //window.setTimeout( load_ajax("scratch") , "2000");
						  
				  }
			  });	 					
	}
	function load_winners(id){
		var x = $("#scratch_win_body");
			  x.empty().addClass("loading_img");
			  $.ajax({
				  type: "get",
				  cache: false,
				  url: "<?php echo site_url('/')?>my_admin/load_scratch_winners/"+id ,
				  success: function (data) {
					 
					 x.html(data).removeClass("loading_img");
					 //window.setTimeout( load_ajax("scratch") , "2000");
					$(".tbl_scratch_winners").dataTable( {
						  "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
						  "sPaginationType": "bootstrap",
						  "iDisplayLength": 10,
						  "aLengthMenu": [[10, 100, 500, 1000, -1], [10, 100, 500, 1000, "All"]],
						  "oLanguage": {
							  "sLengthMenu": "_MENU_ records per page"
						  },
						  "aaSorting":[],
						  "bSortClasses": false
		
						} );	  
				  }
			  });	 					
	}
	function load_logs(id){
		var x = $("#scratch_win_body");
			  x.empty().addClass("loading_img");
			  $.ajax({
				  type: "get",
				  cache: false,
				  url: "<?php echo site_url('/')?>my_admin/load_scratch_logs/"+id ,
				  success: function (data) {
					 
					 x.html(data).removeClass("loading_img");
					 //window.setTimeout( load_ajax("scratch") , "2000");
						$(".tbl_scratch_logs").dataTable( {
						  "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
						  "sPaginationType": "bootstrap",
						  "iDisplayLength": 50,
						  "aLengthMenu": [[50, 100, 500, 1000, -1], [50, 100, 500, 1000, "All"]],
						  "oLanguage": {
							  "sLengthMenu": "_MENU_ records per page"
						  },
						  "aaSorting":[],
						  "bSortClasses": false
		
						} );	  
				  }
			  });	 					
	}
</script>