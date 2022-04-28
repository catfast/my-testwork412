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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'clickskz_wp_wbtqx' );

/** MySQL database username */
define( 'DB_USER', 'click_wp_uh2fk' );

/** MySQL database password */
define( 'DB_PASSWORD', '#0P@%z8$^8^7G&h?' );

/** MySQL hostname */
define( 'DB_HOST', 'srv-pleskdb45.ps.kz:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'Y0E1Or14it3xxk;3e24L956K~%/-:SbI7U0U5OOc#Z%(bo9|0n2W7iry]19N(:ft');
define('SECURE_AUTH_KEY', '*t3Bn]]|2Q#vf+O:%7dRT/57y)K5*FU/scZ25[5~AG@[n*t(q6u8)I!_!|hrF&a3');
define('LOGGED_IN_KEY', 'RVO4U5uY3@gAdf421AVB5xzq9&RzD%~86;]1uLz)9o!h4+X-/ECw)3P8/-@9bwe&');
define('NONCE_KEY', 'xj_kz|%64UFEYQ7E5Hr%*8[27sp#4t0zcP@0fAUes!uzC-08[13[ntnA3fk*&U1G');
define('AUTH_SALT', 'yM2vBu348T~|1#%_8Z6/![3k71hgxZDJ308271&601w_g:ML-2cqXr_fv_&Kay*q');
define('SECURE_AUTH_SALT', 'X1@429hBB54FG3/_360#iI;x%gON~ty]Up||3R8_;8I1z[9670FSv0_Q;-G45:-8');
define('LOGGED_IN_SALT', '*Q1~09al[-*|Fa43jW]6|72WFEGspgM_h-ax47ibThI;VFdH;(|@M3AgEeM#%E8H');
define('NONCE_SALT', '0vg2uHa00g11TR*iOw)ou#65%(nsKk(wh~:DE%tTj;ju92R(/v0ICf*Fk6*%&4eQ');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '1qGj22UWB_';


define('WP_ALLOW_MULTISITE', true);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
