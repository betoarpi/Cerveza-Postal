<?php
/**
 * Template Name: Masonry Blog Template
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage trizzy
 * @since trizzy 1.0
 */


get_header(); ?>

<!-- Titlebar
================================================== -->
<section class="titlebar">
    <div class="container">
        <div class="sixteen columns">
            <h2><?php
                    if ( is_category() ) {
                        printf( __( 'Category Archives: %s', 'trizzy' ), '<span>' . single_cat_title( '', false ) . '</span>' );

                    } elseif ( is_tag() ) {
                        printf( __( 'Tag Archives: %s', 'trizzy' ), '<span>' . single_tag_title( '', false ) . '</span>' );

                    } elseif ( is_author() ) {
                        /* Queue the first post, that way we know
                         * what author we're dealing with (if that is the case).
                        */
                        the_post();
                        printf( __( 'Author Archives: %s', 'trizzy' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
                        /* Since we called the_post() above, we need to
                         * rewind the loop back to the beginning that way
                         * we can run the loop properly, in full.
                         */
                        rewind_posts();

                    } elseif ( is_day() ) {
                        printf( __( 'Daily Archives: %s', 'trizzy' ), '<span>' . get_the_date() . '</span>' );

                    } elseif ( is_month() ) {
                        printf( __( 'Monthly Archives: %s', 'trizzy' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

                    } elseif ( is_year() ) {
                        printf( __( 'Yearly Archives: %s', 'trizzy' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

                    } else {
                        $pp_blog_page = ot_get_option('pp_blog_page');
                        if (function_exists('icl_register_string')) {
                            icl_register_string('Blog page title','pp_blog_page', $pp_blog_page);
                            echo icl_t('Blog page title','pp_blog_page', $pp_blog_page); }
                            else {
                                echo $pp_blog_page;
                            }
                        }
                        ?>
            </h2>

            <nav id="breadcrumbs">
                <?php if(ot_get_option('pp_breadcrumbs','on') == 'on') echo dimox_breadcrumbs(); ?>
            </nav>
        </div>
    </div>
</section>
<!-- Container -->
<div class="container">

    <!-- Masonry Wrapper-->
    <div id="masonry-wrapper">


        <?php if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
                    $args = array('
                        offset'=> 0,
                        'paged'=>$paged,
                       // 'posts_per_page' => get_option('posts_per_page'),
                        'posts_per_page' => 12,
                        'post_type' => 'post'
                        );
                    $all_posts = new WP_Query($args);
                    while($all_posts->have_posts()) : $all_posts->the_post(); ?>

            <?php
                /* Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                $format = get_post_format();
                if( false === $format  )  $format = 'standard';
                get_template_part( 'postformats/masonry', $format );
            ?>

            <?php endwhile;
            endwhile; ?>


        <?php trizzy_paging_nav(); ?>

    <?php else : ?>

        <?php get_template_part( 'content', 'none' ); ?>

    <?php endif; ?>
    </div>
</div>

<div class="container">
    <div class="sixteen columns">
        <!-- Pagination -->
        <div class="pagination-container">
            <nav class="pagination">
                <ul>
                    <li id="next"><?php next_posts_link( '', $all_posts->max_num_pages  ); ?></li>
                    <li id="prev"><?php previous_posts_link( ''); ?></li>
                    <!-- <li><a href="#" class="next"></a></li> -->
                </ul>
            </nav>
        </div>
    </div>
 </div>
<!-- Container / End -->

<?php get_footer(); ?>
