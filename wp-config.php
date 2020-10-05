<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'smbc' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '/c[?l5Vy>%s*c|]<d7BO2`b]-e#@GMO&}|9utm(c~,-vunW:UW4c^ao(C?)C0qtX' );
define( 'SECURE_AUTH_KEY',  ',}2}@${Q`s(GP1IH5R1v`/x~[S!(:|kg]4ifOg5,XV9:C$[bLh[,LTk2b/DyPM2a' );
define( 'LOGGED_IN_KEY',    'x~yNe&z~;B7n@R}7>2}FAjF8-(?s*xR4^3m+[f=kShC8*7:$)caD(=gLbZeoj6kc' );
define( 'NONCE_KEY',        '4$jUHh}*7 AZ ?+>j=k0vGt/I*bT=0F(JiED2BV_ne(2pd6P%m,k$,7RB%WEZu&E' );
define( 'AUTH_SALT',        'V=%0HQhfD8pj^JOy!6%g$Fj]vRa[6|0<Pcm),:wQ5q0Gnyj2`4=7{KTj7n#Cx[l[' );
define( 'SECURE_AUTH_SALT', 'Lt*@@dkD1c0Ipt^Y>8?ES_K`R5N2HdB)9`A-Le*z#tp#+iq!~#%NKp;yGz6ppLb)' );
define( 'LOGGED_IN_SALT',   'y3r$$&h/YD/Cy@@N_P!:O@Az@*WY9uIfDE&3J0T_InEq9d.VD 7ZaRE|y|}9eh/r' );
define( 'NONCE_SALT',       '.KOQOuwY~fNo-+!I{JdS.9^*(ICp@)x?kNSoLxh^cDALu[2Ro>X+|@6oXkYkz38;' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
