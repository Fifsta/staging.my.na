
<div class="row">
	<div class="col-md-6">
	 <img src="<?php $this->business_model->get_qr_vcard_src($ID); ?>" alt=" Vcard for- My Namibia" 
		title="Vcard for - My Namibia" style="width:295px;height:295px"/>
	</div>
	<div class="col-md-5">
	<div class="alert alert-block">
		 <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4>What is a QR code?</h4>
		  (Quick Response code) A two-dimensional bar code that is widely used to cause a Web page to 
		  download into the users smartphone when scanned with a mobile tagging app. Smart marketers are using them to promote their services 
		  products or company. Can be used for people to quickly contact you or view your products.
	</div>
		<a href="<?php echo $this->business_model->get_qr_vcard_src($ID); ?>" target="_blank" class="btn"><i class="icon-qrcode"></i> Download QR vCard</a>
		
	</div>
</div>
<div class="row">
	<div class="col-md-6">
	 <img src="<?php echo $this->business_model->get_qr_url_src($ID); ?>" alt=" Vcard for- My Namibia" 
		title="Vcard for - My Namibia' . '" style="width:295px;height:295px"/>
	</div>
	<div class="col-md-5">
	<div class="alert alert-block">
		 <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4> QR Codes Are Everywhere</h4>
				QR codes are found in newspapers, magazines, on business cards, all types of promotional materials, as well as store shelves. 
			Some companies create billboard-sized QR codes because the QR app uses the phones camera and can scan the QR matrix at a distance.
	</div>
		<a href="<?php $this->business_model->get_qr_url_src($ID); ?>" target="_blank" class="btn"><i class="icon-qrcode"></i> Download QR URL</a>
		
	</div>
</div>