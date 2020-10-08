$(document).ready(function(){
    $('.sidebar').height($(window).height()-56);

    $('.to-edit-inline').click(function(e){
        e.preventDefault();
        var inlineedit = $(this).closest('.inline-edit');
        inlineedit.find('.data-box').hide();
        inlineedit.find('.input-box').show();
    });
    $('.to-cancel-inline').click(function(e){
        e.preventDefault();
        var inlineedit = $(this).closest('.inline-edit');
        inlineedit.find('.input-box').hide();
        inlineedit.find('.data-box').show();
    });

    $('#show-menu').click(function(){
        var header = $('#header');
        if (header.hasClass('active')){
            header.removeClass('active');
        } else {
            header.addClass('active');
        }
    });
    $('#show-sidebar').click(function(){
        var header = $('#sidebar-app');
        if (header.hasClass('active')){
            header.removeClass('active');
        } else {
            header.addClass('active');
        }
    });

    $('.scrollTo').click(function (e) {
        e.preventDefault();
        var ancla = $(this).attr('href');
        var ubicacion = $(ancla).offset();
        $("html, body").animate({scrollTop: ubicacion.top - 80}, "slow");

        $(ancla).addClass('focus');
        setTimeout(function(){
            $(ancla).removeClass('focus');
        },1000);
    });

    $('#BackTop-action').click(function (e) {
        e.preventDefault();
        $("html, body").animate({scrollTop: 0}, "slow");
    });

    $(document).scroll(function () {
        var winHeight = $(window).height();
        var numScroll = $(document).scrollTop();
        var numToStop = $(document).height() - $('footer').height() - winHeight;
        if (numScroll > (winHeight - 600)) {
            $('#BackTop').slideDown();
            if (numToStop <= numScroll) {
                $('#BackTop').addClass('in');
            } else {
                $('#BackTop').removeClass('in');
            }

        } else {
            $('#BackTop').slideUp();
        }
    });
});