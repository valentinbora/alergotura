<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'gm');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'pa84~BZ8&|?D%7fmD}v2}5_>~T~0j+Ryv*o|NR*@6z^t4Tfv-dWTj-RJ~e&-5r-^');
define('SECURE_AUTH_KEY',  '<a>qGbl+LyNpxj1C5GO,aP_~~Z8YEe?{*>  #gRUsG*Aq?-J|d5&f?zN%b,$t>4/');
define('LOGGED_IN_KEY',    'C#rZ0vy/{@}QVg`SkizwT}Z4ZeYt ,F}aXg@GV`w)#FfK!9MD.K!P6h[{/{jxzH_');
define('NONCE_KEY',        '-gN);](9ENb?;U5p=Ip9DDD%M i73g~0|rU-%#WfR*eV<%dF+_j/yK;$;1{]ziRK');
define('AUTH_SALT',        ' %DZ`YKa6wwri</VON]g),)-Gk[%g;;4iS:7K|@-Fs(8uk/r9fLu6G|*dX{a$M%P');
define('SECURE_AUTH_SALT', '?W+Ik=siUl},xT4(~5&+Z(SP 2Qpj0[p5WZ@(RvWAGpE+zK,:Z>_lKap-/#D*R-o');
define('LOGGED_IN_SALT',   '3TJiv)-:z#{tipBg3r y$Pa6KwU$T<O@VV+G2+aBVpj-L(m|U,Ulj+PI?G$<YUVl');
define('NONCE_SALT',       '<3R *a|):IEwRf!Wi-y(HOJdJNhNakQSQjr/3;lW*r1SxP+G?+?||C@g)GWMgKP&');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

