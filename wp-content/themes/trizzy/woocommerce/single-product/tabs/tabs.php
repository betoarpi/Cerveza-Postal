<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>
<?php global $post; $layout      = get_post_meta($post->ID, 'pp_sidebar_layout', TRUE); ?>
	<div class="woocommerce-tabs <?php if($layout == 'full-width') { echo 'sixteen'; } else { echo "twelve"; } ?> columns alpha omega">
		<ul class="tabs-nav">
			<?php foreach ( $tabs as $key => $tab ) : ?>

				<li class="<?php echo $key ?>_tab">
					<a href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
				</li>

			<?php endforeach; ?>
		</ul>
		<div class="tabs-container">
		<?php foreach ( $tabs as $key => $tab ) : ?>

			<div class="panel tab-content entry-content" id="tab-<?php echo $key ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>

		<?php endforeach; ?>
		</div>
	</div>

<?php endif; ?>