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
define('DB_NAME', 'sta');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'hx?otB`F{1;gv);P5:E:UhcjDG51LtLsb`7$l=!0JQ`?iRT3C1.]sVptCggR>um[');
define('SECURE_AUTH_KEY',  '7D;/.Q!7kyhs_Y9[^+FR-(&tmn>o~?vL_U^Rhs!qrl=1{9]3q(H(qq!x<A$n4%i:');
define('LOGGED_IN_KEY',    'kWh.YD|`zRnkbc}K76dEOc?w(~W?k?Wj=0e.A+1jne;u=|OOrjx 9cp*y>#sQx=[');
define('NONCE_KEY',        'Ri_wq[zGO@m^6=D-Q#R/br1yOG>RYBp+R*^2xU;#InmB45m=H?~q`b)Ck1^r2Bh!');
define('AUTH_SALT',        '( jSEtdnzV2fc^YnpJoY8{Q[K}<!<rZhB+Nq`_O[QNx1JQc^xcN|Ln9De b[YD8;');
define('SECURE_AUTH_SALT', 'pz>1YiUJz7+^*()`?gzu&qzWW|?s}[p d.oou50E`-^KrRr^Vnu%GcTHkEWXD+(z');
define('LOGGED_IN_SALT',   '~iODyZMq1WBGlo[+E[Nc2 C9mX$08]0UCj$3qGd@?,sL[cUru(HWqQc^OKw&y{9D');
define('NONCE_SALT',       '8;9^_PG(j%:Nc4p0W;?_wS~Zmq@5]>0NShQ+Zz!71?_cTRrsi79z:2?Y1=}HNg0p');

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
