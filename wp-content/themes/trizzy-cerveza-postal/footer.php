<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Trizzy
 */
?>

</div><!-- #content -->
<?php if ( is_user_logged_in() ){}else{ ?>

<!-- Pop Up -->
<div class="PopUp">
    <div class="PopUp-container">
        <figure class="PopUp-logoContainer">
            <img src="<?php echo get_stylesheet_directory_uri();?>/img/logoB.png" alt="Cerveza Postal">
        </figure>
        <div class="PopUp-infoContainer">
            <p class="PopUp-question"><strong class="simbol">?</strong>Eres mayor de edad?</p>
            <div class="PopUp-awnser">
                <a href="#" class="PopUp-yes">Si</a>
                <a href="http://www.alcoholinformate.org.mx/" class="PopUp-no">No</a>
            </div>
            <p class="PopUp-info">Al acceder a este sitio, manifiesta su conformidad con el <a href="#">aviso de privacidad</a> y el <a href="#">uso de cookies</a> de este sitio web.
            </br></br>para mas información, lea nuestro <a href="#">aviso de privacidad.</p>
        </div>
    </div>
</div>
<!-- PopUp-End -->
<?php } ?>
<div id="footer">
    <!-- 960 Container -->
    <div class="container">

        <div class="two columns">
            <div class="footer-logo">
                <img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo-footer.png" alt="">
            </div>
           <?php //if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 1st Column')) : endif; ?>
        </div>

        <div class="five columns">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 2nd Column')) : endif; ?>
        </div>


        <div class="four columns">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 3rd Column')) : endif; ?>
        </div>

        <div class="five columns">
            <h3 class="headline footer">Boletín</h3>
            <span class="line"></span>
            <div class="widget widget-registro">
                <p><strong>Regístrate</strong> ya a nuestro boletín de ofertas y noticias. Recibe un cupón del <strong>10% del descuento</strong> para tu primera compra.</p>
            </div>
            <!-- Begin MailChimp Signup Form -->
            <div id="mc_embed_signup">
                <form action="//cervezapostal.us9.list-manage.com/subscribe/post?u=ab267137f209fc42e74aa20be&amp;id=efe8ad7dc0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate register-form" target="_blank" novalidate>
                    <div id="mc_embed_signup_scroll">
                        <div class="mc-field-group">
                            <label for="mce-FNAME">Tu Nombre  <span class="asterisk">*</span></label>
                            <input type="text" value="" name="FNAME" class="formField required" id="mce-FNAME" required>
                        </div>
                        <div class="mc-field-group">
                            <label for="mce-EMAIL">Tu email  <span class="asterisk">*</span></label>
                            <input type="email" value="" name="EMAIL" class="formField required email" id="mce-EMAIL" required>
                        </div>
                        <div class="mc-field-group">
                            <label for="mce-FAV">Tus Favoritas </label>
                            <input type="text" value="" name="FAV" class="formField" id="mce-FAV" placeholder="ej. Lupe Reyes, Yule, Santa's Red">
                        </div>
                        <input type="submit" value="Quiero Registrarme" name="subscribe" id="mc-embedded-subscribe" class="button submit-register-form">
                        <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>
                        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                        <div style="position: absolute; left: -5000px;">
                            <input type="text" name="b_ab267137f209fc42e74aa20be_efe8ad7dc0" tabindex="-1" value="">
                        </div>
                    </div>
                </form>
            </div><!--End mc_embed_signup-->

            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 4th Column')) : endif; ?>
        </div>
</div>
<!-- Container / End -->

</div>
<!-- Footer / End -->
<!-- Footer Bottom / Start -->
<div id="footer-bottom">

    <!-- Container -->
    <div class="container">

        <div class="eight columns"><?php $copyrights = ot_get_option('pp_copyrights' );
        if (function_exists('icl_register_string')) {
            icl_register_string('Copyrights in footer','copyfooter', $copyrights);
            echo icl_t('Copyrights in footer','copyfooter', $copyrights);
        } else {
          echo $copyrights;
      } ?></div>
      <div class="eight columns">
        <?php /* get the slider array */
                $payment_icons = ot_get_option( 'pp_payment_icons', array() );
                if ( !empty( $payment_icons ) ) {
                    echo ' <ul class="payment-icons">';
                    foreach( $payment_icons as $icon ) {
                        if(!empty($icon['url'])){
                            echo '<li><a href="' . esc_url($icon['url']) . '">';
                                if(!empty($icon['upload'])) {
                                    echo '<img src="'.$icon['upload'].'" alt="" />';
                                } else {
                                    echo '<img src="'.get_template_directory_uri().'/images/'.$icon['icons_service'].'.png" alt="" />';
                                }
                            echo '</a></li>';
                        } else {
                            echo '<li>';
                                if(!empty($icon['upload'])){
                                    echo '<img src="'.$icon['upload'].'" alt="" />';
                                } else {
                                    echo '<img src="'.get_template_directory_uri().'/images/'.$icon['icons_service'].'.png" alt="" />';
                                }
                            echo '</li>';
                        }
                    }
                    echo '</ul>';
                }
                ?>
     </div>

</div>
<!-- Container / End -->
<!-- Back To Top Button -->
<div id="backtotop_trizzy"><a href="#"></a></div>
</div>
<!-- Footer Bottom / Start -->

</div>

<?php if ( is_page_template( 'template-contact.php' ) ) { ?>

<script type="text/javascript">
(function($){
    $(document).ready(function(){
        $('#googlemaps').gMap({
            maptype: '<?php echo ot_get_option('pp_contact_maptype','ROADMAP') ?>',
            scrollwheel: false,
            zoom: <?php echo ot_get_option('pp_contact_zoom',13) ?>,
            markers: [
                <?php $markers = ot_get_option('pp_contact_map');
                if(!empty($markers)) {
                    foreach ($markers as $marker) { ?>
                    {
                        address: '<?php echo $marker['address']; ?>', // Your Adress Here
                        html: '<strong style="font-size: 14px;"><?php echo $marker['title']; ?></strong></br><?php echo $marker['content']; ?>',
                        popup: true,
                    },
                    <?php }
                } ?>
                    ],
                });
    });
})(this.jQuery);
</script>
<?php } //eof is_page_template ?>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/cp-scripts.js"></script>
<?php wp_footer(); ?>
</body>
</html>
