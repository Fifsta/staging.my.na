<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" /> 
<div id="add_prize_cont" style="display<?php if (isset($ID)){echo ':block;';}else{ echo ':none;';}?>">
    
    <div class="row-fluid">
    	<?php if (isset($ID)){echo '<h4 >Update Prize <small>Update the prize</small></h4>';}else{ echo '<h4 >Add New Prize <small>Submit new prize for review</small></h4>';}?>
       <a href="javascript:void(0)" onclick="load_ajax('scratch')" class="btn pull-right"> Back</a>
     
    	<div class="clearfix" style="height:10px;"></div>
    </div>
    
    <div class="row-fluid">
    	
    	<div class="span8">

            <form id="prize-add" name="prize-add" method="post" action="<?php echo site_url('/');?>win/add_prize" class="form-horizontal">
                             <fieldset>
                             		      <input type="hidden" name="prize_id" id="prize_id" value="<?php if (isset($ID)){echo $ID;}else{ echo '0';}?>" />
    									  <!--<input type="hidden" name="bus_id_prize" id="bus_id_prize" value="<?php //echo $bus_id;?>" />-->
                                          <div class="control-group">
                                            <label class="control-label" for="title">Prize</label>
                                            <div class="controls">
                                                    <input type="text" class="span12" id="prize_title" name="prize_title" placeholder="Prize title" value="<?php if (isset($NAME)){echo $NAME;}?>">
                                                    <span class="help-block" style="font-size:11px">A few words about your amazing prize. eg: Buy 1 get 1 FREE</span>
                                            </div>
                                          </div>
                             			  
                              			 
                                         <div class="control-group">
                                            <label class="control-label" for="prize_quantity">Quantity</label>
                                            <div class="controls">          
                                                <input type="text" class="span6" id="prize_quantity" name="prize_quantity" placeholder="0" value="<?php if (isset($QUANTITY)){echo $QUANTITY;}?>">
                                                <span class="help-block" style="font-size:11px">How many prizes/promotions are available. Must be set</span>
                   
                                            </div>
                                          </div>
                                          

                                   
                                          <div class="control-group">
                                                <label class="control-label" for="prize_content">Prize Collection Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="prize_content" name="prize_content" style="display:block"><?php if (isset($DESCRIPTION)){echo $DESCRIPTION;}?></textarea> 
                                                    <span class="help-block"  style="font-size:11px">
                                                    Please tell the winner how to collect his prize. This will be emailed to the winner. 
                                                    Terms and conditions should be mentioned if there are</span>
                                                </div>
                                           </div>
										   <div id="prize_msg"></div>
                                           <?php 
											if(isset($ID) && $IS_ACTIVE == '1'){
												
												
												echo '<a onclick="submit_prize('.$ID.')" class="btn btn-inverse pull-right" style="margin-left:10px;display:block" id="btn_submit_prize">
												  <i class="icon-play icon-white"></i> Publish Prize</a>';
													
												
											}else{
												
												echo '<a class="btn btn-inverse pull-right" style="margin-left:10px;display:none" id="btn_submit_prize">
												  <i class="icon-play icon-white"></i> Publish Prize</a>';
												
											}
											?>
                                           
                                           
                                            
                                          <button type="submit" class="btn btn-inverse pull-right" id="add_prize_btn"><?php if (isset($ID)){echo 'Update Prize';}else{ echo 'Add Prize';}?></button>
                                           
                               </fieldset> 
                             </form>
        </div>
        <div class="span4">
            <?php 
			    if(isset($ID)){
					if ($IMAGE_URL == 'NULL'){
					
						echo '<div id="prize_img"></div><a onclick="add_prize_image()" class="btn btn-block" style="display:none" id="btn_add_prize_img"><i class="icon-picture"></i> Add Prize Graphic</a>
							  ';
						
					}else{ 
					
						if($PROMOTION_ID == 2){
							echo '<div id="prize_img"><img src="'.S3_URL.'scratch_card/expo2013/prizes/raw/'.str_replace('_win','',$IMAGE_URL).'" /></div><br />
							<a onclick="add_prize_image()" class="btn btn-block clearfix" style="display:block;" id="btn_add_prize_img"><i class="icon-picture"></i> Update Prize Graphic</a>
							  ';
						
						}elseif($PROMOTION_ID == 3){
							//RESERVED
							
							echo '<div id="prize_img"><img src="'.S3_URL.'scratch_card/expo2013/prizes/raw/'.str_replace('_win','',$IMAGE_URL).'" /></div><br />
							<a onclick="add_prize_image()" class="btn btn-block clearfix" style="display:block;" id="btn_add_prize_img"><i class="icon-picture"></i> Update Prize Graphic</a>
							  ';
						}else{
							
							echo '<div id="prize_img"><img src="'.S3_URL.'scratch_card/images/prizes/raw/'.str_replace('_win','',$IMAGE_URL).'" /></div><br />
							<a onclick="add_prize_image()" class="btn btn-block clearfix" style="display:block;" id="btn_add_prize_img"><i class="icon-picture"></i> Update Prize Graphic</a>
							  ';
						}
						
						
					}
				}else{
					
					echo '<div id="prize_img"></div><a onclick="add_prize_image()" class="btn btn-block" style="display:none" id="btn_add_prize_img"><i class="icon-picture"></i> Add Prize Graphic</a>
						  ';
					
				}
				?>
           
        </div>
        
     </div>

	<div class="row-fluid">
    
    	<div class="span12">
        
         
        </div>
    
    
    </div>



</div>




<div id="modal-prize-delete" class="modal hide fade">

    <div class="modal-header">
      <a href="#" onclick="javascript:$('#modal-prize-delete').modal('hide')" class="close">&times;</a>
      <h3>Delete the Prize</h3>
    </div>
     <div class="modal-body">
       <p>Are you sure you want to completely remove the current prize and all of its resources?</p>
        
    </div>

    <div class="modal-footer">
      <a href="#" class="btn btn-primary">Delete</a> 
      <a href="#" onclick="javascript:$('#modal-prize-delete').modal('hide')" class="btn btn-secondary">No</a>
    </div>
 
</div>


<form action="<?php echo site_url('/')?>win/add_prize_img" method="post" accept-charset="utf-8" id="add-gallery" enctype="multipart/form-data" name="add-gallery" > 
<div id="modal-prize-img" class="modal hide fade">

    <div class="modal-header">
      <a href="#" onclick="javascript:$('#modal-prize-img').modal('hide')" class="close">&times;</a>
      <h3>Add a Prize Graphic</h3>
    </div>
    <div class="modal-body">
     <p>Please select the images you want to accompany the Prize</p>
	 
 		<div class="control-group">
      		<div class="controls">
           <input type="hidden" id="prize_id_prize_img"  name="prize_id_prize_img" value="<?php if (isset($ID)){echo $ID;}else{echo '0';}?>" />
    	   <!--<input type="hidden" id="bus_id_prize_img" name="bus_id_prize_img" value="<?php //echo $bus_id;?>" />-->
           <input type="file" class="btn btn-link" name="userfile" >
           <span class="help-inline">Select Graphic</span>
           <span class="help-block"  style="font-size:11px">
             Image dimensions required 173px wide by 338px in height</span>
           <div id="result_prize_img"></div>
             <div class="progress progress-striped active" id="gal-cover" style="display:none">
                <div class="bar" style="width: 0%;"></div>
            </div>
        </div>
         
      </div>
	  
      
    </div>
    <div class="modal-footer">
      <input type="submit" id="add_img_modal_btn" class="btn btn-primary" value="Add Graphic">  
      <a href="#" onclick="javascript:$('#modal-prize-img').modal('hide')" class="btn secondary">No</a>
    </div>
 
</div>
</form> 

<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
<script type="text/javascript">

$(document).ready(function(){
	$('#prize_content').redactor({ 	
				
	buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
	'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
	'video', 'table','|',
	 'alignment', '|', 'horizontalrule']
	});


});


function toggle_prize_add(){
	
	var x = $('#add_prize_cont');
	x.slideToggle();
	$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
		
	
}



$('#add_prize_btn').click(function(e){ 
		
		e.preventDefault();
		if($('#prize_title').val().length == 0){
			var x = $('#prize_title');
			x.popover({  delay: { show: 100, hide: 3000 },
			 placement:"top",html: true,trigger: "manual",
			 title:"Price Title required", content:"Please give the prize a valid and enticing subject line."});
			x.popover('show');
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
				
		}else{
			var frm = $('#prize-add');
			$('#add_prize_btn').html('<img src="<?php echo base_url('/'). 'img/load.gif';?>"/> Processing...');
			$.ajax({
				type: 'post',
				cache: false,
				data:frm.serialize(),
				url: '<?php echo site_url('/').'win/add_prize/';?>' ,
				success: function (data) {
					$('#prize_msg').html(data);
					$('#add_prize_btn').html('Update Deal');

					
				}
		});	
				
		}			
	
});


function add_prize_image(){
	
	
	$('#modal-prize-img').unbind('show').bind('show', function() {
			var removeBtn = $('#add_img_modal_btn'),
			frm = $('#add-gallery'),probar = $('#gal-cover .bar'),procover = $('#gal-cover');

			removeBtn.click(function() {
				procover.show();
				frm.ajaxForm({
                        beforeSend: function() {
                            var percentVal = '0%';
                            probar.width(percentVal)
                           
                        },
                        uploadProgress: function(event, position, total, percentComplete) {
                            var percentVal = percentComplete + '%';
                            probar.width(percentVal)
                            
                        },
                        complete: function(xhr) {
							procover.hide();
							$('#result_prize_img').html(xhr.responseText)
							probar.width('0%');
							$('#modal-prize-img').modal('hide');
                        }
                    });
	
		});
	}).modal({ backdrop: false });
}

//Show gallery after upload success
function show_prize_img(prize_id){
		 
		 var cont = $('#prize_img'),submit_btn = $('#btn_submit_prize');
		 cont.empty();
		 cont.addClass('loading_img');
		 $.get('<?php echo site_url('/')?>win/show_prize_img/'+prize_id, { cache: false } ,  function(data) {
			 cont.removeClass('loading_img');
			 cont.html(data);
			 $("#btn_add_prize_img").popover('destroy');	
			 
			 
			  submit_btn.attr('onclick','submit_prize('+prize_id+')');
			  submit_btn.fadeIn();
			
			  submit_btn.popover({  delay: { show: 100, hide: 3000 },
				 placement:"top",html: true,trigger: "manual",
				 title:"Publish your Deal", content:"Submit the prize for approval. My Namibia will approve the prize within 24 hours"});
			  submit_btn.popover('show');
				$('html, body').animate({
					 scrollTop: (submit_btn.offset().top - 200)
				 }, 300);
		});
		
}


function delete_prize(id){
	
	
	$('#modal-prize-delete').appendTo("body").bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary'),
			href = removeBtn.attr('href');
			var frm = $('#add-gallery');
			var probar = $('#gal-cover .bar');
			var procover = $('#gal-cover');

			removeBtn.click(function(e) { 
					
				e.preventDefault();

						
						$.ajax({
							type: 'post',
							url: '<?php echo site_url('/').'win/delete_prize/';?>' ,
							data: {prize_id: id},
							success: function (data) {
								 
								 $('#modal-prize-delete').modal('hide');
								 $('#prize_img').html(data);
								 
							}
						});
			});
	}).modal({ backdrop: true });
}


function update_prize(id){
	
	var cont = $('#prizes');
	cont.empty();
	cont.addClass('loading_img'); 
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'win/update_prize/';?>'+id ,
			success: function (data) {
					cont.removeClass('loading_img'); 
				    cont.html(data);
					
			}
		});	 
	
}

function submit_prize(id){
	
	var cont = $('#prizes');
	cont.empty();
	cont.addClass('loading_img'); 
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'win/publish_prize/';?>'+id ,
			success: function (data) {
					cont.removeClass('loading_img'); 
				    cont.html(data);
					
					
			}
		});	 
	
}



</script>