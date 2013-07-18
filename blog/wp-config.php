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
define('WP_CACHE', true); //Added by WP-Cache Manager
define('DB_NAME', 'malama_wdps1');

/** MySQL database username */
define('DB_USER', 'malama_wdps1');

/** MySQL database password */
define('DB_PASSWORD', 'g1zTrhdPFVYg74pz');

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
define('AUTH_KEY',         '|Rx1_`Jo9f+k1EKco Y#Xg~b<Kbs}vjr3Mz48*7eoBmgAxd/9%^D$KLvz}m|;_Q_');
define('SECURE_AUTH_KEY',  'i&Q~a;U~ FVYZ-on5~t%/!Cs-!_G*>|[BIA)?xp, ,p=~i}sWeU:odb]txv2cKft');
define('LOGGED_IN_KEY',    '&2ct#ld8V-)i=eNOqRd`+{xZCRdTMy`|rD6%6T+ $-**KFrl3~N%v>{{mVm?ohC|');
define('NONCE_KEY',        '*`43A#*<s}sbN]OFad>sg^MYJ0wLW+Xc)YCbfQ:0@eG:*Y~DDLXD^pIO& 1 C.hQ');
define('AUTH_SALT',        ' 6vAmX5sVB6t?m|3~D%.$w0Cy5BAD[a-l?xKu7PC4Mszomz<tb|C$aCQMm |-.(r');
define('SECURE_AUTH_SALT', 'R|+s`H1X.eGohqh;AS7`?)E0/G7)T>Yg4qn5u@6-{4NU3y)H1<nWu|r4BrxZoh9$');
define('LOGGED_IN_SALT',   '&x-FB<5Ki~4|m<oH5[t) 5&cc!kI;uqM&#q_bPz!O]?WcncCOK(smF(u>*Tg^/g~');
define('NONCE_SALT',       ':V[G5D:gM}<kEU+|pFmI63+thtR7eqCp_>+wqg$>fg,]G?&}$&R .`hp8xXdXkD?');

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