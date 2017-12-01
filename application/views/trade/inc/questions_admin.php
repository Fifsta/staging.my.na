<?php 
//LOOP QUESTIONS

if($q->result()){
	
	echo '<h3>Questions Asked?</h3>
		  <p>Please view all the questions regarding the item below and answer accordingly</p>';
	foreach($q->result() as $row){
		
		
			$client_id = $row->client_id;
			$bus_id1 = $row->bus_id;
			$question = $row->question;
			$q_date = $row->datetime;
			
			$user = $this->trade_model->get_user_avatar($row->asking_client_id);
			$reply = $row->answer;
			echo '<div class="well well-mini">';
				if($row->answer == ''){
					
					$answer = '
						<div id="answer_'.$row->question_id.'" style="width:100%; min-height:100px;">
							<form id="answer_frm_'.$row->question_id.'" action="'. site_url('/').'trade/answer/" method="post" accept-charset="utf-8" id="contact-us" name="contact-us">
								<input type="hidden" name="question_id" value="'.$row->question_id.'"/>
								<input type="hidden" name="product_id" value="'.$row->product_id.'"/>
								<input type="hidden" name="client_id" value="'.$row->client_id.'"/>
								<input type="hidden" name="asking_client_id" value="'.$row->asking_client_id.'"/>
								<input type="hidden" name="product_title" value="'.$row->title.'"/>
								<input type="hidden" name="question" value="'.$row->question.'"/>
								   <div class="control-group">
									<label class="control-label" for="answer">Answer:</label>
									<div class="controls">
									  <textarea rows="3"  class="redactor" name="answer"></textarea>
									</div>
								  </div>
								 
							</form>
							<a class="btn btn-inverse pull-right" id="answer_btn_'.$row->question_id.'" onclick="reply_question('.$row->question_id.')" >Answer Question</a>
						</div>	
								';
						
				}else{
					
					$answer = '<div id="answer_'.$row->question_id.'"><div class="alert alert-success"><strong>A:</strong>'.strip_tags($row->answer).'</div></div>';
					
				}
				
				echo '<div class="media">
					  <div>
					  <a class="pull-left" href="#" title="Reviewed on '.date('F j, Y',strtotime($q_date)).'" rel="tooltip">
						<span class="avatar-overlay60"></span>
						<img class="media-object" style="border:1px solid #333333;width:60px; margin-right:10px; height:60px" src="'.$user['image'].'">
					  </a>
					  
					  <div class="media-body">
					  <span><strong>Q:</strong>'.strip_tags($question) .'</span>
					   <font style="font-size:10px;"><span itemprop="reviewer">'.$user['name'].'</span></font>	
						
					  '.$answer.'
					  <time itemprop="dtreviewed" style="display:none;font-size:10px;font-style:italic" datetime="'.date('m-d-Y',strtotime($q_date)).'">'
					  .date('F j, Y',strtotime($q_date)).'</time>
					  
					  </div>
					  </div>
				  </div>';	
		
		echo '</div>';
	}
	
echo '<div class="clearfix" style="height:100px;"></div?>';		
	
}

	

?>
<script data-cfasync="false" type="text/javascript">
$(document).ready(function(){
	$('[rel=tooltip]').tooltip();
	$('.redactor').redactor({ 	
				
				buttons: ['formatting', '|', 'bold', 'italic', 'deleted', '|', 
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				 'alignment', '|', 'horizontalrule']
	});


});


function reply_question(id){
	
	var cont = $('#answer_'+id), frm = $('#answer_frm_'+id), btn = $('#answer_btn_'+id);
	cont.delay(3000).fadeOut();
	btn.html('Answering...');
	cont.addClass('loading_img');	
	$.ajax({
			type: 'post',
			cache: false,
			url: '<?php echo site_url('/').'trade/answer/';?>' ,
			data: frm.serialize(),
			success: function (data) {	
				
				cont.html(data);
				cont.fadeIn().removeClass('loading_img');
			}
		});		
	
}

</script>