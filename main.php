<?php include( 'i_lang_' . $_SESSION[ZS][LANG] . '.php' ); ?>


<!doctype html>


<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->


<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->


<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->


<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->


<head>


	<meta charset="utf-8">


	<title><?php mt_title( $controller_name ); ?></title>


        <meta name="keywords" content="<?php


        mt_keywords();


    ?>" />


	<meta name="description" content="<?php mt_description(); ?>">


	<meta name="author" content="">


	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<link rel="stylesheet" href="<?php b(); ?>static/css/<?php echo tmplStr( 'style' ); ?>.css">




	<script src="static/js/libs/modernizr-1.7.min.js"></script>


	


	<link href="plugins/uploadify/uploadify.css" type="text/css" rel="stylesheet" />


	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


	<script type="text/javascript" src="plugins/uploadify/swfobject.js"></script>


	<script type="text/javascript" src="plugins/uploadify/jquery.uploadify.v2.1.4.min.js"></script>


	<script type="text/javascript">





		function post_upload_from_www() {


		


		    if ( isBannedByIP || isBannedBy_u_id ) {


		        alert( "you're banned" );


		        return false;


		    }


		    


		    $("body").css("cursor", "progress");


		    


		    var s_label_values = Array();


		    var slv_count = 0;


		  


            $('.focusOn').each(function(i) {


                if ( $(this).attr('id') == 's_label' ) {


                    s_label_values[ slv_count ] = $(this).attr('value');


                    slv_count++;


                }


            });


            $('.focusOff').each(function(i) {


                if ( $(this).attr('id') == 's_label' ) {


                    s_label_values[ slv_count ] = $(this).attr('value');


                    slv_count++;


                }


            });


            


 $.post("dl",


           {


               s_label_values: s_label_values,


               save : 'save'


           },


           function(data){





            $("body").css("cursor", "default");


               //alert("[TEST] Data loaded: " + data);





               if ( data == 0 ) { // success





                      var select_album_id       = document.getElementById( 'album_id'     );


                      var input_album_name      = document.getElementById( 'album_name'   );


                      var checkbox_is_private   = document.getElementById( 'is_private'   );





                      var a_name = '';


                      var is_private = 'public';


                      if ( checkbox_is_private.checked ) is_private = 'private';


                      if ( input_album_name.value != '' ) {


                          a_name = input_album_name.value;


                          location.replace( 'afterupload/'+u_id+'/add_to_new_album:' + a_name + '/' + is_private );


                      }


                      else if ( select_album_id.selectedIndex > 0 ) {


                          a_name = select_album_id.options[ select_album_id.selectedIndex ].text;


                          location.replace( 'afterupload/'+u_id+'/add_to_existing_album:' + a_name + '/' + is_private );


                      } else


                          location.replace( 'afterupload/'+u_id+'/no_album:-' + '/' + is_private );


                  } else {


                      if (data == 350) alert( er_uploaded_image_is_too_big + ': ' + multi_upload_max_size+' MB' );


                      else alert( 'Upload error ('+data+')' );


                  }





       });


                  


			return false;


        }	


	


    function www_upload_links_validate()


    {


        var ok = true;


		$('.www_upload_inputs').each(function(e){


            var val = $(this).val();


            var parts = val.split( '.' );


              //alert( parts[ parts.length-1 ] );


            var i_file_ext = parts[ parts.length-1 ];


            if (


                   (i_file_ext != 'jpg') && (i_file_ext != 'jpeg') && (i_file_ext != 'gif') && (i_file_ext != 'png') && (i_file_ext != 'bmp')


                   &&


                   (i_file_ext != 'JPG') && (i_file_ext != 'JPEG') && (i_file_ext != 'GIF') && (i_file_ext != 'PNG') && (i_file_ext != 'BMP')


               )


                ok = false;


		});


		


		return ok;


    }


    


    function check_http() {


        var ok = true;


		$('.www_upload_inputs').each(function(e){


            var val = $(this).val();


            //alert( val.search( 'http://' ) );


            if ( val.search( 'http://' ) == -1 )


                ok = false;


		});


		


		return ok;


    }


	


	function love_it_fadeIn() {


        $('#span_love_it').fadeIn( 2500 );


    }


    


    function encode_utf8( s ) {


        return unescape( encodeURIComponent( s ) );


    }





    function decode_utf8( s ) {


        return decodeURIComponent( escape( s ) );


    }


	


	$(document).ready(function() {


	    var active_tab = 1; // tab_computer





        var checkbox_add_to_album = document.getElementById( 'add_to_album' );


        var checkbox_create_album = document.getElementById( 'create_album' );





        var select_album_id       = document.getElementById( 'album_id'     );


        var input_album_name      = document.getElementById( 'album_name'   );


        


        var checkbox_is_private   = document.getElementById( 'is_private'   );


        


	  	jQuery('#file_upload').uploadify({


		    'uploader'  : 'plugins/uploadify/uploadify.swf',


		    'script'    : 'plugins/uploadify/uploadify.php?u_id=' + u_id,// + '&for_uploadify_album_id=' + for_uploadify_album_id,


    		'cancelImg' : 'plugins/uploadify/cancel.png',


	    	'folder'    : 'photos',


	    	// 20120810:


	    	'fileDesc'  : 'Image Files',


    		'fileExt'   : '*.jpg;*.jpeg;*.gif;*.png;*.bmp;*.JPG;*.JPEG;*.GIF;*.PNG;*.BMP',


	    	'buttonText': selectImagesText + '...', //'Select images...',


	    	'auto'      : false,


		    'multi'     : true,


		    'sizeLimit' : multi_upload_max_size*1024*1024,


		    'queueSizeLimit' : multi_upload_max_one_time,


            'onAllComplete': function(event, data) {


                                 var a_name = '';


                                 var is_private = 'public';


                                 if ( checkbox_is_private.checked ) is_private = 'private';


                                 if ( input_album_name.value != '' )


                                 {


                                     a_name = input_album_name.value;


                        //alert(a_name);


    	                             location.replace( 'afterupload/'+u_id+'/add_to_new_album:' + a_name + '/' + is_private + '?a_name=' + a_name );


                                 }


                                 else if ( select_album_id.selectedIndex > 0 )


                                 {


                                     a_name = select_album_id.options[ select_album_id.selectedIndex ].text;


    	                             location.replace( 'afterupload/'+u_id+'/add_to_existing_album:' + a_name + '/' + is_private );


    	                         } else


    	                             location.replace( 'afterupload/'+u_id+'/no_album:-' + '/' + is_private );


                             },


            'onError': function (a, b, c, d) { 


                           if (d.status == 404)


                               alert('Could not find upload script. Use a path relative to: '+'<?= getcwd() ?>');


                           else if (d.type === "HTTP")


                               alert('error '+d.type+": "+d.status);


                           else if (d.type ==="File Size")


                               alert(c.name+' '+d.type+' - '+er_uploaded_image_is_too_big+': ' + multi_upload_max_size+' MB');


                           else


                               alert('error '+d.type+": "+d.text);


                       }


	    });


	    


	    $('#tab_computer').click(function () {


	        active_tab = 1;


		});	


	    


	    $('#tab_www').click(function () {


	        active_tab = 2;


		});	


		


		$('#img_upload').click(function () {


		


		    if ( isBannedByIP || isBannedBy_u_id ) {


		        alert( "you're banned" );


		        return false;


		    }


		    


		    switch ( active_tab ) {


		        case 1:


                    $('#file_upload').uploadifyUpload();


		        break;


		        case 2:


                    var www_upload_inputs_ok = www_upload_links_validate();


        		    if ( check_http() ) {


		                if ( www_upload_inputs_ok ) {


                            post_upload_from_www();


                        } else


                            alert( er_text_at_least );


                    } else


                        alert( er_text_please_enter );


                        


		        break;


            }


    		return false;


		});	





		$('#album_id').change(function () {


		


		    var album_name = $('#album_name').get(0);


		


		    var album_id = $('#album_id').get(0);


		    if ( album_id.selectedIndex > 0 ) {


		        //$('#album_name').fadeOut(500);


		        $('#div_label_album_name').fadeTo(500, 0.5);


		        album_name.disabled = true;


		    }


		    else {


		        //$('#album_name').fadeIn(500);


		        $('#div_label_album_name').fadeTo(500, 1);


		        album_name.disabled = false;


		    }


		        


		});


        


		$('#album_name').keyup(function () {


		


		    var album_id = $('#album_id').get(0);


		    var album_name = document.getElementById( 'album_name' );


            if ( album_name.value != '' ) {


    		    album_id.disabled = true;


	    	    $('#div_label_album_id').fadeTo(500, 0.5);


		    }


		    else {


    		    album_id.disabled = false;


	    	    $('#div_label_album_id').fadeTo(500, 1);


		    }


		});


        


        $('#div_album_id').mousemove(function () {





            if ( !user_logged )


                $('#div_127').slideDown(750);


		


		});


		


        var x=$("#fea12").offset();


        if ( whatimglist == 1 ) {


		    try {


		        setTimeout( love_it_fadeIn(), 1000 );


		    } catch(e) {


		        love_it_fadeIn();


            }


		}


		else


		    $('#span_love_it').show();


        $('#span_love_it').offset( { left: x.left + $('#fea12').width() +  12 } );


        


        $('#id_flr').css( 'display', "none" );


        $('#id_flr').css( 'visibility', 'visible' );


        


        $('#id_flr').fadeIn( 1000 );


	});


	


</script>


<script src="http://101xxl.com/js/Slider/modernizr.custom.js"></script>

<script src="http://101xxl.com/js/Slider/jquery.cbpFWSlider.min.js"></script>

<script src="http://101xxl.com/js/Slider/jquery.mosaicflow.min.js"></script>

<script language="javascript" type="text/javascript">
			$( function() {
				

				$( '#cbp-fwslider' ).cbpFWSlider();

			} );
		</script>


<script type="text/javascript">

$(document).ready(function(){


    $(".slidingDiv").hide();
	$(".show_hide1").show();
	
	$('.show_hide1').click(function(){
	$(".slidingDiv").slideToggle();
	});

});

</script>



</head>


<?php





    if ( isset($_SESSION[ZS][U_ID]) ) {


        $user_id = $_SESSION[ZS][U_ID];


        echo "<SCRIPT LANGUAGE='Javascript'> var user_logged = true; var u_id = $user_id; </SCRIPT>";


    } else


        echo "<SCRIPT LANGUAGE='Javascript'> var user_logged = false; var u_id = 0; </SCRIPT>";


        


    if ( isset($_GET['whatimglist']) ) $whatimglist = $_GET['whatimglist']; else $whatimglist = 3;


    echo "<SCRIPT LANGUAGE='Javascript'> var whatimglist = $whatimglist; </SCRIPT>";


    


    echo "<SCRIPT LANGUAGE='Javascript'> var multi_upload_max_one_time = " . multi_upload_max_one_time . "; var multi_upload_max_size = " . multi_upload_max_size . "; </SCRIPT>";


    


    echo "<SCRIPT LANGUAGE='Javascript'> var er_uploaded_image_is_too_big = '" . lg(9100, $lg) . "'; </SCRIPT>";


    


    echo "<SCRIPT LANGUAGE='Javascript'> var isBannedByIP = " . $isBannedByIP . "; var isBannedBy_u_id = " . $isBannedBy_u_id . " </SCRIPT>";


    


    $select_images_text   = lg('select_images', $lg);


    echo "<SCRIPT LANGUAGE='Javascript'> var selectImagesText     = '$select_images_text'; </SCRIPT>";


    $er_text_at_least     = lg(140, $lg);


    echo "<SCRIPT LANGUAGE='Javascript'> var er_text_at_least     = '$er_text_at_least'; </SCRIPT>";


    $er_text_please_enter = lg(141, $lg);


    echo "<SCRIPT LANGUAGE='Javascript'> var er_text_please_enter = '$er_text_please_enter'; </SCRIPT>";


         


?>




<body class="homepage">




<!--<p>I <span data-tooltip=", really" class="tooltip">really</span> like pie.</p>​-->





	<div id="container">


	


		<header id="head" role="banner"><div class="h-bg"></div>


			<div class="inner">


			    <!----------------------------------->


			    <?php include( 'i_echo_logo.php' ); ?>


			    <!-------------------------------------------->


			  <ul class="navigation">
     	<li><a href="#">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Contact Us</a></li>
     </ul>
      
      <!-------------------------------------------->
      <a href="http://101xxl.com/signup" class="forgot">Sign up</a>
      <a class="login show_hide1">Log in</a>
      
      <div class="user-panel slidingDiv"> 
      



	    			<?php include( 'i_echo_form_login.php' ); ?>

	
      
        
      </div>
      <!-- .user-panel --> 


			    <!-------------------------------------------->


			





				<nav id="nav">


					<ul>


						<li class="start">


							<a href=""><?php echo domain; ?></a>


						</li>


						<li>


							<span><?php l(129, $lg); ?></span>


						</li>


					</ul>


		    	    <!------------------------------------------>


					<?php include( 'i_echo_form_search.php' ); ?>


		    	    <!------------------------------------------>


				</nav>


			</div><!-- .inner -->


		</header><!-- #head -->

 <section role="main" class="header">
    <div class="inner">
      <h2>COME AND SHARE YOUR LIFE !</h2>
      <ul>
        <li><a><img src="static/images/header-list-bg1.png" width="100" height="100" alt="list"> <span>Create Profile</span></a></li>
        <li><a><img src="static/images/header-list-bg2.png" width="100" height="100" alt="list"> <span>Create Album</span></a></li>
        <li><a><img src="static/images/header-list-bg3.png" width="100" height="100" alt="list"> <span>Share Photos</span></a></li>
        <li><a><img src="static/images/header-list-bg4.png" width="100" height="100" alt="list"> <span>Earn Money</span></a></li>
      </ul>
      <a href="#"><img src="static/images/lets-start-button.png" width="223" height="64" alt="Lets Start"></a> </div>
	  <p style="font-size:14px;color:#313640;margin-top:65px;">© All images are copyrighted by their respective authors.</p>
  </section>
<section id="page" role="main">
    <div class="inner"> 
      
     
      <!--------------------------------------------->
      
      <div id="content">
        <div id="cbp-fwslider" class="cbp-fwslider">
          <ul>
            <li>
            	<div class="slider-content"> 
                	<div class="left-col">
                    	<h3>Life. Shared.</h3>
                    	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                      </p>   <br>
                   
                      <input type="submit" value="Learn More">
                      
                    </div>
                	<div class="right-col">
                    	<h3>Start Now</h3>
                        <hr>
                        
                        <ul>
                        <li>unlimited Space</li>
                        <li>unlimited Image Upload</li>
                        <li>No Ads</li>
                        <li>Customer Support</li>
                        <li>unlimited Space</li>
                        <br>

                        </ul>
                        <input type="submit" value="Get Started">
                    
                    </div>
                </div>
            
            
            
            </li>
            <li>
            
            	<div class="slider-content"> 
                	<div class="left-col">
                    	<h3>Life. Shared. 2</h3>
                    	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                      </p>   <br>
                   
                      <input type="submit" value="Learn More">
                      
                    </div>
                	<div class="right-col">
                    	<h3>Start Now 2</h3>
                        <hr>
                        
                        <ul>
                       
                        <li>No Ads</li>
                        <li>Customer Support</li>
                        <li>unlimited Space</li>
                        </ul>
                        <input type="submit" value="Get Started">
                    
                    </div>
                </div>
            
            
            </li>
            <li>
            
            	<div class="slider-content"> 
                	<div class="left-col">
                    	<h3>Life. Shared. 3</h3>
                    	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                        when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                      </p>   <br>
                   
                      <input type="submit" value="Learn More">
                      
                    </div>
                	<div class="right-col">
                    	<h3>Start Now 3</h3>
                        <hr>
                        
                        <ul>
                        <li>unlimited Space</li>
                        <li>unlimited Image Upload</li>
                       
                        </ul>
                        <input type="submit" value="Get Started">
                    
                    </div>
                </div>
            
            
            </li>
            
          </ul>
        </div>
        <!-- #main-content --> 
        
      </div>
      <!-- #content --> 
      
    </div>
    <!-- .inner --> 
    
  </section>
  <section class="text_panel" role="main">
    <div class="gallery">
    	
        
        <div class="mosaicflow" data-item-height-calculation="attribute">
        
        
		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img1.jpg" width="240" height="230" alt="Img1"></a>
			<p>Dessi the Dachshund</p>
		</div>
        
        

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img2.jpg" width="240" height="320" alt="Img1"></a>
			<p>Tsiri on Baltic Sea</p>
		</div>

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img3.jpg" width="240" height="159" alt="Img1"></a>
			<p>Ciyar the Saluki</p>
		</div>

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img4.jpg" width="240"  height="238"alt="Img1"></a>
			<p>Tsiri Having Fun by the Sea</p>
		</div>

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img5.jpg" width="240" height="357" alt="Img1"></a>
			<p>Dessi Meets the Sea</p>
		</div>

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img6.jpg" width="240" height="159" alt="Img1"></a>
			<p>Tsiri the Saluki</p>
		</div>

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img7.jpg" width="240" height="159" alt="Img1"></a>
			<p>Dessi on a Waterfall</p>
		</div>

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img8.jpg" width="240" height="159" alt="Img1"></a>
			<p>Dessi in Dandelion Field</p>
		</div>

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img9.jpg" width="240" height="159" alt="Img1"></a>
			<p>New Year Postcard from Tsiri and Ciyar</p>
		</div>

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img10.jpg" width="240" height="358" alt="Img1"></a>
			<p>Beautiful Afghan Hound Girl</p>
		</div>
        
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img11.jpg" width="240" height="156" alt="Img1"></a>
			<p>Beautiful Afghan Hound Girl</p>
		</div>
        
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img12.jpg" width="240" height="359" alt="Img1"></a>
			<p>Beautiful Afghan Hound Girl</p>
		</div>
        
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img13.jpg" width="240" height="359" alt="Img1"></a>
			<p>Beautiful Afghan Hound Girl</p>
		</div>
        
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img14.jpg" width="240" height="352" alt="Img1"></a>
			<p>Beautiful Afghan Hound Girl</p>
		</div>
        
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img15.jpg" width="240" height="179" alt="Img1"></a>
			<p>Beautiful Afghan Hound Girl</p>
		</div>
        
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img16.jpg" width="240" height="234" alt="Img1"></a>
			<p>Beautiful Afghan Hound Girl</p>
		</div>
        
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img17.jpg" width="240" height="144" alt="Img1"></a>
			<p>Beautiful Afghan Hound Girl</p>
		</div>
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img11.jpg" width="240" height="156" alt="Img1"></a>
			<p>Beautiful Afghan Hound Girl</p>
		</div>
        
               
               
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img1.jpg" width="240" height="230" alt="Img1"></a>
			<p>Dessi the Dachshund</p>
		</div>

		<div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img2.jpg" width="240" height="320" alt="Img1"></a>
			<p>Tsiri on Baltic Sea</p>
		</div>
		
        <div class="mosaicflow__item">
			<a href="#"><img src="static/images/mosi/gallery-img8.jpg" width="240" height="159" alt="Img1"></a>
			<p>Dessi in Dandelion Field</p>
		</div>

		
	</div>
    
    
    
    
    </div>
  </section>
  
  <section class="sign_panel" role="main">
    <div class="inner">
      <p><a href="#"><span>Sign Up to</span> <img src="static/images/logo.a.png" width="188" height="27" alt="logo"></a></p>
      <a href="#"><img src="static/images/lets-start-button.png" width="223" height="64" alt="Lets Start"></a> </div>
</section>
		


		<section id="page" role="main">


			<div class="inner">





				<?php


    	    		if ( $er_log != 0 ) {


        	    		echo '<div style="width: 800px; margin: auto; padding-top: 48px;"><div class="flash-msg f-error">'. lg(9000, $lg) .'</div></div>';


		    	    }


    	    		if ( $er != 0 ) {


        	    		echo '<div class="flash-msg f-error">'. erText( $er ) .'</div>';


	        		}


	    		?>


    	


    		    <!----------------------------------------->


                <?php include( 'i_echo_ads_728_90.php' ); ?>


    		    <!--------------------------------------------->


				<div id="content">


					<aside id="sidebar">


						<div class="box b-upload">


							<div class="content">


								<form action="index_submit" method="post" enctype="multipart/form-data" accept-charset="utf-8">


									<fieldset>


										<div class="tabs">


											<a href="#" class="current computer" id="tab_computer">


												<strong><?php l(120, $lg); ?></strong>


											</a>


											<a href="#" class="www" id="tab_www">


												<strong><?php l(121, $lg); ?></strong>


											</a>


										</div>


										<div class="tabs-content">


											<section>


												<div class="field f-wide">


												    <!--


													<input type="file" name="s_label[]" value="" id="s_label" />


													-->


                                                    <input type="file" id="file_upload" name="file_upload" />


                                                    <input type="hidden" id="testpost" name="testpost" value="testpost" />


													<!--


													<a href="#" class="add-new-label">Add new label</a>


													-->


												


													<?php


													    /*


													    echo '<div style="width: 90%; text-align: right;">'


													        . html::anchor( 'simpleupload', lg(129, $lg) )


													        . '</div>'


                                                            ;


                                                            */


                                                    ?>


												


												</div>


											</section>


											<section style="display: none;">


												<div class="field f-wide">


													<input type="text" name="s_label" value="" id="s_label" class="www_upload_inputs" />


													<a href="#" class="add-new-label"><?php l(126, $lg); ?></a>


												</div>


											</section>


<?php if ( !isset($_SESSION[ZS][U_ID]) ) { ?>    											  


    											  <div id="div_127" style="display: none; padding-left: 12px; padding-right: 12px; padding-bottom: 12px; color: #FF6600; font-weight: bold; text-align: center;">


    											  <?php l(127, $lg); ?>


    											  </div>


<?php } ?>    											  


    											  


												<div class="field f-transform" id="div_label_album_id">


												    <!--


													<input type="checkbox" name="add_to_album" value="" id="add_to_album" class="add_to_album" style="visibility: hidden;" />


													-->


													<label for="add_to_album"><?php l(122, $lg); ?></label>


													


<?php if ( !isset($_SESSION[ZS][U_ID]) ) { ?>    											  


												  <div id="div_album_id" title="<?php l(127, $lg); ?>">	


<?php } else { ?>    											  


												  <div id="div_album_id">	


<?php } ?>    											  


													<select name="album_id" id="album_id" class="album_id">


														<option value="option1">[ <?php l(128, $lg); ?>... ]</option>


<?php


											          if ( isset($_SESSION[ZS][KL_ID]) )


    											          foreach ( $array_user_albums as $alb ) {


	    										              $i_a_name = $alb['a_name'];


?>


														      <option value="<?php echo $i_a_name; ?>"><?php echo $i_a_name; ?></option>


<?php


                                                          }


?>


													</select>


    											  </div>


    											  


												</div>


												<div class="field f-transform" id="div_label_album_name">


												    <!--


													<input type="checkbox" name="create_album" value="" id="create_album" />


													-->


													<label for="create_album"><?php l(123, $lg); ?></label>


													<input type="text" name="album_name" value="" id="album_name" />


												</div>


												


												<?php


												if ( is_md_ppv_enabled() ) {


												    if ( $st_adult_images_acceptation != 0 )


												        $adult_text = lg(132, $lg);


												    else


												        $adult_text = lg(133, $lg);


                                                ?>


												    <div class="field f-transform">


                                                        <label for="create_album"><?php l(131, $lg); ?></label>


                                                        <a href="ppv/make-money.htm" class="private-info"><?php echo $adult_text; ?></a>


                                                    </div>


												<?php


												}


                                                ?>


												


												<div class="field f-transform last-field">


													<input type="checkbox" name="is_private" value="" id="is_private" />


													<label for="is_private"><?php l(124, $lg); ?></label>


													<div style="padding: 11px;">


													    <a href="whatitmeans" class="single_image" style="background: url(../images/private-info.png) no-repeat right center; color: #7f8a8d; font-size: 11px; font-weight: bold; font-style: italic; text-decoration: none; padding-right: 23px; position: relative;"><?php l(125, $lg); ?>?</a>


													</div>


												</div>


												<div class="foot">


													<span class="filetypes">


														JPG JPEG PNG BMP GIF


													</span>


													<span class="maxsize">


														Max. <?php echo multi_upload_max_size; ?> MB


													</span>


												</div>


												


												<div style="text-align: center; font-size: 16px; font-weight: bold;">


												    <!--


                                                    <a href="javascript:$('#file_upload').uploadifyUpload();">


                                                    -->


                                                    <a href="#" id="img_upload">


                                                    <img id="ttt" src="static/images/upload.button.png" />


                                                    </a>


												</div>


                                                <!-- .submits -->												


										</div>


										<!-- .tabs-content -->


									</fieldset>


								</form>


							</div>


						</div><!-- .upload -->


						


						<?php


						    // ------------------------------------------------


						 //   include( 'i_echo_latest_searches.php' );


						    // ------------------------------------------------



                        ?>


						


					</aside>


					<div id="main-content" class="wide-boxes" style="display:none !important;">


						<div class="box b-featured">


							<div class="head">


								<h2>


								    <!--<a href="?whatimglist=1">-->


									<?php


									    if ( $whatimglist == 1 ) {


                                            echo '<label id="fea12" style="margin-left:   0px; font-size: 14px; font-family: Verdana; cursor: default;">';


                                                l(150, $lg);


                                            echo '</label>';


                                        } else {


                                            echo '<label id="fea12" style="margin-left:   0px; font-size: 14px; font-family: Verdana;"><a style="text-decoration: none;" id="whatimglist_latest" href="?whatimglist=1">';


                                                l(150, $lg);


                                            echo '</a></label>';


                                        }


									    if ( $whatimglist == 2 ) {


                                            echo '<label id="lat12" style="margin-left: 150px; font-size: 14px; font-family: Verdana; cursor: default;">';


                                                l(151, $lg);


                                            echo '</label>';


									    } else {


                                            echo '<label id="lat12" style="margin-left: 150px; font-size: 14px; font-family: Verdana;"><a style="text-decoration: none;" id="whatimglist_latest" href="?whatimglist=2">';


                                                l(151, $lg);


                                            echo '</a></label>';


                                        }


									    if ( $whatimglist == 3 ) {


                                            echo '<label id="ran12" style="margin-left:  50px; font-size: 14px; font-family: Verdana; cursor: default;">';


                                                l(152, $lg);


                                            echo '</label>';


									    } else {


                                            echo '<label id="ran12" style="margin-left:  50px; font-size: 14px; font-family: Verdana;"><a style="text-decoration: none;" id="whatimglist_random" href="?whatimglist=3">';


                                                l(152, $lg);


                                            echo '</a></label>';


                                        }


                                    ?>


									<span id="span_love_it" style="display: none;">love it</span>


								</h2>


							</div><!-- .head -->


							<div id="id_flr" class="content" style="visibility: hidden;">


								<ul>
<?php foreach ( $featured as $r ) {


                                        $i_ph_id    = $r[0];


                                        $i_ph_sv_id = $r['sv_id']; 


                                        $i_filename = $r['ph_filename'];


                                        $i_title    = $r['ph_title'];


                                        if ( isset($i_title) )


                                            if ( $i_title != '' )


                                                $i_title = '"' . $i_title . '" ';


                                        $i_u_login  = $r['u_login'];


                                        $i_views    = $r['ph_views'];


                                        $i_a_name   = $r['a_name'];


                                        if ( $i_a_name == '-' ) $i_a_name_str = ''; else $i_a_name_str = ", album: $i_a_name";


                                        $multiServerFullPath = multiServerFullPath( $i_ph_sv_id );


    									echo '<li>'


				    						.html::anchor( "image/$i_ph_id.html"


                                                , "<span></span><img src='$multiServerFullPath".FOLDER_PHOTOS_THUMB."$i_filename' alt='Image $i_ph_id' />"


			    								, array( 'title' => $i_title.lg('by', $lg)." $i_u_login (".lg('views', $lg).": $i_views)$i_a_name_str" )


                                            )


					    				    .'</li>';


                                    } // foreach


?>


								</ul>


							</div><!-- .content -->


						</div><!-- .box -->


    					<!----------------------------------------->


	    				<?php include( 'i_echo_tags_cloud.php' ); ?>


		    			<!----------------------------------------->


					</div><!-- #main-content -->


				</div><!-- #content -->


			</div><!-- .inner -->


		</section><!-- #page -->


        <!------------------------------------->


        <?php include( 'i_echo_footer.php' ); ?>


        <!------------------------------------->


	</div> <!-- #container -->


    <!---------------------------------------->


    <?php include( 'i_echo_js_bottom.php' ); ?>


    <!---------------------------------------->


    


<script type="text/javascript" src="<?php b(); ?>plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>


<link rel="stylesheet" type="text/css" href="<?php b(); ?>plugins/fancybox/jquery.fancybox-1.3.4.css" media="screen" />


    


<script type="text/javascript">





$(document).ready(function() {





	/* This is basic - uses default settings */


	


	$("a.single_image").fancybox({


		'transitionOut'	:	'elastic',


		'speedIn'		:	600, 


		'speedOut'		:	200, 


		'overlayShow'	:	true


	});


	


	/* Using custom settings */


	


	$("a#inline").fancybox({


		'hideOnContentClick': true


	});





	/* Apply fancybox to multiple items */


	


	$("a.group").fancybox({


		'transitionIn'	:	'elastic',


		'transitionOut'	:	'elastic',


		'speedIn'		:	600, 


		'speedOut'		:	200, 


		'overlayShow'	:	false


	});


	


	$("a.iframe").fancybox({


		'transitionIn'	:	'elastic',


		'transitionOut'	:	'elastic',


		'speedIn'		:	600, 


		'speedOut'		:	200, 


		'width'         :   800,


		'height'        :   600,


		'overlayShow'	:	true


	});


	


	$("a.grouped_elements").fancybox();


	


	//$('.iframe').hide();


	


});





</script>



</body>


</html>


