<?php
// Registrar scripts e estilos
function meu_tema_scripts() {
    wp_enqueue_script('meu-tema-script', get_template_directory_uri() . '/assets/js/meu-script.js', array('jquery'), '1.0', true);
    wp_localize_script('meu-tema-script', 'ajax_params', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'meu_tema_scripts');

// AJAX para filtrar posts por categoria
function filtrar_posts_por_categoria() {
    $cat_id = $_POST['cat_id'];
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'post',
        'cat' => $cat_id
    );

    $posts = get_posts($args);

    $response = array();
    foreach ($posts as $post) {
        $response[] = array(
            'title' => get_the_title($post->ID),
            'content' => apply_filters('the_content', $post->post_content)
        );
    }

    wp_send_json_success($response);
}
add_action('wp_ajax_filtrar_posts', 'filtrar_posts_por_categoria');
add_action('wp_ajax_nopriv_filtrar_posts', 'filtrar_posts_por_categoria');

// Registrar endpoints para API REST
function registrar_endpoints_api() {
    register_rest_route('meu-tema/v1', '/posts-por-categoria/(?P<cat_id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_posts_by_category',
    ));
}
add_action('rest_api_init', 'registrar_endpoints_api');

function get_posts_by_category($data) {
    $cat_id = $data['cat_id'];
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'post',
        'cat' => $cat_id
    );

    $posts = get_posts($args);

    $response = array();
    foreach ($posts as $post) {
        $response[] = array(
            'title' => get_the_title($post->ID),
            'content' => apply_filters('the_content', $post->post_content)
        );
    }

    return rest_ensure_response($response);
}
