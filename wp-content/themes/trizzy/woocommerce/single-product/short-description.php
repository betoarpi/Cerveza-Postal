<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

if ( ! $post->post_excerpt ) { ?>
<section>
    <div itemprop="description" id="product-description">
        <?php echo do_shortcode( '[shareit facebook="yes" pinit="yes" twitter="yes" gplus="yes"]' ) ?>
    </div>
</section>
<?php } else { ?>
<section>
    <div itemprop="description" id="product-description">
    	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );

        if(function_exists('yith_wishlist_constructor')) { echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); }
        echo do_shortcode( '[shareit facebook="yes" pinit="yes" twitter="yes" gplus="yes"]' );
       ?>
    </div>
</section>
<?php } ?>