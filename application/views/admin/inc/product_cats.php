<?php 

$this->admin_model->load_product_categories(0, 0, 0, 0);
		 
?>		 
<script type="text/javascript">

function load_ajax_product_cat(cat1, cat2, cat3 , cat4){
		
		var n = $('#admin_content');
		n.fadeOut();
		var loading = $('#loading_img');
		loading.addClass('loading_img');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'my_admin/load_product_categories/';?>'+cat1+'/'+cat2+'/'+cat3+'/'+cat4 ,
			success: function (data) {	
				
				n.html(data).delay('300').fadeIn('300');
				$('#example').dataTable( {
					  	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
						"sPaginationType": "bootstrap",
						"oLanguage": {
							"sLengthMenu": "_MENU_ records per page"
						},
						"aaSorting":[],
						"bSortClasses": false

					} );
				loading.removeClass('loading_img');
			}
		});	

}

function add_product_category(cat1, cat2, cat3, cat4){
	
	$('#modal-cat-add-main').bind('show', function() {
		    
			var removeBtn = $(this).find('.btn-primary');
			
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();
				var name = $('#main_cat_name').val();
	
				$.ajax({
				  type: "post",
				  data: {main_cat_name: name, cat1: cat1, cat2: cat2, cat3: cat3, cat4: cat4  },
				  url: "<?php echo site_url('/');?>my_admin/add_product_category/"+cat1+"/"+cat2+"/"+cat3+"/"+cat4,
				  success: function(data) {
					
					$("#msg_admin").html(data);
					$('#modal-cat-add-main').modal('hide');
				  }
				});
				
			});
	}).modal({ backdrop: true });

	
}

//MAIN CAT
function update_product_cat(id, cat1, cat2, cat3, cat4){
	
	$('#modal-update-cat').bind('show', function() {
		
		   var removeBtn = $(this).find('.btn-primary');
		   removeBtn.attr('onClick', 'update_product_cat_do()');
				$.ajax({
				  type: "get",
				  cache:false,
				  url: "<?php echo site_url('/');?>my_admin/update_product_category/"+id+"/"+cat1+"/"+cat2+"/"+cat3+"/"+cat4,
				  success: function(data) {
					
					$('#update_cat_content').html(data);
					
				  }
				});
				
		
	}).modal({ backdrop: true });
	
}
//MAIN CAT
function update_product_cat_do(){
	
			var frm = $('#main-cat-update');
	
			$.ajax({
			  type: "post",
			  data: frm.serialize(),
			  cache:false,
			  url: "<?php echo site_url('/');?>my_admin/update_product_cat_do",
			  success: function(data) {
				
				$("#msg_admin").html(data);
				$('#modal-update-cat').modal('hide');
				
			  }
			});
		
	
}



function delete_product_category(cat_id, cat1, cat2, cat3, cat4){
	  
	$('#modal-cat-delete').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');
				
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();	
				$.ajax({
				  url: "<?php echo site_url('/');?>my_admin/delete_product_category/"+cat_id+"/"+cat1+"/"+cat2+"/"+cat3+"/"+cat4,
				  success: function(data) {
					
					$("#msg_admin").html(data);
					$('#modal-cat-delete').modal('hide');
				  }
				});
				
			});
	}).modal({ backdrop: true });
}


function back_(cat1, cat2, cat3, cat4){
	
	if(cat4 > 0){
		
		load_ajax_product_cat(cat1, cat2, cat3,0);
		
	}else if(cat3 > 0){
		
		load_ajax_product_cat(cat1, cat2,0, 0);
		
	}else if(cat2 > 0){
		
		load_ajax_product_cat(cat1, 0, 0, 0);
		
	}else if(cat1 > 0){
	
		load_ajax_product_cat(0,0, 0, 0);
	}else{
		
		load_ajax_product_cat(0,0, 0, 0);
	}
	
}
</script>