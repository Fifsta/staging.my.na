 <?php 
 //+++++++++++++++++
 //My.Na Account Update
 //+++++++++++++++++
 //Roland Ihms
 //Get Account Details
$page_details = $this->admin_model->get_page($page_id);
$title = $page_details['heading'];
$slug = $page_details['slug'];
$body = $page_details['body'];
$heading = $page_details['heading'];
$metaD = $page_details['metaD'];
$metaT = $page_details['metaT'];

 ?>
 <script src="<?php echo base_url('/');?>js/jquery.filestyle.js" type="text/javascript"></script>
 <script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

 <h3>Page <small><?php echo $title; ?></small></h3>
      <div class="clearfix"></div>

<form id="page-update" name="page-update" method="post" action="<?php echo site_url('/');?>my_admin/update_page_do" class="form-horizontal">
 <fieldset>
    <legend>Update Page details</legend>

              <div class="control-group">
                <label class="control-label" for="title">Title</label>
                <div class="controls">
                        <input type="text" class="span4" id="title" name="title" placeholder="Page title" value="<?php if(isset($title)){echo $title;}?>">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="slug">Slug</label>
                <div class="controls">
                 	    <input type="text" class="span4" disabled="disabled" id="slug" name="slug" placeholder="Page URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">  
                </div>
              </div>
             
              
              
              <input type="hidden" name="page_id" value="<?php echo $page_id;?>">
              <div class="control-group">
              		<div class="controls">
               			<textarea id="redactor_content" name="content" style="display:block" class="span4"><?php echo $body;?></textarea>
               		</div>
               </div>
             
                   <div class="control-group">
                  	   <label class="control-label" for="metaT">Meta Title:</label>
                        <div class="controls">
                            <textarea name="metaT" style="display:block" class="span6"><?php if(isset($metaT)){echo $metaT;}?></textarea>
                   			<span class="help-block">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                         </div>
                   </div>
              
               
                
                 <div class="control-group">
                  		<label class="control-label" for="metaD">Meta Description</label>
                        <div class="controls">
              				 <textarea name="metaD" style="display:block" class="span6"><?php if(isset($metaD)){echo $metaD;}?></textarea>
                             <span class="help-block">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
               			</div>
                   </div>
              
              <div id="result_msg"></div>
              <button type="submit" class="btn-large btn pull-right" id="butt"><b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" ></button>
               
   </fieldset> 
 </form>
 <script type="text/javascript">


$('#butt').click(function(e) {
	
	
	e.preventDefault();
	//Validate
	if($('#title').val().length == 0){
			
		    $('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a full name, Name and Surname."});
			$('#title').popover('show');
			$('#title').focus();
	
	}else if($('#redactor_content').html().length == 0){
		
    	    $('#redactor_content').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Email Required", content:"Please supply us with a valid email address"});
			$('#redactor_content').popover('show');
			$('#redactor_content').focus();		
		
	}else{
		
		submit_form();
		
	}
});


function submit_form(){
		
		var frm = $('#page-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'my_admin/update_page_do';?>' ,
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#butt').html('<b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
				
			}
		});	

}

	
 $("input[type=file]").filestyle({ 
     image: "<?php echo base_url('/').'img/fake_file.jpg';?>",
     imageheight :100,
     imagewidth :150,
     width :110
 });
 


</script>