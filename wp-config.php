<?php
define( 'WP_CACHE', true );

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings
//Begin Really Simple SSL key
define('RSSSL_KEY', 'JBftlORkn6n5Jz6YihnOWzWzgJXoUjGH9FbdFxrt4th3BiaZwLpcs9FT1XcST2nr');
//END Really Simple SSL key

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */


// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'airinosg4stro_wp992' );

/** Database username */
define( 'DB_USER', 'airinosg4stro_wp992' );

/** Database password */
define( 'DB_PASSWORD', '9-p653MSM.' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         'rcramcamab9wxe2tx1wr4ng2jlv9amsp9cfryzcjiw8rb4wt5hfusaae9st4v7ht' );
define( 'SECURE_AUTH_KEY',  'cwdonltlyd6x4tmxowaj4fbkezv1jwunuzzzddjp9lhlsuhze4b5kptyuowlmacj' );
define( 'LOGGED_IN_KEY',    'yqpk5qt7histb4j407kzav900fwxkp9e17xpfw1jlu6snvqguaxvi3uwvs6q12kh' );
define( 'NONCE_KEY',        '1zbntlap9q6frsjhb4rer4cgrk0yk8gmghjh7xesy6cqcfxnrurwylmeofj6p8je' );
define( 'AUTH_SALT',        'ahus0dvpealiq2uv99hao5unn8fsuk9e2qolgwigmfvp4azv7kbsgr9ciaezh6if' );
define( 'SECURE_AUTH_SALT', 'qmqniwyqwdaza2u0lop4lerqfewktphirpftozm7ajd43wmqsqssvde62qqihuwy' );
define( 'LOGGED_IN_SALT',   'be9rdax3qfctptnpvifi7cmusrgajlnliigd50g6lbteosytb7bt02gkand8reck' );
define( 'NONCE_SALT',       'm3wxb1odrvdpn45qh5yuqyma9pfdthhjqzje3ivi8b1pwiojko4qyamo9nhkyy1s' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wppr_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
