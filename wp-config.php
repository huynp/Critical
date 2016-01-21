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
define('DB_NAME', 'critical_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'B1llg@tes88!');

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
define('AUTH_KEY',         'm  1v5orSiK#6qr_I%0~$jK/B6g%;xM+9w(HCpl:@+$nNy~FuIUh3#aAf?X|sP2|');
define('SECURE_AUTH_KEY',  '1#pr?CMuxzHsC*%!}Qj&No@#,RP`>r+S~VAVc&;wL+*5O[q}kA%.uP -NK.{N6B(');
define('LOGGED_IN_KEY',    ' {I64S qygU)G+,e6gAs&I|t-U6>lJ~-_{<W1f}WYLz#fbiB oTO)&(c-s#f1vB:');
define('NONCE_KEY',        'TX/gwe*O7/khKy=<A!+}`fi(I-3hvi@@&^Rcl:Zzy#*EG2|p/5HQ>I~+`xqJO Cq');
define('AUTH_SALT',        'mLT{#9a!)+(/Xd9f%YtFYS9=>p!FO4$iwj)6-%YYh=7|Z1E$Yy:ouf/Ou xDGnHD');
define('SECURE_AUTH_SALT', ',KL7?Z$|]NfK-<[(SuG RaM>kG=7&>;^[_UeH>ZtJXL-t<IxdXSVP=1@IhV+VhYy');
define('LOGGED_IN_SALT',   'nhweyr=&0(rsPgt`O538c~YFU/8%POEAysO]vimcpnbcmEx~9%.MTlU_lIhx5cwT');
define('NONCE_SALT',       '7hoTIbOtx`l3LSh.H#}<_W]4`_G~;Koz/89^hx1r|MU!U?&+%N]uj5`O)-{A^yV.');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'cr_';

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
