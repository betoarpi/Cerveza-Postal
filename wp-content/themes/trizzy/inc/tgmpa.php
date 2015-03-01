<?php

require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'astrum_register_required_plugins' );

function astrum_register_required_plugins() {

/**
 * Array of plugin arrays. Required keys are name and slug.
 * If the source is NOT from the .org repo, then source is also required.
 */
$plugins = array(

     array(
        'name'                  => 'Revolution Slider',
        'slug'                  => 'revslider',
        'source'                => get_template_directory_uri() . '/plugins/revslider.zip',
        'version'               => '4.6.5',
        'required'              => true,
    ),
    array(
        'name'                  => 'WPBakery Visual Composer', // The plugin name
        'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
        'source'                => get_stylesheet_directory() . '/plugins/js_composer.zip', // The plugin source
        'required'              => true, // If false, the plugin is only 'recommended' instead of required
        'version'               => '4.4.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
    ),
    array(
        'name'                  => 'Purethemes.net Shortcodes',
        'slug'                  => 'purethemes-shortcodes',
        'source'                => get_template_directory_uri() . '/plugins/purethemes-shortcodes.zip',
        'version'               => '1.4',
        'required'              => true,
    ),
    array(
        'name'                  => 'Web Fonts Social Icons WP',
        'slug'                  => 'web-font-social-icons',
        'source'                => get_template_directory_uri() . '/plugins/web-font-social-icons.zip',
        'version'               => '1.2',
        'required'              => false,
    ),
    array(
        'name'                  => 'Contact Form 7', // The plugin name
        'slug'                  => 'contact-form-7', // The plugin slug (typically the folder name)
        'version'               => '4.0',
        'required'              => false, // If false, the plugin is only 'recommended' instead of required
    ),
     array(
        'name'                  => 'MailChimp Widget', // The plugin name
        'slug'                  => 'mailchimp-widget', // The plugin slug (typically the folder name)
        'version'               => '0.8.12',
        'required'              => false, // If false, the plugin is only 'recommended' instead of required
    ),
    array(
        'name'                  => 'WP-PageNavi', // The plugin name
        'slug'                  => 'wp-pagenavi', // The plugin slug (typically the folder name)
        'version'               => '2.86',
        'required'              => false, // If false, the plugin is only 'recommended' instead of required
    ),
    array(
        'name'                  => 'WooCommerce', // The plugin name
        'slug'                  => 'woocommerce', // The plugin slug (typically the folder name)
        'version'               => '2.3.1',
        'required'              => false, // If false, the plugin is only 'recommended' instead of required
    ),
    array(
        'name'                  => 'YITH WooCommerce Wishlist', // The plugin name
        'slug'                  => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
        'version'               => '1.1.6',
        'required'              => false, // If false, the plugin is only 'recommended' instead of required
    ),

);

    // Change this to your theme text domain, used for internationalising strings
$theme_text_domain = 'tgmpa';

$config = array(
        'domain'            => $theme_text_domain,           // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                           // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
        'parent_url_slug'   => 'themes.php',         // Default parent URL slug
        'menu'              => 'install-required-plugins',   // Menu slug
        'has_notices'       => true,                         // Show admin notices or not
        'is_automatic'      => false,            // Automatically activate plugins after installation or not
        'message'           => '',               // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                                => __( 'Install Required Plugins', $theme_text_domain ),
            'menu_title'                                => __( 'Install Plugins', $theme_text_domain ),
            'installing'                                => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
            'oops'                                      => __( 'Something went wrong with the plugin API.', $theme_text_domain ),
            'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                    => __( 'Return to Required Plugins Installer', $theme_text_domain ),
            'plugin_activated'                          => __( 'Plugin activated successfully.', $theme_text_domain ),
            'complete'                                  => __( 'All plugins installed and activated successfully. %s', $theme_text_domain ) // %1$s = dashboard link
            )
);

tgmpa( $plugins, $config );

}




?>