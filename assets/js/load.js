$(document).ready(function(){
    // to fade in on page load
    $("#content").css("display", "none");
    $("#content").fadeIn(200); 
    // to fade out before redirect
    $('a').click(function(e){
        redirect = $(this).attr('href');
        e.preventDefault();
        $('#content').fadeOut(200, function(){
            document.location.href = redirect
        });
    });
})