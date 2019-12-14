$(document).ready(function()
{
    //get the URL when the page just loaded
    var profileID = -1;
    var page = 'main';
    var pageURL = window.location.href;
    var pagetype = pageURL.indexOf('personalpage.php');
    //if personal page
    if(pagetype>1)
    {
        page = 'personal';
        var userIDposition = pageURL.indexOf('?id=');
        //if this page is not your own page (other's personal page)
        if(userIDposition>1)
        {
            profileID = Number(pageURL.substring(userIDposition+4));
        }
    }
    var limit = 5;
    var start = 0;
    var action = 'inactive';
    function loadMore(limit, start) {
        $.ajax({
            url:"includes/loadnewfeed.php",
            method:"POST",
            data:{limit:limit, start:start, page:page, profileID:profileID},
            cache:false,
            success:function(data) {
                $('#newfeed_content').append(data);
                if(data == '') {
                    $('#spinner').remove();
                    action = 'active';
                }
                else {
                    $('#spinner').html('<svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg>');
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