
<div class="row">
  <div class="col-md-12">

    <a onClick="load_mail('all')" class="btn btn-dark text-light"><i class="fa fa-inbox"></i> Inbox</a> 
    <a onclick="reply_message()" class="btn btn-dark text-light"><i class="fa fa-reply"></i> Reply</a> 

    <hr>

    <div id="view_msg">

        <!--tabs-->
        <div class="tab-content">
          <section role="tabpanel" class="tab-pane active" id="Contact-Agent">
            <div class="row">
              <div class="col-sm-12">
                <section class="results-item">
                  <div>
                    <figure>
                      <a href="#"><img src="<?php echo $img_url; ?>" class="img-responsive"></a>
                    </figure>
                  </div>
                  <div>
                    <h2>From <a href="#"><?php echo $nameFROM; ?></a></h2>
                    <p class="addr" data-icon="fa-map-marker"><?php echo date('l jS \of F Y h:i:s A', strtotime($timestamp)); ?></p>
                    <?php echo $body; ?>
                  </div>
                </section>
              </div>
            </div>
          </section>
        </div>
        <!--tabs-->

        <hr>

        <a onClick="load_mail('all')" class="btn btn-dark text-light"><i class="fa fa-inbox"></i> Inbox</a> 
        <a onclick="reply_message()" class="btn btn-dark text-light"><i class="fa fa-reply"></i> Reply</a> 

    </div>

    <div id="reply_msg" style="display:none">
      <h3><?php echo $subject; ?></h3>
      <form id="replymail" name="replymail" >
        <input type="hidden" name="cur_state" id="cur_state" value="<?php echo $status; ?>'">
        <input type="hidden" name="bus_id_reply" id="bus_id_reply" value="<?php echo $bus_id; ?>">
        <input type="hidden" name="msg_id_reply" id="msg_id_reply" value="<?php echo $msg_id; ?>">
        <input type="hidden" name="client_id_reply" id="client_id_reply" value="<?php echo $client_id; ?>">
        <input type="hidden" name="emailTO" id="emailTO" value="<?php echo $email; ?>">
        <input type="hidden" name="emailFROM" id="emailFROM" value="<?php echo $emailTO; ?>">
        <input type="hidden" name="name_from" id="name_from" value="<?php echo $nameFROM; ?>">
        <input type="hidden" name="name_to" id="name_to" value="<?php echo $nameTO; ?>">
        <textarea id="reply_redactor_content" name="reply_content">
        <br /><br /><br />
        -------------------------------------------------------<br /><em>
        <?php echo date('l jS \of F Y h:i:s A', strtotime($timestamp)); ?></em><br />
        -------------------------------------------------------<br />
        <p><?php echo $body; ?></p>
        </textarea>
        <br />
        <div id="reply_msg"></div>
        <hr />
        <a id="reply_email_yes" class="btn btn-dark text-light"><i class="fa fa-reply"></i> Reply</a>
        <a onClick="load_mail('all')" class="btn btn-dark text-light"><i class="fa fa-inbox"></i> Inbox</a>
      </form> 
    </div>      

  </div>


</div>

<script data-cfasync="false" type="text/javascript">

  function reply_message(){
  
    $("#view_msg").hide();
    $("#reply_msg").fadeIn();
    $("#reply_redactor_content").prepend();
    $("#reply_redactor_content").focus();

  }

  $("#reply_redactor_content").redactor({   

    buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
    "unorderedlist", "orderedlist", "outdent", "indent", "|",
    "video", "table","|",
    "alignment", "|", "horizontalrule"]

  });

  $("#reply_email_yes").on("click", function() {  
    
    var frm = $("#replymail");
    frm.attr("action","<?php echo site_url('/'); ?>tna_mail/reply_email/");

    $("#reply_email_yes").html("Sending...");
    
    $.ajax({
      type: "post",
      cache: false,
      data: frm.serialize(),
      url: "<?php echo site_url('/'); ?>tna_mail/reply_email/" ,
      success: function (data) {
        $("#reply_email_yes").html("Sent!");
        $("#reply_msg").html(data);
      }
    }); 

  }); 

  </script>