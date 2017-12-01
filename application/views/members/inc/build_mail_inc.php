<div class="row">
<div class="span9">
<h3><font class="na_script" style="font-size:20px">!na</font> - Mail <small>The Namibian online marketing network</small></h3>

<?php if($this->session->flashdata('error')){ ?>
    <div class="alert alert-error">
     <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $this->session->flashdata('error'); ?>
    </div>
    <?php
    }//end error
    if($this->session->flashdata('msg')){ ?>
    <div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
    <?php
    }
?>  
</div>
   <div class="span4 well muted">
   
   We have built the most effective email marketing system in Namibia called <font class="na_script" style="font-size:20px">!na</font> Mail. You can send customised messages to anybody that has
   connected with your business on My Namibia.<br />
   
   <span class="badge">1</span> Select recipients <span class="badge">2</span> Compose Message <span class="badge">3</span> Send!
   
   </div>
   <div class="span4">
   
       <div id="tna_mailCarousel" class="carousel slide">
              
              <!-- Carousel items -->
              <div class="carousel-inner">
                <div class="item active">
                    <div class="alert alert-block">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <h4>How to send <font class="na_script" style="font-size:20px">!na</font> Mail?</h4><br/>
                      Follow the steps below to send a personalised email to anybody that has <font class="na_script" style="font-size:20px">!na</font>'d your business. Select only a selected few or send a update to everyone.
                    </div>
                </div>
                <div class="item">
                    <div class="alert alert-block">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <h4>Recipients?</h4><br/>
                      These are the people who will receive your customised emails. You can select anybody that has connected with your business by <font class="na_script" style="font-size:20px">!na</font>'ing them.
                    </div>
                </div>
                <div class="item">
                    <div class="alert alert-block">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <h4>Compose Message?</h4><br/>
                      This is where you create the email body. Enter your message, promotion, coupon or update. Please preview the email before you send it.
                    </div>
                
                </div>
             
        </div>
   
   </div>
 </div>
 </div>
 <div class="row-fluid">   
<form id="sendmail" target="load_frame"  name="sendmail" method="post" action="<?php echo site_url('/');?>tna_mail/send_email" >
       		
            
        <ul class="nav nav-tabs" id="bus_tabs">
          <li id="tna_step_1_li" class="active"><a href="#tnaselect" data-toggle="tab"><span class="badge">1</span> Recipients</a></li>
          <li id="tna_step_2_li"><a href="#tnacompose" id="tna_step_2" style="display:none" data-toggle="tab"><span class="badge">2</span> Compose</a></li>
        </ul>
        
        <div class="tab-content">
              <!-- TAB SELECT -->
              <div class="tab-pane active" id="tnaselect">
              <div class="span12">
              	<?php $this->members_model->show_tna_recipients($ID);?>	
                
              </div>
              </div><!-- end select tab -->
              <!-- TAB COMPOSE -->
              <div class="tab-pane" id="tnacompose" style="overflow:hidden">
              
              <div class="span12">
       
        	
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
                        
                        <div style="overflow:hidden">
          
                          <h3><small>Compose a Message</small></h3>  
                                
                                <div class="alert alert-block">
                                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                                  <h4>Notice!</h4>
                                  The US CAN-SPAM Act bans false or misleading header information (e.g. "From" and "To" emails).
                                    It also bans deceptive or misleading subject lines.
                                </div>
                               
                                <a id="preview_button" style="display:none;margin-bottom:10px;clear:both" onClick="javascript:$('#preview').slideUp();$('#admin_content').slideDown();$('#preview_button').hide()" class="btn pull-right"><i class="icon-remove"></i> Close Preview</a>
                                <div style="height:30px;" class="clearfix"></div>
                                <div id="preview" class="span12" style="display:none;background-color:#FF7401">
                                
                            
                       </div>
                       <iframe  allowtransparency="true" name="load_frame" id="load_frame" frameborder="0" src="" style="width:100%;display:none"></iframe>
                      
                       <div id="admin_content">    
                            
                              <input type="text" class="span9" style="font-size:22px;line-height:32px;height:40px;padding:5px" onKeyDown="$('#title').popover('destroy');" id="title" name="title" placeholder="Subject..." />
                              <input type="hidden" name="bus_id_tna_mail" id="bus_id_tna_mail" value="<?php echo $ID;?>">
                              <input type="hidden" name="bus_email_tna_mail" id="bus_email_tna_mail" value="<?php echo $BUSINESS_EMAIL;?>">
                              <input type="hidden" name="bus_name" id="bus_name" value="<?php echo $BUSINESS_NAME;?>">
                              <input type="radio" style="display:none" name="recipient" id="radio_all" value="all">
                              <input type="radio" style="display:none" name="recipient" id="radio_2" value="none">
                              <textarea id="redactor_content" style="display:none" name="content"></textarea>
                              <br />
                              <button type="submit" id="send_mail_btn" class="btn pull-right"><i class="icon-envelope"></i> Send <font class="na_script" style="font-size:20px">!na</font> Mail</button>
                              <a href="javascript:preview();" class="btn pull-right" style="margin-right:10px;"><i class="icon-check"></i> Preview</a>
                            
                      </div>
                  </div>  
                
                 
                    
                 
                </div>
              
              </div><!-- end tab compose --> 
        </div>
        
       <div class="clearfix" style="height:30px;"></div>
       
       </form>
</div>