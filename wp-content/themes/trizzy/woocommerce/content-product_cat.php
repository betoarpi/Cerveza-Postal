<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );



// Increase loop count
$woocommerce_loop['loop']++;
?>
<div class="four columns products-categories <?php     if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 )
        echo ' alpha';
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo ' omega';
 ?>">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>" class="img-caption">
		<figure>
			<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked woocommerce_subcategory_thumbnail - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $category );
			?>
			<figcaption>
				<h3>
					<?php
						echo $category->name;

						if ( $category->count > 0 )
							echo apply_filters( 'woocommerce_subcategory_count_html', ' (' . $category->count . ')', $category );
					?>
				</h3>
				<span><?php _e('Browse Products','trizzy') ?></span>
			<?php
				/**
				 * woocommerce_after_subcategory_title hook
				 */
				do_action( 'woocommerce_after_subcategory_title', $category );
			?>
			</figcaption>
		</figure>
	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</div>