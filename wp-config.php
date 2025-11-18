<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u362428227_XCgMd' );

/** Database username */
define( 'DB_USER', 'u362428227_Axo3H' );

/** Database password */
define( 'DB_PASSWORD', 'BybrM1eqTx' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'R$,8}w%lJeD_Nba%<nq%P,ND`Pc.]eDQ0q@*$ACoe{gDW$8J}Ijuv@X<~iq_<APn' );
define( 'SECURE_AUTH_KEY',   'm-=.41j-Q}e@c-(;Gd.u_p-P^(vB=Q#66&k(B{8g2R.WN4p.^3rCS_$rTHWAifQ5' );
define( 'LOGGED_IN_KEY',     'h2$2L]SSGg$s-lu<QT|2r9651U#R_@N(<>!]Xs}#m4B31Dq[I(L{-<K7:*#Y{QX~' );
define( 'NONCE_KEY',         'tql_0*Cx:qxr2NyZeEV:CP5@MsQ$MY9vrGt~]NVLmi{A},(m,.fU87dcF+_@?.?r' );
define( 'AUTH_SALT',         'I7,i9-{m7yw^BaqY/S>(y(<<1ssxx>Clo>PHkG43bv((UYv4cEVDYblQI^>nM5mk' );
define( 'SECURE_AUTH_SALT',  '<K%MEx5F&&?K~>GGBe[?,Q5S~940rB(h&>/ %#mhRD4(%3${tl=AOv6IAZBLVRk,' );
define( 'LOGGED_IN_SALT',    '2uYz@=0$T[#oBcP&/c6$]INz|^EQ=;][3RoZ0y/$72]b[({0G9@}@/@422*3j-i=' );
define( 'NONCE_SALT',        'Bgl^(/:og^sdSwN8h*xdb!HN1;1)w0({C*v<U?kO>A(]W?;yJ)hd%:EJ_fnG.Qat' );
define( 'WP_CACHE_KEY_SALT', 'srQ.G+N m5ujy1w_U$8z}_lq?,&5?!XHl.?B1P*N&G,:4r/:?xJCey,bJmHDQI3s' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'f6223c6a14b3cd725947c26a0efa1d2e' );
define( 'WP_AUTO_UPDATE_CORE', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

// Tambahkan sebelum baris "That's all, stop editing!"

define('JWT_AUTH_SECRET_KEY', ')R1Oq.N%9[_0Z!dkpU7eMwlf[E7f#FKh$kUsA.+vWm8sLfjvMTUH9F%D=zPh6}x7');
define('JWT_AUTH_CORS_ENABLE', true);