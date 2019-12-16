$('.scroll-button').click(function() {
    $('html, body').animate({
        scrollTop: eval($('#' + $(this).attr('target')).offset().top)
    }, 700);
});