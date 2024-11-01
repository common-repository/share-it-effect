<?php
/**
 * Plugin Name: ShareitEffect for WooCommerce
 * Plugin URI: https://www.shareiteffect.com
 * Description: Welcome to the #1 online referral marketing strategy! Harness the power of word-of-mouth marketing! Increase traffic, credibility, online visibility, and revenue! ShareitEffect.com provides a cutting-edge way for your customers to recommend your products to hundreds of their followers. Enjoy this FREE WooCommerce Plugin.
 * Version: 1.1.1
 * Author: Shareiteffect Team
 * Author URI: http://www.shareiteffect.com/contact-us
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!defined('SIE_INSTALLED_VERSION')) { 
    define('SIE_INSTALLED_VERSION', 'FREE');
}

if (!defined('SIE_BASE_NAME')) {
    define('SIE_BASE_NAME', plugin_basename(__FILE__));
}

define( 'SIE_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'SIE_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'SIE_DIR', WP_PLUGIN_DIR . "/shareiteffect/" );

define( 'SIE_UPGRADE_LINK', 'https://app.shareiteffect.com/woocommerce/register' );

define( 'SIE_PAGE_CONTENT', SIE_DIR_PATH . '/partials/' );

/**
 * Check if WooCommerce is activated
 */
if(!in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && !array_key_exists( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_site_option( 'active_sitewide_plugins', array() ) ) ) ) 
{ 
    return;
}

function activate_shareiteffect() {
    if (!class_exists( 'WooCommerce' )) {
        deactivate_plugins( SIE_BASE_NAME );
        wp_die( __( "WooCommerce is required for this plugin to work properly. Please activate WooCommerce.", 'shareiteffect-for-woocommerce' ), "", array( 'back_link' => 1 ) );
    }

    if ( defined('SIE_PRO_BASE_NAME') ) {
        deactivate_plugins( SIE_BASE_NAME );        
        wp_die( __( "ShareitEffect Pro is already installed", 'shareiteffect-for-woocommerce' ), "", array( 'back_link' => 1 ) );
    }
    
    require_once SIE_DIR_PATH . '_inc/classes/sie.class.activator.php';
}

register_activation_hook(__FILE__, 'activate_shareiteffect');


function deactivate_sie_plugin() {
    delete_option( '_sie_discount_amt' );
    delete_option( '_sie_discount_type' );
    delete_option( '_sie_hashtag' );
    delete_option( '_sie_marketing_content' );
}
 
register_deactivation_hook( __FILE__, 'deactivate_sie_plugin' );

require_once SIE_DIR_PATH . '_inc/classes/sie.class.php';



