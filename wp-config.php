<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'betoarpi_wp-whoocommerce');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'betoarpi_startup');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'i2i$={B)Mok@');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', '192.185.21.169');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', ')n{3S`,Xk~0j)#,(+ERQW.z}[8s@ZB+W6EwPWv%lykEnMf6J@ICbgo>|c=EW0+:b'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', '_aMtfCN|tHMVpK-ZsnCfg<+LqtXj||PcZl2ji`Fm95X2l|1[!|cSHI-b(1/#TYO~'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', 'n1DPbQ.n$CDq?+WA]+fyR_a&yG0FDOlzvKq8t}11x0X(,xZps~iEr?RcXG:<Xzn-'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', '_lcE>Q-9IdX/!|`nLn$P?ii(*<bYeWFOyz~MG+efr+|+o2_59 o/V,}8tC#RV7Tv'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', '|U5,ab|{/]920E|1^!YD5v|t(Cx]{K]Pdm|[/3n69+mi/(+|Wkm89`<`{:sVU!B2'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'Gc P-lM5M@|;[cE$kL~H0qrztV0l_gyhYF7s/i;2tCM^T P9Bdx7<Wh4xQ]iZ8z>'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', ' gEw?7YijA];5gz!lFP }2m}{2><gyjQ+eV/S -RDXVJ{w1UV>Y7-pD?I0ic4Py/'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', 'PUDJHg{*4[XYIM&9~yg8_XoRol,!;i|iA9C>!m&D4*][&8MFGS3JmD6gH&|^88||'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

