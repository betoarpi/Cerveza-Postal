<?php
/**
 * Template Name: Subscription Template
 *
 * This is the template that displays the subscription pricing table.
 *
 * @package Trizzy
 */

get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<!-- Titlebar
================================================== -->
<?php

$titlebar = get_post_meta( $post->ID, 'pp_title_bar_hide', TRUE );
if($titlebar != 'off') {
$parallaximage = get_post_meta( $post->ID, 'pp_parallax_bg', TRUE );
$parallaxcolor = get_post_meta( $post->ID, 'pp_parallax_color', TRUE );
$parallaxopacity = get_post_meta( $post->ID, 'pp_parallax_opacity', TRUE );
if(!empty($parallaximage)) { ?>
<section class="parallax-titlebar fullwidth-element"  data-background="<?php echo $parallaxcolor; ?>" data-opacity="<?php echo esc_attr($parallaxopacity); ?>" data-height="160">
	<img src="<?php echo $parallaximage; ?>" alt="" />
	<div class="parallax-overlay"></div>

	<div class="parallax-content">
		<h2><?php the_title(); ?>
			<?php $subtitle = get_post_meta($post->ID, 'pp_subtitle', TRUE);  if($subtitle) { ?>
				<span><?php echo $subtitle; ?></span>
			<?php } ?>
		</h2>
		<nav id="breadcrumbs">
			<?php if(ot_get_option('pp_breadcrumbs','on') == 'on') echo dimox_breadcrumbs(); ?>
		</nav>
	</div>
</section>
<?php } else { ?>

<!-- Titlebar
================================================== -->
<section class="titlebar">
<div class="container">
    <div class="sixteen columns">
        <h2><?php the_title(); ?></h2>
        <nav id="breadcrumbs">
             <?php if(ot_get_option('pp_breadcrumbs','on') == 'on') echo dimox_breadcrumbs(); ?>
        </nav>
    </div>
</div>
</section>

<?php }
} ?>
<?php
// $layout  = get_post_meta($post->ID, 'pp_sidebar_layout', true);

// switch ($layout) {
//     case 'full-width':
//         get_template_part( 'content', 'page' );
//         break;
//     case 'left-sidebar':
//         get_template_part( 'content', 'pageleft' );
//         break;
//     case 'right-sidebar':
//         get_template_part( 'content', 'pageright' );
//         break;
//     default:
//         get_template_part( 'content', 'page' );
//         break;
// }
?>

<section class="container sixteen columns pricing-table-container">
    <div class="one-third alpha columns">
        <article class="pricing-table">
            <header>
                <div class="subscription-cost">
                    $300
                    <span>mensuales</span>
                </div>
                <h3 class="pricing-table-title">Paquete<br>Principiante</h3>
            </header>
            <ul>
                <li>Selección de 6 cervezas</li>
                <li>Estilos fáciles de explorar</li>
                <li>Souvenir sorpresa</li>
                <li class="empty-item">&nbsp;<br>&nbsp;</li>
                <li class="empty-item">&nbsp;</li>
            </ul>

            <a class="pricing-cta" href="<?php bloginfo('siteurl'); ?>/registro/">Quiero Subscribirme</a>
        </article>
    </div>

    <div class="one-third alpha omega columns">
        <article class="pricing-table">
            <header>
                <div class="subscription-cost">
                    $450
                    <span>mensuales</span>
                </div>
                <h3 class="pricing-table-title">Paquete<br>Aficionado</h3>
            </header>
            <ul>
                <li>Selección de 8 cervezas</li>
                <li>Diferentes estilos</li>
                <li>Diferentes cervecerías</li>
                <li>Souvenir sorpresa</li>
                <li class="empty-item">&nbsp;<br>&nbsp;</li>
            </ul>

            <a class="pricing-cta" href="<?php bloginfo('siteurl'); ?>/registro/">Quiero Subscribirme</a>
        </article>
    </div>

    <div class="one-third omega columns">
        <article class="pricing-table">
            <header>
                <div class="subscription-cost">
                    $750
                    <span>mensuales</span>
                </div>
                <h3 class="pricing-table-title">Paquete<br>Experto</h3>
            </header>
            <ul>
                <li>Selección de 12 cervezas</li>
                <li>Diferentes estilos</li>
                <li>Diferentes cervecerías</li>
                <li>Cervezas de edición especial/de temporada</li>
                <li>Souvenir sorpresa</li>
            </ul>

            <a class="pricing-cta" href="<?php bloginfo('siteurl'); ?>/registro/">Quiero Subscribirme</a>
        </article>
    </div>
</section><!-- ends Price Table Container -->


<?php endwhile; // end of the loop. ?>
</div>
<?php get_footer(); ?>
