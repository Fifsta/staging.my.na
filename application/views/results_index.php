 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($title)){
 
     $header['title'] = $title . ' - My Namibia';
     $header['metaD'] = 'Buy or Sell '.$title. '. Find ' . $title .' online - My Namibia';
     $header['section'] = '';
     
 }else{
    
     $header['title'] = '';
     $header['metaD'] = '';
     $header['section'] = '';
     
 }
 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>

</head>

<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
    <div class="container">
          <ol class="breadcrumb">
            <li itemtype="http://data-vocabulary.org/Breadcrumb" class="breadcrumb-item"><a href="#">My.na</a></li>
            <li class="breadcrumb-item active">Search index for: <?php echo $title;?></li>
          </ol>
    </div>
</nav>

<div class="container">

    <div class="row">

        <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-3" id="sidebar">
            <?php $this->load->view('inc/login'); ?>
            <?php $this->load->view('inc/weather'); ?>
            <?php $this->load->view('inc/adverts'); ?>
        </div>

        <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">

            <section id="results">

                    <div class="heading" style="margin-bottom:20px">
                      <h2 data-icon="fa-newspaper-o">Search Index for <strong><?php echo $title;?></strong></h2>
                    </div> 

                <div class="row">

                    <div class="col-md-12">
                        <?php 
                        //+++++++++++++++++
                        //LOAD LOCATION LINKS
                        //+++++++++++++++++
                        $this->my_na_model->instant_search($key, '100');
                        ?>
                    </div>  

                </div>

            </section>    

        </div>

    </div>  
    
</div>
    
<?php $this->load->view('inc/footer');?>    
<script src='<?php echo base_url('/')?>js/jquery.cycle.all.min.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url('/')?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[rel=tooltip]').tooltip();

        // Cycle plugin
        $('.slides').cycle({
            fx:     'fade',
            speed:   400,
            timeout: 200
        }).cycle("pause");
    
        // Pause & play on hover
        $('.slideshow-block').hover(function(){

            $(this).find('.slides').addClass('active').cycle('resume');
            $(this).find('.slides li img').each(function (e) {
                $(this).attr('src', $(this).attr('data-original'));
            });

        }, function(){
            $(this).find('.slides').removeClass('active').cycle('pause');
        });
    });      
</script>
</body>
</html>