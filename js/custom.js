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
                email:{
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    rangelength: [8,16]
                },
                password_confirm:{
                    equalTo: '#password'
                }
            },//end of rules
            messages: {
                password_confirm: {
                    equalTo: "Password not match"
                }
            } //end of message
    });
    
    $('#regForm').submit(function(){
        var formData = $(this).serialize();
        var url="index.php?module=registration&action=submit";
        $.post(url,formData,processData);

        function processData(data){
            var dataerr = my_strip('<div id="pageWrapper">', '</div>', data);
//alert(dataerr);
            if (dataerr.match("Error:")){
//                alert(dataerr);
                $(".err").html("<div class='errorMsg mTop15' >" + dataerr + "</div>");
            }else{
                location.href='index.php?module=Users&action=Login';
            }
        }
        return false;
    });

    $('#forgot_password').submit(function(){
        var formData = $(this).serialize();
        var url="index.php?module=Users&action=forgot_password";
        $.post(url,formData,processData);

        function processData(data){
//            var dataerr = my_strip('<div id="pageWrapper">', '</div>', data)
//                alert(dataerr);
                location.href='index.php?module=Users&action=Login';
        }
        return false;
    });

    $('#new_password').submit(function(){
        var formData = $(this).serialize();
        var url="index.php?module=registration&action=submit";
        $.post(url,formData,processData);

        function processData(data){
//            var dataerr = my_strip('<div id="pageWrapper">', '</div>', data);
                location.href='index.php?module=Users&action=Login';
        }
        return false;
    });

});

//search
function clearDefault(el) {
    if (el.defaultValue==el.value) el.value = ""
}

function strstr (haystack, needle, bool) {
    var pos = 0;

    haystack += '';
    pos = haystack.indexOf(needle);
    if (pos == -1) {
        return false;
    } else {
        if (bool) {
            return haystack.substr(0, pos);
        } else {
            return haystack.slice(pos);
        }
    }
}

function my_strip(start, end, data){
        var data = strstr(data, start, false);
        var data = strstr(data, end, true);
        var dataret2 = data.substr(start.length);
        return dataret2;
}