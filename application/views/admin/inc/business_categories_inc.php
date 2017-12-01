 <?php 
 //+++++++++++++++++
 //My.Na Business map
 //+++++++++++++++++
 //Roland Ihms
 //Get Map Details
$cat_details = $this->admin_model->get_main_categories_edit();
$current_cats = $this->admin_model->get_current_categories($ID);


 ?>
<h2>Business Categories</h2>
<legend>Current Categories</legend>
<div id="sel_cats">
	<?php 
    foreach($current_cats->result() as $row1){
        
        $cat_id_cur = $row1->CATEGORY_ID;
        echo '<a href="'. site_url('/').'members/delete_category/'.$cat_id_cur.'/'.$ID.'/" onclick="delete_cat('.$cat_id_cur.','.$ID.')" style="margin-bottom:5px;" class="btn del_cat" rel="tooltip" title="Remove '.$this->admin_model->get_category_name($cat_id_cur).' category" >'.$this->admin_model->get_category_name($cat_id_cur).' <i class="icon-remove"></i></a> ';
            
    }
    ?>
</div>
<br /><br />
<div style="height:320px">
<legend>Add Categories</legend>

    <select onchange="load_sub_cats(this.value)" style="height:300px;float:left" class="span4" multiple="multiple">
    <?php 
    foreach($cat_details->result() as $row){
        
        $cat_id = $row->ID;
        $cat_name = $row->CATEGORY_NAME;
        $cat_descr = $row->CATEGORY_DESCRIPTION;
        echo '<option onclick="load_sub_cats(this.value)" value="'. $cat_id .'">'.$cat_name.'</option>';
            
    }
    ?>
    </select>
    <div id="sub_category" style="height:300px"></div>
    <hr />
    <a id="add_cat" class="btn pull-right disabled"><i class="icon-plus"></i> Add category</a>


</div>
<div class="clearfix" style="height:140px;"></div>

<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//DELETE LEARNING STORY MODAL
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 
<div class="modal hide fade" id="modal-cat-delete">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete Category</h3>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to remove the selected category?</p>
  </div>
  <div class="modal-footer">
    <a href="#" onclick="$('#modal-cat-delete').modal('hide')" class="btn">Cancel</a>
    <a href="#" class="btn btn-primary">Remove</a>
  </div>
</div>
<script type="text/javascript">
<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//LOAD CATEGORIES
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 
function load_sub_cats(id){
	
	$("#sub_category").html('<div class="span3" style="text-align:center;margin-top:125px;"><img src="<?php echo base_url('/').'img/load.gif';?>" /><br /> Getting Categories...</div>');
		
		$.ajax({
		  url: "<?php echo site_url('/');?>members/get_sub_categories/"+id+"/",
		  success: function(data) {
			$("#sub_category").html(data);
			$("#add_cat").addClass('disabled');
		  }
		});
	
}
<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//CLICK SUBCATEGORY PREPARE ACTIONS
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 
function add_sub_cats(id){
	
	var adbtn = $("#add_cat");
	adbtn.removeClass('disabled');
	adbtn.attr('onclick','add_cat('+id+')');
	
	
}

<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//ADD CATEGORY
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 

$('.del_cat').live('click',function(e){
	
	e.preventDefault();	

}); 
 
function add_cat(id){
	
	$("#sel_cats").html('<div class="span6" style="text-align:center;margin-top:15px;"><img src="<?php echo base_url('/').'img/load.gif';?>" /><br /> Getting Categories...</div>');
	$.ajax({
		  url: "<?php echo site_url('/');?>members/add_category/"+id+"/<?php echo $ID;?>/",
		  success: function(data) {
			$("#sel_cats").html(data);
			$("#add_cat").addClass('disabled');
		  }
		});
	
	
}
<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//DELETE CATEGORY
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 

function delete_cat(id, bus_id){
	  
	$('#modal-cat-delete').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary'),
			href = removeBtn.attr('href');
			removeBtn.attr('href','<?php echo site_url('/');?>members/delete_category/'+id+'/'+bus_id);
				
			removeBtn.click(function(e) { 
				e.preventDefault();	
				$.ajax({
				  url: "<?php echo site_url('/');?>members/delete_category/"+id+"/<?php echo $ID;?>/ajax/",
				  success: function(data) {
					$("#sel_cats").html(data);
					$("#add_cat").addClass('disabled');
					$('#modal-cat-delete').modal('hide');
				  }
				});
				
			});
	}).modal({ backdrop: true });
}
</script>