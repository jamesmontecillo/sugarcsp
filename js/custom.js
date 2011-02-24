$(document).ready(function(){
    $('.faqAnswer').hide();
    $('.faqQuestion').click(function(){
        if( $(this).next().is(':hidden') ) {
                $('.faqQuestion').removeClass('active').next().slideUp();
                $(this).toggleClass('active').next().slideDown();
        }else{
                $('.faqAnswer').slideUp();
                $('.faqQuestion').removeClass('active');
        }
        return false; //end FAQ slider
    });

    $('.showNote').hide();
    $('.noteCtn').click(function(){
        if( $(this).next().is(':hidden') ) {
                $(this).toggleClass('active').next().slideDown();
        }else{
                $(this).toggleClass('active').next().slideUp();
        }
        return false; //end note
    });
	
	$('.forgotP').hide();
    $('.forgotLink').click(function(){
        if( $(this).next().is(':hidden') ) {
                $(this).toggleClass('active').next().slideDown();
        }else{
                $(this).toggleClass('active').next().slideUp();
        }
        return false; //end note
    });

    //POPUP START
    $('a.poplight[href^=#]').click(function() {
        var popID = $(this).attr('rel');
        var popURL = $(this).attr('href');
        var query= popURL.split('?');
        var dim= query[1].split('&');
        var popWidth = dim[0].split('=')[1];

        $('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="#" class="close"><img src="css/images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>');

        var popMargTop = ($('#' + popID).height() + 80) / 2;
        var popMargLeft = ($('#' + popID).width() + 80) / 2;

        $('#' + popID).css({
            'margin-top' : -popMargTop,
            'margin-left' : -popMargLeft
        });

        //Fade in Background
        $('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
        $('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies

        return false;
    });

    //Close Popups and Fade Layer
    $('a.close, #fade').live('click', function() {
        $('#fade , .popup_block').fadeOut(function() {
            $('#fade, a.close').remove();  //fade them both out
        });
        return false;
    });

    $("#regForm").validate({
            rules: {
            password_confirm:{equalTo: '#password'}
            },//end of rules
            messages: {
            password_confirm: {equalTo: "Password not match"}
            } //end of message
    });

});

//search
function clearDefault(el) {
    if (el.defaultValue==el.value) el.value = ""
}