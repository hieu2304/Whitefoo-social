( function( $ ) {
    $( document ).ready( function() {
        $('.likepost').click(function(e){
            e.preventDefault();
            // Khai báo biến objPost để thực hiện nhiều về sau.
            var objPost = $(this);
            // Kiểm tra class like. Nếu đã liked thì thoát.
            if(objPost.hasClass('liked')) return false;
            // Dữ liệu muốn đưa lên để xử lý ajax.
            var data = {
                action: 'fronted_likepost',
                security : ajax_likepost.security,
                post_id: objPost.data('id')
            };
            // Bắt đầu xử lý ajax với kiểu dữ liệu là json
            $.post(ajax_likepost.ajaxurl, data, function(response) {
                /**
                Thay đổi số like vào thẻ a.
                Thêm class liked để biết rằng người dùng đã like bài viết và không thực hiện like nữa.
                Thay đổi title cho thẻ a.
                */
                objPost
                    .text(response.count)
                    .addClass('liked')
                    .attr('title', objPost.data('already'));
            }, 'json');
        });
    });
} )( jQuery );