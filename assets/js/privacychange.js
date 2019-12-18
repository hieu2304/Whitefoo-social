$(document).on("click", ".visibility-picker button", function () {
    var selvalue = $(this).val();
    var postid = $(this).parent().attr("postid");
    $.ajax({
        url:"init.php",
        method:"POST",
        data:{privacyvalue:selvalue, postid:postid},
        cache:false,
        success:function() {
            var visibility = $("[value='" + postid + "'].post-visibility");
            visibility.removeClass(function (index, className) {
                return (className.match (/(^|\s)fa*\sfa-\S+/g) || []).join(' ');
            });
            if (selvalue == "0")
                visibility.addClass('fa fa-globe');
            else if (selvalue == "1")
                visibility.addClass('fas fa-user-friends');
            else if (selvalue == "2")
                visibility.addClass('fa fa-lock');
        }
    });
})