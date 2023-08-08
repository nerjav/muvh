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

define('FORCE_SSL_ADMIN',true);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'muvh_dswgtics' );
/** MySQL database username */
define( 'DB_USER', '' );
/** MySQL database password */
define( 'DB_PASSWORD', '' );
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

define( 'AUTH_KEY',         ']yIndF2}<SprHm:Ggl8p4vrR1A[%}fdlz9VN4o:]=l3I~%j|zXy9[1|uh;-v1-2$' );
define( 'SECURE_AUTH_KEY',  'og}Ylf5,nY&eG8&{[O~TZ;Px1 zy]6ggW*p>@>6/YMTs~WvbsFu XdY4RBkScN_;' );
define( 'LOGGED_IN_KEY',    'sPivW|]HO7:*=]QU3Cy;QXzU]$JL1[UtzL8:=rUX;Z=v2 2Bcuf[Hgz)yzGd>ay,' );
define( 'NONCE_KEY',        'kS71IeD%AP%^Fe}gyUTVp!*ze;,7W2`B(&y6$<I{xF.1}$D=)=LuK4^ID+Ox s7P' );
define( 'AUTH_SALT',        'T^)n[v9NsTTIX9?FSd^7lS?Y$xKFXd~OUo,xu^25[$1tU{+s!~3|`z(<R<|vRYY.' );
define( 'SECURE_AUTH_SALT', 'p!AJgK0qFPn*!-=q]FufgTtZ0/AILO$*_fZ}=D`oOEXUm VAUY49O9D(=I;O [c@' );
define( 'LOGGED_IN_SALT',   'mvE~.(0,~sz`_]GN/Gxgwb6qk,vW3pom?UtgV(_T+cGLD_a^x?$xXFVB8o?(+au^' );
define( 'NONCE_SALT',       '`2IY6,JA1Tm6eei+3F7yW_KfN}75R4VAhaktvD6^6He3,CS#l?#p]^. s=}#7$97' );

/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'dswgt1cs_';
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

/* That's all, stop editing! Happy publishing. */

define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'tudominio paul');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);



/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';