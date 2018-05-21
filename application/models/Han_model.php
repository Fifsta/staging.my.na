<?php
class Han_model extends CI_Model{
	
 	function han_model(){
  		//parent::CI_model();
			
 	}


	//+++++++++++++++++++++++++++
	//GET OVERALL SCORE HAN EVALUATIONS
	//++++++++++++++++++++++++++
	public function get_overall_han_score($bus_id){
		
		 $db2 = $this->connect_tourism_db();
		 $query = $db2->query("SELECT * FROM `u_evaluation` WHERE BUSINESS_ID = '".$bus_id."'", FALSE);
		 if($query->result()){
			$count_score = FALSE; 
		 	$total1['score'] = 0;$total2['score'] = 0;$total3['score'] = 0;$total4['score'] = 0;$total5['score'] = 0;$total6['score'] = 0;
			$total1['cat_count'] = 0;$total2['cat_count'] = 0;$total3['cat_count'] = 0;$total4['cat_count'] = 0;$total5['cat_count'] = 0;$total6['cat_count'] = 0;
		 	$x = 0;
			foreach($query->result() as $row){
				 
				 
				 if($row->IS_ACTIVE == 'Y'){
					
					 $query2 = $db2->query("SELECT i_evaluation_question.* ,u_evaluation_question.NAME ,u_evaluation_question_category.QUESTION_CATEGORY_NAME, u_evaluation_question.QUESTION_TYPE_ID 
				 				FROM `i_evaluation_question` 
								JOIN u_evaluation_question ON i_evaluation_question.QUESTION_ID = u_evaluation_question.ID 
								JOIN u_evaluation_question_category ON u_evaluation_question.QUESTION_TYPE_ID = u_evaluation_question_category.ID
								WHERE EVALUATION_ID = '".$row->ID."'", FALSE);
					 $count_score = TRUE;			 
					 
				 }else{
					
					 $query2 = $db2->query("SELECT * FROM `u_evaluation` WHERE ID = 0", FALSE);
								 
					 
				 }
				 
				
				if($query2->result()){
					
					foreach($query2->result() as $row2){
						
								//Total per category
								if($row2->QUESTION_TYPE_ID == 1){
									$total1['score'] = $total1['score'] + $row2->ANSWER;
									$total1['type'] = $row2->QUESTION_CATEGORY_NAME;
									$total1['cat_count'] ++;  
								}elseif($row2->QUESTION_TYPE_ID == 2){
									$total2['score'] = $total2['score'] + $row2->ANSWER;
									$total2['type'] = $row2->QUESTION_CATEGORY_NAME; 
									$total2['cat_count'] ++;  
								}elseif($row2->QUESTION_TYPE_ID == 3){
									$total3['score'] = $total3['score'] + $row2->ANSWER;
									$total3['type'] = $row2->QUESTION_CATEGORY_NAME;  
									$total3['cat_count'] ++; 
								}elseif($row2->QUESTION_TYPE_ID == 4){
									$total4['score'] = $total4['score'] + $row2->ANSWER;
									$total4['type'] = $row2->QUESTION_CATEGORY_NAME;
									$total4['cat_count'] ++;   	
								}elseif($row2->QUESTION_TYPE_ID == 5){
									$total5['score'] = $total5['score'] + $row2->ANSWER;
									$total5['type'] = $row2->QUESTION_CATEGORY_NAME;
									$total5['cat_count'] ++;   
								}elseif($row2->QUESTION_TYPE_ID == 6){
									
									if($row2->QUESTION_ID == 19){
										$total6['score'] = $total6['score'] + $row2->ANSWER;
										$total6['type'] = $row2->QUESTION_CATEGORY_NAME; 
										$total6['cat_count'] ++; 
										
									}elseif($row2->QUESTION_ID == 18){
										
										
									}else{
										$total6['score'] = $total6['score'] + $row2->ANSWER;
										$total6['type'] = $row2->QUESTION_CATEGORY_NAME; 
										$total6['cat_count'] ++; 
										
									}
									 
								}
						
						$x ++;
					}
					
				}
				
			}
			
			if( $count_score === TRUE){
				
				//avoid division by 0 error
				
				
				$type1 = $total1['type'];$type2 = $total2['type'];$type3 = $total3['type'];$type4 = $total4['type'];$type5 = $total5['type'];$type6 = $total6['type'];
				$div1 = $total1['cat_count'];$div2 = $total2['cat_count'];$div3 = $total3['cat_count'];$div4 = $total4['cat_count'];$div5 = $total5['cat_count'];$div6 = $total6['cat_count']; 
				if($total1['cat_count'] == 0){ $div1 = 1; $type1 = '';}
				if($total2['cat_count'] == 0){ $div2 = 1; $type2 = '';}
				if($total3['cat_count'] == 0){ $div3 = 1; $type3 = '';}
				if($total4['cat_count'] == 0){ $div4 = 1; $type4 = '';}
				if($total5['cat_count'] == 0){ $div5 = 1; $type5 = '';}
				if($total6['cat_count'] == 0){ $div6 = 1; $type6 = '';}
				
				//Display Totals
				echo '<h5>Overall Scores</h5>
						  <div  class="well well-mini">
							  <table>
								<tr>
									<td>'.$type1.': </td>
									<td>'.$this->get_overall_han_score_per_eval(round ($total1['score'] / $div1)).'</td>
								</tr>
								<tr>
									<td>'.$type2.': </td>
									<td>'.$this->get_overall_han_score_per_eval(round($total2['score'] / $div2)).'</td>
								</tr>
								<tr>
									<td>'.$type3.': </td>
									<td>'.$this->get_overall_han_score_per_eval(round($total3['score'] / $div3)).'</td>
								</tr>
								<tr>
									<td>'.$type4.': </td>
									<td>'.$this->get_overall_han_score_per_eval( round( $total4['score'] / $div4)).'</td>
								</tr>
								<tr>
									<td>'.$type5.': </td>
									<td>'.$this->get_overall_han_score_per_eval(round($total5['score'] / $div5)).'</td>
								</tr>
								<tr>
									<td>'.$type6.': </td>
									<td>'.$this->get_overall_han_score_per_eval_percentage(round($total6['score'] / $div6)).'</td>
								</tr>
							</table>		
						</div>';	
	
			}else{
				
				echo '<div  class="well well-mini"><h5>No Evaluations Active</h5>
						Active evaluations are required to calculate a score.</div>';
					
			}
		 
		 }
		 
		 
		
								
								
								
	}
    //+++++++++++++++++++++++++++
	//GET ALL HAN EVALUATIONS
	//++++++++++++++++++++++++++
	public function han_evaluations($bus_id)
	{
		  $db2 = $this->connect_tourism_db();
		  //$query = $this->db->query("SELECT * FROM `u_evaluation` JOIN i_evaluation_question ON u_evaluation.ID = i_evaluation_question.EVALUATION_ID WHERE BUSINESS_ID = '".$bus_id."'", FALSE);
		  $query = $db2->query("SELECT * FROM `u_evaluation` WHERE BUSINESS_ID = '".$bus_id."'", FALSE);
		  
		  if($query->result()){
			echo '<a href="http://hannamibia.com/forum/?id='.$bus_id.'" target="_blank" class="btn pull-right"><i class="icon-list-alt"></i> HAN Form</a>
			<a href="http://hannamibia.com/evaluation.php?iid='.$bus_id.'" target="_blank" class="btn pull-right" style="margin-right:10px;"><i class="icon-bookmark"></i> Evaluation Link</a>
			<h3>HAN Evaluations <small>My Namibia</small></h3>';
			$this->get_overall_han_score($bus_id);
			
			echo '<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:30%">Rated By</th>
						<th style="width:10%">Active</th>
						<th style="width:20%">Date of Stay</th>
						<th style="width:20%">Review Date</th>
						<th style="width:20%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$user = $this->get_han_user($row->USER_ID);
				$active_str = "'Y'";
				$click = '';
				if($this->session->userdata('admin_id')){
					
					$click = 'onclick="set_eval_status('.$row->ID.','.$active_str.')"';
				}
				
				$active = '<a '.$click.' href="javascript:void(0)"><span class="label label-important">NO</span></a>';
				$btn = '<a class="btn btn-mini btn-success disabled"  href="javascript:void(0)"><i class="icon-ok icon-white"></i></a>';
				if($row->IS_ACTIVE == 'Y'){
					$active_str = "'N'";
					
					$click = '';
					if($this->session->userdata('admin_id')){
						
						$click = 'onclick="set_eval_status('.$row->ID.','.$active_str.')"';	
						
					}
					
					$active = '<a '.$click.' href="javascript:void(0)"><span class="label label-success">YES</span></a>';
					$btn = '<a class="btn btn-mini btn-danger disabled"  href="javascript:void(0)"><i class="icon-remove icon-white"></i></a>';
				}
	
				echo '<tr>
						<td style="width:30%">'.ucwords($user['NAME']).'</td>
						<td style="width:10%">'.$active.'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->DATE_OF_STAY)).'</td>
            			<td style="width:20%">'.date('Y-m-d h:i:s',strtotime($row->DATE_ENTERED)).'</td>
						<td style="width:20%;text-align:right"><a style="cursor:pointer" 
						href="javascript:void(0)" class="btn btn-mini" onclick="load_eval('.$row->ID.','.$row->USER_ID.','.$bus_id.')">
						<i class="icon-search"></i></a>
						'.$btn.'
						</td>
					  </tr>';
			}
			
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script data-cfasync="false" type="text/javascript">
					
					function set_eval_status(id, status){
	 
							  $.ajax({
								  type: "get",
								  cache: false,
								  url: "'.site_url('/').$this->uri->segment('1').'/set_eval_status/"+id+"/"+status+"/"+'.$bus_id.' ,
								  success: function (data) {
									 
									 $("#msg_admin").html(data);
									 load_tab("'.$bus_id.'", "han_evaluations");
										  
								  }
							  });	 					
					}
					function load_eval(id, user_id, bus_id){
	 
							  $.ajax({
								  type: "get",           
								  cache: false,
								  url: "'.site_url('/').'my_admin/load_han_evaluation/"+id+"/"+user_id+"/"+bus_id ,
								  success: function (data) {
									 
									 $("#han_evaluations").html(data);
									 //load_tab("'.$bus_id.'", "han_evaluations");
										  
								  }
							  });	 					
					}
				</script>';
			
		 }else{
			
			echo '<a href="http://hannamibia.com/forum/?id='.$bus_id.'" target="_blank" class="btn pull-right"><i class="icon-list-alt"></i> HAN Form</a>
				  <a href="http://hannamibia.com/evaluation.php?iid='.$bus_id.'" target="_blank" class="btn pull-right" style="margin-right:10px;"><i class="icon-bookmark"></i> Evaluation Link</a>
				    <div class="clearfix" style="height:40px;"></div>
					<div class="alert alert-block">
						<h3>No Evaluations made.</h3> Convince your guests to leave feedback by emailing them the link above
					</div>'; 
			 
		 }		
	}	
	
	public function get_han_user($id){
		
		$db2 = $this->connect_tourism_db();
		$db2->where('ID', $id);
		$query = $db2->get('u_evaluation_user');
		return $query->row_array();
	}
	
	public function get_han_eval_questions(){
		
		$db2 = $this->connect_tourism_db();
		$query =$db2->query("SELECT u_evaluation_question.* ,u_evaluation_question_category.QUESTION_CATEGORY_NAME FROM u_evaluation_question 
								JOIN u_evaluation_question_category ON u_evaluation_question.QUESTION_TYPE_ID = u_evaluation_question_category.ID 
								WHERE u_evaluation_question.IS_ACTIVE = 'Y' ORDER BY u_evaluation_question.ID ASC",FALSE);
		return $query;
	}
    //+++++++++++++++++++++++++++
	//GET SINGLE HAN EVALUATION
	//++++++++++++++++++++++++++	
	
	function load_han_evaluation($evaluation_id, $user_id, $bus_id){
			
		  $db2 = $this->connect_tourism_db();
		  $query = $db2->query("SELECT i_evaluation_question.* ,u_evaluation_question.NAME ,u_evaluation_question_category.QUESTION_CATEGORY_NAME FROM `i_evaluation_question` 
								JOIN u_evaluation_question ON i_evaluation_question.QUESTION_ID = u_evaluation_question.ID 
								JOIN u_evaluation_question_category ON u_evaluation_question.QUESTION_TYPE_ID = u_evaluation_question_category.ID
								WHERE EVALUATION_ID = '".$evaluation_id."'", FALSE);
		  
		  if($query->result()){
			 
			 //get user
			 $user = $this->get_han_user($user_id);

			 //GET TOTAL QUESTIONS 
			 $q = $this->get_han_eval_questions(); 
			 
			 echo'<h3>HAN Evaluation by  <small>'.$user['NAME'].' ' . $user['EMAIL'].'</small></h3>
				  <a href="javascript:void(0);" onclick="load_all('.$bus_id.')" class="btn pull-right"><i class="icon-chevron-left"></i> Back to all</a>
					<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
						<thead>
							<tr style="font-weight:bold">
								<th style="width:50%">Question</th>
								<th style="width:20%">Category</th>
								<th style="width:30%;text-align:right">Answer</th>
							</tr>
				   </thead>
				  <tbody>';
			 //5 categories, add each for totals
			 
			 $total1['score'] = 0;$total2['score'] = 0;$total3['score'] = 0;$total4['score'] = 0;$total5['score'] = 0;$total6['score'] = 0;
			 $total1['cat_count'] = 0;$total2['cat_count'] = 0;$total3['cat_count'] = 0;$total4['cat_count'] = 0;$total5['cat_count'] = 0;$total6['cat_count'] = 0;

			 //loop each question
			 foreach($q->result() as $row){
				 
					 $answ = $db2->query("SELECT i_evaluation_question.* ,u_evaluation_question.NAME, u_evaluation_question.QUESTION_TYPE_ID FROM `i_evaluation_question` 
										JOIN u_evaluation_question ON i_evaluation_question.QUESTION_ID = u_evaluation_question.ID 
										WHERE i_evaluation_question.EVALUATION_ID = '".$evaluation_id."' AND i_evaluation_question.QUESTION_ID = '".$row->ID."'", FALSE);
					//if Question is answered or in DB
					if($answ->result()){				

								$row2 = $answ->row();
								
								//Total per category
								if($row2->QUESTION_TYPE_ID == 1){
									$total1['score'] = $total1['score'] + $row2->ANSWER;
									$total1['type'] = $row->QUESTION_CATEGORY_NAME;
									$total1['cat_count'] ++;  
								}elseif($row2->QUESTION_TYPE_ID == 2){
									$total2['score'] = $total2['score'] + $row2->ANSWER;
									$total2['type'] = $row->QUESTION_CATEGORY_NAME; 
									$total2['cat_count'] ++;  
								}elseif($row2->QUESTION_TYPE_ID == 3){
									$total3['score'] = $total3['score'] + $row2->ANSWER;
									$total3['type'] = $row->QUESTION_CATEGORY_NAME;  
									$total3['cat_count'] ++; 
								}elseif($row2->QUESTION_TYPE_ID == 4){
									$total4['score'] = $total4['score'] + $row2->ANSWER;
									$total4['type'] = $row->QUESTION_CATEGORY_NAME;
									$total4['cat_count'] ++;   	
								}elseif($row2->QUESTION_TYPE_ID == 5){
									$total5['score'] = $total5['score'] + $row2->ANSWER;
									$total5['type'] = $row->QUESTION_CATEGORY_NAME;
									$total5['cat_count'] ++;   
								}elseif($row2->QUESTION_TYPE_ID == 6){
									$total6['score'] = $total6['score'] + $row2->ANSWER;
									$total6['type'] = $row->QUESTION_CATEGORY_NAME; 
									$total6['cat_count'] ++;  
								}
								
								
								if($row->NAME != 'Please Explain?'){
										
										//comments
										if($row2->QUESTION_ID == 18){
										
										
											echo '<tr>
														<td style="width:50%">'.$row->NAME.'</td>
														
														<td colspan="2" style="width:50%;text-align:right"><em>'.$row2->ANSWER.'</em></td>
												 </tr>';
										
										//Overall percentage
										}elseif($row2->QUESTION_ID == 19){	
											
											 if(is_numeric($row2->ANSWER)){ 
											   
												   if($row2->ANSWER > 80){
														$answer = '<span class="badge badge-success">'.$row2->ANSWER . '% Excellent</span>';
													}elseif($row2->ANSWER > 80){
														$answer = '<span class="badge badge-success">'.$row2->ANSWER . '% Very good</span>';
													}elseif($row2->ANSWER > 60){
														
														$answer = '<span class="badge badge-alert">'.$row2->ANSWER . '% Good</span>';	
													}elseif($row2->ANSWER > 40){
														$answer = '<span class="badge badge-warning">'.$row2->ANSWER . '% Satisfactory</span>';
													
													}elseif($row2->ANSWER < 20){
														$answer = '<span class="badge badge-important">'.$row2->ANSWER . '% Poor</span>';
														
													}else{
														
														$answer = '<span class="badge badge-important">Not Rated</span>';
													}
													
													echo '<tr>
															<td style="width:50%">'.$row->NAME.'</td>
															<td style="width:20%">'.$row->QUESTION_CATEGORY_NAME.'</td>
															<td style="width:30%;text-align:right">'.$answer.'</td>
															
														  </tr>';
											 }
										
										}elseif($row2->QUESTION_ID == 20){
											
												if($row2->ANSWER == 'Type your comments here'){
													
													$answer = 'No Comment Left';
												}else{
													
													$answer = $row2->ANSWER;
												}
												
												echo '<tr>
														<td style="width:50%">'.$row->NAME.'</td>
														
														<td colspan="2" style="width:50%;text-align:right"><em>'.$answer.'</em></td>
														
													  </tr>';							
										
										}else{
												
												if($row2->ANSWER > 4){
													$answer = '<span class="badge badge-success">'.$row2->ANSWER . ' Excellent</span>';
												}elseif($row2->ANSWER > 3){
													$answer = '<span class="badge badge-success">'.$row2->ANSWER . ' Very good</span>';
												}elseif($row2->ANSWER > 2){
													
													$answer = '<span class="badge badge-alert">'.$row2->ANSWER . ' Good</span>';	
												}elseif($row2->ANSWER > 1){
													$answer = '<span class="badge badge-warning">'.$row2->ANSWER . ' Satisfactory</span>';
												}else{
													
													$answer = '<span class="badge badge-important">'.$row2->ANSWER . ' Poor</span>';
												}
												
												echo '<tr>
														<td style="width:50%">'.$row->NAME.'</td>
														<td style="width:20%">'.$row->QUESTION_CATEGORY_NAME.'</td>
														<td style="width:30%;text-align:right">'.$answer.'</td>
														
													  </tr>';
									
		
										}
								}//not Please explain
					//ANSWER Not in DB						  
					}else{
							
							//Total per category
							//no answer add 0
							if($row->QUESTION_TYPE_ID == 1){
								$total1['score'] = $total1['score'] + 0;
								$total1['type'] = $row->QUESTION_CATEGORY_NAME;
								//$total1['cat_count'] ++;  
							}elseif($row->QUESTION_TYPE_ID == 2){
								$total2['score'] = $total2['score'] + 0; 
								$total2['type'] = $row->QUESTION_CATEGORY_NAME; 
								//$total2['cat_count'] ++;  
							}elseif($row->QUESTION_TYPE_ID == 3){
								$total3['score'] = $total3['score'] + 0; 
								$total3['type'] = $row->QUESTION_CATEGORY_NAME;
								//$total3['cat_count'] ++;   
							}elseif($row->QUESTION_TYPE_ID == 4){
								$total4['score'] = $total4['score'] + 0; 
								$total4['type'] = $row->QUESTION_CATEGORY_NAME;
								//$total4['cat_count'] ++;   	
							}elseif($row->QUESTION_TYPE_ID == 5){
								$total5['score'] = $total5['score'] + 0; 
								$total5['type'] = $row->QUESTION_CATEGORY_NAME;
								//$total5['cat_count'] ++;   
							}elseif($row->QUESTION_TYPE_ID == 6){
								$total6['score'] = $total6['score'] + 0;     
								$total6['type'] = $row->QUESTION_CATEGORY_NAME;
								//$total6['cat_count'] ++;   
							}
			
							if($row->NAME != 'Please Explain?'){
								
								/*	
								Other Questions
								echo '<tr>
										<td style="width:50%">'.$row2->ID.'-'.$row->NAME.'</td>
										<td style="width:20%">'.$row->QUESTION_CATEGORY_NAME.'</td>
										<td style="width:30%;text-align:right">N/A No answer given</td>
												
									 </tr>';*/
							}elseif($row->ID == 116){
								

								
							}
					
					}//end if answer found
				}//end foreach Question
	 
				  $data = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
				  	
				  echo '</tbody>
					  </table>
					  <hr />
					  <div class="clearfix" style="height:30px;"></div>
					  <h5>Overall Scores</h5>
					  <div  class="well well-mini">
						  <table>
							<tr>
								<td>'.$total1['type'].': </td>
								<td>'.$this->get_overall_han_score_per_eval(round($total1['score'] / $total1['cat_count'])).'</td>
							</tr>
							<tr>
								<td>'.$total2['type'].': </td>
								<td>'.$this->get_overall_han_score_per_eval(round($total2['score'] / $total2['cat_count'])).'</td>
							</tr>
							<tr>
								<td>'.$total3['type'].': </td>
								<td>'.$this->get_overall_han_score_per_eval(round($total3['score'] / $total3['cat_count'])).'</td>
							</tr>
							<tr>
								<td>'.$total4['type'].': </td>
								<td>'.$this->get_overall_han_score_per_eval(round($total4['score'] / $total4['cat_count'])).'</td>
							</tr>
							<tr>
								<td>'.$total5['type'].': </td>
								<td>'.$this->get_overall_han_score_per_eval(round($total5['score'] / $total5['cat_count'])).'</td>
							</tr>
					  	</table>		
				 	</div>	
						
					  <script data-cfasync="false" type="text/javascript">

						  function load_all(id){
		   
									$.ajax({
										type: "get",
										cache: false,
										url: "'.site_url('/').'my_admin/han_evaluations/"+id+"/" ,
										success: function (data) {
										   
										   $("#han_evaluations").html(data);
												$("#example").dataTable( {
												"sDom": "'.$data.'",
												"sPaginationType": "bootstrap",
												"oLanguage": {
													"sLengthMenu": "_MENU_"
												},
												"aaSorting":[],
												"bSortClasses": false
						
											} );
												
										}
									});	 					
						  }
					  </script>';
					
		 }

	}
	
	function get_overall_han_score_per_eval($score){
		
		  
		  if($score > 4){
			  $total = '<span class="badge badge-success">'.$score. ' Excellent</span>';
		  }elseif($score > 3){
			  $total = '<span class="badge badge-success">'.$score. ' Very good</span>';
		  }elseif($score > 2){
			  
			  $total = '<span class="badge badge-alert">'.$score. ' Satisfactory</span>';	
		  }elseif($score > 1){
			  $total = '<span class="badge badge-warning">'.$score. ' Bad</span>';
		  }else{
			  
			 $total = '<span class="badge badge-important">'.$score . ' Terrible</span>';
		  }
		 return $total;
	}
	
	function get_overall_han_score_per_eval_percentage($score){
		
		  
		  if($score > 80){
			  $total = '<span class="badge badge-success">'.$score. '%  Excellent</span>';
		  }elseif($score > 60){
			  $total = '<span class="badge badge-success">'.$score. '%  Very good</span>';
		  }elseif($score > 40){
			  
			  $total = '<span class="badge badge-alert">'.$score. '%  Satisfactory</span>';	
		  }elseif($score > 20){
			  $total = '<span class="badge badge-warning">'.$score. '%  Bad</span>';
		  }else{
			  
			 $total = '<span class="badge badge-important">'.$score . '% Terrible</span>';
		  }
		 return $total;
	}   
	
	 //+++++++++++++++++++++++++++
	//UPDATE HAN EVALUATION STATUS
	//++++++++++++++++++++++++++	
	function set_eval_status($id, $status)
	{	
		$db2 = $this->connect_tourism_db();
		$data['IS_ACTIVE'] = $status;
		$db2->where('ID', $id);
		$db2->update('u_evaluation', $data);
		echo '<div class="alert alert-success">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			Evaluation has been updated</div>';

	}

	
	//connect to tourism db
	function connect_tourism_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'hannamib_devuser';
		$config_db['password'] = 'UI5TrephoWC0';
		$config_db['database'] = 'hannamib_mynatour_devdb';
		
		//$config_db['username'] = 'root';
	    //$config_db['password'] = '';
		//$config_db['database'] = 'my_na';
		
		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = TRUE;
		$config_db['db_debug'] = TRUE;
		$config_db['cache_on'] = FALSE;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = TRUE;
		$config_db['stricton'] = FALSE;
		$maindb = $this->load->database($config_db, TRUE);
		$this->db->close();
		return $maindb;
	}	


}
?>