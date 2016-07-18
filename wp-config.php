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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wpcampus-test');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost:8888');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'o<So7SZsSV^uzx74XXfH`3^@x!mP:4I&Hz|)`/y9Z%0xD=[>2~pjz#BdNHK)Hnfd');
define('SECURE_AUTH_KEY',  'p5Ok_)olbD8F0+1!^&8TjrdHUvyt&30&~B%>tQWG`3Ab~M{GNvWXb|5vkWOZ<+HM');
define('LOGGED_IN_KEY',    '1oR]Od*O9=z$NyVKauO>dw+(o(EJ0H_,Z}k/Xr|Hm7pwdcjgsusrmg59<!k(E9Y+');
define('NONCE_KEY',        '{cxNO3oiRq&N%T8kKDOiEz/DQ7 n(om8DJ-<&*Q>2r9#//bn$~UFo]-K3j:)&j1B');
define('AUTH_SALT',        'do8><WC<X#j1@(N!mxBbp<nu2PZ7r2%-;AD%HOL7x.}of|=n4>4_Lzt0Y6,sr)=~');
define('SECURE_AUTH_SALT', '~M#C.pZQ,Vc(?#GWdZk#jh-~!B@^[;az=n?CgBV/>hm<V@IAN(fDlLu_N58VU*PQ');
define('LOGGED_IN_SALT',   '9-a`4?k&}XAMw-s D!cG)Xz|)MIf*Gr68*K)cuv,uAP;<FF&x,,Fv08H|}N@Vz.)');
define('NONCE_SALT',       'jjJ(noV&l24hbtG6G|(k*H=~(Pi7PZlv/)N^Si+E,lMk>QrPsPuWf}D `tc;<_!-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
