$(document).ready(function() {
    var limit = 5;
    var start = 0;
    var action = 'inactive';
    function loadMore(limit, start) {
        $.ajax({
            url:"includes/loadnewfeed.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            success:function(data) {
                $('#newfeed_content').append(data);
                if(data == '') {
                    $('#spinner').remove();
                    action = 'active';
                }
                else {
                    $('#spinner').html('<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg><script type="text/javascript" src="assets/js/lazyload.js"></script>');
                    action = 'inactive';
                }
            }
        });
    }

    if(action == 'inactive')
    {
        action = 'active';
        loadMore(limit, start);
    }

    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() > $('#content').height() && action == 'inactive')
        {
            action = 'active';
            start = start + limit;
            setTimeout(function() {
            loadMore(limit, start);
        }, 500);
        }
    });
})