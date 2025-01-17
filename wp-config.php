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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'cybernews' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '1n=wCv[LpfCinKmr:MuP%oTd}G>h6~=QB`]fX_?@`RG+/~lk8(&*wI<d$67#PuId' );
define( 'SECURE_AUTH_KEY',  'rEfASL8}iurGBJ!ASq+4@A(UqnvaB;:G]z*1#F<gpRD,`Hz$ _HhC,+AX9*F#7J}' );
define( 'LOGGED_IN_KEY',    'hwHq$ Q_=cx4w;5&B!&[k^d5_twD5pKz*7:b)R&j36IfuyMw&qSY1;0T9K4ECS)}' );
define( 'NONCE_KEY',        '.+LvS;fjm(:GqW[o6x)4}$fslT}R14!xflTc(q*CJL5v[>D@_kVGeOlF-@d$[Z]X' );
define( 'AUTH_SALT',        '1>pO=FKbl/2w<P;`MV1Og)7QxY)fX*]`KGV4|P2=;:F;aI(0aa/0yE~WBuW[W5(]' );
define( 'SECURE_AUTH_SALT', 'ivBYE$&A04H{ o/w^qHxFQ]}bBr*Vk%2A(@cDr8?l5Rl0pd;-l#`B;B(30O5.9`}' );
define( 'LOGGED_IN_SALT',   '@)<nSYX7<s:u)@ XDmTuN.;2YYp!BYr)$nT>E!4AfH;[l|SwO;?[]QEk/mx4zNEx' );
define( 'NONCE_SALT',       '=RL/2sT@~lZ;NZ8dGe|0W!we`ZHrRsrvso_fsprr9zWx3<as@a8DV#+gmG2b!BoS' );

/**#@-*/

/**
 * WordPress database table prefix.
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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
