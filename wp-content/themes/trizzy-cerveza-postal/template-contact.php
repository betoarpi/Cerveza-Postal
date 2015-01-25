<?php
/**
 * Template Name: Contact Page
 *
 * A page showing map below title.
 *
 *
 * @package WordPress
 * @subpackage trizzy
 * @since trizzy 1.0
 */


get_header(); ?>

<!-- Titlebar
================================================== -->
<?php
$parallaximage = get_post_meta( $post->ID, 'pp_parallax_bg', TRUE );
$parallaxcolor = get_post_meta( $post->ID, 'pp_parallax_color', TRUE );
$parallaxopacity = get_post_meta( $post->ID, 'pp_parallax_opacity', TRUE );
if(!empty($parallaximage)) { ?>
<section class="parallax-titlebar fullwidth-element"  data-background="<?php echo $parallaxcolor; ?>" data-opacity="<?php echo $parallaxopacity; ?>" data-height="160">
    <img src="<?php echo $parallaximage ?>" alt="" />
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
<section class="titlebar margin-bottom-0">
<div class="container">
    <div class="sixteen columns">
        <h2><?php the_title(); ?></h2>
        <nav id="breadcrumbs">
           <?php if(ot_get_option('pp_breadcrumbs','on') == 'on') echo dimox_breadcrumbs(); ?>
        </nav>
    </div>
</div>
</section>

<?php } ?>

<?php while (have_posts()) : the_post(); ?>
    <!-- Container -->
<div class="container fullwidth-element">

    <!-- Google Maps -->
    <!-- <section class="google-map-container">
        <div id="googlemaps" class="google-map google-map-full"></div>
    </section> -->
    <!-- Google Maps / End -->

</div>
<!-- Container / End -->
    <!-- Post -->
    <div  id="post-<?php the_ID(); ?>" <?php post_class('container'); ?> >
        <h3 class="Tcenter">Gracias por utilizar nuestra plataforma</h3>
        <h5 class="Tcenter">para descubrir el mundo de la cerveza artesanal mexicana</h5>
        <br>
        <p>Si tienes alguna sugerencia para la mejora de nuestro servicio, no dudes en contactarnos. Puedes hacerlo a través de nuestras redes sociales o por el siguiente formulario de contacto.</p>
        <hr>
        <div class="four columns">
            <aside class="contact-sidebar">
                <h6>Para atención personalizada llámanos al siguiente número telefónico o envíanos un correo electrónico.</h6>
                <br>
                <ul class="contact-informations second">
                    <li><i class="fa fa-phone"></i>+48 880 440 110</li>
                    <li><i class="fa fa-envelope"></i>contacto@cervezapostal.com</li>
                    <li><i class="fa fa-globe"></i>www.cervezapostal.mx</li>
                </ul>
                <br>
                <div class="clearfix"></div>

                <h3 class="headline">Síguenos</h3>
                <span class="line" style="margin-bottom:25px;"></span>
                <div class="clearfix"></div>
                <ul class="ptwsi_social-icons ptwsi">
                    <li><a class="twitter  ptwsi-social-icon" href="https://twitter.com/cervezapostal"><i class="ptwsi-icon-twitter"></i></a></li>
                    <li><a class="facebook  ptwsi-social-icon" href="https://www.facebook.com/cervezapostal"><i class="ptwsi-icon-facebook"></i></a></li>
                </ul>
            </aside>
        </div>
        <div class="twelve columns">
          <?php the_content() ?>
        </div>
    </div>
<?php endwhile; // End the loop. Whew.

get_footer();

?>