<?php
/**
 * Single Product Image
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.0.14
* @modified    purethemes
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $product, $woocommerce;
$layout         = get_post_meta($post->ID, 'pp_sidebar_layout', TRUE);
if(empty($layout)) { $layout = 'full-width'; }
$sliderstyle    = get_post_meta($post->ID, 'pp_woo_thumbnail_style', TRUE);
?>
<?php echo $layout != 'full-width' ? '<div class="six columns alpha">' : '<div class="eight columns">'; ?>
    <div class="slider-padding ">

        <?php
        if ( has_post_thumbnail() ) {

            $image_title        = esc_attr( get_the_title( get_post_thumbnail_id() ) );
            $image_link         = wp_get_attachment_url( get_post_thumbnail_id() );

            $image              = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_single' );
            $imageRSthumb       = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop-small-thumb' );
            $attachment_ids     = $product->get_gallery_attachment_ids();
            $attachment_count   = count( $product->get_gallery_attachment_ids() );
            $output = '';
            if ( $attachment_count > 0 ) { // many images, use flexslider

            $output .='<div id="'.($sliderstyle == 'horizontal' ? 'product-slider' : 'product-slider-vertical').'" class="royalSlider rsDefault">';
                 //first, get the main thumbnail
                $output .='<a href="'.$image_link.'" itemprop="image" class="mfp-gallery" title="'.$image_title.'">
                               <img src="'.$image[0].'" class="rsImg" data-rsTmb="'.$imageRSthumb[0].'" />
                           </a>';
                //2nd, get the hover image if exists
                $hover = get_post_meta($post->ID, 'pp_featured_hover', TRUE);
                if($hover) {
                    $hoverimage = wp_get_attachment_image_src($hover, 'shop_single');
                    $hoverimagefull = wp_get_attachment_image_src($hover, 'full');
                    $hoverimageRSthumb = wp_get_attachment_image_src($hover, 'shop-small-thumb');
                    $output .= '<a href="'.$hoverimagefull[0].'" class="mfp-gallery"><img class="rsImg" src="'.$hoverimage[0].'"  data-rsTmb="'.$hoverimageRSthumb[0].'" /></a>';
                }
                //get rest of images
                foreach ( $attachment_ids as $attachment_id ) {
                    $image          = wp_get_attachment_image_src( $attachment_id, 'shop_single');
                    $imageRSthumb   = wp_get_attachment_image_src( $attachment_id, 'shop-small-thumb' );
                    $image_title    = esc_attr( get_the_title( $attachment_id ) );
                    $output .= '<a href="'.$image[0].'" class="mfp-gallery" title="'.$image_title.'"><img class="rsImg" src="'.$image[0].'" data-rsTmb="'.$imageRSthumb[0].'" /></a>';
                }
            $output .='</div> <!-- eof royal -->';

            } else { // just one image

            $hover = get_post_meta($post->ID, 'pp_featured_hover', TRUE);
                if($hover) {
                    $output .='<div id="'.($sliderstyle == 'horizontal' ? 'product-slider' : 'product-slider-vertical').'" class="royalSlider rsDefault images">';
                    $output .='<a href="'.$image_link.'" itemprop="image" class="mfp-gallery" title="'.$image_title.'"><img src="'.$image[0].'" class="rsImg" data-rsTmb="'.$imageRSthumb[0].'" /></a>';
                } else {
                    $output .='<div class="single-product-image">';
                    $output .='<a href="'.$image_link.'" itemprop="image" class="mfp-image" title="'.$image_title.'"><img src="'.$image[0].'" class="rsImg"  /></a>';
                }
                if($hover) {
                    $hoverimage = wp_get_attachment_image_src($hover, 'shop_single');
                    $hoverimagefull = wp_get_attachment_image_src($hover, 'full');
                    $hoverimageRSthumb = wp_get_attachment_image_src($hover, 'shop-small-thumb');
                    $output .= '<a href="'.$hoverimagefull[0].'" class="mfp-gallery"><img class="rsImg" src="'.$hoverimage[0].'"  data-rsTmb="'.$hoverimageRSthumb[0].'" /></a>';
                }
            $output .='</div>';
            }
        } else {
              $output .= apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="single-product-image"><img src="%s" alt="Placeholder" /></div>', woocommerce_placeholder_img_src() ), $post->ID );
        }
        echo  $output;
        //do_action('woocommerce_product_thumbnails');
        ?>


        <div class="clearfix"></div>
    </div>
</div>