 <?php 
 //+++++++++++++++++
 //My.Na Account Update
 //+++++++++++++++++
 //Roland Ihms
 //Get Account Details

 ?>


 <h3>Page <small>Add new Page</small></h3>
      <div class="clearfix"></div>

<form id="page-update" name="page-update" method="post" action="<?php echo site_url('/');?>my_admin/add_page_do" class="form-horizontal">
 <fieldset>
    <legend>Add Page</legend>

              <div class="control-group">
                <label class="control-label" for="title">Title</label>
                <div class="controls">
                        <input type="text" class="span4" id="title" name="title" placeholder="Page title" value="">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="slug">Slug</label>
                <div class="controls">
                 	    <input type="text" class="span4" id="slug" name="slug" placeholder="Page URL Slug eg: /about-us" value="">  
                </div>
              </div>

              <div class="control-group">
              		<div class="controls">
                        <div class="span4" id="cont_msg"></div>
               			<textarea id="redactor_content" name="content" style="display:block" class="span4"></textarea>
               		</div>
               </div>
             
                   <div class="control-group">
                  	   <label class="control-label" for="metaT">Meta Title:</label>
                        <div class="controls">
                            <textarea name="metaT" style="display:block" class="span6"></textarea>
                   			<span class="help-block">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                         </div>
                   </div>
              
               
                
                 <div class="control-group">
                  		<label class="control-label" for="metaD">Meta Description:</label>
                        <div class="controls">
              				 <textarea name="metaD" style="display:block" class="span6"></textarea>
                             <span class="help-block">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
               			</div>
                   </div>
              
              <div id="result_msg"></div>
              <button type="submit" class="btn-large btn pull-right" id="butt"><b>Add Page</b></button>
               
   </fieldset> 
 </form>
 <script type="text/javascript">


$('#butt').click(function(e) {
	
	
	e.preventDefault();
	//Validate
	if($('#title').val().length == 0){
			
		    $('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a fpage title"});
			$('#title').popover('show');
			$('#title').focus();
	
	}else if($('#redactor_content').val() == 0){

    	    $('#cont_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
			$('#cont_msg').popover('show');
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
			url: '<?php echo site_url('/').'my_admin/add_page_do';?>' ,
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#butt').html('<b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
				
			}
		});	

}
 


</script>