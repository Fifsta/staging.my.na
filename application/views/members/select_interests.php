<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Register - My Nmaibia&trade;">
    <meta name="author" content="My Namibia">
    <link rel="icon" href="<?php echo base_url('/');?>favicon.ico">

    <title>Select your Interests - My Namibia&trade;</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('/');?>bootstrap/css/bootstrap.min.css?v1" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="//getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
		
		.selected{position:absolute; margin:-40px 0 0 0;}
		.border_yes{border:5px solid #090; opacity:0.8}
		.thumbnail:hover{cursor:pointer}
		.nav-pills>li.active>a, .nav-pills>li.active>a:hover, .nav-pills>li.active>a:focus{background-color:#090; cursor:pointer}
		.limit-txt{white-space: nowrap; overflow: hidden;text-overflow: ellipsis }
		a{color:#666}
		a:hover, a:focus {color:#007184}

	</style>
  </head>
<body>

    <div class="container">
      	  <div class="row">
          		
                <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1 text-right">
                
               		 <a href="<?php echo site_url('/');?>nmh/register/" class="btn btn-default" style="margin-top:10px;"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
                    
                </div>
           </div>  
           <p>&nbsp;</p> 
          <div class="row">
          		
                <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">
                
                	<form class="form-horizontal" action="<?php echo site_url('/');?>nmh/update_interest/" id="member-interests">
                    	<input type="hidden" name="client_id" value="<?php echo $client_id;?>">
                        
                    	  <div class="row">
                          		<div class="col-lg-12">
                                	
                                    

                                </div>
                           </div>     
                           
						   <?php echo $this->nmh_model->get_publications($client_id);?>
                              
                          
                          
                          <div class="form-group">
                            <div class="col-sm-12 text-right">
                              <!--<a class="btn btn-lg" id="skip">Skip</a>-->
                              <button type="submit" id="butt" class="btn btn-default btn-lg">Save</button>
                            </div>
                            <div class="col-sm-8" id="result_msg">
                              
                            </div>
                          </div>
                      </form>
                
                </div>
          		
          </div>
    
    </div><!-- /.container -->

</body>



<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>bootstrap/js/bootstrap.min.js?v1"></script>
<!--<script src="<?php echo base_url('/'); ?>js/custom/fb.js"></script>-->

<script type="text/javascript">
	var publications = [];
    $(document).ready(function(){
		
		var str = $('#publications').val();
		var publications = new Array();
		// this will return an array with strings "1", "2", etc.
		publications = str.split(",");
		for (a in publications ) {
			publications[a] = parseInt(publications[a], 10); // Explicitly include base as per Álvaro's comment
		}
		var str2 = $('#categories').val();
		var categories = new Array();
		// this will return an array with strings "1", "2", etc.
		categories = str2.split(",");
		for (a in categories ) {
			categories[a] = parseInt(categories[a], 10); // Explicitly include base as per Álvaro's comment
		}
	
		$('#skip').on('click',function(e) {
			parent.location.reload();
		});

        $('#butt').on('click',function(e) {
            e.preventDefault();
			var btn = $(this);
			//console.log($('#publications').val());
			 var frm = $('#member-interests');
			//frm.submit();
			btn.html('Working...');
			$.ajax({
				type: 'post',
				url: '<?php echo site_url('/').'nmh/update_interests/';?>' ,
				data: frm.serialize(),
				dataType: 'json',
				success: function (data) {

					if(data['success']){
						
						btn.html('Continue');
						$('#result_msg').html(data['msg']);
						//parent.location.reload();
					}else{
						$('#result_msg').html(data['msg']);
						
						btn.html('Continue');
					}
				}
			});
			
        });

		$('.thumbnail').on('click', function(){
			
			var it = $(this);
			var pub_id = it.data('pub-id');
			var sel = it.data('selected');
			if(sel){

				it.removeClass('border_yes');
				it.siblings('span').addClass('hide');
				it.data('selected', false);
				var index = publications.indexOf(it.data('pub-id'));
				if (index > -1) {
					publications.splice(index, 1);
				}
			}else{
				
				it.addClass('border_yes');
				it.siblings('span').removeClass('hide');
				it.data('selected', true);
				publications.push(it.data('pub-id'));
				
			}
			$('#publications').val(publications.toString());
			//console.log(publications + ' ' +$('#publications').val());
				
		});
		
		$('.categories_select').on('click', function(e){
			
			e.preventDefault();
			var it = $(this);
			var sel = it.data('selected');
			if(sel){

				it.parent('li').removeClass('active');
				it.find('span').removeClass('glyphicon-plus-sign').addClass('glyphicon-minus-sign');
				it.data('selected', false);
				var index = categories.indexOf(it.data('id'));
				if (index > -1) {
					categories.splice(index, 1);
				}
				it.find('input').prop('checked', false);
			}else{
				
				it.parent('li').addClass('active');
				it.find('span').removeClass('glyphicon-minus-sign').addClass('glyphicon-plus-sign');
				it.data('selected', true);
				it.find('input').prop('checked', true);
				categories.push(it.data('id'));
				
			}
			$('#categories').val(categories.toString());
			console.log(categories + ' ' +$('#categories').val());
			
		});


    });


    </script>
</html>