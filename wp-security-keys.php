<?php
/**
 * WordPress Security Keys Configuration
 * Generated: October 29, 2025
 * 
 * Include this file in wp-config.php or use environment variables
 * Regenerate these keys periodically for better security
 */

// WordPress Security Keys - Generated from https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         'oekRhF>zD|}fhMb]aCPCeG~TDL&=^|{v| avi$QX`ze9O~wYF|+MXd3* jI}RV%Q');
define('SECURE_AUTH_KEY',  'VeXp:MMM~Jjz1%F[IT[Gf}ri8sFUKJ+lw#(?+ws~+;}wQsCR4jL]Bk-<Mmj+-_jv');
define('LOGGED_IN_KEY',    '-@%4qpLU{U%>x329]]V(*7+E:6WF551;hi_?HvV DuO4`o{[e]GnOEdHY^sE3=7c');
define('NONCE_KEY',        '%;uj+kUsqJT8Smi|p:J8sx}Ugv5+At_OqNOV}rAQnm}r~pQ25@E/8i8[a}^|+R:R');
define('AUTH_SALT',        'e480#=|.y3IS+Hgg|87TvZ*I5-_Ih|9AOe){VK3?<%?zIv%E>qmns){-$7:Ow-cN');
define('SECURE_AUTH_SALT', 'xXx]+| 77#z@%wVgfQ{U6(3bq|snR|t1sgX.;4qh6P0Aq0r^>:9pt-I7m%m-wie3');
define('LOGGED_IN_SALT',   'b`|=[X~82}*z>P97[T~sn-&x(t`owJ<Tz]^#6smy_x;/l3-D4UI$E$M0n-k6#czV');
define('NONCE_SALT',       '1*zo>1K8q4:MPr7Le-:3db#]ZI:(D[T<0]bdB+MqUnM[.0:&oBpV6U3I7]`$};;#');

/**
 * Security Hardening Settings
 */
// Disable file editing from WordPress admin
define('DISALLOW_FILE_EDIT', true);

// Disable file modifications
define('DISALLOW_FILE_MODS', false); // Set to true for production

// Force SSL for admin (uncomment for production with SSL)
// define('FORCE_SSL_ADMIN', true);

// Limit login attempts (requires plugin)
define('LIMIT_LOGIN_ATTEMPTS', true);

// Hide WordPress version
define('WP_HIDE_VERSION', true);

// Automatic updates configuration
define('WP_AUTO_UPDATE_CORE', 'minor'); // Enable minor updates only

// Security headers (if not handled by server)
define('WP_SECURITY_HEADERS', true);