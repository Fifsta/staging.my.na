 <?php
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++



  //BUILD OPEN GRAPH
  $header['og'] ='';
 $this->load->view('inc/header_print', $header);

 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag

 ?>
 
 <style type="text/css">
    #wrap, html, body,.table td, table th{background:#fff; border:none; height: 99%;}
	#prod_carousel .item {max-height:550px;overflow:hidden;}
	#prod_carousel .item img{width:100%; height:auto;}
	body,*{font-size:12px;}
    .container{

	    page-break-after: always; 
	    overlfow:hidden;
    }
	 .print_end{

		 page-break-after: auto;
	 }
 </style>
</head>

<body>

 <?php
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = '';
// $this->load->view('inc/navigation', $nav);
 ?>
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->

     <!-- Begin page content -->
       <div class="container" style="width:680px;">

		   <?php 
              /*
              SHOW Company Info
              */	        

		   if($bus_id == 0){

			?>
			   <table class="table" border="0" style="border:none">
				   <tr>
					   <td style="width:70%; border:none"><h1 class="na_script"><?php echo $Ptitle;?></h1></td>
					   <td style="width:30%; text-align:right; border:none"><img src="<?php echo base_url('/');?>images/my-na-logo-black.png" /></td>
				   </tr>
			   </table>
		   <?php
		   }elseif($bus_id != 0){
                    
            ?>


				 <?php
	                /*
	                SHOW Company Info
	                */
	                $this->print_model->show_company($bus_id, $property_agent);

	              ?>

            <?php }?>
            
 			<?php 
				/*
				LOOP EACH PROIDUCT
				*/	
				
				if($query->result()){
					foreach($query->result_array() as $row){
						$this->print_model->print_product($row['product_id'], $row['property_agent'], $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat);
					}
				}



			?>

	 </div>
     <!-- /container - end content -->
	 <div class="print_end"></div>

    <?php
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 //$this->load->view('inc/footer', $footer);
  //$this->output->enable_profiler(TRUE);

 ?>
</body>
</html>