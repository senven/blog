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
define('DB_NAME', 'sonicbids_blog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'photon123');

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
define('AUTH_KEY',         '>.GG)C,vGX4l9QEs.*1bx=fL,X>j;R*_otxl.pWwy*-]b%#=bg8!D7.<@a2PL<ny');
define('SECURE_AUTH_KEY',  'cs@cWb+>]w|]2rjD2JBBcSdnB8(gh_-J9Z|*^w[:*UF`[RqU7e]~Y:d<7e$/aQfw');
define('LOGGED_IN_KEY',    'Mu=,T{D>TYh(.SR73:w0g+hE!gX)?_ygb7^iAiK|oZxoy@-Q%{??g>Jw,#>^@J(h');
define('NONCE_KEY',        'Tx]c%1LsUiec#^D{]IRd~i#:vbc5E3+yt&+HK)B,&db.Jw!p?=8T7`MQ^=JWZ$TR');
define('AUTH_SALT',        ']Bi>mH<xySpTm6u1fr/U$r`Z70xqX_|z0Kenz?n8t{27wWWP6)WX}mo{Vi(=p,Eo');
define('SECURE_AUTH_SALT', '_1{SLyJE#TWRR*]K<-PIe04wP./X&=JvPI6)40j,.)jRl45U}S]|jn []5/fA&5%');
define('LOGGED_IN_SALT',   '2w|7_hM_Z!JzT1oCy]B.:99;g3LVI ;!.[B4~q/v+iy}+PgOV5/iOj`wwQC/t(=k');
define('NONCE_SALT',       'c M@eB*8V7RbT2fv,,;OhiQ6/gwdMkTtZiD{=1*/%hum1]GydCUsVbOk]o7]pOm$');

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
