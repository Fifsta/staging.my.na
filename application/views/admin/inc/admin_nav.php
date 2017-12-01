<?php //IF TESTER STUDENT 

if($this->session->userdata('u_position') == 'Tester'){
	
?>
	
	
<div id="timeline-anchor"></div>
  <div id="timeline" style="margin:0;padding:0">
    <div>
        <ul class="nav nav-tabs nav-stacked">
        <li class="nav-header">My Admin</li>
              <li <?php if ($subsection == 'myinfo') {  echo 'class="active"'; }?>><a href="<?php echo site_url('/');?>my_admin/home/">General Info<i class="icon-chevron-right pull-right"></i></a></li>
             
              <li class="nav-header">My Namibia Users</li>
              <li><a href="javascript:load_ajax('users')">Registered Users<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="javascript:load_ajax('businesses')">Registered Businesses<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="<?php echo site_url('/');?>my_admin/add_business">Add Business<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">Categories</li>
              <li><a href="javascript:load_ajax('categories')">Categories<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">Reviews</li>
              <li><a href="javascript:load_ajax('reviews')">Business reviews<i class="icon-chevron-right pull-right"></i></a></li>
             
              <li><a href="<?php echo site_url('/');?>my_admin/users">Spare...<i class="icon-chevron-right pull-right"></i></a></li>
       
        </ul>
        
	</div>
  </div>
 	
	
	
	
<?php	
}else{
?>	
	
	
<div id="timeline-anchor"></div>
  <div id="timeline"  style="margin:0;padding:0">
    <div>
        <ul class="nav nav-tabs nav-stacked">
        <li class="nav-header">My Admin</li>
              <li <?php if ($subsection == 'myinfo') {  echo 'class="active"'; }?>><a href="<?php echo site_url('/');?>my_admin/home/">General Info<i class="icon-chevron-right pull-right"></i></a></li>
              <li <?php if ($subsection == 'myusers') {  echo 'class="active"'; }?>><a href="<?php echo site_url('/');?>my_admin/sys_users/">System Users<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">My Namibia Users</li>
              <li <?php if ($subsection == 'users') {  echo 'class="active"'; }?>><a href="javascript:load_ajax('users')">Registered Users<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">My Namibia Businesses</li>
              <li><a href="javascript:load_ajax('businesses')">Registered Businesses<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="<?php echo site_url('/');?>my_admin/add_business">Add Business<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="javascript:load_ajax('business_claims')">Business Claims<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">Business Categories</li>
              <li><a href="javascript:load_ajax('categories')">Business Categories<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="javascript:load_ajax('categories_sub_all')">Business Sub Categories<i class="icon-chevron-right pull-right"></i></a></li>
	          <li class="nav-header">Reviews</li>
	          <li><a href="javascript:load_ajax('reviews')">Business reviews<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">Products</li>
              <li><a href="javascript:load_ajax('load_products')">Listed Products<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="javascript:load_ajax('product_reviews')">Product Reviews<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="javascript:load_ajax('product_categories')">Product Categories<i class="icon-chevron-right pull-right"></i></a></li>

              <li class="nav-header">Adverts</li>
              <li><a href="javascript:load_ajax('adverts')">My Na Adverts<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">Deals</li>
              <li><a href="javascript:load_ajax('deals')">My Na Deals<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">Scratch &amp; Win</li>
              <li><a href="javascript:load_ajax('scratch')">Scratch &amp; Win<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">Content</li>
              <li><a href="javascript:load_ajax('pages')">Pages<i class="icon-chevron-right pull-right"></i></a></li>
	          <li><a href="javascript:load_ajax('content/regions')">Regions<i class="icon-chevron-right pull-right"></i></a></li>
	          <li><a href="javascript:load_ajax('content/towns')">Cities/Towns<i class="icon-chevron-right pull-right"></i></a></li>
	          <li><a href="javascript:load_ajax('content/culture')">Culture<i class="icon-chevron-right pull-right"></i></a></li>
	          <li><a href="javascript:load_ajax('content/animals')">Animals<i class="icon-chevron-right pull-right"></i></a></li>
	          <li><a href="javascript:load_ajax('content/plants')">Plants<i class="icon-chevron-right pull-right"></i></a></li>
	          <li><a href="javascript:load_ajax('content/birds')">Birds<i class="icon-chevron-right pull-right"></i></a></li>
	          <li><a href="javascript:load_ajax('content/must_know')">Must Know<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">Communicate</li>
              <li <?php if ($subsection == 'news') {  echo 'class="active"'; }?>><a href="<?php echo site_url('/');?>my_admin/build_mail/">Compose Newsletter<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="<?php echo site_url('/');?>my_admin/emails/">Newsletters<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="<?php echo site_url('/');?>my_admin/sms/">SMS Service<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="nav-header">System Tools</li>
              <li><a href="javascript:load_ajax('system_log')">System Log<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="javascript:load_ajax('find_duplicates')">Find Duplicates<i class="icon-chevron-right pull-right"></i></a></li>
              <li><a href="<?php echo site_url('/');?>my_admin/users">Spare...<i class="icon-chevron-right pull-right"></i></a></li>
       
        </ul>
        
	</div>
  </div>
 	
	
<?php	
}
?>

