<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<ul class="variation">
	<?php
		foreach ( $item_data as $data ) :
			$key = sanitize_text_field( $data['key'] );
	?>
	<li>
        <strong class="variation-<?php echo sanitize_html_class( $key ); ?>"><?php echo wp_kses_post( $data['key'] ); ?>:</strong>
		<span class="variation-<?php echo sanitize_html_class( $key ); ?>"><?php echo wp_kses_post( $data['value'] ); ?></span>
    </li>
	<?php endforeach; ?>
</ul>
