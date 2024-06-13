<?php
get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <h1>Categorias</h1>

        <ul id="categorias">
            <?php
            $categories = get_categories();
            foreach ($categories as $category) {
                echo '<li><a href="#" data-cat-id="' . $category->term_id . '">' . $category->name . '</a></li>';
            }
            ?>
        </ul>

        <div id="posts-container">
            <?php
            // Verifica se há uma categoria filtrada
            $cat_id = (isset($_GET['cat'])) ? intval($_GET['cat']) : 0;

            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'post',
            );

            if ($cat_id > 0) {
                $args['cat'] = $cat_id;
            }

            $posts_query = new WP_Query($args);

            if ($posts_query->have_posts()) :
                while ($posts_query->have_posts()) :
                    $posts_query->the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="entry-meta">
                                Categorias: <?php the_category(', '); ?>
                            </div>
                        </header><!-- .entry-header -->

                        <div class="entry-content">
                            <?php the_excerpt(); ?>
                            <p><a href="<?php the_permalink(); ?>" class="read-more">Continuar lendo &raquo;</a></p>
                        </div><!-- .entry-content -->
                    </article><!-- #post-<?php the_ID(); ?> -->
                    <?php
                endwhile;
                wp_reset_postdata(); // Restaura os dados originais da consulta
            else :
                echo '<p>Nenhuma postagem encontrada.</p>';
            endif;
            ?>
        </div><!-- #posts-container -->

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
