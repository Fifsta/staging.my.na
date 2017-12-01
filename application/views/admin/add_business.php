 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = '';
 $header['metaD'] = '';
 $this->load->view('admin/inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
 <link href="<?php echo base_url('/');?>css/datatables.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />  
 <style type="text/css">
 #loading_img{position:relative;min-height:600px}
 .loading_img{min-height:400px;width:100%;position:relative;top:0;left:0;right:0;bottom:0; z-index: 1040;
  background-color: #FFF;
    opacity: 0.8;
  filter: alpha(opacity=80);}
.btn-group {
  font-size: 12px; /*or whatever size */
}
 </style> 
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = 'account';
 $this->load->view('inc/navigation', $nav);
 ?>

    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div id="container-body" class="container white_box padding10"   style="margin-top:80px;">
      
	  <div class="row">
      	
        <div class="span12">
        	<div class="btn-group pull-right">
            <button class="btn btn-large"><i class="icon-fire"></i> Admin Account</button>
            <button class="btn dropdown-toggle btn-large" data-toggle="dropdown">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li class="nav-header">Admin Navigation</li>
              <li><a href="<?php echo site_url('/');?>my_admin/">Home</a></li>
              <li><a href="">Spare</a></li>
              <li class="nav-header">Logout of Account</li>
              <li><a href="<?php echo site_url('/');?>my_admin/logout">Logout</a></li>
            </ul>
          </div>
          <h1>My Namibia Admin</h1>  
             <ul class="breadcrumb">
              <li><a href="#">My Account</a> <span class="divider">/</span></li>
              <li><?php if($this->session->userdata('u_name')){ echo ucfirst($this->session->userdata('u_name'));}?></li>
            </ul>
        </div>
		      
      </div>
      
      	
      <div class="row">
      
       <div class="span3">
            <?php 
                 //+++++++++++++++++
                 //LOAD MEMBERS NAVIGATION
                 //+++++++++++++++++
                 $subnav['subsection'] = 'add_bus';
				 $this->load->view('admin/inc/admin_nav', $subnav);
				 //+++++++++++++++++
                 //LOAD MY NA BUTTONS
                 //+++++++++++++++++
				// $this->load->view('members/inc/my_na_buttons');
             ?>
       
       	 
        </div>
      
      
        <div class="span9">
       
        	
                  <?php if(isset($error)){ ?>
                    <div class="alert alert-error">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error; ?>
                    </div>
                    <?php
                    }//end error
                    if(isset($basicmsg)){ ?>
                    <div class="alert alert-success">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $basicmsg; ?>
                    </div>
                    <?php
                    }
                    ?>
                
          <div id="loading_img">
              <div id="msg"></div>     
              <div id="admin_content">
    
                <form id="business-add" name="business-add" method="post" action="<?php echo site_url('/');?>my_admin/add_business_do" class="form-horizontal">
                 <fieldset>
                    <legend>Add Business Details</legend>
                      	<div class="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                             <h4>Please Note!</h4> Please make sure the business does not already exist by searching through the existing Businesses <a href="javascript:load_ajax('businesses')">here</a>
                        </div>
                       <div class="control-group">
                        <label class="control-label" for="name">Business Name</label>
                        <div class="controls">
                                <input type="text" class="span4" id="name" name="name" placeholder="Business Name" value="<?php if(isset($BUSINESS_NAME)){echo $BUSINESS_NAME;}?>">
                        </div>
                      </div>
        
                      <div class="control-group">
                        <label class="control-label" for="email">Email</label>
                        <div class="controls">
                            
                             <input type="text" class="span4" id="email" name="email" placeholder="Email" value="<?php if(isset($BUSINESS_EMAIL)){echo $BUSINESS_EMAIL;}?>">
                                
                        </div>
                      </div>
                      
                      <div class="control-group">
                        <label class="control-label" for="tel">Telephone</label>
                        <div class="controls">
                                <input type="text" id="tel" class="span4" name="tel" placeholder="eg: 061231234" value="<?php if(isset($BUSINESS_TELEPHONE)){echo $BUSINESS_TELEPHONE;}?>"> 
                        </div>
                      </div>
                      
                      <div class="control-group">
                        <label class="control-label" for="fax">Fax</label>
                        <div class="controls">
                           
                                <input type="text" id="fax" class="span4" name="fax" placeholder="eg: 061231234" value="<?php if(isset($BUSINESS_FAX)){echo $BUSINESS_FAX;}?>">
                          
                        </div>
                      </div>
                      
                    
                      <div class="control-group">
                        <label class="control-label" for="cell">Cellphone</label>
                        <div class="controls">
                                <input type="text" id="cell" class="span4" name="cell" placeholder="eg: 0811234567" value="<?php if(isset($BUSINESS_CELLPHONE)){echo $BUSINESS_CELLPHONE;}?>">
                        </div>
                      </div>
                      
                      <div class="control-group">
                        <label class="control-label" for="url">Website</label>
                        <div class="controls">
                                <input type="text" id="url" class="span4" name="url" placeholder="eg: www.example.com.na" value="<?php if(isset($BUSINESS_URL)){echo $BUSINESS_URL;}?>">
                        </div>
                      </div>
                       
                        <div class="control-group">
                        <label class="control-label" for="pobox">PO BOX</label>
                        <div class="controls">
                           
                                <input type="text" id="pobox" class="span4" name="pobox" placeholder="eg: 9012 Windhoek" value="<?php if(isset($BUSINESS_POSTAL_BOX)){echo $BUSINESS_POSTAL_BOX;}?>">
                          
                        </div>
                      </div>
                 
                      <div class="control-group">
                        <label class="control-label" for="address">Physical Address</label>
                        <div class="controls">
                            
                                <input type="text" id="address" class="span4" name="address" placeholder="eg: 12 Sam Nujoma Drive, Windhoek Namibia" value="<?php if(isset($BUSINESS_PHYSICAL_ADDRESS)){echo $BUSINESS_PHYSICAL_ADDRESS;}?>"/>
                             
                        </div>
                      </div>
                       <legend>Add Your Business Description</legend>
                      <textarea id="redactor_content" name="content"><?php if(isset($BUSINESS_DESCRIPTION)){echo $BUSINESS_DESCRIPTION;}?></textarea>
                      <div></div>
                      
                     
                      <input type="hidden" name="id" value="<?php echo $this->session->userdata('admin_id');?>">
                      <div style="height:10px; clear:both"></div>
                      <div id="result_msg"></div>
                      <div style="height:10px; clear:both"></div>
                      <button type="submit" class="btn-large btn pull-right" name="submit" id="but"><b>Add</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" ></button>
                       
                   </fieldset> 
                 </form>
              </div>
          </div>  

        </div>
       <div class="clearfix" style="height:30px;"></div>
       
       
      </div><!--end Row -->
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>
      <div id="push"></div>
    </div>
 <?php 
 //+++++++++++++++++
 //MODAL HTML
 //+++++++++++++++++
 ?>  
   

 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('members/inc/footer_backend', $footer);
 ?>  

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
    
<script type="text/javascript">

<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//FIRE EDITOR
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
  
$(document).ready(
	function()
	{
		$('#redactor_content').redactor({ 	
				
				buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				'video', 'table','|',
				 'alignment', '|', 'horizontalrule']
			});
		$('[rel=tooltip]').tooltip();
	 
	}
);


$('#but').click(function(e) {
	
	e.preventDefault();
	
	var cell =  document.getElementById("cell").value;
	
	
	//Validate
	if(($('#name').val().length == 0)){
		
		  $('#name').popover({  
		  delay: { show: 100, hide: 2000 },
		  placement:"top",
		  html:true,trigger: "manual", 
		  title:"Name Required", 
		  content: "Please give provide us with a valid Business name"});
		  $('#name').popover('show');
		  $('#name').focus();
		
	}else if($('#email').val().length == 0){
		
    	$('#email').popover({  
		delay: { show: 100, hide: 2000 },
		placement:"top",
		html: true,trigger: "manual", 
		title:"Email Required", 
		content:"Please give provide us with a valid email address"});
		$('#email').popover('show');
		$('#email').focus();
	
	//}else if($('#tel').val().length < 6){
//		
//    	$('#tel').popover({  
//		delay: { show: 100, hide: 2000 },
//		placement:"top",
//		html: true,trigger: "manual", 
//		title:"Telephone Required", 
//		content:"Please provide us with a valid telephone number"});
//		$('#tel').popover('show');
//		$('#tel').focus();
	
	//}else if($('#cell').val().length < 10){
//		
//    	$('#cell').popover({  
//		delay: { show: 100, hide: 3000 },
//		placement:"top",
//		html: true,trigger: "manual", 
//		title:"Cellphone Required", 
//		content:"Please give provide us with a valid cellphone number - 10 digits long"});
//		$('#cell').popover('show');
//		$('#cell').focus();
//	
//	}else if(checkCellphoneValidity()){
//
//	    $('#cell').popover({  
//		delay: { show: 100, hide: 3000 },
//		placement:"top",
//		html: true,trigger: "manual", 
//		title:"Cellphone invalid", 
//		content:"Your cellular number does not have a correct prefix. Cellular numbers must begin with a 081/085 or 060!"});
//		$('#cell').popover('show');
//		$('#cell').focus();
		
	}else if($('#address').val().length < 6){
		
	    $('#address').popover({  
		delay: { show: 100, hide: 3000 },
		placement:"top",
		html: true,trigger: "manual", 
		title:"Address required", 
		content:"Please provide us with the business Physical address"});
		$('#address').popover('show');
		$('#address').focus();
		
	}else{

		submit_form();
		
	}
});
function submit_form(){
		
		var frm = $('#business-add');
		//frm.submit();
		$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'my_admin/add_business_do_ajax';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#but').html('<b>Add</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
				
			}
		});	

}


function redirectbusiness(id,msg){
	
	$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Redirecting...');
	
		setTimeout(function() {
		  window.location.href = "<?php echo site_url('/');?>my_admin/business_details/"+id+"/";
		}, 2000);
	
}

/* Set the defaults for DataTables initialisation */
$.extend( true, $.fn.dataTable.defaults, {
	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
	"sPaginationType": "bootstrap",
	"oLanguage": {
		"sLengthMenu": "_MENU_ records per page"
	},
	
	"bSortClasses": false
} );


/* Default class modification */
$.extend( $.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline"
} );


/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
{
	return {
		"iStart":         oSettings._iDisplayStart,
		"iEnd":           oSettings.fnDisplayEnd(),
		"iLength":        oSettings._iDisplayLength,
		"iTotal":         oSettings.fnRecordsTotal(),
		"iFilteredTotal": oSettings.fnRecordsDisplay(),
		"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
		"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	};
};


/* Bootstrap style pagination control */
$.extend( $.fn.dataTableExt.oPagination, {
	"bootstrap": {
		"fnInit": function( oSettings, nPaging, fnDraw ) {
			var oLang = oSettings.oLanguage.oPaginate;
			var fnClickHandler = function ( e ) {
				e.preventDefault();
				if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
					fnDraw( oSettings );
				}
			};

			$(nPaging).addClass('pagination').append(
				'<ul>'+
					'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
					'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
				'</ul>'
			);
			var els = $('a', nPaging);
			$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
			$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
		},

		"fnUpdate": function ( oSettings, fnDraw ) {
			var iListLength = 5;
			var oPaging = oSettings.oInstance.fnPagingInfo();
			var an = oSettings.aanFeatures.p;
			var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

			if ( oPaging.iTotalPages < iListLength) {
				iStart = 1;
				iEnd = oPaging.iTotalPages;
			}
			else if ( oPaging.iPage <= iHalf ) {
				iStart = 1;
				iEnd = iListLength;
			} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
				iStart = oPaging.iTotalPages - iListLength + 1;
				iEnd = oPaging.iTotalPages;
			} else {
				iStart = oPaging.iPage - iHalf + 1;
				iEnd = iStart + iListLength - 1;
			}

			for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
				// Remove the middle elements
				$('li:gt(0)', an[i]).filter(':not(:last)').remove();

				// Add the new list items and their event handlers
				for ( j=iStart ; j<=iEnd ; j++ ) {
					sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
					$('<li '+sClass+'><a href="#">'+j+'</a></li>')
						.insertBefore( $('li:last', an[i])[0] )
						.bind('click', function (e) {
							e.preventDefault();
							oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
							fnDraw( oSettings );
						} );
				}

				// Add / remove disabled classes from the static elements
				if ( oPaging.iPage === 0 ) {
					$('li:first', an[i]).addClass('disabled');
				} else {
					$('li:first', an[i]).removeClass('disabled');
				}

				if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
					$('li:last', an[i]).addClass('disabled');
				} else {
					$('li:last', an[i]).removeClass('disabled');
				}
			}
		}
	}
} );


/*
 * TableTools Bootstrap compatibility
 * Required TableTools 2.1+
 */
if ( $.fn.DataTable.TableTools ) {
	// Set the classes that TableTools uses to something suitable for Bootstrap
	$.extend( true, $.fn.DataTable.TableTools.classes, {
		"container": "DTTT btn-group",
		"buttons": {
			"normal": "btn",
			"disabled": "disabled"
		},
		"collection": {
			"container": "DTTT_dropdown dropdown-menu",
			"buttons": {
				"normal": "",
				"disabled": "disabled"
			}
		},
		"print": {
			"info": "DTTT_print_info modal"
		},
		"select": {
			"row": "active"
		}
	} );

	// Have the collection use a bootstrap compatible dropdown
	$.extend( true, $.fn.DataTable.TableTools.DEFAULTS.oTags, {
		"collection": {
			"container": "ul",
			"button": "li",
			"liner": "a"
		}
	} );
}


<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//TIMELINE SCROLL SPY
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
//TimeLine Navigation
//function moveScroller() {
//
//		var move = function() {
//			var st = $(window).scrollTop();
//			var ot = $("#timeline-anchor").offset().top;
//			var s = $("#timeline");
//			if($(window).width() < 770){
//					
//			}else{
//				if(st > ot) {
//					
//					s.css({
//						position: "fixed",
//						top: "80px"
//						
//					});
//				
//					
//				} else {
//					if(st <= ot) {
//						s.css({
//							position: "relative",
//							top: ""
//						});
//					}
//				}
//			}
//    };
//$(window).scroll(move);
//    move();
//}
//
// $(function() {
//    moveScroller();
//    $('[rel=tooltip]').tooltip();
//    
//  });
  	

function load_ajax(str){
		
		var n = $('#admin_content');
		n.fadeOut();
		var loading = $('#loading_img');
		loading.addClass('loading_img');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'my_admin/';?>'+str+'/' ,
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



</script>

</body>
</html>