<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php if(isset($subject)){echo $subject;}else{ echo 'My Namibia Mail';}?></title>
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/skin1-front.css?v5">
    <style type="text/css">

        /* /\/\/\/\/\/\/\/\/ CLIENT-SPECIFIC STYLES /\/\/\/\/\/\/\/\/ */
        #outlook a{padding:0;} /* Force Outlook to provide a "view in browser" message */
        .ReadMsgBody{width:100%;} .ExternalClass{width:100%;} /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing */
        body, table, td, p, a, li, blockquote{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;} /* Prevent WebKit and Windows mobile changing default text sizes */
        table, td{mso-table-lspace:0pt; mso-table-rspace:0pt; border:none;border-color:#000} /* Remove spacing between tables in Outlook 2007 and up */
        img{-ms-interpolation-mode:bicubic;} /* Allow smoother rendering of resized image in Internet Explorer */

        /* /\/\/\/\/\/\/\/\/ RESET STYLES /\/\/\/\/\/\/\/\/ */
        body{margin:0; padding:0;border-bottom:4px solid #000;}
        img{border:0; outline:none; text-decoration:none;}
        table{border-collapse:collapse !important;}
        body, #bodyTable, #bodyCell{height:100% !important; margin:0; padding:0; width:100% !important;}

        /* /\/\/\/\/\/\/\/\/ TEMPLATE STYLES /\/\/\/\/\/\/\/\/ */

        /* ========== Page Styles ========== */

        .white_box {

            background-color: #fff;
            margin-bottom: 10px;
            background: #fff;
            -moz-box-shadow: 0 0 1px #000;
            -webkit-box-shadow: 0 0 1px #000;
            box-shadow: 0 0 1px #000;
            -moz-border-radius: 0px;
            -webkit-border-radius: 0px;
            border-radius: 0px; /* future proofing */
            -khtml-border-radius: 0px; /* for old Konqueror browsers */
            border-bottom:5px solid  #FF9F01;
            max-width:640px;
            padding:10px;
        }

        .btn{padding:10px 20px; background:#000; border:1px solid #FF9F01; text-decoration: none; color:#fff; font-weight: bold;text-transform:uppercase; font-size:18px;font-family:'Yanone Kaffeesatz', sans-serif;}
        .white{color:#f1f1f1;}.black{color:#1d1d1d}.white_back{background:#fff}.yellow{color:#FF9F01}.yellow_back{background: #FF9F01}
        .upper{text-transform: uppercase;font-weight: normal}
        #bodyCell{padding:20px;}
        #templateContainer{width:600px;}
			.img-rounded {
			  -webkit-border-radius: 6px;
			  -moz-border-radius: 6px;
			  border-radius: 6px;
			}
			.img-polaroid {
			  padding: 4px;
			  background-color: #fff;
			  border: 1px solid #ccc;
			  border: 1px solid rgba(0, 0, 0, 0.2);
			  -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
			  -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
			  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
			}
			.img-circle {
			  -webkit-border-radius: 500px;
			  -moz-border-radius: 500px;
			  border-radius: 500px;
			}
			small{font-size:10px}
			*,p,td{            /*@editable*/ color:#505050;
            /*@editable*/ font-family:Arial;
            /*@editable*/ font-size:14px;
            /*@editable*/ line-height:150%;}
        /**
        * @tab Page
        * @section background style
        * @tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
        * @theme page
        */
        body, #bodyTable{
            /*@editable*/ background-color:#f5f5f5;
        }

        /**
        * @tab Page
        * @section background style
        * @tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
        * @theme page
        */
        #bodyCell{
            /*@editable*/ border-top:4px solid #000;
        }

        /**
        * @tab Page
        * @section email border
        * @tip Set the border for your email.
        */
        #templateContainer{
            /*@editable*/ border:0px solid #BBBBBB;
        }

        /**
        * @tab Page
        * @section heading 1
        * @tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
        * @style heading 1
        */
        h1{
            /*@editable*/ color:#000 !important;
            display:block;
            /*@editable*/ font-family:'Yanone Kaffeesatz', sans-serif;
            /*@editable*/ font-size:26px;
            /*@editable*/ font-style:normal;
            /*@editable*/ font-weight:bold;
            /*@editable*/ line-height:100%;
            /*@editable*/ letter-spacing:normal;
            margin-top:0;
            margin-right:0;
            margin-bottom:10px;
            margin-left:0;
            /*@editable*/ text-align:left;
        }
        .text-center{text-align: center}
        /**
        * @tab Page
        * @section heading 2
        * @tip Set the styling for all second-level headings in your emails.
        * @style heading 2
        */
        h2{
            /*@editable*/ color:#404040 !important;
            display:block;
            /*@editable*/ font-family:'Yanone Kaffeesatz', sans-serif;
            /*@editable*/ font-size:20px;
            /*@editable*/ font-style:normal;
            /*@editable*/ font-weight:bold;
            /*@editable*/ line-height:100%;
            /*@editable*/ letter-spacing:normal;
            margin-top:0;
            margin-right:0;
            margin-bottom:10px;
            margin-left:0;
            /*@editable*/ text-align:left;
        }

        /**
        * @tab Page
        * @section heading 3
        * @tip Set the styling for all third-level headings in your emails.
        * @style heading 3
        */
        h3{
            /*@editable*/ color:#FF9F01 !important;
            display:block;
            /*@editable*/ font-family:'Yanone Kaffeesatz', sans-serif;
            /*@editable*/ font-size:16px;
            /*@editable*/ font-style:italic;

            /*@editable*/ font-weight:normal;
            /*@editable*/ line-height:100%;
            /*@editable*/ letter-spacing:normal;
            margin-top:0;
            margin-right:0;
            margin-bottom:10px;
            margin-left:0;
            /*@editable*/ text-align:left;
        }

        /**
        * @tab Page
        * @section heading 4
        * @tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
        * @style heading 4
        */
        h4{
            /*@editable*/ color:#000 !important;
            display:block;
            /*@editable*/ font-family:'Yanone Kaffeesatz', sans-serif;
            /*@editable*/ font-size:14px;
            /*@editable*/ font-style:italic;
            /*@editable*/ font-weight:normal;
            /*@editable*/ line-height:100%;
            /*@editable*/ letter-spacing:normal;
            margin-top:0;
            margin-right:0;
            margin-bottom:10px;
            margin-left:0;
            /*@editable*/ text-align:left;
        }

        /* ========== Header Styles ========== */

        /**
        * @tab Header
        * @section preheader style
        * @tip Set the background color and bottom border for your email's preheader area.
        * @theme header
        */
        #templatePreheader{
            /*@editable*/ background-color:#f5f5f5;
            /*@editable*/ border-bottom:0px solid #CCCCCC;
        }

        /**
        * @tab Header
        * @section preheader text
        * @tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
        */
        .preheaderContent{
            /*@editable*/ color:#333;
            /*@editable*/ font-family:Arial;
            /*@editable*/ font-size:10px;
            /*@editable*/ line-height:125%;
            /*@editable*/ text-align:left;
        }

        /**
        * @tab Header
        * @section preheader link
        * @tip Set the styling for your email's preheader links. Choose a color that helps them stand out from your text.
        */
        .preheaderContent a:link, .preheaderContent a:visited, /* Yahoo! Mail Override */ .preheaderContent a .yshortcuts /* Yahoo! Mail Override */{
            /*@editable*/ color:#333;
            /*@editable*/ font-weight:bold;
            /*@editable*/ text-decoration:underline;
        }

        /**
        * @tab Header
        * @section header style
        * @tip Set the background color and borders for your email's header area.
        * @theme header
        */
        #templateHeader{
            /*@editable*/
            /*@editable*/ border-top:0px solid #FFFFFF;
            /*@editable*/ border-bottom:0px solid #CCCCCC;
        }

        /**
        * @tab Header
        * @section header text
        * @tip Set the styling for your email's header text. Choose a size and color that is easy to read.
        */
        .headerContent{
            /*@editable*/ color:#fff;
            /*@editable*/ font-family:Arial;
            /*@editable*/ font-size:20px;
            /*@editable*/ font-weight:bold;
            /*@editable*/ line-height:100%;
            /*@editable*/ padding-top:0;
            /*@editable*/ padding-right:0;
            /*@editable*/ padding-bottom:0;
            /*@editable*/ padding-left:0;
            /*@editable*/ text-align:left;
            /*@editable*/ vertical-align:middle;
        }

        /**
        * @tab Header
        * @section header link
        * @tip Set the styling for your email's header links. Choose a color that helps them stand out from your text.
        */
        .headerContent a:link, .headerContent a:visited, /* Yahoo! Mail Override */ .headerContent a .yshortcuts /* Yahoo! Mail Override */{
            /*@editable*/ color:#fff;
            /*@editable*/ font-weight:bold;
            /*@editable*/ text-decoration:underline;
        }

        #headerImage{
            height:auto;
            max-width:600px;
        }
        #headerslogan{
            height:auto;
            max-width:600px;

        }
        .inline_img{

            height:auto;
            max-width:580px;

        }
        /* ========== Body Styles ========== */

        /**
        * @tab Body
        * @section body style
        * @tip Set the background color and borders for your email's body area.
        */
        #templateBody{
            /*@editable*/ background-color:#F4F4F4;
            /*@editable*/ border-top:0px solid #FFFFFF;

        }

        /**
        * @tab Body
        * @section body text
        * @tip Set the styling for your email's main content text. Choose a size and color that is easy to read.
        * @theme main
        */
        .bodyContent {
            /*@editable*/ color:#505050;
            /*@editable*/ font-family:Arial;
            /*@editable*/ font-size:14px;
            /*@editable*/ line-height:150%;
            padding-top:20px;
            padding-right:20px;
            padding-bottom:20px;
            padding-left:20px;
            /*@editable*/ text-align:left;
        }

        /**
        * @tab Body
        * @section body link
        * @tip Set the styling for your email's main content links. Choose a color that helps them stand out from your text.
        */
        .bodyContent a:link, .bodyContent a:visited, /* Yahoo! Mail Override */ .bodyContent a .yshortcuts /* Yahoo! Mail Override */{
            /*@editable*/ color:#EB4102;
            /*@editable*/ font-weight:normal;
            /*@editable*/ text-decoration:underline;
        }


        /* ========== Column Styles ========== */

        .templateColumnContainer{width:260px;}

        /**
        * @tab Columns
        * @section column style
        * @tip Set the background color and borders for your email's column area.
        */
        #templateColumns{
            /*@editable*/ background-color:#F4F4F4;
            /*@editable*/ border-top:1px solid #FFFFFF;
            /*@editable*/ border-bottom:1px solid #CCCCCC;
        }

        /**
        * @tab Columns
        * @section left column text
        * @tip Set the styling for your email's left column content text. Choose a size and color that is easy to read.
        */
        .leftColumnContent{
            /*@editable*/ color:#505050;
            /*@editable*/ font-family:Arial;
            /*@editable*/ font-size:14px;
            /*@editable*/ line-height:150%;
            padding-top:0;
            padding-right:20px;
            padding-bottom:20px;
            padding-left:20px;
            /*@editable*/ text-align:left;
        }

        /**
        * @tab Columns
        * @section left column link
        * @tip Set the styling for your email's left column content links. Choose a color that helps them stand out from your text.
        */
        .leftColumnContent a:link, .leftColumnContent a:visited, /* Yahoo! Mail Override */ .leftColumnContent a .yshortcuts /* Yahoo! Mail Override */{
            /*@editable*/ color:#EB4102;
            /*@editable*/ font-weight:normal;
            /*@editable*/ text-decoration:underline;
        }

        /**
        * @tab Columns
        * @section right column text
        * @tip Set the styling for your email's right column content text. Choose a size and color that is easy to read.
        */
        .rightColumnContent{
            /*@editable*/ color:#505050;
            /*@editable*/ font-family:Arial;
            /*@editable*/ font-size:14px;
            /*@editable*/ line-height:150%;
            padding-top:0;
            padding-right:20px;
            padding-bottom:20px;
            padding-left:20px;
            /*@editable*/ text-align:left;
        }

        /**
        * @tab Columns
        * @section right column link
        * @tip Set the styling for your email's right column content links. Choose a color that helps them stand out from your text.
        */
        .rightColumnContent a:link, .rightColumnContent a:visited, /* Yahoo! Mail Override */ .rightColumnContent a .yshortcuts /* Yahoo! Mail Override */{
            /*@editable*/ color:#EB4102;
            /*@editable*/ font-weight:normal;
            /*@editable*/ text-decoration:underline;
        }

        .leftColumnContent img, .rightColumnContent img{
            display:inline;
            height:auto;
            max-width:260px;
        }

        /* ========== Footer Styles ========== */

        /**
        * @tab Footer
        * @section footer style
        * @tip Set the background color and borders for your email's footer area.
        * @theme footer
        */
        #templateFooter{
            /*@editable*/ background-color:#000;

        }

        /**
        * @tab Footer
        * @section footer text
        * @tip Set the styling for your email's footer text. Choose a size and color that is easy to read.
        * @theme footer
        */
        .footerContent{
            /*@editable*/ color:#f5f5f5;
            /*@editable*/ font-family:Arial;
            /*@editable*/ font-size:10px;
            /*@editable*/ line-height:150%;
            padding-top:20px;
            padding-right:20px;
            padding-bottom:20px;
            padding-left:20px;
            /*@editable*/ text-align:left;
        }

        /**
        * @tab Footer
        * @section footer link
        * @tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
        */
        .footerContent a:link, .footerContent a:visited, /* Yahoo! Mail Override */ .footerContent a .yshortcuts, .footerContent a span /* Yahoo! Mail Override */{
            /*@editable*/ color:#f5f5f5;
            /*@editable*/ font-weight:normal;
            /*@editable*/ text-decoration:underline;
        }

        /* /\/\/\/\/\/\/\/\/ MOBILE STYLES /\/\/\/\/\/\/\/\/ */

        @media only screen and (max-width: 480px){
            /* /\/\/\/\/\/\/ CLIENT-SPECIFIC MOBILE STYLES /\/\/\/\/\/\/ */
            body, table, td, p, a, li, blockquote{-webkit-text-size-adjust:none !important;} /* Prevent Webkit platforms from changing default text sizes */
            body{width:100% !important; min-width:100% !important;} /* Prevent iOS Mail from adding padding to the body */

            /* /\/\/\/\/\/\/ MOBILE RESET STYLES /\/\/\/\/\/\/ */
            #bodyCell{padding:10px !important;}

            .inline_img{

                height:auto;
                max-width:320px;

            }
            img{border:0; height:auto; width:100%;line-height:100%; outline:none; text-decoration:none;}
            img.footer_icons{width:auto}
            /* /\/\/\/\/\/\/ MOBILE TEMPLATE STYLES /\/\/\/\/\/\/ */

            /* ======== Page Styles ======== */

            /**
            * @tab Mobile Styles
            * @section template width
            * @tip Make the template fluid for portrait or landscape view adaptability. If a fluid layout doesn't work for you, set the width to 300px instead.
            */
            #templateContainer{
                max-width:600px !important;
                /*@editable*/ width:100% !important;
            }

            /**
            * @tab Mobile Styles
            * @section heading 1
            * @tip Make the first-level headings larger in size for better readability on small screens.
            */
            h1{
                /*@editable*/ font-size:24px !important;
                /*@editable*/ line-height:100% !important;
            }

            /**
            * @tab Mobile Styles
            * @section heading 2
            * @tip Make the second-level headings larger in size for better readability on small screens.
            */
            h2{
                /*@editable*/ font-size:20px !important;
                /*@editable*/ line-height:100% !important;
            }

            /**
            * @tab Mobile Styles
            * @section heading 3
            * @tip Make the third-level headings larger in size for better readability on small screens.
            */
            h3{
                /*@editable*/ font-size:18px !important;
                /*@editable*/ line-height:100% !important;
            }

            /**
            * @tab Mobile Styles
            * @section heading 4
            * @tip Make the fourth-level headings larger in size for better readability on small screens.
            */
            h4{
                /*@editable*/ font-size:16px !important;
                /*@editable*/ line-height:100% !important;
            }

            /* ======== Header Styles ======== */

            #templatePreheader{display:none !important;} /* Hide the template preheader to save space */

            /**
            * @tab Mobile Styles
            * @section header image
            * @tip Make the main header image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.
            */
            #headerImage{
                height:auto !important;
                /*@editable*/ max-width:97px !important;
                /*@editable*/ width:100% !important;
            }
            #headerslogan, .inline_img{
                height:auto !important;
                /*@editable*/ max-width:340px !important;
                /*@editable*/ width:100% !important;

            }
            /**
            * @tab Mobile Styles
            * @section header text
            * @tip Make the header content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
            */
            .headerContent{
                /*@editable*/ font-size:20px !important;
                /*@editable*/ line-height:125% !important;
            }

            /* ======== Body Styles ======== */

            /**
            * @tab Mobile Styles
            * @section body text
            * @tip Make the body content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
            */
            .bodyContent{
                /*@editable*/ font-size:18px !important;
                /*@editable*/ line-height:125% !important;
            }

            /* ======== Column Styles ======== */

            .templateColumnContainer{display:block !important; width:100% !important;}

            /**
            * @tab Mobile Styles
            * @section column image
            * @tip Make the column image fluid for portrait or landscape view adaptability, and set the image's original width as the max-width. If a fluid setting doesn't work, set the image width to half its original size instead.
            */
            .columnImage{
                height:auto !important;
                /*@editable*/ max-width:480px !important;
                /*@editable*/ width:100% !important;
            }

            /**
            * @tab Mobile Styles
            * @section left column text
            * @tip Make the left column content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
            */
            .leftColumnContent{
                /*@editable*/ font-size:16px !important;
                /*@editable*/ line-height:125% !important;
            }

            /**
            * @tab Mobile Styles
            * @section right column text
            * @tip Make the right column content text larger in size for better readability on small screens. We recommend a font size of at least 16px.
            */
            .rightColumnContent{
                /*@editable*/ font-size:16px !important;
                /*@editable*/ line-height:125% !important;
            }

            /* ======== Footer Styles ======== */

            /**
            * @tab Mobile Styles
            * @section footer text
            * @tip Make the body content text larger in size for better readability on small screens.
            */
            .footerContent{
                /*@editable*/ font-size:14px !important;
                /*@editable*/ line-height:115% !important;
            }

            .footerContent a{display:block !important;} /* Place footer social and utility links on their own lines, for easier access */
        }
    </style>
</head>


<?php 
 //+++++++++++++++++
 //My.Na Business Analytics
 //+++++++++++++++++
 //Roland Ihms
 
 $impJAN = $this->members_model->get_business_impressions($bus_id,$period, '01');
 $impFEB = $this->members_model->get_business_impressions($bus_id,$period, '02');
 $impMAR = $this->members_model->get_business_impressions($bus_id,$period, '03');
 $impAPR = $this->members_model->get_business_impressions($bus_id,$period, '04');
 $impMAY = $this->members_model->get_business_impressions($bus_id,$period, '05');
 $impJUN = $this->members_model->get_business_impressions($bus_id,$period, '06');
 $impJUL = $this->members_model->get_business_impressions($bus_id,$period, '07');
 $impAUG = $this->members_model->get_business_impressions($bus_id,$period, '08');
 $impSEP = $this->members_model->get_business_impressions($bus_id,$period, '09');
 $impOCT = $this->members_model->get_business_impressions($bus_id,$period, '10');
 $impNOV = $this->members_model->get_business_impressions($bus_id,$period, '11');
 $impDEC = $this->members_model->get_business_impressions($bus_id,$period, '12');
 
 $clickJAN = $this->members_model->get_business_clicks($bus_id,$period, '1');
 $clickFEB = $this->members_model->get_business_clicks($bus_id,$period, '2');
 $clickMAR = $this->members_model->get_business_clicks($bus_id,$period, '3');
 $clickAPR = $this->members_model->get_business_clicks($bus_id,$period, '4');
 $clickMAY = $this->members_model->get_business_clicks($bus_id,$period, '5');
 $clickJUN = $this->members_model->get_business_clicks($bus_id,$period, '6');
 $clickJUL = $this->members_model->get_business_clicks($bus_id,$period, '7');
 $clickAUG = $this->members_model->get_business_clicks($bus_id,$period, '8');
 $clickSEP = $this->members_model->get_business_clicks($bus_id,$period, '9');
 $clickOCT = $this->members_model->get_business_clicks($bus_id,$period, '10');
 $clickNOV = $this->members_model->get_business_clicks($bus_id,$period, '11');
 $clickDEC = $this->members_model->get_business_clicks($bus_id,$period, '12');
 
 $enqJAN = $this->members_model->get_business_enquiries($bus_id,$period, '1');
 $enqFEB = $this->members_model->get_business_enquiries($bus_id,$period, '2');
 $enqMAR = $this->members_model->get_business_enquiries($bus_id,$period, '3');
 $enqAPR = $this->members_model->get_business_enquiries($bus_id,$period, '4');
 $enqMAY = $this->members_model->get_business_enquiries($bus_id,$period, '5');
 $enqJUN = $this->members_model->get_business_enquiries($bus_id,$period, '6');
 $enqJUL = $this->members_model->get_business_enquiries($bus_id,$period, '7');
 $enqAUG = $this->members_model->get_business_enquiries($bus_id,$period, '8');
 $enqSEP = $this->members_model->get_business_enquiries($bus_id,$period, '9');
 $enqOCT = $this->members_model->get_business_enquiries($bus_id,$period, '10');
 $enqNOV = $this->members_model->get_business_enquiries($bus_id,$period, '11');
 $enqDEC = $this->members_model->get_business_enquiries($bus_id,$period, '12');
?>
<?php    
    $imp_total = $impJAN + $impFEB+ $impMAR + $impAPR + $impMAY + $impJUN + $impJUL + $impAUG + $impSEP + $impOCT + $impNOV + $impDEC;
    $click_total = $clickJAN + $clickFEB+ $clickMAR + $clickAPR + $clickMAY + $clickJUN + $clickJUL + $clickAUG + $clickSEP + $clickOCT + $clickNOV + $clickDEC;
    $CTR = ( $click_total / $imp_total) * 100;
    
    
    ?>

<?php 
    $rand = rand(0,9999);
    $img = $business[0]->BUSINESS_LOGO_IMAGE_NAME;
    $format = substr($img,(strlen($img) - 4),4);
    $str = substr($img,0,(strlen($img) - 4));
    
    if($img != ''){
        
        if(strpos($img,'.') == 0){

            $format = '.jpg';
            $img_str = base_url('/').'img/timbthumb.php?w=200&h=200&src='.S3_URL.'assets/business/photos/'.$img . $format;
            
        }else{
            
            $img_str =  base_url('/').'img/timbthumb.php?w=200&h=200&src='.S3_URL.'assets/business/photos/'.$img;
            
        }
        
    }else{
        
        $img_str = base_url('/').'img/timbthumb.php?w=200&h=200&src='.base_url('/').'images/bus_blank.png';    
        
    }
    //COVER IMAGE
    $cover_img = $business[0]->BUSINESS_COVER_PHOTO;
    
    if($cover_img != ''){
        
            if(strpos($cover_img,'.') == 0){
    
                $format2 = '.jpg';
                //$cover_str = S3_URL.'assets/business/photos/'.$cover_img . $format2.'?='.$rand;
                $cover_str = base_url('/').'img/timbthumb.php?w=600&h=200&src='.S3_URL.'assets/business/photos/'.$cover_img . $format2;
            }else{
                
                //$cover_str =  S3_URL.'assets/business/photos/'.$cover_img.'?='.$rand;
                $cover_str = base_url('/').'img/timbthumb.php?w=600&h=200&src='.S3_URL.'assets/business/photos/'.$cover_img;
            }
        
    }else{
        
        $cover_str = base_url('/').'images/business_cover_blank.jpg';  
        
    }
    

    ?>

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor="#FF7401">



<table align="center" border="0" cellpadding="0" cellspacing="0" id="bodyTable">
    <tr>
        <td align="center" valign="top" id="bodyCell">
            <!-- BEGIN TEMPLATE // -->
            <table border="0" cellpadding="0" cellspacing="0" id="templateContainer">
                <tr>
                    <td align="center" valign="top">
                        <!-- BEGIN PREHEADER // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader">
                            <tr>
                                <td valign="top" class="preheaderContent" style="padding-top:10px;text-align:center; padding-right:20px; padding-bottom:10px; padding-left:20px;color:#999" mc:edit="preheader_content00">
                                    My Namibia Business Insights for <?php echo $business[0]->BUSINESS_NAME;?>
                                </td>
                                <!-- *|IFNOT:ARCHIVE_PAGE|* -->
                               
                                <!-- *|END:IF|* -->
                            </tr>
                        </table>
                        <!-- // END PREHEADER -->
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <!-- BEGIN HEADER // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%"  id="templateHeader">
                            <tr>
                                <td valign="top" class="headerContent" style="text-align:center;margin:0;padding:0;background-color:#F4F4F4;border:none;padding-top:10px;">
                                    
                                     <img align="center" src="<?php echo base_url('/');?>images/logo_black.png" style="width:97px;height:24px;padding:0;margin:0" alt="Download images to view"/>
                                    <p>
                                        <small>Performance reports</small>
                                    </p>
                                   
                                </td>
                            </tr>
                        </table>
                        <!-- // END HEADER -->
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <!-- BEGIN BODY // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%"  id="templateBody">
                            <tr>
                                <td valign="top" class="bodyContent" style="border:none;" mc:edit="BODY">
                                
                                    <h2 class="na_script text-center"><?php echo $business[0]->BUSINESS_NAME;?></h2>

                                    <img src="<?php echo $cover_str;?>" class="">

                                   
                                    <p>&nbsp;</p>

                                    <table class="table">
                                        <tr>
                                            <td> 
                                                <img class="img-polaroid" src="<?php echo $img_str;?>" alt="<?php echo $business[0]->BUSINESS_NAME;?>" style="width: 80px; height:80px;">
                                            </td>
                                            <td></td>
                                            <td>
                                                <strong><?php echo $business[0]->BUSINESS_NAME;?></strong><br />
                                                <span itemprop="street-address"><i class="icon-map-marker"></i> <?php echo $business[0]->BUSINESS_PHYSICAL_ADDRESS ;?></span>
                                                <br />
                                                
                                                    <small>Rating</small><br />
                                                    <?php echo $this->rating_model->get_review_stars_img($rating);?>    
                                                
                                            </td>
                                        </tr> 
                          
                                    </table>
                                    <p>Hi *|name|* Here are your latest business statistics from the my.na platform for <?php echo date('M Y');?>.
                                        To view the full report online please follow the link below. If you did not receive an attachment please inform us.
                                    </p>
                                    <p class="text-center">
                                        <a href="<?php echo site_url('/');?>business/analytics/<?php echo $bus_id;?>/MONTH/" class="btn">VIEW REPORT ONLINE</a>
                                    </p>    
                                    <p>&nbsp;</p>
                                    <table class="table table-striped">
                                        <thead>
                                                <tr>
                                                  <th></th>
                                                  <th>Click Through Rate(CTR) %</th>
                                                  <th>Telephone Clicks</th>
                                                  <th>Cellphone Clicks</th>
                                                  <th>Fax Clicks</th>
                                                  <th>Website Clicks</th>
                                                </tr>
                                         </thead>
                                         <tbody>
                                                <tr>
                                                  <td></td>
                                                  <td><?php echo round($CTR, 2);?>%</td>
                                                  <?php $this->members_model->get_total_clicks($bus_id);?>
                                                  <td>Coming Soon</td>
                                                </tr>        
                                         </tbody> 
                                    </table>

                                    <p>&nbsp;</p>
                                    <?php echo $this->rating_model->show_reviews_short_email($bus_id);?>

                                    <p>If you received this email and believe it was not meant to be delivered to you please
                                        inform us via email.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">&nbsp;

                                </td>
                            </tr>
                        </table>
                        <!-- // END BODY -->
                    </td>
                </tr>
                <tr>
                    <td valign="top" style="padding-top:0;margin:0;padding:0;background-color:#000"></td>
                </tr>
                <tr>
                    <td align="center" valign="top">
                        <!-- BEGIN FOOTER // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">

                            <tr>
                                <td valign="top" style="padding:10px;width:40%;" mc:edit="footer_content00">
                                    <a href="https://twitter.com/MyNamibia"><img src="<?php echo site_url('/')?>images/icons/twitter_white.png" class="footer_icons" alt="Follow Us on Twitter" /></a>
                                    <a href="http://www.facebook.com/mynamibia"><img src="<?php echo site_url('/')?>images/icons/facebook_white.png" class="footer_icons" alt="Friend Us on Facebook" /></a>
                                    <a href="http://www.youtube.com/user/mynamibiatourism"><img src="<?php echo site_url('/')?>images/icons/youtube_white.png" class="footer_icons" alt="View Our Videos" /></a>
                                </td>
                                <td valign="top" class="footerContent"  style="padding:10px;width:60%;" mc:edit="footer_content01">
                                    <em>Copyright &copy; <?php echo date('Y');?> My Namibia &trade;, All rights reserved.</em>
                                    <br />

                                    <strong>Our mailing address is:</strong>
                                    <br />
                                    info@my.na
                                </td>
                            </tr>


                            <tr>
                                <td colspan="2" valign="top" class="footerContent" style="padding-top:0;" mc:edit="footer_content02">
                                    You have received this email because you have registered on the My Namibia platform to help
                                    you connect with Namibia.  If you really want to change this and unsubscribe from the updates
                                    please click on the unsubscribe link at the bottom of this email. <br />
                                    This email was sent with your permission from My Namibia, 8 Schinz Street Windhoek Namibia - +264 61 231 006
                                </td>
                            </tr>

                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" >

                            <tr>
                                <td valign="top">
                                    <img src="<?php echo site_url('/')?>images/bground/email_bottom_shadow3.jpg?v1" style="max-width:640px;max-height:252px" class="columnImage" alt="Download images to view"/>
                                </td>
                            </tr>

                        </table>


                        <!-- // END FOOTER -->

                    </td>
                </tr>

            </table>

            <!-- // END TEMPLATE -->
        </td>
    </tr>
</table>
</center>

</body>
</html>