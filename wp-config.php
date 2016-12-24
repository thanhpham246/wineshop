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
define('DB_NAME', 'wine');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '2TCRZ=RzC%N51OW(XCy1%yF0C]?SR-0*O4*A-xO3yJO5sN?ZPwIz_Rg1XD(eFq3}');
define('SECURE_AUTH_KEY',  'gumB6SS:]+qX<Ui`ft+ZHP{HY+TNf_s],Ei+{)/+asB^?:bGH)1^JH+rj@O`yvpA');
define('LOGGED_IN_KEY',    'oJv0Cf6CE0&M&C!:!i>?pl>pG%6@?`/:X.9D9l)q?c@w^Z4kW4S3p2U:rm_DT6/C');
define('NONCE_KEY',        '2C> h_]P3<d5+74qNX^a3`s-V,~WzfW+t2mN1P9>`^sUlXADpy^jdQFM%oJ: w$v');
define('AUTH_SALT',        'bP)6-!wX%cXsxT+d3[V:|ALciT6QTZ|C]+LzW$_3{*Q[NcK_+e4|!dgHdw1(XZ6e');
define('SECURE_AUTH_SALT', 'rffHRN#`kv)?,:RW|9kH_Wd9D$+}y}{y*p9kSS^Qy(}f.:vt}z2a$(U`8:^/*rO<');
define('LOGGED_IN_SALT',   'Y<yh}6~fdLM-|:^%_*4SyBYA!29:t7xC8>[>@B]PP,FN]E]<}aB=#`fsA|yp0B)_');
define('NONCE_SALT',       '#zryaW._@c-5u+f/T fmU27/UcooN3+e{cl$tZd,.`0z6aqMKR)-kM/r%.u]Zj1Q');

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
