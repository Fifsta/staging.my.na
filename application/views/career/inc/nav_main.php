<?php $segment = end($this->uri->segment_array()); ?>
<ul class="nav nav-tabs nav-stacked">
    <li <?php if($segment == 'profile') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/profile">My Profile</span></a></li>
    <li <?php if($segment == 'general_details') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/general_details">General Details</a></li>
    <li <?php if($segment == 'education_courses') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/education_courses">Education & Courses</a></li>
    <li <?php if($segment == 'experience_skills') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/experience_skills">Experience and Skills</a></li>
    <li <?php if($segment == 'achievements') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/achievements">Achievements</a></li>
    <li <?php if($segment == 'employment_history') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/employment_history">Employment History</a></li>
    <li <?php if($segment == 'languages') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/languages">Languages</a></li>
    <li <?php if($segment == 'references') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/references">References</a></li>
    <li <?php if($segment == 'applications') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/applications">Applications</a></li>
    <li <?php if($segment == 'leisure') { echo 'class="active"'; } ?>><a href="<?php echo site_url('/'); ?>vacancy/leisure">Leisure & Interests</a></li>
</ul>