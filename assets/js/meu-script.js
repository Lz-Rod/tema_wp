jQuery(document).ready(function($) {
    $('#categorias a').on('click', function(e) {
        e.preventDefault();

        var cat_id = $(this).data('cat-id');

        $.ajax({
            type: 'POST',
            url: ajax_params.ajax_url,
            data: {
                action: 'filtrar_posts',
                cat_id: cat_id
            },
            success: function(response) {
                var html = '';
                $.each(response.data, function(index, post) {
                    html += '<div class="post">';
                    html += '<h2>' + post.title + '</h2>';
                    html += '<div class="content">' + post.content + '</div>';
                    html += '</div>';
                });

                $('#posts-container').html(html);
            }
        });
    });
});
