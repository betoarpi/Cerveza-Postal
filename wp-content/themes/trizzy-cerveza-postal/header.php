<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Trizzy
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
<!-- Mobile Specific Metas
	================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo ot_get_option('pp_favicon_upload', get_template_directory_uri().'/images/favicon.ico')?>" />

	<?php wp_head(); ?>
</head>
<body <?php $style = get_theme_mod( 'trizzy_layout_style', 'boxed' ); body_class($style); ?>>
	<div id="wrapper">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'trizzy' ); ?></a>


	<!-- Top Bar
	================================================== -->
	<div id="top-bar">
		<div class="container">

			<!-- Top Bar Menu -->
			<div class="eight columns">
				<ul class="top-bar-menu">
					<?php
					if(ot_get_option( 'pp_contact_details') == 'on') {
						$email = ot_get_option( 'pp_cdetails_email');
						$phone = ot_get_option( 'pp_cdetails_phone');
						if($phone) { ?><li><i class="fa fa-phone"></i><?php echo $phone;?></li><?php }
						if($email) { ?><li><i class="fa fa-envelope"></i><a href="mailto:<?php echo esc_attr($email) ;?>"><?php echo $email;?></a></li><?php }
					} ?>
					<?php

					if (function_exists('icl_register_string') && ot_get_option('pp_lang_switcher','off') == 'on'): ?>
						<li>
							<div class="top-bar-dropdown">
								<span><?php echo ICL_LANGUAGE_NAME; ?></span>
								<ul class="options">
									<?php
										$languages = icl_get_languages('skip_missing=0&orderby=KEY&order=DIR');
											foreach ($languages as $lang) { ?>
												<li><a href="<?php echo $lang['url']; ?>"><?php echo $lang['native_name'];  ?></a></li>
										<?php } ?>
								 </ul>
							</div>
						</li>
					<?php endif;

					if(function_exists('get_woocommerce_currency') && ot_get_option('pp_currency_switcher','off') == 'on') :  ?>
					<li>
						<div class="top-bar-dropdown currency-change">
							<span><?php global $woocommerce_wpml; echo $woocommerce_wpml->multi_currency_support->get_client_currency(); ?></span>
								<?php do_action('currency_switcher', array(
									'format' => '<a href="#">%code%</a>',
									'switcher_style' => 'list'
								)); ?>

						</div>
					</li>
					<?php endif; ?>
				</ul>
			</div>

			<!-- Social Icons -->
			<div class="eight columns">
				<?php /* get the slider array */
				if ( is_user_logged_in() ) {
					echo '<div class="CP-perfil"> <a class="CP-user" href="#"><p>Hola';
					$current_user = wp_get_current_user(); 
					echo ' ' . $current_user->user_login.'</p>';
					echo get_avatar( $id_or_email, $size, $default, $alt ).'</a>';
					echo '<div class="CP-perfilOptionsWrapper"><div class="CP-perfilOptions">
							<div class="arrow"></div>
							<p class="name">Configuración de tu Cuenta</p>
							<ul>
								<li><a class="perfil" href="#"><i class="fa fa-user"></i> Perfil</a></li>
								<li><a class="edit" href="#"><i class="fa fa-pencil"></i> Editar Perfil</a></li>
								<li><a class="account" href="#"><i class="fa fa-credit-card"></i> Mi Cuenta</a></li>
								<li><a clas="record" href="#"><i class="fa fa-history"></i> Mi Historial de Pedidos</a></li>
								<li><a class="favorites" href="#"><i class="fa fa-beer"></i> Mis Favoritas</a></li>
								<li><a class="order" href="#"><i class="fa fa-shopping-cart"></i> Estado del Pedido</a></li>
								<li><a class="sign-out" href="#"><i class="fa fa-sign-out"></i> Cerrar Sesión</a></li>
							</ul>
						</div></div></div>';

				} else {
					echo '<a href="'.home_url().'/wp-login.php" class="CP-login"><i class="fa fa-sign-in"></i> Iniciar Sesion</a>';
				}
				$headericons = ot_get_option( 'pp_headericons', array() );
				if ( !empty( $headericons ) ) {
					echo '<ul class="social-icons">';
					foreach( $headericons as $icon ) {
						echo '<li><a class="' . $icon['icons_service'] . '" title="' . esc_attr($icon['title']) . '" href="' . esc_url($icon['icons_url']) . '"><i class="icon-' . $icon['icons_service'] . '"></i></a></li>';
					}
					echo '<li>' . get_template_part( 'inc/mini_cart') . '</li></ul>';
				}
				?>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>



<!-- Header
	================================================== -->
<header class="container main-header">
	<?php
	$logo_area_width = ot_get_option('pp_logo_area_width',4);
	$menu_area_width = 16 - $logo_area_width;
	?>
	<!-- Logo -->
	<div id="logo">
	<?php
		$logo = ot_get_option( 'pp_logo_upload' );
		if($logo) {
			if(is_front_page()){ ?>
				<a class="current homepage" id="current" href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo $logo; ?>" alt="<?php esc_attr(bloginfo('name')); ?>"/></a>
			<?php } else { ?>
				<a class="current homepage" id="current" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo $logo; ?>" alt="<?php esc_attr(bloginfo('name')); ?>"/></a>
		<?php }
		} else {
			if(is_front_page()) { ?>
				<h1><a class="current homepage" id="current" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	  <?php } else { ?>
				<h2><a class="current homepage" id="current" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
	  <?php }
		}
	?>
	<?php if(get_theme_mod('trizzy_tagline_switch','hide') == 'show') { ?><div id="blogdesc"><?php bloginfo( 'description' ); ?></div><?php } ?>
	</div>

	<div class="two columns">&nbsp;</div>
	
	<!-- Navigation
	================================================== -->
	<div class="fourteen columns">
		<a href="#menu" class="menu-trigger"><i class="fa fa-bars"></i> Menu</a>

		<nav id="navigation" class="<?php echo get_theme_mod( 'trizzy_menu_style', 'dark' ); ?>">
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => false,
				'menu_id' => 'responsive',
				 'fallback_cb' => 'trizzy_fallback_menu',
				'walker' => new trizzy_megamenu_walker
			));
			?>
		</nav>
	</div>
</header>
