<section id="news">
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-newspaper-o">Todays <strong>Headlines</strong></h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							<ul class="options">
								<li><a href="#" data-icon="fa-edit">List my own</a></li>
								<li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>
							</ul>
						</div>
					</div>
                    
                    
					<?php 
                     echo $this->my_model->get_items('news');
                     ?>
                    
                    
</section>