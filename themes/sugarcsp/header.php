<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Sugar CS Portal Home</title>

    <link rel="stylesheet" type="text/css" href="css/<?php echo $css; ?>.css" media="screen" />
    <!--[if lte IE 6]>
        <link rel="stylesheet" type="text/css" href="css/<?php echo $ie_css; ?>.css" media="screen" />
    <![endif]-->
    <script type="text/javascript" src="js/<?php echo $js; ?>.js"></script>
	<script type="text/javascript">
            $(document).ready(function(){
                $('.faqAnswer').hide(); //Hide/close all containers
                //$('.faqQuestion:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container
                //On Click
                $('.faqQuestion').click(function(){
                    if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
                            $('.faqQuestion').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
                            $(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
                    }else{
						$('.faqAnswer').slideUp();
						$('.faqQuestion').removeClass('active');
					}
                    return false; //Prevent the browser jump to the link anchor
                });
            });
    function clearDefault(el) {
    if (el.defaultValue==el.value) el.value = ""
    }
    </script>
</head>
<body>
<div id="pageWrapper">