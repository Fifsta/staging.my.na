<div class="btn-group">
  <a class="btn btn-secondary" href="#"><input rel="tooltip" title="Select All" type="checkbox" name="selectallM" id="selectallM" /></a>
  <a class="btn btn-dark dropdown-toggle" data-toggle="dropdown" href="#">
    Action
  <span class="caret"></span>
  </a>
  <ul class="dropdown-menu">
  <li><a style="cursor:pointer;" onClick="update_msg('read')">Mark as read</a></li>
  <li><a style="cursor:pointer;" onClick="update_msg('unread')">Mark as unread</a></li>
  <li><a style="cursor:pointer;" onClick="update_msg('trash')">Move to Trash</a></li>
  <li><a style="cursor:pointer;" onClick="delete_msg()">Delete</a></li>
  <li><a style="cursor:pointer;" onclick="load_mail('all')">Refresh</a></li>
  </ul>
</div>

<a onClick="load_mail('all')" class="btn btn-dark text-light"><i class="fa fa-inbox"></i> Inbox</a> 
<a onclick="load_mail('sent')" class="btn btn-dark text-light"><i class="fa fa-share-square-o"></i> Sent Mail</a> 
<a onclick="load_mail('trash')" class="btn btn-dark text-light"><i class="fa fa-trash"></i> Trash</a>

<hr>

<form action="" id="frm_update_msg" name="frm_update_msg" method="post"/>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col" style="width:20px">#</th>
        <th scope="col" style="width:70px"></th>
        <th scope="col">Subject</th>
        <th scope="col">Message</th>
        <th scope="col">Time</th>
      </tr>
    </thead>
    <tbody id="inbox-body"></tbody>
  </table>
</form>

<script>

  $(document).ready(function(){

    load_mail('all');

    $("#selectallM").click(function () {
       $('.caseM').trigger('click'); 
    });

    $(".caseM").click(function(){
      
      if($(".caseM").length == $(".caseM:checked").length) {
        $("#selectallM").attr("checked", "checked");
      } else {
        $("#selectallM").removeAttr("checked");
      }
      
    });

  });


  function update_msg(str) {

      $("#enquiries").addClass("loading_img");  
      var postdata = $("input[type=checkbox]").serialize();

      $.ajax({
          type: "post",
          url: "'.site_url('/').'tna_mail/update_msg_status/"+str+"/Client" ,
          data:  postdata,
          success: function (data) {
             $("#inbox_msg").html(data);
             load_mail("all");
             $("#enquiries").removeClass("loading_img");  
          }
      });
  }


</script>  
