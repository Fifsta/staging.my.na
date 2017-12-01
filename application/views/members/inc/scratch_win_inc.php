<script type="text/javascript" src="<?php echo S3_URL;?>scratch_card/js/jquery.idle-timer.js"></script>

<script type="text/javascript" src="<?php echo S3_URL;?>scratch_card/js/main.js"></script>
<script type="text/javascript" src="<?php echo S3_URL;?>scratch_card/js/scratcher.js"></script>

<script type="text/javascript">
  var BASE_PATH = '<?php echo S3_URL;?>scratch_card';
  var USER_LOG_ID = '';
  
  function getBasePath() {
	  return BASE_PATH;
  }
  var BACKGROUND_IMAGE = '<?php echo S3_URL .'scratch_card/images/prizes/'. $img_file;?>';
 //console.log(BACKGROUND_IMAGE);
</script>
        
<script type="text/javascript">
$(document).ready(function() {
	var timeout = 2 * 60 * 1000;

	$(document).bind("idle.idleTimer", function(){
		//console.log("user idle");
		window.location.href = '<?php echo site_url('/');?>members/logout/';
	});
	
	$(document).bind("active.idleTimer", function(){
		// console.log("user active");
	});
	
	$.idleTimer(timeout);
});

   		 

/**
 * Scratchcard overview logic
 */
$(function() {
    
    var updateUser = false;
    var intervalID = -1;
    var timeLastOpened = 0;
	var timeLastScratched = 0;
    function handleInterval()
    {
        timeLastScratched++;
        timeLastOpened++;
        
        if(timeLastScratched >= 300) {
            askDoneScratching();
            timeLastScratched = 0;
        }
    };
    
    var isDonePopupVisible = false;
    function askDoneScratching()
    {
        if(isDonePopupVisible) { return; }
        if(timeLastOpened < 10) { return; }
        
        timeLastOpened = 0;
        isDonePopupVisible = true;
        
		//MODAL
		
        <?php 
		//ONLY SHOW WINNING MODAL IF WON
		if($bool == TRUE){ 
			
			$img_prize = str_replace('_win','',$img_file);
			
			
		?>
			
			
			$('#modal-win').bind('show', function() {
				
				$('#win_msg_head').html('Congratulations!');
				$('#win_msg').html('<img src="<?php echo S3_URL.'scratch_card/images/prizes/'.$img_prize;?>" class="img-polaroid pull-left" style="width:60px;margin-right:20px;" />You have won. Click on the button below to claim your prize. <br />We will send you confirmation and instructions on how to get hold of it via email.');
				removeBtn = $(this).find('.btn');
					
				removeBtn.unbind('click').click(function(e) { 
					e.preventDefault();	
					removeBtn.html('Processing..Please wait.');
					$('#win_msg').addClass('loading');
					$.ajax({
						  type: "post",
						  cache: false,
						  data: { prize_id: '<?php echo $prize_id;?>', 
						  		  promo_id:'<?php echo $promo_id;?>',
								  coupon:'<?php echo $coupon;?>',
								  prize_img:'<?php echo S3_URL.'scratch_card/images/prizes/'.$img_prize;?>'
								  }, 
						  url: "<?php echo site_url('/');?>win/claim_scratch_win/",
						  success: function(data) {
							
							$('#scratch_content').html(data);
							 
							
						  }
					});
					
				});
			}).modal({ backdrop: true });
			
		<?php
		//NO WIN
		}else{
		?>
			
			$('#modal-win').bind('show', function() {
				
				//IF started scratching
				if($('#scratchPct').val() > 40){
					
					$('#win_msg_head').html('Sorry!');
					$('#win_msg').html('Sorry, better luck next time');
					removeBtn = $(this).find('.btn');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						
						window.location = '<?php echo site_url('/');?>win/scratch_and_win';
						
					});
				
				}else{
					
					$('#win_msg_head').html('Hello?');
					$('#win_msg').html('Are you still there? Please finish scratching or you will be logged out!');
					removeBtn = $(this).find('.btn');
						
					removeBtn.unbind('click').click(function(e) { 
					e.preventDefault();	
						
						$('#modal-win').modal('hide');
						
					});
					
				}
				
				
			}).modal({ backdrop: true });
			
		<?php 
		}
		?>

		
		//OLD SKOOl
		//var d = confirm("Do you want to claim your prize?");
//        if (d == true) {
//            window.clearInterval(intervalID);
//            top.location.href = "" + BASE_PATH + "/result";
//            return; 
//        };
        
        isDonePopupVisible = false;
    };
    
    /**
     * Returns true if this browser supports canvas
     * From http://diveintohtml5.info/
     */
    function supportsCanvas() {
        return !!document.createElement('canvas').getContext;
    };

    /**
     * Handle scratch event on a scratcher
     */
    function scratcherChanged(ev) {
        // Test every pixel. Very accurate, but might be slow on large
        // canvases on underpowered devices:
        //var pct = (scratcher.fullAmount() * 100)|0;
        
        // Only test every 32nd pixel. 32x faster, but might lead to
        // inaccuracy:
        var pct = (this.fullAmount(32) * 100)|0;
		var pct_field = $('#scratchPct');
        pct_field.val(pct);
        
        timeLastScratched = 0;
        if(pct == 65 || pct == 70 || pct == 80 || pct >= 90) {
            askDoneScratching();
        }
        
        if(pct >= 1 && updateUser == false) {
            updateUserPlayed();
        }
    };
    
    function updateUserPlayed() {
		
		//console.log('updateUserPlayed');
   //     $.ajax({
//            url: "" + BASE_PATH + "/ajax/update_user_played.php?user_log_id=" + USER_LOG_ID,
//        }).done(function(value) {
//            updateUser = false;
//        });
    }

    /**
     * Reset given scratchers, default it's all
     */
    function onResetClicked(scratchers) {
        var i;
        for (i = 0; i < scratchers.length; i++) {
            scratchers[i].reset();
        }
        return false;
    };

    /**
     * Assuming canvas works here, do all initial page setup
     */
    function initCard() {
        intervalID = window.setInterval(handleInterval, 100);
        var scratcherLoadedCount = 0;
        var scratchers = [];
        var i;

        // called each time a scratcher loads
        function onScratcherLoaded(ev) {
            scratcherLoadedCount++;

            //check if all scratchers loaded!
            if (scratcherLoadedCount == scratchers.length) {
            
                // bind the reset button to reset all scratchers
                $('#resetbutton').on('click', function() {
                        onResetClicked(scratchers);
                    });

                // hide loading text, show instructions text
                //$('#loading-text').hide();
                //$('#inst-text').show();
            }
        };

        // create new scratchers
        var scratchers = new Array(1);
        for (i = 0; i < scratchers.length; i++) {
            scratchers[i] = new Scratcher('scratcher' + (i+1));
            // set up this listener before calling setImages():
            scratchers[i].addEventListener('imagesloaded', onScratcherLoaded);
            // add front and back images
            scratchers[i].setImages(BACKGROUND_IMAGE, BASE_PATH+'/images/scratch_front_8.png');
        }

        // get notifications of this scratcher changing
        // (These aren't "real" event listeners; they're implemented on top
        // of Scratcher.)
        scratchers[0].addEventListener('reset', scratcherChanged);
        scratchers[0].addEventListener('scratch', scratcherChanged);

        // Or if you didn't want to do it every scratch (to save CPU), you
        // can just do it on 'scratchesended' instead of 'scratch':
        //scratchers[2].addEventListener('scratchesended', scratcherChanged);
    };

    /**
     * Handle page load
     */
    if (supportsCanvas()) {
        initCard();
    } else {
        $('#card').hide();
        $('#lamebrowser').show();
    }
});
</script>

<div class="card" style="background-color:#FFF; min-height:300px">
       <canvas id="scratcher1" style="background-color:#FFF" width="535" height="338"></canvas>
</div>

  
    <input type="hidden" value="" id="scratchPct" name="scratchPct"> 
   
    <div id="lamebrowser" style="display:none;position:fixed; bottom:20px; right:20px">
        <div class="alert"><h4>Your browser doesn't support HTML canvas.</h4> 
        Get a modern browser such as <a href="http://www.google.com/chrome/">Chrome</a></div>
    </div>
  